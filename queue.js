$.ajax({
	type: "POST",
	url: 'includes/initIndex.php',
	success: function(u_id){
		// The necessary data for the page to be accessible 
		var pageData = {'decrement': false, 'totPlayers': 2, 'g_mode': 0, 'u_id': u_id, 'q_id': -1, 'interval_id': -1};

		// The page that allows you to choose which game you'd like to play
		var flwgModal = document.getElementById("myModal");
		
		// The button that opens the modal
		var flwgButton = document.getElementById("flwgBtn");

		// Close the four letter word game modal
		var flwgClose = document.getElementById("flwgClose");
	
		var flwgQueueGuest = document.getElementById("flwg-guest");  

		var flwgQueueComputer = document.getElementById("flwg-computer"); 
		// Open the modal on click
		flwgButton.onclick = function() {
			flwgModal.style.display = "block";
		}

		// Close the modal on click
		flwgClose.onclick = function() {
			flwgModal.style.display = "none";
		}
		flwgQueueComputer.onclick = function() {
			location.href='./flwg.html'; 
		}
		
		// Code when the user exits the queue 
		function exitQueue(e) {
			// Prevents the page from dropping out  
			e.preventDefault();
			e.returnValue = '';
			
			var pageData = e.currentTarget.pageData; 
			// Fixes bug that causes queue decrementation to happen multiple times
			if(!pageData['decrement']){
				// Reset the decrement to true
				pageData['decrement'] = true; 
				var queueData = {'q_id': pageData['q_id']}; 
				$.ajax({
					type: "POST",
					data: queueData,
					url: "includes/userQuit.php",
					success: function(r){
						// Set it to say guest and that it is no longer searching
						document.getElementById("flwg-guest").innerHTML = "Guest";	
						pageData['decrement'] = true; 
						// User is no longer in a queue
						pageData['q_id'] = -1; 
						// Stops webpage from asking player if they want to leave the page
						window.removeEventListener('beforeunload', exitQueue);
						// Stops webpage from querying queue
						clearInterval(pageData['interval_id']);
					}
				});

			}

		}	    
		// Frequently check if a user has joined the queue
		function queryQueue(data, button){
			
			// When the user queries the queue it sends out an ajax request telling it to run queryQueue.php
			$.ajax({
				type: "POST",
				data: data,
				url: 'includes/queryQueue.php',
				success: function(g_id){
					if(g_id > -1){
						pageData['g_id'] = g_id; 
						// Stops webpage from asking player if they want to leave page
						window.removeEventListener('beforeunload', exitQueue);
						// Redirect user to game page 	
						window.location.href = "flwg.html";
					}	
				}

			}); 
			// If it returns a game id, it changes the innerHTML to 2 or more players are in 

		}
		// If a user is in a queue when they log out in decrements the # of players in the queue 
		// This Adds a player to the queue when they press the queue button 
		function queryFLWG(){
			// This is the modal that will be shown if the user is not logged in 
			var loginModal = document.getElementById("loginModal"); 
			// The boolean that determines if the user is signed in 
			
			pageData['decrement'] = false; 
			// If the user is not singed in it will open the sign in sheet
			if(pageData['u_id'] == -1){
				loginModal.style.display = "block";
				flwgModal.style.display = "none";
			
			}
			else if (pageData['q_id'] != -1){
				alert("You are already in a queue");
			}
			// Otherwise it will announce the user is in the queue
			else{
				// Solves weird error where it removes user from queue multiple times
				// Now I have to change the button to say that they are "Waiting for an opponent"
				var flwgGuestButton = document.getElementById("flwg-guest");
				var data = {totPlayers: pageData['totPlayers'], gmode: pageData['g_mode']};
				// Then I send out an ajax request asking if there is a queue, if there is not one they will be inserted into the queue
				flwgGuestButton.innerHTML = "Waiting for Opponents";
				
				// When a button is pressed send out an ajax reqeust to create a queue 
				$.ajax({
					type: "POST",
					data: data,
					url: 'includes/initQueue.php',
					success: function(jsonData){
						// Output the result of the initialQueue.php
						// The result of the game query
						var result = JSON.parse(jsonData);
						// This is the data that is sent into the queue quit 

						// When the user wants to leave they also leave the queue
						// So when the window unloads, it asks the user if they're certain they want to close it 
						window.addEventListener('beforeunload', exitQueue);
						window.pageData = pageData;

						if(result['startGame']){
							pageData['g_id'] = result['q_id'];
							window.removeEventListener('beforeunload', exitQueue);
							// Redirect user to proper page
							window.location.href = "flwg.html";
						}
						else{
							pageData['q_id'] = result['q_id'];
							// It is necessary to occasionally check if any users have entered the game
							pageData['interval_id'] = setInterval(queryQueue, 1000, pageData, flwgGuestButton);
						}
					}
				});
				
			}
		}
	
		flwgQueueGuest.onclick = function() {
			queryFLWG(); 
		}
	}



});

		
