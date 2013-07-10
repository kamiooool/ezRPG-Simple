<?php
/*
 Module Name: Login
 Module URI: http://ezrpgproject.net/
 Description: This module handles user authentication. It is included in ezRPG core by default.
 Version: 1.0.1
 Package: SIMPLE
 Author: Zeggy, [SC]Smash3r
 Author URI: http://smash3r.dautkom.lv/
 */
 
defined('IN_EZRPG') or exit;

class Module_Login extends Base_Module
{
    /*
      Function: start
      Checks player details to login the player.
	
      If successful, a new session is generated and the user is redirected to the game.
	
      On failure, session data is cleared and message error thrown.
    */
    public function start()
    {
		
		// Checking if username is not empty, otherwise - return an error
        if (empty($_POST['username'])) {
            showMsg('Please enter username!', 1);
        }
        
		// Checking if password is not empty, otherwise - return an error
        if (empty($_POST['password'])) {
            showMsg('Please enter your password!', 1);
        }
        
		// Fetching and checking info entered from DB, but firstly check the $_POST info for validity
		isUsername($_POST['username']) or showMsg('Your username contains invalid characters! Please use only letters and digits, longer than 3 chars.',1);
		
		// If username is valid, we can check for that user in DB
        $query = $this->db->execute('SELECT `id`, `username`, `password`, `secret_key` FROM `<ezrpg>players` WHERE `username`=?', array($_POST['username']));
		
        if ($this->db->numRows($query) == 0) {
		
			// If username is not existing
            showMsg('Please check your username/password!', 1);
			
        } else {
            $player = $this->db->fetch($query);
            $check = sha1($player->secret_key . $_POST['password'] . SECRET_KEY);
            if ($check != $player->password)
            {
				// If username is existing, but password is not match. Here is important to show same error as if it was not existing username to avoid password bruteforcing :D
                showMsg('Please check your username/password!', 1);
            }
        }
        
		// If everything is okay, and there is no errors - we can let the user in
        global $hooks;
            
		//Run login hook
		$player = $hooks->run_hooks('login', $player);
            
		$query = $this->db->execute('UPDATE `<ezrpg>players` SET `last_login`=? WHERE `id`=?', array(time(), $player->id));
		$hash = sha1($player->id . $_SERVER['REMOTE_ADDR'] . SECRET_KEY);
		$_SESSION['userid'] = $player->id;
		$_SESSION['hash'] = $hash;

		$hooks->run_hooks('login_after', $player);
            
		redirectTo('index.php');
		exit;
		
    }
}
?>
