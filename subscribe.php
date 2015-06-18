<?PHP
	$conn = mysql_connect("localhost:3306", "root", "pwd"); // Establishing Connection with Server
//	$conn = mysql_connect("bookmane.in", "bookmane_user1", "test123"); // Establishing Connection with Server


	$id = $_GET["id"];
	$twitter_id = $_GET["twitter_id"];
	$email = $_GET["email"];
	$comp = $_GET["company"];

	if(! $conn){
        	die("Connection failed: " . mysql_error());
	}

	$sql = "INSERT INTO subscribers(id, twitter_id, email, company) VALUES(NULL,'$twitter_id','$email','$comp')"; 
	mysql_select_db('handbook');
//	mysql_select_db('bookmane_handbook');
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


