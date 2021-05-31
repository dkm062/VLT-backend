<?php

require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/database/DAO.php");

$dao = new DAO();
$response = new Response();

$json = file_get_contents('php://input');
$request = json_decode($json);

if(!empty($request->ordersId)){
	$orders = $dao->get("Orders", $request->ordersId, "ordersId");
	if($orders->ordersId){
		$orders->orderStatus = $request->orderStatus;

		$isUpdated = $dao->update($orders);

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