<?php
defined('IN_EZRPG') or exit;

// This hook is used for checking and getting all the info about modules in admin area. For proper ezRPG admin functionality, it must always be in admin header part.
$hooks->add_hook('admin_header', 'check_modules', 3);

function hook_check_modules(&$db, &$tpl, &$player, $args = 0) {

	/**
	/* get_modules() function returns us 3 arrays of module names to work with:
	/* 1. public ones (all modules, that are used in game, but don't have any settings) - returned as $var['public']
	/* 2. admin ones (all modules, that have settings and can be reached from admin area) - returned as $var['admin']
	/* 3. other (files, that lie separately in modules dir, but not in subdirs - misc ones. It's here just to handle them too) - returned as $var['other']
	/* Accepts parameter 0 (empty) or 1 for full modules info parsing. By default only returns dirnames of used modules.
	**/
	$modules_array = get_modules();
	 
	if (isset($modules_array['public'])) {
		$tpl->assign('PUBLIC_MODULES', $modules_array['public']);
	}
	
	if (isset($modules_array['admin'])) {
		$tpl->assign('ADMIN_MODULES', $modules_array['admin']);
	}
    
    return $args;
}
?>