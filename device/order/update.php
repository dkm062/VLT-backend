<?php

require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/database/DAO.php");

$dao = new DAO();
$response = new Response();

$json = file_get_contents('php://input');
$request = json_decode($json);

if(!empty($request->ordersId)){
	$orders = $dao->get("Orders", $request->ordersId, "ordersId");
	if($orders->ordersId){
    	$orders->userId = $request->userId;
		$orders->orderDate = $request->orderDate;
		$orders->orderStatus = $request->status;

		$isUpdated = $dao->update($orders);

		$items = (array)$request->items;
		$getItems = $dao->listAll("Item", "orderId", $request->ordersId);
		for ($i=0; $i<sizeof($items) ; $i++) { 
			$item = $getItems[$i];			
			$item->orderId = $request->ordersId;
			$item->serviceId = $items[$i]->serviceId;
			$item->price = $items[$i]->price;
			$itemUpdated = $dao->update($item);
		}

		$response->status = $isUpdated && $itemUpdated ? 1 : 0;
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