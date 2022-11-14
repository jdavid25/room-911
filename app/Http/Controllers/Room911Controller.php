<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\EmployeeModule;
use App\Models\Log;

class Room911Controller extends Controller
{
    public function access()
    {
        return view('access-room-911');
    }

    public function validate_access(Request $request){
        $request->validate([
            'id_employee' => 'required'
        ]);

        $employee = Employee::find($request->id_employee);

        $log = [
            'module_id' => config('constants.module_room_911_id'),
            'date' => date('Y-m-d'),
            'time' => date('H:i:s'),
            'employee_id' => $request->id_employee,
            'observation' => 'Ok',
            'status_id' => config('constants.success')
        ];
        
        // validates if the ID is for an existing employee
        if(!$employee){
            $log['observation'] = 'Employee does not exist';
            $log['status_id'] = config('constants.wrong');
            Log::create($log);
            return redirect()->back()->withErrors(['ID' => 'Id not authorized']);
        }
        
        // validates if the employee is active
        if($employee->status_id != config('constants.active')){
            $log['observation'] = 'Employee is not active';
            $log['status_id'] = config('constants.wrong');
            Log::create($log);
            return redirect()->back()->withErrors(['ID' => 'Id not authorized']);
        }
        
        // validates if the employee has room 911 enabled
        if(!EmployeeModule::where([
            ['employee_id',$employee->id],
            ['module_id', config('constants.module_room_911_id')],
            ['status_id', config('constants.active')]
            ])->first()){
            $log['observation'] = 'Not authorized';
            $log['status_id'] = config('constants.wrong');
            Log::create($log);
            return redirect()->back()->withErrors(['ID' => 'Id not authorized']);
        }

        Log::create($log);

        return view('room-911',['employee' => $employee]);

    }
}
