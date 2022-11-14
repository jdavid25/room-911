@extends('welcome')
 
@section('title', 'Access room 911')

@section('content')
    <h1 class="text-center">Room 911 authentication</h1>
    <form method="POST" action="/room_911">
        @csrf
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="row">       
                    <div class="col-md-12 mb-3">
                        <label for="id_employee" class="form-label">ID</label>
                        <input type="text" class="form-control" id="id_employee" name="id_employee">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>
@endsection