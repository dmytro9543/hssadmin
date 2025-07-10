<?php

namespace App\Http\Controllers\imsi;

use Illuminate\Http\Request;
use App\models\Epdn;
use App\models\Euserpdn;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\historyCrypt;

class PdnController extends Controller
{
    public function index(Request $request){
    	$page = $request->get('page', 1);
        $data_per_page = $request->get('myselect', 5);
        $gettype = $request->get('gettype', null);
        $order = $request->get('order', 'asc');
        $sort = $request->get('sort', 'apn');
	
        $userpdncounts = array();
        $pdns = DB::table('e_pdn')->select();
        $pdncounts = Epdn::all();
        $data_size = $pdns->count();
        foreach($pdncounts as $pdncount){
            $usercount = Euserpdn::where('pdn_id', $pdncount->id)->count();
            $userpdncounts[$pdncount->id] = $usercount;
        }
	  
        $data_size = count(DB::table('e_pdn')->get());
        $tb = DB::table('e_pdn')->orderBy($sort, $order)->paginate($data_per_page);
        $permInfo = DB::table('admin_perm')->where('admin_id', '=', Auth::user()->uid)->get();
        
        if($gettype != null)
            return view('imsi.pdncontent', compact('permInfo', 'tb', 'page' ,'data_per_page', 'data_size', 'order', 'sort', 'userpdncounts'));
        return view('imsi.pdn', compact('permInfo', 'tb','page' , 'data_per_page', 'order', 'sort', 'data_size', 'userpdncounts'));
    }
	
    public function getInfo(Request $request) {
        $id = $request->get('id', 0);
        $pdninfo = Epdn::where('id', $id)->get();
        return json_encode($pdninfo);
    }
    
