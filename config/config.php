<?php 
	ob_start();
	session_start();
	define('ENVIRONMENT','DEVELOPMENT');
	if(ENVIRONMENT=='DEVELOPMENT'){
		error_reporting(E_ALL);
		define('SITE_URL', 'http://localhost:81/newsportal');
		define('DB_HOST', 'localhost');
		define('DB_USER','root');
		define('DB_PWD', '');
		define('DB_NAME', 'newsportal');
	}else{
		error_reporting(0);
		define('SITE_URL', 'https://newsportal.com');
		define('DB_HOST', 'localhost');
		define('DB_USER','root');
		define('DB_PWD', '');
		define('DB_NAME', 'newsportal');
	}
	define('ADMIN_URL', SITE_URL.'/admin/');
	define('ADMIN_ASSETS', ADMIN_URL.'assets/');
	define('ADMIN_VENDOR_URL', ADMIN_ASSETS.'vendor/');
	define('ADMIN_CSS_URL', ADMIN_ASSETS.'css/');
	define('ADMIN_JS_URL', ADMIN_ASSETS.'js/');
	define('SITE_NAME','Newsportal, An Online Based Nepali Newsportal');
	define('META_KEYWORDS','nepali news, newsportal, online news, nepal, politics, sagarmatha, kantipur, mount everest');
	define('META_DESCRIPTION','Newsportal is an online based Nepali newsportal website. We provide 24x7 service to all the people living within Nepal or outside Nepal' );
	
	define('CLASS_PATH', $_SERVER["DOCUMENT_ROOT"].'newsportal/class/');
	define('ERROR_PATH', $_SERVER['DOCUMENT_ROOT'].'newsportal/error/');

	define('ALLOWED_IMAGE_EXTENSION', array('jpg','jpeg','png','svg','bmp','gif'));

	define('UPLOAD_PATH', $_SERVER['DOCUMENT_ROOT'].'newsportal/uploads/');
	define('UPLOAD_URL', SITE_URL.'/uploads/');
	ob_flush();
 ?>