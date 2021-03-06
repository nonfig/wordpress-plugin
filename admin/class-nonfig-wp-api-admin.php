<?php


/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.nonfig.com
 * @since      1.0.0
 *
 * @package    Nonfig_Wp_Api
 * @subpackage Nonfig_Wp_Api/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Nonfig_Wp_Api
 * @subpackage Nonfig_Wp_Api/admin
 * @author     Nonfig <hello@nonfig.com>
 */
class Nonfig_Wp_Api_Admin {



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
	 * The options name to be used in this plugin
	 *
	 * @since   1.0.0
	 * @access  private
	 * @var     string      $option_name    Option name of this plugin
	 */
	private $option_name = 'nonfig_wp_api';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		// phpcs:ignore
		wp_enqueue_style(
			'google-fonts',
			'https://fonts.googleapis.com/icon?family=Material+Icons',
			array()
		);
		wp_enqueue_style( 'materialize', plugin_dir_url( __FILE__ ) . 'css/materialize.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/nonfig-wp-api-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'lodash', plugin_dir_url( __FILE__ ) . 'js/lodash.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'materialize', plugin_dir_url( __FILE__ ) . 'js/materialize.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/nonfig-wp-api-admin.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * This function introduces the theme options into the 'Appearance' menu and into a top-level
	 * 'WPPB Demo' menu.
	 */
	public function setup_plugin_options_menu() {
		add_options_page(
			'Nonfig Page',
			'Nonfig - Manage',
			'manage_options',
			'nonfig_wp_api_options',
			array( $this, 'render_settings_page_content' )
		);
	}
	/**
	 * Provides default values for the Display Options.
	 *
	 * @return array
	 */
	public function default_api_key_option() {
		$defaults = array(
			'app_id'         => '',
			'app_secret'     => '',
			'cache_active'   => '',
			'last_cache'     => '',
			'next_cache'     => '',
			'cache_duration' => '',
		);
		return $defaults;
	}

	public function render_settings_page_content( $active_tab = '' ) {
		require_once plugin_dir_path( dirname( __FILE__ ) ) .
			'admin/partials/nonfig-wp-api-admin-display.php';
	}

	public function general_options_callback() {    }

	/**
	 * Initializes the theme's display options page by registering the Sections,
	 * Fields, and Settings.
	 *
	 * This function is registered with the 'admin_init' hook.
	 */
	public function initialize_api_key_option() {
		// If the theme options don't exist, create them.
		if ( false === get_option( 'nonfig_api_key_option' ) ) {
			$default_array = $this->default_api_key_option();
			add_option( 'nonfig_api_key_option', $default_array );
		}

		add_settings_section(
			'general_settings_section',                  // ID used to identify this section and with which to register options
			__( 'Setup Consumer Credential', 'nonfig_wp_api' ),            // Title to be displayed on the administration page
			array( $this, 'general_options_callback' ),      // Callback used to render the description of the section
			'nonfig_api_key_option'                    // Page on which to add this section of options
		);

		// Next, we'll introduce the fields for toggling the visibility of content elements.
		add_settings_field(
			'app_id_field',                    // ID used to identify the field throughout the theme
			__( 'Application ID', 'nonfig_wp_api' ),          // The label to the left of the option interface element
			array( $this, 'app_id_callback' ),  // The name of the function responsible for rendering the option interface
			'nonfig_api_key_option',              // The page on which this option will be displayed
			'general_settings_section',              // The name of the section to which this field belongs
			array(                        // The array of arguments to pass to the callback. In this case, just a description.
				__( 'Activate this setting to display the header.', 'nonfig_wp_api' ),
			)
		);

		add_settings_field(
			'app_secret_field',
			__( 'Application Secret', 'nonfig_wp_api' ),
			array( $this, 'app_secret_callback' ),
			'nonfig_api_key_option',
			'general_settings_section',
			array(
				__( 'Activate this setting to display the content.', 'nonfig_wp_api' ),
			)
		);

		add_settings_field(
			'cache_active_field',
			__( 'Enable Cache', 'nonfig_wp_api' ),
			array( $this, 'cache_active_callback' ),
			'nonfig_api_key_option',
			'general_settings_section',
			array(
				__( 'Activate this setting to display the content.', 'nonfig_wp_api' ),
			)
		);

		add_settings_field(
			'cache_duration_field',
			__( 'Cache Duration (sec)', 'nonfig_wp_api' ),
			array( $this, 'cache_duration_callback' ),
			'nonfig_api_key_option',
			'general_settings_section',
			array(
				__( 'Activate this setting to display the content.', 'nonfig_wp_api' ),
			)
		);
		// Finally, we register the fields with WordPress
		register_setting(
			'nonfig_api_key_option',
			'nonfig_api_key_option'
		);
	}

	public function app_id_callback() {
		$options = get_option( 'nonfig_api_key_option' );
		$app_id  = '';

		if ( isset( $options['app_id'] ) ) {
			$app_id = $options['app_id'];
		}
		?>

		<input
			style="width: 60%;"
			type="text"
			id="fieldAppId"
			name="nonfig_api_key_option[app_id]"
			value="<?php echo esc_html( $app_id ); ?>" />
		<?php
	}

	public function app_secret_callback() {
		$options    = get_option( 'nonfig_api_key_option' );
		$app_secret = '';

		if ( isset( $options['app_secret'] ) ) {
			$app_secret = $options['app_secret'];
		}
		?>

		<input
			type="text"
			style="width: 60%;"
			id="fieldAppSecret"
			name="nonfig_api_key_option[app_secret]"
			value="<?php echo esc_html( $app_secret ); ?>"
			/>
		<?php
	}

	public function cache_active_callback() {
		$options     = get_option( 'nonfig_api_key_option' );
		$valu        = '';
		$curent_time = microtime( true );
		if ( isset( $options['cache_active'] ) ) {
			$valu = $options['cache_active'];
		}

		if ( isset( $options['last_cache'] ) ) {
			$last_cache = $options['last_cache'];
		} // end if

		if ( ( microtime( true ) - $last_cache ) < 100 ) {
			global $wpdb;
			$table_name = 'nonfig_' . $wpdb->prefix . 'cache';
			$wpdb->query( $wpdb->prepare( 'TRUNCATE TABLE %s', array( $table_name ) ) );
		}

		// Render the output
		?>
		<label>
			<input
				type="checkbox"
				id="fieldCacheActive"
				checked="<?php esc_html( $options['cache_active'] ); ?>"
				name="nonfig_api_key_option[cache_active]"
				value="1" />
		<span>Active</span>
		<?php
		if ( $valu ) {
			?>
			<style>
				#wpbody-content.loading form {
					position: relative;
				}

				#wpbody-content.loading form:before {
					content: '';
					position: absolute;
					left: 0;
					right: 0;
					top: 0;
					bottom: 0;
					background: #f1f1f1b8;
					z-index: 100;
				}
			</style>
			<script>
				jQuery(function($) {
					var curTime = <?php echo esc_html( $curent_time ); ?>,
						cacheDur = <?php echo esc_html( $options['cache_duration'] ); ?>;
					$('.clearcache').on('click', function() {
						curTime = Date.now() / 1000;
						$('#wpbody-content').addClass('loading');
						$('#fieldLastCache').val(curTime);
						$('#fieldNextCache').val(curTime + (cacheDur / 1000));
						setTimeout(function() {
							$('.submit input').trigger('click');
						}, 2000);
					});
				});
			</script>
			<?php
		}
	}
	public function cache_duration_callback() {
		$options = get_option( 'nonfig_api_key_option' );
		$valu    = '';

		if ( isset( $options['cache_duration'] ) ) {
			$valu = $options['cache_duration'];
		} // end if
		// Render the output

		?>
		<input
			type="range"
			style="width: 60%"
			min="30" max="300"
			id="fieldCacheDuration"
			name="nonfig_api_key_option[cache_duration]"
			value="<?php echo esc_html( $valu ); ?>"
		/>
		<strong><span id="fieldCacheDurationOutput"><?php echo esc_html( $valu ); ?></span></strong>
		<script>
			jQuery(function($) {
				var $elemFieldCacheDuration = $('#fieldCacheDuration');

				$elemFieldCacheDuration.on('change', function() {
					$('#fieldCacheDurationOutput').text($elemFieldCacheDuration.val());
				})


				console.log($elemFieldCacheDuration)
			})
		</script>

		<?php
	}

	public function initialize_content_options() {  }

	/**
	 * Sanitization callback for the social options. Since each of the social options are text inputs,
	 * this function loops through the incoming option and strips all tags and slashes from the value
	 * before serializing it.
	 *
	 * @params  $input  The unsanitized collection of options.
	 *
	 * @returns      The collection of sanitized values.
	 */
	public function sanitize_content_options( $input ) {
		// Define the array for the updated options
		$output = array();
		// Loop through each of the options sanitizing the data
		foreach ( $input as $key => $val ) {
			if ( isset( $input[ $key ] ) ) {
				$output[ $key ] = esc_url_raw( wp_strip_all_tags( stripslashes( $input[ $key ] ) ) );
			} // end if
		} // end foreach
		// Return the new collection
		return apply_filters( 'sanitize_content_options', $output, $input );
	} // end sanitize_content_options
	public function validate_input_examples( $input ) {
		// Create our array for storing the validated options
		$output = array();
		// Loop through each of the incoming options
		foreach ( $input as $key => $value ) {
			// Check to see if the current option has a value. If so, process it.
			if ( isset( $input[ $key ] ) ) {
				// Strip all HTML and PHP tags and properly handle quoted strings
				$output[ $key ] = wp_strip_all_tags( stripslashes( $input[ $key ] ) );
			} // end if
		} // end foreach
		// Return the array processing any additional functions filtered by this action
		return apply_filters( 'validate_input_examples', $output, $input );
	} // end validate_input_examples
}
