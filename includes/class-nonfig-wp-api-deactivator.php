<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://webstalk.net/
 * @since      1.0.0
 *
 * @package    Nonfig_Wp_Api
 * @subpackage Nonfig_Wp_Api/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Nonfig_Wp_Api
 * @subpackage Nonfig_Wp_Api/includes
 * @author     Nonfig <hello@nonfig.com>
 */
class Nonfig_Wp_Api_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

	}

	public static function nonfig_cache_db_uninstall() {
		global $wpdb;
		$table_name = 'nonfig_' . $wpdb->prefix . 'cache';
		$wpdb->query( "DROP TABLE IF EXISTS {$table_name}" );
	}

}
