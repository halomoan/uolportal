@extends('layouts.app')
@section('content')
    <h1>Attendance Management</h1>

@endsection

@section('sidebar')
    @parent
    <h3>Create An Event</h3>
    <form method="POST" action="{{asset('attendance')}}">
        {{ csrf_field() }}


        <div class="form-group">

        </div>
        <button type="submit" class="btn btn-primary">Submit</button>

    </form>
@endsection