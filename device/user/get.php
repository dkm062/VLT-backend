<?php
error_reporting(0);
require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/database/DAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/php/Validator.php");

$dao = new DAO();
$response = new Response();

$json = file_get_contents('php://input');
$request = json_decode($json);

if(!empty($request->userId)){
	$users = $dao->listAllWhere("User", "WHERE `userId`= $request->userId AND `isDeleted` = 0");
    $response->users = $users; 	
} else {
	$users = $dao->listAllWhere("User", "WHERE `isDeleted` = 0");
	$response->users =  $users;
}
 $dao->close();

echo  json_encode($response); 

class Response {
	public $users;
}



?>