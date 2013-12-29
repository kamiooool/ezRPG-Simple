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
			$msg = _e('##EZ_ACCOUNTSETTINGS_ERROR_1##');
            showMsg($msg, 1);
        }
        else
        {
            $check = sha1($this->player->secret_key . $_POST['current_password'] . SECRET_KEY);
            if ($check != $this->player->password)
            {
				$msg = _e('##EZ_ACCOUNTSETTINGS_ERROR_2##');
				showMsg($msg, 1);
            }
            else if (!isPassword($_POST['new_password']))
            {
				$msg = _e('##EZ_ACCOUNTSETTINGS_ERROR_3##');
				showMsg($msg, 2);
            }
            else if ($_POST['new_password'] != $_POST['new_password2'])
            {
				$msg = _e('##EZ_ACCOUNTSETTINGS_ERROR_4##');
				showMsg($msg, 1);
            }
            else
            {
                $new_password = sha1($this->player->secret_key . $_POST['new_password2'] . SECRET_KEY);
                $this->db->execute('UPDATE `<ezrpg>players` SET `password`=? WHERE `id`=?', array($new_password, $this->player->id));
				$msg = _e('##EZ_ACCOUNTSETTINGS_SUCCESS_MSG##');
				showMsg($msg, 3);
            }
        }
    }
}
?>