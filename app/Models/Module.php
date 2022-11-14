<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    public function employees_modules(){
        return $this->hasMany('App\Models\EmployeeModule');
    }

    public function status(){
        return $this->belongsTo('App\Models\Status');
    }
}
