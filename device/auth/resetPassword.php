<?php     
	// ini_set("SMTP","smtp.gmail.com");
	// ini_set("smtp_port","465");
	$to_email = 'dkm062@gmail.com';
	$subject = 'Testing PHP Mail';
	$message = 'This mail is sent using the PHP mail function';
	$headers = 'From:meplusblack@gmail.com';
	mail($to_email,$subject,$message,$headers);
?>