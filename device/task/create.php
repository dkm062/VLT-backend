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
if($request->taskTypeId==1){//task type picking up 
	$task->orderStatus = 1;
}else if ($request->taskTypeId==2){//task type delivery 
	$task->taskTypeId = 4;
}
$task->taskStatus = 1;//task assigned
$task->isDeleted = 0;

$taskId = $dao->add($task);
$dao->close();

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