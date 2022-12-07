<?php
// The goal of this part of the program is to occasionally check if there is another user who has decided to join the game
session_start();
// Connect to the database 

$conn = require('includes/connect.php'); 

// Grab the q_id from the server
$q_id = $_POST['q_id']; 
//
// Check the total number of players and current number of players
$playerCheck = sprintf("select g_id from queue where q_id = %d", $q_id);
$result = $conn->query($playerCheck);
$row = $result->fetch_assoc();
// Save those numbers in a variable
$g_id = $row['g_id']; 
$output = $g_id; 
if($g_id != -1){
	$_SESSION['turn_id'] = 1;
	$_SESSION['g_id'] = $g_id;
}

echo $output; 
// Check if the number of users is equal to the # players
//
// Success Case: There are an adequete # of users to justify starting a new game
// If there are are send back success
//
// Fail Case: No user has decided to enter the game, or more accurately there are not enough users to be able to justify a new game 


?>
