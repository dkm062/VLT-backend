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
$ordersId = $request->ordersId;

if(!empty($request->staffId)){
	$staff = $dao->listAllWhere("User", "WHERE `userId`= $request->staffId AND `isDeleted` = 0 AND userRole = 2 ; ");// A staff
	if(count($staff)>0){
		$staff = $staff[0];
    	$response->staff = $staff;
	}else{
		$response->staff = [];
	}
	$response->status = 1;
} else if($request->getAllStaff==1) {
	if($ordersId){
		$tasks = $dao->listAllWhere("Task", "WHERE `ordersId`= $ordersId AND `isDeleted` = 0 ; ");//get task for the order;
		$temp = [];
		foreach ($tasks as $t) {
			$u = $dao->get("User", $t->staffId, 'userId');// A staff
			
			if($t->taskStatus==1){
				$response->currentAssigneeStaff = $u ;
			}

			$t->staffName = $u->firstName.' '.$u->lastName ;
			$t->taskStatusDesc = $dao->get("TaskStatus", $t->taskStatus, 'taskStatusId')->taskStatusDescription;
			$t->taskTypeDesc = $dao->get("TaskType", $t->taskType, 'taskTypeId')->taskTypeDescription;
			$temp[]=$t;
		}
		$response->tasks =  $temp;

	}
	$staff = $dao->listAllWhere("User", "WHERE `isDeleted` = 0 AND userRole = 2; ");//All the staff
	$response->staff =  $staff;
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
	public $staff;
	public $tasks;
	public $currentAssigneeStaff;
	public $status;
	public $taskType;
	public $taskStatus;
}	
?>