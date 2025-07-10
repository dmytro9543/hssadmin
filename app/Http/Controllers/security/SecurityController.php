<?php

namespace App\Http\Controllers\security;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\historyCrypt;

class SecurityController extends Controller
{

	public function index(Request $request){
		$permInfo = DB::table('admin_perm')->where('admin_id', '=', Auth::user()->uid)->get();
		return view('security.security',compact('permInfo'));
    }
    
	public function  saveOPC(Request $request){
		$opc = $request->get('opc');
		if(empty($opc)){
			$err['errorName']='opc field empty';
            $err['errorcode']='1020';
            return json_encode($err);
		}
		$config_Table_Row['name'] = 'opc';
		$config_Table_Row['value'] = $opc;
		$flag = false;
		$config_table = DB::table('config')->get();
		foreach ($config_table as $key => $row) {
			# code...
			if($row->name == 'opc'){
				$flag = true;
				break;
			}
		}
		
		if($flag){
			DB::table('config')->where('name', '=', 'opc')->update($config_Table_Row);
			$adminHistory_Row['operated_by'] = historyCrypt::encrypt(Auth::user()->uid);
			$adminHistory_Row['operation'] = historyCrypt::encrypt("Edit OPC in Security Management(success)");
            DB::table('admin_history')->insert($adminHistory_Row);
		}
		else{
			DB::table('config')->insert($config_Table_Row);
			
			$adminHistory_Row['operated_by'] = historyCrypt::encrypt(Auth::user()->uid);
			$adminHistory_Row['operation'] = historyCrypt::encrypt("Insert OPC in Security Management(success)");
            DB::table('admin_history')->insert($adminHistory_Row);
		}
		
		$err['errorName']='success';
        $err['errorcode']='1';
		return json_encode($err);
	}
}
