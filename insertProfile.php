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
$username = $_GET['username'];
$firstname = $_GET['firstname'];
$lastname = $_GET['lastname'];
$phonenumber = $_GET['phonenumber'];
$email = $_GET['email'];
$password = $_GET['password'];
$password = md5($password);
$c = oci_connect('jwassel', 'jasonwassel', '//localhost/curt');
if (!$c) {
    $e = oci_error();   // For oci_connect errors do not pass a handle
    trigger_error(htmlentities($e['message']), E_USER_ERROR);
}

$q = 'insert into users values (:t, :v, :w, :x, :y, :z)';
//Parse that SQL query into a statement
$s = oci_parse($c, $q);
//Next we bind the variables to the placeholders.
oci_bind_by_name($s, ":t", $username);
oci_bind_by_name($s, ":v", $firstname);
oci_bind_by_name($s, ":w", $lastname);
oci_bind_by_name($s, ":x", $phonenumber);
oci_bind_by_name($s, ":y", $email);
oci_bind_by_name($s, ":z", $password);

//Execute the SQL statement
oci_execute($s);

oci_close($c);
?>
</head>
<body>
<a href="http://orchestra.cselab.nd.edu/~jwassel/CarpoolND/homePage.php">Go Back</a>
</body>
</html>



