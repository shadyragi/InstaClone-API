<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;

use Illuminate\Support\Facades\Hash;

use Validator;

use App\User;
class authController extends Controller
{
    //

    public function check(Request $request) {

	$data = $request->query();
	
	
	if(Auth::attempt(["email" => $data["email"], "password" => $data["password"]])) {



		$user = User::where("email", $data["email"])->first();

		return ["message" => "exist", "user" => $user];
	}

	else {
		return ["message" => "not exist"];
	}

    }


    public function test() {

    	if($user = Auth::attempt(["email" => "shady@yahoo.com", "password" => "123456"])) {

    		print_r($user);
    	}
    }

   public function register(Request $request) {

   	$validator = Validator::make($request->all(), [
   		"name" => "required",
   		"email" => "required|email",
   		"password" => "required|confirmed"
   	]);

   	$errors = $validator->errors();

   	if(count($errors) > 0) {

   		return ["errors" => $errors];
   	}

   	$name = $request->name;

   	$email = $request->email;

   	$password = Hash::make($request->password);

   	if($user = User::create(["name" => $name, "email" => $email, "password" => $password])) {

   		return ["message" => "registered", "user" => $user];

   	}
   	return ["message" => "error"];

   }
}
