var navigationBar = `
<!-- THE REGISTER MODAL--> 
<div id="container mt-3"> <div class="modal" id="registerModal">
		<div class="modal-content" style="width: 80%">

			<span class="close" id="registerClose">&times;</span>
			<h1>Register</h1>
			<form class="rc" id="registerForm" accept-charset=utf-8>
				<div class="mb-3 mt-3">
					<label for="uname" class="form-label">Username: </label>
					<input type="text" class="form-control" id="u_name" placeholder="Enter username" maxlength=20 name="u_bname">
				</div>
				<div class="mb-3 mt-3">
					<label for="pword" class="form-label">Password: </label>	
					<input type="password" class="form-control" id="p_word" placeholder="Enter password" maxlength=20 name="p_word">
				</div>

				<div class="mb-3 mt-3">
					<label for="pword2" class="form-label">Re-enter Password: </label>	
					<input type="password" class="form-control" id="p_word2" placeholder="Re-enter password" maxlength=20 name="p_word2">
				</div>	
				<div class="mb-3 mt-3">
					<label for="email" class="form-label">Email:</label>
					<input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
				</div>	
				<div class="mb-3 mt-3">
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div id="aboutModal" class="modal">
	<div class="modal-content" style="width:80%">
		<span class="close" id="aboutClose">&times;</span>
		<h1>About Page</h1>
	</div>
</div>

<div id="moreModal" class="modal">
	<div class="modal-content" style="width:80%">
		<span class="close" id="moreClose">&times;</span>
		<h1>More</h1>
	</div>
</div>

<div id="helpModal" class="modal">
	<div class="modal-content" style="width:80%">
		<span class="close" id="helpClose">&times;</span>
		<h1>Welcome to Four Lettter Word Puzzles</h1>
		<h2>The concept</h2>
		<p>The overarching concept that applies in all three games is "letter substitution"</p>
		<p>Letter substitution is as follows: Starting with a four letter word, change one of the individual letters to make it a new word</p>
		<p>An example of this is starting with ties, convert the 't' to a 'p' to make it 'pies'. From there a participant could change the letter 'e' to 'n' to make it pins</p>
		<h2>The Rules</h2>
		<p>A participant cannot change more than one letter at a time; thus 'pies' to 'tier is invalid'</p>
		<p>A participant can neither add nor remove letters; thus pies to pie, or pines is invalid</p>
		<p>Slang, acronyms, proper nouns and abbreviations are not permitted</p>
		<p>The dictionary is constantly being improved, please let me know if there are any words you would like added or removed</p>
		<p>This concept is taken and applied to the three following games</p>
		<h2>The games</h2>
		<h3>Versus</h3>
		<p><em>Versus:</em> Starting with a word, go back and forth with an opponent changing it via letter substituion, without getting stuck</p>
		<h3>Pathfinder</h3>
		<p><em>Pathfinder:</em> Starting with a word, and having a goal word, create a path between the two; for example, pies->tins: pies->pins->tins</p>
		<h3>Challenge</h3>
		<p><em>Challenge:</em> A combination between Versus & Pathfinder, two opponents each have their own unique word they would like to reach, unaware of their opponents goal.</p> 
	</div>
</div>

<!-- The login modal -->
<div id="container mt-3">
	<div class="modal" id="loginModal">
		<div class="modal-content" style="width: 80%">

			<span class="close" id="loginClose">&times;</span>
			<h1>Login:</h1>
			<form class="rc" id="loginForm" accept-charset=utf-8>
				<div class="mb-3 mt-3">
					<label for="uname" class="form-label">Username: </label>
					<input type="text" class="form-control" id="u_name_login" placeholder="Enter username" maxlength=20 name="u_bname">
				</div>
				<div class="mb-3 mt-3">
					<label for="pword" class="form-label">Password: </label>	
					<input type="password" class="form-control" id="p_word_login" placeholder="Enter password" maxlength=20 name="p_word">
				</div>

				<div class="mb-3 mt-3">
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg p-0 navbar-dark bg-dark">
	<div class="container-fluid p-0" style="float:right; fill:white;">
		<a class="navbar-brand" style="fill:white; padding-left:10px" href="./index.html">
			<img src="./img/home.svg" alt="logo" width="33" height="33">
		</a>	
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="mynavbar">
			<ul class="navbar-nav me-auto mb-2 mb-sm-0">
				<li class="nav-item" style="font-size:24px">
					<a class="nav-link" id="helpButton" href="#helpModal">Help</a>
				</li>
				<li class="nav-item" style="font-size:24px;">
					<a class="nav-link" id="aboutButton" href="#aboutModal">About</a>
				</li>
				<li>
					<a class="nav-link" id="moreButton" style="font-size:24px;" href="#moreModal">More</a>
				</li>
			</ul>	
		<ul class="nav navbar-nav navbar-right" id="loginInfo">
			<script src="signIn.js" type="text/javascript" def></script>
   		 </ul>	
	</div>

</nav>
<!-- END COPY -->
`;
document.write(navigationBar); 
