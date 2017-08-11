<!DOCTYPE HTML>
<head>
	<title> Simple News Web Site </title>
</head>
<body>

	<?php

		session_start();
		
		//create CSRF token
		$_SESSION['token'] = substr(md5(rand()), 0, 10);


	?>

	<form name="input" action="checkUser.php" method="POST">
		Username: <input type="text" name="user" required/> <br>
		Password: <input type="text" name="pass" required/> <br>
		<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
		<input type="submit" value="Login" /><br>
	</form>

	<!--Register new user-->
	<form action="registerUserForm.php">
		<input type="submit" value="Click here to register"/><br>
	</form>

	<!--Log in as guest-->
	<form action="snws.php">
		<input type="submit" value="Login as guest"/>
	</form>

</body>


