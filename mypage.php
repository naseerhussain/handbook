<?php
session_start();
require_once('twitteroauth/twitteroauth.php');
include('config.php');


if(isset($_SESSION['name']) && isset($_SESSION['twitter_id'])) //check whether user already logged in with twitter
{

        /*echo "Name :".$_SESSION['name']."<br>";
        echo "Twitter ID :".$_SESSION['twitter_id']."<br>";
        echo "Image :<img src='".$_SESSION['image']."'/><br>";
        echo "<br/><a href='logout.php'>Logout</a>";
        //header('Location: main.php');*/

        $conn = mysql_connect("localhost:3306", "root", "pwd"); // Establishing Connection with Server


        if(! $conn){
                die("Connection failed: " . mysql_error());
        }


        $id = $_SESSION['twitter_id'];
        $name = $_SESSION['name'];

        $sql = "INSERT INTO users(id,twitter_id,name)VALUES(NULL,'$id','$name')";
        mysql_select_db('handbook');
        $insert = mysql_query( $sql, $conn );
        mysql_close($conn); 
}
else // Not logged in
{

        $connection = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET);
        $request_token = $connection->getRequestToken($OAUTH_CALLBACK); //get Request Token

        if(     $request_token)
        {
                $token = $request_token['oauth_token'];
                $_SESSION['request_token'] = $token ;
                $_SESSION['request_token_secret'] = $request_token['oauth_token_secret'];

                switch ($connection->http_code)
                {
                        case 200:
                                $url = $connection->getAuthorizeURL($token);
                                //redirect to Twitter .
                        header('Location: ' . $url);
                            break;
                        default:
                            echo "Coonection with twitter Failed";
                        break;
                }

        }
        else //error receiving request token
        {
                echo "Error Receiving Request Token";
        }


}
?>

<?php

	require_once('toJson.php');
	session_start();

	if(isset($_SESSION['name']) && isset($_SESSION['twitter_id'])) //check whether user already logged in with twitter
	{
		$conn = mysql_connect("localhost:3306", "root", "pwd"); // Establishing Connection with Server


	        if(! $conn){
        	        die("Connection failed: " . mysql_error());
        	}
		$query = 'select *from company where twitter_id ="' . $_SESSION['twitter_id'].'"';

		//$query ='select *from company';
		mysql_select_db('handbook');
	        $retval = mysql_query( $query, $conn );
		if(! $retval )
		{
  			die('Could not get data: ' . mysql_error());
		}
		$rows = array();
		while($row = mysql_fetch_array($retval, MYSQL_ASSOC))
		{
			$rows[] = $row;
		}
		$result = json_encode($rows);
        	mysql_close($conn);
			
	}
	
?>
<?php

	require_once('toJson.php');
        session_start();

        if(isset($_SESSION['name']) && isset($_SESSION['twitter_id'])) //check whether user already logged in with twitter
        {
                $conn = mysql_connect("localhost:3306", "root", "pwd"); // Establishing Connection with Server


                if(! $conn){
                        die("Connection failed: " . mysql_error());
                }
                $sql = 'select *from topics where twitter_id ="' . $_SESSION['twitter_id'].'"';

                //$query ='select *from company';
                mysql_select_db('handbook');
                $ret = mysql_query( $sql, $conn );

                if(! $ret )
                {
                        die('Could not get data: ' . mysql_error());
                }
                $arr = array();
                while($row = mysql_fetch_array($ret, MYSQL_ASSOC))
                {
                        $arr[] = $row;
                }
                $topics = json_encode($arr);
                mysql_close($conn);

        }

?>

<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">

	<link href="css/bootstrap.min.css" rel="stylesheet">

	<link href="css/smoothState.css" rel="stylesheet">


        <script type="text/javascript" charset="utf-8" src="lib/jquery.min.js"></script>

	<script type="text/javascript" src="lib/bootstrap.min.js"></script>

<!--	<script type="text/javscript" src="lib/bootstrap-dialog.js"></script>-->

	<script type="text/javascript" src="lib/masonry.pkgd.min.js"></script>

<!--	<script type="text/javascript" src="lib/jquery.smoothState.js"></script>

	<script type="text/javscript" src="lib/function.js"></script>

	<script type="text/javascript" src="lib/bootstrap-transition.js"></script>

	<script type="text/javascript" src="lib/bootstrap-modal.js"></script>-->

<title>New App</title>

<style>
.thumbnails{
	float:left;
}
	
.thumbnail{
	width:30%;
	height:30%;
	margin-top:3%;
	margin-left:2%;
	float:left;
	
}

.well {
	width:100%;
	height:100%;
}

div.thumbnail {
    position: relative;
    /*width: 200px;
    height: 200px;*/
    background: #F8F8F8;
    color: #000;
    padding: 20px;    
}
 
