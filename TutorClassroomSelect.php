<?php
	
require 'ParseSDK/autoload.php';
use Parse\ParseClient;
use Parse\ParseObject;
use Parse\ParseQuery;
ParseClient::initialize('cWXjlwyKH3BwBbxFjhun4IJAlOhrU5PuoURXSmFT', 'gBnGei76iDjgKDE8Aq5LWYJTADZpZW8bf7fcQkpm', 'y078995uSeCNpTHC69EatJhLIkRgc9Rkz6fWQd9N');

if(session_status() != PHP_SESSION_ACTIVE){
	session_start();
}

// Fetch subjects
if(array_key_exists('all_subjects_cached', $_SESSION)){
	$all_subjects = $_SESSION['all_subjects_cached'];
}
else{
	$subjectsQuery = new ParseQuery("Subject");
	$all_subjects = $subjectsQuery->find();
	$_SESSION['all_subjects_cached'] = $all_subjects;
}


	
?>

<!DOCTYPE HTML>
<HTML>
	<head>
		<?php include 'includes.php';?>
	</head>
	
	<body>
		<?php 
		
		if(session_status() != PHP_SESSION_ACTIVE){
			session_start();
		}
		
		?>
		
		<h1>Which Subject Will You Be Teaching?</h1>
		<select id="subjectSelect" class="c-select">
			<option value=""> --- </option>
			<?php
				
				for ($i = 0; $i < count($all_subjects); $i++){
					echo '<option value="' . $all_subjects[$i]->get("title") . '">' . $all_subjects[$i]->get("title") . '</option>';
				}
				
			?>
		</select><br /><br />
		
		<button type="button" class="btn btn-info" id="subjectSelectButton">Go!</button>
		
		<script>
			$( document ).ready(function() {
				
				Parse.initialize("cWXjlwyKH3BwBbxFjhun4IJAlOhrU5PuoURXSmFT", "hYh3XGDxMPQFCSVa6KbCZnbWClx5YFqynfIDtFLv");
				var currentUser = Parse.User.current();
				
				$('#subjectSelectButton').click(function(){
					if($("#subjectSelect").val() === ""){
						alert('Please select a subject');
					}
					else{
						var LectureSession = Parse.Object.extend("LectureSession");
						
						/* Fetch any previous session(s) left open and delete it */
						var query = new Parse.Query(LectureSession);
						query.equalTo("tutorUsername", currentUser.get("username"));
						query.equalTo("subject", $("#subjectSelect").val());
						query.find({
						  success: function(results) {
							  
							  /* After deleting, create new session */
							Parse.Object.destroyAll(results).then(function(success){
								var session = new LectureSession();
								session.set("subject", $("#subjectSelect").val());
								session.set("tutorUsername", currentUser.get("username"));
								session.set("tutorName", currentUser.get("firstName") + " " + currentUser.get("lastName"));
								session.set("tutorAvatar", currentUser.get("avatar"));
								session.set("clickX", []);
								session.set("clickY", []);
								session.set("clickDrag", []);
								session.set("clickColor", []);
								session.set("clickSizes", []);
								session.set("clickTool", []);
								session.set("isSessionActive", true);
						
								session.save(null, {
								  success: function(session) {
									window.location.href = "Classroom.php?lectureId=" + session.id;
								  },
								  error: function(session, error) {
								    // Execute any logic that should take place if the save fails.
								    // error is a Parse.Error with an error code and message.
								    alert('Failed to create lecture session, with error code: ' + error.message);
								  }
								}, function(error){alert("Error: " + error.code + " " + error.message);});
							});
						  },
						  error: function(error) {
						    alert("Error: " + error.code + " " + error.message);
						  }
						});
					}
				});
				
			});
		</script>
		
	</body>
</HTML>