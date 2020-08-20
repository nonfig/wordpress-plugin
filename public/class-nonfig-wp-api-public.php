<?php

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'nonfig-php-sdk/index.php';


/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://webstalk.net/
 * @since      1.0.0
 *
 * @package    Nonfig_Wp_Api
 * @subpackage Nonfig_Wp_Api/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Nonfig_Wp_Api
 * @subpackage Nonfig_Wp_Api/public
 * @author     Nonfig <hello@nonfig.com>
 */
class Nonfig_Wp_Api_Public {
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Nonfig_Wp_Api_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Nonfig_Wp_Api_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'css/nonfig-wp-api-public.css',
			array(),
			$this->version,
			'all'
		);
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'js/nonfig-wp-api-public.js',
			array( 'jquery' ),
			$this->version,
			false
		);
	}

	public function nonfig_content_shortcode() {
		add_shortcode( 'nonfig', array( $this, 'nonfig_shortcode_function' ) );
	}

	public function nonfig_shortcode_function( $atts = array(), $defaultContent = null ) {
		// set up default parameters
		extract(
			shortcode_atts(
				array(
					'id'         => '',
					'full-name'  => '',
					'keypath'    => '',
					'param-type' => '',
					'fields'     => '',
				),
				$atts
			)
		);
		$nonfig_api_keys = get_option( 'nonfig_api_key_option' );

		if (
			! empty( $nonfig_api_keys['app_id'] ) &&
			! empty( $nonfig_api_keys['app_secret'] )
		) {

			$nonfig             = new Nonfig( $nonfig_api_keys['app_id'], $nonfig_api_keys['app_secret'] );
			$isCacheActive      = $nonfig_api_keys['cache_active'];
			$hasToUpdate        = ( $nonfig_api_keys['next_cache'] < microtime( true ) );
			$data_present_in_db = false;

			// Update Date
			$hasToUpdate = true;

			global $wpdb;
			$table_name   = 'nonfig_' . $wpdb->prefix . 'cache';
			$stringoutput = $defaultContent;

			// when render by id
			if ( ! empty( $atts['id'] ) ) {
				try {
					if ( $isCacheActive && ! $hasToUpdate ) {
						$stringoutput = $this->cache_table_get( $atts, 'get', '' );
					} else {
						$configPath   = $nonfig->findConfigurationById( $atts['id'] );
						$stringoutput = $this->cache_table_get( $atts, 'add', $configPath );
					}

					return $this->formatOutput( $stringoutput, $atts );
				} catch ( Exception $e ) {
					error_log( $e->getMessage() );
				}
			}

			// when render by full name
			if ( ! empty( $atts['full-name'] ) ) {

				try {
					if ( $isCacheActive && ! $hasToUpdate ) {
						$stringoutput = $this->cache_table_get( $atts, 'get', '' );
					} else {
						$configPath   = $nonfig->findConfigurationByName( $atts['full-name'] );
						$stringoutput = $this->cache_table_get( $atts, 'add', $configPath );
					}

					return $this->formatOutput( $stringoutput, $atts );
				} catch ( Exception $e ) {
					error_log( $e->getMessage() );
				}
			}

			// when render by param type
			if ( ! empty( $atts['param-type'] ) ) {
				if (
					$atts['param-type'] == 'query' &&
					! empty( $atts['field'] )
				) {
					try {

						if ( $isCacheActive && ! $hasToUpdate ) {
							$stringoutput = $this->cache_table_get( $atts, 'get', '' );
						} else {
							$paramval   = sanitize_text_field( $_GET[ $atts['field'] ] );
							$configsArr = $nonfig->findConfigurationByLabels( $paramval );

							if ( count( $configsArr ) ) {
								$configPath   = $configsArr[0];
								$stringoutput = $this->cache_table_get( $atts, 'add', $configPath );
							}
						}

						return $this->formatOutput( $stringoutput, $atts );
					} catch ( Exception $e ) {
						error_log( $e->getMessage() );
					}
				}
			}

			return $defaultContent;
		} else {
			$message = 'Nonfig: Please set API Key and API Secret first to continue';
			error_log( $message );

			return $message;
		}
	}

	public function formatOutput( $content, $atts ) {
		return '<span class="nonfig__content">' . $content . '</span>';
	}

	public function keypath_filter( $data, $keypath ) {
		//        require_once plugin_dir_path(dirname(__FILE__)) . 'vendor/nonfig/php-sdk/index.php';

		// TODO - Cache Impemetation Goes Here

		$jsonoutput = json_decode( $data );
		/*if(strpos($keypath, '.')>=0){
				$stringoutput = get($jsonoutput, $keypath, "default");
			}
			else{

			}*/
		$stringoutput = $jsonoutput->{$keypath};

		/*foreach($jsonoutput as $keyp=>$item){
				if(strpos($atts['keypath'], '.')>=0){
					$arrayobj = explode('.',$atts['keypath']);
					foreach($arrayobj as $initem){

					}
				}
				else if($keyp==$atts['keypath']){$stringoutput=$item;}

			}*/

		return $stringoutput;
	}

	public function update_next_cache() {
		$nonfig_api_key_option               = get_option( 'nonfig_api_key_option' );
		$lastCache                           = microtime( true );
		$nextCache                           = $lastCache + ( $nonfig_api_key_option['cache_duration'] / 1000 );
		$nonfig_api_key_option['last_cache'] = $lastCache;
		$nonfig_api_key_option['next_cache'] = $nextCache;
		update_option( 'nonfig_api_key_option', $nonfig_api_key_option );
	}

	public function cache_table_get( $atts, $method, $configData ) {
		$table_data_label = '';

		if ( ! empty( $atts['id'] ) ) {
			$table_data_label = 'id:' . $atts['id'];
		}

		if ( ! empty( $atts['full-name'] ) ) {
			$table_data_label = 'full-name:' . $atts['full-name'];
		}

		if ( $atts['param-type'] == 'query' && ! empty( $atts['field'] ) ) {
			$table_data_label = 'query:' . sanitize_text_field( $_GET[ $atts['field'] ] );
		}

		if ( ! empty( $atts['keypath'] ) ) {
			$table_data_label = $table_data_label . ',keypath:' . $atts['keypath'];
		}

		$table_data_label = explode( '/', $table_data_label );
		$table_data_label = join( '-', $table_data_label );

		global $wpdb;
		$table_name    = 'nonfig_' . $wpdb->prefix . 'cache';
		$retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name" );
		$retval        = '';
		foreach ( $retrieve_data as $itm ) {
			if ( $itm->config_name == $table_data_label ) {
				$retval = $itm;
			}
		}

		if ( $method == 'get' ) {
			if ( ! empty( $retval ) ) {
				$stringoutput = $retval->config_path;
				return $stringoutput . ' - From table';
			}
		}

		if ( $method == 'add' ) {

			$config_id    = $configData->id;
			$stringoutput = $configData->data;
			if ( ! empty( $atts['keypath'] ) && $configData->type == 'JSON' ) {
				$stringoutput = $this->keypath_filter( $stringoutput, $atts['keypath'] );
			}
			$table_data_data = $stringoutput;

			if ( empty( $retval ) ) {
				$wpdb->insert(
					$table_name,
					array(
						'createdAt'   => current_time( 'mysql' ),
						'config_name' => $table_data_label,
						'config_path' => $table_data_data,
						'config_id'   => $config_id,
					)
				);
			} else {
				$wpdb->update(
					$table_name,
					array(
						'createdAt'   => current_time( 'mysql' ),
						'config_path' => $table_data_data,
					),
					array(
						'id' => $retval->id,
					)
				);
			}

			return $table_data_data;
		}
	}
}
