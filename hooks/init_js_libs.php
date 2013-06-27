<?php
defined('IN_EZRPG') or exit;

$hooks->add_hook('header', 'init_js_libs', 0);

// This is the file where all the core needed .js files are included
// You shouldn't add any other JS files here, because various themes have different JS files, and they must be included in theme's header.tpl file accordingly

function hook_init_js_libs(&$db, &$tpl, &$player, $args = 0) {

    $tpl->assign('INIT_JS_LIBS', array('<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>','<script src="lib/js/ajax.js"></script>'));
    
    return $args;
}
?>