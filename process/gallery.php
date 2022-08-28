<?php
require '../../config/init.php';
require '../inc/checklogin.php';

$gallery = new Gallery();
if(isset($_POST) && !empty($_POST)){
	
	$data = array(
		'title' => sanitize($_POST['title']),
		'summary' => sanitize($_POST['summary']),
		'status' => sanitize($_POST['status']),
		'added_by' => $_SESSION['user_id']
	);

	if(isset($_FILES, $_FILES['cover_image'])  && $_FILES['cover_image']['error'] == 0){
		$file_name = uploadFile($_FILES['cover_image'], 'gallery');
		if($file_name){
			$data['cover_pic'] = $file_name;
		} else {
			$_SESSION['warning'] = 'File Could not be uploaded.';
		}
	}

	$gallery_id =  (isset($_POST['gallery_id']) && !empty($_POST['gallery_id'])) ? (int)$_POST['gallery_id'] : null;
	
	if($gallery_id){
		$act = "updat";
		$gallery_id = $gallery->updateGallery($data, $gallery_id);
	} else {
		$act = "add";
		$gallery_id = $gallery->addGallery($data);
	}
	
	if($gallery_id){
		/*Gallery Added Successfully*/
		$other_images = $_FILES['other_images'];

		
		if(isset($other_images)){
			$count = count($other_images['name']);
			if($count > 0){

				for($i =0; $i<$count; $i++){
					$temp = array();
					if($other_images['error'][$i] == 0){
						$temp['name'] = $other_images['name'][$i];
						$temp['type'] = $other_images['type'][$i];
						$temp['tmp_name'] = $other_images['tmp_name'][$i];
						$temp['error'] = $other_images['error'][$i];
						$temp['size'] = $other_images['size'][$i];
						

						$image_name = uploadFile($temp, "gallery");
						if($image_name){
							$img_data = array(
								'gallery_id' => $gallery_id,
								'image_name' => $image_name
							);

							$gallery_image = new GalleryImages();
							$gallery_image->addImages($img_data);
						}

					}
				}

			}
		
		}
		redirect('../gallery-list.php', 'success', 'Gallery '.$act.'ed Successfully');
	} else {
		redirect('../gallery-list.php','error', 'Sorry! There was problem while '.$act.'ing gallery.');
	}
}
 else if(isset($_GET['gallery_id'], $_GET['img_id']) && !empty($_GET['gallery_id']) && !empty($_GET['img_id'])){
	$gallery_id = (int)$_GET['gallery_id'];
	$img_id = (int)$_GET['img_id'];

	$gallery_images = new GalleryImages();

	$image = $gallery_images->getImageById($img_id);
	if(!$image){
		redirect('../gallery-add.php?id='.$gallery_id, 'error', 'Image not found.');
	}

	$del = $gallery_images->deleteImage($img_id);
	if($del){
		if(file_exists(UPLOAD_PATH.'gallery/'.$image[0]->image_name)){
			unlink(UPLOAD_PATH.'gallery/'.$image[0]->image_name);
		}
	}
	redirect('../gallery-add.php?id='.$gallery_id);
}

else {
	redirect('../gallery-list.php','error', 'Unauthorized Access.');
}

