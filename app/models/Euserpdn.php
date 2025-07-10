<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Euserpdn extends Model
{
    //e_userpdn표에 대응한 모형클라스
    protected $table = 'e_userpdn';

    protected $fillable = [
    	'id', 'imsi', 'pdn_id',
    ];
}
