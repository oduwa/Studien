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
		
		<title>Join Studien!</title>
	</head>
	
	<body>
	
		<!-- Reg. form Start -->
		<form id="CollectInfoForm">
			<div style="background-color:#fff">
				<div id="profilePicPreview"></div>
			</div>
			<div class="form-group">
				<label for="exampleInputFile">Profile Picture</label>
				<input type="file" accept="image/*" id="profilePicFile">
				<p class="help-block">Please select a picture for upload.</p>
				<div class="form-group">
					<label for="bioArea">About You</label>
					<textarea class="form-control" rows="15" id="bioArea" placeholder="Tell us about yourself . . . " maxlength="400"></textarea><br />
				</div>
				<div class="pull-left" id="tagGroup">
					<label for="tags">Hobbies </label> 
				</div>
				<button class="pull-right" data-toggle="modal" data-target="#myModal">Add Hobby</button><br />
			

				<button id="submitBtn" type="submit" class="btn btn-default">Submit</button>
			
			</form>
			<!-- Reg. form End -->
		
			<!-- Modal -->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-body">
							<div class="form-group" style="margin-top:15px;">
								<label for="tag" class="control-label">Add Hobby:</label>
								<input type="text" class="form-control" id="tagInput">
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							<button class="btn btn-primary" data-dismiss="modal" id="addTagButton">Add</button>
						</div>
					</div>
				</div>
			</div>
		
		
		
			<script type="text/javascript">
		
			Parse.initialize("cWXjlwyKH3BwBbxFjhun4IJAlOhrU5PuoURXSmFT", "hYh3XGDxMPQFCSVa6KbCZnbWClx5YFqynfIDtFLv");
			var tags = [];
			var profilePicFile;
			var filename;
			
			document.getElementById('profilePicFile').addEventListener('change', function(){
			
				var file = this.files[0];
			
				// This code is only for demo ...
			
				console.log("name : " + file.name);
				
				var img = document.createElement("img");
				var fr = new FileReader();
				fr.onload = function () {
					img.src = fr.result;
					img.width = 200;
				}
				fr.readAsDataURL(file);
				document.getElementById("profilePicPreview").appendChild(img);
				profilePicFile = file;
				filename = file.name
					
				
				//var img = document.getElementById('profilePicPreview');
				//img.file = file;
				
			
			}, false);
			
			
			
			function removeTagWithId(id){
				//remove tag from array
				for(var i = 0; i < tags.length; i++){
					if(tags[i] === id){
						tags[i] = "";
					}
				}
				$("#"+id).html("");
			}
						
			function showTags(){
				var str = "";
				for(var i = 0; i < tags.length; i++){
					str = str + tags[i] + " ";
				}
				alert(str);
			}			
						
			$('#addTagButton').click(function(){
				// check for input
				if($("#tagInput").val().trim() === ""){
					return false;
				}
					
				// get tag entered
				var newTag = $("#tagInput").val();
					
				// check that it hasnt already been added before adding it
				if($.inArray(newTag, tags) == -1){
					tags[tags.length] = newTag;
					$("#tagGroup").append("<span id=\"" + newTag + "\"  class=\"label label-primary\"><button onclick=\"removeTagWithId('"+newTag+"')\"><span style=\"color:#f00;\" aria-hidden=\"true\">&times;</span></button>" + newTag + "</span>\n");
				}
					
				// clear text field
				$("#tagInput").val("");
			});
		
			$('#CollectInfoForm').on('submit', function(e) {
				e.preventDefault();	
			});
			
			$('#submitBtn').on('click', function(e) {
				var currentUser = Parse.User.current();
				
				var parseFile = new Parse.File(filename, profilePicFile);
				
				currentUser.set("bio", $('#bioArea').val());
				currentUser.set("hobbies", tags);
				currentUser.set("avatar", parseFile);
				
				currentUser.save(null, {
				  success: function() {
						window.location.href = 'LoginController.php?email=' + currentUser.get("email") + '&' +
												'username=' + currentUser.get("username") + '&' +
												'fname=' + currentUser.get("firstName") + '&' +
												'lname=' + currentUser.get("lastName") + '&' +
												'role=' + currentUser.get("userRole") + '&' +
												'bio=' + currentUser.get("bio");
				  },
				  error: function( error) {
				    // Execute any logic that should take place if the save fails.
				    // error is a Parse.Error with an error code and message.
				    alert('Failed to save details, with error code: ' + error.message);
				  }
				});

			});
			
			</script>
		
		</body>
	</HTML>