div.thumbnail:hover {
    cursor: hand;
    cursor: pointer;
    opacity: .9;
}
 
a.divLink {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    text-decoration: none;
    z-index: 10;
    background-color: white;
    opacity: 0;
    filter: alpha(opacity=0);
}

</style>

<script>
 $(document).ready(function(){
	var db_results = '<?php echo $result; ?>';
	db_results = JSON.parse(db_results);
	
	var getTilesInfo = '<?php echo $topics; ?>';
	getTilesInfo = JSON.parse(getTilesInfo);

	var id = '<?php echo $_SESSION['twitter_id'];?>';

	$("#logout").hide();

	if(db_results.length < 1){
		$("#signUpModal").modal('show');
	}
	if(getTilesInfo.length == 0){
		for(var key in db_results){
			if(db_results[key].create_list == "yes" && db_results[key].twitter_id == id){
				$("#topicTileModal").modal('show');
			}
		}
	}

	for(var i=0;i<getTilesInfo.length;i++){
		var div = '<div class="thumbnail"><legend>'+getTilesInfo[i].name+'</legend><p>'+getTilesInfo[i].intent+'</p><p>'+getTilesInfo[i].about+'</p><p>Can Teach :'+getTilesInfo[i].canTeach+'</p><p>Venue :'+getTilesInfo[i].venue+'</p><p>RSVP :'+getTilesInfo[i].rsvp+'</p><p><a class="divLink" id="'+getTilesInfo[i].name+'" zid="'+getTilesInfo[i].id+'"></a></p></div>';

		$("#thumbnails").append(div);	
	}
	
	$("#searchCompany").keyup(function(){
		clearContainer();
		var search = $("#searchCompany").val();
		filteredResults(getTilesInfo, search, "cName");
	});	
	
	$("#searchCategory").keyup(function(){
		clearContainer();
		var search = $("#searchCategory").val();
		filteredResults(getTilesInfo, search, "compProduct");
	});

	$("#searchTech").keyup(function(){
		clearContainer();
		var search = $("#searchTech").val();
		filteredResults(getTilesInfo, search, "skills");
	});

	$(".thumbnail").click(function(){
		var clicked = $(this).find("a:first").attr("id");
		var zid = $(this).find("a:first").attr("zid");
		console.log(clicked);
		console.log(zid);
		if(clicked != undefined && zid != undefined){
			//window.location.href = "details.html?id='"+clicked+"'&zid='"+zid+"'";
		}
	});


	$("#signUpPopUp").click(function(){
		$("#myModal").modal('toggle');
		$("#signUpModal").modal('toggle');
	});

	$("#signUp").click(function(){
		$("#signUpModal").modal('toggle');
	});

	$("#updateInfo").click(function(){
		//$("#Uname").val(db_results[])
		$("#updateProfileModal").modal('toggle');
		console.log(db_results);
		$("#Uname").val(db_results[0].name);
		$("#Ucategory").val(db_results[0].category);
		$("#Ulocation").val(db_results[0].location);
		$("#Uabout").val(db_results[0].about);
		
		if(db_results[0].create_list == "yes"){
			$("#Uyes").prop('checked',true);
		}else{
			$("#Uno").prop('checked',true);
		}

	});
 });

function getInfo(){
	var jTable = localStorage.getItem("jobBase") || {};
	
	if(Object.size(jTable) > 0){
		jTable = JSON.parse(jTable);
	}
	return jTable;
}

function filteredResults(getTilesInfo,search, attribute){
	var size = Object.key(getTilesInfo);
	
	for(var i=1;i<=size;i++){
		var str =getTilesInfo[i];
		str = str[attribute];
		if(str.search(search) > -1){
			var div = '<div class="thumbnail"><video src='+getTilesInfo[i].url+' controls="true"></video><legend>'+getTilesInfo[i].cName+'</legend><legend><p>'+getTilesInfo[i].compDesc+'</p><p>'+getTilesInfo[i].category+'</p></legend><p>'+getTilesInfo[i].compProduct+'</p><legend></legend><p>'+getTilesInfo[i].skills+'</p><p><a class="divLink" id="'+getTilesInfo[i].cName+i+'"></a></p></div>';
	                $("#thumbnails").append(div);   

		}
	}
}

function clearContainer(){
	$("div .thumbnail").remove();

//	var thumb = "<div class='thumbnail'><h3>Post Job</h3><p>Company Name</p><p>Company Description</p><p>Products</p><p>Required Skills</p></div>";
//	$("#thumbnails").append(thumb);
}
	

Object.size = function(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};

Object.key = function(obj){
        var size = 0;

        for(key in obj){
                size= key;
        }
        return size;
}

