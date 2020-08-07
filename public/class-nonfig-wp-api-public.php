<?php

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
 * @author     Azim Khan <akhan_24@hotmail.com>
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
		$this->version = $version;

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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/nonfig-wp-api-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/nonfig-wp-api-public.js', array( 'jquery' ), $this->version, false );

	}



    public function nonfig_content_shortcode(){
        add_shortcode('nonfig', array( $this, 'nonfig_shortcode_function'));
    }

    public function nonfig_shortcode_function( $atts = array(), $content = null ) {

        require_once plugin_dir_path(dirname(__FILE__)) . 'vendor/nonfig/php-sdk/index.php';

        // set up default parameters
        extract(shortcode_atts(array(
            'id' => '',
            'name' => '',
            'labels' => '',
            'keypath' => '',
            'param-type' => '',
            'fields' => ''
        ), $atts));
        $nonfig_api_keys = get_option('nonfig_api_key_option');
        if(!empty($nonfig_api_keys['app_id']) && !empty($nonfig_api_keys['app_secret']) ){
//            return $nonfig_api_keys['app_id']." - ".$nonfig_api_keys['app_secret']." - ".$atts['path'];
            if(!empty($atts['id'])){
                try {
                    $nonfig = new Nonfig($nonfig_api_keys['app_id'], $nonfig_api_keys['app_secret']);
                    $configPath = $nonfig->findConfigurationById($atts['id']);
                    $stringoutput=$configPath[0]->data;
                    return $stringoutput;
                }
                catch(Exception $e) {
                    //return 'Message: ' .$e->getMessage();
                    return $content;
                }
            }
            else if(!empty($atts['name'])){
                try {
                    $nonfig = new Nonfig($nonfig_api_keys['app_id'], $nonfig_api_keys['app_secret']);
                    $configPath = $nonfig->findConfigurationByName($atts['name']);
                    $stringoutput=$configPath[0]->data;
                    return $stringoutput;
                }
                catch(Exception $e) {
                    //return 'Message: ' .$e->getMessage();
                    return $content;
                }
            }
            else if(!empty($atts['labels'])){
                try {
                    $nonfig = new Nonfig($nonfig_api_keys['app_id'], $nonfig_api_keys['app_secret']);
                    $stringoutput=$this->label_content_filter($nonfig,$atts['labels'],$atts);
                    return $stringoutput;
                }
                catch(Exception $e) {
//                    return 'Message: ' .$e->getMessage();
                    return $content;
                }
            }
            else if(!empty($atts['param-type'])){
                if($atts['param-type']=='query' && !empty($atts['field'])){
                    try {
                        $nonfig = new Nonfig($nonfig_api_keys['app_id'], $nonfig_api_keys['app_secret']);
                        $paramval = $_GET[$atts['field']];
                        $stringoutput=$this->label_content_filter($nonfig,$paramval,$atts);
                        return $stringoutput;
                    }
                    catch(Exception $e) {
//                    return 'Message: ' .$e->getMessage();
                        return $content;
                    }
                } else {
                    return $content;
                }

            } else {
                return $content;
            }

        } else {
            return "Error: Keys not present or 'path' missing.";
        }


    }

    public function label_content_filter($nonfig,$label,$atts){
        $configPath = $nonfig->findConfigurationByLabels($label);

	    if(!empty($atts['keypath']) && $configPath[0]->type=='JSON'){
            $jsonoutput=json_decode($configPath[0]->data);
            $stringoutput = $jsonoutput->{$atts['keypath']};
            /*foreach($jsonoutput as $keyp=>$item){
                if(strpos($atts['keypath'], '.')>=0){
                    $arrayobj = explode('.',$atts['keypath']);
                    foreach($arrayobj as $initem){

                    }
                }
                else if($keyp==$atts['keypath']){$stringoutput=$item;}

            }*/
        }
	    else{
            $stringoutput=$configPath[0]->data;
        }
        return $stringoutput;
    }


}
