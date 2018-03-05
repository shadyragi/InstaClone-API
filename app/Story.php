<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

use App\User;

class Story extends Model
{
    //

    protected $fillable = ["user_id", "image"];


    public function user() {

    	return $this->belongsTo("App\User", "user_id");
    }


    protected static function boot() {

    	parent::boot();


    	static::created(function($story) {

    		$eventName = $story->id . "story_event";

    		DB::connection()->getPdo()->exec("

    			CREATE EVENT $eventName
    			ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL 24 HOUR

    			DO 

    			DELETE FROM stories 

    			WHERE id = '$story->id'


    			");

    	});

    }
}
