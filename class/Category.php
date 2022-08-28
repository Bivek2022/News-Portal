<?php 
	class Category extends Database{
	public function __construct(){
		Database::__construct();
		$this->table('categories');
	}

	public function addCategory($data, $is_die = false){
		return $this->insert($data, $is_die);
	}
	
	public function getAllCategories($is_die = false){
		return $this->select([], $is_die);
	}

	public function getCategoryById($cat_id, $is_die = false){
		$args = array(
			'where' => array(
					'id' => $cat_id
			)
		);
		return $this->select($args, $is_die);
	}

	public function deleteCategory($cat_id, $is_die = false){
		$args = array(
			'where' => array(
					'id' => $cat_id
			)
		);
		return $this->delete($args, $is_die);	
	}

	public function updateCategory($data, $cat_id, $is_die=false){
		$args = array(
			'where' => array(
					'id' => $cat_id
			)
		);
		$success = $this->update($data, $args, $is_die);
		if($success){
			return $cat_id;
		} else {
			return false;
		}
	}
	public function getMenu(){
		$args=array();
	}
}
 ?>