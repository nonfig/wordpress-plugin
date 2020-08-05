<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://webstalk.net/
 * @since      1.0.0
 *
 * @package    Nonfig_Wp_Api
 * @subpackage Nonfig_Wp_Api/admin/partials
 */
//https://www.knowboard.de/how-to-create-a-wordpress-plugin-using-the-wppb-boilerplate-including-a-beautyful-settings-page/
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<!--<p>Nonfig Admin Page</p>-->

<!-- Create a header in the default WordPress 'wrap' container -->
<?php
$nonfig_api_keys = get_option('nonfig_api_key_option');
$keysPresent=false;
if(!empty($nonfig_api_keys['app_id']) && !empty($nonfig_api_keys['app_secret'])){$keysPresent=true;}
//echo $nonfig_api_keys['app_id'];
//echo $nonfig_api_keys['app_secret'];
?>
<div class="wrap">
    <h2><?php _e( 'Nonfig API Options', 'nonfig_wp_api' ); ?></h2>
    <?php settings_errors(); ?>
    <?php if( isset( $_GET[ 'tab' ] ) ) {
        $active_tab = $_GET[ 'tab' ];
    /*} else if( $active_tab == 'content_options' ) {
        $active_tab = 'content_options';
    } else if( $active_tab == 'input_examples' ) {
        $active_tab = 'input_examples';*/
    } else {
        $active_tab = 'api_key_option';
    } // end if/else ?>
    <h2 class="nav-tab-wrapper">
        <a href="?page=nonfig_wp_api_options&tab=api_key_option" class="nav-tab <?php echo $active_tab == 'api_key_option' ? 'nav-tab-active' : ''; ?>"><?php _e( 'API Keys', 'nonfig_wp_api' ); ?></a>
        <?php if($keysPresent){ ?>
        <a href="?page=nonfig_wp_api_options&tab=content_options" class="nav-tab <?php echo $active_tab == 'content_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Content List', 'nonfig_wp_api' ); ?></a>
        <?php } ?>
        <?php /*
        <a href="?page=nonfig_wp_api_options&tab=input_examples" class="nav-tab <?php echo $active_tab == 'input_examples' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Input Examples', 'nonfig_wp_api' ); ?></a>
        */ ?>
    </h2>
    <form method="post" action="options.php">
        <?php
        if( $active_tab == 'api_key_option' ) {
            settings_fields( 'nonfig_api_key_option' );
            do_settings_sections( 'nonfig_api_key_option' );
            submit_button();
        } elseif( $active_tab == 'content_options' && $keysPresent ) {
            settings_fields( 'nonfig_content_options' );
            do_settings_sections( 'nonfig_content_options' );
        } /*else {
            settings_fields( 'nonfig_input_examples' );
            do_settings_sections( 'nonfig_input_examples' );
        }*/ // end if/else
//        submit_button();
        ?>
    </form>
</div><!-- /.wrap -->




<?php
if( $active_tab == 'content_options' && $keysPresent ) {
//echo plugin_dir_path( dirname( __FILE__ ) );
    require_once plugin_dir_path(dirname(__FILE__)) . '../api/index.php';

//    $options = get_option('nonfig_api_key_option');
//    var_dump($options);
    try {
        $nonfig = new Nonfig($nonfig_api_keys['app_id'], $nonfig_api_keys['app_secret']);
        $configPath = $nonfig->findConfigurationByPath("/wordpress");
//        var_dump($configPath[0]); ?>

        <p>Use these Shortcodes in page to show respective data</p>
        <table width="100%" cellpadding="10">
            <tr>
                <th width="60%" style="text-align:left;">Data</th>
                <th style="text-align:left;">Shortcode</th>
            </tr>
        <?php foreach($configPath[0] as $ckey=>$item){ ?>
            <tr>
                <td><?php echo $item->data; ?></td>
                <td>[nonfig path="<?php echo $item->fullyQualifiedName; ?>"]</td>
            </tr>
        <?php } ?>
        </table>
    <?php }

//catch exception
    catch(Exception $e) {
        echo 'Message: ' .$e->getMessage();
    }

// pls remove this below
//$nonfig = new Nonfig("1926ef61-1f23-4cf9-beac-338beb062017", "TWBk1CGOeQQlQDR1gtlr");
//$configId = $nonfig->findConfigurationById("8400a3a0-9c14-47cc-b598-f5037fd5a9ce");
//$configName = $nonfig->findConfigurationByName("/feature_flags");
//$configPath = $nonfig->findConfigurationByPath("/wordpress");
//var_dump($configPath);
}


?>

