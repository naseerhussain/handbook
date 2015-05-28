<?php    
	
	$to = $_GET["email"];
	$topic = $_GET["topic"];
	$subject = "test the code";
	$from = "naseer.aman@gmail.com";
	$headers = "From: $from";
	echo "this code is running";
	echo $to;


	$body = "Hello $to\n\n

			Thanks for subscribing to the $topic notifications and updates\n\n
		You will recieve any news related to the $topic.";

    $send = mail($to, $subject, $body, $headers);



?>
