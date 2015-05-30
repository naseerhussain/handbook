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
	if(!is_dir("images/uploads/")) {
		mkdir("images/uploads/");
	}

	move_uploaded_file($_FILES["file"]["tmp_name"],"images/uploads/" . $_FILES["file"]["name"]);
	$picname1=$_FILES['file']['name'];	

	
	$sql ="INSERT INTO company(id,name,twitter_id,category,location,about,image_url,create_list) VALUES (NULL,'$name','$id','$category','$loc','$abt','$picname1','$list')";
	mysql_select_db('handbook');
	$insert = mysql_query( $sql, $conn );

	//if (! $insert) {
        //	die('Could not enter data: ' . mysql_error());
	//} else {
    	//	echo "Data entered successfully";
	//}

	mysql_close($conn);
	header('Location: mypage.php');
?>
