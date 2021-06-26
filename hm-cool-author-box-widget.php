<?php
/**
 * Plugin Name: 	Cool Author Box
 * Plugin URI:		https://wordpress.org/plugins/hm-cool-author-box-widget/
 * Description: 	This plugin display an author box to your theme sidebar/widget area or Post/Page section.
 * Version: 		2.5
 * Author: 			HM Plugin
 * Author URI: 		https://hmplugin.com
 * Text Domain: 	wp-cool-author-box
 * License:         GPLv2 or later
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined( 'WPINC' ) ) { die; }
if ( ! defined('ABSPATH') ) { exit; }

define( 'HMCABW_PATH', plugin_dir_path( __FILE__ ) );
define( 'HMCABW_ASSETS', plugins_url( '/assets/', __FILE__ ) );
define( 'HMCABW_LANG', plugins_url( '/languages/', __FILE__ ) );
define( 'HMCABW_SLUG', plugin_basename( __FILE__ ) );
define( 'HMCABW_PREFIX', 'hmcabw_' );
define( 'HMCABW_CLASSPREFIX', 'cls-hmcab-' );
define( 'HMCABW_TXT_DOMAIN', 'hm-cool-author-box-widget' );
define( 'HMCABW_VERSION', '2.5' );

require_once HMCABW_PATH . 'inc/' . HMCABW_CLASSPREFIX . 'master.php';
$hmcabw = new HMCABW_Master();
$hmcabw->hmcabw_run();

