<?php

namespace App\Http\Controllers\connect;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class ConnectedHistoryController extends Controller
{
	public function index(Request $request){
	    	$page = $request->get('page', 1);
	        $data_per_page = $request->get('myselect', 5);
	        $gettype = $request->get('gettype', null);
	        $order = $request->get('order', 'asc');
	        $sort = $request->get('sort', 'id');
		
	        $Served_imsi = $request->get('Served_imsi', '');
	        $Served_imei = $request->get('Served_imei', '');
	        $Served_pdp_address = $request->get('Served_pdp_address', '');
	        
	        $data_size = DB::table('cdr')->where('flag', '=', 1)->where('Served_imsi', 'like', '%'.$Served_imsi.'%')->where('Served_imei', 'like', '%'.$Served_imei.'%')->where('Served_pdp_address', 'like', '%'.$Served_pdp_address.'%')->count();
	    	$tb = DB::table('cdr')->where('flag', '=', 1)->where('Served_imsi', 'like', '%'.$Served_imsi.'%')->where('Served_imei', 'like', '%'.$Served_imei.'%')->where('Served_pdp_address', 'like', '%'.$Served_pdp_address.'%')->orderBy($sort, $order)->paginate($data_per_page);
	    	
	        $permInfo = DB::table('admin_perm')->where('admin_id', '=', Auth::user()->uid)->get();
      
    		if($gettype != null)
	        	return view('connect.connectedHistoryContent', compact('permInfo', 'tb', 'page' ,'data_per_page', 'data_size', 'order', 'sort'));
	    	return view('connect.connectedHistory', compact('permInfo', 'tb','page' , 'data_per_page', 'order', 'sort', 'data_size'));
	}

    public function getHistoryDetailInfo(Request $request){
        $id = $request->get('id');
        return json_encode(DB::table('cdr')->where('id', '=', $id)->get());
    }
}
