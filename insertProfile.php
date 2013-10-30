<?php
$username = $_GET['username'];
$firstname = $_GET['firstname'];
$lastname = $_GET['lastname'];
$phonenumber = $_GET['phonenumber'];
$email = $_GET['email'];
$rating = $_GET['rating'];
$comments = $_GET['comments'];
$password = $_GET['password'];
$c = oci_connect('jwassel', 'jasonwassel', '//localhost/curt');
if (!$c) {
    $e = oci_error();   // For oci_connect errors do not pass a handle
    trigger_error(htmlentities($e['message']), E_USER_ERROR);
}

$q = 'insert into users values (:t, :v, :w, :x, :y, :b, :a, :z)';
//Parse that SQL query into a statement
$s = oci_parse($c, $q);
//Next we bind the variables to the placeholders.
oci_bind_by_name($s, ":t", $username);
oci_bind_by_name($s, ":v", $firstname);
oci_bind_by_name($s, ":w", $lastname);
oci_bind_by_name($s, ":x", $phonenumber);
oci_bind_by_name($s, ":y", $email);
oci_bind_by_name($s, ":b", $rating);
oci_bind_by_name($s, ":a", $comments);
oci_bind_by_name($s, ":z", $password);
//Execute the SQL statement
oci_execute($s);
print("Hello World");

oci_close($c);
?>


