<?php
/*
 Module Name: Register
 Module URI: http://ezrpgproject.net/
 Description: This module handles user registration. It is included in ezRPG core by default.
 Version: 1.0.1
 Package: SIMPLE
 Author: Zeggy, [SC]Smash3r
 Author URI: http://smash3r.dautkom.lv/
 */

defined('IN_EZRPG') or exit;

class Module_Register extends Base_Module
{
    public function start()
    {
		if (LOGGED_IN) {
			// If user is already logged in, we're just redirecting him to index
			redirectTo('index.php');
		}
		
		//If the form was submitted, process it in register()
        if (!empty($_POST))
            $this->register();
        else
            $this->render();
    }
	
    /*
      Function: render
      Renders register.tpl.
    */
    private function render()
    {
        $this->tpl->display('register.tpl');
    }
	
    /*
      Function: register
      Processes the submitted player details.
	
      Checks if all the data is correct, and adds the player to the database.
	
      Otherwise, add an error message.
    */
    private function register()
    {

		// Quering in DB to check if that username already created
		$result = $this->db->fetchRow('SELECT COUNT(`id`) AS `count` FROM `<ezrpg>players` WHERE `username`=?', array($_POST['username']));
		
		// Check username
        if (empty($_POST['username'])) {
		
            showMsg('Please enter username!', 1);
			
        } else if (!isUsername($_POST['username'])) {
		
			// If username is too short... Output warning message (notice the 2 in showMsg args)
			showMsg('Your username must be longer than 3 characters and may only contain alphanumerical characters!', 2);
			
        } else if ($result->count > 0) {
			
			// If username already exists
			showMsg('That username has already been used. Please create only one account!', 1);

        }
		
        //Check password
        if (empty($_POST['password']))
        {
            showMsg('Please enter your password!', 1);
        }
        else if (!isPassword($_POST['password']))
        { 
			//If password is too short...
            showMsg('Your password is too short!', 2);
        }
	
        if ($_POST['password2'] != $_POST['password'])
        {
            //If passwords didn't match
            showMsg('You didn\'t verified your password correctly!', 1);
        }
	
        //Check email
        $result = $this->db->fetchRow('SELECT COUNT(`id`) AS `count` FROM `<ezrpg>players` WHERE `email`=?', array($_POST['email']));
		
        if (empty($_POST['email']))
        {
            showMsg('Please enter your correct email!', 1);
        }
        else if (!isEmail($_POST['email']))
        {
            showMsg('Your email format is wrong!', 1);
        }
        else if ($result->count > 0)
        {
            showMsg('That email has already been used. Please create only one account, creating more than one account will get all your accounts deleted!', 2);
        }
	
        if ($_POST['email2'] != $_POST['email'])
        {
            showMsg('You didn\'t verify your email correctly!', 1);
        }
		
	
        // verify_code must NOT be used again.
        session_unset();
        session_destroy();

            unset($insert);
            $insert = Array();
            // Add new user to database
            $insert['username'] = $_POST['username'];
            $insert['email'] = $_POST['email'];
            $insert['secret_key'] = createKey(16);
            $insert['password'] = sha1($insert['secret_key'] . $_POST['password'] . SECRET_KEY);
            $insert['registered'] = time();

            global $hooks;
            // Run register hook
            $insert = $hooks->run_hooks('register', $insert);
            
            $new_player = $this->db->insert('<ezrpg>players', $insert);
            // Use $new_player to find their new ID number.

            $hooks->run_hooks('register_after', $new_player);
			
			// Don't forget to redirect user back to index page
            redirectTo('index.php');
			
            exit;
    }
}
?>
