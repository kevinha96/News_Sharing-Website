<?php

session_start();
require 'database.php';

$user = $_SESSION['user'];

$title = (string)$_POST['title'];
$commentary = (string)$_POST['commentary'];
$link = (string)$_POST['link'];

$story_id = $_SESSION['story_id'];

//check CSRF token validity
if($_SESSION['token'] !== $_POST['token']){
	die("Request forgery detected");
}

//check if url is valid
if (filter_var($link, FILTER_VALIDATE_URL) === FALSE) {
	echo "Enter full url";
	header("refresh:1; url=editStory.php");
	exit;
}

$update = $mysqli->prepare("update stories set title=?, link=?, commentary=? where story_id=? and username=?");
if(!$update){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

//Bind parameters
$update->bind_param('sssis', $title, $link, $commentary, $story_id, $user);
$update->execute();

$update->close();

//navigate back
require 'from.php';

?>