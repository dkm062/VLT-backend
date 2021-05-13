<?php
error_reporting(0);
require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/database/DAO.php");

$dao = new DAO();
$response = new Response();

$json = file_get_contents('php://input');
$request = json_decode($json);
if(!empty($request->staffId)){
	$user = $dao->get("User", $request->staffId, "userId");
	$user->lat = $request->coords->latitude;
	$user->lng = $request->coords->longitude;
	$dao->update($user);
	$response->status=1;
}else{
	$response->status=0;
}
echo  json_encode($response);

class Response {
    public $status;
}
?>