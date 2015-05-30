<?PHP

	session_start();	
	$conn = mysql_connect("localhost:3306", "root", "pwd"); // Establishing Connection with Server


	if(! $conn){
        	die("Connection failed: " . mysql_error());
	}

	$name = $_POST['name'];
	$category = $_POST['category'];
	$loc = $_POST['location'];
	$abt = $_POST['about'];
	$id = $_SESSION['twitter_id'];

	if(isset($_POST['optradio'])){
		$list = $_POST['optradio'];
	}

	
	//file upload code
	if(!is_dir("uploads")) {
		mkdir("uploads",0777);
	}
	$fileName = $_FILES["file"]["name"]; 
	$fileTmpLoc = $_FILES["file"]["tmp_name"];
	$temp = $id ;
	// Path and file name
	$pathAndName = "uploads/".$fileName;
	rename($pathAndName,$temp);
	move_uploaded_file($fileTmpLoc, "uploads/".$temp);

	exec("find uploads/ -type f -exec chmod 0777 {} +");
	
	$sql ="INSERT INTO company(id,name,twitter_id,category,location,about,create_list) VALUES (NULL,'$name','$id','$category','$loc','$abt','$list')";
	mysql_select_db('handbook');
	$insert = mysql_query( $sql, $conn );

	if (! $insert) {
        	die('Could not enter data: ' . mysql_error());
	} else {
    		echo "Data entered successfully";
	}

	mysql_close($conn);
	header('Location: mypage.php');
?>
