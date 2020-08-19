<?php

/**
 * Fired during plugin activation
 *
 * @link       http://webstalk.net/
 * @since      1.0.0
 *
 * @package    Nonfig_Wp_Api
 * @subpackage Nonfig_Wp_Api/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Nonfig_Wp_Api
 * @subpackage Nonfig_Wp_Api/includes
 */
class Nonfig_Wp_Api_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {



        global $wpdb;
        $table_name = 'nonfig_' . $wpdb->prefix . "cache";
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
              id mediumint(9) NOT NULL AUTO_INCREMENT,
              config_id varchar(64) NOT NULL default '',
              config_name varchar(128) NOT NULL default '',
              config_path text NOT NULL default '',
              createdAt datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
              PRIMARY KEY  (id)
            ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

	}



    function add_entry(){
        global $wpdb;
        $table_name = 'nonfig_' . $wpdb->prefix . "cache";

        $wpdb->insert(
            $table_name,
            array(
                'time' => current_time( 'mysql' ),
                'nonfig_value' => '',
                'nonfig_result' => '',
            )
        );
    }
}
