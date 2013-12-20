<?php
defined('IN_EZRPG') or exit;

/*
  Class: Admin_Members
  Admin page for managing members
*/
class Admin_Members extends Base_Module
{
    /*
      Function: start
      Displays the list of members or a member edit form.
    */
    public function start()
    {
		// We need to go deeper
        if (isset($_POST['act']))
        {
            if ($_POST['act'] == 'edit')
            {
                $this->editMember();
				exit;
            }
            else if ($_POST['act'] == 'delete')
            {
                $this->deleteMember();
				exit;
            }
        }
		
        if (isset($_GET['act']))
        {
            if ($_GET['act'] == 'edit')
            {
                $this->editMember();
            }
            else if ($_GET['act'] == 'delete')
            {
                $this->deleteMember();
            }
        }
        else
        {
            $this->listMembers();
        }
		
    }
    
    /*
      Function: listMembers
      Gets a list of all members and displays them in a paginated format.
    */
    private function listMembers()
    {
        if (isset($_GET['page']))
            $page = (intval($_GET['page']) > 0) ? intval($_GET['page']) : 0;
        else
            $page = 0;
        
        $query = $this->db->execute('SELECT `id`, `username`, `email` FROM `<ezrpg>players` ORDER BY `id` ASC LIMIT ?,50', array($page * 50));
        
        $members = Array();
        while ($m = $this->db->fetch($query))
        {
            $members[] = $m;
        }
        
        $query = $this->db->fetchRow('SELECT COUNT(`id`) AS `count` FROM `<ezrpg>players`');
        $total_players = $query->count;
        
        $prevpage = (($page - 1) >= 0) ? ($page - 1) : 0;
        
        $this->tpl->assign('nextpage', ++$page);
        $this->tpl->assign('prevpage', $prevpage);
        $this->tpl->assign('playercount', $total_players);
        $this->tpl->assign('members', $members);
        
        $this->tpl->display(ADMIN_TPL_DIR.'/members.tpl');
    }
    
    /*
      Function: editMember
      Displays a form to edit a player, and processes the form submissions.
    */
    private function editMember()
    {
		if (!isset($_POST['act'])) {
			if (!isset($_GET['id']))
			{
				showMsg('Player with such ID is not found!', 1);
			}
			
			$member = $this->db->fetchRow('SELECT `id`, `username`, `email`, `rank`, `money`, `stat_points` FROM `<ezrpg>players` WHERE `id`=?', array( intval($_GET['id']) ));
			
			//No form was submitted, so just display the edit form
			if (!isset($_POST['edit']))
			{
				$this->tpl->assign('member', $member);
				$this->tpl->display(ADMIN_TPL_DIR.'/members_edit.tpl');
				exit;
			}
		
		} else {
			
			$member = $this->db->fetchRow('SELECT `id`, `username`, `email`, `rank`, `money`, `stat_points` FROM `<ezrpg>players` WHERE `id`=?', array( intval($_POST['id']) ));
			
		}

        //No rows found
        if ($member == false)
        {
            redirectTo('index.php?mod=Members');
            exit;
        }
        
        
        //Form was submitted! \o/
        if (empty($_POST['email']))
        {
            showMsg('Please enter e-mail!', 1);
        }
		
        //Money
        $_POST['money'] = (!empty($_POST['money']))?intval($_POST['money']):0;
		
        //Statpoints
        $_POST['statpoints'] = (!empty($_POST['money']))?intval($_POST['stat_points']):0;

        $_POST['rank'] = (!empty($_POST['rank']))?intval($_POST['rank']):$member->rank;
        if (!isset($_POST['rank']))
        {
            showMsg('Please enter user rank!', 1);
        }
        
        //If the rank of the player you're editing is higher or equal to your own rank, then you are not allowed to edit their rank
        if ($member->rank > $this->player->rank)
        {
            if ($_POST['rank'] != $member->rank)
            {
                //Reset rank to original rank
                $_POST['rank'] = $member->rank;
            }
        }
        else if ($_POST['rank'] > $this->player->rank)
        {
            showMsg('You can\'t set player\'s rank higher than yours!', 1);
        }
        
            //No errors, update player info
            $query = $this->db->execute('UPDATE `<ezrpg>players` SET `email`=?, `rank`=?, `money`=?, `stat_points`=? WHERE `id`=?', array($_POST['email'], $_POST['rank'],$_POST['money'], $_POST['stat_points'], $member->id));
            
            showMsg('Info succesfully updated!', 3);

    }
    
    /*
      Function: deleteMember
      Deletes a member from the database. Asks for confirmation first.
    */
    private function deleteMember()
    {
		if (!isset($_POST['act']))
		{
			$member = $this->db->fetchRow('SELECT `id`, `username` FROM `<ezrpg>players` WHERE `id`=?', array($_GET['id']));
		
			if (!isset($_POST['confirm']))
			{
				$this->tpl->assign('member', $member);
				$this->tpl->display(ADMIN_TPL_DIR.'/members_delete.tpl');
				exit;
			}

		}
		else
		{
			$member = $this->db->fetchRow('SELECT `id`, `username` FROM `<ezrpg>players` WHERE `id`=?', array($_POST['id']));
			
		}
        
        if ($member == false)
        {
            redirectTo('index.php?mod=Members');
            exit;
        }
        
        if ($member->id == $this->player->id)
        {
            // Cannot delete self
            showMsg('You can\'t delete your account when logged in!', 1);
        }
        
            $query = $this->db->execute('DELETE FROM `<ezrpg>players` WHERE `id`=?', array($member->id));
            redirectTo('index.php?mod=Members');
            exit;

    }
}