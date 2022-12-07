<?php 
session_start(); 

// This is the set of words that have already been used 
$wordSet = $_SESSION['WordSet']; 
// This converts a word to an integer
$dictionary = $_SESSION['WordToInt']; 
// This convert
$prev = $_POST['prev'];
$curr = $_POST['curr']; 


/*Check the word has no special characters or numbers*/
if(!ctype_alpha($curr)){
	echo "Input must only contain letters"; 
	exit(1); 
}	
/*Verify that the word is not too short*/
if(strlen($curr) < 4){
	echo "Input is shorter than 4 characters";
	exit(1); 

}

/*Verify that the word is not too long*/
if(strlen($curr) > 4){
	echo "Input is longer than 4 characters"; 
	exit(1);
}	

if(!array_key_exists($curr, $dictionary)){
	echo "Word not found in dictionary";
	exit(1);
}	
/*Validate that it connects properly*/
// Take the previous word
$c = 0;

//Loop through the current character set 
for($i = 0; $i < 4; $i++){
	if($curr[$i] === $prev[$i]){
		$c += 1; 
	}
}
if($c < 3){
	echo "Not enough letters in common";
	exit(1); 
}
else if($c > 3){
	echo "Word cannot be same as previous"; 
	exit(1); 

}



// Check if the word is in the set of used words
if(in_array($dictionary[$curr], $wordSet)){
	echo "Word already used"; 
	exit(1); 
}

echo "true"; 	
 
?>
