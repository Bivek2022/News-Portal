<?php
require '../../config/init.php';
require '../inc/checklogin.php';
$category =  new Category();
if(isset($_POST) && !empty($_POST)){

	$data = array(
		'title' => sanitize($_POST['title']),
		'summary' => sanitize($_POST['summary']),
		'status' => sanitize($_POST['status']),
		'added_by' => $_SESSION['user_id']
	);
	if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
		$file_name = uploadFile($_FILES['image'], 'category');
		if($file_name){
			$data['image'] = $file_name;
		} else {
			$_SESSION['warning'] = "Image could not be uploaded";
		}
	}
	$cat_id = (isset($_POST['cat_id']) && !empty($_POST['cat_id'])) ? (int)$_POST['cat_id'] : null;
	if($cat_id){
		/*Update*/
		$act = "updat";
		$category_id = $category->updateCategory($data, $cat_id);
	} else {
		$act = "add";
		$category_id = $category->addCategory($data);
	}

	if($category_id){
		redirect('../category-list.php','success','Category '.$act.'ed successfully.');
	} else {
		redirect('../category-list.php','error','Sorry! There was problem while '.$act.'ing category.');		
	}
	// debug($category_id, true);
} else if(isset($_GET, $_GET['id'], $_GET['act']) && $_GET['act'] == "del"){
	/*Delete action*/
	$id = (int)$_GET['id'];

	if($id <= 0){
		redirect('../category-list.php', 'error','Invalid Category id provided.');
	}

	$category_detail = $category->getCategoryById($id);

	if(!$category_detail){
		redirect('../category-list.php', 'error','Category not found or has been already deleted.');
	}

	$del = $category->deleteCategory($id);

	if($del){
		/*File delete*/
		if($category_detail[0]->image != null && file_exists(UPLOAD_PATH.'category/'.$category_detail[0]->image)){
			/*Delete*/
			unlink(UPLOAD_PATH.'category/'.$category_detail[0]->image);
		}
		redirect('../category-list.php', 'success','Category deleted successfully.');
	} else {		
		redirect('../category-list.php', 'error','Sorry! There was problem while deleting category.');
	}
}
else {
	redirect('../category-list.php', 'error','Unauthorized access.');
}