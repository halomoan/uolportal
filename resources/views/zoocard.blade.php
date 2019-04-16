@extends('layouts.app')
@section('content')
    <h1>Singapore Zoo Card Booking</h1>
    @if(count($zoocards) > 0)
        @foreach($zoocards as $zoocard)

            <div class="card">
                <div class="card-body">
                <h4 class="card-title"> Booked by {{$zoocard->requester}} </h4>
                <h6 class="card-subtitle mb-2 text-muted">On {{$zoocard->created_at->format('d/M/y')}}</h6>
                <div class="row">
                        <div class="col-8">
                            <p>For {{$zoocard->fordate->format("D, d M, Y")}}</p>
                        </div>
                        <div class="col-4">
                            @if($zoocard->status == 'C')
                                <a href="/zoocard/{{$zoocard->id}}/edit" class="btn btn-primary float-right">Reinstate Booking</a>
                            @else
                                <a href="/zoocard/{{$zoocard->id}}/edit" class="btn btn-danger float-right">Cancel Booking</a>
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
        <requester></requester>
    @endif
@endsection

@section('sidebar')
    @parent
    <h3>Create A Booking</h3>
    <form method="POST" action="/zoocard">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="requester">Requester Name :</label>
            <input type="text" class="form-control" aria-label="Requester" name="requester" id="requester" autocomplete="off">
        </div>
        <div class="form-group">

        </div>
        <div class="form-group">
            <label for="fordate">For Date :</label>
            <bookingdate></bookingdate>

        </div>

        <button type="submit" class="btn btn-primary">Submit</button>

    </form>
@endsection