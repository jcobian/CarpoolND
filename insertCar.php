<?php
print("Hello World");
$Make = $_GET['Make'];
$Model = $_GET['Model'];
$Seats = $_GET['Seats'];
$OccupiedSeats = $_GET['OccupiedSeats'];
$c = oci_connect('jwassel', 'jasonwassel', '//localhost/curt');
if (!$c) {
    $e = oci_error();   // For oci_connect errors do not pass a handle
    trigger_error(htmlentities($e['message']), E_USER_ERROR);
}
$q = 'insert into cars values (:v :w, :x, :y, :z)';
//Parse that SQL query into a statement
$s = oci_parse($c, $q);
print("Hello World");

//Next we bind the variables to the placeholders.
oci_bind_by_name($s, ":v", SEQ_CAR.nextval);
oci_bind_by_name($s, ":w", $Make);
oci_bind_by_name($s, ":x", $Model);
oci_bind_by_name($s, ":y", $Seats);
oci_bind_by_name($s, ":z", $OccupiedSeats);
//Execute the SQL statement
if(!oci_execute($s)){
$e = oci_error($s);
print $e['message'];
}
oci_close($c);
?>



