<?php
  
  $json = file_get_contents('php://input');
  $request = json_decode($json);

  $email = $request->email;
  $amount = $request->amount;

  $url = "https://api.paystack.co/transaction/initialize";

  $fields = [
    'email' => $email,
    'amount' => $amount,
  ];

  $fields_string = http_build_query($fields);
  //open connection
  $ch = curl_init();
  
  //set the url, number of POST vars, POST data
  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch,CURLOPT_POST, true);
  curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Authorization: Bearer sk_test_c54190341c9ee4984e6d017bf8a896d23060811a",
    "Cache-Control: no-cache",
  ));
  
  //So that curl_exec returns the contents of the cURL; rather than echoing it
  curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
  
  //execute post
  $response = curl_exec($ch);
  echo $response;
?>