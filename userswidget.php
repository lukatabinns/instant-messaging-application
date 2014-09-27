<?php
	/*This will display the users registered on the system within the user area. 
	*The idea is to show various status such as "online", "is typing" and "last seen".
	*/
	$result1 = $db->query("SELECT * FROM `".MLS_PREFIX."users` WHERE `userid` > 1 ORDER by `userid` ASC ");
	//$user1 = $user->islg();
	while($extract = mysqli_fetch_array($result1)){
		if (!empty($extract['username'])){
		echo           "<div class=\"users-wrapper\">";
		echo	      		" <div class=\"users-list\"> ";
		echo					" <ul class =\"users-holder-ul\"> ";
		echo						" <li class=\"users-holder\" > ";
		echo							"<span class=' '> " . "<img src='".$user->getAvatar()."' width='18' class='img-polaroidms'>" . " </span><span class = 'uname'> " . $extract['username'] . "</span></br>";
		echo						"</li>";
		echo					"</ul>";
		echo				"</div>";
		echo			"</div>";

		}else return false;
	}
