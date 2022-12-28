<!DOCTYPE html>

<?php
// 0. User opens website
session_start();


?>

<!--  2. Design the front end of the website -->
<html>
	<head>	 
		<!-- Initialize jquery libraries for ajax accessibility -->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<!-- Game Functions for the four letter word game -->
		<script src="gameFunctions.js" type="text/javascript" def></script> 
		<!-- Initialize any templates -->
		<script src="template.js" type="text/javascript" def></script>
		<!-- Initialize Bootstrap -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>	
		<link rel="stylesheet" href="modal.css">
	</head>

	<body>
		<!-- Navbar -->
		<script>
			document.write(navigationBar);
		</script>
		<div style="text-align:center;padding-top:25px">	
			<h1 style="center" id="announcer"></h1>
		</div>
			
		<!-- Word Display -->
		<!-- The full box -->

                <form method="get" class="ajax" id="wordForm" action="includes/functions.php">
		<div class="d-flex justify-content-center flex-nowrap container" style="padding:20px">
			<!-- The grey box -->
			<div class="d-flex justify-content-center flex-nowrap bg-dark" id="b1" style="padding:20px; width:1000px; height: 250px;">
				<div class="row">
					<!-- The blue box -->
					<div class="col-sm-12 col-xl-12 justify-content-center d-flex">
						<div class="bg-primary text-white mx-10 p-3"; style="width:550px; text-align:center">
							<!-- The text -->
							<h1 id="word" style="center"></h1>
						</div>
					</div>
					
					<div class="row">
				
						<!-- Insert input #1  -->
						<div class="form-group col-xl-12" style="padding:20px">
							<input type="text" maxlength=5 placeholder="Enter a four letter word" class="form-control" id="w_str">
						</div>
				

					</div>

					<div class="row">
						<div class="form-group col-xl-12">
							<div class="alert alert-danger" id="err" hidden><strong>Error: </strong>Input was not long enough</div>	
						</div>
					</div>
					<div class="row justify-content-center flex-nowrap">
						<div class="col-sm-4 justify-content-center d-flex">
							<button type="submit" id="submit" class="btn btn-success" style="font-size:25px">Enter word!</button>
						</div>
						<div class="col-sm-4 justify-content-center d-flex"> 
							<button type="button" id="resign" class="btn btn-danger justify-content-center d-flex" style="font-size:25px" href="index.php">Resign</button>
						</div>
					
					</div>				

				</div>

			</div>
		</div>
		</form>	

		<div id="winModal" class="modal">
			<div class="modal-content">
				<!-- Header: Congrats! You Won-->
				<div class="container-fluid p-5 text-center bg-success text-white" style="width:100%">
					<h1>Congratulations, you've won!</h1>
				</div>	
				
				<!-- Check Mark png -->
				<img src="./img/star.svg" alt="star" style="width:35%; margin:auto; height:35%">
				

				<!-- New Game/Home Screen -->
				<div class="row justify-content-center flex-nowrap" style="padding-top:25px">
				
					<div class="col-sm-4 justify-content-center d-flex">
						<form action="flwg.php">
							<button type="submit" id="submit" class="btn btn-success" style="font-size:25px">Play Again</button>
						</form>
					</div>
						<div class="col-sm-4 justify-content-center d-flex"> 
							
					<form action="index.php">
							<button type="submit" class="btn btn-secondary justify-content-center d-flex" style="font-size:25px">Home Page</button>

					</form>
						</div>
				</div>
			</div>
		</div>

		<div id="loseModal" class="modal">
			<div class="modal-content">
				<!-- Header: Congrats! You Won-->
				<div class="container-fluid p-5 text-center bg-danger text-white" style="width:100%">
					<h1>Defeat, better luck next time!</h1>
				</div>	
				
				<!-- Check Mark png -->
				<img src="./img/lose.svg" alt="star" style="width:35%; margin:auto; padding-top: 20px; height:35%">
				

				<!-- New Game/Home Screen -->
				<div class="row justify-content-center flex-nowrap" style="padding-top:25px">
				
					<div class="col-sm-4 justify-content-center d-flex">
						<form action="flwg.php">
							<button type="submit" id="submit" class="btn btn-primary" style="font-size:25px">Play Again</button>
						</form>
					</div>
						<div class="col-sm-4 justify-content-center d-flex"> 
							
					<form action="index.php">
							<button type="submit" class="btn btn-secondary justify-content-center d-flex" style="font-size:25px">Home Page</button>

					</form>
				</div>

			</div>
		</div>
		<div class="content bg-dark" style="position:fixed; left:0; bottom:0; width:100%; text-align: center;">
			<p>Display</p>
		</div>

			




	        <script>
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
			gameStatus['g_id'] = <?php echo ((isset($_SESSION['g_id'])) ? $_SESSION['g_id'] : -1); ?>; 
			gameStatus['myTurn'] = <?php echo ((isset($_SESSION['turn_id'])) ? $_SESSION['turn_id'] : -1); ?>;
			// The first turn of the game will always be 0, this may or may not be this user's turn
			var totTurns = 2; 
			gameStatus['currTurn'] = 0; 
			var announcer = document.getElementById('announcer');
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

			// Initialize the dictionaries 
			$.ajax({
			type: "GET",
			url: 'includes/createDictionary.php',
			success: function(r){
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
                </script>

        </body>
	

</html>
