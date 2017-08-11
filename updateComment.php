<!DOCTYPE HTML>
<head>
	<title>Edit story</title>
</head>
<body>
	<?php 

	session_start();
	require 'database.php';

	$user = $_SESSION['user'];

	$body = (string)$_POST['comment'];
	$story_id = $_POST['story_id'];
	$comment_id = $_POST['comment_id'];

	//check CSRF token validity
	if($_SESSION['token'] !== $_POST['token']){
		die("Request forgery detected");
	}

	$update = $mysqli->prepare("update comments set body=? where comment_id=? and username=?");
	if(!$update){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	//Bind param
	$update->bind_param('sis', $body, $comment_id, $user);
	$update->execute();
	
	$update->close();

	//navigate back
	require 'from.php';

	?>

</bodu>