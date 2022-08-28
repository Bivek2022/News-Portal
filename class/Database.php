<?php
abstract class Database{
	private $conn = null;
	private $stmt = null;
	private $table = null;
	private $sql = null;

	public function __construct(){
		try{
			$this->conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";", DB_USER, DB_PWD);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$this->stmt = $this->conn->prepare("SET NAMES utf8");
			$this->stmt->execute();

		} catch(PDOException $e){
			error_log(date('Y-m-d h:i:s A').":".$e->getMessage()."\n", 3, ERROR_PATH."error.log");
			return false;
		} catch(Exception $e){
			error_log(date('Y-m-d h:i:s A').":".$e->getMessage()."\n", 3, ERROR_PATH."error.log");
			return false;
		}
	}

	final protected function table($_table){
		$this->table = $_table;
	}

	final protected function select($args = array(), $is_die = false){
		try{
			$this->sql = "SELECT ";
			if(isset($args['fields']) && !empty($args['fields'])){
				if(is_array($args['fields'])){
					$this->sql .= implode(", ", $args['fields']);
				} else {
					$this->sql .= $args['fields'];
				}
			} else {
				$this->sql .= " * ";
			}
			$this->sql .= " FROM ";

			if(!isset($this->table) || $this->table == null){
				throw new Exception('Table not set.');
			}
			$this->sql .= $this->table;
			if(isset($args['where']) && !empty($args['where'])){
				if(is_array($args['where'])){
					$temp = array();
					foreach($args['where'] as $column_name=>$value){
						$str = $column_name." = :".$column_name;
						$temp[] =$str;
					}
					$this->sql .= " WHERE ". implode(' AND ', $temp);
				} else {
					$this->sql .= " WHERE ".$args['where'];
				}
			}
			if($is_die){
				debug($args);
				echo $this->sql;
				exit;
			}
			$this->stmt = $this->conn->prepare($this->sql);
			if(isset($args['where']) && is_array($args['where'])){
				foreach($args['where'] as $column_name => $value){
					if(is_integer($value)){
						$param = PDO::PARAM_INT; // number
					} else if(is_bool($value)){
						$param = PDO::PARAM_BOOL;
					} else {
						$param = PDO::PARAM_STR;
					}
					if($param){
						$this->stmt->bindValue(":".$column_name, $value, $param);
					}	
				}
			}
			$this->stmt->execute();
			return $this->stmt->fetchAll(PDO::FETCH_OBJ);

		} catch(PDOException $e){
			error_log(date('Y-m-d h:i:s A').": (SQL: ".$this->sql.") ".$e->getMessage()."\n", 3, ERROR_PATH."error.log");
			return false;
		} catch(Exception $e){
			error_log(date('Y-m-d h:i:s A').": (SQL: ".$this->sql.") ".$e->getMessage()."\n", 3, ERROR_PATH."error.log");
			return false;
		}
	}
	final protected function update($data= array(), $args= array(), $is_die=false){
		try{
			$this->sql = "UPDATE ";
			if(!isset($this->table) || $this->table == null){
				throw new Exception('Table not set.');
			}
			$this->sql .= $this->table;

			if(!isset($data) || empty($data)){
				throw new Exception('Data not set.');
			} else {
				if(is_array($data)){
					$temp_data = array();
					foreach($data as $column_name => $value){
						$str_1 = $column_name." = :".$column_name."_";
						$temp_data[] = $str_1;
					}
					$this->sql .= " SET ".implode(", ", $temp_data);
				} else {
					$this->sql .= " SET ". $data;
				}
			}
			if(isset($args['where']) && !empty($args['where'])){
				if(is_array($args['where'])){
					/*Loop*/
					$temp = array();
					foreach($args['where'] as $column_name=>$value){
						$str = $column_name." = :".$column_name;
						$temp[] =$str;
					}
					$this->sql .= " WHERE ". implode(' AND ', $temp);
				} else {
					$this->sql .= " WHERE ".$args['where'];
				}
			}
			if($is_die){
				debug($args);
				echo $this->sql;
				exit;
			}
			$this->stmt = $this->conn->prepare($this->sql);
			if(isset($data) && is_array($data)){
				foreach($data as $column_name => $value){
					if(is_integer($value)){
						$param = PDO::PARAM_INT;
					} else if(is_bool($value)){
						$param = PDO::PARAM_BOOL;
					} else {
						$param = PDO::PARAM_STR;
					}
					if($param){
						$this->stmt->bindValue(":".$column_name."_", $value, $param);
					}	
				}
			}
			if(isset($args['where']) && is_array($args['where'])){
				foreach($args['where'] as $column_name => $value){
					if(is_integer($value)){
						$param = PDO::PARAM_INT;
					} else if(is_bool($value)){
						$param = PDO::PARAM_BOOL;
					} else {
						$param = PDO::PARAM_STR;
					}
					if($param){
						$this->stmt->bindValue(":".$column_name, $value, $param);
					}	
				}
			}
			return $this->stmt->execute();
		} catch(PDOException $e){
			error_log(date('Y-m-d h:i:s A').": (SQL: ".$this->sql.") ".$e->getMessage()."\n", 3, ERROR_PATH."error.log");
			return false;
		} catch(Exception $e){
			error_log(date('Y-m-d h:i:s A').": (SQL: ".$this->sql.") ".$e->getMessage()."\n", 3, ERROR_PATH."error.log");
			return false;
		}
	}
	final protected function insert($data= array(), $is_die=false){
		try{
			$this->sql = "INSERT INTO  ";
			if(!isset($this->table) || $this->table == null){
				throw new Exception('Table not set.');
			}
			$this->sql .= $this->table;
			if(!isset($data) || empty($data)){
				throw new Exception('Data not set.');
			} else {
				if(is_array($data)){
					$temp_data = array();
					foreach($data as $column_name => $value){
						$str_1 = $column_name." = :".$column_name."_";
						$temp_data[] = $str_1;
					}
					$this->sql .= " SET ".implode(", ", $temp_data);
				} else {
					$this->sql .= " SET ". $data;
				}
			}
			if($is_die){
				debug($data);
				echo $this->sql;
				exit;
			}
			$this->stmt = $this->conn->prepare($this->sql);
			if(isset($data) && is_array($data)){
				foreach($data as $column_name => $value){
					if(is_integer($value)){
						$param = PDO::PARAM_INT;
					} else if(is_bool($value)){
						$param = PDO::PARAM_BOOL;
					} else {
						$param = PDO::PARAM_STR;
					}
					if($param){
						$this->stmt->bindValue(":".$column_name."_", $value, $param);
					}	
				}
			}
			$this->stmt->execute();
			return $this->conn->lastInsertId();
		} catch(PDOException $e){
			error_log(date('Y-m-d h:i:s A').": (SQL: ".$this->sql.") ".$e->getMessage()."\n", 3, ERROR_PATH."error.log");
			return false;
		} catch(Exception $e){
			error_log(date('Y-m-d h:i:s A').": (SQL: ".$this->sql.") ".$e->getMessage()."\n", 3, ERROR_PATH."error.log");
			return false;
		}
	}
	final protected function delete($args= array(), $is_die=false){
		try{
			$this->sql = "DELETE FROM ";
			if(!isset($this->table) || $this->table == null){
				throw new Exception('Table not set.');
			}
			$this->sql .= $this->table;
			if(isset($args['where']) && !empty($args['where'])){
				if(is_array($args['where'])){
					/*Loop*/
					$temp = array();
					foreach($args['where'] as $column_name=>$value){
						$str = $column_name." = :".$column_name;
						$temp[] =$str;
					}

					$this->sql .= " WHERE ". implode(' AND ', $temp);
				} else {
					$this->sql .= " WHERE ".$args['where'];
				}
			}
			//ordering 
			if(isset($args['order_by']) && !empty($args['order_by'])){
				//$this->

				
			}
			if($is_die){
				debug($args);
				echo $this->sql;
				exit;
			}
			$this->stmt = $this->conn->prepare($this->sql);
			if(isset($args['where']) && is_array($args['where'])){
				foreach($args['where'] as $column_name => $value){
					if(is_integer($value)){
						$param = PDO::PARAM_INT;
					} else if(is_bool($value)){
						$param = PDO::PARAM_BOOL;
					} else {
						$param = PDO::PARAM_STR;
					}
					if($param){
						$this->stmt->bindValue(":".$column_name, $value, $param);
					}	
				}
			}
			return $this->stmt->execute();
		} catch(PDOException $e){
			error_log(date('Y-m-d h:i:s A').": (SQL: ".$this->sql.") ".$e->getMessage()."\n", 3, ERROR_PATH."error.log");
			return false;
		} catch(Exception $e){
			error_log(date('Y-m-d h:i:s A').": (SQL: ".$this->sql.") ".$e->getMessage()."\n", 3, ERROR_PATH."error.log");
			return false;
		}
	}
}

?>