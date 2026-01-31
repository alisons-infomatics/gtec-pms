<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class course extends Model
{
    protected $table = 'courses';
    protected $guarded = [];

    public function GetDept()
    {
        return $this->belongsTo(department::class, 'dept_id', 'id');
    }
}
