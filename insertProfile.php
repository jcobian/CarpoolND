<?php session_destroy();?>

<?php session_start();?>
<html>
<head>
<style>
body {background-color:#041c42;}
p {font-size:14px}
p.Helv{font-family:Helvetica,serif}
</style>
<?php
$email = $_POST['username'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$phonenumber = $_POST['phonenumber'];
$phonenumber2 = $_POST['phonenumber2'];
$phonenumber3 = $_POST['phonenumber3'];
$password = $_POST['password'];
$password = md5($password);

$c = oci_connect('jwassel', 'jasonwassel', '//localhost/curt');
if (!$c) {
    $e = oci_error();   // For oci_connect errors do not pass a handle
    trigger_error(htmlentities($e['message']), E_USER_ERROR);
}
$phonenumber = $phonenumber.'-'.$phonenumber2.'-'.$phonenumber3;


$q = 'insert into users (username,firstname,lastname,phonenumber,password) values (:t, :v, :w, :x,:z)';
//Parse that SQL query into a statement
$s = oci_parse($c, $q);
//Next we bind the variables to the placeholders.
oci_bind_by_name($s, ":t", $email);
oci_bind_by_name($s, ":v", $firstname);
oci_bind_by_name($s, ":w", $lastname);
oci_bind_by_name($s, ":x", $phonenumber);
oci_bind_by_name($s, ":z", $password);

//Execute the SQL statement
oci_execute($s);

oci_close($c);

session_start();
$_SESSION['username']=$email;
header("Location:homePage.php");

?>
</head>
<body>
</body>
</html>



