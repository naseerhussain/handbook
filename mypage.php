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
	//$conn = mysql_connect("bookmane.in", "bookmane_user1", "test123"); // Establishing Connection with Server



        if(! $conn){
                die("Connection failed: " . mysql_error());
        }


        $id = $_SESSION['twitter_id'];
        $name = $_SESSION['name'];

        $sql = "INSERT INTO users(id,twitter_id,name)VALUES(NULL,'$id','$name')";
        //mysql_select_db('bookmane_handbook');
	mysql_select_db("handbook");
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
//		$conn = mysql_connect("bookmane.in", "bookmane_user1", "test123"); // Establishing Connection with Server



	        if(! $conn){
        	        die("Connection failed: " . mysql_error());
        	}
		//$query = 'select *from company where twitter_id ="' . $_SESSION['twitter_id'].'"';

		$query ='select *from company';
	//	mysql_select_db('bookmane_handbook');
		mysql_select_db("handbook");
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
	//	$conn = mysql_connect("bookmane.in", "bookmane_user1", "test123"); // Establishing Connection with Server



                if(! $conn){
                        die("Connection failed: " . mysql_error());
                }
                $sql = 'select *from topics';// where twitter_id ="' . $_SESSION['twitter_id'].'"';

                //$query ='select *from company';
         //       mysql_select_db('bookmane_handbook');
		mysql_select_db("handbook");

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

<?php

        require_once('toJson.php');
        session_start();

        if(isset($_SESSION['name']) && isset($_SESSION['twitter_id'])) //check whether user already logged in with twitter
        {
                $conn = mysql_connect("localhost:3306", "root", "pwd"); // Establishing Connection with Server
        //      $conn = mysql_connect("bookmane.in", "bookmane_user1", "test123"); // Establishing Connection with Server



                if(! $conn){
                        die("Connection failed: " . mysql_error());
                }
                $sql2 = 'select *from venueDetails';// where twitter_id ="' . $_SESSION['twitter_id'].'"';

                //$query ='select *from company';
         //       mysql_select_db('bookmane_handbook');
                mysql_select_db("handbook");

                $retV = mysql_query( $sql2, $conn );

                if(! $retV )
                {
                        die('Could not get data: ' . mysql_error());
                }
                $venue = array();
                while($row = mysql_fetch_array($retV, MYSQL_ASSOC))
                {
                        $venue[] = $row;
                }
                $venueDetails = json_encode($venue);
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

	<link href="css/main.css" rel="stylesheet">

	<link href="css/overlay-bootstrap.min.css" rel="stylesheet">

	<link href="css/jquery.tagsinput.css" rel="stylesheet">

        <script type="text/javascript" charset="utf-8" src="lib/jquery.min.js"></script>

	<script type="text/javascript" src="lib/bootstrap.min.js"></script>

	<script type="text/javascript" src="lib/masonry.pkgd.min.js"></script>

	<script type="text/javascript" src="lib/bootstrap-tooltip.js"></script>
	
	<script type="text/javascript" src="lib/bootstrap-popover.js"></script>

	<script type="text/javascript" src="lib/jquery.tagsinput.js"></script>
<!--
	<script type="text/javscript" src="lib/function.js"></script>

	<script type="text/javascript" src="lib/bootstrap-transition.js"></script>

	<script type="text/javascript" src="lib/bootstrap-modal.js"></script>-->

<title>New App</title>
<style>
#crowdlearn:hover{
	cursor:hand;
}
</style>
<script>
var company = '<?php echo $result; ?>';
    company = JSON.parse(company);

var getTilesInfo = '<?php echo $topics; ?>';
    getTilesInfo = JSON.parse(getTilesInfo);

var venueDetails = '<?php echo $venueDetails; ?>';
    venueDetails = JSON.parse(venueDetails);

var id = '<?php echo $_SESSION['twitter_id'];?>';

