<?php
/**
 * Plugin activation.
 *
 * @package BeerJournal
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class BJ_Activator
 */
class BJ_Activator {

	/**
	 * Run on activation.
	 *
	 * @return void
	 */
	public static function activate() {
		BJ_Settings::ensure_defaults();
		BJ_DB_Install::maybe_add_indexes();
		flush_rewrite_rules();
		do_action( 'bj_plugin_activated' );
	}
}
