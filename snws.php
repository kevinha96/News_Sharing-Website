<!DOCTYPE HTML>
<head>
	<title>News</title>
</head>
<body>
	<?php

	session_start();
	require 'database.php';

	//navigation
	$_SESSION['from'] = "main";

	if(empty($_SESSION['user'])){
		echo "Hi guest user.";

		//logout
		print 
		'<form action="logout.php"  style="display: inline;">
		<input type="submit" value="Logout" />
		</form><br>';
	}

	else {
		$user = $_SESSION['user'];

		echo "Hi " . htmlspecialchars($user);

		//view profile
		print 
		'<form action="profile.php"  style="display: inline;">
		<input type="submit" name="action" value="View Profile" />
		</form>';

	//logout
		print 
		'<form action="logout.php"  style="display: inline;">
		<input type="submit" name="action" value="Logout" />
		</form><br><br>';

	//New story
		print 
		'<form action="newStoryForm.php"  style="display: inline;">
		<input type="submit" name="action" value="Create new story" />
		</form><br><br>';

	}

	//List All Stories
	$stmt = $mysqli->prepare("select story_id, title, story_added, username from stories order by story_added DESC");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$stmt->execute();	

	//Bind results
	$stmt->bind_result($story_id, $title, $story_added, $username);

	//print stories	
	echo "New Stories: <br>";
	echo "<ul>\n";
	while($stmt->fetch()){

		printf("\t<li>%s<br>Story Title: %s<br></li>\n", 
			htmlspecialchars($story_added),
			htmlspecialchars($title)
			);

		//view button
		print 
		'<form action="story.php" method="POST" style="display: inline;">
		<input type="hidden" name="story" value="'.$story_id.'"/> 
		<input type="submit" name="action" value="View" />
		</form>';

		//edit and delete buttons for stories created by user
		if ($username == $user){
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
		}

		echo "<br><br>";

	}
	echo "</ul>\n";

	$stmt->close();

	?>
</body>