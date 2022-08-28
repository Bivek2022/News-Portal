<?php
require '../../config/init.php';
require '../inc/checklogin.php';
$news =  new News();
if(isset($_POST) && !empty($_POST)){

	$data = array(
		'title' => sanitize($_POST['title']),
		'summary' => sanitize($_POST['summary']),
		'description'=>htmlentities($_POST['description']),
		'category_id'=>(int)$_POST['category_id'],
		'news_date'=>sanitize($_POST['news_date']),
		'reporter'=>(int)$_POST['reporter'],
		'location'=>sanitize($_POST['location']),
		'source'=>sanitize($_POST['source']),
		'is_sticky'=>isset($_POST['is_sticky'])? 'Yes':'No',
		'is_featured'=>isset($_POST['is_featured'])? 'Yes':'No',
		'status'=>sanitize($_POST['status']),
		'added_by'=> $_SESSION['user_id']
	);
	if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
		$file_name = uploadFile($_FILES['image'], 'news');
		if($file_name){
			$data['image'] = $file_name;
		} else {
			$_SESSION['warning'] = "Image could not be uploaded";
		}
	}
	$news_id = (isset($_POST['id']) && !empty($_POST['id'])) ? (int)$_POST['id'] : null;
	if($news_id){
		/*Update*/
		$act = "updat";
		$news_id = $news->updateNews($data, $news_id);
	} else {
		$act = "add";
		$news_id = $news->addNews($data);
	}

	 if($news_id){
		redirect('../news-list.php','success','News '.$act.'ed successfully.');
	} else {
		redirect('../news-list.php','error','Sorry! There was problem while '.$act.'ing news.');		
	}
} else if(isset($_GET, $_GET['id'], $_GET['act']) && $_GET['act'] == "del"){
	/*Delete action*/
	$id = (int)$_GET['id'];

	if($id <= 0){
		redirect('../news-list.php', 'error','Invalid News id provided.');
	}

	$news_detail = $news->getNewsById($id);

	if(!$news_detail){
		redirect('../news-list.php', 'error','News not found or has been already deleted.');
	}

	$del = $news->deleteNews($id);

	if($del){
		/*File delete*/
		if($news_detail[0]->image != null && file_exists(UPLOAD_PATH.'news/'.$news_detail[0]->image)){
			/*Delete*/
			unlink(UPLOAD_PATH.'news/'.$news_detail[0]->image);
		}
		redirect('../news-list.php', 'success','News deleted successfully.');
	} else {		
		redirect('../news-list.php', 'error','Sorry! There was problem while deleting news.');
	}
}
else {
	redirect('../news-list.php', 'error','Unauthorized access.');
}