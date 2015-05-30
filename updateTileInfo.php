<?PHP
$conn = mysql_connect("localhost:3306", "root", "pwd"); // Establishing Connection with Server


if(! $conn){
	die("Connection failed: " . mysql_error());
}


$name = $_GET['name'];
$intent = $_GET['intent'];
$loc = $_GET['location'];
$abt = $_GET['abt'];
$teach = $_GET['teach'];
$venue = $_GET['venue'];
$rsvp = $_GET['rsvp'];
$id = $_GET['id'];
$twitter_id = $_GET['twitter_id'];

echo $name,$intent,$abt,$teach,$venue,$rsvp,$id,$twitter_id;

$sql ="UPDATE topics SET name = '$name' ,intent='$intent',location='$loc', about ='$abt' ,canTeach ='$teach',venue='$venue',rsvp='$rsvp' WHERE twitter_id='$twitter_id' AND id='$id'";
mysql_select_db('handbook');
$insert = mysql_query( $sql, $conn );


mysql_close($conn);
header('Location: mypage.php');
?>



