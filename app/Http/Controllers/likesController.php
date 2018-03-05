<?php

namespace App\Http\Controllers;

use App\Notifications\likePostNotif;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Post;

use App\User;

class likesController extends Controller
{
    //

    public function store(Request $request, Post $post) {

    	$user = User::findOrFail($request->id);

        $postOwner = $post->user;

    	if(!$post->isLiked($user->id)) {

    	if($post->likes()->create(['user_id' => $user->id])) {

                $postOwner->notify(new likePostNotif($post, $user));
    		
    			$post["isLiked"] = true;

                $post["username"] = $user->name;

                $post["likes_count"]  = $post->likesCount();



    			return ["message" => "liked", "post" => $post];

    	}

    	return ["message" => "not liked"];

    }

    }


}
