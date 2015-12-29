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

		$_SESSION['page'] = 'subjects';
		include 'TuteeNavBar.php';
		
		?>
		<h1><?php echo $_SESSION['current_firstName'];?>'s Subjects</h1>
		
		<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Add Subject</button>
		
		<ul id="tutee-subject-list" class="list-group">
		
			<script>
				Parse.initialize("cWXjlwyKH3BwBbxFjhun4IJAlOhrU5PuoURXSmFT", "hYh3XGDxMPQFCSVa6KbCZnbWClx5YFqynfIDtFLv");
				var tuteeSubjects = currentUser.get("subjects");
			
				for(var i = 0; i < tuteeSubjects.length; i++){
					document.write('<li class="list-group-item"><a href="TuteeSubjectPage.php?subject=' + tuteeSubjects[i] + '">' + tuteeSubjects[i] + '</a></li>');
				}
			</script>
			
		</ul>
		
		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-body">
						<div class="form-group" style="margin-top:15px;">
							<label for="tag" class="control-label">Select A Subject:</label>
							<select id="subjectSelect" class="c-select">
								<option value=""> --- </option>
								<?php
									
									for ($i = 0; $i < count($all_subjects); $i++){
										echo '<option value="' . $all_subjects[$i]->get("title") . '">' . $all_subjects[$i]->get("title") . '</option>';
									}
									
								?>
							</select>
						</div>
					</div>
					<div id="subjectInfo" style="background-color:#f10" width="500" height="500">
						INFO ABOUT SUBJECT HERE
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						<button class="btn btn-primary" data-dismiss="modal" id="addSubjectButton">Add</button>
					</div>
				</div>
			</div>
		</div>
		
		
		
		<script>
			$( document ).ready(function() {
				Parse.initialize("cWXjlwyKH3BwBbxFjhun4IJAlOhrU5PuoURXSmFT", "hYh3XGDxMPQFCSVa6KbCZnbWClx5YFqynfIDtFLv");
				
				$('#addSubjectButton').click(function(){
		
					var newSubject = $("#subjectSelect").val();
					
					if(newSubject === ""){
						alert('You did not select any subject');
					}
					else{
						var tuteeSubjects = currentUser.get("subjects");
						
						/* Check that subject has not already been selected previously */
						var hasAlreadyBeenAdded = false;
						for(var i = 0; i < tuteeSubjects.length; i++){
							if(tuteeSubjects[i] == newSubject){
								hasAlreadyBeenAdded = true;
								break;
							}
						}
						
						tuteeSubjects.push(newSubject);
						currentUser.set("subjects", tuteeSubjects)
						
						currentUser.save(null, {
						  success: function() {
								$("#tutee-subject-list").append('<li class="list-group-item"><a href="TuteeSubjectPage.php?subject=' + newSubject + '">' + newSubject + '</a></li>');
						  },
						  error: function( error) {
						    // Execute any logic that should take place if the save fails.
						    // error is a Parse.Error with an error code and message.
						    alert('Failed to add subject, with error code: ' + error.message);
						  }
						});
					}
					
					
					
					$("#subjectSelect").val("");
					
				});
				
			});
		</script>
		
	</body>
</HTML>