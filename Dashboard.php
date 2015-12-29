<!DOCTYPE HTML>
<HTML>
	<head>
		<!-- Parse -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script type="text/javascript" src="http://www.parsecdn.com/js/parse-latest.js"></script>
		
		<!-- Bootsrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

		<!-- Bootstrap JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		
		<!-- Studien stuff -->
		<link href="css/styles.css" rel="stylesheet" type="text/css">
	</head>
	
	<body>
		<?php 
		
		if(session_status() != PHP_SESSION_ACTIVE){
			session_start();
		}
		
		if($_SESSION['current_userRole'] > 0){
			$_SESSION['page'] = 'dashboard';
			include 'TutorNavBar.php';
		}
		else{
			$_SESSION['page'] = 'dashboard';
			include 'TuteeNavBar.php';
		}
		
		?>
		<h1>Welcome <span class="firstNameText"></span></h1>
		
		<script>
		
			$( document ).ready(function() {
				Parse.initialize("cWXjlwyKH3BwBbxFjhun4IJAlOhrU5PuoURXSmFT", "hYh3XGDxMPQFCSVa6KbCZnbWClx5YFqynfIDtFLv");
		
				var currentUser = Parse.User.current();
				if (currentUser) {
					// do stuff with the user
					$(".firstNameText").html(currentUser.get("firstName"));
				} else {
					// show the signup or login page
					$(".firstNameText").html(currentUser.get("ERROR"));
				}
				
			});
		
		</script>
		
	</body>
</HTML>