<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class job_role_list extends Model
{
    protected $table = 'job_role_lists';
    protected $guarded = [];

    public function GetCom()
    {
        return $this->belongsTo(employer::class, 'company_id', 'id');
    }
   
}
