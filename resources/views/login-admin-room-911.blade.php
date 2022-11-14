@extends('welcome')
 
@section('title', 'Login admin room 911')

@section('content')
    <form method="POST" action="/auth">
        @csrf
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="name" class="form-label">Username</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>
@endsection