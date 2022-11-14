@extends('welcome')
 
@section('title', 'Create Employee')

@section('content')
    <p>Please upload a css file in the following format. <small>(Without column names)</small></p>
    
    <div class="row">
        <div class="col-md-4">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Lastname</th>
                    <th scope="col">Department ID</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>John</td>
                        <td>Doe</td>
                        <td>1</td>
                    </tr>
                    <tr>
                        <td>....</td>
                        <td>....</td>
                        <td>....</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <form method="POST" enctype="multipart/form-data" action="{{route('employees.store.massive')}}">
        @csrf
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="csvEmployee" class="form-label">Upload file</label>
                        <input type="file" class="form-control" id="csvEmployee" name="csvEmployee">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>
@endsection