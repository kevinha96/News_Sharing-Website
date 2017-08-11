<!DOCTYPE HTML>
<head>
	<title>Compose Message</title>
</head>
<body>
	<?php

	session_start();
	require 'database.php';

	$user = $_SESSION['user'];

	//list other users
	$stmt = $mysqli->prepare("select username from user_info where username!=?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	//Bind parameter
	$stmt->bind_param('s', $user);
	$stmt->execute();

	//Bind results
	$stmt->bind_result($sendTo);

	//List other users
	echo "Other Users: <br>";
	while($stmt->fetch()){
		echo htmlspecialchars($sendTo).", ";
	}

	echo "<br><br>";

	?>

	<form action="sendMessage.php" id="send" method="POST">
		Send to: <input type="text" name="sendTo" required/><br> 
		<textarea rows="4" cols="50" name="message" form="send">Enter message here...</textarea><br>
		<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
		<input type="submit" value="Send Message"/>
	</form>

	<!--back to profile-->
	<form action="profile.php"  style="display: inline;">
		<input type="submit" name="action" value="Go Back" />
	</form>


</body>