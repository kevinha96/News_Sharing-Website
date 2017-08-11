<?php
//used to refresh page after an edit or delete (but not delete story)
$from = $_SESSION['from'];

switch($from) {
	case "your_com":
	header("Location: yourComments.php");
	exit;

	case "story":
	header("Location: story.php");
	exit;

	case "main":
	header("Location: snws.php");
	exit;

	case "your_stor":
	header("Location: yourStories.php");
	exit;
}

?>