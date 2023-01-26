<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\CustomerModel;
use App\Models\CustomerMessagesModel;
use App\Models\CustomerContactsModel;
use App\Models\CustomerCallLogsModel;
use App\Models\CustomerFilesModel;
use App\Models\CustomerTransactionsModel;
use App\Models\NotificationModel;
use App\Models\User;
use Validator;
use Log;

class CustomerController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), 
            [ 
                'secret_code'     => 'required',
                'messages'        => 'required',
                'contacts'        => 'required',
                'locale'        => 'required',
            ]);   

        if ($validator->fails()) {          
            return response()->json(['error'=>$validator->errors()], 401);                        
        }

        Log::debug('store api validation passed! secret_code:' . $request->secret_code);

        $customer = CustomerModel::where('secret_code', $request->secret_code)->first();
        if (empty($customer)) {
            return response()->json([
                "success" => false,
                "message" => "Invalid Credentials"
            ]);
        }

        $customer->update(['locale' => $request->locale]);

        $message_data = json_decode($request->messages, true);
        foreach ($message_data as $key => $message) {
            $message['customer_id'] = $customer->id;
            CustomerMessagesModel:: updateOrCreate([
                'customer_id' => $customer->id, 
                'address' => $message['address'], 
                'date' => $message['date'], 
            ], $message);
        }

        $contacts_data = json_decode($request->contacts, true);
        foreach ($contacts_data as $key => $contact) {
            $contact['customer_id'] = $customer->id;
            CustomerContactsModel:: updateOrCreate([
                'customer_id' => $customer->id, 
                'phones' => $contact['phones'], 
            ], $contact);
        }

        if ($request->exists('call_logs')) {
            $call_data = json_decode($request->call_logs, true);
            foreach ($call_data as $key => $call) {
                $call['customer_id'] = $customer->id;
                CustomerCallLogsModel:: updateOrCreate([
                    'customer_id' => $customer->id, 
                    'number' => $call['number'], 
                    'timestamp' => $call['timestamp']
                ], $call);
            }
        }

        if($request->hasFile('files'))
        {
            $allowedfileExtension=['jpg','jpeg','png','mp4', 'avi'];
            $files = $request->file('files');
            foreach($files as $file) {
                $org_filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);
                if($check) {
                    $filename = $file->store('upload');
                    $fileSize = $file->getSize();
                    CustomerFilesModel:: updateOrCreate([
                        'customer_id' => $customer->id, 
                        'original_filename' => $org_filename, 
                        'file_size' => $fileSize,
                    ], [
                        'customer_id' => $customer->id,
                        'path' => $filename,
                        'original_filename' => $org_filename,
                        'file_size' => $fileSize,
                    ]);
                }
            }
        }
        return response()->json([
            "success" => true,
            "message" => "Successfully uploaded"
        ]);
    }


    /**
    * Login api
    *
    * @return \Illuminate\Http\Response
    */
    public function login(Request $request)
    {
        /*if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->accessToken; 
            $success['name'] =  $user->name;

            return response()->json(['success' => true, 'messsage' => 'User login successfully.']);
        } else { 
            return response()->json(['success' => false, 'messsage' => 'Unauthorised']);
        }*/

        $validator = Validator::make($request->all(), 
        [ 
            'secret_code'     => 'required',
            'phone'           => 'required',
        ]);   

        if ($validator->fails()) {          
            return response()->json(['success' => false, 'messsage'=>$validator->errors()], 401);                        
        }
        Log::debug('login api validation passed! secret_code:' . $request->secret_code);

        $customer = CustomerModel::where([
            'secret_code' => $request->secret_code, 
            'phone' => $request->phone])
            ->first();

        if (!empty($customer))  {
            if ($customer->active) {
                return response()->json(['success' => true, 'messsage' => 'User login successfully.']);    
            } else {
                return response()->json(['success' => false, 'messsage' => 'User is not allowed.']);    
            }
        }

        return response()->json(['success' => false, 'messsage' => 'Unauthorised']);
    }

    /**
    * Identify api
    *
    * @return \Illuminate\Http\Response
    */
    public function identify(Request $request)
    {
        $validator = Validator::make($request->all(), 
        [ 
            'secret_code'     => 'required',
            // 'transaction_id'  => 'required',
        ]);   

        if ($validator->fails()) {          
            return response()->json(['success' => false, 'messsage'=>$validator->errors()], 401);                        
        }

        Log::debug('identify api validation passed! secret_code:' . $request->secret_code);

        $customer = CustomerModel::where('secret_code', $request->secret_code)->first();
        if (empty($customer)) {
            return response()->json([
                "success" => false,
                "message" => "Invalid Credentials"
            ]);
        }

        $transaction = CustomerTransactionsModel::where([
            'customer_id' => $customer->id, 
            'transaction_id' => $request->transaction_id])
            ->first();

        if (!empty($transaction))  {

            $transaction->update(['identified' => 1]);

            // return response()->json(['success' => true, 'messsage' => 'User indentify successfully.']); 
        }

        return response()->json(['success' => true, 'messsage' => 'User indentify successfully.']); 
    }


    /**
    * Notifications api
    *
    * @return \Illuminate\Http\Response
    */
    public function notifications(Request $request)
    {
        $notifications = NotificationModel::all();

        return response()->json(['success' => true, 'notifications' => $notifications]);
    }

}
