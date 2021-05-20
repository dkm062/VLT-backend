<?php

require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/database/DAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/php/Validator.php");

$dao = new DAO();
$response = new Response();

$json = file_get_contents('php://input');
$request = json_decode($json);

// if($request->serviceId != 0 && $request->serviceId !='' && $request->serviceId != null){
if(!empty($request->serviceId)){
	$service = $dao->get("Service", $request->serviceId, "serviceId");
	if($service->serviceId){
    	$service->name = $request->name;
		$service->description = $request->description;
		$service->status = $request->status;
		$service->price = $request->price;
		$service->images = $request->images;
		$service->isDeleted = $request->isDeleted ? $request->isDeleted : 0 ;

		$isUpdated = $dao->update($service);
		$response->status = $isUpdated ? 1 : 0;
	}else{
    	$response->status = 0;
	}
	$dao->close();
} else {
	$response->status = 0;
}
echo  json_encode($response); 

class Response {
    public $status;
}



?>