<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Udynamic extends Model
{
    // IMSI의 동적정보(u_dynamic)에 대응한 모형클라스 
    protected $table = 'u_dynamic';

    protected $fillable = [
    	'id', 'imsi', 'sqn', 'rand', 'imei', 'imei_sv', 'ms_purged_ps_4g',	
    ];
}
