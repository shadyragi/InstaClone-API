<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;


use App\Post;

use App\Follower;

use App\Story;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    
    public function posts() {

        return $this->hasMany("App\Post");
    }

    public function stories() {

        return $this->hasOne("App\Story", "user_id");
    }

    public function hasStory() {

        if($this->stories()->count() == 1) {

            return true;
        }

        return false;
    }

    public function followers() {

        return $this->hasMany("App\Follower");
    }

    
    public function followings() {

        return $this->hasMany("App\Follower", "follower_id");
    }

    public function storiesOfFollowings() {

        $followings = $this->followings;

        $stories = [];

        foreach ($followings as $key => $following) {
            # code...

            $user = $following->user;

            if($user->hasStory()) {



                $stories[] = $user->stories()->with("user")->first();
            }


        }

       return $stories;
    }


    public function isFollowing(User $user) {

        if ($user->followers()->where([

            ["follower_id", "=", $this->id],

            ["user_id", "=", $user->id]

        ])->first()) {

            return true;

        }

            return false;

    }


}
