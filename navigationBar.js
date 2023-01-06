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
					<a class="nav-link" href="javascript:void(0)">Help</a>
				</li>
				<li class="nav-item" style="font-size:24px;">
					<a class="nav-link" href="javascript:void(0)">About</a>
				</li>
				<li>
					<a class="nav-link" style="font-size:24px;" href="javascript:void()">More</a>
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
