<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    // 관리자표(users)에 대응한 모형클라스이다. 
    protected $table = 'users';

    protected $fillable = [
    	'id', 'uid', 'name', 'email', 'password',
    ];
}
