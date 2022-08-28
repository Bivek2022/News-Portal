<?php 

	function debug($data, $is_exit=false){
		echo "<pre>";
		print_r($data);
		echo "</pre>";
		if($is_exit){
			exit;
		}
	}

function redirect($path, $msg_key = null, $msg = null){
	if($msg_key != null){
		$_SESSION[$msg_key] = $msg;
	}
	@header('location:  '.$path);
	exit;
}


function flash(){
	if(isset($_SESSION['success']) && !empty($_SESSION['success'])){
		echo "<p class='alert alert-success'>".$_SESSION['success']."</p>";
		unset($_SESSION['success']);
	}
	if(isset($_SESSION['error']) && !empty($_SESSION['error'])){
		echo "<p class='alert alert-danger'>".$_SESSION['error']."</p>";
		unset($_SESSION['error']);
	}
	if(isset($_SESSION['warning']) && !empty($_SESSION['warning'])){
		echo "<p class='alert alert-warning'>".$_SESSION['warning']."</p>";
		unset($_SESSION['warning']);
	}
	if(isset($_SESSION['info']) && !empty($_SESSION['info'])){
		echo "<p class='alert alert-info'>".$_SESSION['info']."</p>";
		unset($_SESSION['info']);
	}
}

function generateRandomStr($length = 100){
	$chars = "0123456789abcdefghijklmnopqrxtuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$str_leng = strlen($chars);

	$random = "";
	for($i=0; $i<$length; $i++){
		$random .= $chars[rand(0, ($str_leng-1))];
	}

	return $random;
}

function sanitize($str){
	// $str = addslashes($str);	//
	$str = strip_tags($str);	// Remove tags
	$str = trim($str);	// Remove Multiple spaces
	// $str = stripslashes($str); // remove slashes
	return $str;
}

function uploadFile($file, $upload_dir){
	if($file['error'] == 0){
		$ext = pathinfo($file['name'], PATHINFO_EXTENSION);	// file extension returns
		if(in_array(strtolower($ext), ALLOWED_IMAGE_EXTENSION)){
			if($file['size'] <= 5000000){

				$path = UPLOAD_PATH.$upload_dir;
				if(!is_dir($path)){
					mkdir($path, true, '777');
				}
				// Category-2018123008440012.ext
				$file_name = ucfirst($upload_dir)."-".date('Ymdhis').rand(0, 99).".".$ext;
				$success = move_uploaded_file($file['tmp_name'], $path."/".$file_name);
				if($success){
					return $file_name;
				} else {
					return false;
				}

			} else {
				return false;
			}
		} else {
			return false;
		}
	} else {
		return false;
	}
} 
function getYouTubeVideoId($url){
	// https://www.youtube.com/embed/ihxU7VUG1XA
	// https://www.youtube.com/watch?v=ihxU7VUG1XA
	// https://www.youtu.be/ihxU7VUG1XA
	// https://m.youtube.com/

	preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches);
	return $matches[1];
	// parse_str(parse_url($url, PHP_URL_QUERY), $match);
/*	debug($matches);
	echo $url;*/
}
function getCurrentUrl(){
	$url = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	return $url;
}
function getCurrentPage(){
	 return pathinfo($_SERVER['PHP_SELF'],PATHINFO_FILENAME);
}
?>