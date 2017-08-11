<!DOCTYPE HTML>
<head>
	<title>Edit Comment</title>
</head>
<body>
	<?php

	session_start();
	require 'database.php';

	$user = $_SESSION['user'];

	$comment_id = $_POST['comment'];

	//fetch comment
	$stmt = $mysqli->prepare("select story_id, body from comments where comment_id=?");
	if(!stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	//Bind parameter
	$stmt->bind_param('i', $comment_id);
	$stmt->execute();

	//Bind results
	$stmt->bind_result($story_id, $body);
	$stmt->fetch();

	$stmt->close();

	?>

	<!--Edit Comment-->
	<form action="updateComment.php" id="updateComment" method="POST">
		Edit comment: <br>
		<textarea rows="4" cols="50" name="comment" form="updateComment"><?php echo htmlspecialchars($body); ?></textarea><br>
		<input type="hidden" name="story_id" value="<?php echo $story_id; ?>"/> 
		<input type="hidden" name="comment_id" value="<?php echo $comment_id; ?>"/> 
		<input type="hidden" name="from" value="<?php echo $from; ?>"/> 
		<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
		<input type="submit" value="Update Comment" style="display: inline"/><br>
	</form>

</body>