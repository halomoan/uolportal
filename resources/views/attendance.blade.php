@extends('layouts.app')
@section('content')
    <h1>Attendance Management</h1>

@endsection

@section('sidebar')
    @parent
    <h3>Create An Event</h3>
    <form method="POST" action="{{asset('zoocard')}}">
        {{ csrf_field() }}


        <div class="form-group">

            <selectuser></selectuser>
        </div>
        <div class="form-group">
            <label for="fordate">For Date :</label>
            <bookingdate></bookingdate>

        </div>

        <button type="submit" class="btn btn-primary">Submit</button>

    </form>
@endsection