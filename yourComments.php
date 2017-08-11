<!DOCTYPE HTML>
<head>
	<title>Your Comments</title>
</head>
<body>
	<?php

	session_start();
	require 'database.php';

	//navigation
	$_SESSION['from'] = "your_com";

	$user = $_SESSION['user'];

	echo "Here are your comments: ";

	//fetch your comments
	$stmt = $mysqli->prepare("select comments.story_id, comment_id, body, comment_added, stories.title 
		from comments 
		join stories on (stories.story_id=comments.story_id)
		where comments.username=? 
		order by comment_added DESC");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	//Bind parameter
	$stmt->bind_param('s', $user);
	$stmt->execute();

	//Bind results
	$stmt->bind_result($story_id, $comment_id, $body, $comment_added, $story_title);

	//print comments
	echo "<ul>\n";
	while($stmt->fetch()){

		printf("\t<li>Story Title: %s<br>%s<br><br>%s<br><br></li>\n", 
			htmlspecialchars($story_title),
			htmlspecialchars($comment_added),
			htmlspecialchars($body)
			);

		//open story, edit and delete buttons
		print 
		'<form action="story.php" method="POST" style="display: inline;">
		<input type="hidden" name="story" value="'.$story_id.'"/> 
		<input type="submit" name="action" value="View Story" />
		</form>';

		print 
		'<form action="editComment.php" method="POST" style="display: inline;">
		<input type="hidden" name="comment" value="'.$comment_id.'"/> 
		<input type="submit" name="action" value="Edit" />
		</form>';

		print 
		'<form action="deleteComment.php" method="POST" style="display: inline;">
		<input type="hidden" name="comment" value="'.$comment_id.'"/> 
		<input type="submit" name="action" value="Delete" />
		</form>';

		echo "<br><br>";
	}
	echo "</ul>\n";

	$stmt->close();


	?>

	<!--go back to profile-->
<form action="profile.php">
	<input type="submit" value="Go back" />
</form>

</body>