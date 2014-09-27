<?php

/* This is the homepage created from a combination of HTML and PHP. I made a few changes here. although this code is apart of the framework
*Please notice that this is the same page has the users chat area.
*If a person visits the web app or a user logs-out, they will be presented the homepage.
*the inc/init.php file on line 10 includes all the necessary function such as database connection, error messages, users functions(login & logout) etc.
* I have included the lines 17-27 which shows the homepage banner.
* I have included lines 32-45 is the HTML codes for the message input box.
*I have also included lines 58-66 which are HTML codes for the links to other pages.
*/

include "inc/init.php";

$page->title = "Welcome to ". $set->site_name;

$presets->setActive("home"); // we highlith the home link

include_once 'custom/index/index_header.php';

if(!$user->islg()){
echo "
<div class=\"container\">

<div class=\"hero-unit\">
    <h1>Ifriend</h1>
    <p>
       Meeting new people and make conversation everyday.
    </p>";

	}
if($user->islg()) {	
include "userswidget.php";

echo "<form id=\"form1\">
		<div class=\"chat-wrapper\">
				<ul class = \"chattrigger\">
					<li><input type=\"text\"   id = \"msg\" name=\"msg\"  placeholder = \"send your message...\"></input></li>
					<li><a href=\"javascript:void(0)\" onClick=\"submitChat(); return false;\" >send</a></li>
				</ul>
			<!--<div id=\"imageload\" style=\"display:none;\">
			<img src=\"images/img.gif\"/>
			</div>-->
			<div id=\"chatlogs\">
			<div class = \"wait\"><img src=\"img/img.gif\"/><div>
			</div>
		</div>
</form> ";}
	
	
if(!$user->islg()) {
    echo "<p>
        <a class=\"btn btn-primary btn-large\" href=\"$set->url/register.php\">Sign Up</a>
        <a class=\"btn btn-large\" href=\"$set->url/login.php\">Login</a>
    </p>";

}
if(!$user->islg()) {
echo	 "<div class=\"menu\">
			<ul class= \"\"> 
				<li><a href=\"$set->url/about.php\">About</a></li>
				<li><a href=\"$set->url/terms.php\">Terms</a></li>
				<li><a href=\"$set->url/privacypolicies.php\">Privacy</a></li>
				<li><a href=\"$set->url/help.php\">Help</a></li><br>
				  <div class=\"mark\"> &copy; Ifriend " . date("Y") . "</div>
			</ul>
		</div>
		
		
</div></div> <!-- /container -->";}

include 'custom/index/index_footer.php';