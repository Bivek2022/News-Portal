<?php
class Gallery extends Database{
	public function __construct(){
		Database::__construct();
		$this->table('galleries');
	}

	public function addGallery($data, $is_die =false){
		return $this->insert($data, $is_die);
	}

	public function getAll(){
		return $this->select();
	}

	public function getGalleryById($gal_id){
		$args = array(
			'where' => ['id' => $gal_id]
		);

		return $this->select($args);
	}

	public function updateGallery($data, $gallery_id){
		$args = array(
			'where' => ['id' => $gallery_id]
		);

		$update = $this->update($data, $args);

		if($update){
			return $gallery_id;
		} else {
			return false;
		}

	}
}