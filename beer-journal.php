<?php
/**
 * Plugin Name:       Beer Journal for Untappd
 * Plugin URI:        https://github.com/jaz-on/beer-journal
 * Description:       Sync and display your Untappd beer check-ins on WordPress.
 * Version:           0.1.0
 * Requires at least: 6.0
 * Requires PHP:      8.2
 * Author:            Beer Journal Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       beer-journal
 * GitHub Plugin URI: https://github.com/jaz-on/beer-journal
 * Primary Branch:    dev
 *
 * @package BeerJournal
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'BJ_VERSION', '0.1.0' );
define( 'BJ_PLUGIN_FILE', __FILE__ );
define( 'BJ_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'BJ_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

if ( file_exists( BJ_PLUGIN_DIR . 'vendor/autoload.php' ) ) {
	require_once BJ_PLUGIN_DIR . 'vendor/autoload.php';
}

/**
 * Load plugin text domain.
 */
function bj_load_textdomain() {
	load_plugin_textdomain(
		'beer-journal',
		false,
		dirname( plugin_basename( __FILE__ ) ) . '/languages'
	);
}
add_action( 'plugins_loaded', 'bj_load_textdomain' );
