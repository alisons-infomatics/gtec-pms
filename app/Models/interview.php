<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class interview extends Model
{
    protected $table = 'interviews';
    protected $guarded = [];

    public function GetEmp()
    {
        return $this->belongsTo(employer::class, 'employer', 'id');
    }
    public function GetRole()
    {
        return $this->belongsTo(job_role_list::class, 'job_role', 'id');
    }
    public function jobRole()
{
    return $this->belongsTo(job_role_list::class, 'job_role');
}
    public function GetStd()
    {
        return $this->belongsTo(student::class, 'student_id', 'id');
    }
}
