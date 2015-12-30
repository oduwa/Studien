<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav-collapse" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Studien</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="nav-collapse">
            <ul class="nav navbar-nav">
                <li id="dashboardListItem"><a href="#">Dashboard<span class="sr-only">(current)</span></a></li>
                <li id="subjectListItem"><a href="#">Subjects</a></li>
				<li id="classroomListItem"><a href="TutorClassroomSelect.php">Enter Classroom</a></li>
				<li id="teachingListItem"><a href="#">Teaching Materials</a></li>
				<li id="timesheetListItem"><a href="#">Timesheet</a></li>
            </ul>
            <ul class="nav navbar-nav pull-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <!-- The Profile picture inserted via div class below, with shaping provided by Bootstrap -->
                        <div class="img-rounded profile-img"></div>
						<script>
							Parse.initialize("cWXjlwyKH3BwBbxFjhun4IJAlOhrU5PuoURXSmFT", "hYh3XGDxMPQFCSVa6KbCZnbWClx5YFqynfIDtFLv");
		
							var currentUser = Parse.User.current();
							if (currentUser) {
								/* Set display name */
								document.write(currentUser.get("firstName") + " " + currentUser.get("lastName"));
								
								/* Set avatar */
								var avatarURL = currentUser.get("avatar").url();
								$('.profile-img').css('background', 'url(' + avatarURL + ')');
							} else {
								document.write("User Name");
								$('.profile-img').css('background', 'url(mac.jpg) 50% 50% no-repeat');
							}
						</script>
                         <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#">Settings</a>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li>
                            <a href="#">Log out</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
	<?php
		
		if(session_status() != PHP_SESSION_ACTIVE){
			session_start();
		}

		$id = '';
		
		if($_SESSION['page'] == 'dashboard'){
			$id = "dashboardListItem";
		}
		else if($_SESSION['page'] == 'subjects'){
			$id = "subjectsListItem";
		}
		else if($_SESSION['page'] == 'teaching'){
			$id = "teachingListItem";
		}
		else if($_SESSION['page'] == 'timesheet'){
			$id = "timesheetListItem";
		}
		else if($_SESSION['page'] == 'classroom'){
			$id = "classroomListItem";
		}
		else{
			$id = "xxx";
		}
		
	?>

	var id = '#<?php echo $id; ?>';
	$(id).addClass('active');
</script>