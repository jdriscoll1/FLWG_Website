<?php 
session_start(); 
// Connect to the database

$conn = require('includes/connect.php');

// Output any errors in case the connection failed
if($conn->connect_error){
	die("Connection Failed: " . $conn->connect_error);
}

// Initialize the queue id variable
$q_id = -1; 

// Check the total # of players in the game sent from the index page 
$totPlayers = $_POST["totPlayers"];

// Check the game mode sent from the index page
$gmode = $_POST["gmode"]; 

// Query the database to see if the queue has been initialized 
// Looking for any queue with with n players and the correct game mode
$queue_query = sprintf("select q_id, currPlayers from queue where totPlayers=%d and gmode=%d", $totPlayers, $gmode);
$result = $conn->query($queue_query);

// The output stores 2 pieces of data: 
// 1) Whether the game should be started  
// 2) The Queue or Game id depending on if the game has been initialized
$output = "";

// If the queue already exists, it is important to add this user to the queue 
if($result->num_rows > 0){
	// Obtain the queue that I am entering which is stored as a row in the queue table 
	$row = $result->fetch_assoc();
	// Obtain the q_id of the row 
	$q_id = $row['q_id']; 
	// Obtain the current # of players + 1 because the new player is being added
	$currPlayers = $row['currPlayers'] + 1;
	
	// Increment the number of players in that row 	
	$increment_queue = sprintf("update queue set currPlayers = currPlayers + 1 where q_id = %d", $q_id); 
	$conn->query($increment_queue); 

	
	// If the queue is full, then begin the game 
	if($currPlayers == $totPlayers){

		// This creates a row in the user list table -- currently this is not being used
		$create_user_list = sprintf("insert into user_list (u1, u2, u3, u4, u5, u6, u7, u8) values (%d, %d, %d, %d, %d, %d, %d, %d)", $_SESSION['u_id'], 0, -1, -1, -1, -1, -1, -1);
		$result = $conn->query($create_user_list);

		// Grab the id of the list of users -- falls into last command category: not being used
		$user_list_id = $conn->insert_id; 

		// Initialize the first word
		srand(time());
		$init_word = rand(0, 2146);

		// Create the game: it is stored in the database as a row   
		$create_game_query = sprintf("insert into game (gameType, numPlayers, user_list_id, currTurn, currWord, options_id) values (%d, %d, %d, %d, %d, %d)", 0, 2, $user_list_id, 0, $init_word, -1); 
		$result = $conn->query($create_game_query);
		
		// Obtain the game id
		$g_id = $conn->insert_id;

		// Update the queue's game id 
		$update_gid = sprintf("update queue set g_id = %d, currPlayers = 0 where q_id = %d", $g_id, $q_id);
		$conn->query($update_gid);

		// Update the game id of hte session making it accessible from any page
		$_SESSION['g_id'] = $g_id; 
		// Set the session's turn id to 0 
		$_SESSION['turn_id'] = 0; 
		
		// This is the output it will now send a game id instead of a q_id
		$output = ["startGame" => true, "q_id" => $g_id]; 
	}
	// If there is already a queue in existence but it is not full
	else {
		if($currPlayers == 1){
			$resetGameID = sprintf("update queue set g_id = -1 where q_id = %d", $q_id);
			$conn->query($resetGameID); 
		}
		// This states that there is already a queue in existent but there are not enough players
		$output = ["startGame" => false, "q_id" => $q_id];
	}
}


// If the row does not exist it will have to make the row 
else{
	// Create a queue which is stored as a row in the queue database 
	$create_queue_row = sprintf("insert into queue (g_id, gmode, totPlayers, currPlayers, options_id) values (%d, %d, %d, %d, %d)", -1, $gmode, $totPlayers, 1, -1);
	if($conn->query($create_queue_row) !== TRUE){
		echo "Error: " . $create_queue_row . "\n" . $conn->error; 

	}

	$q_id = $conn->insert_id; 
	$output = ["startGame" => false, "q_id" => $q_id];
}

// Encode the output so that it can be transferred via post request
$output = json_encode($output);
echo $output; 
?>
