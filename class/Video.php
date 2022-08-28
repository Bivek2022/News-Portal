<?php
class Video extends Database{
	public function __construct(){
		Database::__construct();
		$this->table('videos');
	}
	public function addVideo($data){
		return $this->insert($data);
	}
	public function getVideos(){
		return $this->select();
	}
	
}