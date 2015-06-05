<?PHP

	session_start();	
//	$conn = mysql_connect("localhost:3306", "root", "pwd"); // Establishing Connection with Server
	$conn = mysql_connect("bookmane.in", "bookmane_user1", "test123"); // Establishing Connection with Server



	if(! $conn){
        	die("Connection failed: " . mysql_error());
	}

	$name = $_GET['Uname']; //$_POST['Uname'];
	$category = $_GET['Ucategory']; //$_POST['Ucategory'];
	$tech = $_GET['Utechnology']; //$_POST['Utechnology'];
	$loc = $_GET['Ulocation']; //$_POST['Ulocation'];
	$abt = $_GET['Uabout']; //$_POST['Uabout'];
	$id = $_GET['twitter_id']; //$_SESSION['twitter_id'];
	$list = $_GET['createList'];

	//if(isset($_POST['optradio'])){
	//	$list = $_POST['optradio'];
	//}

	
	//file upload code
	//if(!is_dir("images/uploads/")) {
	//	mkdir("images/uploads/");
//	}

//	move_uploaded_file($_FILES["file"]["tmp_name"],"images/uploads/" . $_FILES["Ufile"]["name"]);
//	$picname1=$_FILES['Ufile']['name'];	

	
	$sql ="UPDATE company SET name = '$name' ,category='$category',technology='$tech',location ='$loc' ,about ='$abt',create_list='$list' WHERE twitter_id='$id'";
//	mysql_select_db('handbook');
	mysql_select_db('bookmane_handbook');
	$insert = mysql_query( $sql, $conn );

	//if (! $insert) {
        //	die('Could not enter data: ' . mysql_error());
	//} else {
    	//	echo "Data entered successfully";
	//}

	mysql_close($conn);
	header('Location: mypage.php');
?>
