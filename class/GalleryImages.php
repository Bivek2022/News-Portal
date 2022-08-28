<?php
class GalleryImages extends Database{
	public function __construct(){
		Database::__construct();
		$this->table('gallery_images');
	}

	public function addImages($data, $is_die =false){
		return $this->insert($data, $is_die);
	}

	public function getImagesBygalleryId($gallery_id){
		$args = array(
			'where' => array(
					'gallery_id' => $gallery_id
					// SELECT * FROM gallery_images WHERE gallery_id = $gallery_id
				)
		);

		return $this->select($args);
	}

	public function getImageById($id){
		$args = array(
			'where' => array(
					'id' => $id
				)
		);

		return $this->select($args);
	}
	public function deleteImage($img_id){
		$args = array(
			'where' => array(
					'id' => $img_id
				)
		);

		return $this->delete($args);
	}
}