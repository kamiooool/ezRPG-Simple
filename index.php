<?php
define('IN_EZRPG', true);
define('CUR_DIR', realpath(dirname(__FILE__)));

// Checking if config.php was created, and if it has some data, so we might be sure the user is not abandoned the process at the very middle
if (!file_exists(CUR_DIR.'/config.php') or filesize(CUR_DIR.'/config.php') == 0) {
	header('Location: install.php');
	exit();
}

// Deleting installer, if everything is already set
if (isset($_GET['act']) && $_GET['act'] == 'deleteinstaller' && file_exists(CUR_DIR.'/install.php')) {
	unlink(CUR_DIR.'/install.php');
	header('Location: index.php');
	exit();
}

// Main skeleton

require_once CUR_DIR.'/init.php';

$default_mod = 'Index';

$module_name = ( (isset($_GET['mod']) && ctype_alnum($_GET['mod'])) ? $_GET['mod'] : $default_mod );

//Header hooks
$module_name = $hooks->run_hooks('header', $module_name);

//Begin module
$module = ModuleFactory::factory($db, $tpl, $player, $module_name);
$module->start();

//Footer hooks
$hooks->run_hooks('footer', $module_name);
?>
