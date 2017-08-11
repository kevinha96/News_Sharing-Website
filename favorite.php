<?php

session_start();
require 'database.php';

$user = $_SESSION['user'];

$story_id = $_POST['story'];

//add into favorites
$stmt = $mysqli->prepare("insert into favorites (username, story_id) values (?,?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('si', $user, $story_id);
$stmt->execute();
$stmt->close();

//go back to story page
header("Location: story.php");
exit;

?>