<?php

require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/database/DAO.php");
$dao = new DAO();
$response = new Response();

$json = file_get_contents('php://input');
$request = json_decode($json);
if($request->userId){
	$orders = [];
	if($request->userRole==1){//this is admin
		$orders = $dao->listAllWhere('Orders'," WHERE 1 ORDER BY ordersId DESC ; ");
	}else if($request->userRole==2){//this is satff
	}else if($request->userRole==3){//this is user
		$orders = $dao->listAllWhere('Orders'," WHERE `userId` = $request->userId ORDER BY ordersId DESC ; ");
	}
	$newOrders=[];
	if(count($orders)>0){
		foreach ($orders as $o ) {
			$o->orderStatusDesc = $dao->get("OrderStatus", $o->orderStatus, 'orderStatusId')->orderStatusDescription;
			$items = $dao->listAllWhere('Item'," WHERE `orderId` = $o->ordersId ; ");
			$services = $dao->listAllWhere('Service'," WHERE `serviceId` IN (SELECT `serviceId` from `Item` WHERE `orderId` = $o->ordersId ) ; ");
			$o->items = json_encode($items);
			$o->services = json_encode($services);
			array_push($newOrders, $o);		
		}
	}
	$response->status = 1; 
	$response->orders = $newOrders;
	echo  json_encode($response);
	exit; 
}


class Response {
    public $orders;
    public $status;
}
?>