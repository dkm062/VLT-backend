<?php

require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/database/DAO.php");

$dao = new DAO();
$response = new Response();

$json = file_get_contents('php://input');
$request = json_decode($json);

if(!empty($request->reviewId)){
	$review = $dao->get("Review",$request->reviewId,'reviewId');
	$review->ordersId = $request->ordersId;
	$review->overAll = addslashes($request->overAll);
	$review->detailed = addslashes($request->detailed); 
	$review->imageId = $request->imageIds;
	$review->addedBy = $request->addedBy;
	$dao->update($review);

    $response->status = 1; 
}else{
    $response->status = 0; 
}


$dao->close();

echo  json_encode($response); 

class Response {
    public $status;
}
?>