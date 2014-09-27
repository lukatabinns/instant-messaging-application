<?php
/* 
*This is the header of the index page which includes the JavaScript code which operates the chat system
* All other code originates from the framework.
*/


// we generate the navbar components in case they weren't before
if($page->navbar == array())
    $page->navbar = $presets->GenerateNavbar();

if(!$user->islg()) // if it's not logged in we hide the user menu
    unset($page->navbar[count($page->navbar)-1]);


?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $page->title; ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="<?php echo $set->url; ?>/css/bootstrap.min.css">
        <!-- join the dark side :) -->
        <!-- <link rel="stylesheet" href="<?php echo $set->url; ?>/css/darkstrap.min.css">-->
        <style>
            body {
                padding-top: 60px;
                padding-bottom: 40px;
			
            }
        </style>
		<?php if(!$user->islg()){
		echo " <style>
            body {
                padding-top: 60px;
                padding-bottom: 40px;
				background-color:#E0E0E0;
				background:url('http://localhost/lukex/img/girlchat2.jpg'); 
				background-repeat:no-repeat;
				background-size: 100%;
            }
        </style>";
		} ?>
	    <link rel="stylesheet" href="<?php echo $set->url; ?>/css/chatstyle.css">
        <link rel="stylesheet" href="<?php echo $set->url; ?>/css/bootstrap-responsive.min.css">
        <link rel="stylesheet" href="<?php echo $set->url; ?>/css/main.css">

        <script src="<?php echo $set->url; ?>/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo $set->url; ?>/css/style.css"/>
		<script src="http://code.jquery.com/jquery-1.9.0.js"></script>
		<script>
		
		function submitChat(){
			/* This alert will return a message to the user if the input message box is blank */
			if ( form1.msg.value == ''){
			
				alert('enter your message');
				return false;
			
			}
				
				$('#imageload').show();
				/* This line will retrieve the message after the user clicks send*/
				var msg = form1.msg.value;
				/* This line of code will instantiate the XMLHttpRequest */ 
				var xmlhttp = new XMLHttpRequest();
				/* 
				 * This block of code sends a request to the server using the onreadystate.
				 * The onreadystate acts like a trigger and changes state from 0-4 as it initiates contact with the server.
				 * The status indicates that a successful connection as been made and the server is ready to send the message.
				 * On the next line the document is encoded into an appropriate format for processing.
				 */
					
				xmlhttp.onreadystatechange = function(){
					if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
					document.getElementById('chatlogs').innerHTML;

					
					}
					
				
				}
					/* 
					* This section receives data from the inserted.php file 
					* This data is then sent over the server to be displayed on the user's page 
					*/
					xmlhttp.open('GET', 'insert.php?&msg='+msg, true);
					xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xmlhttp.send(null);
				    /* This piece of code refreshes the input message box when the user clicks enter or the send button */
					document.forms['form1'].reset();

				}
		
			/* This block of code displays the previous data or messages that users submit */ 
			$(document).ready(function(){
				//Load Previous Chat Messages
				$("#chatlogs").load('reg.php', function(){
				// This should fire once the request is fully loaded
				$("#chatlogs").animate({ scrollTop: $("#chatlogs")[0].scrollHeight}, "fast");
			   window.setInterval(function() { var elem = document.getElementById('chatlogs'); elem.scrollTop = elem.scrollHeight; }, 340);
				});
			});

				
			/* This block of code grabs a chat message every 2000 of a millisecond which is where the real-time effect comes to life */
			$(document).ready(function(e){
		
			$.ajaxSetup({cache:false});
				setInterval(function(){$('#chatlogs').load('reg.php')}, 2000);
		
			});
			
			/* 
			 * This block of code provide another option for you to submit data.
			 * User can click enter instead of the send button.
			 */
		 	$(document).keyup(function (e) {
				if ($(".chatbox:focus") && (e.keyCode === 13 && e.shiftKey === false)  ) {
				submitChat();
				e.preventDefault();
				}
			 });
			 
			 
			

		</script>

    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]--> 

        <!-- This code is taken from http://twitter.github.com/bootstrap/examples/hero.html -->
<?php


		if($user->islg()) { 
       echo "<div class=\"navbar navbar-default navbar-fixed-top\">
            <div class=\"navbar-inner\">
                <div class=\"container\">
                    <a class=\"btn btn-navbar\" data-toggle=\"collapse\" data-target=\".nav-collapse\">
                        <span class=\"icon-bar\"></span>
                        <span class=\"icon-bar\"></span>
                        <span class=\"icon-bar\"></span>
                    </a>
					<a class=\"brand\" href=\" $set->url \"> $set->site_name</a>
                    <div class=\"nav-collapse collapse\">
                        <ul class=\"nav pull-right\">";
// we generate a simple menu this may need to be adjusted depending on your needs
// but it should be ok for most common items
foreach ($page->navbar as $key => $v) {

    if ($v[0] == 'item') {
    
        echo "<li".($v[1]['class'] ? " class='".$v[1]['class']."'" : "").">
			  <a href='".$v[1]['href']."'>".$v[1]['name']."</a></li>";
					
    } else if($v[0] == 'dropdown') {

        echo "<li class='dropdown".
            // extra classes 
            ($v['class'] ? " ".$v['class'] : "")."'".
            // extra style
            ($v['style'] ? " style='".$v['style']."'" : "").">
            
            <a href='#' class='dropdown-toggle' data-toggle='dropdown'>".$v['name']." <b class='caret'></b></a>
            <ul class='dropdown-menu'>";
        foreach ($v[1] as $k => $v) 
            echo "<li".
                
                ($v['class'] ? " class='".$v['class']."'" : "").">
					
                <a href='".$v['href']."'>".$v['name']."</a></li>";                                
        echo "</ul></li>";

    }
    
}

echo "</ul>";

/*echo "<span class='pull-right'>
        <a href='$set->url/register.php' class='btn btn-primary btn-small'>Sign Up</a>
        <!-- <a href='$set->url/login.php' class='btn btn-small'>Login</a> -->
        <a href='#loginModal' data-toggle='modal' class='btn btn-small'>Login</a>
    </span>
    ";*/


echo "

            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>";

}


if($user->data->banned) {
  
    // we delete the expired banned
    $_unban = $db->getAll("SELECT `userid` FROM `".MLS_PREFIX."banned` WHERE `until` < ".time());
    if($_unban) 
        foreach ($_unban as $_usr) {
            $db->query("DELETE FROM `".MLS_PREFIX."banned` WHERE `userid` = ?i", $_usr->userid);
            $db->query("UPDATE `".MLS_PREFIX."users` SET `banned` = '0' WHERE `userid` = ?i", $_usr->userid);             
        }


    $_banned = $user->getBan();
    if($_banned)
    $options->error("You were banned by <a href='$set->url/profile.php?u=$_banned->by'>".$user->showName($_banned->by)."</a> for `<i>".$options->html($_banned->reason)."</i>`.
        Your ban will expire in ".$options->tsince($_banned->until, "from now.")."
        ");


    


}



if($user->islg() && $set->email_validation && ($user->data->validated != 1)) {
    $options->fError("Your account is not yet acctivated ! Please check your email !");
}

if(file_exists('install.php')) {
    $options->fError("You have to delete the install.php file before you start using this app.");
}




if(isset($_SESSION['success'])){
    $options->success($_SESSION['success']);
    unset($_SESSION['success']);
}
if(isset($_SESSION['error'])){
    $options->error($_SESSION['error']);
    unset($_SESSION['error']);

}
flush(); // we flush the content so the browser can start the download of css/js