    public function saveInfo(Request $request) {
        $id = $request->get('id', 0);
        $apn = $request->get('apn');
        $pdn_type = $request->get('pdn_type');
        $pdn_ipv4 = $request->get('pdn_ipv4');
        $pdn_ipv6 = $request->get('pdn_ipv6');
        $aggregate_ambr_ul = $request->get('aggregate_ambr_ul');
        $aggregate_ambr_dl = $request->get('aggregate_ambr_dl');
        $qci = $request->get('qci');
        $priority_level = $request->get('priority_level');
        $pre_emp_cap = $request->get('pre_emp_cap');
        $pre_emp_vul = $request->get('pre_emp_vul');
        $LIPA_Permissions = $request->get('LIPA_Permissions');
	
        if(empty($apn)){
            $err['errorName']='apn field empty';
            $err['errorcode']='3001';
            return json_encode($err);
        }
        if(empty($pdn_type)){
            $err['errorName']='pdn_type field empty';
            $err['errorcode']='3002';
            return json_encode($err);
        }
        if(empty($pdn_ipv4)){
            $err['errorName']='pdn_ipv4 field empty';
            $err['errorcode']='3003';
            return json_encode($err);
        }
        if(empty($pdn_ipv6)){
            $err['errorName']='pdn_ipv6 field empty';
            $err['errorcode']='3004';
            return json_encode($err);
        }
        if(empty($aggregate_ambr_ul)){
            $err['errorName']='aggregate_ambr_ul field empty';
            $err['errorcode']='3005';
            return json_encode($err);
        }
        if(empty($aggregate_ambr_dl)){
            $err['errorName']='aggregate_ambr_dl field empty';
            $err['errorcode']='3006';
            return json_encode($err);
        }
        if(empty($qci)){
            $err['errorName']='qci field empty';
            $err['errorcode']='3007';
            return json_encode($err);
        }
        
        if(empty($priority_level)){
            $err['errorName']='priority_level field empty';
            $err['errorcode']='3008';
            return json_encode($err);
        }
        if(empty($pre_emp_cap)){
            $err['errorName']='pre_emp_cap field empty';
            $err['errorcode']='3009';
            return json_encode($err);
        }
        if(empty($pre_emp_vul)){
            $err['errorName']='pre_emp_vul field empty';
            $err['errorcode']='3010';
            return json_encode($err);
        }
        if(empty($LIPA_Permissions)){
            $err['errorName']='LIPA_Permissions field empty';
            $err['errorcode']='3011';
            return json_encode($err);
        }
        
        $val['apn'] = $apn;
        $val['pdn_type'] = $pdn_type;
        $val['pdn_ipv4'] = $pdn_ipv4;
        $val['aggregate_ambr_ul'] = $aggregate_ambr_ul*1024*1024;
        $val['aggregate_ambr_dl'] = $aggregate_ambr_dl*1024*1024;
        $val['qci'] = $qci;
        $val['priority_level'] = $priority_level;
        $val['pre_emp_cap'] = $pre_emp_cap;
        $val['pre_emp_vul'] = $pre_emp_vul;
        $val['LIPA_Permissions'] = $LIPA_Permissions;
        
        $repeatedRows = DB::table('e_pdn')->where('apn', '=', $apn)->get();
        
        if($id == 0) { // Add
           if(count($repeatedRows) >0){
                $adminHistory_Row['operated_by'] = historyCrypt::encrypt(Auth::user()->uid);
                $adminHistory_Row['operation'] = historyCrypt::encrypt("Insert ".$apn." into PDN List(failed)");
                DB::table('admin_history')->insert($adminHistory_Row);

                $err['errorName']='duplicate apn Name';
                $err['errorcode']='3012';
                return json_encode($err);   
            }

            DB::table('e_pdn')->insert($val);
              
            // $adminHistory_Row['operated_by'] = Auth::user()->uid;
            $adminHistory_Row['operated_by'] = historyCrypt::encrypt(Auth::user()->uid);
            $adminHistory_Row['operation'] = historyCrypt::encrypt("Insert ".$apn." into PDN List(success)");
            DB::table('admin_history')->insert($adminHistory_Row);
        } else { // Update
                $df = $request->get('isDifferent');
                if($df != 0){
                    foreach ($repeatedRows as $key => $row) {
                    # code...
                    if(!empty(strstr($row->apn, $apn))){
                        $adminHistory_Row['operated_by'] = historyCrypt::encrypt(Auth::user()->uid);
                        $adminHistory_Row['operation'] = historyCrypt::encrypt("Edit ".$apn." in PDN List(failed)");
                        DB::table('admin_history')->insert($adminHistory_Row);

                        $err['errorName']='duplicate apn Name';
                        $err['errorcode']='3012';
                        return json_encode($err);
                        }
                    }
                }
            DB::table('e_pdn')->where('id', '=', $id)->update($val);

            $adminHistory_Row['operated_by'] = historyCrypt::encrypt(Auth::user()->uid);
            $adminHistory_Row['operation'] = historyCrypt::encrypt("Edit ".$apn." in PDN List(success)");
            DB::table('admin_history')->insert($adminHistory_Row);
        }
        $err['errorName']='success';
        $err['errorcode']='1';
        return json_encode($err);
    }
    
    public function deletePdnInfo(Request $request){
        $id = $request->get('id');

        $apn = DB::table('e_pdn')->where('id', '=', $id)->first()->apn;
        $user_Pdn = DB::table('e_userpdn')->where('pdn_id', '=', $id)->get();
        if(!empty($user_Pdn)){
            $adminHistory_Row['operated_by'] = Auth::user()->uid;
            $adminHistory_Row['operation'] = "Delete ".$apn." in PDN List(failed)";
            $err['errorName']='Because using Pdn, it can not delete';
            $err['errorcode']='3013';
            return json_encode($err);
        }
        $adminHistory_Row['operated_by'] = historyCrypt::encrypt(Auth::user()->uid);        
        $adminHistory_Row['operation'] = historyCrypt::encrypt("Delete ".$apn." in PDN List(success)");
        DB::table('admin_history')->insert($adminHistory_Row);

        DB::table('e_pdn')->where('id', '=', $id)->delete();
        DB::table('e_userpdn')->where('pdn_id', '=', $id)->delete();
        DB::table('profilepdn')->where('pdn_id', '=', $id)->delete();
        
        $err['errorName']='success';
        $err['errorcode']='1';
        return json_encode($err);
    }
}
