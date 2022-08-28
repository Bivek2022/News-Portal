<?php 
	spl_autoload_register(function($class_file){
		require_once CLASS_PATH.$class_file.'.php';
	});
 ?>