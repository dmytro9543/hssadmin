<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
class CommonController extends Controller
{
    public function index(Request $request){
    	$permInfo = DB::table('admin_perm')->where('admin_id', '=', Auth::user()->uid)->get();
    	
        $imsiCnt = DB::table('u_baseinfo')->count();
        
        $pdnCnt = DB::table('e_pdn')->count();
        
        $blackListCnt = DB::table('terminal_info')->where('status', '=', 'BLACKLISTED')->count();
        
        $whiteListCnt = DB::table('terminal_info')->where('status', '=', 'WHITELISTED')->count();
        
        $page = $request->get('page', 1);
        $data_per_page = 10;
        $historyInfo = DB::table('loginhistory')->where('uid', '=', Auth::user()->uid)->orderBy('created_at', 'desc')->paginate($data_per_page);
        return view('systeminfo', compact('permInfo', 'imsiCnt', 'pdnCnt', 'blackListCnt', 'whiteListCnt', 'historyInfo', 'data_per_page', 'page'));
    }

    function updatePassword(Request $request){
        $new_psw = $request->new_psw;
        $pre_Password = openssl_digest($request->pre_Password, "sha256");
        
        if($pre_Password  !=  Auth::user()->password){
            $err['errorName']='Previous Password is wrong';
            $err['errorcode']='5004';
            return json_encode($err);
        }
        $user_Row["password"] = openssl_digest($new_psw, "sha256");
        $user_Row["last_change_pwd"] = date("Y-m-d H:i:s");
        
        DB::table("users")->where('uid', '=', Auth::user()->uid)->update($user_Row);
        $err['errorName']='success';
        $err['errorcode']='1';
        return json_encode($err);
    }

    function createRandom(Request $request){
        $byte = openssl_random_pseudo_bytes(rand(5, 9));
        session_start();
        $_SESSION["random"] = bin2hex($byte);
        return bin2hex($byte);
    }
   

}
