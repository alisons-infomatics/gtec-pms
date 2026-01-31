<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentInterviewStage extends Model
{
    protected $table = 'student_interview_stages';

    protected $fillable = [
        'student_id',
        'interview_id',
        'stage',
        'status',
        'remarks',
        'updated_at',
    ];

    public $timestamps = false;

  
    public function student()
    {
        return $this->belongsTo(student::class);
    }

    public function interview()
    {
        return $this->belongsTo(interview::class, 'interview_id');
    }
}
