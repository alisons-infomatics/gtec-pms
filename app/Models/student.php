<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class student extends Model
{
    protected $table = 'students';
    protected $guarded = [];

    public function GetDept()
    {
        return $this->belongsTo(department::class, 'dept', 'id');
    }
    public function GetCrs()
    {
        return $this->belongsTo(course::class, 'course', 'id');
    }
    public function GetRole()
    {
        return $this->belongsTo(job_role::class, 'dept_id', 'id');
    }
    public function interviewStages()
    {
        return $this->hasMany(StudentInterviewStage::class, 'student_id');
    }
    public function interviews()
    {
        return $this->hasMany(interview::class, 'student_id');
    }
}
