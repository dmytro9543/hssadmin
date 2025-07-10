<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\historyCrypt;

class AdminhistoryController extends Controller
{
    public function adminhistory(Request $request){
    	$page = $request->get('page', 1);
        $data_per_page = $request->get('myselect', 10);
        $gettype = $request->get('gettype', null);
        $order = $request->get('order', 'desc');
        $sort = $request->get('sort', 'created_at'); 
        $searchAdmiId = $request->get('searchAdmiId', '');
        
        
        $data_size = DB::table('admin_history')->where('operated_by', 'like', '%'.$searchAdmiId.'%')->count();
        $tb = DB::table('admin_history')->where('operated_by', 'like', '%'.$searchAdmiId.'%')->orderBy($sort, $order)->paginate($data_per_page);
        $permInfo = DB::table('admin_perm')->where('admin_id', '=', Auth::user()->uid)->get();
        
        if ($gettype != null)
            return view('admin.adminhistorycontent', compact('permInfo','tb', 'page', 'order', 'sort', 'data_per_page', 'data_size'));
        return view('admin.admin_history', compact('permInfo','tb', 'page', 'data_per_page', 'order', 'sort', 'data_size'));
    }

    public function adminhistory_del(Request $request){
    	$id = $request->id;
        DB::table('admin_history')->where('id', '=', $id)->delete();
        $err['errorName']='success';
        $err['errorcode']='1';
        return json_encode($err);
    }
    public function clearHistory(Request $request){
        $adminHistory_Row['operated_by'] = historyCrypt::encrypt(Auth::user()->uid);
        $adminHistory_Row['operation'] = historyCrypt::encrypt(Auth::user()->uid.": Clear Access Log.");
        DB::table('admin_history')->delete();
        DB::table('admin_history')->insert($adminHistory_Row);

    }
}
