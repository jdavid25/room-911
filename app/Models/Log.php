<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
      
    protected $fillable = [
        'module',
        'observation',
        'date',
        'time',
        'module_id',
        'employee_id',
        'status_id'
    ];
        
    public function employee(){
        return $this->belongsTo('App\Models\Employee');
    }

    public function status(){
        return $this->belongsTo('App\Models\Status');
    }
}
