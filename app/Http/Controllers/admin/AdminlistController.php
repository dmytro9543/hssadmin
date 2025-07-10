<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\historyCrypt;

class AdminlistController extends Controller
{
    public function adminManagement(Request $request){
    	$page = $request->get('page', 1);
        $data_per_page = $request->get('myselect', 10);
        $gettype = $request->get('gettype', null);
        $order = $request->get('order', 'asc');
        $sort = $request->get('sort', 'users.created_at');
       
        $data_size = DB::table('users')->count();
        $tb = DB::table('users')->orderBy($sort, $order)->paginate($data_per_page);
        $permInfo = DB::table('admin_perm')->where('admin_id', '=', Auth::user()->uid)->get();
        
        if ($gettype != null) 
            return view('admin.adminManagementContent', compact('permInfo', 'tb', 'page', 'order', 'sort', 'data_per_page', 'data_size'));
    	return view('admin.adminManagement', compact('permInfo','tb', 'page', 'data_per_page', 'order', 'sort', 'data_size'));
    }
   
    public function admindele(Request $request){
        $id = $request->id;

        
        $uid = DB::table('users')->where('id', '=', $id)->first()->uid;
        $adminHistory_Row['operation'] = historyCrypt::encrypt("Delete ".$uid." in Admin list(success)");
        $adminHistory_Row['operated_by'] = $uid;
        DB::table('admin_history')->insert($adminHistory_Row);
        DB::table('users')->where('id', '=', $id)->delete();
        DB::table('admin_perm')->where('id', '=', $id)->delete();
	 
        $err['errorName']='success';
        $err['errorcode']='1';
        return json_encode($err);
    }
   
    public function adminInfo(Request $request){
        $row_Id = $request->get('row_Id');
        $permInfo = DB::table('admin_perm')->where('admin_id', '=', Auth::user()->uid)->get();
        if($row_Id == 0){
            $tb = DB::table('menu')->select('name')->get();
            return view('admin.adminManagementInfo', compact('permInfo', 'tb', 'row_Id'));
        }
        else{
            $tb = DB::table('admin_perm')->leftJoin('menu', 'admin_perm.submenu_id', '=', 'menu.id')
                            ->where('admin_perm.id', '=', $row_Id) 
                            ->where('admin_perm.submenu_id', '<>', 7)
                            ->where('admin_perm.submenu_id', '<>', 8)->get();
            $user_Tb = DB::table('users')->where('id', '=', $row_Id)->first();	
            $name = $user_Tb->name;
            $user_id = $user_Tb->uid;
            $user_ipAddr = $user_Tb->ipAddr;
            $user_authorize = $user_Tb->user_authorize;
            return view('admin.adminManagementInfo', compact('permInfo', 'tb', 'row_Id', 'name', 'user_id', 'user_ipAddr', 'user_authorize'));
        }
    }

    public function saveAdmin(Request $request){
        $id = $request->get('id');
        $name = $request->get('name');
        $uid = $request->get('uid');
        $ipAddr = $request->get('ipAddr');
        $password = $request->get('password');
        $content = $request->get('Adcontent');
        $authorityInfo = $request->get('authorityInfo');
        
        if(empty($name)){
            $err['errorName']='name empty';
            $err['errorcode']='5000';
            return json_encode($err);
        }
        if(empty($uid)){
            $err['errorName']='uid empty';
            $err['errorcode']='5001';
            return json_encode($err);
        }
        if(empty($password) && $id == 0){
            $err['errorName']='password empty';
            $err['errorcode']='5002';
            return json_encode($err);
        }

    
        if($id == 0){
	        if(count(DB::table('users')->where('uid', '=', $uid)->get())){
	            $err['errorName']='administrator uid duplicate';
	            $err['errorcode']='5003';
	            return json_encode($err);
	        }
	        $user_Row['uid'] = $uid;
	        $user_Row['name'] = $name;
	        $user_Row['password'] = openssl_digest($password, "sha256");
	        $user_Row['ipAddr'] = $ipAddr;
	        $user_Row['user_authorize'] = $content;
	        $user_Row['last_change_pwd'] = date("Y-m-d H:i:s", time());
	        $id = DB::table('users')->insertGetId($user_Row);	
	
	        for($i=1; $i<=10; $i++){
	            $admin_Perm_Row['id'] = $id;
	            $admin_Perm_Row['admin_id'] = $uid;
	            $admin_Perm_Row['submenu_id'] = $i;

	            $admin_Perm_Row['perm_view'] = 0;
	            if($authorityInfo[($i-1)*3] == 'true')
	                $admin_Perm_Row['perm_view'] = 1;

	            $admin_Perm_Row['perm_upd'] = 0;
	            if($authorityInfo[($i-1)*3+1] == 'true')
	                $admin_Perm_Row['perm_upd'] = 1;

	            $admin_Perm_Row['perm_del'] = 0;
	            if($authorityInfo[($i-1)*3+2] == 'true')
	                $admin_Perm_Row['perm_del'] = 1;
	            DB::table('admin_perm')->insert($admin_Perm_Row);	
	        }
            $adminHistory_Row['operated_by'] = historyCrypt::encrypt(Auth::user()->uid);
            $adminHistory_Row['operation'] = historyCrypt::encrypt("Insert ".$uid." into Admin List(success)");
            DB::table('admin_history')->insert($adminHistory_Row);
        }
        else{
	        $user_Row['uid'] = $uid;
	        $user_Row['name'] = $name;
	        if(!empty($ipAddr))
	            $user_Row['ipAddr'] = $ipAddr;
	        if(!empty($password))
	            $user_Row['password'] = openssl_digest($password, "sha256");
	        if(!empty($content))
	            $user_Row['user_authorize'] = $content;
	        $user_Row['last_change_pwd'] = date("Y-m-d H:i:s", time());
	        DB::table('users')->where('id', '=', $id)->update($user_Row);  

	        $admin_Perm_Tb = DB::table('admin_perm')->where('id', '=', $id)->select('no')->get();
	        $cnt = DB::table('menu')->count();
	        for($i=1; $i<=10; $i++){
	            $admin_Perm_Row['id'] = $id;
	            $admin_Perm_Row['admin_id'] = $uid;
	            $admin_Perm_Row['submenu_id'] = $i;

	            $admin_Perm_Row['perm_view'] = 0;
	            if($authorityInfo[($i-1)*3] == 'true')
	                $admin_Perm_Row['perm_view'] = 1;

	            $admin_Perm_Row['perm_upd'] = 0;
	            if($authorityInfo[($i-1)*3+1] == 'true')
	                $admin_Perm_Row['perm_upd'] = 1;

	            $admin_Perm_Row['perm_del'] = 0;
	            if($authorityInfo[($i-1)*3+2] == 'true')
	                $admin_Perm_Row['perm_del'] = 1;
	            DB::table('admin_perm')->where('no', '=', $admin_Perm_Tb[$i-1]->no)->update($admin_Perm_Row); 
	        }  
            $adminHistory_Row['operated_by'] = historyCrypt::encrypt(Auth::user()->uid);
            $adminHistory_Row['operation'] = historyCrypt::encrypt("Edit ".$uid."(success)");
            DB::table('admin_history')->insert($adminHistory_Row);
        }
        $err['errorName']='success';
        $err['errorcode']='1';
        return json_encode($err);
    }
}