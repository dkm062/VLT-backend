<?php

require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/database/DAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/php/Validator.php");

$dao = new DAO();
$response = new Response();

$json = file_get_contents('php://input');
$request = json_decode($json);

if(!empty($request->serviceId)){
	$service = $dao->get("Service", $request->serviceId, "serviceId");
	$service->isDeleted = 1;

	$serviceId = $dao->update($service);
	$dao->close();

    $response->isDeleted = 1; 
	
} else {
	$response->isDeleted = 0;
}
echo  json_encode($response); 

class Response {
    public $isDeleted;
}



?>