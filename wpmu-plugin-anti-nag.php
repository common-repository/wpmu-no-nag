<?php
/*
Plugin Name: Remove WPMU Dashboard Notification Nag
Plugin URI: http://www.protospace.com/wpmu-no-nag-plugin/
Description: WPMU wants everyone that uses their plugins to use their Dashboard Notification plugin.  It is annoying, especially if you use their plugins for your client sites or just bought one plugin or theme for your own site. This removes that annoying piece.  If you install the dashboard, you'll need to remove this or the dashboard will break. | If you like it, consider <a href="http://www.protospace.com/wpmu-no-nag-plugin/">Donating</a>.  Thank you very much!
Version: 1.2.1
Author: Paul Hirst
Author URI: http://protospace.com
License: GPLv2 or later
*/

/* Legacy remove update */

class WPMUDEV_Update_Notifications {
        public function __construct()
        {
        }

    }
    
class WPMUDEV_Dashboard {
      public function __construct()
      {
      }
      }

if ( class_exists('WPMUDEV_Dashboard_Notice3') ) {

   remove_action( 'all_admin_notices', array( $WPMUDEV_Dashboard_Notice3, 'activate_notice' ), 10 );
   remove_action( 'all_admin_notices', array( $WPMUDEV_Dashboard_Notice3, 'install_notice' ), 10 );
}


function load_custom_wp_admin_style() {
        wp_register_style( 'custom_wp_admin_css', plugin_dir_url( __FILE__ ) . '/wpmu-plugin-anti-nag.css', false, '1.0.0' );
        wp_enqueue_style( 'custom_wp_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style');

function my_plugin_load_last()
{
	$path = str_replace( WP_PLUGIN_DIR . '/', '', __FILE__ );
	if ( $plugins = get_option( 'active_plugins' ) ) {
		if ( $key = array_search( $path, $plugins ) ) {
			array_splice( $plugins, $key, 9999 );
			array_unshift( $plugins, $path );
			update_option( 'active_plugins', $plugins );
		}
	}
}


add_action( 'activated_plugin', 'my_plugin_load_last' );

?>