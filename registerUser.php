<?php 
session_start();

require 'database.php';

//filter input
$user = (string)$_POST['user'];
$pass = (string)$_POST['pass'];

//check CSRF token validity
if($_SESSION['token'] !== $_POST['token']){
	die("Request forgery detected");
}

$stmt = $mysqli->prepare("select username from user_info where username=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

//Bind parameter
$stmt->bind_param('s', $user);
$stmt->execute();

//Bind results
$stmt->bind_result($user_);
$stmt->fetch();

//check if the user is in the database
if ($user_ == $user) {
	echo "Username already in use";
	header("refresh:1; url=registerUser.html");
	exit;
}

//if user is not in database
$stmt->close();
$_SESSION['user'] = $user;

//encrypt password
$pass = crypt($pass);

//insert new user into database
$stmt = $mysqli->prepare("insert into user_info (username, salt_hash) values (?,?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('ss', $user, $pass);
$stmt->execute();
$stmt->close();

//go to main page
header("Location: snws.php");
exit;

?>