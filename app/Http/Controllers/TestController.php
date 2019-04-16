<?php
/**
 * Created by PhpStorm.
 * User: Halomoan
 * Date: 16/4/2019
 * Time: 9:20 PM
 */

namespace App\Http\Controllers;

use App\User;

class TestController extends Controller
{
    public function index(){
        $user = User::find('1');

        dd($user->department->name);

    }

}