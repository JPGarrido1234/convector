<?php
$requestMethod = $_SERVER["REQUEST_METHOD"];
include('../class/Rest.php');
$api = new Rest();
switch($requestMethod) {
	case 'GET':
		$email = '';	
		if(isset($_GET['email'])) {
			$email = $_GET['email'];
			$api->getUser($email);
		}	
		break;
	default:
	header("HTTP/1.0 405 Method Not Allowed");
	break;
}
?>