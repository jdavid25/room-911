<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $table = 'status';

    public function departments(){
        return $this->hasMany('App\Models\Department');
    }

    public function employees(){
        return $this->hasMany('App\Models\Employee');
    }

    public function logs(){
        return $this->hasMany('App\Models\Log');
    }

    public function users(){
        return $this->hasMany('App\Models\User');
    }
}
