<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class UbaseInfo extends Model
{
    // IMSI의 기본정보(u_baseinfo)에 대응한 모형클라스
    protected $table = 'u_baseinfo';

    protected $fillable = [
    	'id', 'imsi', 'msisdn', 'rau_tau_timer', 'ue_ambr_ul', 'ue_ambr_dl', 'subscriber_status',
    ];
}
