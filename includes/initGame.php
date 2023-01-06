<?php
// The goal of this file is to create a dictionary in a json encodable way such that it can be passed to javascript:w
session_start();
// The file which stores all the words
$filename = "/var/www/html/docs/4/Four_Letter_Dictionary.txt";

// Accesses file that stores all the words but not their connections
$file = fopen($filename, "r") or die ("file doesn't exist"); 

//Loop through every line of the file
$index = 0; 
while(!feof($file)){
	$wordList[rtrim(fgets($file, 10))] = $index; 
	$index += 1; 
}

$g_id = ((isset($_SESSION['g_id'])) ? $_SESSION['g_id'] : -1); 
// It needs to receive the current turn as well, in case the webpage refreshes 
// 1) Connect to the database
$conn = require("connect.php"); 
// 2) Acquire the curr row based on the g_id 
$getCurrTurn = sprintf("select currTurn from game where g_id = %d", $g_id); 
$result = $conn->query($getCurrTurn); 
$row = $result->fetch_assoc(); 
$currTurn = $row['currTurn'];
$conn->close();
// 3) Obtain the curr id 
$keys = array_keys($wordList); 

fclose($file);
$_SESSION['WordToInt'] = $wordList; 
$_SESSION['IntToWord'] = $keys;
$_SESSION['WordSet'] = []; 
echo json_encode(
	['g_id' => $g_id,
	'myTurn' => ((isset($_SESSION['turn_id'])) ? $_SESSION['turn_id'] : -1),
	'currTurn' => $currTurn 
	]); 
?>
