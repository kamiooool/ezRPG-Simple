<?php
/*
 Module Name: Logout
 Module URI: http://ezrpgproject.net/
 Description: Clears the session data to logout the user. Included in ezRPG core by default.
 Version: 1.0
 Package: SIMPLE
 Author: Zeggy
 */
 
defined('IN_EZRPG') or exit;

class Module_Logout extends Base_Module
{
    /*
      Function: start
      Clears session data and redirects back to homepage.
    */
    public function __construct(&$db, &$tpl, &$player=0)
    {
        unset($_SESSION['hash']);
        unset($_SESSION['userid']);
        session_unset();
        session_destroy();

        global $hooks;
        $hooks->run_hooks('logout');
		
        exit;
    }
}
?>
