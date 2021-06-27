<?php
/**
 * Plugin Name: 	Cool Author Box
 * Plugin URI:		https://wordpress.org/plugins/hm-cool-author-box-widget/
 * Description: 	This plugin display an author box to your theme sidebar/widget area or Post/Page section.
 * Version: 		  2.5
 * Author: 			  HM Plugin
 * Author URI: 		https://hmplugin.com
 * License:       GPLv2 or later
 * License URI:   http://www.gnu.org/licenses/gpl-2.0.html
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

// Donate link to plugin description
function hmcab_display_donation_link_to_plugin_meta( $links, $file ) {

    if ( HMCABW_SLUG === $file ) {
        $row_meta = array(
          'hmcab_donation'  => '<a href="' . esc_url( 'https://www.paypal.me/mhmrajib/' ) . '" target="_blank" aria-label="' . esc_attr__( 'Donate us', HMCABW_TXT_DOMAIN ) . '" style="color:green; font-weight: bold;">' . esc_html__( 'Donate us', HMCABW_TXT_DOMAIN ) . '</a>'
        );
 
        return array_merge( $links, $row_meta );
    }
    return (array) $links;
}
add_filter( 'plugin_row_meta', 'hmcab_display_donation_link_to_plugin_meta', 10, 2 );