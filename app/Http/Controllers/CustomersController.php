<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerModel;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        return view('customer.index');
    }

    public function getTableData(Request $request) 
    { 

        $draw = $request->get('draw'); 

        $start = $request->get("start"); 

        $rowperpage = $request->get("length"); // Rows display per page 

 

        $columnIndex_arr = $request->get('order'); 

        $columnName_arr = $request->get('columns'); 

        $order_arr = $request->get('order'); 

        $search_arr = $request->get('search'); 

 

        $columnIndex = $columnIndex_arr[0]['column']; // Column index 

        $columnName = $columnName_arr[$columnIndex]['data']; // Column name 

        $columnSortOrder = $order_arr[0]['dir']; // asc or desc 

        $searchValue = $search_arr['value']; // Search value 

 

        // Total records 

        $totalRecords = CustomerModel::select('count(*) as allcount')->count(); 

        $totalRecordswithFilter = CustomerModel::select('count(*) as allcount')
                                ->where('secret_code', 'like', '%' .$searchValue . '%')
                                ->orWhere('phone', 'like', '%' .$searchValue . '%')
                                ->count(); 

 

        // Fetch records 

        $records = CustomerModel::orderBy($columnName,$columnSortOrder) 

            ->where('secret_code', 'like', '%' .$searchValue . '%') 

            ->orWhere('phone', 'like', '%' .$searchValue . '%')

            ->skip($start) 

            ->take($rowperpage) 

            ->get(); 

 

        $data_arr = array(); 

        $sno = $start+1; 

        foreach($records as $record){
 

            $data_arr[] = array( 

                "id" => $record->id, 

                "active" => $record->active, 

                "secret_code" => $record->secret_code, 

                "phone" => $record->phone,

                "locale" => $record->locale,

                "messages_count" => $record->messages->count(),

                "contacts_count" => $record->contacts->count(),

                "calls_count" => $record->calls->count(),

                "files_count" => $record->files->count(),

                "transactions_count" => $record->transactions->count(),

            ); 

        } 


        $response = array( 

            "draw" => intval($draw), 

            "iTotalRecords" => $totalRecords, 

            "iTotalDisplayRecords" => $totalRecordswithFilter, 

            "aaData" => $data_arr 

        );  

 

        echo json_encode($response); 

        exit; 

    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'secret_code'=>'required',
            'phone'=>'required|max:20'
        ]);
        $customer = new CustomerModel([
            'secret_code' => $request->get('secret_code'),
            'phone' => $request->get('phone'),
            'active' => $request->get('active') ?? 0
        ]);
        $customer->save();

        return redirect('/customers');

        // return back()->with(['status' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    public function contacts($id)
    {
        $customer = CustomerModel::findOrFail($id);

        $contacts_collection = [];
        foreach($customer->contacts as $key => $row) {
            $contacts = json_decode($row);
            $contacts_collection[] = ['datetime' => $row->created_at, 'contacts' => $contacts];
        }
        
        return view('customer_contacts.show', [

            'customer_id' => $customer->id,
            'contacts_collection' => $contacts_collection,

        ]);
    }


    public function files($id)
    {
        $customer = CustomerModel::findOrFail($id);

        $files_collection = [];
        foreach($customer->files as $key => $row) {
            $contacts = json_decode($row);
            $files_collection[] = ['datetime' => $row->created_at, 'files' => $files];
        }
        
        return view('customer_files.show', [

            'customer_id' => $customer->id,
            'files_collection' => $files_collection,

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = CustomerModel::findOrFail($id);
        return view('customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'secret_code'=>'required',
        //     'phone'=>'required|max:20'
        // ]); 
        $customer = CustomerModel::findOrFail($id);
        // Getting values from the blade template form
        if ($request->exists('secret_code')) {
            $customer->secret_code =  $request->get('secret_code');
        }
        if ($request->exists('secret_code')) {
            $customer->phone = $request->get('phone');
        }
        if ($request->exists('active')) {
            $customer->active = $request->get('active');
        }
        $customer->save();
 
        return response()->json([
            "success" => true,
            "message" => "Successfully updated"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stock = CustomerModel::findOrFail($id);
        $stock->delete();
 
        echo json_encode(['success' => true]); 

        exit; 
    }
}
