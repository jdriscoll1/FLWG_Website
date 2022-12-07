<?php
//Filename: userPly.php
// Goal: Allow the user to submit a word, validate that it is there turn and update the word in the databas
session_start();                                         
// 1) Connect to the database
$conn = require('connect.php');

$currTurn = $_GET['currTurn']; 
$g_id = $_GET['g_id'];
$wordStr = $_GET['curr'];
$wordID = $_SESSION['WordToInt'][$wordStr];  

// 2) Grab the turn of the current user from the database
$query = sprintf("select currTurn from game where g_id = %d", $g_id); 
$result = $conn->query($query);
$row = $result->fetch_assoc(); 

// Grab the current turn
// 3) Grab the turn of the current user stored in the session
$currTurn = $row['currTurn'];
$myTurn = $_SESSION['turn_id']; 

// If the user tried to go when it was not their turn, it'll output an error 
// 4) Validate that the 2 are equal, if they are not, return 'm' for multiplayer error 
if($currTurn != $myTurn){
	$wordStr = 'm'; 
}
else{
	// This updates the current turn
	$currTurn = ($currTurn + 1) % 2; 

	// 5) Update the row setting the currWord = to the word that was passed in
	$updateWord = sprintf("update game set currWord = %d where g_id = %d", $wordID, $g_id);
	$conn->query($updateWord);

	// 6) Update the currTurn in the database to currTurn = (currTurn + 1) % totPlayers 
	$updateTurn = sprintf("update game set currTurn = %d where g_id = %d", $currTurn, $g_id);
	$conn->query($updateTurn);

	//7) Add this word to the set of used words
	array_push($_SESSION['WordSet'], $wordID); 
}
// 7) Output the current word 
echo $wordStr;





?>
