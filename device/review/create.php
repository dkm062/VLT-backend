<?php

require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/database/DAO.php");

$dao = new DAO();
$response = new Response();

$json = file_get_contents('php://input');
$request = json_decode($json);

$review = new Review();
$review->ordersId = $request->ordersId;
$review->overAll = addslashes($request->overAll);
$review->detailed = addslashes($request->detailed); 
$review->imageId = $request->imageIds;
$review->addedBy = $request->addedBy;

$review->reviewId = $dao->add($review);
$dao->close();

if($reviewId){
    $response->review = $reviewId;
    $response->status = 1; 
}else{
    $response->review = 0;
    $response->status = 0; 
}
echo  json_encode($response); 

class Response {
    public $review;
    public $status;
}
?>