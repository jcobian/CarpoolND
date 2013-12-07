<html>
<head>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<title>User Home</title>
<?php
session_start();
if(!isset($_SESSION['username']))
{unset($_SESSION);
session_destroy();
session_write_close();
header("Location:index.html");
exit;
}
$username = $_SESSION['username'];
?>
<script type="text/javascript">
//function notify(){
		//var value = <?php print '\"'.$rows.'\"'; ?>;
		//var value = "<?php print $rows; ?>";
		//alert("You have" + value + "unanswered requests");
//		alert("notify");
	//}
	
function clickedButton(sel) {

        if(sel.id=="createCarpool") 
                window.location.href="createCarpool.php";
        
        if(sel.id=="insertSearcher") 
                window.location.href="createSearcher.php";
        
        if(sel.id=="searchCarpools") 
                window.location.href="searchCarpool.php";
        
        if(sel.id=="userSettings") 
                window.location.href="userSettings.php";
               
        if(sel.id=="searchSearchers") 
                window.location.href="searchSearchers.php";
        
	if(sel.id=="logout") 
                window.location.href="logout.php";
        
        if(sel.id=="searchRequest") 
                window.location.href="searchRequest.php";
                
        if(sel.id=="waypoints") 
                window.location.href="testWaypts.php";
        


}
</script>
</head>
<body>
<?php 
//$c = oci_connect('jwassel','jasonwassel','//localhost/curt');
//$q = 'select count(*) from request, carpool where carpool.carpool_id = request.carpool_id and carpool.driver = :t';
//$s = oci_parse($c, $q);
//oci_bind_by_name($s,":t",$_SESSION['username']);
//oci_execute($s);
//$rows = oci_fetch_array($s, oci_num);
//print $rows[0];
//if ($rows[0] > 0){
//	print '<script type="text/javascript">'.'notify(); </script>';
//}
?>
<div id="header" align="center">
<h1 style="margin-bottom:0;">CarpoolND</h1></div>

<div id="header" style="position:relative; float:right; right:50px">
<h4 style="background-color:white">User: <?php print $username ?></h4></div>

<div id="content" style="position:relative; float:right; right:-13px; top:40px">
<button id="userSettings"type="button" onclick="clickedButton(this)"> Settings</button></div>


<div id="menu" align="center" style="margin: 0 auto; margin-top:100px">
<b><button id="createCarpool" type="button" onclick="clickedButton(this)"> I Am a Driver</button></b><br></br>
<button id="insertSearcher" type="button" onclick="clickedButton(this)">  I am a Passenger</button><br></br>
<button id="searchCarpools" type="button" onclick="clickedButton(this)"> Search Carpools</button><br></br>
<button id="searchSearchers" type="button" onclick="clickedButton(this)"> View All People Looking For Rides</button> <br></br>
<button id="searchRequest" type="button" onclick="clickedButton(this)"> View People Requesting Rides From You</button>
<br></br>
<button id="waypoints" type="button" onclick="clickedButton(this)"> Find Ride Closest to Destination</button>
</div>

<div id="content1" style="position:absolute; left:48%; bottom:20px">
<button id="logout"type="button" onclick="clickedButton(this)"> Logout</button></div>

<!--<table width="100%" >
<tr><td align="center"><h2>CarpoolND</h2> </td><td> <h4>User: <?php print $username ?></h4> <button id="userSettings"type="button" onclick="clickedButton(this)"> Settings</button> </td>  </tr>
<tr><td> <button id="logout"type="button" onclick="clickedButton(this)"> Logout</button> </td>  </tr>
</table>
<table>
<tr><td> <button id="createCarpool" type="button" onclick="clickedButton(this)"> I Am a Driver</button></td></tr>
<tr><td> <button id="insertSearcher" type="button" onclick="clickedButton(this)">  I Am a Passenger</button></td></tr>
<tr><td> <button id="searchCarpools" type="button" onclick="clickedButton(this)"> Browse All Carpools</button></td></tr>-->
</table>
</body>
</html>

