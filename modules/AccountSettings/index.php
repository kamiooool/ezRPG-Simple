<?php
/*
 Module Name: Account Settings
 Module URI: http://ezrpgproject.net/
 Description: Lets the user change their password. Included in ezRPG core by default.
 Version: 1.0.1
 Package: SIMPLE
 Author: Zeggy, [SC]Smash3r
 Author URI: http://smash3r.dautkom.lv/
 */
 
defined('IN_EZRPG') or exit;

class Module_AccountSettings extends Base_Module
{
    /*
      Function: start
      Begins the account settings page/
    */
    public function start()
    {
		if (!LOGGED_IN)
		{
			redirectTo('index.php');
		} 
        
        if (!empty($_POST))
        {
            $this->changePassword();
        }
        else
        {
            $this->tpl->display('account_settings.tpl');
        }
    }

    private function changePassword()
    {
        if (empty($_POST['current_password']) || empty($_POST['new_password']) || empty($_POST['new_password2']))
        {
            showMsg('You forgot to fill in something', 1);
        }
        else
        {
            $check = sha1($this->player->secret_key . $_POST['current_password'] . SECRET_KEY);
            if ($check != $this->player->password)
            {
				showMsg('The password you entered does not match this account\'s password.', 1);
            }
            else if (!isPassword($_POST['new_password']))
            {
				showMsg('Your password must be longer than 3 characters!', 2);
            }
            else if ($_POST['new_password'] != $_POST['new_password2'])
            {
				showMsg('You didn\'t confirm your new password correctly!', 1);
            }
            else
            {
                $new_password = sha1($this->player->secret_key . $_POST['new_password2'] . SECRET_KEY);
                $this->db->execute('UPDATE `<ezrpg>players` SET `password`=? WHERE `id`=?', array($new_password, $this->player->id));
				showMsg('You have changed your password.', 3);
            }
        }
    }
}
?>