<?php
/*
 Module Name: Members
 Module URI: http://ezrpgproject.net/
 Description: Shows basic list of members. Included in ezRPG core by default.
 Version: 1.0
 Package: SIMPLE
 Author: Zeggy
 */
 
defined('IN_EZRPG') or exit;

class Module_Members extends Base_Module
{
    /*
      Function: start
      Displays the members list page.
    */
    public function start()
    {
		if (!LOGGED_IN)
		{
			redirectTo('index.php');
		}
        
        if (isset($_GET['page']))
            $page = (intval($_GET['page']) > 0) ? intval($_GET['page']) : 0;
        else
            $page = 0;
        
        $query = $this->db->execute('SELECT `username`, `level` FROM `<ezrpg>players` ORDER BY `id` ASC LIMIT ?,50', array($page * 50));
        $members = $this->db->fetchAll($query);
        
        $prevpage = (($page - 1) >= 0) ? ($page - 1) : 0;
        
        $this->tpl->assign('nextpage', ++$page);
        $this->tpl->assign('prevpage', $prevpage);
        $this->tpl->assign('members', $members);
        $this->tpl->display('members.tpl');
    }
}
?>
