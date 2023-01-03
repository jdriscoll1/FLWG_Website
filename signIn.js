// Goal: Create two different navbar outputs depending if the user is logged in 
// 2 different strings, a. logged in variants b. not logged in variant
// Not Logged in variant is what we already have
// Logged Out: Output Register & Login	
var l1 = '<li><a class="nav-link" style="font-size:24px;" id="registerButton" href="#registerModal" date-toggle="modal"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li><li><a class="nav-link" style="font-size:24px;" id="loginButton" href="#login"><span class="glyphicon glyphicon-log-in"></span>Login</a></li>';
// Logged in: Output Profile & Logout 
var l2 = '<li><a class="nav-link" style="font-size:24px;" id="profileButton" href="#profile" date-toggle="modal"><span class="glyphicon glyphicon-user"></span>Profile</a></li><li><a class="nav-link" style="font-size:24px;" id="logoutButton" href="#logout"><span class="glyphicon glyphicon-log-in"></span>Logout</a></li>';
var signedIn = -1; 
$.ajax({
type: "GET",
url: "includes/getSignedIn.php",
success: function(s){
	document.getElementById("loginInfo").innerHTML = (s == -1) ? l1 : l2;
	// If the user is not signed in 
	if(s == -1){
		// Obtain the buttons
		var registerButton = document.getElementById("registerButton");
		var registerModal = document.getElementById("registerModal");
		var registerClose = document.getElementById("registerClose");
		var loginButton = document.getElementById("loginButton");
		var loginModal = document.getElementById("loginModal");
		var loginClose = document.getElementById("loginClose");
		if (registerButton != null) {
			registerButton.onclick = function(){
				registerModal.style.display = "block";
			}
		}
		if(registerClose != null){
			registerClose.onclick = function() {
				registerModal.style.display = "none";
			}
		}
		if(loginButton != null){	
			loginButton.onclick = function(){
				loginModal.style.display = "block";
			}
		}
		if(loginClose != null){
			loginClose.onclick = function(){
				loginModal.style.display = "none";
			}
		}	
		// When the button is clicked it is necessary to send an ajax request to register.php which should be renamed register.php
		if(document.getElementById("loginForm") != null){
			$("#loginForm").submit(function(e){
				e.preventDefault();
				var userData = {
					u_name: document.getElementById('u_name_login').value,
					p_word: document.getElementById('p_word_login').value,
				};
				$.ajax({
					type: "POST",
					data: userData,
					url: 'includes/login.php',
					success: function(u_id){
						window.location.href = "";
					}
				
				});
			
			}); 	
		}
		if(document.getElementById("registerForm") != null){
			// When the button is clicked it is necessary to send an ajax request to login.php which sends the data to teh login form 
			$("#registerForm").submit(function(e){
				e.preventDefault();
				var userData = {
					u_name: document.getElementById('u_name').value,
					p_word: document.getElementById('p_word').value,
					email: document.getElementById('email').value
				};
			 
				$.ajax({
					type: "POST",
					data: userData,
					url: 'includes/register.php',
					error: function(o){
						alert("Error: " + o);
					},
					success: function(o){
						window.location.href = ""; 
					}
				
				});
			
			}); 


		}
	}

	// If the user is signed in 
	else{
		var logoutButton = document.getElementById("logoutButton");
		if(logoutButton != null){
			logoutButton.onclick = function(){
				
				$.ajax({
					type: "GET",
					url: "includes/logout.php",
					success: function(e){
						window.location.href = "";
					}
				});
			}
		}
	}
}
});
