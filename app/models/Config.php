<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    // 설정값들을 보관하는 config표에 대응한 모형클라스
    protected $table = 'config';

    protected $fillable = [
    	'id', 'name', 'value',
    ];
}
