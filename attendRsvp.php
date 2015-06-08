<?php    
	//$conn = mysql_connect("bookmane.in", "bookmane_user1", "test123"); // Establishing Connection with Server
        $conn = mysql_connect("localhost:3306", "root", "pwd"); // Establishing Connection with Server
	

	$attendee = $_GET["email"];
	$twitter_id = $_GET["twitter_id"];
	$topicId = $_GET["zid"];

	echo $attendee, $twitter_id, $topicId;

	$subject = "Thanks for your interest";
	$from = "crowdlearn@bookmane.in";
	$headers = "From: $from";


	$sql = 'SELECT email FROM company WHERE twitter_id="'.$twitter_id.'" AND id="'.$topicId.'"';

	mysql_select_db("handbook");
	//mysql_select_db('bookmane_handbook');

	$retval = mysql_query($sql, $conn);
	if(! $retval){
		die('could not get data :'. mysql_error());
	}
	
	while($row = mysql_fetch_array($retval, MYSQL_ASSOC)){
		$email = $row['email'];
		//echo $row['email'];
	}

	echo $email;


	$body = "Hello $attendee\n\n
		Thanks for showing interest to attend the RSVP, $email will send the time, duration and venue of the event";
  	$send = mail($attendee, $subject, $body, $headers);

	$sub = "New Attendee wants to join";

	$body2 = "Hello $email \n\n
		$attendee wants to join the rsvp event, please send him the venue and other details\n\n
		Thanking you";

	mail($email,$sub,$body2,$headers);

	mysql_close($conn);

?>
