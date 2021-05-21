<?php     
require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/database/DAO.php");

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
$dao = new DAO();
$response = new Response();

$json = file_get_contents('php://input');
$request = json_decode($json);

$email = $request->email;

$user = $dao->get("User", $email, "email");
if( is_null($user->email) ) 
{
    $response->status = 0; 
}else{
	$newPass = generateRandomString();
    $user->password = $newPass;
	$to_email = $user->email;
	$subject = 'New password for VLT lanudry';
	$message = 'Your new password for the VLT lanudry account is '.$newPass;
	$headers = 'From:info@volt.com';
	$isSent = mail($to_email,$subject,$message,$headers);
	if($isSent){
    	$dao->update($user);
    	$response->status = 1; 
	}else{
    	$response->status = 2; 
	}
}    
$dao->close();
echo  json_encode($response); 

class Response {
    public $status;
}

?>