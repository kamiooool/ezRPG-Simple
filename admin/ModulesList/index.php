<?php
defined('IN_EZRPG') or exit;

/*
  Class: Admin_ModulesList
  Handles all the info and stuff about modules
*/
class Admin_ModulesList extends Base_Module
{
    public function start()
    {
	/**
	/* get_modules() function returns us 3 arrays of module names to work with:
	/* 1. public ones (all modules, that are used in game, but don't have any settings) - returned as $var['public']
	/* 2. admin ones (all modules, that have settings and can be reached from admin area) - returned as $var['admin']
	/* 3. other (files, that lie separately in modules dir, but not in subdirs - misc ones. It's here just to handle them too) - returned as $var['other']
	/* Accepts parameter 0 (empty) or 1 for full modules info parsing. By default only returns dirnames of used modules.
	**/
	$modules_array = get_modules(1);
	
	if (isset($modules_array['module'])) {
		$this->tpl->assign('MODULES_INFO', $modules_array['module']);
	}
	
	$this->tpl->display(ADMIN_TPL_DIR.'/modules_list.tpl');
    }
}
?>