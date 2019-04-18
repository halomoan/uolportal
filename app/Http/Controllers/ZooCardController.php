<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ZooCard;

class ZooCardController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $today = date('Y-m-d');
        $zoocards = ZooCard::join('users',function($join) use($today){
           $join->on('users.id','=','zoo_cards.user_id')
               ->where('fordate','>=', $today);
        })->orderBy('fordate')->paginate(2);

       /* $zoocards = User::whereHas('zoocards',function($query) use($today) {
              $query->where('fordate','>=', $today)->orderBy('fordate');
        })->paginate(2);;*/

        return view('zoocard')->with('zoocards',$zoocards);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'requester' => 'required',
            'fordate' => 'required'
        ]);

        $zoocard = new ZooCard;

        $zoocard->user_id = $request->input('requester');

        $fordate = \DateTime::createFromFormat("D, d M, yy", $request->input('fordate'));
        if ($fordate) {
            $zoocard->fordate = $fordate->format("Y-m-d");
        }

        $zoocard->status = '';

        $zoocard->save();

        $zoocards = Zoocard::orderBy('fordate')->paginate(2);
        return redirect('zoocard')->with('zoocards',$zoocards);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $zoocard = Zoocard::where('user_id','=',$id)->firstOrFail();

        if ($zoocard->status == 'C') {
            $zoocard->status = '';
        } else {
            $zoocard->status = 'C';
        }
        $zoocard->save();

        $zoocards = Zoocard::orderBy('fordate')->paginate(2);
        return redirect('zoocard')->with('zoocards',$zoocards);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
