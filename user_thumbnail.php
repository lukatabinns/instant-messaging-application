
<?php

include_once "inc/init.php";

echo "  	
	<div class='thumb-wrapper'>	
			<a href='".$set->url."/profile.php?u=".$user->data->userid."'>
				<img src='".$user->getAvatar( )."' width='240' class='img-polaroidmsc'>
			</a>
		<a href='".$set->url."/profile.php?u=".$user->data->userid."'><div class = 'uname1'><b>".$user->showName()."  </b></div></a>
		<a href='' class = 'unprofile2'>Edit Profile</a>
	</div>";


