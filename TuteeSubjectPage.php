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

// Get the title of subject to display info for
$subjectTitle = $_GET['subject'];
$subject = NULL;
for($i = 0; $i < count($all_subjects); $i++){
	if($all_subjects[$i]->get("title") == $subjectTitle){
		$subject = $all_subjects[$i];
		break;
	}
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
		$_SESSION['page'] = 'subjects';
		include 'TuteeNavBar.php';
		
		?>
		<h1><?php echo $subject->get("title");?></h1>
		
		<p>
			<?php echo $subject->get("description");?>
		</p>
		
		
		
		
	</body>
</HTML>