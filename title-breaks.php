<?php
/**
 * Plugin Name: Title Breaks
 * Description: Control how your post titles will break
 * Author: MIND
 * Author URI: https://www.mind.ch
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: title-breaks
 * Domain Path: languages/
 * Version: 1.0.0
 */
add_action( 'plugins_loaded', function() {
	load_plugin_textdomain( 'title-breaks', false, basename( dirname( __FILE__ ) ) . '/languages/' );

	if ( ! is_admin() ) {
		require_once 'class-title-breaks.php';

		$title_breaks = new Title_Breaks();
		$title_breaks->init();
	} else {
		require_once 'class-title-breaks-admin.php';

		$title_breaks_admin = new Title_Breaks_Admin();
		$title_breaks_admin->init();
	}
} );
