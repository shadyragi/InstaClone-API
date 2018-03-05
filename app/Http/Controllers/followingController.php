<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

class followingController extends Controller
{
    

    public function store(Request $request, User $user) {


    	$id = $request->id;

    	$followingUser = User::find($id);

    	if($follow = $user->followers()->create(["follower_id" => $followingUser->id])) {

    		$user["followed"] = true;

    		return ["message" => "followed", "user" => $user];
    	}

    	else {

    		return ["message" => "error in following user"];
    	}


    }
}
