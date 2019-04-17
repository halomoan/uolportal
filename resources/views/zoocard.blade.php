@extends('layouts.app')
@section('content')
    <h1>Singapore Zoo Card Booking</h1>
    @if(count($zoocards) > 0)
        @foreach($zoocards as $zoocard)

            <div class="card">
                <div class="card-body">
                <h4 class="card-title"> Booked by {{$zoocard->name}} </h4>
                <div class="card-subtitle mb-3 text-muted"><small>On {{$zoocard->created_at->format('d/M/y')}}</small></div>

                <div class="row">
                        <div class="col-8">
                            <h5>For: <b>{{$zoocard->fordate->format("D, d M, Y")}}</b></h5>
                        </div>
                        <div class="col-4">
                            @if($zoocard->status == 'C')
                                <a href="{{asset('zoocard')}}/{{$zoocard->user_id}}/edit" class="btn btn-primary float-right">Reinstate Booking</a>
                            @else
                                <a href="{{asset('zoocard')}}/{{$zoocard->user_id}}/edit" class="btn btn-danger float-right">Cancel Booking</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <br>

        @endforeach

        {{$zoocards->links()}}
    @else
        <p>No Bookings found</p>

    @endif
@endsection

@section('sidebar')
    @parent
    <h3>Create A Booking</h3>
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