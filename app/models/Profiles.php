<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Profiles extends Model
{
    //프로화일정보(profiles)에 대응한 모형클라스
    protected $table = 'profiles';

    protected $fillable = [
    	'id', 'name', 'subscriber_status', 'odb', 'rau_tau_timer', 'access_restriction', 'ue_ambr_ul', 'ue_ambr_dl',
    ];
}
