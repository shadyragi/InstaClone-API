<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

class notificationsController extends Controller
{
    //

    public function index(Request $request) {

    	$user = User::findOrFail($request->id);

    	



    	return ["notifications" => $user->notifications];


    }	
}
