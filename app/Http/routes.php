<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get("api/lessons", function() {

		$lessons = ["first Lesson" => "lesson1", "seond Lesson" => "lesson2", "third Lesson" => "lesson3"];

		return $lessons;
});



Route::auth();



Route::post("api/upload", "postsController@upload");

Route::get("test", "authController@test");

Route::get("api/checkCredentials", "authController@check");

Route::post("api/register", "authController@register");

Route::post("api/post", "postsController@store");

Route::get("api/post", "postsController@index");

Route::delete("api/post/{post}", "postsController@destroy");

Route::post("api/{post}/like", "likesController@store");

Route::get("api/user/{username}", "searchController@show");

Route::post("api/follow/{user}", "followingController@store");

Route::post("api/{post}/comment", "commentsController@store");

Route::get("api/{post}/comment", "commentsController@index");

Route::delete("api/comment/{comment}", "commentsController@destroy");

Route::post("api/story", "storiesController@store");

Route::get("api/story", "storiesController@index");

Route::get("api/notifications", "notificationsController@index");





/*Route::get("api/checkCredentials", function(Request $request) {

	$email = $request->query()["email"];
	$password = $request->query()["password"];

	if($email == "shady@yahoo.com" AND $password == "123456") {
		return ["message" => "exist"];
	}

	return ["message" => "not exist"];
});*/