$(document).ready(function(){
	//$("#mylistTabMenu").hide();

//	$(".tags").tagsInput();
	//$('.tags').tagsInput({onChange: onChangeTag});
	$('input.tags').tagsInput({onAddTag:onAddTag,onRemoveTag:onRemoveTag,onChange: onChangeTag});
//	$('.tags').tagsInput({interactive:false});
	//$("#searchTech").tagsInput();
	//$("#searchLocation").tagsInput();

	var isTile = 0;
	for(var k=0;k<company.length;k++){
		for(var i=0;i<getTilesInfo.length;i++){
			if(getTilesInfo[i].twitter_id == id && company[k].twitter_id == id){
				isTile += 1;
			}
		}
	}

	for(var k=0;k<company.length;k++){
		if(company[k].twitter_id == id){
			if(isTile == 0 && company[k].createList == "yes"){
				$("#topicTileModal").modal('toggle');
			}	
		}
	}

	for(var i=0;i<company.length;i++){
		if(company[i].twitter_id == id){
                	var div = '<div class="thumbnail"><div style="height:120px;width:100%;overflow:hidden;"><img src="uploads/'+company[i].id+'" height="100%;" width="100%"></div><legend ><div style="text-align:center">'+company[i].name+'</div></legend><p class="text-center">'+company[i].category+'</p><p class="text-center">'+company[i].technology+'</p><a class="divLink" id="'+company[i].name+'" zid="'+company[i].twitter_id+'"></a><p class="text-center">'+company[i].location+'</p><div class="changes" style="z-index:9999;"><legend><a class="remove1"><img src="images/edit.png" id="remove1" zid="'+company[i].id+'"title="Edit" width="15" height="15" class="pull-left" style="position:relative;top:10px;"></a><a class="remove2"><img src="images/delete.png" zid="'+company[i].id+'" id="remove2" title="Delete" width="15" height="15" class="pull-right" style="position:relative;top:10px;"></a></legend></div></div>';
		}else{
			var div = '<div class="thumbnail"><div style="height:120px;width:100%;overflow:hidden;"><img src="uploads/'+company[i].id+'" height="100%;" width="100%"></div><legend ><div style="text-align:center">'+company[i].name+'</div></legend><p class="text-center">'+company[i].category+'</p><p class="text-center">'+company[i].technology+'</p><a class="divLink" id="'+company[i].name+'" zid="'+company[i].twitter_id+'"></a><p class="text-center">'+company[i].location+'</p></div>';
		}
                $("#thumbnails").append(div);   
        }
	
	$(".thumbnail").click(function(){
                var clicked = $(this).find("a:first").attr("id");
                var zid = $(this).find("a:first").attr("zid");

		$("#mylistTabMenu").show();
		$("#company-tab").removeClass('active');
		$("#mylist-tab").addClass('active');
		$("#mylistTabMenu").addClass('active');
		$("#companyTabMenu").removeClass('active');
		//-showTileInfo(getTilesInfo, company,clicked,zid);  
		drawTiles(getTilesInfo, zid, clicked);
	});
	

	var compClicked;        
        $(".remove1").click(function(){
                event.stopPropagation();
                compClicked = $(this).find("img:first").attr("zid");
                $("#updateProfileModal").modal('show');
		
		for(var i=0;i<company.length;i++){
			if(company[i].id == compClicked){
				$("#Uname").val(company[i].name);
				$("#Uemail").val(company[i].email);
				$("#Ucategory").val(company[i].category);
				$("#Ulocation").val(company[i].location);
				$("#Utechnology").val(company[i].technology);
				$("#Uabout").val(company[i].about);
				$('input[name=optradio][value="'+company[i].create_list+'"]').prop('checked',true);
				
			}
		}
	});

	 // Function for deleting the topic tile
        $(".remove2").click(function(){
                event.stopPropagation();
                compClicked = $(this).find("img:first").attr("zid");
                $("#deleteCompTileModal").modal('show');
        });


	$("#companyTabMenu").click(function(){
		$("#mylistTabMenu").hide();
		$("#companyTabMenu").addClass('active');
		//$("#")
		location.reload();
	});

	$("#crowdlearn").click(function(){
		location.reload();
	});

	//Function to update the company profile
	$("#updateProfile").click(function(){
		var validate = validation();
		
		var name = $("#Uname").val();
		var email = $("#Uemail").val();
		var cat = $("#Ucategory").val();
		var loc = $("#Ulocation").val();
		var tech = $("#Utechnology").val();
		var comp = $("#Uabout").val();
		var list = $("input[name=optradio]").val();

		if(validate){
                        $("#editTopicModal").modal('hide');
                }else{
                        return false;
                }

		 //call updaeCompany.php file
                if (window.XMLHttpRequest) {
                        // code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                } else {
                       // code for IE6, IE5
                       xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                                //document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
                                console.log(xmlhttp.responseText);
                        }
                }
                xmlhttp.open("GET","updateCompany.php?name="+name+"&email="+email+"&category="+cat+"&location="+loc+"&tech="+tech+"&about="+comp+"&createList="+list+"id="+compClicked+"&twitter_id="+id, true);
                xmlhttp.send();
                location.reload();

	
	});

	// Delete company tiles 
         $("#deleteCompTile").click(function(){
                $("#deleteCompTileModal").modal('hide');
                //call updaeTileInfo.php file
                if (window.XMLHttpRequest) {
                        // code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                } else {
                       // code for IE6, IE5
                       xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                                //document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
                                console.log(xmlhttp.responseText);
                        }
                }
                xmlhttp.open("GET","deleteCompany.php?id="+compClicked+"&twitter_id="+id, true);
                xmlhttp.send();
                location.reload();

        });
		

	// Edit topic Tiles
	$("#updateTile").click(function(){
                var validate = validateListInfo();
                
                var name = $("#editLname").val();
                var intent = $("#editLintent").val();
                var loc = $("#editLlocation").val();
		var comp = $("#editLcompany").val();
                var abt = $("#editLabout").val();
                var teach = $("input[name=editLteach]").val();
                var venue = $("input[name=editLvenue]").val();
                var rsvp = $("input[name=editLrsvp]").val();

                if(validate){
                        $("#editTopicModal").modal('hide');
                }else{
                        return false;
                }
                //call updaeTileInfo.php file
                if (window.XMLHttpRequest) {
                        // code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                } else {
                       // code for IE6, IE5
                       xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                                //document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
                                console.log(xmlhttp.responseText);
                        }
                }
                xmlhttp.open("GET","updateTileInfo.php?name="+name+"&intent="+intent+"&location="+loc+"&comp="+comp+"&abt="+abt+"&teach="+teach+"&venue="+venue+"&rsvp="+rsvp+"&id="+tileClicked+"&twitter_id="+id, true);
                xmlhttp.send();
                location.reload();

        });
	
	//Function for filling venue details
	$("input[name=venue]").click(function(){
		var validate = validateListInfo();
		
		if(! validate){
			return false;
		}else{
			var loc = $("#llocation").val();
			$("#venueCity").val(loc);
		}


		var isAvail = $(this).val();
		//alert(isAvail);
		if(isAvail == "Available"){
			$("#venueModal").modal('toggle');
		}
	});

	//Function for editing venue details
	$("input[name=editLvenue]").click(function(){
		var validate = validateListInfo();

		if(! validate){
			return false;
		}else{
			var loc = $("#editLlocation").val();
			$("#editVcity").val(loc);
		}
		var isAvail = $(this).val();
		if(isAvail == "Available"){
			$("#venueModal").modal('toggle');
		}
	});
	
	// Save venue details of the RSVP event
	$("#saveVenue").click(function(){
		var validate = venueValidation();

		if(! validate){
			return false;
		}
		var vDate = $("#venueDate").val();
		var vTime = $("#venueTime").val();
		var vAddress = $("#venueAddress").val();
		var vCity = $("#venueCity").val();
		var vCompany = $("#lcompany").val();
		var vTopic = $("#lname").val();

		//call updaeTileInfo.php file
                if (window.XMLHttpRequest) {
                        // code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                } else {
                       // code for IE6, IE5
                       xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                                //document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
                                console.log(xmlhttp.responseText);
                        }
                }
                xmlhttp.open("GET","saveVenueDetails.php?vDate="+vDate+"&vTime="+vTime+"&vAddress="+vAddress+"&vCompany="+vCompany+"&vCity="+vCity+"&vTopic="+vTopic+"&twitter_id="+id, true);
                xmlhttp.send();
		$("#venueModal").modal('toggle');

	});

	// Delete topic tiles 
	 $("#deleteTile").click(function(){
                $("#deleteTileModal").modal('hide');
                //call updaeTileInfo.php file
                if (window.XMLHttpRequest) {
                        // code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                } else {
                       // code for IE6, IE5
                       xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                                //document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
                                console.log(xmlhttp.responseText);
                        }
                }
                xmlhttp.open("GET","deleteTile.php?id="+tileClicked+"&twitter_id="+id, true);
                xmlhttp.send();
                location.reload();

        });

	//Search functionality for the company tiles
	$("#searchCategory").keyup(function(){
		/*
                clearContainer();
                var search = $("#searchCategory").val();
                filteredResults(company, search, "category");*/
        });

        //Search technology function
        $("#searchTech").keyup(function(){
		/*
                clearContainer();
                var search = $("#searchTech").val();
                filteredResults(company, search, "technology");*/
		console.log("hwwdwf");
        });
        
        $("#searchLocation").keyup(function(){
		/*
                clearContainer();
                var search = $("#searchLocation").val();
                filteredResults(company,search,"location");*/
        });


});

