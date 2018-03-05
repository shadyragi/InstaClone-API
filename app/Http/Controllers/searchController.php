<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

class searchController extends Controller
{
    //


    public function show(Request $request, $username) {

    	$authUser = User::find($request->id);

    	$users = User::where("name", "like", "%$username%")->get();

    	if(count($users) > 0) {

    		foreach($users as $user) {

    			if($authUser->isFollowing($user)) {

    				$user["followed"] = true;

    			}
    			else {
    				$user["followed"] = false;
    			}
    		}

    		return ["message" => "found", "users" => $users];
    	}

    	else {

    		return ["message" => "not found"];
    	}

    }
}
