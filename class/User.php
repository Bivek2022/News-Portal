<?php 
	class User extends Database{
	public function __construct(){
		Database::__construct();
		$this->table('users');
	}

	public function getUserByUserName($user_name){
			$args = array(
				// 'fields' => " id, email, password, role, status"
				'fields' => ["id",'full_name', "email", "password", "role", "status"],
				'where' => array(
						'email' => $user_name
				)
			);
			return $this->select($args);
	}

	public function updateUser($data, $user_id, $is_exit=false){
		$args = array(
			'where' => array('id' => $user_id)
		);

		// UPDATE users SET remember_token = $data['remeber_token'] WHERE id = $user_id
		$success = $this->update($data, $args, $is_exit);
		if($success){
			return $user_id;
		} else {
			return false;
		}
	}

	public function getUserFromToken($token){
		$args = array(
			'where' => array(
				'remember_token' => $token
			)
		);
		return $this->select($args);
	}

	public function getAllReporter(){
		$args=array('where'=>array('role'=>'Reporter'));
		return $this->select($args);
	}
}
 ?>