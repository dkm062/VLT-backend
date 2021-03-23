<?php

require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/database/DAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/php/Validator.php");

$dao = new DAO();
$response = new Response();

$json = file_get_contents('php://input');
$request = json_decode($json);

$user = new User();
$user->firstName = $request->first_name;
$user->lastName = $request->last_name;
$user->email = $request->email;
$user->phoneNumber = $request->phone;
$user->password = $request->password;
$user->address = $request->formattedAddress;
$user->userRole = 3;
$user->userStatus=1;
$user->isDeleted = 0;

$userId = $dao->add($user);
$dao->close();

if($userId){
    $response->userId = $userId;
    $response->status = 1; 
}else{
    $response->userId = 0;
    $response->status = 0; 
}
echo  json_encode($response); 

class Response {
    public $userId;
    public $status;
}



?>