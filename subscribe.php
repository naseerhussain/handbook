<?PHP
	$conn = mysql_connect("localhost:3306", "root", "pwd"); // Establishing Connection with Server

	$id = $_GET["id"];
	$twitter_id = $_GET["twitter_id"];
	$email = $_GET["email"];

	if(! $conn){
        	die("Connection failed: " . mysql_error());
	}

	$sql = "INSERT INTO subscribers(id, twitter_id, email) VALUES(NULL,'$twitter_id','$email')"; 
	mysql_select_db('handbook');
	$insert = mysql_query( $sql, $conn );
	
	mysql_close($conn);

	//Send E-mail the subscriber
	$subject = "Thanks for Subscribing";
        $from = "crowdlearn@bookmane.in";
        $headers = "From: $from";

	$body = "Hello $to  \n\n

                        Thanks for subscribing to this topic. \n\n
                You will recieve all updates and notifications related to this.";

	$send = mail($to, $subject, $body, $headers);


	header('Location: mypage.php');


?>


