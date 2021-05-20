<?php
    header('Content-Type: multipart/form-data; charset=utf-8');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: PUT, GET, POST");
    require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/database/DAO.php");

    $response = new Response();

    $url = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ?  "https://" : "http://";   
    $url .= $_SERVER['HTTP_HOST'];   

    $file = $_FILES["image"]; 
    if($file){
        $timestamp = time();
        $target_dir = $_SERVER['DOCUMENT_ROOT']."/VLT-backend/images/$timestamp/";
        mkdir($target_dir);
        $target_file = $target_dir . basename($file["name"]);
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            $response->status = 1;
            $charToRemove = stripos($target_file, "/VLT-backend");
            $response->imageLink = $url.substr($target_file, $charToRemove);
        } else {
            $response->status = 0;
        }
    } else {
        $response->status = 0;
    }

    echo json_encode($response);

    class Response {  
        public $status;
        public $imageLink;
    }

?>

