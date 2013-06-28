<?php
defined('IN_EZRPG') or exit;

$hooks->add_hook('header', 'init_js_libs', 0);

// This is the file where all the core needed .js files are included
// You shouldn't add any other JS files here, because various themes have different JS files, and they must be included in theme's header.tpl file accordingly

function hook_init_js_libs(&$db, &$tpl, &$player, $args = 0) {

	// Here goes the list of included necessary JS libs
	$libs_array = array(
						'<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>',
						'<script src="lib/js/ajax.js"></script>',
						);
	// For DEBUG_MODE plug in another one JS for nifty modal window to handle messages
	if (DEBUG_MODE == 1) $libs_array[] = '<script src="lib/js/debug_modal.js"></script>';
	
    $tpl->assign('INIT_JS_LIBS', $libs_array);
    
    return $args;
}
?>