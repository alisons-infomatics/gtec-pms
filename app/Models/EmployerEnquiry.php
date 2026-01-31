<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployerEnquiry extends Model
{
   
    protected $table = 'employer_enquiry';

  
    protected $fillable = [
        'employer_id',
        'status',
        'created_by',
        'contact_person',
        'contact_number',
        'contact_date',
        'follow_up_date',
        'remarks',
    ];

    
    public function employer()
    {
        return $this->belongsTo(Employer::class, 'employer_id');
    }

    
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
