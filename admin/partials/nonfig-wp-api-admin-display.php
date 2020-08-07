<?php

$nonfig_api_keys = get_option('nonfig_api_key_option');
$active_tab = (isset($_GET['tab']))
    ? $_GET['tab']
    : 'api_key_option';
$keysPresent = false;

if (!empty($nonfig_api_keys['app_id']) &&
    !empty($nonfig_api_keys['app_secret'])
) {
    $keysPresent = true;
}

settings_errors();
?>
<div class="wrap">
    <h2><?php _e('Nonfig API Options', 'nonfig_wp_api'); ?></h2>
    <h2 class="nav-tab-wrapper">
        <a
            href="?page=nonfig_wp_api_options&tab=api_key_option"
            class="nav-tab <?php echo $active_tab == 'api_key_option' ? 'nav-tab-active' : ''; ?>"
        >
            <?php _e('Settings', 'nonfig_wp_api'); ?>
        </a>
        <?php if ($keysPresent) { ?>
            <a href="?page=nonfig_wp_api_options&tab=content_options" class="nav-tab <?php echo $active_tab == 'content_options' ? 'nav-tab-active' : ''; ?>"><?php _e('Shortcode Generator', 'nonfig_wp_api'); ?></a>
        <?php } ?>
    </h2>
    <form method="post" action="options.php">
        <?php
        // decision block
        $settings_field = 'nonfig_api_key_option';
        $settings_section = 'nonfig_api_key_option';
        $show_submit_btn = true;

        if ($active_tab == 'content_options' && $keysPresent) {
            $settings_field = 'nonfig_content_options';
            $settings_section = 'nonfig_content_options';
            $show_submit_btn = false;
        }

        // render block
        settings_fields($settings_field);
        do_settings_sections($settings_section);

        if ($show_submit_btn) {
            submit_button();
        }
        ?>
    </form>
</div><!-- /.wrap -->

<!-- Shortcode Generator section -->
<?php
if ($active_tab == 'content_options' && $keysPresent) {
    // show a form or wizard over here

    ?>

<div>
    <h1>Wizard goes here</h1>
    <?php
    require_once plugin_dir_path(dirname(__FILE__)) . '../vendor/nonfig/php-sdk/index.php';

//    $nonfig = new Nonfig('1926ef61-1f23-4cf9-beac-338beb062017', 'TWBk1CGOeQQlQDR1gtlr');
//    $config = $nonfig->findConfigurationByPath('/');

    $nonfig = new Nonfig($nonfig_api_keys['app_id'], $nonfig_api_keys['app_secret']);
    $config = $nonfig->findConfigurationByLabels('texas')[0];
    var_dump($config);
    ?>
    <div>
        You can create a shortcode for three use cases:
        <table style="padding: 5px;">
            <tr>
                <td><strong>Integrate using unique ID</strong></td>
                <td>[nonfig id=enter-id-here"] show this when cannot resolve [/nonfig]</td>
            </tr>

            <tr>
                <td><strong>Integrate using full exact name</strong></td>
                <td>[nonfig name=enter-fulll-name-here"] show this when cannot resolve [/nonfig]</td>
            </tr>
            <tr>
                <td><strong>Integrate using Labels</strong></td>
                <td>[nonfig labels=label1,label:2,..."] show this when cannot resolve [/nonfig]</td>
            </tr>
            <tr>
                <td><strong>Integrate using Query Parameters</td>
                <td>[nonfig paramtype="query" fields="query1,campaign,..."] show this when cannot resolve [/nonfig]</td>
            </tr>
        </table>
    </div>
</div>
    <?php
}
?>