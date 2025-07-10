<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Terminal extends Model
{
    //말단정보(terminal_info)에 대응한 모형클라스
    protected $table = 'terminal_info';

    protected $fillable = [
    	'imei', 'sv', 'status',
    ];
}
