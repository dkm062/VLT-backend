<?php

require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/database/DAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/php/Validator.php");

$dao = new DAO();
$response = new Response();

$json = file_get_contents('php://input');
$request = json_decode($json);

$task = new Task();
$task->ordersId = $request->ordersId;
$task->staffId = $request->staffId;
$task->taskType = $request->taskTypeId;
$isTask = $dao->listAllWhere("Task"," WHERE taskType = $request->taskTypeId AND ordersId = $request->ordersId AND taskStatus = 1 ; ");
$isStaffOccupied = $dao->listAllWhere("Task"," WHERE staffId = $request->staffId AND taskStatus = 1 ; ");

if(count($isTask)>=1){
    $response->alreadyExist = 1;
}else if (count($isTask)==0){
    $response->alreadyExist = 0;
	if (count($isStaffOccupied)>=1){
		$taskId = 0;
	    $response->staffOccupied = 1;
	}else if(count($isStaffOccupied)==0){
	    $response->staffOccupied = 0;
		if($request->taskTypeId==1){//task type picking up
			$task->orderStatus = 1;
		}else if ($request->taskTypeId==2){//task type delivery 
			$task->orderStatus = 4;
			$orders = $dao->get("Orders", $task->ordersId, "ordersId");
			$orders->orderStatus = $task->orderStatus;
			$isUpdated = $dao->update($orders);
		}
		$task->taskStatus = 1;//task assigned
		$task->isDeleted = 0;

		$taskId = $dao->add($task);
		$dao->close();
	}
}
if($taskId){
    $response->taskId = $taskId;
    $response->status = 1; 
}else{
    $response->taskId = 0;
    $response->status = 0; 
}
echo  json_encode($response); 

class Response {
    public $taskId;
    public $status;
}
?>