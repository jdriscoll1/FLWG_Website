<?php
$servername = 'localhost';
$uname = getenv('db_uname');
$password = getenv('db_password');
$db = 'flwg_data';

$conn = new mysqli($servername, $uname, $password, $db);

if($conn->connect_error){
	die("Connection Failed: " . $conn->connect_error);
}

return $conn; 
?>
