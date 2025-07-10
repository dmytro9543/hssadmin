<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Profilepdn extends Model
{
    //프로화일에 설정된 PDN정보에 대응한 모형클라스(profilepdn)
    protected $table = 'profilepdn';

    protected $fillable = [
    	'id', 'profile_id', 'pdn_id',	
    ];
}
