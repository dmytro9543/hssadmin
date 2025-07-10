<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Uauth extends Model
{
    // IMSI의 인증정보(u_auth)에 대응한 모형클라스
    protected $table = 'u_auth'; 

    protected $fillable = [
    	'id', 'imsi', 'k', 'op', 'opc', 'allocuser',
    ];
}
