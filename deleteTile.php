<?PHP
	$conn = mysql_connect("localhost:3306", "root", "pwd"); // Establishing Connection with Server
	//$conn = mysql_connect("bookmane.in", "bookmane_user1", "test123"); // Establishing Connection with Server


	$id = $_GET["id"];
	$twitter_id = $_GET["twitter_id"];

	if(! $conn){
        	die("Connection failed: " . mysql_error());
	}

	$sql = "DELETE FROM topics WHERE id='$id' AND twitter_id='$twitter_id'"; 
	//mysql_select_db('bookmane_handbook');
	mysql_select_db('handbook');
	$insert = mysql_query( $sql, $conn );
	
	mysql_close($conn);
	header('Location: mypage.php');


?>


