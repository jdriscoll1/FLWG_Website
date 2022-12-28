<?php 

// 2) Grab the row & from the row acquire the word id 
 session_start(); 
// Connect to the database
// 1) Connect to the database
$conn = require('connect.php');

// 2) Return the word id 
$g_id = $_SESSION['g_id']; 
$query_str = sprintf("select currWord from game where g_id = %d", $g_id); 
$result = $conn->query($query_str);
$row = $result->fetch_assoc();

// Run the command 
$w_id = $row['currWord']; 
$w_str = $_SESSION['IntToWord'][$w_id]; 
array_push($_SESSION['WordSet'], $w_id);
$output = json_encode(["w_id" => $w_id, "w_str" => $w_str]);
echo $output;
?>
