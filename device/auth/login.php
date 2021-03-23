<?php

require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/database/DAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/php/Validator.php");

$dao = new DAO();
$response = new Response();

$json = file_get_contents('php://input');
$request = json_decode($json);

$email = $request->email;
$password = $request->password;

$credentialError = Validator::isCorrectCredential($email, $password,true);
     
if(Validator::check($credentialError) )
{
    $user = $dao->get("User", $email, "email");
    if( is_null($user->email) ) 
    {
        $response->data = 0;
        $response->userId = 0;
        $response->status = 0; 
    }else{
    	$response->data = $user;
        $response->userId = $user->userId;
        $response->status = 1; 
	    $date = date("Y-m-d H:i:s");
	    $user->lastLogIn = $date;
        $user->logInIP = $_SERVER['REMOTE_ADDR'];
        $dao->update($user);
    }              
}else{
	$response->data = $credentialError;
    $response->userId = 0;
    $response->status = 0; 
}
$dao->close();
echo  json_encode($response); 

class Response {
    public $data;
    public $userId;
    public $status;
}


?>