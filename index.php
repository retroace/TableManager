<?php 
/*
Plugin Name: Table Manager
Plugin URI:
Description: Manage your database table. Also helps to view different data in the plugin

Author: Rajesh Paudel
*/


define('TABLE_PLUGIN_PATH_URL', plugin_dir_url(__FILE__));
define('TABLE_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('TABLE_PLUGIN_SETTINGS_URL',"?page=managetable");

$plugin = plugin_basename(__FILE__);


require_once (TABLE_PLUGIN_PATH . 'classes/TableManagerConfig.class.php');
require_once (TABLE_PLUGIN_PATH . 'classes/TableDb.class.php');
require_once (TABLE_PLUGIN_PATH . 'classes/TableManager.class.php');

$tableManager = new TableManager();
$tableManager->pluginInit();

register_activation_hook(__FILE__, 'file_plugin_activate');

add_action('admin_init', 'file_plugin_redirect');

function file_plugin_activate() 
{
    add_option('file_plugin_do_activation_redirect', true);
}


function file_plugin_redirect(){
	if (get_option('file_plugin_do_activation_redirect',false)) {
		delete_option('file_plugin_do_activation_redirect');
		wp_redirect(TABLE_PLUGIN_SETTINGS_URL);
	}
}
