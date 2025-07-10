<?php
namespace App\Http\Controllers\imei;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\historyCrypt;

class ImeiController extends Controller
{
    public function index(Request $request){
    	$page = $request->get('page', 1);
        $data_per_page = $request->get('myselect', 5);
        $gettype = $request->get('gettype', null);
        $order = $request->get('order', 'asc');
        $sort = $request->get('sort', 'imei');

        $imei = $request->get('imei', '');
        $imeiSv = $request->get('imeiSv', '');

        $status = 'BLACKLISTED';
        $title = 'Black List';
    	if($request->is('whiteList')){
	        $status = 'WHITELISTED';
            $title = 'White List';
            $url = '/whiteList';
    	}
        $data_size = DB::table('terminal_info')->where('status', '=', $status)->where('imei', 'like', '%'.$imei.'%')->where('sv', 'like', '%'.$imeiSv.'%')->count();
        
    	$tb = DB::table('terminal_info')->where('status', '=', $status)->where('imei', 'like', '%'.$imei.'%')->where('sv', 'like', '%'.$imeiSv.'%')->orderBy($sort, $order)->paginate($data_per_page);
        $permInfo = DB::table('admin_perm')->where('admin_id', '=', Auth::user()->uid)->get();
        
        if($gettype != null)
	        return view('imei.imeicontent', compact('permInfo', 'tb', 'page' ,'data_per_page', 'data_size', 'order', 'sort', 'status'));
	    return view('imei.imei', compact('permInfo', 'tb','page' , 'data_per_page', 'order', 'sort', 'data_size', 'title', 'status'));
    }
    
    public function saveIMEIInfo(Request $request){
    	$id = $request->get('id');
        $imei = $request->get('imei');
        $status = $request->get('status');
        $is_Different = $request->get('is_Different');
        
        if(empty($imei)){
            $err['errorName']='imei field empty';
            $err['errorcode']='1003';
            return json_encode($err);
        }
        $sv = $request->get('sv');
        if(empty($sv)){
            $err['errorName']='sv field empty';
            $err['errorcode']='1004';
            return json_encode($err);
        }
        $remark = $request->get('remark');
        $terminal_info_Row['imei'] = $imei;
        $terminal_info_Row['sv'] = $sv;
        $terminal_info_Row['status'] = $status;
        $terminal_info_Row['remark'] = $remark;
        if($id == 0)
            $terminal_info_Row['created_at'] = date('y-m-d H:i:s');
        
        $repeatedRow = DB::table('terminal_info')->where('imei','=',$imei)->first();
        
        if($id == 0){//insert   
        	
            //return json_encode($repeatedRow->status);
                if(count($repeatedRow) >0){
                    if(empty(strstr($repeatedRow->status, $status)))
                        $err['errorName']=$repeatedRow->status;
                    else
                        $err['errorName']=$status;
                $err['errorcode']='2004';
                return json_encode($err);    
            }
            DB::table('terminal_info')->insert($terminal_info_Row);

            $adminHistory_Row['operated_by'] = historyCrypt::encrypt(Auth::user()->uid);
            if(empty(strstr("WHITELISTED", $status)))
                $adminHistory_Row['operation'] = historyCrypt::encrypt("Insert ".$imei." into Blacklist(success)");
            else
            $adminHistory_Row['operation'] = historyCrypt::encrypt("Insert ".$imei." into Whitelist(success)");
            DB::table('admin_history')->insert($adminHistory_Row);
        }
        else{//update
            if(count($repeatedRow) >=1  && intval($is_Different) != 0){
                $err['errorName']=$repeatedRow->status;
                $err['errorcode']='2004';
                return json_encode($err);    
            }
            DB::table('terminal_info')->where('id', '=', $id)->update($terminal_info_Row);

              $adminHistory_Row['operated_by'] = historyCrypt::encrypt(Auth::user()->uid);
            if(empty(strstr("WHITELISTED", $status)))
                $adminHistory_Row['operation'] = historyCrypt::encrypt("Edit ".$imei." in Blacklist(success)");
            else
            $adminHistory_Row['operation'] = historyCrypt::encrypt("Edit ".$imei." in Whitelist(success)");
            DB::table('admin_history')->insert($adminHistory_Row); 
        }
        $err['errorName']='success';
        $err['errorcode']='1';
        return json_encode($err);
    }

    public function getIMEIInfo(Request $request){
        $id= $request->get('id');
        return json_encode(DB::table('terminal_info')->where('id', '=', $id)->get());
    }

    public function getRemark(Request $request){
        $id= $request->get('id');
        return json_encode(DB::table('terminal_info')->where('id', '=', $id)->select('remark')->get());
    }

    public function deleteIMEIInfo(Request $request){
        $id= $request->get('id');
        $tb = DB::table('terminal_info')->where('id', '=', $id)->first();
        
        $adminHistory_Row['operated_by'] = historyCrypt::encrypt(Auth::user()->uid);
        if(empty(strstr("WHITELISTED", $tb->status))){
            $adminHistory_Row['operation'] = historyCrypt::encrypt("Delete ".$tb->imei." in Blacklist(success)");
        }
        else{
            $adminHistory_Row['operation'] = historyCrypt::encrypt("Delete ".$tb->imei." in Whitelist(success)");
        }
        DB::table('admin_history')->insert($adminHistory_Row);
        
        DB::table('terminal_info')->where('id', '=', $id)->delete();
        $err['errorName']='success';
        $err['errorcode']='1';
        return json_encode($err);
    }
}
