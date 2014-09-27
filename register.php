<!-- this is the register main pagecreated by HTML and PHP . The header for this file is on a different file and has been included by the include_once function -->
<!-- this is the mostly the framework files. the only changes I made was adding the honey curl feature on line 50 and commented out the captcha feature. -->

<?php

include_once "inc/init.php";
include_once 'lib/captcha/captcha.php';

if($user->islg()) { // if it's alreadt logged in redirect to the main page
  header("Location: $set->url");
  exit;
}


$page->title = "Register to ". $set->site_name;

// determine if captcha code is correct
//$captcha = ((!$set->captcha) || ($set->captcha && isset($_SESSION['captcha']) && isset($_POST['captcha']) && ($_SESSION['captcha']['code'] === $_POST['captcha'])));
if($_POST && isset($_SESSION['token']) && ($_SESSION['token'] == $_POST['token']) && $set->register) {

 if(isset($_POST)){
	  $name = $_POST['name'];
	  $fullname = $_POST['fullname'];
	  $email = $_POST['email'];
	  $input = $_POST['input'];
	  $password = $_POST['password'];}
	  
	  
  if(!isset($name[3]) || isset($name[30]))
    $page->error = "Username too short or too long !";

  if(!$options->validUsername($name))
    $page->error = "Invalid username !";

  if(!isset($fullname[3]) || isset($fullname[50]))
    $page->error = "full name too short or too long !";

  if(!isset($password[3]) || isset($password[30]))
    $page->error = "Password too short or too long !";

  if(!$options->isValidMail($email))
    $page->error = "Email address is not valid.";

  if($db->getRow("SELECT `userid` FROM `".MLS_PREFIX."users` WHERE `username` = ?s", $name))
    $page->error = "Username already in use !";

  if($db->getRow("SELECT `userid` FROM `".MLS_PREFIX."users` WHERE `email` = ?s", $email))
    $page->error = "Email already in use !";
	
   if(!empty($input) > 0)
    $page->error = "you are a bot!";

  if(!isset($page->error)){
    $user_data = array(
	  "fullname" => $fullname,
      "username" => $name,
      "password" => sha1($password),
      "email" => $email,
      "lastactive" => time(),
      "regtime" => time(),
      "validated" => 1
      );
	
	if($set->email_validation == 1) {

      $user_data["validated"] = $key = sha1(rand());

      $link = $set->url."/validate.php?key=".$key."&username=".urlencode($name);


      $url_info = parse_url($set->url);
      $from ="From: not.reply@".$url_info['host'];
      $sub = "Activate your account !";
      $msg = "Hello ".$options->html($name).",<br> Thank you for choosing to be a member of out community.<br/><br/> To confirm your account <a href='$link'>click here</a>.<br>If you can't access copy this to your browser<br/>$link  <br><br>Regards<br><small>Note: Dont reply to this email. If you got this email by mistake then ignore this email.</small>";
      if(!$options->sendMail($email, $sub, $msg, $from))
        // if we can't send the mail by some reason we automatically activate the account
          $user_data["validated"] = 1;
    }

    if(($db->query("INSERT INTO `".MLS_PREFIX."users` SET ?u", $user_data)) && ($id = $db->insertId()) && $db->query("INSERT INTO `".MLS_PREFIX."privacy` SET `userid` = ?i", $id)) {
      $page->success = 1;
      $_SESSION['user'] = $id; // we automatically login the user
      $user = new User($db);
    } else
      $page->error = "There was an error ! Please try again !";

  }


}  


include 'header.php';


if(!$set->register) // we check if the registration is enabled
  $options->fError("We are sorry registration is blocked momentarily please try again later !");


$_SESSION['token'] = sha1(rand()); // random token

/*if($set->captcha)
  $_SESSION['captcha'] = captcha();*/


$extra_content = ''; // holds success or error message

if(isset($page->error))
  $extra_content = $options->error($page->error);

if(isset($page->success)) {

  echo "<div class='container'>
    <div class='span3 hidden-phone'></div>
    <div class='span6 well'>
    <h1>Congratulations !</h1>";
    $options->success("<p><strong>Your account was successfully registered !</strong></p>");
    echo " <a class='btn btn-primary' href='$set->url'>Start exploring</a>
    </div>
  </div>";


} else {

/*if($set->captcha)
$captcha =  "
  <div class='control-group'>
    <label class='control-label' for='captcha'>Enter the code:</label>
    <div class='controls'>
      <img src='".$_SESSION['captcha']['image_src']."'><br/>
      <input type='text' class='input-xlarge' name='captcha' id='captcha'>
    </div>
  </div>";
else
  $captcha = '';
  the variable above should be on line 172 below and on line 18 to reinstall captcha
  */
  
  
  
  // we validate the data
	
	

  echo "
  <div class='container'>
    <div class='span3 hidden-phone'></div>
      <div class='span6'>

      ".$extra_content."

      <form action='#' id='contact-form' class='form-horizontal well' method='post'>
        <fieldset>
          <legend>Sign up to Ifriend </legend>
		  
		 <div class='form-group'>
            <label class='sr-only' for='inputfullname'></label>
            <div class='controls'>
              <input type='text' class='input-xlarge' placeholder='full name' name='fullname' value = '' id='fullname'>
            </div>
          </div><br>

          <div class='form-group'>
            <label class='sr-only' for='inputUsername'></label>
            <div class='controls'>
              <input type='text' class='input-xlarge' placeholder='username' name='name' value = '' id='name'>
            </div>
          </div><br>
       
          <div class='form-group'>
            <label class='sr-only' for='inputEmail'></label>
            <div class='controls'>
              <input type='text' class='input-xlarge' placeholder='email' name='email' value = '' id='email'>
            </div>
          </div><br>
          <div class='form-group'>
            <label class='sr-only' for='Password'></label>
            <div class='controls'>
              <input type='password' class='input-xlarge' placeholder='password' name='password' id='password'>
            </div>
          </div><br>
		  <div class='form-group'>
			  <div class='control-group'>
			  <input type='hidden' class='input-xlarge' name='input' id='input'>
			  </div>
		  </div>
          <input type='hidden' name='token' value='".$_SESSION['token']."'>
          <div class='form-actions'>
          <button type='submit' class='btn btn-primary btn-large'>Sign up</button>
            <button type='reset' class='btn'>Reset</button>
          </div>
        </fieldset>
      </form>
    </div>


  </div>";
}





include "footer.php";

