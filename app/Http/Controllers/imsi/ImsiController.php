<?php

namespace App\Http\Controllers\imsi;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\models\UbaseInfo;
use App\models\Uauth;
use App\models\Euserpdn;
use App\models\Epdn;
use App\models\Profiles;
use Auth;
use App\historyCrypt;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\FifoWriter;

class ImsiController extends Controller
{
	
    public function index(Request $request){
        $page = $request->get('page', 1);
        $data_per_page = $request->get('myselect', 5);
        $gettype = $request->get('gettype', null);
        $order = $request->get('order', 'asc');
        $sort = $request->get('sort', 'imsi');
        $imsi = $request->get('imsi', '');
        $subscriber_status = $request->get('subscriber_status', '');
        $subscriber_status = $subscriber_status == 'ALL' ? '' : $subscriber_status;

        $u_baseinfo = DB::table("u_baseinfo")->where('imsi', 'like', '%'.$imsi.'%')->where('subscriber_status', 'like', '%'.$subscriber_status.'%');
        $data_size = $u_baseinfo->count();                                                                                                              

        $tb = $u_baseinfo->orderBy($sort, $order)->paginate($data_per_page);

        $pdnCount_apnName_Array = array();
        foreach ($tb as $key => $row) {

            $pdns = DB::table("e_userpdn")
                ->leftJoin("e_pdn", "e_pdn.id", "=", "e_userpdn.pdn_id")
                ->where("e_userpdn.imsi", $row->imsi)
                ->select("e_pdn.apn")->get();

            $cnt = 0;
            $apnNames = "";
            foreach($pdns as $pdn_info){
                $apnNames.=$pdn_info->apn;
                $apnNames.=',';
                $cnt++;
            }
            $pdnCount_apnName_Array[$row->id] = substr($apnNames, 0, strlen($apnNames)-1);
        }

        $permInfo = DB::table('admin_perm')->where('admin_id', '=', Auth::user()->uid)->get();
        $quantity = 0;
        $errorcode['errorName']='success';
        $errorcode['errorcode']='1';
        if($gettype != null)
          return view('imsi.imsicontent', compact('permInfo','tb', 'page' ,'data_per_page', 'data_size', 'pdnCount_apnName_Array', 'order', 'sort'));
        return view('imsi.imsi', compact('permInfo', 'tb','page' , 'data_per_page', 'order', 'sort', 'data_size', 'pdnCount_apnName_Array', 'quantity', 'errorcode'));
    }
	
    public function getProfileName(Request $request){
        $profile = DB::table('profiles')->select('name')->get();
        return json_encode($profile);
    }

    public function getProfileInfo(Request $request){
        $proName = $request->get('name');
        $data = DB::table('profiles')->where('name', '=', $proName)->get();
        return  json_encode($data);
    }

