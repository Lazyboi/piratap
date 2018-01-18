<?php
require("lorels.php");
//$API_KEY = $_POST['key'];
$number = "09355104506";
$message = "hellow";
$API_KEY = "4dd8b47dc01406eb9c58c499a1db42464cf2b725";
$options = array( 'ssl' => false );
$clockwork = new annymsphQOI( $API_KEY, $options );
$message = array('to' => ''.$number.'', 'message' => ''.$message.'');
$done = $clockwork->send($message);
?>