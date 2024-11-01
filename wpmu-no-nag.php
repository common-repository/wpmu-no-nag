<?php
/*
Plugin Name: Remove WPMU Dashboard Notification Nag
Plugin URI: http://www.protospace.com/wpmu-no-nag-plugin/
Description: WPMU wants everyone that uses their plugins to use their Dashboard Notification plugin.  It is annoying, especially if you use their plugins for your client sites or just bought one plugin or theme for your own site. This removes that annoying piece.  If you install the dashboard, you'll need to remove this or the dashboard will break. | If you like it, consider <a href="http://www.protospace.com/wpmu-no-nag-plugin/">Donating</a>.  Thank you very much!
Version: 1.3.0
Author: Paul Hirst
Author URI: http://protospace.com
License: GPLv2 or later
*/

/* Legacy remove update */


if (!class_exists('WPMUDEV_Update_Notifications')) {
  class WPMUDEV_Update_Notifications {
        public function __construct() {}
    }
  }

if ( !class_exists('WPMUDEV_Dashboard') ) {
    class WPMUDEV_Dashboard {
      public function __construct() {}
      }
    }

if ( class_exists('WPMUDEV_Dashboard_Notice3') ) {

   remove_action( 'all_admin_notices', array( $WPMUDEV_Dashboard_Notice3, 'activate_notice' ), 10 );
   remove_action( 'all_admin_notices', array( $WPMUDEV_Dashboard_Notice3, 'install_notice' ), 10 );
} else {
    class WPMUDEV_Dashboard_Notice3 {}
}

function this_plugin_first() {
  // ensure path to this file is via main wp plugin path
  $wp_path_to_this_file = preg_replace('/(.*)plugins\/(.*)$/', WP_PLUGIN_DIR."/$2", __FILE__);
  $this_plugin = plugin_basename(trim($wp_path_to_this_file));
  $active_plugins = get_option('active_plugins');
  $this_plugin_key = array_search($this_plugin, $active_plugins);
  if ($this_plugin_key) { // if it's 0 it's the first plugin already, no need to continue
    array_splice($active_plugins, $this_plugin_key, 1);
    array_unshift($active_plugins, $this_plugin);
    update_option('active_plugins', $active_plugins);
  }
}

add_action("activated_plugin", "this_plugin_first");

?>