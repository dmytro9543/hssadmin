<?php

namespace App\Http\Controllers\imsi;

use Illuminate\Http\Request;
use App\models\Profiles;
use App\models\Profilepdn;
use App\models\Epdn;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\historyCrypt;

class ProfileController extends Controller
{
    public function index(Request $request){
        $page = $request->get('page', 1);
        $data_per_page = $request->get('myselect', 10);
        $gettype = $request->get('gettype', null);
        $order = $request->get('order', 'asc');
        $sort = $request->get('sort', 'name');
        $value = $request->get('value', null);
        $pdnCounts = array();
        $tb = Profiles::all();
        $Profilepdn_Table = Profilepdn::all();
       	foreach ($tb as $key => $row) {
       		# code...
       		$cnt = 0;
       		foreach($Profilepdn_Table as $value){
       		if($row->id == $value->profile_id)
       		 $cnt++;
       		}
       		$pdnCounts[$row->id] = $cnt;
       	}
       	$data_size = $tb->count();
        $tb = DB::table('profiles')->orderBy($sort, $order)->paginate($data_per_page);
        $permInfo = DB::table('admin_perm')->where('admin_id', '=', Auth::user()->uid)->get();
        
        if($gettype != null)
          return view('imsi.profilecontent', compact('permInfo', 'data_per_page', 'data_size', 'tb', 'pdnCounts', 'order', 'sort', 'page'));
        return view('imsi.profile', compact('permInfo', 'data_per_page', 'order', 'sort', 'tb','data_size', 'pdnCounts', 'page'));
    }

    public function getProfileInfo(Request $request){
       $id = $request->get('id', 0);
       $profileInfo = Profiles::where('id', $id)->get();
       return json_encode($profileInfo);
    }
    
    public function getApn(Request $request){
         $profile_id = $request->get('id',0);
         $isEmpty = count(DB::table('profilepdn')->where('profile_id', '=', $profile_id)->get());
         $pdnidArray = array();
         
         if($profile_id !=0 && $isEmpty>0){//If update and  data count isn't zero 
               $pdn_id = DB::table('profilepdn')->select('pdn_id')->where('profile_id', '=', $profile_id)->get();
               $idjsonData = json_encode($pdn_id);
               $tmp = explode(',', substr($idjsonData, 1, strlen($idjsonData)-2));
               for($i=0; $i<count($tmp); $i++){
                       $id = explode(':', substr($tmp[$i], 1, strlen($tmp[$i])-2))[1];
                       $pdnid = DB::table('e_pdn')->select('id')->where('id', '=', $id)->get();
                       array_push($pdnidArray, $pdnid);
                }
        }
         $data_To_Send = array();
         $e_pdn_Table = Epdn::all();
         foreach ($e_pdn_Table as $key => $row) {
          # code...
                $val['apn'] = $row->apn;
                $val['selected'] = 0;
                if($profile_id != 0 && $isEmpty>0){
                    foreach ($pdnidArray as $key => $pdnid) {
                     # code...
                     $tmpName = explode(',', substr(json_encode($pdnid), 1, strlen(json_encode($pdnid))-2));
                     $pdn = explode(':', substr($tmpName[0], 1, strlen($tmpName[0])-2))[1];
                     if(intval($pdn) == $row->id){
                             $val['selected'] = 1;
                             break;
                          }
                  }
            }
                array_push($data_To_Send, $val);
          }
         return json_encode($data_To_Send);
       
    }
    
