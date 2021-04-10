<?php

require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/database/DAO.php");
$dao = new DAO();
$response = new Response();

$json = file_get_contents('php://input');
$request = json_decode($json);

$Order = new Orders();
$Order->userId = $request->userId;
$Order->orderDate = $request->orderDate;
$Order->orderStatus = 1;

$orderId = $dao->add($Order);

$items = (array)$request->items;
$itemIds = []; 
for ($i=0; $i<sizeof($items) ; $i++) { 
	$item = new Item();
	$item->orderId = $orderId;
	$item->serviceId = $items[$i]->serviceId;
	$item->price = $items[$i]->price;
	$itemId = $dao->add($item);
	array_push($itemIds,$itemId);
}

$dao->close();

if($orderId){
    $response->orderId = $orderId;
    $response->itemIds = $itemIds;
    $response->status = 1; 
}else{
    $response->orderId = 0;
    $response->itemIds = null;
    $response->status = 0; 
}
echo  json_encode($response); 

class Response {
    public $orderId;
    public $itemIds;
    public $status;
}



?>