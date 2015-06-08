<?PHP

	session_start();	
//	$conn = mysql_connect("bookmane.in", "bookmane_user1", "test123"); // Establishing Connection with Server
	 $conn = mysql_connect("localhost:3306", "root", "pwd"); // Establishing Connection with Server



	if(! $conn){
        	die("Connection failed: " . mysql_error());
	}

	$name = $_POST['name'];
	$email = $_POST['email'];
	$category = $_POST['category'];
	$tech = $_POST['technology'];
	$loc = $_POST['location'];
	$abt = $_POST['about'];
	$id = $_SESSION['twitter_id'];

	if(isset($_POST['optradio'])){
		$list = $_POST['optradio'];
	}

	$sql ="INSERT INTO company(id,name,email,twitter_id,category,technology,location,about,createList) VALUES (NULL,'$name','$email','$id','$category','$tech','$loc','$abt','$list')";
        mysql_select_db('handbook');
	//mysql_select_db('bookmane_handbook');
        $insert = mysql_query( $sql, $conn );



	
	//file upload code
	if(!is_dir("uploads")) {
		mkdir("uploads",0777);
	}
	$fileName = $_FILES["file"]["name"]; 
	$fileTmpLoc = $_FILES["file"]["tmp_name"];
//	$temp = $id ;
	$temp = mysql_insert_id();
	// Path and file name
	//$pathAndName = "uploads/".$fileName;
	rename($pathAndName,$temp);
	move_uploaded_file($fileTmpLoc, "uploads/".$temp);

	exec("find uploads/ -type f -exec chmod 0777 {} +");
	
//	$sql ="INSERT INTO company(id,name,twitter_id,category,technology,location,about,create_list) VALUES (NULL,'$name','$id','$category','$tech','$loc','$abt','$list')";
//	mysql_select_db('handbook');
//	mysql_select_db('bookmane_handbook');
//	$insert = mysql_query( $sql, $conn );

	if (! $insert) {
        	die('Could not enter data: ' . mysql_error());
	} else {
		mysql_close($conn);
		header('Location: mypage.php');
	}
?>