    public function saveProfileInfo(Request $request){
        $id = $request->get('id', 0);
        $name = $request->get('name', "");
        $subscriber_status = $request->get('subscriber_status',"");
        $rau_tau_timer = $request->get('rau_tau_timer', "");
        $ue_ambr_ul = $request->get('ue_ambr_ul',"");
        $ue_ambr_dl = $request->get('ue_ambr_dl', "");
        $ue_ambr_dl = $request->get('ue_ambr_dl', "");
        $checkBoxStates = $request->get('checkBoxStates', array());
        
        if(empty($name)){
            $err['errorName']='profileName field empty';
            $err['errorcode']='4001';
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
        if(count($checkBoxStates) == 0){
            $err['errorName']='pdnList not check';
            $err['errorcode']='4004';
            return json_encode($err);
        }

        $ProfileData['name'] = $name;
        $ProfileData['subscriber_status'] = $request->get('subscriber_status','SERVICE_GRANTED');
        $ProfileData['rau_tau_timer'] = $request->get('rau_tau_timer',120);
        $ProfileData['ue_ambr_ul'] = $request->get('ue_ambr_ul',50000000)*1024*1024;
        $ProfileData['ue_ambr_dl'] = $request->get('ue_ambr_dl',100000000)*1024*1024;
        $repeatedProfileCount = DB::table('profiles')->where('name', '=', $name)->get();
        $profile_id = 0;
        if($id == 0){//Add
          if(count($repeatedProfileCount) >= 1){
            
            $adminHistory_Row['operated_by'] = historyCrypt::encrypt(Auth::user()->uid);
            $adminHistory_Row['operation'] = historyCrypt::encrypt("Insert ".$name." into Profile List(failed)");
            DB::table('admin_history')->insert($adminHistory_Row);

            $err['errorName']='duplicate profileName';
            $err['errorcode']='4005';
            return json_encode($err);
          }
          $profile_id = DB::table('profiles')->insertGetId($ProfileData);
          $adminHistory_Row['operated_by'] = historyCrypt::encrypt(Auth::user()->uid);
          $adminHistory_Row['operation'] = historyCrypt::encrypt("Insert ".$name." into Profile List(success)");
          DB::table('admin_history')->insert($adminHistory_Row);
        }
        else{//Update Profile
           $df = $request->get('isDifferent');
           if($df != 0 && count($repeatedProfileCount) >= 1){
              $adminHistory_Row['operated_by'] = historyCrypt::encrypt(Auth::user()->uid);
              $adminHistory_Row['operation'] = historyCrypt::encrypt("Edit ".$name." in Profile List(failed)");
              DB::table('admin_history')->insert($adminHistory_Row);
              
             $err['errorName']='duplicate profileName';
             $err['errorcode']='4005';
             return json_encode($err);
           }
           DB::table('profiles')->where('id','=',$id)->update($ProfileData);
           
           $adminHistory_Row['operated_by'] = historyCrypt::encrypt(Auth::user()->uid);
           $adminHistory_Row['operation'] = historyCrypt::encrypt("Edit ".$name." in Profile List(success)");
           DB::table('admin_history')->insert($adminHistory_Row);
           
           $profile_id = $id;
           //Profiles Table and ProfilePdn Table
           DB::table('profilepdn')->where('profile_id', '=', $id)->delete();
        }
        
        $epdnTable = Epdn::all();
        for($i=0; $i<count($epdnTable); $i++) {
            if($checkBoxStates[$i] == 'true'){
              $str = explode(',',json_encode($epdnTable[$i]));
              $pdn_id =  explode(':',$str[0])[1];
              $profilepdnData['profile_id'] = $profile_id;
              $profilepdnData['pdn_id'] = $pdn_id;
              DB::table('profilepdn')->insert($profilepdnData);
            }
        }
        $err['errorName']='success';
        $err['errorcode']='1';
        return json_encode($err);
    }
    
    public function deleteProfileInfo(Request $request){
      $id = $request->get('id');

      $name = DB::table('profiles')->where('id', '=', $id)->first()->name;
      $adminHistory_Row['operated_by'] = historyCrypt::encrypt(Auth::user()->uid);
      $adminHistory_Row['operation'] = historyCrypt::encrypt("Delete ".$name." in Profile List(success)");
      DB::table('admin_history')->insert($adminHistory_Row);

      DB::table('profiles')->where('id', '=', $id)->delete();
      DB::table('profilepdn')->where('profile_id', '=', $id)->delete();

      $err['errorName']='success';
      $err['errorcode']='1';
      return json_encode($err);
    }
    
    public function changeDefault(Request $request){
        $id = $request->get('id');
        DB::table('profiles')->where('isDefault', '=', 1)->update(['isDefault'=>0]);
        DB::table('profiles')->where('id', '=', $id)->update(['isDefault'=>1]);
        $err['errorName']='success';
        $err['errorcode']='1';
        return json_encode($err);
    }

}



