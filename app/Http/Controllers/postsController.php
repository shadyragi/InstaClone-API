<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;

use Gate;

use App\User;

use App\Post;

class postsController extends Controller
{
    //

    public function index(Request $request) {

    	$id = $request->id;

    	$user = User::findOrFail($id);

        $followings = $user->followings()->with("user")->get();

        //session()->put("token", "123456");

      

       

        $allposts = [];

        foreach ($followings as $key => $following) {
            $postCount = Post::where("user_id", $following->user_id)->count();

            if($postCount >= 1) {

                $posts = Post::withCount("likes")->where("user_id", $following->user_id)->get();

                foreach ($posts as $key => $post) {

                    if($post->isOwner($user->id)) {

                        $post["isOwner"] = true;
                    }

                    else {
                        $post["isOwner"] = false;
                    }
                   
                    $post["username"] = $following->user->name;

                    if($post->isLiked($id)) {
                        $post["isLiked"] = true;
                    }
                    else {
                        $post["isLiked"] = false;
                    }

                    if(count($post["comments"]) > 0) {

                        $post["hasComments"] = true;
                    }
                    else {
                        $post["hasComments"] = false;
                    }
                    $allposts[] = $post;
                }


                
            }

            elseif($postCount == 1){

                $post = Post::withCount("likes")->where("user_id", $following->user_id)->first();

                $post["username"] = $following->user->name;

                if($post->isLiked($id)) {
                    $post["isLiked"] = true;
                }
                else {
                    $post["isLiked"] = false;
                }

                if(count($post["comments"]) > 0) {

                    $post["hasComments"] = true;
                }
                else {

                    $post["hasComments"] = false;
                }
                $allposts[] = $post;
            }
            # code...
        }

        return ["posts" => $allposts];



    }

    public function upload(Request $request) {

        if($request->file("image")->isValid()) {

            $path = $request->file("image")->move("photos");

           

            return ["message" => "uploaded Successfully", "path" => $path];
        }

    }

    public function store(Request $request) {
		
        //return ["message" => "blabla"];

		if(!$user = User::find($request->id)) {
            return ["message" => "user error"];
        }

          if($request->file("image")->isValid()) {
 
            $path = (string)$request->file("image")->move("photos");


        if($post = $user->posts()->create(["caption" => $request->caption, "location" => $request->location ,  "image" => $path])) {

            $post["username"] = $user->name;

            $post["isLiked"]  = false;

            $post["likes_count"] = 0;
            
            $post["isOwner"] = true;

            return ["message" => "stored", "post" => $post];
        }
        else {
            return ["message" => "not stored"];
        }


        }

    }


    public function destroy(Request $request, Post $post) {


        $user = User::findOrFail($request->id);

        if(Gate::forUser($user)->allows("delete-post", $post)) {

            $post->delete();

            return ["message" => "post Has Been Deleted Successfully"];



        }




    }


}
