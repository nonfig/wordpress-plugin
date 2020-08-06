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
class Nonfig_Wp_Api_Admin
{

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
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

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

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/nonfig-wp-api-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

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

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/nonfig-wp-api-admin.js', array( 'jquery' ), $this->version, false);
    }

    /**
     * This function introduces the theme options into the 'Appearance' menu and into a top-level
     * 'WPPB Demo' menu.
     */
    public function setup_plugin_options_menu()
    {
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
        add_options_page('Nonfig Page', 'Nonfig API', 'manage_options', 'nonfig_wp_api_options', array( $this, 'render_settings_page_content'));
    }
    /**
     * Provides default values for the Display Options.
     *
     * @return array
     */
    public function default_api_key_option()
    {
        $defaults = array(
            'show_header'    =>  '',
            'show_content'    =>  '',
            'show_footer'    =>  '',
        );
        return $defaults;
    }
    /**
     * Provide default values for the Social Options.
     *
     * @return array
     */
    public function default_social_options()
    {
        $defaults = array(
            'twitter'    =>  'twitter',
            'facebook'    =>  '',
            'googleplus'  =>  '',
        );
        return  $defaults;
    }
    /**
     * Provides default values for the Input Options.
     *
     * @return array
     */
    public function default_input_options()
    {
        $defaults = array(
            'input_example'    =>  'default input example',
            'textarea_example'  =>  '',
            'checkbox_example'  =>  '',
            'radio_example'    =>  '2',
            'time_options'    =>  'default'
        );
        return $defaults;
    }
    /**
     * Renders a simple page to display for the theme menu defined above.
     */
    public function render_settings_page_content($active_tab = '')
    {
        ?>
        <!-- Create a header in the default WordPress 'wrap' container -->
        <div class="wrap">
            <h2><?php _e('Nonfig API Options', 'nonfig_wp_api'); ?></h2>
            <?php settings_errors(); ?>
            <?php if (isset($_GET[ 'tab' ])) {
                $active_tab = $_GET[ 'tab' ];
            } elseif ($active_tab == 'social_options') {
                $active_tab = 'social_options';
            } elseif ($active_tab == 'input_examples') {
                $active_tab = 'input_examples';
            } else {
                $active_tab = 'api_key_option';
            } // end if/else ?>
            <h2 class="nav-tab-wrapper">
                <a href="?page=nonfig_wp_api_options&tab=api_key_option" class="nav-tab <?php echo $active_tab == 'api_key_option' ? 'nav-tab-active' : ''; ?>"><?php _e('API Keys', 'nonfig_wp_api'); ?></a>
                <a href="?page=nonfig_wp_api_options&tab=social_options" class="nav-tab <?php echo $active_tab == 'social_options' ? 'nav-tab-active' : ''; ?>"><?php _e('Social Options', 'nonfig_wp_api'); ?></a>
                <a href="?page=nonfig_wp_api_options&tab=input_examples" class="nav-tab <?php echo $active_tab == 'input_examples' ? 'nav-tab-active' : ''; ?>"><?php _e('Input Examples', 'nonfig_wp_api'); ?></a>
            </h2>
            <form method="post" action="options.php">
                <?php
                if ($active_tab == 'api_key_option') {
                    settings_fields('enym_api_key_option');
                    do_settings_sections('enym_api_key_option');
                } elseif ($active_tab == 'social_options') {
                    settings_fields('enym_social_options');
                    do_settings_sections('enym_social_options');
                } else {
                    settings_fields('enym_input_examples');
                    do_settings_sections('enym_input_examples');
                } // end if/else
                submit_button();
                ?>
            </form>
        </div><!-- /.wrap -->
        <?php
    }
    /**
     * This function provides a simple description for the General Options page.
     *
     * It's called from the 'wppb-demo_initialize_theme_options' function by being passed as a parameter
     * in the add_settings_section function.
     */
    public function general_options_callback()
    {
        $options = get_option('enym_api_key_option');
        var_dump($options);
        echo '<p>' . __('Select which areas of content you wish to display.', 'nonfig_wp_api') . '</p>';
    } // end general_options_callback
    /**
     * This function provides a simple description for the Social Options page.
     *
     * It's called from the 'wppb-demo_theme_initialize_social_options' function by being passed as a parameter
     * in the add_settings_section function.
     */
    public function social_options_callback()
    {
        $options = get_option('enym_social_options');
        var_dump($options);
        echo '<p>' . __('Provide the URL to the social networks you\'d like to display.', 'nonfig_wp_api') . '</p>';
    } // end general_options_callback
    /**
     * This function provides a simple description for the Input Examples page.
     *
     * It's called from the 'wppb-demo_theme_initialize_input_examples_options' function by being passed as a parameter
     * in the add_settings_section function.
     */
    public function input_examples_callback()
    {
        $options = get_option('enym_input_examples');
        var_dump($options);
        echo '<p>' . __('Provides examples of the five basic element types.', 'nonfig_wp_api') . '</p>';
    } // end general_options_callback
    /**
     * Initializes the theme's display options page by registering the Sections,
     * Fields, and Settings.
     *
     * This function is registered with the 'admin_init' hook.
     */
    public function initialize_api_key_option()
    {
        // If the theme options don't exist, create them.
        if (false == get_option('enym_api_key_option')) {
            $default_array = $this->default_api_key_option();
            add_option('enym_api_key_option', $default_array);
        }
        add_settings_section(
            'general_settings_section',                  // ID used to identify this section and with which to register options
            __('API Keys Options', 'nonfig_wp_api'),            // Title to be displayed on the administration page
            array( $this, 'general_options_callback'),      // Callback used to render the description of the section
            'enym_api_key_option'                    // Page on which to add this section of options
        );
        // Next, we'll introduce the fields for toggling the visibility of content elements.
        add_settings_field(
            'show_header',                    // ID used to identify the field throughout the theme
            __('Header', 'nonfig_wp_api'),          // The label to the left of the option interface element
            array( $this, 'toggle_header_callback'),  // The name of the function responsible for rendering the option interface
            'enym_api_key_option',              // The page on which this option will be displayed
            'general_settings_section',              // The name of the section to which this field belongs
            array(                        // The array of arguments to pass to the callback. In this case, just a description.
                __('Activate this setting to display the header.', 'nonfig_wp_api'),
            )
        );
        add_settings_field(
            'show_content',
            __('Content', 'nonfig_wp_api'),
            array( $this, 'toggle_content_callback'),
            'enym_api_key_option',
            'general_settings_section',
            array(
                __('Activate this setting to display the content.', 'nonfig_wp_api'),
            )
        );
        add_settings_field(
            'show_footer',
            __('Footer', 'nonfig_wp_api'),
            array( $this, 'toggle_footer_callback'),
            'enym_api_key_option',
            'general_settings_section',
            array(
                __('Activate this setting to display the footer.', 'nonfig_wp_api'),
            )
        );
        // Finally, we register the fields with WordPress
        register_setting(
            'enym_api_key_option',
            'enym_api_key_option'
        );
    } // end wppb-demo_initialize_theme_options
    /**
     * Initializes the theme's social options by registering the Sections,
     * Fields, and Settings.
     *
     * This function is registered with the 'admin_init' hook.
     */
    public function initialize_social_options()
    {
        delete_option('enym_social_options');
        if (false == get_option('enym_social_options')) {
            $default_array = $this->default_social_options();
            update_option('enym_social_options', $default_array);
        } // end if
        add_settings_section(
            'social_settings_section',      // ID used to identify this section and with which to register options
            __('Social Options', 'nonfig_wp_api'),    // Title to be displayed on the administration page
            array( $this, 'social_options_callback'),  // Callback used to render the description of the section
            'enym_social_options'    // Page on which to add this section of options
        );
        add_settings_field(
            'twitter',
            'Twitter',
            array( $this, 'twitter_callback'),
            'enym_social_options',
            'social_settings_section'
        );
        add_settings_field(
            'facebook',
            'Facebook',
            array( $this, 'facebook_callback'),
            'enym_social_options',
            'social_settings_section'
        );
        add_settings_field(
            'googleplus',
            'Google+',
            array( $this, 'googleplus_callback'),
            'enym_social_options',
            'social_settings_section'
        );
        register_setting(
            'enym_social_options',
            'enym_social_options',
            array( $this, 'sanitize_social_options')
        );
    }
    /**
     * Initializes the theme's input example by registering the Sections,
     * Fields, and Settings. This particular group of options is used to demonstration
     * validation and sanitization.
     *
     * This function is registered with the 'admin_init' hook.
     */
    public function initialize_input_examples()
    {
        //delete_option('enym_input_examples');
        if (false == get_option('enym_input_examples')) {
            $default_array = $this->default_input_options();
            update_option('enym_input_examples', $default_array);
        } // end if
        add_settings_section(
            'input_examples_section',
            __('Input Examples', 'nonfig_wp_api'),
            array( $this, 'input_examples_callback'),
            'enym_input_examples'
        );
        add_settings_field(
            'Input Element',
            __('Input Element', 'nonfig_wp_api'),
            array( $this, 'input_element_callback'),
            'enym_input_examples',
            'input_examples_section'
        );
        add_settings_field(
            'Textarea Element',
            __('Textarea Element', 'nonfig_wp_api'),
            array( $this, 'textarea_element_callback'),
            'enym_input_examples',
            'input_examples_section'
        );
        add_settings_field(
            'Checkbox Element',
            __('Checkbox Element', 'nonfig_wp_api'),
            array( $this, 'checkbox_element_callback'),
            'enym_input_examples',
            'input_examples_section'
        );
        add_settings_field(
            'Radio Button Elements',
            __('Radio Button Elements', 'nonfig_wp_api'),
            array( $this, 'radio_element_callback'),
            'enym_input_examples',
            'input_examples_section'
        );
        add_settings_field(
            'Select Element',
            __('Select Element', 'nonfig_wp_api'),
            array( $this, 'select_element_callback'),
            'enym_input_examples',
            'input_examples_section'
        );
        register_setting(
            'enym_input_examples',
            'enym_input_examples',
            array( $this, 'validate_input_examples')
        );
    }
    /**
     * This function renders the interface elements for toggling the visibility of the header element.
     *
     * It accepts an array or arguments and expects the first element in the array to be the description
     * to be displayed next to the checkbox.
     */
    public function toggle_header_callback($args)
    {
        // First, we read the options collection
        $options = get_option('enym_api_key_option');
        // Next, we update the name attribute to access this element's ID in the context of the display options array
        // We also access the show_header element of the options collection in the call to the checked() helper function
        $html = '<input type="checkbox" id="show_header" name="enym_api_key_option[show_header]" value="1" ' . checked(1, isset($options['show_header']) ? $options['show_header'] : 0, false) . '/>';
        // Here, we'll take the first argument of the array and add it to a label next to the checkbox
        $html .= '<label for="show_header"> '  . $args[0] . '</label>';
        echo $html;
    } // end toggle_header_callback
    public function toggle_content_callback($args)
    {
        $options = get_option('enym_api_key_option');
        $html = '<input type="checkbox" id="show_content" name="enym_api_key_option[show_content]" value="1" ' . checked(1, isset($options['show_content']) ? $options['show_content'] : 0, false) . '/>';
        $html .= '<label for="show_content"> '  . $args[0] . '</label>';
        echo $html;
    } // end toggle_content_callback
    public function toggle_footer_callback($args)
    {
        $options = get_option('enym_api_key_option');
        $html = '<input type="checkbox" id="show_footer" name="enym_api_key_option[show_footer]" value="1" ' . checked(1, isset($options['show_footer']) ? $options['show_footer'] : 0, false) . '/>';
        $html .= '<label for="show_footer"> '  . $args[0] . '</label>';
        echo $html;
    } // end toggle_footer_callback
    public function twitter_callback()
    {
        // First, we read the social options collection
        $options = get_option('enym_social_options');
        // Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.
        $url = '';
        if (isset($options['twitter'])) {
            $url = esc_url($options['twitter']);
        } // end if
        // Render the output
        echo '<input type="text" id="twitter" name="enym_social_options[twitter]" value="' . $url . '" />';
    } // end twitter_callback
    public function facebook_callback()
    {
        $options = get_option('enym_social_options');
        $url = '';
        if (isset($options['facebook'])) {
            $url = esc_url($options['facebook']);
        } // end if
        // Render the output
        echo '<input type="text" id="facebook" name="enym_social_options[facebook]" value="' . $url . '" />';
    } // end facebook_callback
    public function googleplus_callback()
    {
        $options = get_option('enym_social_options');
        $url = '';
        if (isset($options['googleplus'])) {
            $url = esc_url($options['googleplus']);
        } // end if
        // Render the output
        echo '<input type="text" id="googleplus" name="enym_social_options[googleplus]" value="' . $url . '" />';
    } // end googleplus_callback
    public function input_element_callback()
    {
        $options = get_option('enym_input_examples');
        // Render the output
        echo '<input type="text" id="input_example" name="enym_input_examples[input_example]" value="' . $options['input_example'] . '" />';
    } // end input_element_callback
    public function textarea_element_callback()
    {
        $options = get_option('enym_input_examples');
        // Render the output
        echo '<textarea id="textarea_example" name="enym_input_examples[textarea_example]" rows="5" cols="50">' . $options['textarea_example'] . '</textarea>';
    } // end textarea_element_callback
    public function checkbox_element_callback()
    {
        $options = get_option('enym_input_examples');
        $html = '<input type="checkbox" id="checkbox_example" name="enym_input_examples[checkbox_example]" value="1"' . checked(1, $options['checkbox_example'], false) . '/>';
        $html .= ' ';
        $html .= '<label for="checkbox_example">This is an example of a checkbox</label>';
        echo $html;
    } // end checkbox_element_callback
    public function radio_element_callback()
    {
        $options = get_option('enym_input_examples');
        $html = '<input type="radio" id="radio_example_one" name="enym_input_examples[radio_example]" value="1"' . checked(1, $options['radio_example'], false) . '/>';
        $html .= ' ';
        $html .= '<label for="radio_example_one">Option One</label>';
        $html .= ' ';
        $html .= '<input type="radio" id="radio_example_two" name="enym_input_examples[radio_example]" value="2"' . checked(2, $options['radio_example'], false) . '/>';
        $html .= ' ';
        $html .= '<label for="radio_example_two">Option Two</label>';
        echo $html;
    } // end radio_element_callback
    public function select_element_callback()
    {
        $options = get_option('enym_input_examples');
        $html = '<select id="time_options" name="enym_input_examples[time_options]">';
        $html .= '<option value="default">' . __('Select a time option...', 'nonfig_wp_api') . '</option>';
        $html .= '<option value="never"' . selected($options['time_options'], 'never', false) . '>' . __('Never', 'nonfig_wp_api') . '</option>';
        $html .= '<option value="sometimes"' . selected($options['time_options'], 'sometimes', false) . '>' . __('Sometimes', 'nonfig_wp_api') . '</option>';
        $html .= '<option value="always"' . selected($options['time_options'], 'always', false) . '>' . __('Always', 'nonfig_wp_api') . '</option>';
        $html .= '</select>';
        echo $html;
    } // end select_element_callback
    /**
     * Sanitization callback for the social options. Since each of the social options are text inputs,
     * this function loops through the incoming option and strips all tags and slashes from the value
     * before serializing it.
     *
     * @params  $input  The unsanitized collection of options.
     *
     * @returns      The collection of sanitized values.
     */
    public function sanitize_social_options($input)
    {
        // Define the array for the updated options
        $output = array();
        // Loop through each of the options sanitizing the data
        foreach ($input as $key => $val) {
            if (isset($input[$key])) {
                $output[$key] = esc_url_raw(strip_tags(stripslashes($input[$key])));
            } // end if
        } // end foreach
        // Return the new collection
        return apply_filters('sanitize_social_options', $output, $input);
    } // end sanitize_social_options
    public function validate_input_examples($input)
    {
        // Create our array for storing the validated options
        $output = array();
        // Loop through each of the incoming options
        foreach ($input as $key => $value) {
            // Check to see if the current option has a value. If so, process it.
            if (isset($input[$key])) {
                // Strip all HTML and PHP tags and properly handle quoted strings
                $output[$key] = strip_tags(stripslashes($input[ $key ]));
            } // end if
        } // end foreach
        // Return the array processing any additional functions filtered by this action
        return apply_filters('validate_input_examples', $output, $input);
    } // end validate_input_examples
}
