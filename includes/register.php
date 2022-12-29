<?php 
session_start(); 

// First, connect to the server 
$conn = require('connect.php'); 
$u_name = htmlspecialchars($_POST['u_name'], ENT_QUOTES); 
$p_word = htmlspecialchars($_POST["p_word"], ENT_QUOTES);
$email = htmlspecialchars($_POST["email"], ENT_QUOTES);

// The string is not too long

if(strlen($u_name) < 4 || strlen($u_name) > 20){
	echo "The username must be within 4-20 characters"; 
	exit(0); 
}	
// There are no special characters
if(preg_match('/[^a-z\d]/i', $u_name)){
	echo "The string must contain only alphabetical and numerical characters, no special characters are allowed";	
	exit(0); 
}


// There are no inappropriate usernames (regex)
// Check if the username hasn't already been taken 
$check_uname_query = $conn->prepare("select * from users where u_name = ?;"); 
$check_uname_query->bind_param("s", $u_name);
$check_uname_query->execute();
$result = $check_uname_query->get_result(); 

// Create the sql queyr with the username
	
// Run the query & check the number of rows 
$num_usernames = $result->num_rows > 0; 
if($num_usernames > 0){
	echo "Please use a different username";
	exit(0); 
} 



// Validate that the user is at least 13 
$creation_date = date('Y-m-d');

 
// Validate that the email is proper 
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
	echo "invalid email";
	exit(0); 
}	

// Hash the password 
$o = [ 'cost' => 9, ]; 
$p_word = password_hash($p_word, PASSWORD_DEFAULT, $o); 

//echo "Your data has been validated!"; 
$insert_query = $conn->prepare("insert into users (u_name, p_word, email, creation_date) values (?, ?, ?, ?);"); 
$insert_query->bind_param("ssss", $u_name, $p_word, $email, $creation_date);
$insert_query->execute();
$u_id = $conn->insert_id; 
$_SESSION['u_name'] = $u_name; 
$_SESSION['u_id'] = $u_id; 
/*
//We need to get the user's id
$get_id_query = $conn->prepare("select u_id from users where u_name = ?;");
$get_id_query->bind_param("s", $u_name);
$get_id_query->execute();

$result = $get_id_query->get_result();


// Check if there's at least one row in the database where there is a username 
if($result->num_rows == 1){
	// First get the correct row in the database
	$row = $result->fetch_assoc(); 
	$_SESSION['u_name'] = $u_name; 
	$_SESSION['u_id'] = $row['u_id'];
}
 */
 

$conn->close(); 
echo $_SESSION['u_id']; 
?>


