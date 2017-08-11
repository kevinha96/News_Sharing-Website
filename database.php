<?php

//connect to database
$mysqli = new mysqli('localhost', 'mod3_inst', 'mod3_pass', 'mod3_news_website');

if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}

?>