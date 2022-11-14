<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeModule extends Model
{
    use HasFactory;

    protected $table = 'employees_modules';
     
    protected $fillable = [
        'employee_id',
        'module_id',
        'status_id'
    ];
    
    public function employees(){
        return $this->belongsTo('App\Models\Employee');
    }
    
    public function modules(){
        return $this->belongsTo('App\Models\Module');
    }

    public function status(){
        return $this->belongsTo('App\Models\Status');
    }
}
