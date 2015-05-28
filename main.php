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
 $(document).ready(function(){
	$("#logout").hide();
	var getTilesInfo = getInfo();
	var size = Object.key(getTilesInfo);
	var isGuest = localStorage.getItem("isGuest") || false;
	isGuest = (isGuest == "true") ? true : false; 
	if(isGuest){
		$("#create").hide();
		$("#logout").hide();	
	}

	for(var i=1;i<=size;i++){
		var div = '<div class="thumbnail"><video src='+getTilesInfo[i].url+' controls="true"></video><legend>'+getTilesInfo[i].cName+'</legend><legend><p>'+getTilesInfo[i].compDesc+'</p><p>'+getTilesInfo[i].category+'</p></legend><p>'+getTilesInfo[i].compProduct+'</p><legend></legend><p>'+getTilesInfo[i].skills+'</p><p><a class="divLink" id="'+getTilesInfo[i].cName+'" zid="'+i+'"></a></p></div>';

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
			window.location.href = "details.html?id='"+clicked+"'&zid='"+zid+"'";
		}
	});

	$("#signIn").click(function(){
		var userId = $("#userId").val();
		var pwd = $("#pwd").val();
		if(userId=="" && pwd == ""){
			$("#error").html("Enter User name and Password");
			return;
		}
	});

	$("#signUpPopUp").click(function(){
		$("#myModal").modal('toggle');
		$("#signUpModal").modal('toggle');
	});

	$("#signUp").click(function(){
		$("#signUpModal").modal('toggle');
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



</script>
</head>
<body>
	<div class="container">
		<br><br>
		<a href="index.html" id="logout" class="btn btn-sm btn-danger pull-right">Log Out</a>
		<a href="createTile.html" id="create" class="btn btn-sm pull-right btn-primary" style="margin-right:2%;">Create</a>

		<!--<button class="btn btn-sm pull-right btn-info" data-toggle="modal" data-target="#signUpModal">Sign Up</button>-->

		<button class="btn btn-sm pull-right btn-primary" style="margin-right:2%;" data-toggle="modal" data-target="#myModal">Sign In</button>
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
