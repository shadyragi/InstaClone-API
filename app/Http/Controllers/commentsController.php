<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Gate;

use App\Http\Requests;

use App\Post;

use App\User;

use App\Comment;

class commentsController extends Controller
{
    //

    public function store(Request $request, Post $post) {

    	$user = User::findOrFail($request->id);

    	$comment = $request->comment;

    	if($comment = $post->comments()->create(["user_id" => $user->id, "comment" => $comment])) {

            

    		$comment["user"] = $user;

    		$comment["isOwner"] = true;

    		return ["message" => "comment added", "comment" => $comment];
    	}
    	else {

    		return ["message" => "error in adding comment"];
    	}
    }

    public function index(Request $request, Post $post) {

    	$user = User::findOrFail($request->id);

    	if($post->comments()->count() > 0) {

    		$comments = $post->comments;

    		foreach ($comments as $key => $comment) {
    			# code...

    			if(Gate::forUser($user)->allows("delete-comment", $comment)) {

    				$comment["isOwner"] =  true;
    			}
    			else {

    				$comment["isOwner"] = false;
    			}
    		}

    		return ["comments" => $comments];
    	}


    }

    public function destroy(Request $request, Comment $comment) {

    	$user = User::findOrFail($request->id);

    	if(Gate::forUser($user)->allows("delete-comment", $comment)) {

    		if($comment->delete()) {

    		return ["message" => "comment deleted"];
    	}
    	}

    	

    }
}
