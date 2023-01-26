<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\NotificationModel;
use Validator;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        return view('notification.index');
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

        $totalRecords = NotificationModel::select('count(*) as allcount')->count(); 

        $totalRecordswithFilter = NotificationModel::select('count(*) as allcount')

                                ->where('notification', 'like', '%' .$searchValue . '%')

                                ->count(); 

 

        // Fetch records 

        $records = NotificationModel::orderBy($columnName,$columnSortOrder) 

            ->where('notification', 'like', '%' .$searchValue . '%')

            ->skip($start) 

            ->take($rowperpage) 

            ->get(); 

 

        $data_arr = array(); 

        $sno = $start+1; 

        foreach($records as $record){ 

            $id = $record->id; 


            $data_arr[] = array( 

                "id" => $id, 

                "customer_id" => $record->customer_id, 

                "notification" => $record->notification,

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
        //
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
            'notification'=>'required'
        ]);

        $notification = new NotificationModel([
            'notification' => $request->get('notification'),
        ]);
        $notification->save();

        return response()->json([
            "success" => true,
            "message" => "Successfully updated"
        ]);
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $request->validate([
            'notification'=>'required'
        ]);
        $notification = NotificationModel::findOrFail($id);
        if ($request->exists('notification')) {
            $notification->notification = $request->get('notification');
        }
        $notification->save();
 
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
        $notification = NotificationModel::find($id);
        $deleted = $notification->delete();
 
        echo json_encode(['success' => $deleted]); 

        exit; 
    }
}
