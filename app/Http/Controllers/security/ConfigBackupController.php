<?php

namespace App\Http\Controllers\security;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class ConfigBackupController extends Controller
{

   public function index(Request $request){
		$permInfo = DB::table('admin_perm')->where('admin_id', '=', Auth::user()->uid)->get();
		return view('security.configBackup',compact('permInfo'));
    }
    
    public function backup(Request $req){
        $path = storage_path().'/tmp.sql';
        $filename = "hssdb_".date("YmdHi").".sql";

        exec('sudo mysqldump hssdb >' .$path, $res, $ret);

        header('Content-type: text/sql');
        header('Content-Disposition: attachment; filename="'.$filename.'"');

        readfile($path);
    }
    
    public function restore(Request $req){
        if ($_FILES['sqlfile']['error'] == 0)
        {
            $filename = $_FILES['sqlfile']['name'];
            $tok = strtok($filename, "\.");
            while($tok){
                $prev = $tok;
                $tok = strtok("\.");
            }
            //$filePath = storage_path()."/app/upload/".$filename;
            //print_r($filePath);exit;
            if($prev == "sql"){
                $filePath = storage_path()."/upload/tmp.sql";
                if(move_uploaded_file($_FILES['sqlfile']['tmp_name'], $filePath))
                {
                    exec('sudo mysql hssdb < ' .$filePath, $res, $ret);
                    unlink($filePath);
                    echo "<script>alert('Database successfully restored.');</script>";
                    echo "<script>location.href='/configBackup';</script>";
                    exit();
                }
            }
        }
    }

}