function clearContainer(){
        $("div .thumbnail").remove();
}

function listToArray(fullString, separator) {
  var fullArray = [];

  if (fullString !== undefined) {
    if (fullString.indexOf(separator) == -1) {
      fullArray.push(fullString);
    } else {
      fullArray = fullString.split(separator);
    }
  }

  return fullArray;
}


function onChangeTag(input,tag){
	tagsSearch();
}

function onAddTag(tag){
	tagsSearch();
}
function onRemoveTag(tag){
	tagsSearch();
}

function tagsSearch(){
	//console.log($(".tags").importTags(''));
	var tech = ($("#searchTech").val() != "") ? listToArray($("#searchTech").val(), ",") : 0 ;
	var loc = ($("#searchLocation").val() != "") ? listToArray($("#searchLocation").val(),",") : 0;
	var cat = ($("#searchCategory").val() != "") ? listToArray($("#searchCategory").val(),",") : 0;
	var searchTech = [], searchLoc=[], searchCat = [];

	if(tech != 0){
		for(var i=0;i<tech.length;i++){
			searchTech.push(tech[i]);
		}
	}
	if(loc != 0){
		for(var i=0;i<loc.length;i++){
			searchLoc.push(loc[i]);
		}
	}
	if(cat != 0){
		for(var i=0;i<cat.length;i++){
			searchCat.push(cat[i]);
		}
	}
	filteredResults(company, searchTech, searchLoc, searchCat);
}

