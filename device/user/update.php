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
		
    	$user->firstName = $request->firstName ?  $request->firstName : $user->firstName;
		$user->lastName = $request->lastName ?  $request->lastName : $user->lastName;
		$user->email = $request->email ?  $request->email : $user->email;
		$user->phoneNumber = $request->phone ?  $request->phone : $user->phoneNumber;
		$user->password = $request->password ?  $request->password : $user->password;
		$user->address = $request->address ?  $request->address : $user->address;
		$user->lat = $request->lat ?  $request->lat : $user->lat;
		$user->lng = $request->lng ?  $request->lng : $user->lng;
		$user->userRole = $request->userRole ?  $request->userRole : $user->userRole;
		$user->pPicture = $request->pPicture ? $request->pPicture : "" ;
		
		$user->userStatus = 1;
		$user->isDeleted = 0;

		$isUpdated = $dao->update($user);
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