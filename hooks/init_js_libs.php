<?php
defined('IN_EZRPG') or exit;

$hooks->add_hook('header', 'init_js_libs', 0);

function hook_init_js_libs(&$db, &$tpl, &$player, $args = 0) {

    $tpl->assign('INIT_JS_LIBS', array('<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>'));
    
    return $args;
}
?>