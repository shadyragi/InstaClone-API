<?php




function checkApiToken($apiToken) {

	if(session()->get("token") == $apiToken) {

		return true;
	}

	return false;

}


?>