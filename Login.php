<!DOCTYPE HTML>
<HTML>
	<head>
		<!-- Parse -->
		<script type="text/javascript" src="http://www.parsecdn.com/js/parse-latest.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		
		<!-- Bootsrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

		<!-- Bootstrap JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		
		<title>Enter Studien</title>
	</head>
	
	<body>
	
		<!-- Login form Start -->
		<form id="LoginForm">
			<div class="form-group">
				<label for="email">Email address: </label>
				<input type="email" class="form-control" id="email" placeholder="Email">
			</div>
			<div class="form-group">
				<label for="password">Password: </label>
				<input type="password" class="form-control" id="password" placeholder="Password">
			</div>

			<button type="submit" class="btn btn-default">Log In</button>
		</form>
		<!-- Login form End -->
		
		
		
		<script type="text/javascript">
		
			Parse.initialize("cWXjlwyKH3BwBbxFjhun4IJAlOhrU5PuoURXSmFT", "hYh3XGDxMPQFCSVa6KbCZnbWClx5YFqynfIDtFLv");
		
			$('#LoginForm').on('submit', function(e) {
				e.preventDefault();
				
				// Validate
				
				Parse.User.logIn($('#email').val(), $('#password').val(), {
					success: function(user) {
						// Do stuff after successful login.
						window.location.href = 'LoginController.php?email=' + user.get("email") + '&' +
												'username=' + user.get("username") + '&' +
												'fname=' + user.get("firstName") + '&' +
												'lname=' + user.get("lastName") + '&' +
												'role=' + user.get("userRole") + '&' +
												'bio=' + user.get("bio");
					},
					error: function(user, error) {
						// The login failed. Check error to see why.
						alert("Error: " + error.code + " " + error.message);
					}
				});
				
			});
			
		</script>
		
	</body>
</HTML>