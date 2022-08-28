<?php
require '../../config/init.php';
require '../inc/checklogin.php';

$video = new Video();
if(isset($_POST) && !empty($_POST)){
	$data = array(
		'title' => sanitize($_POST['title']),
		"summary" => sanitize($_POST['summary']),
		'url' => sanitize($_POST['url']),
		'video_id' => getYouTubeVideoId($_POST['url']),
		'status' => sanitize($_POST['status']),
		'added_by' => $_SESSION['user_id']
 	);
	// debug($_FILES, true);
 	if(isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == 0){
 		$file_name = uploadFile($_FILES['thumbnail'], 'video');
 		if($file_name){
 			$data['thumbnail'] = $file_name;
 		} else {
 			$_SESSION['warning'] = "File could not be uploaded at this moment.";
 		}
 	}
 	$video_id = $video->addVideo($data);
 	if($video_id){
 		redirect('../video-list.php','success','Video added successfully.');
 	} else {
 		redirect('../video-list.php','error','Sorry! There was problem while adding video.');
 	}
} else {
	redirect('../video-list.php', 'error', 'Unauthorized access.');
}