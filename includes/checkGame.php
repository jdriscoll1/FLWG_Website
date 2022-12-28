<?php

// This is a script that will occasionally run checks to see if the game has updated
session_start(); 
// 1) Connect to Database
// Connect to the database
$conn = require('connect.php');
// Grab the id of the of game from the user
$g_id = $_POST['g_id'];

// 2) Select: the current word, the current turn the current number of players from the database
$getData = sprintf("select numPlayers, currWord, currTurn from game where g_id = %d", $g_id); 
$result = $conn->query($getData);

// Returns the current row that was acquired from the result
$row = $result->fetch_assoc();
// Output the total number of players 
$numPlayers = $row['numPlayers'];
// Outputs the current word
$wordID = $row['currWord'];
// 3) Grab Post details about current turn
$currTurn = $row['currTurn'];
// Turn the results into a json_encodable dictionary-formatted output 
$wordStr = $_SESSION['IntToWord'][$wordID]; 
// If the word isn't already added to the word set, add it
if(!in_array($wordID, $_SESSION['WordSet'])){
	array_push($_SESSION['WordSet'], $wordID); 
}

$output = [
	'numPlayers' => $numPlayers, 
	'id' => $wordID, 
	'word' => $wordStr, 
	'turn' => $currTurn];

// Give the output to the client
echo json_encode($output);


// 4) If currTurn != updatedTurn, return currTurn: currTurn, newWord: Same as last time 
// 5) If the user has resigned, it will be currTurn +1, newWord: -1 and it means that they are a winner! 
// Current Turn will need to be passed in 
// If the current turn is not equal to the updated turn, then it will return the new word and the current turn, otherwise it will return -1 
// 3 Outputs: 
// a) No update: currTurn: currTurn == updatedTurn, currWord: currWord == updatedWord
// b) New word: currTurn: (currTurn + 1) % totPlayers, currWord = updatedWord
// c) Resignation: Player leaves, Time Runs Out, Or Player Clicks Resign
// i. totPlayers == 1: currTurn: -1, currWord: currWord == updatedWord
// ii. totPlayers > 1: currTurn: (currTurn + 1) % totPlayers, currWord: currWord == updatedWord




?>
