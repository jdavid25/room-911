@extends('welcome')
 
@section('title', 'Room 911')

@section('content')
    <h1>Room 911</h1>
    <p>Hello {{$employee->name}} {{$employee->lastname}}</p>
@endsection