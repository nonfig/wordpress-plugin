<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://webstalk.net/
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
 * @author     Azim Khan <akhan_24@hotmail.com>
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
     * @since  	1.0.0
     * @access 	private
     * @var  	string 		$option_name 	Option name of this plugin
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
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/nonfig-wp-api-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/nonfig-wp-api-admin.js', array( 'jquery' ), $this->version, false );

	}

    /**
     * This function introduces the theme options into the 'Appearance' menu and into a top-level
     * 'WPPB Demo' menu.
     */
    public function setup_plugin_options_menu() {
        //Add the menu to the Plugins set of menu items
        /*
        add_plugins_page(
            'WPPB Demo Options',           // The title to be displayed in the browser window for this page.
            'WPPB Demo Options',          // The text to be displayed for this menu item
            'manage_options',          // Which type of users can see this menu item
            'nonfig_wp_api_options',      // The unique ID - that is, the slug - for this menu item
            array( $this, 'render_settings_page_content')        // The name of the function to call when rendering this menu's page
        );
        */
        add_options_page( 'Nonfig Page', 'Nonfig - Manage', 'manage_options', 'nonfig_wp_api_options', array( $this, 'render_settings_page_content') );
    }
    /**
     * Provides default values for the Display Options.
     *
     * @return array
     */
    public function default_api_key_option() {
        $defaults = array(
            'app_id'    =>  '',
            'app_secret'    =>  '',
        );
        return $defaults;
    }

    /**
     * Renders a simple page to display for the theme menu defined above.
     */
    public function render_settings_page_content( $active_tab = '' ) {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/nonfig-wp-api-admin-display.php';
    }
    /**
     * This function provides a simple description for the General Options page.
     *
     * It's called from the 'wppb-demo_initialize_theme_options' function by being passed as a parameter
     * in the add_settings_section function.
     */
    public function general_options_callback() {
//        $options = get_option('nonfig_api_key_option');
//        var_dump($options);
//        echo '<p>' . __( 'Select which areas of content you wish to display.', 'nonfig_wp_api' ) . '</p>';
    }
    /**
     * Initializes the theme's display options page by registering the Sections,
     * Fields, and Settings.
     *
     * This function is registered with the 'admin_init' hook.
     */
    public function initialize_api_key_option() {
        // If the theme options don't exist, create them.
        if( false == get_option( 'nonfig_api_key_option' ) ) {
            $default_array = $this->default_api_key_option();
            add_option( 'nonfig_api_key_option', $default_array );
        }
        add_settings_section(
            'general_settings_section',                  // ID used to identify this section and with which to register options
            __( 'Setup Consumer Credential', 'nonfig_wp_api' ),            // Title to be displayed on the administration page
            array( $this, 'general_options_callback'),      // Callback used to render the description of the section
            'nonfig_api_key_option'                    // Page on which to add this section of options
        );
        // Next, we'll introduce the fields for toggling the visibility of content elements.
        add_settings_field(
            'show_header',                    // ID used to identify the field throughout the theme
            __( 'Application ID', 'nonfig_wp_api' ),          // The label to the left of the option interface element
            array( $this, 'app_id_callback'),  // The name of the function responsible for rendering the option interface
            'nonfig_api_key_option',              // The page on which this option will be displayed
            'general_settings_section',              // The name of the section to which this field belongs
            array(                        // The array of arguments to pass to the callback. In this case, just a description.
                __( 'Activate this setting to display the header.', 'nonfig_wp_api' ),
            )
        );
        add_settings_field(
            'show_content',
            __( 'Application Secret', 'nonfig_wp_api' ),
            array( $this, 'app_secret_callback'),
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
        // First, we read the social options collection
        $options = get_option( 'nonfig_api_key_option' );
        // Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.
        $valu = '';
        if( isset( $options['app_id'] ) ) {
            $valu = $options['app_id'];
        } // end if
        // Render the output
        echo '<input type="text" id="twitter" name="nonfig_api_key_option[app_id]" value="' . $valu . '" />';
    }
    public function app_secret_callback() {
        // First, we read the social options collection
        $options = get_option( 'nonfig_api_key_option' );
        // Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.
        $valu = '';
        if( isset( $options['app_secret'] ) ) {
            $valu = $options['app_secret'];
        } // end if
        // Render the output
        echo '<input type="text" id="twitter" name="nonfig_api_key_option[app_secret]" value="' . $valu . '" />';
    }

    /**
     * Initializes the theme's social options by registering the Sections,
     * Fields, and Settings.
     *
     * This function is registered with the 'admin_init' hook.
     */
    public function initialize_content_options() {

    }



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
        foreach( $input as $key => $val ) {
            if( isset ( $input[$key] ) ) {
                $output[$key] = esc_url_raw( strip_tags( stripslashes( $input[$key] ) ) );
            } // end if
        } // end foreach
        // Return the new collection
        return apply_filters( 'sanitize_content_options', $output, $input );
    } // end sanitize_content_options
    public function validate_input_examples( $input ) {
        // Create our array for storing the validated options
        $output = array();
        // Loop through each of the incoming options
        foreach( $input as $key => $value ) {
            // Check to see if the current option has a value. If so, process it.
            if( isset( $input[$key] ) ) {
                // Strip all HTML and PHP tags and properly handle quoted strings
                $output[$key] = strip_tags( stripslashes( $input[ $key ] ) );
            } // end if
        } // end foreach
        // Return the array processing any additional functions filtered by this action
        return apply_filters( 'validate_input_examples', $output, $input );
    } // end validate_input_examples






}
