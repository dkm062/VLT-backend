<?php

require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/database/DAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/php/Validator.php");

$dao = new DAO();
$response = new Response();

$json = file_get_contents('php://input');
$request = json_decode($json);

$service = new Service();
$service->name = $request->name;
$service->description = $request->description;
$service->status = $request->status;
$service->price = $request->price;
$service->isDeleted = 0;

$serviceId = $dao->add($service);
$dao->close();

if($serviceId){
    $response->serviceId = $serviceId;
    $response->status = 1; 
}else{
    $response->serviceId = 0;
    $response->status = 0; 
}
echo  json_encode($response); 

class Response {
    public $serviceId;
    public $status;
}



?>