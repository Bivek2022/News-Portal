<?php

$user = new User();
if(!isset($_SESSION['token']) || empty($_SESSION['token'])) {
	if(!empty($_COOKIE['_au'])){
	
		$token = $_COOKIE['_au'];

		$user_info = $user->getUserFromToken($token);
		if(!$user_info){
			session_destroy();
			setcookie('_au', '', time()-60, "/");
			redirect('./');
		}
		$_SESSION['user_id'] = $user_info[0]->id;
		$_SESSION['name'] = $user_info[0]->full_name;
		$_SESSION['email'] = $user_info[0]->email;
		$_SESSION['role'] = $user_info[0]->role;
		$token = generateRandomStr(100);
		$_SESSION['token'] = $token;

		setcookie('_au', $token, (time()+864000), "/");
		$data = array(
			'remember_token' => $token
		); //"remember_token = '".$token."'";

		$user->updateUser($data, $user_info[0]->id);

	} else {
		redirect('./');
	}
}