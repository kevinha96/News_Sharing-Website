<?php

session_start();
require 'database.php';

$user = $_SESSION['user'];

//filter input
$comment = (string)$_POST['comment'];
$story_id = (int)$_POST['story'];
$comment_body = (string)$_POST['comment'];

//check CSRF token validity
if($_SESSION['token'] !== $_POST['token']){
	die("Request forgery detected");
}

$stmt = $mysqli->prepare("insert into comments (username, story_id, body) values (?,?,?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('sis', $user, $story_id, $comment_body);
$stmt->execute();
$stmt->close();

//go back to story page
header("Location: story.php");
exit;

?>