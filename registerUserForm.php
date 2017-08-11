<!DOCTYPE HTML>
<head>
	<title> Register User </title>
</head>
<body>

	<?php

		session_start();
		
		//create CSRF token
		$_SESSION['token'] = substr(md5(rand()), 0, 10);

	?>

	<form name="input" action="registerUser.php" method="POST">
		Create new username: <input type="text" name="user" required/> <br>
		Create a password: <input type="text" name="pass" required/> <br>
		<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
		<input type="submit" value="Register" />
	</form>

	<form action="login.html">
		<input type="submit" value="Go back" />
	</form>
</body>
