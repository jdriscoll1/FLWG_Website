<?php
session_start(); 
/*What does the login file do?*/
// 1) Connects to the database 
// First, connect to the server

$conn = require('connect.php'); 

if($conn->connect_error){
	die("Connection Failed: " . $conn->connect_error);
}


// 2) Checks if the username & Password Match

// Get the username & password from the server
$u_name = htmlspecialchars($_POST['u_name'], ENT_QUOTES);
$p_word = htmlspecialchars($_POST['p_word'], ENT_QUOTES);
$u_id = -1; 


// Access the database to see if the username exists in the database 

// Get query
$uname_reuse_query = $conn->prepare("select u_id, u_name, p_word from users where u_name = ?;"); 
$uname_reuse_query->bind_param("s", $u_name); 

$uname_reuse_query->execute();
$result = $uname_reuse_query->get_result();
// Check if there's at least one row in the database where there is a username 
if($result->num_rows == 1){
	// First get the correct row in the database
	$row = $result->fetch_assoc(); 
	$_SESSION['u_name'] = $u_name; 
	$p_word_check = $row['p_word'];
	// Check if the verified password is the same is what's being passed in
	if(password_verify($p_word, $p_word_check)){
		$u_id = $row['u_id']; 		
		$_SESSION['u_id'] = $u_id;
	}
}
// 3) Echo's the id #
echo $u_id; 






?>
