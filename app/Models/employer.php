<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class employer extends Model
{
    protected $table = 'employers';
    protected $guarded = [];
    
     public function createdBy()
    {
        return $this->belongsTo(admin_detail::class,'created_by');
    }
    
    public function contacts()
    {
        return $this->hasMany(employer_contact::class, 'employer_id');
    }
    
    public function latest_enquiry()
    {
        return $this->hasOne(EmployerEnquiry::class, 'employer_id')->latestOfMany();
    }
     
}
