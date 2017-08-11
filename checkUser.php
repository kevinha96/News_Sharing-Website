<?php 
session_start();

require 'database.php';

//go straight to main page for guest
if(empty($_POST['user'])) {
	header("Location: snws.php");
	exit;
}

//filter input
$user = (string)$_POST['user'];
$pass = (string)$_POST['pass'];

//check CSRF token validity
if($_SESSION['token'] !== $_POST['token']){
	die("Request forgery detected");
}

$stmt = $mysqli->prepare("select username, salt_hash from user_info where username=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

//Bind parameter
$stmt->bind_param('s', $user);
$stmt->execute();

//Bind results
$stmt->bind_result($user_, $pass_hash);
$stmt->fetch();

//compare passwords to see if user exists in database
if (crypt($pass, $pass_hash) == $pass_hash) {
	$_SESSION['user'] = $user;
	header("Location: snws.php");
	exit;
}
else {
	echo "Invalid Login";
	header("refresh:1; url=login.html");
	exit;
}
?>