//Function to draw company topic tiles
function drawTiles(getTilesInfo, id, cName){
        
        for(var i=0;i<getTilesInfo.length;i++){
		var div = "";
                if(getTilesInfo[i].twitter_id == id && getTilesInfo[i].companyName == cName){
                        
                         div = '<div class="thumbnail"><legend>'+getTilesInfo[i].name+'</legend><p>'+getTilesInfo[i].intent+'</p><p>'+getTilesInfo[i].about+'</p><p>Can Teach :'+getTilesInfo[i].canTeach+'</p><p>Venue :'+getTilesInfo[i].venue+'</p><p>RSVP :'+getTilesInfo[i].rsvp+'</p><p><a class="divLink" id="'+getTilesInfo[i].name+'" zid="'+getTilesInfo[i].id+'"></a></p><div class="changes" style="z-index:9999;"><legend></legend><a class="remove1"><img src="images/edit.png" id="remove1" zid="'+getTilesInfo[i].id+'"title="Edit" width="15" height="15" class="pull-left" style="position:relative;top:-10px;"></a>';

			if(getTilesInfo[i].rsvp=="yes"){
				div += '<img src="images/attend1.png" zid="'+getTilesInfo[i].id+'" cid="'+getTilesInfo[i].companyName+'" tid="'+getTilesInfo[i].name+'" id="rsvpattend" title="Join RSVP" class="attendRSVP" width="45" height="25" style="margin-left:30%;margin-top:-25px;" >';
			}
			div += '<a class="remove2"><img src="images/delete.png" zid="'+getTilesInfo[i].id+'" id="remove2" title="Delete" width="15" height="15" class="pull-right" style="position:relative;top:-10px;"></a></div></div>';
                } /*else{
                        
                        var div = '<div class="thumbnail"><legend>'+getTilesInfo[i].name+'</legend><p>'+getTilesInfo[i].intent+'</p><p>'+getTilesInfo[i].about+'</p><p>Can Teach :'+getTilesInfo[i].canTeach+'</p><p>Venue :'+getTilesInfo[i].venue+'</p><p>RSVP :'+getTilesInfo[i].rsvp+'</p><p><a class="divLink" id="'+getTilesInfo[i].name+'" zid="'+getTilesInfo[i].id+'"></a></div>';

                }*/
		if(div != ""){
                	$("#list-thumbnails").append(div); 
		}
        }


	 var tileClicked;        
        $(".remove1").click(function(){
                event.stopPropagation();
                tileClicked = $(this).find("img:first").attr("zid");
                $("#editTopicModal").modal('show');

                for(var i=0;i<getTilesInfo.length;i++){
                        if(getTilesInfo[i].id == tileClicked){
                                $("#editLname").val(getTilesInfo[i].name);
                                $("#editLintent").val(getTilesInfo[i].intent);
                                $("#editLlocation").val(getTilesInfo[i].location);
                                $("#editLabout").val(getTilesInfo[i].about);
				$("#editLcompany").val(getTilesInfo[i].companyName);
                                $('input[name=editLteach][value="'+getTilesInfo[i].canTeach+'"]').prop('checked',true);
                                $('input[name=editLvenue][value="'+getTilesInfo[i].venue+'"]').prop('checked',true);
                                $('input[name=editLrsvp][value="'+getTilesInfo[i].rsvp+'"]').prop('checked',true);
                        }
                }
        });
        $(".remove2").click(function(){
                event.stopPropagation();
                tileClicked = $(this).find("img:first").attr("zid");
                $("#deleteTileModal").modal('show');
        });

 	var zid;
	$("#rsvpattend").click(function(){
		event.stopPropagation();
		zid = $(this).attr('zid');
		var tid = $(this).attr('tid');
		var cid = $(this).attr('cid');
		console.log("clicked");
		for(var i=0;i<venueDetails.length;i++){
                        if(tid == venueDetails[i].topic && cid == venueDetails[i].company){
                                $("#rsvpDate").text("Date : "+venueDetails[i].date);
                                $("#rsvpTime").text("Time : "+venueDetails[i].time);
                                $("#rsvpAddress").text("Address : "+venueDetails[i].address);
                                $("#rsvpCity").text("City : "+venueDetails[i].city);
                        }
                }

		$("#attendRsvpModal").modal('toggle');
	});
	
	$("#attendRSVP").click(function(){
		var email = $("#rsvpEmail").val();

		if(email == ""){
			return false;
		}else{
			$("#attendRsvpModal").modal('toggle');
		}

		 //call attendRsvp.php file
                if (window.XMLHttpRequest) {
                        // code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                } else {
                       // code for IE6, IE5
                       xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                                //document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
                                console.log(xmlhttp.responseText);
                        }
                }
                xmlhttp.open("GET","attendRsvp.php?email="+email+"&twitter_id="+id+"&zid="+zid, true);
                xmlhttp.send();
                //location.reload();

		
	});

	 $(".thumbnail").click(function(){
                var clicked = $(this).find("a:first").attr("id");
                var zid = $(this).find("a:first").attr("zid");

                clearContainer();
                showTileInfo(getTilesInfo, company,clicked,zid);    
                
        });


	


}

