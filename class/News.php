<?php 
class News extends Database{
	public function __construct(){
		Database::__construct();
		$this->table('news');
	}
	public function addNews($data, $is_die = false){
		return $this->insert($data, $is_die);
	}
	
	public function getAllNews($is_die = false){
		return $this->select([], $is_die);
	}

	public function getNewsById($news_id, $is_die = false){
		$args = array(
			'where' => array(
					'id' => $news_id
			)
		);
		return $this->select($args, $is_die);
	}

	public function deleteNews($news_id, $is_die = false){
		$args = array(
			'where' => array(
					'id' => $news_id
			)
		);
		return $this->delete($args, $is_die);	
	}

	public function updateNews($data, $news_id, $is_die=false){
		$args = array(
			'where' => array(
					'id' => $news_id
			)
		);
		$success = $this->update($data, $args, $is_die);
		if($success){
			return $news_id;
		} else {
			return false;
		}
	}
	public function getNews($args, $is_die=false){
		return $this->select($args, $is_die);
	}
	public function getRelatedNews(){
		
	}
}
 ?>