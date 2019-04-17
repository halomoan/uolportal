<?php

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('/requester',function(){
    $query = Input::get('query');
    $users = User::where('name','like','%'.$query.'%')->get();

    $data = [];

    foreach($users as $user){

        $data[] = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $user->userprofile->avatar,
            'bukrs' => $user->userprofile->bukrs,
            'company' => $user->userprofile->company->name,
            'department' => $user->userprofile->department->name,
            'position' => $user->userprofile->position->name,
        ];
    }
    return response()->json($data);
});