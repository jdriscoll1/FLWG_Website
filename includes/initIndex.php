<?php
// Start the session
session_start();
// Reset the game id
unset($_SESSION['g_id']);
// Reset the queue id
unset($_SESSION['q_id']); 
// Unset the turn id
unset($_SESSION['turn_id']); 
// Pass back the user id 
echo (isset($_SESSION['u_id']) ? $_SESSION['u_id'] : -1); 
?>
