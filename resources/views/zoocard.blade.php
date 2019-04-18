@extends('layouts.app')
@section('content')
    <h1>Singapore Zoo Card Booking</h1>
    @if(count($zoocards) > 0)
        @foreach($zoocards as $zoocard)
<br>
            <div class="p-3 border border-info rounded bg-white">
            <div class="media" >
                <div class="media-left">
                    <a href="#">
                        <img class="align-self-center mr-3"  src="{{'storage/avatars/' . $zoocard->userprofile[0]->avatar}}" alt="photo" width="80px" height="90px">
                    </a>
                </div>
                <div class="media-body">
                     <h4 class="mt-0 mb-0">Reserved by {{$zoocard->name}}  </h4> <small >On {{$zoocard->created_at->format('d/M/y')}}</small>



                    <div class="float-right">
                            @if($zoocard->status == 'C')
                                <a  href="{{asset('zoocard')}}/{{$zoocard->user_id}}/edit" class="btn btn-primary float-right">Reinstate Booking</a>
                            @else
                                <a  href="{{asset('zoocard')}}/{{$zoocard->user_id}}/edit" class="btn btn-danger float-right">Cancel Booking</a>
                            @endif

                    </div>
                    <p>For: <b>{{$zoocard->fordate->format("D, d M, Y")}}</b></p>
                </div>
            </div>
            </div>
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