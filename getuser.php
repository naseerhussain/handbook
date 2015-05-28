<?PHP
$conn = mysql_connect("localhost:3306", "root", "pwd"); // Establishing Connection with Server


if(! $conn){
	die("Connection failed: " . mysql_error());
}


$compName = $_GET['name'];
$compDesc = $_GET['cDesc'];
$compProduct = $_GET['cProd'];
$skills = $_GET['skills'];
$url = $_GET['url'];
$category = $_GET['category'];


$sql ="INSERT INTO company(id,companyName,description,category,product,skills,url) VALUES (NULL,'$compName','$compDesc','$category','$compProduct','$skills','$url')";
mysql_select_db('handbook');
$insert = mysql_query( $sql, $conn );

if (! $insert) {
	die('Could not enter data: ' . mysql_error());
} else {
    echo "Data entered successfully";
}

mysql_close($conn);
?>



