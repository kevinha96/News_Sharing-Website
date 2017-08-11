<?php

session_start();
require 'database.php';

$user = $_SESSION['user'];

$sendTo = (string)$_POST['sendTo'];
$message = (string)$_POST['message'];

//check CSRF token validity
if($_SESSION['token'] !== $_POST['token']){
	die("Request forgery detected");
}

//check for the user in database
$stmt = $mysqli->prepare("select username from user_info where username=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

	//Bind parameter
$stmt->bind_param('s', $sendTo);
$stmt->execute();

	//Bind results
$stmt->bind_result($Dest);
$stmt->fetch();

//user does not exist
if ($Dest != $sendTo) {
	echo "User does not exist!";
	header("refresh:1; url=profile.php");
	exit;
}

$stmt->close();

$stmt = $mysqli->prepare("insert into messages (mess_from, mess_to, message) values (?,?,?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

//Bind parameter
$stmt->bind_param('sss', $user, $sendTo, $message);

$stmt->execute();
$stmt->close();

//message has been sent
if ($Dest == $sendTo) {
	echo "Message has been sent!";
	header("refresh:1; url=profile.php");
	exit;
}

?>