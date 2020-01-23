<?php

/**
 * Disabled Direct Access
 */

defined( 'ABSPATH') or die ( 'No Permision in this Pages!');

/**
* Define_constants
*/
define('FRP_PLUGIN', 'file-relative-path');

/**
 * Define Constant Directory Paths
 */
 define('FRP_REALPATH', trailingslashit(realpath(plugin_dir_path(__DIR__))) );
 define('FRP_PATH', plugin_dir_path( __FILE__ ));
 define('FRP_ABSPATH', trailingslashit(plugin_dir_url(__DIR__)));
 define("FRP_CSS_JQUERY", trailingslashit(plugin_dir_url(basename(__DIR__)).FRP_PLUGIN));
 define("FRP_PLUGIN_PATH", admin_url('tools.php?page=').FRP_PLUGIN);

 /**
  * Plugin Information
  */
  define("FRP_NAME", get_plugin_data( realpath(FRP_REALPATH)."/".FRP_PLUGIN.".php")['Name']);
  define("FRP_URI", get_plugin_data( realpath(FRP_REALPATH)."/".FRP_PLUGIN.".php")['PluginURI']);
  define("FRP_VERSION", get_plugin_data( realpath(FRP_REALPATH)."/".FRP_PLUGIN.".php")['Version']);
  define("FRP_DETAILS", GET_PLUGIN_DATA( realpath(FRP_REALPATH)."/".FRP_PLUGIN.'.php')['Description']);
