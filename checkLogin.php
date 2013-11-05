<?php session_destroy();?>
<?php

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
header("Location:loginFail.html");
}
?>
