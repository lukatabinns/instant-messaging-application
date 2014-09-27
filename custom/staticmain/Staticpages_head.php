<?php
include_once "inc/init.php";

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
        <title>ifriend</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="<?php echo $set->url; ?>/css/bootstrap.min.css">
        <!-- join the dark side :) -->
        <!-- <link rel="stylesheet" href="<?php echo $set->url; ?>/css/darkstrap.min.css">-->
        <style>
            body {
                padding-top: 20px;
                padding-bottom: 40px;
            }
        </style>
		<link rel="stylesheet" type="text/css" href="<?php echo $set->url; ?>/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $set->url; ?>/css/static-page.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $set->url; ?>/css/bootstrapext.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $set->url; ?>/css/bootstrap-responsive.min.css">
        <script src="<?php echo $set->url; ?>/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo $set->url; ?>/css/style.css"/>
		<script src="http://code.jquery.com/jquery-1.9.0.js"></script>
		
    </head>
    <body>
	
		  <div class="navbar navbar-default navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                
                    <a class="brand" href="<?php echo $set->url; ?>"><?php echo $set->site_name; ?></a>
                    <div class=" navbar-collapse" id="b-menu-1">
                        <ul class="nav navbar-nav navbar-right">
				
<?php
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

if(!$user->islg()) { 

echo "<span class='pull-right'>
       <a href='$set->url/register.php' class='btn btn-primary btn-sm'>Sign Up</a>
       <a href='$set->url/login.php' class='btn btn-small'>Login</a>
    </span>

    ";
}

echo "

            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>";



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


if(isset($_SESSION['success'])){
    $options->success($_SESSION['success']);
    unset($_SESSION['success']);
}
if(isset($_SESSION['error'])){
    $options->error($_SESSION['error']);
    unset($_SESSION['error']);

}
flush(); // we flush the content so the browser can start the download of css/js