<?PHP

        session_start();
        $conn = mysql_connect("localhost:3306", "root", "pwd"); // Establishing Connection with Server


        if(! $conn){
                die("Connection failed: " . mysql_error());
        }

	$name = $_POST['lname'];
        $intent = $_POST['lintent'];
	$loc = $_POST['llocation'];
        $abt = $_POST['labout'];
	$id = $_SESSION['twitter_id'];

	if(isset($_POST['teach'])){
                $teach = $_POST['teach'];
        }

	if(isset($_POST['venue'])){
                $venue = $_POST['venue'];
        }

	if(isset($_POST['rsvp'])){
                $rsvp = $_POST['rsvp'];
        }
	
	$sql ="INSERT INTO topics(id,name,intent,location,about,canTeach,venue,rsvp,twitter_id) VALUES (NULL,'$name','$intent','$loc','$abt','$teach','$venue','$rsvp','$id')";
        mysql_select_db('handbook');
        $insert = mysql_query( $sql, $conn );

	mysql_close($conn);
        header('Location: mypage.php');

?>
