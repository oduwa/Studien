<!-- IMPORTANT: JQUERY MUST HAVE BEEN INCLUDED IN THE BODY OF THE PAGE THIS NAV BAR IS TO APPEAR IN -->

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
                <li id="dashboardListItem"><a href="Dashboard.php">Dashboard<span class="sr-only">(current)</span></a></li>
                <li id="subjectsListItem"><a href="TuteeSubjects.php">My Subjects</a></li>
				<li id="classroomListItem"><a href="Classroom.php">Classroom</a></li>
				<li id="revisionListItem"><a href="#">Revision Materials</a></li>
				<li id="searchListItem"><a href="#">Search</a></li>
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
								document.write(currentUser.get("firstName") + " " + currentUser.get("lastName"));
							} else {
								document.write("User Name");
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
                            <a href="Logout.html">Log out</a>
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
		else if($_SESSION['page'] == 'revision'){
			$id = "revisionListItem";
		}
		else if($_SESSION['page'] == 'search'){
			$id = "searchListItem";
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