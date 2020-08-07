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
    /*require_once plugin_dir_path(dirname(__FILE__)) . '../vendor/nonfig/php-sdk/index.php';

//    $nonfig = new Nonfig('1926ef61-1f23-4cf9-beac-338beb062017', 'TWBk1CGOeQQlQDR1gtlr');
//    $config = $nonfig->findConfigurationByPath('/');

    $nonfig = new Nonfig($nonfig_api_keys['app_id'], $nonfig_api_keys['app_secret']);
    $config = $nonfig->findConfigurationByLabels('texas')[0];
    var_dump($config);*/
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
    <style>
        .generator{}
        .generator input{width:50%;}
        .generator table{min-width:50%;}
        .generator table input{width:100%;}
    </style>
    <div class="generator">
        <h3>Generate Shortcode</h3>
        <h4>By ID</h4>
        <div>
            <table>
                <tr>
                    <td><input type="text" class="nonfig-id" placeholder="ID"/></td>
                    <td><input type="text" class="nonfig-id-unresolve" value="show this when cannot resolve" /></td>
                </tr>
            </table>
            <div>
                <p class="nonfig-id-output"></p>
            </div>
        </div>
        <h4>By Full Name</h4>
        <div>
            <table>
                <tr>
                    <td><input type="text" class="nonfig-name" placeholder="Full Name" /></td>
                    <td><input type="text" class="nonfig-name-unresolve" value="show this when cannot resolve" /></td>
                </tr>
            </table>
            <div>
                <p class="nonfig-name-output"></p>
            </div>
        </div>

        <h4>By Label</h4>
        <div>
            <table>
                <tr>
                    <td><input type="text" class="nonfig-label" placeholder="Label" /></td>
                    <td><input type="text" class="nonfig-keypath" placeholder="KeyPath (optional)"/></td>
                    <td><input type="text" class="nonfig-label-unresolve" value="show this when cannot resolve" /></td>
                </tr>
            </table>
            <div>
                <p class="nonfig-label-output"></p>
            </div>
        </div>

        <h4>By Query</h4>
        <div>
            <table>
                <tr>
<!--                    <td><input type="text" class="nonfig-param-type" value="query" disabled/></td>-->
                    <td><input type="text" class="nonfig-field" placeholder="Field"/></td>
                    <td><input type="text" class="nonfig-keypath2" placeholder="KeyPath (optional)"/></td>
                    <td><input type="text" class="nonfig-query-unresolve" value="show this when cannot resolve" /></td>
                </tr>
            </table>
            <div>
                <p class="nonfig-query-output"></p>
            </div>
        </div>
    </div>
    <script>
        jQuery(function($){
            $('body').on('blur','.nonfig-id, .nonfig-id-unresolve',function(){
                var fildval = $('.nonfig-id').val(),
                    unresl = $('.nonfig-id-unresolve').val();
                if(fildval!=''){
                    $('.nonfig-id-output').text('[nonfig id="'+fildval+'"] '+unresl+' [/nonfig]');
                }else{
                    $('.nonfig-id-output').text('[nonfig id="enter-id-here"] '+unresl+' [/nonfig]');
                }
            });


            $('body').on('blur','.nonfig-name, .nonfig-name-unresolve',function(){
                var fildval = $('.nonfig-name').val(),
                    unresl = $('.nonfig-name-unresolve').val();
                if(fildval!=''){
                    $('.nonfig-name-output').text('[nonfig name="'+fildval+'"] '+unresl+' [/nonfig]');
                }else{
                    $('.nonfig-name-output').text('[nonfig name="enter-fulll-name-here"] '+unresl+' [/nonfig]');
                }
            });


            $('body').on('blur','.nonfig-label, .nonfig-keypath, .nonfig-label-unresolve',function(){
                var fildval = $('.nonfig-label').val(),
                    keypth = $('.nonfig-keypath').val(),
                    unresl = $('.nonfig-label-unresolve').val();
                if(fildval!=''){
                    $('.nonfig-label-output').text('[nonfig labels="'+fildval+'"] '+unresl+' [/nonfig]');
                    if(keypth!=''){
                        $('.nonfig-label-output').text('[nonfig labels="'+fildval+'" keypath="'+keypth+'"] '+unresl+' [/nonfig]');
                    }
                }else{
                    $('.nonfig-label-output').text('[nonfig labels="enter-fulll-name-here"] '+unresl+' [/nonfig]');
                }
            });


            $('body').on('blur','.nonfig-field, .nonfig-keypath2, .nonfig-query-unresolve',function(){
                var fildval = $('.nonfig-field').val(),
                    keypth = $('.nonfig-keypath2').val(),
                    unresl = $('.nonfig-query-unresolve').val();
                if(fildval!=''){
                    $('.nonfig-query-output').text('[nonfig labels="'+fildval+'"] '+unresl+' [/nonfig]');
                    if(keypth!=''){
                        $('.nonfig-query-output').text('[nonfig labels="'+fildval+'" keypath="'+keypth+'"] '+unresl+' [/nonfig]');
                    }
                }else{
                    $('.nonfig-query-output').text('[nonfig labels="enter-fulll-name-here"] '+unresl+' [/nonfig]');
                }
            });

        });
    </script>
</div>
    <?php
}
?>