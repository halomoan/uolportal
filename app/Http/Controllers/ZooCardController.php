<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
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
        $zoocards = Zoocard::orderBy('fordate')->paginate(3);
        /*$zoocards = ZooCard::join('users',function($join) use($today){
           $join->on('users.id','=','zoo_cards.user_id')
               ->where('fordate','>=', $today);
        })->orderBy('fordate')->paginate(3);*/

       /* $zoocards = User::whereHas('zoocards',function($query) use($today) {
              $query->where('fordate','>=', $today)->orderBy('fordate');
        })->paginate(2);;*/


        return view('zoocard')->with('zoocards',$zoocards)->with('withsidebar',false);
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

        $fordate = \DateTime::createFromFormat("D, d M, yy", $request->input('fordate'));
        if (!$fordate) {
            return redirect()->back()->with('error','Invalid date');
        } elseif($fordate < (new \DateTime(date('d-m-y'))) ) {

            return redirect()->back()->with('error','Please select future date');
        }

        //Someone reserved the zoo card on the same date
        if (Zoocard::where('fordate', '=', $fordate->format("Y-m-d"))->exists()) {
            return redirect()->back()->with('error','Someone has reserved the zoo card on that date');
        }

        $zoocard = new ZooCard;

        $zoocard->user_id = $request->input('requester');
        $zoocard->fordate = $fordate->format("Y-m-d");


        $zoocard->status = '';

        try {
            $zoocard->save();
        } catch (QueryException $e) {
            $error = $e->errorInfo;


            if ($error[0] == '23000'){
                return redirect()->back()->with('error','The card has been reserved.');
            } else {
                return redirect()->back()->with('error','An error has occurred when saving the data');

            }
        }


        return redirect()->back()->with('success','Reserved successfully');;
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
        $zoocard = Zoocard::findOrFail($id);


        if ($zoocard->status == 'C') {

            if (Zoocard::where('fordate', '=', $zoocard->fordate)->where('status','=','')->exists()) {
                return redirect()->back()->with('error','The card has been reserved by ' . $zoocard->user->name . ' on the same date.');
            }else {
                $zoocard->status = '';
            }
        } else {
            $zoocard->status = 'C';
        }
        $zoocard->save();

        return redirect()->back()->with('success','Updated successfully');

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
