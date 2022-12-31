// This is the globally accessible game status 
let gameStatus = {'currWord': '', 'currID': -1, 'g_id': -1, 'myTurn': -1, 'currTurn': -1}; 

// Get the resign button by it's ID
let resignBtn = document.getElementById("resign");	

// When the resign button is clicked it displays the block
resignBtn.onclick = function() {	
	// Call the javascript function for resign with the given gamemode
	// Call the game functions lose 

	// if the game is against an opponent it notifies the server that the opponent has lost
	if(gameStatus['g_id'] != -1){
		var data = {'g_id': gameStatus['g_id']};
		// Send resign to server
		$.ajax({
			type: "POST",
			data: data,
			url: "includes/resign.php",
			success: function(){
				document.getElementById("loseModal").style.display="block";
			}
		});
	}	
	else{	
		document.getElementById("loseModal").style.display="block";
	
	}
}

// This should get moved to Bots 
function resetGame(){
	// When the user clicks reset, it will add both users to the 
	if(g_id == -1){
		// Reset the game and start over
		gameFunctions.chooseFirst();
	}
	else{
		
	
	}
}

// This is the function that displays an error in regards to user input
function displayError(err){
	// Grab the alert box that will be displayed
	var alertBox = document.getElementById("err"); 
	
	// Change the height of the surrounding grey box
	document.getElementById('b1').style.height = '325px'; 

	// Show the alert block
	if(alertBox.hasAttribute('hidden')){
		alertBox.removeAttribute('hidden');
	}
	// Chagne the alert block to the proper text 
	alertBox.innerHTML = "<strong>Error: </strong>" + err; 	

}
// Fucntion that runs every few seconds or so that checks the server to see if it is
function checkGameStatus(gameStatus){
	// First check if it is currently my turn
	// Unnecessary to check status of game if I am the one who is able to update the game
	

	var data = {'g_id': gameStatus['g_id']};
	// Send a post request to the server pinging the database and gathering some data
	$.ajax({
		type: 'POST',
		data: data, 
		url: 'includes/checkGame.php',
		success(result){
			// Ping the database, it will retrieve 3 updated variables: 
			// TotPlayers, CurrWord, CurrTurn
			result = JSON.parse(result); 
			var updatedWordID = result['id'];
			var updatedWordStr = result['word'];
			var updatedTurn = result['turn'];
			var updatedPlayers = result['numPlayers']; 
			if(updatedPlayers == 1){
				
				document.getElementById("winModal").style.display="block";
				return; 
			}
			if(gameStatus['myTurn'] == gameStatus['currTurn']){
				return; 
			}
			// a) Nothing Has Changed: currTurn == updatedTurn && currWord == updatedWord 
			else if(gameStatus['currID'] == updatedWordID && gameStatus['currTurn'] == updatedTurn){
				 return ;
			}
			// c) User Resigned -- Don't need to worry about this
			// Case i) There is one player
			// Case ii) There is still more than one player (not something I need to worry about)
			
	
			// b) New Word: updatedTurn == (currTurn + 1) % numPlayers && currWord != updatedWord
			else if(updatedTurn != gameStatus['currTurn'] && gameStatus['currID'] != updatedWordID){
				gameStatus['currWord'] = updatedWordStr; 
				gameStatus['currID'] = updatedWordID; 
				gameStatus['currTurn'] = (gameStatus['currTurn'] + 1) % 2; 
				// update the current word that is being displayed
				document.getElementById("word").innerHTML = updatedWordStr;
				document.getElementById('announcer').innerHTML = 'Versus: Take Your Turn';
				return;
			}

		}		
	});
	// Output: Current Turn, Current Word 
}


