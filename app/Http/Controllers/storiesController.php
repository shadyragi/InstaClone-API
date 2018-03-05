<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Story;

use App\Post;

use App\User;

class storiesController extends Controller
{
    //


    public function index(Request $request) {


    	$user = User::findOrFail($request->id);

    	return ["stories" => $user->storiesOfFollowings()];

    }

    public function store(Request $request) {


    	$id = $request->id;

    	$user = User::findOrFail($id);


    	if($request->file("image")->isValid()) {

    		$path = (string)$request->file("image")->move("photos");

    		if($user->hasStory()) {

    			$user->stories()->delete();

    		}

    		if($user->stories()->create(["image" => $path])) {

    			return ["message" => "story Added"];
    		}

    		return ["message" => "error"];

    		


    }
}
}
