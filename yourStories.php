<!DOCTYPE HTML>
<head>
	<title>Your stories</title>
</head>
<body>
	<?php

	session_start();
	require 'database.php';

	//navigation
	$_SESSION['from'] = "your_stor";

	$user = $_SESSION['user'];

	echo "Here are your stories: ";

	//fetch your stories
	$stmt = $mysqli->prepare("select story_id, title from stories where username=?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	//Bind parameter
	$stmt->bind_param('s', $user);
	$stmt->execute();

	//Bind results
	$stmt->bind_result($story_id, $title);
	
	//print titles
	echo "<ul>\n";
	while($stmt->fetch()){

		printf("\t<li>%s</li>\n", htmlspecialchars($title));

		//View, edit and delete buttons
		print 
		'<form action="story.php" method="POST" style="display: inline;">
		<input type="hidden" name="story" value="'.$story_id.'"/> 
		<input type="submit" name="action" value="View" />
		</form>';

		print 
		'<form action="editStory.php" method="POST" style="display: inline;">
		<input type="hidden" name="story" value="'.$story_id.'"/> 
		<input type="submit" name="action" value="Edit" />
		</form>';

		print 
		'<form action="deleteStory.php" method="POST" style="display: inline;">
		<input type="hidden" name="story" value="'.$story_id.'"/> 
		<input type="submit" name="action" value="Delete" />
		</form>';

		echo "<br>";
	}
	echo "</ul>\n";

	$stmt->close();

?>

<!--go back to profile-->
<form action="profile.php">
	<input type="submit" value="Go back" />
</form>

</body>