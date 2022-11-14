<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use App\Models\Department;
use App\Models\EmployeeModule;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PDF;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // check if the user has logged in
        if(!auth()->check()){
            return redirect('/');
        }

        // check if the user has the right rol
        if(!auth()->user()->hasRole('admin_room_911')){
            return redirect('/');
        }

        $departments = Department::where('status_id',config('constants.active'))->get();
        $employees = Employee::where('status_id',config('constants.active'))->paginate(5);
        return view('module-admin-room-911',['employees' => $employees,'departments' => $departments]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::where('status_id',config('constants.active'))->get();
        return view('create-employee',['departments' => $departments]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'department' => 'required|string'
        ]);

        $employee = Employee::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'department_id' => $request->department,
            'status_id' => config('constants.active')
        ]);

        EmployeeModule::create([
            'employee_id' => $employee->id,
            'module_id' => config('constants.module_room_911_id'),
            'status_id' => config('constants.active')
        ]);

        return redirect('/employees')->with('success','The user has been created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $departments = Department::where('status_id',config('constants.active'))->get();
        return view('edit-employee',['employee' => $employee, 'departments' => $departments]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'department_id' => 'required|string'
        ]);

        $employee->update($request->all());
        return redirect('/employees')->with('success','The user has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->status_id = config('constants.deleted');
        $employee->save();
        return redirect('/employees')->with('success','The user has been deleted');
    }

    public function change(Employee $employee)
    {
        $employee_module = EmployeeModule::where([
            ['employee_id',$employee->id],
            ['module_id', config('constants.module_room_911_id')]
            ])->first();
        $employee_module->status_id = $employee_module->status_id == 1 ? config('constants.locked') : config('constants.active');
        $employee_module->save();
        $status = $employee_module->status_id == 1 ? 'Enabled' : 'Disabled';
        return redirect('/employees')->with('success',$employee->name." ".$employee->lastname."'s permit for the room 911 has been ".$status);
    }

    public function create_pdf(Employee $employee){
        $logs = Log::where('employee_id',$employee->id)->get();
        $data = ['employee' => $employee, 'logs' => $logs];
        // share data to view
        view()->share('data',$data);
        $pdf = PDF::loadView('logs', $data);
        // download PDF file with download method
        return $pdf->stream();
    }

    public function create_pdf_all(){
        $logs = Log::orderBy('employee_id')->get();
        $data = ['logs' => $logs];
        // share data to view
        view()->share('data',$data);
        $pdf = PDF::loadView('logs-all', $data);
        // download PDF file with download method
        return $pdf->stream();
    }

    public function create_massive()
    {
        return view('create-massive-employee');
    }

    public function store_massive(Request $request)
    {
        $request->validate([
            'csvEmployee' => 'required|mimes:csv,txt|max:2048'
        ]);
 
        if($file = $request->file('csvEmployee')){
            // if the file exits, we save it in the 'uploads' folder
            $destination_path = 'uploads/';
            $file_name = auth()->user()->id.'-'.date('Y-m-d-H-i-s').".".$file->extension();
            $file->move($destination_path,$file_name);
            $openfile = fopen("uploads/".$file_name, "r");
            
            // read the uploaded file
            while($data = fgetcsv($openfile, null, ",")){
                $newEmployee = Employee::create([
                    'name' => $data[0],
                    'lastname' => $data[1],
                    'department_id' => $data[2],
                    'status_id' => config('constants.active')
                ]);
                $employees_modules = Employeemodule::create([
                    'employee_id' => $newEmployee->id,
                    'module_id' => config('constants.module_room_911_id'),
                    'status_id' => config('constants.active')
                ]);
            }
            fclose($openfile);
        }

        return redirect('/employees')->with('success','The users have been created');
    }

    public function filter(Request $request){
        $where = [['employees.status_id',config('constants.active')]];
        if($request->id != ''){
            $where[] = ['employees.id','=',$request->id];
        }
        if($request->name != ''){
            $where[] = ['employees.name','LIKE',"%".$request->name."%"];
        }
        if($request->lastname != ''){
            $where[] = ['employees.lastname','LIKE',"%".$request->lastname."%"];
        }
        if($request->department != '' && is_numeric($request->department)){
            $where[] = ['employees.department_id','=',$request->department];
        }
        $employees = Employee::selectRaw('employees.*, status.name AS status, departments.name AS dment,COUNT(logs.id) as tlogs')
            ->join('status','employees.status_id','=','status.id')
            ->join('departments','employees.department_id','=','departments.id')
            ->leftJoin('logs','employees.id','=','logs.employee_id')
            ->where($where)
            ->groupBy('employees.id')
            ->get();
        return response()->json($employees);
    }
}
