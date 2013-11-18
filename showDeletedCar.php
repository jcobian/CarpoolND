<?php session_start();?>
<html>
<head>
<style>
body {background-color:#041c42;}
p {font-size:14px}
p.Helv{font-family:Helvetica,serif}
</style>
<?php
$carId = $_GET['carId'];
$c = oci_connect('jwassel', 'jasonwassel', '//localhost/curt');
if (!$c) {
    $e = oci_error();   // For oci_connect errors do not pass a handle
    trigger_error(htmlentities($e['message']), E_USER_ERROR);
}
#$q = "delete from car where make='".$Make."' AND model='".$Model."'AND year='".$YEAR."'";
#$q = "delete from car where make= :v and model= :t";
$q = "delete from car where car_id= :v";
//Parse that SQL query into a statement
$s = oci_parse($c, $q);

//Next we bind the variables to the placeholders.
oci_bind_by_name($s, ":v", $carId);

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



