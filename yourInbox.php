<!DOCTYPE HTML>
<head>
	<title>Your inbox</title>
</head>
<body>
	<?php

	session_start();
	require 'database.php';

	$user = $_SESSION['user'];

	echo "Here are your messages: ";

	//fetch your stories
	$stmt = $mysqli->prepare("select mess_from, message, mess_sent from messages where mess_to=? order by mess_sent DESC");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	//Bind parameter
	$stmt->bind_param('s', $user);
	$stmt->execute();

	//Bind results
	$stmt->bind_result($mess_from, $message, $mess_sent);
	
	//print titles
	echo "<ul>\n";
	while($stmt->fetch()){

		printf("\t<li>%s<br>From: %s<br><br>%s<br><br></li>\n", $mess_sent, $mess_from, htmlspecialchars($message));
		
	}
	echo "</ul>\n";

	$stmt->close();

?>

<!--go back to profile-->
<form action="profile.php">
	<input type="submit" value="Go back" />
</form>

</body>