// Grab the id of the game if it is set 
// The first turn of the game will always be 0, this may or may not be this user's turn
// Initialize the dictionaries 
$.ajax({
type: "GET",
url: 'includes/initGame.php',
success: function(gameDataResults){
	// Obtain and parse the JSON results from teh gameDataResults
	var gameData = JSON.parse(gameDataResults); 
	// Obtain the game id from that php document
	gameStatus['g_id'] = gameData['g_id']; 
	// Obtain the current turn from the gameData 
	gameStatus['myTurn'] = gameData['myTurn']; 
	// Set the total number of turns to too, this will eventually be updated when multiplayer is added
	var totTurns = 2; 
	// Set the current turn to 0, this determines whose turn it is 
	gameStatus['currTurn'] = 0; 
	// This updates the user whether it's their turn or the opponents 
	var announcer = document.getElementById('announcer');
	// Tells the announcer what to say 
	switch(gameStatus['myTurn']){
		case(-1):
			announcer.innerHTML = 'Versus: Beat the Bot'
			break; 
		case(0):
			announcer.innerHTML = 'Versus: Take Your Turn'
			break; 
		default: 
			announcer.innerHTML = 'Versus: Waiting for Opponent';
			break; 
	}

	// Outputs the current game id

	// The php links that should be called when played against the algorithm 
	var algLinks = {'init': 'includes/chooseStart.php', 'newWord': 'includes/botPly.php'}; 
	// The php links that should be called when played against another player
	var multiplayerLinks = {'init': 'includes/getFirstWord.php', 'newWord': 'includes/userPly.php'};
	// The array storing which links should be called
	var links = [algLinks, multiplayerLinks];
	// Determines which links should be used based on whether the user is playing against the alg or another user
	var linkID = (gameStatus['g_id'] == -1) ? 0 : 1;  


	// Parse the results and seperate them
	// if the game id is not -1, frequently ping hte database
	

	// Initialize the first word
	$.ajax({
	type: "POST",
	url: links[linkID]['init'],
	success: function(initWord){
		var result = JSON.parse(initWord);
		// Obtain the previous word
		gameStatus['currWord'] = result['w_str'];
		// Obtain the previous id
		gameStatus['currID'] = result['w_id'];

		if(gameStatus['g_id'] != -1){
			setInterval(checkGameStatus, 1000, gameStatus);	
		}
		document.getElementById("word").innerHTML = gameStatus['currWord'];
		// 3. User enters word causing ajax to open buffer
		$('form.ajax').on('submit', function(e){
			e.preventDefault();
			// The user input  -- temporary because it might not be used
			var tempInput = $("#w_str").val();
			var input = {curr: tempInput, prev: gameStatus['currWord']}; 

			// This is the textbox that will be updated whenever a new word is entered 	
			var textbox = document.getElementById("word"); 
			// validate the word
			$.ajax({
				type: "POST",
				data: input,
				url: 'includes/wordCheck.php',
				success: function(errMsg){
					// This gets the error message based on the word check 
					
					// If there is no error it sends the word to the opponent 
					
					if(errMsg === 'true'){
						// The temporary string is the current word becaue that's what's being
						var wordData = {'g_id': gameStatus['g_id'], 'curr': tempInput, 'currTurn': gameStatus['currTurn']};
						
						$.ajax({
							type: "GET",
							data: wordData, 
							url: links[linkID]['newWord'],
							success: function(newWord){
								
								// What happens with the bot is going to be very different than what happens with multiplayer
								// In multiplayer, there are two outputs: 
								// 1) It is not the player's turn 
								// What needs to happen here, the current turn needs to update
								// The curent word needs to update
								// If the bot has lost it returns l & outputs the win modal 
								
								if (newWord.trim() === 'm'){
									displayError('It is not your turn'); 	
								}
								else if(newWord.trim() === 'l'){	
									document.getElementById("winModal").style.display="block";

								}										
								// The bot sends a word and sets it to the new word that the user has to use
								
								else{
									gameStatus['currWord'] = newWord;   
									var alertBox = document.getElementById('err');
									document.getElementById("word").innerHTML = gameStatus['currWord'];
									document.getElementById("b1").style.height = "250px";
									if(!alertBox.hasAttribute('hidden')){
										alertBox.setAttribute('hidden', 'hidden'); 
									}
									
									if(gameStatus['g_id'] != -1){
										// Update the current turn 
										gameStatus['currTurn'] = (gameStatus['currTurn'] + 1) % 2; 
										document.getElementById('announcer').innerHTML = 'Versus: Waiting for Opponent';
									}
								}	
								
							} // Ends success function 

						}); // Ends the ajax request to find a new word

					} // Ends if the word is valid if statement

					else{
						displayError(errMsg);
					}
							
				}  // Ends the success function of the word check 

			}); //Ends the ajax call for the Word Check
			document.getElementById("wordForm").reset(); 
		}); // Ends the Ajax on submit call 

	}});// End 
}}); 