<?php
error_reporting(0);
require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/database/DAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/php/Validator.php");

$dao = new DAO();
$response = new Response();

$json = file_get_contents('php://input');
$request = json_decode($json);

$response->taskType = $dao->listAll("TaskType");
$response->taskStatus = $dao->listAll("TaskStatus");


if(!empty($request->taskId)){
	$task = $dao->listAllWhere("Task", "WHERE `taskId`= $request->taskId AND `isDeleted` = 0 ORDER BY taskId DESC");
	if(count($task)>0){
		$task = $task[0];
		$u = $dao->get("User", $task->staffId, 'userId');
		$task->staffName = $u->firstName.' '.$u->lastName ;
		$task->taskStatusDesc = $dao->get("TaskStatus", $task->taskStatus, 'taskStatusId')->taskStatusDescription;
		$task->taskTypeDesc = $dao->get("TaskType", $task->taskType, 'taskTypeId')->taskTypeDescription;
		$task->orders = $dao->get("Orders", $task->ordersId, 'ordersId');
		$task->orderStatusDesc = $dao->get("OrderStatus", $task->orders->orderStatus, 'orderStatusId')->orderStatusDescription;
    	$response->task = $task;
	}else{
		$response->task = [];
	}
	$response->status = 1;
}else if(!empty($request->staffId)){
	$tasks = $dao->listAllWhere("Task", "WHERE `staffId`= $request->staffId AND `isDeleted` = 0 ORDER BY taskId DESC");
	$temp = [];
	foreach ($tasks as $t) {
		$u = $dao->get("User", $t->staffId, 'userId');
		$t->staffName = $u->firstName.' '.$u->lastName ;
		$t->taskStatusDesc = $dao->get("TaskStatus", $t->taskStatus, 'taskStatusId')->taskStatusDescription;
		$t->taskTypeDesc = $dao->get("TaskType", $t->taskType, 'taskTypeId')->taskTypeDescription;
		$t->orders = $dao->get("Orders", $t->ordersId, 'ordersId');
		$t->orderStatusDesc = $dao->get("OrderStatus", $t->orders->orderStatus, 'orderStatusId')->orderStatusDescription;
		$temp[]=$t;
	}
	$response->tasks =  $temp;
	$response->status = 1;
} else if($request->getAllTasks==1) {
	$tasks = $dao->listAllWhere("Task", "WHERE `isDeleted` = 0 ORDER BY taskId DESC ; ");//get task for the order;
	$temp = [];
	foreach ($tasks as $t) {
		$u = $dao->get("User", $t->staffId, 'userId');
		$t->staffName = $u->firstName.' '.$u->lastName ;
		$t->taskStatusDesc = $dao->get("TaskStatus", $t->taskStatus, 'taskStatusId')->taskStatusDescription;
		$t->taskTypeDesc = $dao->get("TaskType", $t->taskType, 'taskTypeId')->taskTypeDescription;
		$t->orders = $dao->get("Orders", $t->ordersId, 'ordersId');
		$t->orderStatusDesc = $dao->get("OrderStatus", $t->orders->orderStatus, 'orderStatusId')->orderStatusDescription;
		$temp[]=$t;
	}
	$response->tasks =  $temp;
	$response->status = 1;	
}else{
	$response->status = 0;
}
$dao->close();

echo  json_encode($response); 

// var_dump($response->taskType);
// exit();
// var_dump($response->taskStatus);

class Response {
	public $task;
	public $tasks;
	public $status;
	public $taskType;
	public $taskStatus;
}	
?>