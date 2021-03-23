<?php

require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/database/DAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/php/Validator.php");

$dao = new DAO();
$response = new Response();

$json = file_get_contents('php://input');
$request = json_decode($json);

if(!empty($request->userId)){
	$user = $dao->get("User", $request->userId, "userId");
	if($user->userId){
		$user->isDeleted = 1;

		$isUpdated = $dao->update($user);
		$dao->close();

   		$response->isDeleted = $isUpdated ? 1 : 0;
	} else {
		$response->isDeleted = 0;
	}
	
} else {
	$response->isDeleted = 0;
}
echo  json_encode($response); 

class Response {
    public $isDeleted;
}



?>