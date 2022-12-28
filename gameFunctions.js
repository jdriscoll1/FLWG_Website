// Javascript class that is dedicated to game functions
//
class GameFunctions{
	// When a game is initialized what happens?
	initGame(){
		$.ajax({
			type: "GET",
			url: 'createDictionary.php',
			success: function(result){
				return JSON.parse(result);

			}

		}); 
	} 
	// When a word is submitted it must validate it 
	submitWord(input){}
	// After a valid word is submitted how will the user access a new word
	receiveWord(){}
	// WHen the game begins, how is the first word chosen?
	chooseFirstWord(){}
	// When the user selects a new game, what happens? 
	newGame() {} 


}

class AlgorithmFunctions extends GameFunctions{

	submitWord(input){
		// When a user submits a word a few thing has to happens
		// It first has to check if it is a valid word 
		$.ajax({
			type: "GET",
			data: input,
			url: 'includes/wordCheck.php',
			success: function(errMsg){
				return errMsg; 	
			}  // Ends the success function of the word check 

                }); //Ends the ajax call for the Word Check

		 
	}
	receiveWord(){
		// The receiving word function is going to take a word that is inputted and get an output out of it
		// So for the Algorithm it will run the bot ply algorithm and will output the new word 
		//
		$.ajax({
                	type: "GET",
			data: input, 
			url: 'includes/botPly.php',
			success: function(newWord){
				return newWord; 
			} // Ends success function 

		}); // Ends the ajax request to find a new word


	}

	chooseFirstWord(){
		// Choosing a first word will simply be a random integer chooser run and return that 
		return Math.floor(Math.random() * 2147); 

	}
	newGame(){
		// Set the previous word to pies 
		$.ajax({
			type: "GET",
			url: 'includes/resetGame.php',
			success: function(result){
			}
		});		
					
		//document.getElementById("word").innerHTML = initWord;

	}
}



class MultiplayerFunctions extends GameFunctions{
	initGame(){
		// When a game is initialized
		// It initializes the word set
		// It grabs the first word from the database row 
		// It adds it to the word set  
	} 
	submitWord(input){
		// When a user submits a word it checks to see if it is valid and adds it to the database if it is 	
		// They also add it to the word set 
	}
	receiveWord(){
		// When a user receives a word there are two things, they add it to the word set
		// They check if it is there turn
		// They change that word to the prevWord
	}
	chooseFirstWord(){
		// This checks the database to see what the first word is 


	}
	newGame(){
		// This puts the user in a queueu for a new game 
	}
}
