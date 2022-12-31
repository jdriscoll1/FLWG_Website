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

$keys = array_keys($wordList); 

fclose($file);

$_SESSION['WordToInt'] = $wordList; 
$_SESSION['IntToWord'] = $keys;
$_SESSION['WordSet'] = []; 
echo json_encode(
	['g_id' =>   ((isset($_SESSION['g_id']))    ? $_SESSION['g_id']    : -1),
         'myTurn' => ((isset($_SESSION['turn_id'])) ? $_SESSION['turn_id'] : -1)]); 
?>
