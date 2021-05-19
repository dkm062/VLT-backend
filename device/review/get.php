<?php
error_reporting(0);
require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/database/DAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/php/Validator.php");

$dao = new DAO();
$response = new Response();

$json = file_get_contents('php://input');
$request = json_decode($json);

if(!empty($request->ordersId)){
    $response->review = $dao->get("Review",$request->ordersId,'ordersId');
	$response->status =  1;
} else {
	$response->status =  0;
}
$dao->close();

echo  json_encode($response); 

class Response {
	public $review;
	public $status;
}
?>