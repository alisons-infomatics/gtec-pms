<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class job_role extends Model
{
    protected $table = 'job_roles';
    protected $guarded = [];

    public function GetDept()
    {
        return $this->belongsTo(department::class, 'dept_id', 'id');
    }
}
