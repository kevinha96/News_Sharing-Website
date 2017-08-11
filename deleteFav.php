<?php

session_start();
require 'database.php';

$user = $_SESSION['user'];
$action = $_POST['action'];

//disable and enable foreign key checking
$disable = $mysqli->prepare("set foreign_key_checks=0");
$enable = $mysqli->prepare("set foreign_key_checks=1");

$disable->execute();

//Remove all favorites
if ($action == "Remove all favorites") {

	$delete = $mysqli->prepare("delete from favorites where username=?");
	if(!$delete){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$delete->bind_param('s', $user);
	$delete->execute();
}

//remove a favorite story
else {
	$favorites_id = $_POST['favorites_id'];

	$delete = $mysqli->prepare("delete from favorites where favorites_id=?");
	if(!$delete){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$delete->bind_param('i', $favorites_id);
	$delete->execute();

}

$enable->execute();

//navigate back
header("Location: profile.php");
exit;

?>