function validation(){
	var name = $("#name").val();
	var category = $("#category").val();
	var loc = $("#location").val();
	var abt = $("#about").val();
	var file = $("#file").val();
	
	if(name == ""){
		alert("Please enter the name ");
		return false;
	}	
	
	if(category == ""){
		alert("Please enter the category");
		return false;
	}
	
	if(loc == ""){
		alert("Please enter the location");
		return false;
	}

	if(abt == ""){
		alert("Please enter about");
		return false;
	}
	
	if(file == ""){
		alert("Upload a image file or company logo");
		return false;
	}
	return true;
}

function validateListInfo(){
	var name = $("#lname").val();
	var intent = $("#lintent").val();
	var abt = $("labout").val();
	
	if(name == ""){
		alert("Please Enter the name");
		return false;
	}
	if(intent == ""){
		alert("Please enter the intent");
		return;
	}
	if(abt == ""){
		alert("Please enter the about");
		return;
	}
	return true;
}

</script>
</head>
<body>
	<div class="container">
		<br><br>
		<a href="logout.php" class="btn btn-sm btn-danger pull-right">Log Out <?php echo $_SESSION['name'];?></a>
		<!--<a href="createTile.html" id="create" class="btn btn-sm pull-right btn-primary" style="margin-right:2%;">Create</a>-->

		<button class="btn btn-sm pull-right btn-info" id="updateInfo" data-target="#updateProfileModal" style="margin-right:2%;">Update Profile</button>

		<button class="btn btn-sm pull-left btn-info" data-toggle="modal" data-target="#topicTileModal" style="margin-right:2%;">Create Topic/Subject</button>

	<!--	<button class="btn btn-sm pull-right btn-primary" style="margin-right:2%;" data-toggle="modal" data-target="#myModal">Sign In</button>-->
		<div class="row" style="margin-top:5%">
			<div class="col">
				<table class="table table-condensed" style="text-align:center;">
    					<thead>
        					<tr>
            						<th style="text-align:center">Start Up</th>
            						<th style="text-align:center">Category</th>
            						<th style="text-align:center">Technology Used</th>
        					</tr>
    					</thead>
					<tbody>
						<tr>
							<td><input type="text" id="searchCompany"></td>
							<td><input type="text" id="searchCategory"></td>
							<td><input type="text" id="searchTech"></td> 
						</tr>
					<tbody>
				</table>
			</div>
		</div>
		<div class="row" style="margin-top:2%; background-color:#E0E0E0;">
			<div class = "tiles">
				<!--<div class="tiles-li col-sm-6 col-md-4 col-lg-3"><div class="well">3<br>product</div></div>-->
				<div class="masonry-container" id="thumbnails">
				</div>  
			</div>
		</div>

		<!-- SIDN IN THROUGH TWITTER MODAL-->
		<div id="myModal" class="modal fade" role="dialog">
		  <div class="modal-dialog">

    		<!-- Modal content-->
    			<div class="modal-content" style="width:50%;">
      				<div class="modal-header" style="background-color:#428bca;border-top-left-radius: 4px;border-top-right-radius: 4px">
        				<button type="button" class="close" data-dismiss="modal">&times;</button>
        				<h4 class="modal-title" style="color:white">Sign In</h4>
      				</div>
      				<div class="modal-body">
					<a href="login.php"><img src="images/tw_login.png"></a>
      				</div>
      				<div class="modal-footer">
        				<!--<button type="button" class="btn btn-primary" id="signIn" >Sign In</button>-->
      				</div>
    			</div>

  		</div>
		</div>		

		<!-- SIGN UP COMPANY DETAILS MODAL-->
		<div id="signUpModal" class="modal fade" role="dialog">
                  <div class="modal-dialog">

                <!-- Modal content-->
                        <div class="modal-content" style="width:70%;">
                                <div class="modal-header" style="background-color:#428bca;border-top-left-radius: 4px;border-top-right-radius: 4px">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title" style="color:white">Sign Up</h4>
                                </div>
                                <div class="modal-body">
					<p id="error"></p>
					<form method="post" action="saveCompany.php" enctype="multipart/form-data" onsubmit="return validation();">
                                                <label class="block">Name :</label><br>
                                                <input type="text" name="name" id="name" class="block" style="width:100%;"><br>
                                                <label class="block">What Category :</label><br>
                                                <input type="text" name="category" id="category" class="block" style="width:100%;"><br>
						<label>Location : </label><br>
						<input type="text" name="location" id="location" class="block" style="width:100%"><br>
						<label>About : </label><br>
						<textarea id="about" name="about" style="width:100%" rows=5></textarea><br>
						<label style="width:100%" class="block">Will Create the list : <label>
					 	<div class="radio">
  							<label><input type="radio" name="optradio" value="yes" checked>Yes</label>
  							<label><input type="radio" name="optradio" value="no">No</label>
						</div>	
						<div>
						    	<span><label>Upload Company Logo/Other Image :</label></span>
						    	<span><input type="file" id="file" name="file"/></span><br>
						    	<!-- <span><input type="submit" value="ADD"  style="float: left;" ></span>-->
						</div>
						<input type="submit" value="Save Info" class="btn btn-primary pull-right" >
                                        </form>
                                </div>
                                <div class="modal-footer">
	                                 <!--<button type="submit" class="btn btn-primary" id="signUp" >Sign Up</button>-->
                                </div>
                        </div>

                </div>  
                </div>

		 <!-- UPDATE COMPANY DETAILS MODAL-->
                <div id="updateProfileModal" class="modal fade" role="dialog">
                  <div class="modal-dialog">

                <!-- Modal content-->
                        <div class="modal-content" style="width:70%;">
                                <div class="modal-header" style="background-color:#428bca;border-top-left-radius: 4px;border-top-right-radius: 4px">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title" style="color:white">Update Profile</h4>
                                </div>
                                <div class="modal-body">
                                        <p id="error"></p>
                                        <form method="post" action="updateCompany.php" enctype="multipart/form-data" onsubmit="return fillInfo();">
                                                <label class="block">Name :</label><br>
                                                <input type="text" name="Uname" id="Uname" class="block" style="width:100%;"><br>
                                                <label class="block">What Category :</label><br>
                                                <input type="text" name="Ucategory" id="Ucategory" class="block" style="width:100%;"><br>
                                                <label>Location : </label><br>
                                                <input type="text" name="Ulocation" id="Ulocation" class="block" style="width:100%"><br>
                                                <label>About : </label><br>
                                                <textarea id="Uabout" name="Uabout" style="width:100%" rows=5></textarea><br>
                                                <label style="width:100%" class="block">Will Create the list : <label>
                                                <div class="radio">
                                                        <label><input type="radio" name="optradio" id="Uyes" value="yes" checked>Yes</label>
                                                        <label><input type="radio" name="optradio" id="Uno" value="no">No</label>
                                                </div>
                                                <div>
                                                        <span><label>Upload Company Logo/Other Image :</label></span>
                                                        <span><input type="file" id="Ufile" name="Ufile"/></span><br>
                                                        <!-- <span><input type="submit" value="ADD"  style="float: left;" ></span>-->
                                                </div>
                                                <input type="submit" value="Update Profile" class="btn btn-primary pull-right" >
                                        </form>
                                </div>
                                <div class="modal-footer">
                                         <!--<button type="submit" class="btn btn-primary" id="signUp" >Sign Up</button>-->
                                </div>
                        </div>
		</div>
		</div>


		<!-- CREATE TILE FOR SUBJECT/TOPIC LIST-->
                <div id="topicTileModal" class="modal fade" role="dialog">
                  <div class="modal-dialog">

                <!-- Modal content-->
                        <div class="modal-content" style="width:70%;">
                                <div class="modal-header" style="background-color:#428bca;border-top-left-radius: 4px;border-top-right-radius: 4px">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title" style="color:white">Create Subject/Topic</h4>
                                </div>
                                <div class="modal-body">
					<form method="post" action="saveTopic.php" enctype="multipart/form-data" onsubmit="return validateListInfo();">
						<label class="block">Topic/Subject Name :</label><br>
                                                <input type="text" name="lname" id="lname" class="block" style="width:100%;"><br>
                                                <label class="block">Intent :</label><br>
                                                <input type="text" name="lintent" id="lintent" class="block" style="width:100%;"><br>
						<label>About the Topic/Subject : </label><br>
                                                <textarea id="labout" name="labout" style="width:100%" rows=5></textarea><br>
						<label>Others can teach this : </label>&nbsp;&nbsp;
						<!-- <div class="radio">-->
                                                        <label><input type="radio" name="teach" value="yes" checked>Yes</label>&nbsp;&nbsp;
                                                        <label><input type="radio" name="teach" value="no">No</label>
                                                <!--</div>-->
						<br><label >Venue : </label>
						<!--<div class="radio">-->
                                                        <label><input type="radio" name="venue" value="notAvailable" checked>To be Decided</label>&nbsp;&nbsp;
                                                        <label><input type="radio" name="venue" value="Available" >Available</label>
                                                <!--</div>-->
						<br><label >Create RSVP : </label>&nbsp;&nbsp;
						<!--<div class="radio" style="width:100%">-->
                                                        <label><input type="radio" name="rsvp" value="yes" checked>Yes</label>&nbsp;&nbsp;
                                                        <label><input type="radio" name="rsvp" value="no">No</label>
                                                <!--</div><br>-->
						<br><br><input type="submit" value="Save Info" class="btn btn-primary pull-right" >

					</form>
                                </div>
                                <div class="modal-footer">
                                        <!--<button type="button" class="btn btn-primary" id="signIn" >Sign In</button>-->
                                </div>
                        </div>

                </div>
                </div>


	
	</div>
</body>
</html>