    public function saveIMSIInfo(Request $request){
        $id = $request->get('id',0);
        $imsi = $request->get('imsi');

        $ki = $request->get('ki');
        $k = $ki;
        
        
        $opc = DB::table('config')->where('name', '=', 'opc')->get();
        $opcVal = "";
        if(!empty($opc))
            $opcVal = $opc[0]->value;
        $msisdn = $request->get('msisdn');
        $remark = htmlentities($request->get('remark', ""));
        $subscriber_status = $request->get('subscriber_status','SERVICE_GRANTED');
        $rau_tau_timer = $request->get('rau_tau_timer',120);
        $ue_ambr_ul = $request->get('ue_ambr_ul',50000000);
        $ue_ambr_dl = $request->get('ue_ambr_dl',100000000);
        $pdnList = $request->get('pdnList',array());
        
        if(empty($imsi)){
            $err['errorName']='imsi field empty';
            $err['errorcode']='1000';
            return json_encode($err);
        }
        if(empty($ki)){
            $err['errorName']='ki field empty';
            $err['errorcode']='1001';
            return json_encode($err);
        }
        if(empty($subscriber_status)){
            $err['errorName']='subscriber_status field empty';
            $err['errorcode']='4002';
            return json_encode($err);
        }
        if(empty($rau_tau_timer)){
            $err['errorName']='rau_tau_timer field empty';
            $err['errorcode']='4003';
            return json_encode($err);
        }
        if(empty($ue_ambr_ul)){
            $err['errorName']='ue_ambr_ul field empty';
            $err['errorcode']='3005';
            return json_encode($err);
        }
        if(empty($ue_ambr_dl)){
            $err['errorName']='ue_ambr_dl field empty';
            $err['errorcode']='3006';
            return json_encode($err);
        }
        if(count($pdnList) == 0){
            $err['errorName']='pdnList not check';
            $err['errorcode']='4004';
            return json_encode($err);
        }

        $Ubaseinfo_row['imsi'] = $imsi;
        $Ubaseinfo_row['msisdn'] = $msisdn;
        $Ubaseinfo_row['remark'] = $remark;
        $Ubaseinfo_row['subscriber_status'] = $subscriber_status;
        $Ubaseinfo_row['rau_tau_timer'] = $rau_tau_timer;
        $Ubaseinfo_row['ue_ambr_ul'] = $ue_ambr_ul*1024*1024;
        $Ubaseinfo_row['ue_ambr_dl'] = $ue_ambr_dl*1024*1024;
        
        if($id == 0){//Add
            $repeatedImsiCount = DB::table('u_baseinfo')->where('imsi', '=', $imsi)->get();
            if(count($repeatedImsiCount) >= 1){
                $adminHistory_Row['operated_by'] = historyCrypt::encrypt(Auth::user()->uid);
                $adminHistory_Row['operation'] = historyCrypt::encrypt("Insert ".$imsi."into IMSI List(failed)");
                DB::table('admin_history')->insert($adminHistory_Row);

                $err['errorName']='imsi field Duplicate';
                $err['errorcode']='2000';
                return json_encode($err);
             }
            
            DB::table('u_baseinfo')->insert($Ubaseinfo_row);

			/*
            $auth["imsi"] = $imsi;
            $auth["k"] = $k;
            $auth["opc"] = $opcVal;
            DB::table("u_auth")->insert($auth);
			*/
			
			$sql = "insert into u_auth set imsi={$imsi}, k=0x{$k}, opc=0x{$opcVal}";
			
			DB::insert($sql);
			
            
            $adminHistory_Row['operated_by'] = historyCrypt::encrypt(Auth::user()->uid);
            $adminHistory_Row['operation'] = historyCrypt::encrypt("Insert ".$imsi." into IMSI List(success)");
            DB::table('admin_history')->insert($adminHistory_Row);

            $u_dynamic_Row["imsi"] = $imsi;
            $u_dynamic_Row["sqn"] = 0;
            DB::table('u_dynamic')->insert($u_dynamic_Row);
        }
        else{//Update
            DB::table('u_baseinfo')->where('id', '=', $id)->update($Ubaseinfo_row);
            $adminHistory_Row['operated_by'] = historyCrypt::encrypt(Auth::user()->uid);
            $adminHistory_Row['operation'] = historyCrypt::encrypt("Edit ".$imsi." in IMSI List(success)");
            DB::table('admin_history')->insert($adminHistory_Row);

            Euserpdn::where('imsi',$imsi)->delete();
        }
	
        $epdnTable = Epdn::all();
        for($i=0; $i<count($pdnList); $i++){
            $ip = explode("&", $pdnList[$i])[0];
            $pdn_id = explode("&", $pdnList[$i])[1];
            foreach ($epdnTable as $key => $epdn) {
                # code...
                if($epdn->id == $pdn_id){
                   $e_UserPDNData['imsi'] = $imsi;
                   $e_UserPDNData['pdn_id'] = $pdn_id;
                   $e_UserPDNData['ipAddr'] = $ip;
                   DB::table('e_userpdn')->insert($e_UserPDNData);
                   break;
                }
            }
        }

        $fifoWriter = new FifoWriter();
        $cmd = ":reload_user:";
        $params = (($id > 0) ? 2 : 1)."\n";
        $params .= $imsi;
        $fifoWriter->write2fifo($cmd, $params);

        $err['errorName']='success';
        $err['errorcode']='1';
        return json_encode($err);
    }

