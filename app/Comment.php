<?php

namespace App;



use Illuminate\Database\Eloquent\Model;

use App\User;

class Comment extends Model
{
    //

    protected $fillable = ["post_id", "user_id", "comment"];

    protected $with = ["user"];


    public function user() {


    	return $this->belongsTo("App\User", "user_id");
    }




}
