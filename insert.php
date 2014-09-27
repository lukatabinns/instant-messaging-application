<?php
/* This file inserts the chat to the database that the user enters from the chat input box*/
include "inc/init.php";
//$row = mysqli_fetch_assoc($userid);

$msg =  htmlentities($_REQUEST['msg']);

$msg = $db->real_escape_string($msg);

$query = $db->query("INSERT INTO `".MLS_PREFIX."chat`( `msg`) VALUES( '$msg') ");

//$db->close();
