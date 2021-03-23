<?php
error_reporting(0);
require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/database/DAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/php/Validator.php");

$dao = new DAO();
$response = new Response();

$json = file_get_contents('php://input');
$request = json_decode($json);

if(!empty($request->serviceId)){
	$services = $dao->getWhere("Service", "WHERE `serviceId`= $request->serviceId AND `isDeleted` = 0");
    $response->services = $services; 	
} else {
	$services = $dao->listAll("Service", "isDeleted", 0);
	$response->services = $services;
}
$dao->close();
echo  json_encode($response); 

class Response {
	public $services;
}



?>