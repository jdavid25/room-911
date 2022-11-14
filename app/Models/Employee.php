<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
     
    protected $fillable = [
        'name',
        'lastname',
        'department_id',
        'status_id'
    ];
    
    public function logs(){
        return $this->hasMany('App\Models\Log');
    }
    
    public function employees_modules(){
        return $this->hasMany('App\Models\EmployeeModule');
    }

    public function department(){
        return $this->belongsTo('App\Models\Department');
    }

    public function status(){
        return $this->belongsTo('App\Models\Status');
    }
    
}
