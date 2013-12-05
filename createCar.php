<?php session_start();
if(!isset($_SESSION['username']))
{unset($_SESSION);
session_destroy();
session_write_close();
header("Location:index.html");
exit;
}
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<script type="text/javascript">
function clickedButton(sel) {
	if(sel.id=="goBack") {
		window.location.href="userSettings.php";
	}

}
</script>
</head>
<body>
<center><h2> Add a Car to your Profile</h2></center>
<form action="insertCar.php" method="get" role="form">
<div class="insertForm">
<div class="form-group"><p><label for="Make" class="required" style="color:white">Make: </label><input name="Make"/></p></div>
<div class="form-group"><p><label for="Model" style="color:white">Model: </label><input name="Model"/></p></div>
<div class="form-group" style="color:white"><p><span>Year: </span>
<select name="Year">
<option value=2014>2014</option>
<option value=2013>2013</option>
<option value=2012>2012</option>
<option value=2011 selected>2011</option>
<option value=2010>2010</option>
<option value=2009>2009</option>
<option value=2008>2008</option>
<option value=2007>2007</option>
<option value=2006>2006</option>
<option value=2005>2005</option>
<option value=2004>2004</option>
<option value=2003>2003</option>
<option value=2002>2002</option>
<option value=2001>2001</option>
<option value=2000>2000</option>
<option value=1999>1999</option>
<option value=1998>1998</option>
<option value=1997>1997</option>
<option value=1996>1996</option>
<option value=1995>1995</option>
<option value=1994>1994</option>
<option value=1993>1993</option>
<option value=1992>1992</option>
<option value=1991>1991</option>
<option value=1990>1990</option>
<option value=1989>1989</option>
<option value=1988>1988</option>
<option value=1987>1987</option>
<option value=1986>1986</option>
<option value=1985>1985</option>
<option value=1984>1984</option>
<option value=1983>1983</option>
<option value=1982>1982</option>
<option value=1981>1981</option>
<option value=1980>1980</option>
<option value=1979>Older Than 1980</option>
</select></p></div>
<div class="form-group"><p><span class="required" style="color:white">Number of Seats:  </span>
<select name="Numberofseats">
<option value=2>2</option>
<option value=3>3</option>
<option value=4>4</option>
<option value=5 selected>5</option>
<option value=5>6</option>
<option value=7>7</option>
<option value=8>8</option>
<option value=9>9</option>
<option value=10>10</option>
</select></p></div>
<div class="form-group" style="color:white"><p><span>Car Details: </span>
<textarea rows="4" cols="50" name="Details"
placeholder="Enter details about your car. Ex: Air conditioned, condition of car, airbags, etc.">
</textarea>
</div> 
</div>
<input type="submit"/>

</form>
<div id="content1" style="position:absolute; left:18%; bottom:100px">
<button id="goBack" type="button" onclick="clickedButton(this)"> Go Back</button>
</body>
</html>

