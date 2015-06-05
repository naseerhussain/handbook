<?php

        require_once('toJson.php');
        session_start();

                //$conn = mysql_connect("localhost:3306", "root", "pwd"); // Establishing Connection with Server
		$conn = mysql_connect("bookmane.in", "bookmane_user1", "test123"); // Establishing Connection with Server



                if(! $conn){
                        die("Connection failed: " . mysql_error());
                }
                $query = 'select *from company';// where twitter_id ="' . $_SESSION['twitter_id'].'"';

                //$query ='select *from company';
//                mysql_select_db('handbook');
		mysql_select_db('bookmane_handbook');
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


?>
<?php

        require_once('toJson.php');
        session_start();

       //         $conn = mysql_connect("localhost:3306", "root", "pwd"); // Establishing Connection with Server
		$conn = mysql_connect("bookmane.in", "bookmane_user1", "test123"); // Establishing Connection with Server



                if(! $conn){
                        die("Connection failed: " . mysql_error());
                }
                $sql = 'select *from topics';// where twitter_id ="' . $_SESSION['twitter_id'].'"';

                //$query ='select *from company';
//                mysql_select_db('handbook');
		mysql_select_db('bookmane_handbook');
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
	height:35%;
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

var company = '<?php echo $result; ?>';
    company = JSON.parse(company);
        
var getTilesInfo = '<?php echo $topics; ?>';
    getTilesInfo = JSON.parse(getTilesInfo);

$(document).ready(function(){
	$("#goBack").hide();

	for(var i=0;i<company.length;i++){
		var div = '<div class="thumbnail"><div style="height:120px;width:100%;overflow:hidden;"><img src="uploads/'+company[i].id+'" height="100%" width="100%"></div><legend ><div style="text-align:center">'+company[i].name+'</div></legend><p class="text-center">'+company[i].category+'</p><p class="text-center">'+company[i].technology+'</p><a class="divLink" id="'+company[i].name+'" zid="'+company[i].twitter_id+'"></a><p class="text-center">'+company[i].location+'</p></div>';
                $("#thumbnails").append(div);   
        }

	$(".thumbnail").click(function(){
                var clicked = $(this).find("a:first").attr("id");
                var zid = $(this).find("a:first").attr("zid");
                console.log(clicked);
                console.log(zid);
		$("#table").hide();
		$("#goBack").show();
		clearContainer();		
		drawTopicsTiles(getTilesInfo, zid, clicked);
        });

	$("#crowdlearn").click(function(){
	//	clearContainer();
		location.reload();	
	});

	$("#searchCategory").keyup(function(){
                clearContainer();
                var search = $("#searchCategory").val();
                filteredResults(company, search, "category");
        });

	//Search technology function
        $("#searchTech").keyup(function(){
                clearContainer();
                var search = $("#searchTech").val();
                filteredResults(company, search, "technology");
        });
	
	$("#searchLocation").keyup(function(){
		clearContainer();
		var search = $("#searchLocation").val();
		filteredResults(company,search,"location");
	});

});

function clearContainer(){
        $("div .thumbnail").remove();
}

function drawTopicsTiles(getTilesInfo, zid, clicked){

	for(var i=0;i<getTilesInfo.length;i++){
		if(getTilesInfo[i].twitter_id == zid && getTilesInfo[i].companyName == clicked){
			 var div = '<div class="thumbnail"><legend>'+getTilesInfo[i].name+'</legend><p>'+getTilesInfo[i].intent+'</p><p>'+getTilesInfo[i].about+'</p><p>Can Teach :'+getTilesInfo[i].canTeach+'</p><p>Venue :'+getTilesInfo[i].venue+'</p><p>RSVP :'+getTilesInfo[i].rsvp+'</p><p><a class="divLink" id="'+getTilesInfo[i].name+'" zid="'+getTilesInfo[i].id+'"></a></div>';

	                $("#thumbnails").append(div);   

		}
	}	
}

