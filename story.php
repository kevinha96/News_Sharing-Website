<!DOCTYPE HTML>
<head>
	<title>Story</title>
</head>
<body>
	<?php

	session_start();
	require 'database.php';

	//navigation
	$_SESSION['from'] = "story";

	if(!empty($_SESSION['user'])) {
		$user = $_SESSION['user'];
	}

	$story_id = $_POST['story'];

	//got to story page from html form;
	//create session variable
	if(!empty($story_id)) {
		$_SESSION['story_id'] = $story_id;
	}
	else {
		$story_id = $_SESSION['story_id'];
	}

	//fetch story information
	$stmt = $mysqli->prepare("select title, commentary, link, username from stories where story_id=?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	//Bind parameter
	$stmt->bind_param('i', $story_id);
	$stmt->execute();

	//Bind results
	$stmt->bind_result($title, $commentary, $link, $story_user);
	$stmt->fetch();

	//print
	echo "Title: ".htmlspecialchars($title)."<br><br>";
	echo "Link: <a href='".htmlspecialchars($link)."' target='_blank'>".htmlspecialchars($link)."</a><br><br>";
	echo "Commentary:<br>".htmlspecialchars($commentary)."<br><br>";
	$stmt->close();

	//Edit and delete button if user is in session
	if ($story_user == $user) {
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

	if(!empty($_SESSION['user'])) {
	//favorite button
		print 
		'<form action="favorite.php" method="POST" style="display: inline;">
		<input type="hidden" name="story" value="'.$story_id.'"/> 
		<input type="submit" name="action" value="Favorite" />
		</form>';
	}

	echo "<br><br>";

	//Adding comments
	//comment form
	if (!empty($_SESSION['user'])){
		echo "Add comment: <br>";
		print 
		'<form action="addComment.php" id="addComment" method="POST">
		<textarea rows="4" cols="50" name="comment" form="addComment">Enter text here...</textarea><br>
		<input type="hidden" name="story" value="'.$story_id.'"/> 
		<input type="hidden" name="token" value="'.$_SESSION['token'].'" />
		<input type="submit"/>
		</form><br>';
	}

	//Comments
	$stmt = $mysqli->prepare("select username,body,comment_added,comment_id from comments where story_id=? order by comment_added DESC");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	//Bind parameter
	$stmt->bind_param('i', $story_id);
	$stmt->execute();	

	//Bind results
	$stmt->bind_result($username, $body, $comment_added, $comment_id);

	//print comments	
	echo "<ul>\n";
	while($stmt->fetch()){

		printf("\t<li>%s<br>User: %s<br><br>%s<br><br></li>\n", 
			htmlspecialchars($comment_added),
			htmlspecialchars($username),
			htmlspecialchars($body)
			);

		//Edit and delete button for user's comments
		if ($username == $user) {
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
		}

		echo "<br><br>";

	}
	echo "</ul>\n";

	$stmt->close();


	?>

	<!--go back to main page-->
	<form action="snws.php">
		<input type="submit" value="Go back main page" />
	</form>

	<?php if(!empty($_SESSION['user'])) { ?>
	<!--go back to your stories-->
	<form action="yourStories.php">
		<input type="submit" value="Go back to your stories" />
	</form>
	<?php } ?>

</body>