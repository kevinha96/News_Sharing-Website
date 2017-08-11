<!DOCTYPE HTML>
<head>
	<title> Create a new story </title>
</head>
<body>
	
	<form action="newStory.php" id="submitform" method="POST">
		Title: <input type="text" name="title" required/><br> 		
		Link (Full URL): <input type="text" name="link" /> <br>
		<textarea rows="4" cols="50" name="commentary" form="submitform">Enter commentary here...</textarea><br>
		<input type="hidden" name="token" value="<?php session_start(); echo $_SESSION['token'];?>" />
		<input type="submit" value="Submit story" style="display: inline"/><br>
	</form>

	<form action="snws.php">
		<input type="submit" value="Go back" />
	</form>

</body>


