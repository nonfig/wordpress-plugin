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




	    // Drop table
        global $wpdb;
        $table_name = 'nonfig_' . $wpdb->prefix . "cache";
        $wpdb->query( "DROP TABLE IF EXISTS {$table_name}" );

        // Remove API Keys
        $nonfig_api_key_option = get_option('nonfig_api_key_option');
        $nonfig_api_key_option['app_id']='';
        $nonfig_api_key_option['app_secret']='';
        $nonfig_api_key_option['cache_active']='';
        $nonfig_api_key_option['cache_duration']=0;
        update_option('nonfig_api_key_option', $nonfig_api_key_option);

	}



}
