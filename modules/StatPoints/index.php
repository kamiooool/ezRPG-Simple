<?php
/*
 Module Name: StatPoints
 Module URI: http://ezrpgproject.net/
 Description: This module handles distribution of stat points. It is included in ezRPG core by default.
 Version: 1.0.1
 Package: SIMPLE
 Author: Zeggy, [SC]Smash3r
 Author URI: http://smash3r.dautkom.lv/
 */

defined('IN_EZRPG') or exit;

class Module_StatPoints extends Base_Module
{
    /*
      Function: start
      Begins the stat points distribution page.
    */
    public function start()
    {
		if (!LOGGED_IN)
		{
			// If user is not logged in, and trying to get into StatPoints module - we're just redirecting him to index
			redirectTo('index.php');
		} 

		// Checking for statpoints, and showing an error, if there is no statpoints left to spend
		if (isset($_POST['form_id']))
		{
			if ($this->player->stat_points > 0) 
			{
				$this->spend();
			}
			else
			{
				showMsg('You have no points left to spend!',2);
			}
		}
		else
		{
			$this->render();
		}

    }
	
    /*
      Function: render
      Renders statpoints.tpl.
    */
    private function render()
    {
		$this->tpl->display('statpoints.tpl');
    }
	
    
    /*
      Function: spend
      This function removes stat points and increases stats and other player details.
	
      After the query is executed, the player is redirected back to the StatPoints module homepage.
    */
    private function spend()
    {
        switch($_POST['form_id'])
        {
          case 'stat_str':
              //Add to weight limit
              $query = $this->db->execute('UPDATE <ezrpg>players SET
				stat_points=stat_points-1,
				strength=strength+1
				WHERE id=?', array($this->player->id));
              
			  showMsg('You have increased your strength!',3);
              break;
          case 'stat_vit':
              //Add to hp and max_hp
              $query = $this->db->execute('UPDATE <ezrpg>players SET
				stat_points=stat_points-1,
				vitality=vitality+1,
				hp=hp+5,
				max_hp=max_hp+5
				WHERE id=?', array($this->player->id));
              
              showMsg('You have increased your vitality!',3);
              break;
          case 'stat_agi':
              $query = $this->db->execute('UPDATE <ezrpg>players SET
				stat_points=stat_points-1,
				agility=agility+1
				WHERE id=?', array($this->player->id));
              
              showMsg('You have increased your agility!',3);
              break;
          case 'stat_dex':
              $query = $this->db->execute('UPDATE <ezrpg>players SET
				stat_points=stat_points-1,
				dexterity=dexterity+1
				WHERE id=?', array($this->player->id));
              
              showMsg('You have increased your dexterity!',3);
              break;
          default:
              break;
        }

        exit;
    }
}
?>
