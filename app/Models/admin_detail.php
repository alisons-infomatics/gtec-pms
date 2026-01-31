<?php


namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class admin_detail extends Authenticatable
{
    use HasFactory;

    protected $table = 'admin_details';
    protected $guarded = [];

    public function GetType()
    {
        return $this->belongsTo(user_type::class, 'user_type', 'id');
    }
    
    public function GetDept()
    {
        return $this->belongsToMany(department::class, 'dept_id');
    }

}