function returnArray(company, search, attribute){
	 var result =[];
        if(search.length > 0){
                for(var i=0;i<company.length;i++){
                                
                        for(var j=0;j<search.length;j++){
                                var cat = search[j];
				var comp = company[i];
				comp = comp[attribute];
                                if(comp.search(cat) > -1){
                                        result.push(company[i]);
                                }
                        }
                }
        }
	return result;
}

//Generate search filter results
function filteredResults(comp,searchTech, searchLoc, searchCat){ //, attribute){
        
	clearContainer();
	var results = comp ;
	if(searchCat.length > 0){
		results = returnArray(results, searchCat, "category");
	}

	if(searchTech.length > 0){
		results = returnArray(results, searchTech, "technology");
	}

	if(searchLoc.length > 0){
		results = returnArray(results, searchLoc, "location");
	}

	
	var temp = "";
	for(var i=0 ; i< results.length ; i++){
			if(temp != results[i].name){
				temp = results[i].name;
				var div = '<div class="thumbnail"><div style="height:120px;width:100%;overflow:hidden;"><img src="uploads/'+results[i].id+'" height="100%;" width="100%"></div><legend ><div style="text-align:center">'+results[i].name+'</div></legend><p class="text-center">'+results[i].category+'</p><p class="text-center">'+results[i].technology+'</p><a class="divLink" id="'+results[i].name+'" zid="'+results[i].twitter_id+'"></a><p class="text-center">'+results[i].location+'</p><div class="changes" style="z-index:9999;"><legend><a class="remove1"><img src="images/edit.png" id="remove1" zid="'+results[i].id+'"title="Edit" width="15" height="15" class="pull-left" style="position:relative;top:10px;"></a><a class="remove2"><img src="images/delete.png" zid="'+results[i].id+'" id="remove2" title="Delete" width="15" height="15" class="pull-right" style="position:relative;top:10px;"></a></legend></div></div>';
			
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
                drawTiles(getTilesInfo, zid, clicked);
        });

}

//This function displays the topic information in full detail 
function showTileInfo(getTilesInfo, company, clicked, zid){
                
        for(var k=0;k<company.length;k++){
                for(var i=0;i<getTilesInfo.length;i++){
                        if(company[k].twitter_id == getTilesInfo[i].twitter_id && company[k].name == getTilesInfo[i].companyName){
                                if(getTilesInfo[i].name == clicked && zid == getTilesInfo[i].id){
                                        var div = '<div class="thumbnail" style="width:90%;margin-left:5%;"><legend>'+getTilesInfo[i].name+'<span class="pull-right small" style="margin-right:2%;">Company Name &nbsp;: &nbsp;'+company[k].name+'</span></legend><img src="uploads/'+company[k].id+'" height="50%" width="50%"><br><legend><p class="text-center">About Company</p></legend><p class="text-center">'+company[k].about+'</p><br> <table class="table table-condensed"><thead><tr><th class="pull-left">About This Product</th><th class="text-center">Intent</th></tr></thead><tbody><tr><td class="text-center pull-left">'+getTilesInfo[i].about+'</td><td class="text-center">'+getTilesInfo[i].intent+'</td></tr></tbody></table><br><table class="table table-condensed"><thead><tr><th>Can Teach</th><th>Venue</th><th>RSVP</th><th>Location</th></tr></thead><tbody><tr><td>'+getTilesInfo[i].canTeach+'</td><td>'+getTilesInfo[i].venue+'</td><td>'+getTilesInfo[i].rsvp+'</td><td>'+getTilesInfo[i].location+'</td></tr></tbody></table></div>';


                            	        $("#topicTileClicked").append(div);
                                }
                        }
                }
        }

}



