<?php
	
require 'ParseSDK/autoload.php';
use Parse\ParseClient;
use Parse\ParseObject;
use Parse\ParseQuery;
ParseClient::initialize('cWXjlwyKH3BwBbxFjhun4IJAlOhrU5PuoURXSmFT', 'gBnGei76iDjgKDE8Aq5LWYJTADZpZW8bf7fcQkpm', 'y078995uSeCNpTHC69EatJhLIkRgc9Rkz6fWQd9N');

if(session_status() != PHP_SESSION_ACTIVE){
	session_start();
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
		
		<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">End Session</button>
		<button type="button" class="btn btn-info" id="tutorEndSessionButton">End Session2</button>
		
		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal">&times;</button>
					        <h4 class="modal-title">Please Rate Your Tutor To Complete The Session</h4>
					</div>
					<div class="modal-body">
						<div class="form-group" style="margin-top:15px;">
							<div class="stars">
							  <form id="attitude-form">
								<span>Attitude:</span> <br />
							    <input class="star star-5" id="attitude-star-5" type="radio" name="attitude" value="5"/>
							    <label class="star star-5" for="attitude-star-5"></label>
							
							    <input class="star star-4" id="attitude-star-4" type="radio" name="attitude" value="4"/>
							    <label class="star star-4" for="attitude-star-4"></label>
							
							    <input class="star star-3" id="attitude-star-3" type="radio" name="attitude" value="3"/>
							    <label class="star star-3" for="attitude-star-3"></label>
							
							    <input class="star star-2" id="attitude-star-2" type="radio" name="attitude" value="2"/>
							    <label class="star star-2" for="attitude-star-2"></label>
							
							    <input class="star star-1" id="attitude-star-1" type="radio" name="attitude" value="1"/>
							    <label class="star star-1" for="attitude-star-1"></label>
								<br />
							  </form>
							
							  <form id="preparedness-form">
								<span>Preparedness:</span> <br />
							    <input class="star star-5" id="preparedness-star-5" type="radio" name="preparedness" value="5"/>
							    <label class="star star-5" for="preparedness-star-5"></label>
							
							    <input class="star star-4" id="preparedness-star-4" type="radio" name="preparedness" value="4"/>
							    <label class="star star-4" for="preparedness-star-4"></label>
							
							    <input class="star star-3" id="preparedness-star-3" type="radio" name="preparedness" value="3"/>
							    <label class="star star-3" for="preparedness-star-3"></label>
							
							    <input class="star star-2" id="preparedness-star-2" type="radio" name="preparedness" value="2"/>
							    <label class="star star-2" for="preparedness-star-2"></label>
							
							    <input class="star star-1" id="preparedness-star-1" type="radio" name="preparedness" value="1"/>
							    <label class="star star-1" for="preparedness-star-1"></label>
								<br />
							  </form>
							
								<!-- Surely the tutee is not in the best position to judge the tutor's understanding.
								<span>Understanding:</span> <br />
							    <input class="star star-5" id="understanding-star-5" type="radio" name="understanding"/>
							    <label class="star star-5" for="understanding-star-5"></label>
							
							    <input class="star star-4" id="understanding-star-4" type="radio" name="understanding"/>
							    <label class="star star-4" for="understanding-star-4"></label>
							
							    <input class="star star-3" id="understanding-star-3" type="radio" name="understanding"/>
							    <label class="star star-3" for="understanding-star-3"></label>
							
							    <input class="star star-2" id="understanding-star-2" type="radio" name="understanding"/>
							    <label class="star star-2" for="understanding-star-2"></label>
							
							    <input class="star star-1" id="understanding-star-1" type="radio" name="understanding"/>
							    <label class="star star-1" for="understanding-star-1"></label>
								<br />
								-->
							
							  <form id="usefulness-form">
								<span>Usefulness:</span> <br />
							    <input class="star star-5" id="usefulness-star-5" type="radio" name="usefulness" value="5"/>
							    <label class="star star-5" for="usefulness-star-5"></label>
							
							    <input class="star star-4" id="usefulness-star-4" type="radio" name="usefulness" value="4"/>
							    <label class="star star-4" for="usefulness-star-4"></label>
							
							    <input class="star star-3" id="usefulness-star-3" type="radio" name="usefulness" value="3"/>
							    <label class="star star-3" for="usefulness-star-3"></label>
							
							    <input class="star star-2" id="usefulness-star-2" type="radio" name="usefulness" value="2"/>
							    <label class="star star-2" for="usefulness-star-2"></label>
							
							    <input class="star star-1" id="usefulness-star-1" type="radio" name="usefulness" value="1"/>
							    <label class="star star-1" for="usefulness-star-1"></label>
								<br />
							  </form>
							
							  <form id="thoroughness-form">
								<span>Thoroughness:</span> <br />
							    <input class="star star-5" id="thoroughness-star-5" type="radio" name="thoroughness" value="5"/>
							    <label class="star star-5" for="thoroughness-star-5"></label>
							
							    <input class="star star-4" id="thoroughness-star-4" type="radio" name="thoroughness" value="4"/>
							    <label class="star star-4" for="thoroughness-star-4"></label>
							
							    <input class="star star-3" id="thoroughness-star-3" type="radio" name="thoroughness" value="3"/>
							    <label class="star star-3" for="thoroughness-star-3"></label>
							
							    <input class="star star-2" id="thoroughness-star-2" type="radio" name="thoroughness" value="2"/>
							    <label class="star star-2" for="thoroughness-star-2"></label>
							
							    <input class="star star-1" id="thoroughness-star-1" type="radio" name="thoroughness" value="1"/>
							    <label class="star star-1" for="thoroughness-star-1"></label>
								<br />
							  </form>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button class="btn btn-primary" data-dismiss="modal" id="doneRatingButton">Done</button>
					</div>
				</div>
			</div>
		</div>
		
		
		
		<script>
			$( document ).ready(function() {
				Parse.initialize("cWXjlwyKH3BwBbxFjhun4IJAlOhrU5PuoURXSmFT", "hYh3XGDxMPQFCSVa6KbCZnbWClx5YFqynfIDtFLv");
				
				$('#doneRatingButton').click(function(){
		
					var tutorUsername = lectureSession.get("tutorUsername");
		
					if(typeof $('input[name=attitude]:checked', '#attitude-form').val() === "undefined"
						|| typeof $('input[name=preparedness]:checked', '#preparedness-form').val() === "undefined"
						|| typeof $('input[name=thoroughness]:checked', '#thoroughness-form').val() === "undefined"
						|| typeof $('input[name=usefulness]:checked', '#usefulness-form').val() === "undefined")
					{
						alert('Please rate the session you just had');
					}
					else
					{
						var attitudeRating = parseFloat($('input[name=attitude]:checked', '#attitude-form').val());
						var preparednessRating = parseFloat($('input[name=preparedness]:checked', '#preparedness-form').val());
						var usefulnessRating = parseFloat($('input[name=usefulness]:checked', '#usefulness-form').val());
						var thoroughnessRating = parseFloat($('input[name=thoroughness]:checked', '#thoroughness-form').val());
						
						var meanRating = (attitudeRating + preparednessRating + usefulnessRating + thoroughnessRating)/4.0;
						
						Parse.Cloud.run('updateTutorRating', { tutorUsername: tutorUsername, rating: meanRating });
					}
					
					
				});
				
				$('#tutorEndSessionButton').click(function(){
	
					lectureSession.destroy({
					  success: function(lectureSession) {
					    // The object was deleted from the Parse Cloud.
						  window.location.href = "Dashboard.php";
					  },
					  error: function(lectureSession, error) {
					      console.log('tutorEndSession failed, with error code: ' + error.message);
					  }
					});
				
				});
				
			});
			
			
			
		</script>
		
	</body>
</HTML>