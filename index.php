<html>
<head>
<title>CarpoolND</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
<?php session_destroy();?>
<?php
$wrong = 0;
if (isset($_POST["username"])) {

$username=$_POST['username'];
$password=$_POST['password'];
$password=md5($password);
$c = oci_connect('jwassel', 'jasonwassel', '//localhost/curt');

$q='select COUNT(*) from users where username = :t and password = :u';
$s=oci_parse($c,$q);

oci_bind_by_name($s, ":t", $username);
oci_bind_by_name($s, ":u", $password);
oci_execute($s);
$rows = oci_fetch_array($s,OCI_NUM);


if($rows[0]==1){
session_start();
// Register $myusername, $mypassword and redirect to file "login_success.php"
$_SESSION['username']=$username;
header("Location:homePage.php");


}
else {
$wrong=1;
}
}
?>

</head>
<body>
<center><h2 style="background-color:#ffcc00">CarpoolND</h2></center>

<center>
<form action="index.php" method="post">
<div class="insertForm">
<p><label for="username">Username: </label><input type="text" name="username"/></p>
<p><label for="password">Password: </label><input type ="password" name="password"/></p>
<?php
if($wrong==1){
echo "<h2> Wrong Username and password combination </h2>";
}
?>
<input type="submit" />
</div>
</form>

<a href="http://orchestra.cselab.nd.edu/~jwassel/CarpoolND/insertProfile.html">Create a profile</a>
</center>
</body>
</html>