    public function getRemark(Request $request){
        $id = $request->get('id');
        return json_encode(DB::table('u_baseinfo')->where('id', '=', $id)->select('remark')->get());
    }

    public function getIMSIInfo(Request $request){
        $id = $request->get('id');
        $info = DB::table('u_baseinfo')->where('id', '=', $id)->get();
        $info[0]->remark = html_entity_decode($info[0]->remark);
        return json_encode($info);
    }

    public function getKI(Request $request){
        $imsi = $request->get('imsi');
        $k = DB::table('u_auth')->where('imsi', '=', $imsi)->first()->k;
        $str="";
        for($i=0; $i<strlen($k); $i++){
            $ASCII = Ord($k[$i]);
            $tmp=dechex($ASCII);
            if(strlen($tmp) == 1)
                $str.='0';
            $str.=$tmp;
        }
        return $str;
    }
    
    public function get_ApnName_According_To_IMSI(Request $request){
        $imsi = $request->get('imsi');
        $pdnID_LIST = DB::table('e_userpdn')->where('imsi', '=', $imsi)->get();
        $data_To_Send = array();
        $e_pdn_Table = Epdn::all();
        foreach ($e_pdn_Table as $key => $row) {
            $val['apn'] = $row->apn;
            $val['selected'] = 0;
            $val['id'] = $row->id;
            $val['ipAddr'] = "";
            if(empty($pdnID_LIST)) {
                array_push($data_To_Send, $val);
                continue;
            }
            foreach ($pdnID_LIST as $key => $pdn) {
                $ip = $pdn->ipAddr;
                $id = $pdn->pdn_id;
                if(intval($id) == $row->id){
                    $val['selected'] = 1;
                    $val['ipAddr'] = $ip;
                    break;
                }
            }
            array_push($data_To_Send, $val);
        }
         return json_encode($data_To_Send);
    }

    public function deleteImsiInfo(Request $request){
        $id = $request->get('id');
        $imsi =  DB::table('u_baseinfo')->where('id', '=', $id)->first()->imsi;
        DB::table('u_baseinfo')->where('imsi', '=', $imsi)->delete();
        DB::table('u_auth')->where('imsi', '=', $imsi)->delete();
        DB::table('e_userpdn')->where('imsi', '=', $imsi)->delete();
        DB::table('u_dynamic')->where('imsi', '=', $imsi)->delete();

        $adminHistory_Row['operated_by'] = historyCrypt::encrypt(Auth::user()->uid);
        $adminHistory_Row['operation'] = historyCrypt::encrypt("Delete ".$imsi." in IMSI List(success)");
        DB::table('admin_history')->insert($adminHistory_Row);
        
        $fifoWriter = new FifoWriter();
        $cmd = ":reload_user:";
        $params = "3\n";
        $params .= $imsi;
        $fifoWriter->write2fifo($cmd, $params);

        $err['errorName']='success';
        $err['errorcode']='1';
        return json_encode($err);
    }

    public function getDefaultProfile(){
        return json_encode(DB::table('profiles')->select('name', 'isDefault')->get());
    }
    
    public function isExistOpc(){
    	$opc = DB::table('config')->where('name', '=', 'opc')->get();
        return json_encode(!empty($opc));
    }

