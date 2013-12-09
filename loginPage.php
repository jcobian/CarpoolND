<html>
<head>
<title>CarpoolND</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
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
<center><h2>CarpoolND</h2></center>

<center>
<form action="loginPage.php" method="post" role="form">
<div class="insertForm">
<div class="form-group"><label for="username">Email: </label><input type="text" name="username"/></div>
<div class="form-group"><label for="password">Password: </label><input type ="password" name="password"/></div>
<?php
if($wrong==1){
echo "<h2> Wrong Username and password combination </h2>";
}
?>
<input type="submit" />
</div>
</form>
</center>
</body>
</html>
