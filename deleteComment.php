<?php

session_start();
require 'database.php';

$user = $_SESSION['user'];

$comment_id = $_POST['comment'];

	//disable and enable foreign key checking
$disable = $mysqli->prepare("set foreign_key_checks=0");
$enable = $mysqli->prepare("set foreign_key_checks=1");

	//deleting from comments
$disable->execute();

$update = $mysqli->prepare("delete from comments where comment_id=?");
if(!$update){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$update->bind_param('i', $comment_id);
$update->execute();

$update->close();

$enable->execute();

//navigate back
require 'from.php';

?>