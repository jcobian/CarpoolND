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
<style>
body {background-color:#041c42;}
p {font-size:14px}
p.Helv{font-family:Helvetica,serif}
</style>
<?php
$Make = $_GET['Make'];
$Model = $_GET['Model'];
$Year = $_GET['Year'];
$Numberofseats = $_GET['Numberofseats'];
$c = oci_connect('jwassel', 'jasonwassel', '//localhost/curt');
if (!$c) {
    $e = oci_error();   // For oci_connect errors do not pass a handle
    trigger_error(htmlentities($e['message']), E_USER_ERROR);
}
$q = 'insert into car (car_id, make, model, year, owner, numberofseats) values (seq_car_id.nextval, :v, :w, :x, :y, :z)';
//Parse that SQL query into a statement
$s = oci_parse($c, $q);

//Next we bind the variables to the placeholders.
oci_bind_by_name($s, ":v", $Make);
oci_bind_by_name($s, ":w", $Model);
oci_bind_by_name($s, ":x", $Year);
oci_bind_by_name($s, ":y", $_SESSION['username']);
oci_bind_by_name($s, ":z", $Numberofseats);
//Execute the SQL statement
if(!oci_execute($s)){
$e = oci_error($s);
print $e['message'];
}
oci_close($c);
header("Location:homePage.php");
?>
</head>
<body>
</body>
</html>



