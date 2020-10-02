<?php
/**
 * Plugin Name: Hello World
 * Description: A demo plugin
 * Author: Sandeep Singh
 * Version: 0.1
 * License: GPLv2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * php version 7.4.2
 * 
 * @category File
 * @package  HelloWorld
 * @author   Sandeep Singh <sandeep.singh.pooni@gmail.com>
 * @license  GPLv2 <https://www.gnu.org/licenses/gpl-2.0.html>
 * @link     n/a
 */

// Make sure we don't expose any info if called directly
if (!function_exists('add_action')) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}


define('HELLOWORLD_VERSION', 0.1);
define('HELLOWORLD__MINIMUM_WP_VERSION', 4.0);
define('HELLOWORLD__PLUGIN_DIR', plugin_dir_path(__FILE__));

require_once HELLOWORLD__PLUGIN_DIR . 'class.helloworld.php';


register_activation_hook(__FILE__, array('HelloWorld', 'pluginActivation'));
register_deactivation_hook(__FILE__, array('HelloWorld', 'pluginDeactivation'));

add_action('init', array('HelloWorld', 'init'));

