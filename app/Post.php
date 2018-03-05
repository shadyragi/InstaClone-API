<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Like;

use App\User;

use App\Comment;

class Post extends Model
{
    //

    protected $fillable = ["caption", "image", "location"];

    protected $with = ["comments"];


    public function likes() {

    	return $this->hasMany("App\Like");
    }


    public function comments() {

        return $this->hasMany("App\Comment", "post_id");
    }


    public function hasComments() {

        return $this->comments()->count();
    }

    public function addLike($id) {

    	$this->likes()->create(["user_id" => $id]);
    }

    public function likesCount() {

        return $this->likes()->count();
    }

    public function user() {

        return $this->belongsTo("App\User", "user_id");

    }

    public function isLiked($user_id) {


    	if($like = $this->likes()->where("user_id", $user_id)->first()) {
    		return true;
    	}

    	return false;

    }

    public function isOwner($user_id) {

        if($this->user_id == $user_id) {


            return true;

        }

        return false;

    }

}
