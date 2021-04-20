<?php

require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/database/DAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/php/Validator.php");

$dao = new DAO();
$response = new Response();

$json = file_get_contents('php://input');
$request = json_decode($json);

$isDuplicateUser = $dao->get('User',$request->email,'email');

$isDuplicate=false;
if($isDuplicateUser->userId && !$isDuplicateUser->isDeleted){
	$isDuplicate = true;
}

if($isDuplicate){
    $response->isDuplicate = 1;
    $response->status = 1; 
}else{
	$user = new User();
	$user->firstName = $request->first_name;
	$user->lastName = $request->last_name;
	$user->email = $request->email;
	$user->phoneNumber = $request->phone;
	$user->password = $request->password;
	$user->userRole = 3;
	$user->userStatus = 1;
	$userId = $dao->add($user);
	if($userId){
	    $response->userId = $userId;
	    $response->status = 1; 
	    $response->isDuplicate = 0;	
	}else{
	    $response->userId = 0;
	    $response->status = 0; 
	    $response->isDuplicate = 0;
	}
}
$dao->close();
echo  json_encode($response); 

class Response {
    public $userId;
    public $status;
    public $isDuplicate;
}



?>