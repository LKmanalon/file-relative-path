<?php

/**
 * @package File Relative Path
 * @version 1.0
 */

/**
 * Plugin Name: File Relative Path
 * Plugin URI: http://wordpress.org/plugins/file-relative-path/
 * Description: Manage all your file path to relative format.
 * Author: Leandro Keene C. Manalon
 * Version: 1.0
 * Author URI: https://lkmanalon.github.io/
 * Text Domain: file-relative-path
 * abcde
 */

/**
 * Disabled Direct Access
 */

defined( 'ABSPATH') or die ( 'No Permision in this Pages!');

if(!function_exists('get_plugin_data')) require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
require_once( ABSPATH . "wp-includes/pluggable.php" );
require_once( trailingslashit(realpath(plugin_dir_path(__FILE__)))."admin/define.php" );
require_once FRP_REALPATH. 'admin/main.php';
