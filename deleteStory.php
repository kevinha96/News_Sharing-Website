<?php

session_start();
require 'database.php';

$user = $_SESSION['user'];

$story_id = $_POST['story'];

//disable and enable foreign key checking
$disable = $mysqli->prepare("set foreign_key_checks=0");
$enable = $mysqli->prepare("set foreign_key_checks=1");

//deleting from stories and comments
$disable->execute();

$update = $mysqli->prepare("delete from stories where story_id=?");
if(!$update){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$update->bind_param('i', $story_id);
$update->execute();

$update = $mysqli->prepare("delete from comments where story_id=?");
if(!$update){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$update->bind_param('i', $story_id);
$update->execute();

$update->close();

$enable->execute();

//navigate back
if ($_SESSION['from'] == "story") {
	header("Location: yourStories.php");
	exit;
}
else {
	require 'from.php';
}

?>