//Validation function for creating and updating company profile
function validation(){
        var name = $("#name").val() || $("#Uname").val();
	var email = $("#email").val() || $("#Uemail").val();
        var category = $("#category").val() || $("#Ucategory").val();
        var loc = $("#location").val() || $("#Ulocation").val();
        var tech = $("#technology").val() || $("#Utechnology").val();
        var abt = $("#about").val() || $("#Uabout").val();
        var file = $("#file").val() || $("#Ufile").val();
        
        if(name == ""){
                alert("Please enter the name ");
                return false;
        }      

	if(email == ""){
		alert("Please enter the email");
		return false;
	} 
        
        if(category == ""){
                alert("Please enter the category");
                return false;
        }
        
        if(tech == ""){
                alert("Please Enter the technology used");
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

// Function for validating the create and update list
function validateListInfo(){
        var name = $("#lname").val() || $("#editLname").val();
        var intent = $("#lintent").val() || $("#editLintent").val();
        var abt = $("#labout").val() || $("#editLabout").val();
        var loc = $("#llocation").val() || $("#editLlocation").val();
	var comp = $("#lcompany").val() || $("#editLcompany").val();
        
        if(name == ""){
                alert("Please Enter the name");
                return false;
        }
        if(intent == ""){
                alert("Please enter the intent");
                return false;
        }
        if(loc == ""){
                alert("Please Enter the location");
                return false;
        }
        if(abt == ""){
                alert("Please enter the about");
                return false;
        }
	if(comp == ""){
		alert("Please enter the company name related to this topic");
		return false;
	}
        return true;
}


function venueValidation(){
	var vDate = $("#venueDate").val() || $("#editVdate").val();
	var vTime = $("#venueTime").val() || $("#editVtime").val();
	var vAddress = $("#venueAddress").val() || $("#editVaddress").val();

	if(vDate == ""){
		alert("Enter Date of the venue");
		return false;
	}
	
	if(vTime == ""){
		alert("Enter Time of the venue");
		return false;
	}
	
	if(vAddress == ""){
		alert("Enter Address of the venue");
		return false;
	}

	return true;
}

</script>
</head>
<body>
<div class="container">
	<br><br>
	<a id="crowdlearn" style="cursor:hand;margin-top:45px;position:absolute;">Crowdlearn</a><br>

	<ul id="tabs" class="nav nav-tabs pull-right" data-tabs="tabs">
        	<li class="active" id="companyTabMenu"><a href="#company-tab" data-toggle="tab" id="company">Company</a></li>
        	<li id="mylistTabMenu"><a href="#mylist-tab" data-toggle="tab" id="mylist">My List</a></li>
		<li><a  href="logout.php"  aria-expanded="false">Logout</a></li>
		
        </ul>
	<br>

        <div id="my-tab-content" class="tab-content" style="margin-left:10%;">
            <div class="tab-pane active" id="company-tab">
			<br><br>
			<div class="col">
                                <table class="table table-condensed" style="text-align:center;">
                                        <thead>
                                                <tr>
                                                        <th style="text-align:center">Category</th>
                                                        <th style="text-align:center">Technology Used</th>
                                                        <th style="text-align:center">Location</th>
                                                </tr>
                                        </thead>
                                        <tbody>
                                                <tr>
                                                        <td><input class="tags" type="text" id="searchCategory"></td>
                                                        <td><input class="tags" type="text" id="searchTech"></td> 
                                                        <td><input class="tags" type="text" id="searchLocation"></td>
                                                </tr>
                                        <tbody>
                                </table>
                        </div>

			
			<a style="margin-left:-150px;margin-top:70px;position:absolute" id="addCompany" data-toggle="modal" data-target="#signUpModal">Add Company</a><br>
			<div class="row" style="margin-top:5%; background-color:#E0E0E0;">
                	        <div class = "tiles">
                        	        <!--<div class="tiles-li col-sm-6 col-md-4 col-lg-3"><div class="well">3<br>product</div></div>-->
                                	<div class="masonry-container" id="thumbnails">
                                	</div>
                        	</div>
                	</div>

            </div>
            <div class="tab-pane" id="mylist-tab">
			<br><br>
			<legend></legend>
			<a style="margin-left:-150px;position:absolute;margin-top:35px;" id="addTopic" data-toggle="modal" data-target="#topicTileModal" >Add List</a>
			<div class="row" style="margin-top:5%; background-color:#E0E0E0;width:90%;">
                                <div class = "tiles">
                                        <!--<div class="tiles-li col-sm-6 col-md-4 col-lg-3"><div class="well">3<br>product</div></div>-->
                                        <div class="masonry-container" id="list-thumbnails">
                                        </div>
                                </div>
                        </div>
			<div style="background-color:#ccffcc;width:90%;">
			<div  id="footer" class="jumbotron-overlay-up">
				<label>Subscribe :</label>
                                <input type="text" class="input-sm" placeholder="E-mail Id" id="subscribeEmail" >&nbsp;&nbsp;
                                <button id="subscribe" class="btn btn-sm btn-success">Subscribe</button>
			</div>
			</div>
			<div id="topicTileClicked" class="my-overlay-trigger"></div>
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
						<label class="block">E-mail : </label><br>
						<input type="text" name="email" id="email" class="block" style="width:100%;"><br>
                                                <label class="block">What Category :</label><br>
                                                <input type="text" name="category" id="category" class="block" style="width:100%;"><br>
                                                <label class="block">Technology Used : </label><br>
                                                <input class="text" name="technology" id="technology" class="block" style="width:100%;"><br>
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
                                        <!--<form method="post" action="updateCompany.php" enctype="multipart/form-data" onsubmit="return validation();">-->
					<form>
                                                <label class="block">Name :</label><br>
                                                <input type="text" name="Uname" id="Uname" class="block" style="width:100%;"><br>
						<label class="block">E-mail : </label><br>
						<input type="text" name="Uemail" id="Uemail" class="bloack" style="width:100%"><br>
                                                <label class="block">What Category :</label><br>
                                                <input type="text" name="Ucategory" id="Ucategory" class="block" style="width:100%;"><br>
                                                <label>Location : </label><br>
                                                <input type="text" name="Ulocation" id="Ulocation" class="block" style="width:100%"><br>
                                                <label>Technology Used : </label><br>
                                                <input class="text" name="Utechnology" id="Utechnology" class="block" style="width:100%;"><br>
                                                <label>About : </label><br>
                                                <textarea id="Uabout" name="Uabout" style="width:100%" rows=5></textarea><br>
                                                <label style="width:100%" class="block">Will Create the list : <label>
                                                <div class="radio">
                                                        <label><input type="radio" name="optradio" id="Uyes" value="yes" checked>Yes</label>
                                                        <label><input type="radio" name="optradio" id="Uno" value="no">No</label>
                                                </div>
                                                <!--<div>
                                                        <span><label>Upload Company Logo/Other Image :</label></span>
                                                        <span><input type="file" id="Ufile" name="Ufile"/></span><br>
                                                        <span><input type="submit" value="ADD"  style="float: left;" ></span>
                                                </div>-->
                                             <!--   <input type="submit" value="Update Profile" class="btn btn-primary pull-right" >-->
                                        </form>
                                </div>
                                <div class="modal-footer">
                                         <!--<button type="submit" class="btn btn-primary" id="signUp" >Sign Up</button>-->
					<button type="button" id="updateProfile" class="btn btn-sm btn-primary" >Update Profile</button>
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
                                                <label class="block">Location :</label><br>
                                                <input type="text" name="llocation" id="llocation" class="block" style="width:100%;"><br>
						<label class="block">Company :</label><br>
						<input type="text" name="lcompany" id="lcompany" class="block" style="width:100%;"><br>
                                                <label>About the Topic/Subject : </label><br>
                                                <textarea id="labout" name="labout" style="width:100%" rows=5></textarea><br>

                                                <label>Others can teach this : </label>&nbsp;&nbsp;
                                                <!-- <div class="radio">-->
                                                        <label><input type="radio" name="teach" value="yes" checked>Yes</label>&nbsp;&nbsp;
                                                        <label><input type="radio" name="teach" value="no">No</label>
                                                <!--</div>-->
                                                <br><label >Venue : </label>
                                                <!--<div class="radio">-->
                                                        <label><input type="radio" name="venue" value="Not Available" checked>To be Decided</label>&nbsp;&nbsp;
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
	
 <!-- EDIT TILE FOR SUBJECT/TOPIC LIST-->
                <div id="editTopicModal" class="modal fade" role="dialog">
                  <div class="modal-dialog">

                <!-- Modal content-->
                        <div class="modal-content" style="width:70%;">
                                <div class="modal-header" style="background-color:#428bca;border-top-left-radius: 4px;border-top-right-radius: 4px">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title" style="color:white">Edit Subject/Topic</h4>
                                </div>
                                <div class="modal-body">
                                       <!-- <form method="post" action="saveTopic.php" enctype="multipart/form-data" onsubmit="return validateListInfo();">-->
                                        <form>
                                                <label class="block">Topic/Subject Name :</label><br>
                                                <input type="text" name="editLname" id="editLname" class="block" style="width:100%;"><br>
                                                <label class="block">Intent :</label><br>
                                                <input type="text" name="editLintent" id="editLintent" class="block" style="width:100%;"><br>
                                                <label class="block">Location :</label><br>
                                                <input type="text" name="editLlocation" id="editLlocation" class="block" style="width:100%;"><br>
						<label class="block">Company :</label><br>
						<input type="text" name="editLcompany" id="editLcompany" class="block" style="width:100%;"><br>
                                                <label>About the Topic/Subject : </label><br>
                                                <textarea id="editLabout" name="editLabout" style="width:100%" rows=5></textarea><br>
                                                <label>Others can teach this : </label>&nbsp;&nbsp;
                                                <!-- <div class="radio">-->
                                                        <label><input type="radio" name="editLteach" value="yes" checked>Yes</label>&nbsp;&nbsp;
                                                        <label><input type="radio" name="editLteach" value="no">No</label>
                                                <!--</div>-->
                                                <br><label >Venue : </label>
                                                <!--<div class="radio">-->
                                                        <label><input type="radio" name="editLvenue" value="notAvailable" checked>To be Decided</label>&nbsp;&nbsp;
                                                        <label><input type="radio" name="editLvenue" value="Available" >Available</label>
                                                <!--</div>-->
                                                <br><label >Create RSVP : </label>&nbsp;&nbsp;
                                                <!--<div class="radio" style="width:100%">-->
                                                        <label><input type="radio" name="editLrsvp" value="yes" checked>Yes</label>&nbsp;&nbsp;
                                                        <label><input type="radio" name="editLrsvp" value="no">No</label>
                                                <!--</div><br>-->
                                              <!--  <br><br><input type="submit" value="Update topic" class="btn btn-primary pull-right" >-->

                                        </form>
                                                                                	
				 </div>
                                 <div class="modal-footer">
                                        <button type="button" id="updateTile" class="btn btn-sm btn-primary" >Update Info</button>
                                </div>
                        </div>

                </div>
                </div>

		<!-- DELETE COMPANY TILE MODAL-->
                <div id="deleteCompTileModal" class="modal fade" role="dialog">
                  <div class="modal-dialog">

                        <div class="modal-content" style="width:50%;">
                                <div class="modal-header" style="background-color:#428bca;border-top-left-radius: 4px;border-top-right-radius: 4px">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title" style="color:white">Confirm Delete</h4>
                                </div>
                                <div class="modal-body">
                                        Are You sure to delete this Company Profile ?
                                </div>
                                <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" id="deleteCompTile" >Delete</button>
                                </div>
                        </div>

                </div>
                </div>


		<!-- ATTEND RSVP MODAL-->
                <div id="attendRsvpModal" class="modal fade" role="dialog">
                  <div class="modal-dialog">

                        <div class="modal-content" style="width:50%;">
                                <div class="modal-header" style="background-color:#428bca;border-top-left-radius: 4px;border-top-right-radius: 4px">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title" style="color:white">Attend RSVP</h4>
                                </div>
                                <div class="modal-body">
					<p id="rsvpDate"></p>
					<p id="rsvpTime"></p>
					<p id="rsvpAddress"></p>
					<p id="rsvpCity"></p>
					<legend></legend>
                                        <label>E-mail Id :</label><br>
					<input type="text" id="rsvpEmail" style="width:100%">
                                </div>
                                <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" id="attendRSVP" >Attend</button>
                                </div>
                        </div>

                </div>
                </div>
		

		 <!-- RSVP VENUE DETAILS MODAL-->
                <div id="venueModal" class="modal fade" role="dialog">
                  <div class="modal-dialog">

                        <div class="modal-content" style="width:50%;">
                                <div class="modal-header" style="background-color:#428bca;border-top-left-radius: 4px;border-top-right-radius: 4px">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title" style="color:white">Enter Venue Details</h4>
                                </div>
                                <div class="modal-body">
                                        <label>Venue Date :</label><br>
                                        <input type="text" id="venueDate" style="width:100%">
					<label>Venue TIme :</label><br>
					<input type="text" id="venueTime" style="width:100%">
					<label>Venue Address :</label><br>
					<textarea id="venueAddress" rows="4" style="width:100%"></textarea>
					<label>Venue City : </label><br>
					<input type="text" id="venueCity" style="width:100%;" disabled> 
                                </div>
                                <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" id="saveVenue" >Save Venue</button>
                                </div>
                        </div>

                </div>
                </div>

		 <!--EDIT  RSVP VENUE DETAILS MODAL-->
                <div id="editVenueModal" class="modal fade" role="dialog">
                  <div class="modal-dialog">

                        <div class="modal-content" style="width:50%;">
                                <div class="modal-header" style="background-color:#428bca;border-top-left-radius: 4px;border-top-right-radius: 4px">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title" style="color:white">Edit Venue Details</h4>
                                </div>
                                <div class="modal-body">
                                        <label>Venue Date :</label><br>
                                        <input type="text" id="editVdate" style="width:100%">
                                        <label>Venue TIme :</label><br>
                                        <input type="text" id="editVtime" style="width:100%">
                                        <label>Venue Address :</label><br>
                                        <textarea id="editVaddress" rows="4" style="width:100%"></textarea>
                                        <label>Venue City : </label><br>
                                        <input type="text" id="venueCity" style="width:100%;" disabled>
                                </div>
                                <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" id="saveVenue" >Save Venue</button>
                                </div>
                        </div>

                </div>
                </div>



</body>
</html>
