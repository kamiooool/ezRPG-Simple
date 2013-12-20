<?php
define('IN_EZRPG', true);
define('IN_ADMIN', true);

$start = microtime(true);
require_once '../init.php';

// Require admin rank, or kick the user out back to index, if he is not logged in and trying to break into admin section
if ($player == '0') header('Location: ../index.php');

// Checking now for admin rank. Here we can be sure, that we are not checking an empty object
if ($player->rank < 5) header('Location: ../index.php');

$default_mod = 'Index';

$module_name = ( (isset($_GET['mod']) && ctype_alnum($_GET['mod'])) ? $_GET['mod'] : $default_mod );

// Admin header hook
$module_name = $hooks->run_hooks('admin_header', $module_name);

// Begin module
$module = ModuleFactory::adminFactory($db, $tpl, $player, $module_name);
$module->start();

// Admin footer hook
$hooks->run_hooks('admin_footer', $module_name);
$end = microtime(true);

// ADMIN DEBUG MODE
	if (DEBUG_MODE == 1) {
		global $debug_log;
		$debug_log['PAGE_LOAD_TIME'] = number_format(($end - $start), 3);
		showDbLog($debug_log);
	}
?>
