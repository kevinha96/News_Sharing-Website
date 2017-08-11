<?php 

session_start();

require 'database.php';

$user = $_SESSION['user'];

//filter input
$title =(string)$_POST['title'];
$commentary = (string)$_POST['commentary'];
$link = (string)$_POST['link'];

//check CSRF token validity
if($_SESSION['token'] !== $_POST['token']){
	die("Request forgery detected");
}

//check if link is valid url
if (filter_var($link, FILTER_VALIDATE_URL) === FALSE) {
	echo "Enter full url";
	header("refresh:1; url=snws.php");
	exit;
}

$stmt = $mysqli->prepare("insert into stories (username, title, commentary, link) values (?,?,?,?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('ssss', $user, $title, $commentary, $link);
$stmt->execute();
$stmt->close();

//go back to main page
header("Location: snws.php");
exit;

?>