function filteredResults(company,search, attribute){
        
        for(var i=0;i<company.length;i++){
                var str = company[i];
                str = str[attribute];
                if(str.search(search) > -1){
			var div = '<div class="thumbnail"><div style="height:120px;width:100%;overflow:hidden;"><img src="uploads/'+company[i].id+'" height="100%" width="100%"></div><legend ><div style="text-align:center">'+company[i].name+'</div></legend><p class="text-center">'+company[i].category+'</p><p class="text-center">'+company[i].technology+'</p><a class="divLink" id="'+company[i].name+'" zid="'+company[i].twitter_id+'"></a><p class="text-center">'+company[i].location+'</p></div>';

                        $("#thumbnails").append(div);   
                }


        }
	$(".thumbnail").click(function(){
                var clicked = $(this).find("a:first").attr("id");
                var zid = $(this).find("a:first").attr("zid");
                console.log(clicked);
                console.log(zid);
                $("#table").hide();
                $("#goBack").show();
                clearContainer();               
                drawTopicsTiles(getTilesInfo, zid);
        });

}


</script>
</head>
<body>
	<div class="container">
		<br>
		<!--<button class="btn btn-sm pull-left btn-info" style="margin-right:2%;" id="goBack">Go Back</button>-->
		<a id="crowdlearn" style="cursor:hand;margin-top:45px;position:absolute;">Crowdlearn</a><br>


		<a class="pull-right" style="margin-right:2%;margin-top:25px" data-toggle="modal" data-target="#myModal">Sign In</a>
		<div class="row" style="margin-top:5%">
			<div class="col">
				<table class="table table-condensed" style="text-align:center;" id="table">
    					<thead>
        					<tr>
            						<th style="text-align:center">Category</th>
            						<th style="text-align:center">Technology</th>
            						<th style="text-align:center">Location</th>
        					</tr>
    					</thead>
					<tbody>
						<tr>
							<td><input type="text" id="searchCategory"></td>
							<td><input type="text" id="searchTech"></td>
							<td><input type="text" id="searchLocation"></td>
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


		<div id="myModal" class="modal fade" role="dialog">
		  <div class="modal-dialog">

    		<!-- Modal content-->
    			<div class="modal-content" style="width:50%;">
      				<div class="modal-header" style="background-color:#428bca;border-top-left-radius: 4px;border-top-right-radius: 4px">
        				<button type="button" class="close" data-dismiss="modal">&times;</button>
        				<h4 class="modal-title" style="color:white">Sign In</h4>
      				</div>
      				<div class="modal-body">
					<!--<p id="error"></p>
					<form>
						<label class="block">User Id :</label><br>
						<input type="text" id="userId" class="block" style="width:100%;"><br>
						<label class="block">Password :</label><br>
						<input type="text" id="pwd" class="block" style="width:100%;"><br><br>
						<label>Not Having Account ? <a id="signUpPopUp" data-toggle="modal" >Sign Up</a></label><br>
					</form>-->
					<a href="login.php"><img src="images/tw_login.png"></a>
      				</div>
      				<div class="modal-footer">
        				<!--<button type="button" class="btn btn-primary" id="signIn" >Sign In</button>-->
      				</div>
    			</div>

  		</div>
		</div>		


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
                                        <form>
                                                <label class="block">Name :</label><br>
                                                <input type="text" id="name" class="block" style="width:100%;"><br>
                                                <label class="block">What Category :</label><br>
                                                <input type="text" id="category" class="block" style="width:100%;"><br>
						<label>Location : </label><br>
						<input type="text" id="location" class="block" style="width:100%"><br>
						<label>About : </label><br>
						<textarea id="about" style="width:100%" rows=5></textarea><br>
						<label style="width:100%" class="block">Will Create the list : <label><br>
					 	<div class="radio">
  							<label><input type="radio" name="optradio">Yes</label>
  							<label><input type="radio" name="optradio">No</label>
						</div>	
                                        </form>
                                </div>
                                <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" id="signUp" >Sign Up</button>
                                </div>
                        </div>

                </div>  
                </div>

	
	</div>
	<!-- Details page test demo using smoothjs -->
	<div class="m-scene" id="main">
  		<div class="m-header scene_element scene_element--fadein">
    			...
  		</div>
  		<div class="m-page scene_element scene_element--fadeinup">
    			...
  		</div>
	</div>
</body>
</html>

