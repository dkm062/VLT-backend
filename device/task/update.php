<?php

require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/database/DAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/php/Validator.php");

$dao = new DAO();
$response = new Response();

$json = file_get_contents('php://input');
$request = json_decode($json);

if(!empty($request->taskId)){
	$task = $dao->get("Task", $request->taskId, "taskId");
	if($task->taskId){
    	$task->taskStatus = $request->taskStatus;
    	$task->taskType = $request->taskType;
		$task->isDeleted = 0;

		if($task->taskType==1 && $task->taskStatus==1){//task type picking up and assigned 
			$task->orderStatus = 1;
		}else if($task->taskType==1 && $task->taskStatus==2){//task type picking up and completed
			$task->orderStatus = 2;
		}else if($task->taskType==2 && $task->taskStatus==1){//task type delivery and assigned
			$task->orderStatus = 4;
		}else if($task->taskType==2 && $task->taskStatus==2){//task type delivery and completed
			$task->orderStatus = 5;
		}

		$orders = $dao->get("Orders", $task->ordersId, "ordersId");
		$orders->orderStatus = $task->orderStatus;
		$isUpdated = $dao->update($orders);
		$isUpdated = $dao->update($task);
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