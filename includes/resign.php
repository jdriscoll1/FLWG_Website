<?php
//If a user chooses to resign it will 
// 1) Connect to the database
// 2) Subtract the current number of players by 1
// First, connect to the server
$g_id = $_POST['g_id']; 

$conn = require('connect.php'); 


if($conn->connect_error){
	die("Connection Failed: " . $conn->connect_error);
}

$removePlayer = sprintf("update game set numPlayers = numPlayers - 1 where g_id = %d", $g_id);
$conn->query($removePlayer)


?>
