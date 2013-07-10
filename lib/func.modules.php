<?php
//This file cannot be viewed, it must be included
defined('IN_EZRPG') or exit;

/*
  Title: Modules related functions
  This file contains everything that is related to module files, such as module metainfo parsing and etc.
*/

/**
 * Main function for getting the module files from its directories
 * Ported from Wordpress wp-admin/includes/plugin.php:361
 * Modificated for ezRPG
 */
function get_modules($fullinfo = 0) {
	$module_files = array();
	$other_files = array();
	
	// Files in modules directory (reading dir names)
	$modules_dir = @ opendir(MOD_DIR);

	if ($modules_dir) {
		while (($file = readdir($modules_dir)) !== false ) {
			if (substr($file, 0, 1) == '.')
				continue;
			if (is_dir( MOD_DIR.'/'.$file )) {
				$modules_subdir = @ opendir( MOD_DIR.'/'.$file );
				if ($modules_subdir && $file != 'Index') {
					$module_files['public'][] = $file;
					closedir( $modules_subdir );
				}
			} else {
				// In $other_files array goes all the files that stored in modules folder directly, without subdir - just to handle them too
				if ( substr($file, -4) == '.php' && $file != 'index.php')
					$module_files['other'][] = $file;
			}
		}
		closedir($modules_dir);
	}
	
	// Files in admin directory - for autoadding links for module settings
	$modules_dir = @ opendir(ADMIN_DIR);
	
	if ($modules_dir) {
		while (($file = readdir($modules_dir)) !== false ) {
			if (substr($file, 0, 1) == '.')
				continue;
			if (is_dir( ADMIN_DIR.'/'.$file )) {
				$modules_subdir = @ opendir( ADMIN_DIR.'/'.$file );
				if ($modules_subdir && $file != 'Index') {
					$module_files['admin'][] = $file;
					closedir( $modules_subdir );
				}
			}
		}
		closedir($modules_dir);
	}
	
	if (empty($module_files))
		return;
		
	// Getting full information about plugin, parsing its headers and assigning in array as a module name.
	// To get full info about this plugin, you need to call $var['module'][$module_name], where $module_name is module's dir.
	if ($fullinfo) {
		foreach ($module_files['public'] as $module_file) {
			if( $data = get_module_data(MOD_DIR.'/'.$module_file.'/index.php') ) {
				$module_files['module'][$module_file] = $data;
			}
		}
	}

	return $module_files;
}

/**
 * Ported from Wordpress wp-includes/functions.php:3294
 * Retrieve metadata from a file.
 * Slightly modificated for ezRPG
 */
function get_file_data( $file, $default_headers, $context = '' ) {
	// We don't need to write to the file, so just open for reading.
	$fp = fopen( $file, 'r' );

	// Pull only the first 4kiB of the file in.
	$file_data = fread( $fp, 4096 );

	// PHP will close file handle, but we are good citizens.
	fclose( $fp );

	// Make sure we catch CR-only line endings.
	$file_data = str_replace( "\r", "\n", $file_data );

	$all_headers = $default_headers;

	foreach ( $all_headers as $field => $regex ) {
		if ( preg_match( '/^[ \t\/*#@]*' . preg_quote( $regex, '/' ) . ':(.*)$/mi', $file_data, $match ) && $match[1] )
			$all_headers[ $field ] = htmlentities(trim($match[1]));
		else
			$all_headers[ $field ] = '';
	}

	return $all_headers;
}

/**
 * Parse the module contents to retrieve module's metadata.
 * Ported from Wordpress wp-admin/includes/plugin.php:72
 * Slightly modificated for ezRPG
 */
function get_module_data( $module_file, $markup = true, $translate = true ) {

	$default_headers = array(
		'Name' => 'Module Name',
		'ModuleURI' => 'Module URI',
		'Version' => 'Version',
		'Package' => 'Package',
		'Description' => 'Description',
		'Author' => 'Author',
		'AuthorURI' => 'Author URI'
	);

	$module_data = get_file_data( $module_file, $default_headers, 'module' );

	/*if ( $markup || $translate ) { // For later translation usage
		$plugin_data = _get_plugin_data_markup_translate( $plugin_file, $plugin_data, $markup, $translate );
	}*/

	return $module_data;
}

/**
 * Sanitizes plugin data, optionally adds markup, optionally translates.
 * Ported from Wordpress wp-admin/includes/plugin.php:115
 * Modificated for ezRPG
 */
function _get_plugin_data_markup_translate( $plugin_file, $plugin_data, $markup = true, $translate = true ) {
	return $plugin_data;
}

?>