<?php

$username=$_POST['username'];
$password=$_POST['password'];
echo $username;
echo "  ";

echo $password;
echo " = ";
$password=md5($password);
$c = oci_connect('jwassel', 'jasonwassel', '//localhost/curt');

echo $password;
$q='select COUNT(*) username, password from users where username = :t and password = :u';
$s=oci_parse($c,$q);

oci_bind_by_name($s, ":t", $username);
oci_bind_by_name($s, ":u", $password);
echo "   ";
$result=oci_execute($s); 
oci_fetch($s);
$row=oci_result($s);
echo $row;// If result matched $myusername and $mypassword, table row must be 1 row
if($result==1){
echo "  ";
echo "here";
// Register $myusername, $mypassword and redirect to file "login_success.php"
session_register("username");
session_register("password"); 
header("Location:orchestra.cselab.nd.edu/~jwassel/CarpoolND/homePage.html");
}
else {
echo "FSDF";
echo "Wrong Username or Password";
}
?>
