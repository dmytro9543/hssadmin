<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Epdn extends Model
{
    //PDN정보(e_pdn)에 대응한 모형클라스
    protected $table = 'e_pdn';

    protected $fillable = [
    	'id', 'apn', 'pdn_type', 'pdn_ipv4', 'pdn_ipv6', 'aggregate_ambr_ul', 'aggregate_ambr_dl', 'qci', 'priority_level', 'pre_emp_cap', 'pre_emp_vul', 'LIPA_Permissions',
    ];
}
