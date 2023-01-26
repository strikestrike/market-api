<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CustomerContactsModel;

class CustomerContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($customer_id)
    { 
        return view('customer_contacts.contacts', compact('customer_id'));
    }

    public function getTableData(Request $request) 
    { 

        $customer_id = $request->get('customer_id');

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

        $totalRecords = CustomerContactsModel::select('count(*) as allcount')->count(); 

        $totalRecordswithFilter = CustomerContactsModel::select('count(*) as allcount')

                                ->when($customer_id == 'all' || empty($customer_id), function($query){ 
                                      return $query;
                                }, function($query) use ($customer_id){
                                      return $query->where("customer_id", $customer_id); 
                                })

                                ->where(function($query) use ($searchValue) {
                                    $query->where('name', 'like', '%' .$searchValue . '%')
                                        ->orWhere('phones', 'like', '%' .$searchValue . '%');
                                })

                                ->count(); 

 

        // Fetch records 

        $records = CustomerContactsModel::orderBy($columnName,$columnSortOrder) 

            ->when($customer_id == 'all' || empty($customer_id), function($query){ 
                  return $query;
            }, function($query) use ($customer_id){
                  return $query->where("customer_id", $customer_id); 
            })

            ->where(function($query) use ($searchValue) {
                $query->where('name', 'like', '%' .$searchValue . '%')
                    ->orWhere('phones', 'like', '%' .$searchValue . '%');
            })

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

                "secret_code" => $record->customer->secret_code,

                "name" => $record->name, 

                "phones" => $record->phones,

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer_contacts = CustomerContactsModel::find($id);
        $deleted = $customer_contacts->delete();
 
        echo json_encode(['success' => $deleted]); 

        exit; 
    }
}
