<?php
//This file cannot be viewed, it must be included
defined('IN_EZRPG') or exit;

/*
  Title: Messages handling functions
  This file contains everything that considers as a message
*/

/*
  Function: showMsg
  Returns a message to a user
  
  Parameters:
  $msg_text - The message itself.
  $msg_style - The style (color) of a show message. Must be an int value, just check the function to see how it works

*/
function showMsg($msg_text, $msg_style=0)
{
	// Here we are checking, if the file with the message generated is accessed via AJAX - if directly, just return to index page so to avoid unnecesary bald page view :)
	if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
	
		// Applying a class to <span> element, according to msg_style var - you can define looks in style.css theme file
		switch ($msg_style) {
			case 0:
				$msg_style = "default";
				break;
			case 1:
				$msg_style = "error";
				break;
			case 2:
				$msg_style = "warning";
				break;
			case 3:
				$msg_style = "success";
				break;
		}
		
		echo "<span class=\"{$msg_style}\">{$msg_text}</span>";
		
	} else {
		header ('Location: index.php');
	}
	exit;
}

/*
  Function: redirectTo
  Returns a redirection path as a message to AJAX request, or redirects user using header, if accessed via direct URI
  
  Parameters:
  $path - Location to redirect to. Defaults to index.php

*/
function redirectTo($path='index.php')
{
	// Here we are checking, if the file with the message generated is accessed via AJAX - if directly, just return to index page so to avoid unnecesary bald page view :)
	if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
	
		echo "Location: {$path}";
		exit;
	
	} else {
	
		header("Location: {$path}");
		
	}
}
?>