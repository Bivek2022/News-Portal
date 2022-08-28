<?php 
	require '../config/init.php';
$user_id = $_SESSION['user_id'];
$user = new User();
$data = array(
	'remember_token' => ''
);
$user->updateUser($data, $user_id);
if(isset($_COOKIE['_au']) && !empty($_COOKIE['_au'])){
	setcookie('_au', '', time()-60, "/");
}
session_destroy();
redirect('./');

?>