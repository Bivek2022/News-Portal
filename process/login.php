<?php
require '../../config/init.php';
//debug($_POST,true);

$user = new User();
if(isset($_POST) && !empty($_POST)){
	$user_name = filter_var($_POST['email'],FILTER_VALIDATE_EMAIL);
	if(!$user_name){
		redirect('../','error','Invalid username format. Username should be email type.');
	}
	$password = sha1($user_name.$_POST['password']);

	$user_info = $user->getUserByUserName($user_name);

	if(isset($user_info) && !empty($user_info)){

		if($password == $user_info[0]->password){
			
			if($user_info[0]->status == 'Active'){
				
				$_SESSION['user_id'] = $user_info[0]->id;
				$_SESSION['name'] = $user_info[0]->full_name;
				$_SESSION['email'] = $user_info[0]->email;
				$_SESSION['role'] = $user_info[0]->role;

				$token = generateRandomStr(100);
				$_SESSION['token'] = $token;

				if(isset($_POST['remember'])){
					setcookie('_au', $token, (time()+864000), "/");
				}
				$data = array(
					'remember_token' => $token
				); //"remember_token = '".$token."'";

				$user->updateUser($data, $user_info[0]->id);

				redirect('../dashboard.php', 'success', 'Welcome to admin panel!');
			} else {
				redirect('../', 'error', 'Your account is not activated yet.');
			}
		} else {
			redirect('../', 'error', 'Invalid Password.');
		}
		
	} else {
		redirect('../', 'error', 'User not found.');
	}

} else {
	redirect('../', 'error', 'Unauthorized access.');
}