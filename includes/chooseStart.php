<?php
session_start();
//The goal of this file is to choose a valid word to start with 
srand(time());
$w_id = rand(0,2146); 
$w_str = $_SESSION['IntToWord'][$w_id]; 
$output = json_encode(["w_id" => $w_id, "w_str" => $w_str]);
array_push($_SESSION['WordSet'], $w_id);
echo $output; 

?>
