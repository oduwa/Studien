<?php

if(session_status() != PHP_SESSION_ACTIVE){
	session_start();
}

$lectureId = $_GET['lectureId'];


	
?>
<!DOCTYPE HTML>
<HTML>
	<head>
		<?php include 'includes.php';?>
		
		<!-- OpenTok -->
	    <link href="css/app.css" rel="stylesheet" type="text/css">
	    <script src="https://static.opentok.com/v2/js/opentok.js"></script>
		
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
		
		<title>Studien</title>
		
		<style>
			.center-div {
				position: absolute;
				margin: auto;
				top: 0;
				right: 0;
				bottom: 0;
				left: 0;
				width: 30%;
				height: 30%;
				//background-color: #ccc;
				border-radius: 3px;
			}
			
			#drawingCanvas {
				background-color: #004;
			}
			
		</style>
	</head>
	
	<body>

		<?php 
		
		if(session_status() != PHP_SESSION_ACTIVE){
			session_start();
		}
		
		if($_SESSION['current_userRole'] > 0){
			echo '<button type="button" class="btn btn-info" id="tutorEndSessionButton">End Session2</button>';
		}
		else{
			echo '<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">End Session</button>';
		}
		
		?>
		
	    <div id="videos">
	        <div id="subscriber"></div>
	        <div id="publisher"></div>
	    </div>

		<canvas id="drawingCanvas" width="640" height="640"></canvas>
		
		<button id="toggleCanvasStatusButton">Turn On</button><br />
		<button id="clearCanvasButton">Clear</button><br />
		
		Theme:
		<label class="checkbox-inline"><input id="themeCheckbox_light" type="checkbox" value="light">Drizzy</label>
		<label class="checkbox-inline"><input id="themeCheckbox_dark" type="checkbox" value="dark">Wesley Snipes</label>
		
		<select id="colourSelect" class="form-control">
			<option value="#df4b26">Orange</option>
			<option value="#cb3594">Purple</option>
			<option value="#659b41">Green</option>
			<option value="#986928">Brown</option>
		</select>
		<select id="toolSelect" class="form-control">
			<option value="marker">Marker</option>
			<option value="eraser">Eraser</option>
		</select>
		
		
		
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


		
		
		
	
	    <script type="text/javascript" src="js/config.js"></script>
	    <script type="text/javascript" src="js/app.js"></script>
		<script type="text/javascript">
			
			$( document ).ready(function() {
				
				Parse.initialize("cWXjlwyKH3BwBbxFjhun4IJAlOhrU5PuoURXSmFT", "hYh3XGDxMPQFCSVa6KbCZnbWClx5YFqynfIDtFLv");
				var currentUser = Parse.User.current();
				context = document.getElementById('drawingCanvas').getContext("2d");
				
				var lectureId = <?php echo '"' . $lectureId . '";';?>;
				var lectureSession = null;
				var readyToPersistCanvas = false;
				var isCanvasOn = false;
				
				// Drawing
				var clickX = new Array();
				var clickY = new Array();
				var clickDrag = new Array();
				var paint;
				
				// Colour
				var currentColor = "#df4b26";
				var clickColor = new Array();
				
				// Sizes
				var clickSizes = new Array();
				var defaultMarkerStrokeWidth = 5;
				var defaultEraserStrokeWidth = 10;
				
				// Tools
				var clickTool = new Array();
				var currentTool = "marker"; // Other tool is "eraser"
				
				// Get lecture session object
				var LectureSession = Parse.Object.extend("LectureSession");
				var query = new Parse.Query(LectureSession);
				query.equalTo("objectId", lectureId);
				query.find({
				  success: function(results) {
					  lectureSession = results[0];
					  readyToPersistCanvas = true;
				  },
				  error: function(error) {
				    alert("An error occured establishing your Studien connection.\nError: " + error.code + " " + error.message);
				  }
				});

				// function signature - addClick(number x, number y, bool dragging)
				function addClick(x, y, dragging)
				{
					if(isCanvasOn)
					{
						clickX.push(x);
						clickY.push(y);
						clickDrag.push(dragging);
					
						if(currentTool == "eraser"){
							var canvasBackgroundColour = $('#drawingCanvas').css('backgroundColor');
							clickColor.push(rgbToHex(canvasBackgroundColour));
							clickSizes.push(defaultEraserStrokeWidth);
						}
						else{
							clickColor.push(currentColor);
							clickSizes.push(defaultMarkerStrokeWidth);
						}
					}
				}
				
				function redraw(){
					context.clearRect(0, 0, context.canvas.width, context.canvas.height); // Clears the canvas
  
					context.lineJoin = "round";
			
					for(var i=0; i < clickX.length; i++) {		
						context.beginPath();
						if(clickDrag[i] && i){
							context.moveTo(clickX[i-1], clickY[i-1]);
						}
						else{
							context.moveTo(clickX[i]-1, clickY[i]);
						}
						context.lineTo(clickX[i], clickY[i]);
						context.closePath();
						context.strokeStyle = clickColor[i];
						context.lineWidth = clickSizes[i];
						context.stroke();
					}
					
					saveCanvasData();
				}
				
				function saveCanvasData(){
					if(readyToPersistCanvas){
						readyToPersistCanvas = false;
						
						lectureSession.set("clickX", clickX);
						lectureSession.set("clickY", clickY);
						lectureSession.set("clickDrag", clickDrag);
						lectureSession.set("clickColor", clickColor);
						lectureSession.set("clickSizes", clickSizes);
						lectureSession.set("clickTool", clickTool);
						
						lectureSession.save(null, {
						  success: function(lectureSession) {
							  readyToPersistCanvas = true;
						  },
						  error: function(lectureSession, error) {
							  readyToPersistCanvas = true;
						      console.log('saveCanvasData() failed, with error code: ' + error.message);
						  }
						});
					}
				}
				
				function fetchCanvasData(){
					if(readyToPersistCanvas && !paint && !isCanvasOn){
						readyToPersistCanvas = false; 
					
						var query = new Parse.Query(LectureSession);
						query.equalTo("objectId", lectureId);
						query.find({
						  success: function(results) {
							  lectureSession = results[0];
						  
							  clickX = lectureSession.get("clickX");
							  clickY = lectureSession.get("clickY");
							  clickDrag = lectureSession.get("clickDrag");
							  clickColor = lectureSession.get("clickColor");
							  clickSizes = lectureSession.get("clickSizes");
							  clickTool = lectureSession.get("clickTool");
							  redraw();
						  
							  readyToPersistCanvas = true;
						  },
						  error: function(error) {
						    console.log('fetchCanvasData() failed, with error code: ' + error.message);
						  }
						});
					}
				}
				

				$('#clearCanvasButton').on('click', function(e) {
					clickX = new Array();
					clickY = new Array();
					clickDrag = new Array();
					clickColor = new Array();
					clickSizes = new Array();
					paint = false;
				
					redraw();
				});
				
				$('#colourSelect').on('change', function(e) {
					currentColor = $(this).val();
				});
				
				$('#toolSelect').on('change', function(e) {
					currentTool = $(this).val();
				});
				
				$('#themeCheckbox_light').on('change', function() { 
    // From the other examples
					if (this.checked) {
						$('#drawingCanvas').css('backgroundColor', "#fff");
					}
					else{
						$('#drawingCanvas').css('backgroundColor', "#004");
					}
				});
				
				$('#drawingCanvas').mousedown(function(e){
					var mouseX = e.pageX - this.offsetLeft;
					var mouseY = e.pageY - this.offsetTop;
		
					// Lets us know if the virtual marker is pressing down on the paper or not.
					// If true while mouse moves we know to keep on drawing.
					paint = true;
					addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop);
					redraw();
				});
				
				$('#drawingCanvas').mousemove(function(e){
					if(paint){
						addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop, true);
						redraw();
					}
				});
				
				$('#drawingCanvas').mouseup(function(e){
					paint = false;
				});
				
				$('#drawingCanvas').mouseleave(function(e){
					paint = false;
				});
				
				$('#toggleCanvasStatusButton').click(function(){
					isCanvasOn = !isCanvasOn;
					if(isCanvasOn){
						$('#toggleCanvasStatusButton').html('Turn Off');
						$('#drawingCanvas').css('backgroundColor', "#004");
					}
					else{
						$('#toggleCanvasStatusButton').html('Turn On');
						$('#drawingCanvas').css('backgroundColor', "#044");
					}
				});
				
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
						
						Parse.Cloud.run('updateTutorRating', { tutorUsername: tutorUsername, rating: meanRating }).then(function(){
							window.location.href = "Dashboard.php";
						});
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
				
				var canvasFetchIntervalID = setInterval(fetchCanvasData, 10000); // every 3 seconds
				
				///////////////////////////////////////////////////////
				/////////////////////// HELPER ////////////////////////
				///////////////////////////////////////////////////////
				function rgbToHex(colorval) {
					var color = '';
					
					var parts = colorval.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
					delete(parts[0]);
					for (var i = 1; i <= 3; ++i) {
					parts[i] = parseInt(parts[i]).toString(16);
					if (parts[i].length == 1) parts[i] = '0' + parts[i];
					}
					color = '#' + parts.join('');
					
					return color;
				}
				
			});
			
		</script>
		
	</body>
</HTML>