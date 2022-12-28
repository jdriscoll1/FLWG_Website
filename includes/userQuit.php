<?php
session_start();
$q_id = $_POST['q_id']; 

if($q_id != -1){
	// Connect to the database
	$conn = require('connect.php'); 
	
	// Take the q_id's row 
	$decrement_queue = sprintf("update queue set currPlayers = currPlayers - 1 where q_id = %d", $q_id);
	$conn->query($decrement_queue); 
}
?>
