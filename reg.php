<?php
/*this is the file that outputs the chats to the user area on the server-side*/
include "inc/init.php";
if ($user->islg()){
		$result1 = $db->query("SELECT * FROM `".MLS_PREFIX."chat` ORDER by chatid DESC");

		while($extract = mysqli_fetch_array($result1)){
			if (!empty($extract['msg'])){
			echo	      " <div class=\"chats-list\"> ";
			echo				" <ul class =\"chats-holder-ul\"> ";
			echo					" <li class=\"chat-holder\" > ";
			echo							"<span class=' '> " . "<img src='" . $user->getAvatar() . "' width='18' class='img-polaroidmsc'>" . " </span>" . "<span class = 'uname'> " . $extract['username'] . "</span> <span class='msg'> " . $extract['msg'] . " </span></br>";
			echo					"</li>";
			echo				"</ul>";
			echo			"</div>";
			}else return false;
		}
}