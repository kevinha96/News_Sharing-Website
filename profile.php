<?php

session_start();
require 'database.php';

$user = $_SESSION['user'];

echo "Your Profile: <br>";

//back to main
print 
'<form action="snws.php"  style="display: inline;">
<input type="submit" name="action" value="Go Back" />
</form><br><br>';

//Send messages to other users
print 
'<form action="composeMessage.php"  style="display: inline;">
<input type="submit" name="action" value="Send a message" />
</form><br><br>';

//display own stories
echo "View your stories:";
print 
'<form action="yourStories.php"  style="display: inline;">
<input type="submit" name="action" value="Your Stories" />
</form><br>';

//display own comments
echo "View your comments:";
print 
'<form action="yourComments.php"  style="display: inline;">
<input type="submit" name="action" value="Your Comments" />
</form><br>';

//display inbox
echo "View inbox:";
print 
'<form action="yourInbox.php"  style="display: inline;">
<input type="submit" name="action" value="Your Inbox" />
</form><br><br>';

//List all favorites by when favorited
$stmt = $mysqli->prepare("select fav_added, favorites_id, stories.title 
	from favorites
	join stories on (stories.story_id=favorites.story_id)
	where favorites.username=?
	order by fav_added DESC");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

//Bind parameter
$stmt->bind_param('s', $user);
$stmt->execute();

//Bind results
$stmt->bind_result($fav_added, $favorites_id, $title);

//print favorites
echo "<br>Your Favorite Stories: ";

//Remove all favorites button
print 
'<form action="deleteFav.php" method="POST" style="display: inline;">
<input type="submit" name="action" value="Remove all favorites" />
</form><br>';

echo "<ul>\n";
while($stmt->fetch()) {

	printf("\t<li>%s<br>Story Title: %s<br></li>\n", 
		htmlspecialchars($fav_added),
		htmlspecialchars($title)
		);

	//view button
	print 
	'<form action="story.php" method="POST" style="display: inline;">
	<input type="hidden" name="story" value="'.$story_id.'"/> 
	<input type="submit" name="action" value="View" />
	</form>';

	//remove favorites button
	print 
	'<form action="deleteFav.php" method="POST" style="display: inline;">
	<input type="hidden" name="favorites_id" value="'.$favorites_id.'"/> 
	<input type="submit" name="action" value="Remove from favorites" />
	</form><br><br>';

}
echo "</ul>";

?>