    public function getCSVFile(Request $request){
        $filename="";
        if (!$_FILES['csvFile']['error'] == UPLOAD_ERR_OK)//file upload
            return '';
        $filename = $_FILES['csvFile']['name'];
        $filePath = storage_path()."/upload/".$filename;
        //Storage::disk('local')->put($filename, 'Contents');
        if(!move_uploaded_file($_FILES['csvFile']['tmp_name'], $filePath))
            return;
        $handle = fopen($filePath, 'r');
        
        $data = file($filePath);//array mapping
        //if (strlen($data[0]) > 3) $data[0] = substr($data[0], 3); // remove utf8 signature
        $keyIndex = intval($data[0]);
        $result = array();

        for($i=0; $i<count($data); $i++) {
            $str = $data[$i];
            $order = array(" ","\r\n", "\n", "\r");
            $replace=' ';
            $newstr = str_replace($order, $replace, $str);
            $subData = explode(' ', $newstr);
            $imsi = $subData[0];
            
            $opc = DB::table('config')->where('name', '=', 'opc')->first();
            $opcVal = $opc->value;
          
            $k = $subData[1];//$k = bin2hex($subData[1]);
            
            $defProName = $request->get('proName');
            $defaultPro = DB::table('profiles')->where('name', '=', $defProName)->first();
            
            $defaultProId = $defaultPro->id;
            
            
            $Ubaseinfo_row['imsi'] = $imsi;
            $Ubaseinfo_row['subscriber_status'] = $defaultPro->subscriber_status;
            $Ubaseinfo_row['rau_tau_timer'] = $defaultPro->rau_tau_timer;
            $Ubaseinfo_row['ue_ambr_ul'] = $defaultPro->ue_ambr_ul;
            $Ubaseinfo_row['ue_ambr_dl'] = $defaultPro->ue_ambr_dl;

            $repeatedImsiCount = DB::table('u_baseinfo')->where('imsi', '=', $imsi)->get();
            if(count($repeatedImsiCount) >= 1){
                 $adminHistory_Row['operated_by'] = historyCrypt::encrypt(Auth::user()->uid);
                 $adminHistory_Row['operation'] = historyCrypt::encrypt("Insert ".$imsi." into IMSI List(failed)");
                 DB::table('admin_history')->insert($adminHistory_Row);    
                array_push($result, ['imsi'=>$imsi, 'status' => "2000"]);             
            }
            else{
            	 DB::table('u_baseinfo')->insert($Ubaseinfo_row);
                
                $sql = "insert into u_auth set imsi={$imsi}, k=0x{$k}, opc=0x{$opcVal}";
            	  DB::insert($sql);
                
                $rows = DB::table('profilepdn')->where('profile_id','=',$defaultProId)->get();
                foreach ($rows as $key => $row) {	
                    $profilePdnRow['imsi'] = $imsi;
                    $profilePdnRow['pdn_id'] = $row->pdn_id;
                    DB::table('e_userpdn')->insert($profilePdnRow);	
                }
                $adminHistory_Row['operated_by'] = historyCrypt::encrypt(Auth::user()->uid);
                $adminHistory_Row['operation'] = historyCrypt::encrypt("Insert ".$imsi." into IMSI List(success)");

                DB::table('admin_history')->insert($adminHistory_Row);
                array_push($result, ['imsi'=>$imsi, 'status' => "1"]);  

                $u_dynamic_Row["imsi"] = $imsi;
                $u_dynamic_Row["sqn"] = 0;
                DB::table('u_dynamic')->insert($u_dynamic_Row);
            }
        }
	
        fclose($handle);
        
        $tb = UbaseInfo::all();
        $pdnCount_apnName_Array = array();
        $Euserpdn_Table = Euserpdn::all();
        foreach ($tb as $key => $row) {
            $cnt = 0;
            $apnNames = "";
            foreach($Euserpdn_Table as $value){
            if($row->imsi == $value->imsi){
                $id = $value->pdn_id;
                $apn = Epdn::where('id', $id)->first()->apn;
                $apnNames.=$apn;
                $apnNames.=',';
                $cnt++;
            }
            }
            $pdnCount_apnName_Array[$row->id] = substr($apnNames, 0, strlen($apnNames)-1);
        }
        $quantity = 1;
        $page = 1;
        $data_per_page = 10;
        $sort = 'imsi';
        $order = 'asc';
        $data_size = DB::table("u_baseinfo")->count();
        $tb = DB::table("u_baseinfo")->orderBy($sort, $order)->paginate($data_per_page);
        $permInfo = DB::table('admin_perm')->where('admin_id', '=', Auth::user()->uid)->get();
        
        return view('imsi.imsi', compact('permInfo','tb', 'page' ,'data_per_page', 'data_size', 'pdnCount_apnName_Array', 'order', 'sort', 'result', 'quantity'));
    }
	
	
}
