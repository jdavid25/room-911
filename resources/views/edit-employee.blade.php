@extends('welcome')
 
@section('title', 'Create Employee')

@section('content')
    <form method="POST" action="/employees/{{$employee->id}}">
        @csrf
        @method('PUT')
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{$employee->name}}">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="lastname" class="form-label">Lastname</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" value="{{$employee->lastname}}">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="department" class="form-label">Department</label>
                        <select class="form-select" id="department_id" name="department_id">
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" {{$employee->department_id == $department->id ? 'Selected' : ''}}>{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </form>
@endsection