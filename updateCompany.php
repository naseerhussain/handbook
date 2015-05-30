<?PHP

	session_start();	
	$conn = mysql_connect("localhost:3306", "root", "pwd"); // Establishing Connection with Server


	if(! $conn){
        	die("Connection failed: " . mysql_error());
	}

	$name = $_POST['Uname'];
	$category = $_POST['Ucategory'];
	$loc = $_POST['Ulocation'];
	$abt = $_POST['Uabout'];
	$id = $_SESSION['twitter_id'];

	if(isset($_POST['optradio'])){
		$list = $_POST['optradio'];
	}

	
	//file upload code
	if(!is_dir("images/uploads/")) {
		mkdir("images/uploads/");
	}

	move_uploaded_file($_FILES["file"]["tmp_name"],"images/uploads/" . $_FILES["Ufile"]["name"]);
	$picname1=$_FILES['Ufile']['name'];	

	
	$sql ="UPDATE company SET name = '$name' ,category='$category',location ='$loc' ,about ='$abt',image_url='$picname1',create_list='$list' WHERE twitter_id='$id'";
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
