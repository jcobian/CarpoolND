<?php session_start();
if(isset($_SESSION['username']))
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

function checkEmail() {
	var email = document.getElementById("username").value;
	//if email ends in @nd.edu ok
	if(endsWith(email,"@nd.edu")) {
	}
	else {
		window.alert("Email must end in nd.edu");
		document.getElementById("username").value = "";
	}
}
function endsWith(str,suffix) {
	return str.indexOf(suffix,str.length-suffix.length) !== -1;
}
function checkPasswordsMatch() {
	var password = document.getElementById("password").value;
	var confirmPassword = document.getElementById("confirmPassword").value;
	if(password !== confirmPassword) {
		window.alert("Passwords do not match!");
		document.getElementById("password").value = "";
		document.getElementById("confirmPassword").value = "";
	}

}
</script>

</head>
<body>
<center><h2> Create Your Profile</h2></center>
<form action="insertProfile.php" method="post">
<div class="insertForm">
<div class= "form-group"><label for="username" class="required" style="color:white">Email: <input required name="username" id="username" onchange="checkEmail();"/></div>
<div class= "form-group"><label for="password" class="required" style="color:white">Password: <input name="password" type="password" id="password"/></div>
<div class= "form-group"><label for="confirmPassword" class="required" style="color:white">Confirm Password: <input name="confirmPassword" id="confirmPassword" type="password" onchange="checkPasswordsMatch();"/></div>
<div class= "form-group"><label for="firstname" class="required" style="color:white">First Name: <input name="firstname"/></div>
<div class= "form-group"><label for="lastname" class="required" style="color:white">Last Name: <input name="lastname"/></div>
<div class= "form-group"><label for="phonenumber" style="color:white">Phone Number: <input name="phonenumber" maxlength="3"size="3"/><label for="phonenumber2">-<input name="phonenumber2" maxlength="3" size="3"/><label for="phonenumber3">-<input name="phonenumber3" maxlength="4" size="4"/></div>
</div>
<input type="submit"/>
</form>
</body>
</html>
