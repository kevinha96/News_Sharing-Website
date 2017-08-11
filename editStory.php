<!DOCTYPE HTML>
<head>
	<title>Edit story</title>
</head>
<body>
	<?php

	session_start();
	require 'database.php';

	$user = $_SESSION['user'];

	$story_id = $_POST['story'];

	//create story session variable
	$_SESSION['story_id'] = $story_id;


	//fetch story
	$stmt = $mysqli->prepare("select title, commentary, link from stories where story_id=?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	//Bind parameter
	$stmt->bind_param('i', $story_id);
	$stmt->execute();

	//Bind results
	$stmt->bind_result($title, $commentary, $link);
	$stmt->fetch();

	?>

	<!--Edit story-->
	<form action="updateStory.php" id="updateStory" method="POST">
		Edit Title: <input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>" required/><br>
		Edit Link: <input type="text" name="link" value="<?php echo htmlspecialchars($link); ?>" /><br>
		Edit Commentary:<br>
		<textarea rows="4" cols="50" name="commentary" form="updateStory"><?php echo htmlspecialchars($commentary); ?></textarea><br>
		<input type="hidden" name="story_id" value="<?php echo $story_id; ?>"/> 
		<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
		<input type="submit" value="Update Story" style="display: inline"/><br>
	</form>

	<!--Go back to your stories-->
	<form action="yourStories.php">
		<input type="submit" value="Go back to your stories" />
	</form>

</body>