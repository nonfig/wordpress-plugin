<?php

$nonfig_api_keys = get_option('nonfig_api_key_option');
$active_tab = (isset($_GET['tab']))
    ? $_GET['tab']
    : 'api_key_option';
$keysPresent = false;

if (
    !empty($nonfig_api_keys['app_id']) &&
    !empty($nonfig_api_keys['app_secret'])
) {
    $keysPresent = true;
}

settings_errors();
?>
<div class="wrap">
    <h2><?php _e('Nonfig API Options', 'nonfig_wp_api'); ?></h2>
    <h2 class="nav-tab-wrapper">
        <a href="?page=nonfig_wp_api_options&tab=api_key_option" class="nav-tab <?php echo $active_tab == 'api_key_option' ? 'nav-tab-active' : ''; ?>">
            <?php _e('Settings', 'nonfig_wp_api'); ?>
        </a>
        <?php if ($keysPresent) { ?>
            <a href="?page=nonfig_wp_api_options&tab=content_options" class="nav-tab <?php echo $active_tab == 'content_options' ? 'nav-tab-active' : ''; ?>"><?php _e('Shortcode Generator', 'nonfig_wp_api'); ?></a>
        <?php } ?>
    </h2>
    <form method="post" action="options.php">
        <?php
/*
        $allopt = get_option('nonfig_api_key_option');
        var_dump($allopt);
//        echo $allopt['next_cache'];
        echo ($allopt['next_cache']<microtime(true)).'<br>next:'.$allopt['next_cache'].'<br>current:'.microtime(true).'<br>dif:'.($allopt['next_cache']-microtime(true));*/

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
<?php if ($active_tab == 'content_options' && $keysPresent) { ?>
    <div>
        <style>
            .generator {}
            .generator input {width: 50%;}
            .generator table {min-width: 50%;}
            .generator table input {width: 100%;}
        </style>

        <div>
            <br />
            <div class="row">
                <div class="col s3 m3">
                    <div class="card teal accent-4 z-depth-3">
                        <div class="card-content white-text">
                            <span class="card-title">Query Parameter</span>
                            <p>I am a very simple card. I am good at containing small bits of information.
                                I am convenient because I require little markup to use effectively.</p>
                        </div>
                        <div class="card-action">
                            <a class="waves-effect waves-light btn-small red modal-trigger" href="#modal-using-query">Generate Code</a>
                        </div>
                    </div>
                </div>
                <div class="col s3 m3">
                    <div class="card teal accent-4 z-depth-3">
                        <div class="card-content white-text">
                            <span class="card-title">Using Full Name</span>
                            <p>I am a very simple card. I am good at containing small bits of information.
                                I am convenient because I require little markup to use effectively.</p>
                        </div>
                        <div class="card-action">
                            <a class="waves-effect waves-light btn-small red modal-trigger" href="#modal-using-full-name">Generate Code</a>
                        </div>
                    </div>
                </div>
                <div class="col s3 m3">
                    <div class="card teal accent-4 z-depth-3">
                        <div class="card-content white-text">
                            <span class="card-title">Using Unique ID</span>
                            <p>I am a very simple card. I am good at containing small bits of information.
                                I am convenient because I require little markup to use effectively.</p>
                        </div>
                        <div class="card-action">
                            <a class="waves-effect waves-light btn-small red modal-trigger" href="#modal-using-id">Generate Code</a>
                        </div>
                    </div>
                </div>
                <div class="col s3 m3">
                    <div class="card teal accent-4 z-depth-3">
                        <div class="card-content white-text">
                            <span class="card-title">Using Labels</span>
                            <p>I am a very simple card. I am good at containing small bits of information.
                                I am convenient because I require little markup to use effectively.</p>
                        </div>
                        <div class="card-action">
                            <a class="waves-effect waves-light btn-small red modal-trigger" href="#modal-using-labels" disabled="">Coming Soon</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="modal-using-labels" class="modal">
            <div class="modal-content">
                <h4>Generate for Segmented Labels </h4>
                <div>
                    <div class="input-field col">
                        <i class="material-icons prefix">add_circle</i>
                        <div class="chips chips-placeholder form-input-labels"></div>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix">build</i>

                        <input placeholder="Do you want to point a path inside the file i.g .path.to.value" type="text" class="form-input-keypath">
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons prefix">mode_edit</i>

                        <textarea class="materialize-textarea form-input-default" placeholder="Show this if cannot resolve a configuration"></textarea>
                        <label for="textarea2">Default fallback value</label>
                    </div>
                    <div class="waiting-for-input-loader center">
                        <div class="preloader-wrapper big active">
                            <div class="spinner-layer spinner-blue">
                                <div class="circle-clipper left">
                                    <div class="circle"></div>
                                </div>
                                <div class="gap-patch">
                                    <div class="circle"></div>
                                </div>
                                <div class="circle-clipper right">
                                    <div class="circle"></div>
                                </div>
                            </div>

                            <div class="spinner-layer spinner-red">
                                <div class="circle-clipper left">
                                    <div class="circle"></div>
                                </div>
                                <div class="gap-patch">
                                    <div class="circle"></div>
                                </div>
                                <div class="circle-clipper right">
                                    <div class="circle"></div>
                                </div>
                            </div>

                            <div class="spinner-layer spinner-yellow">
                                <div class="circle-clipper left">
                                    <div class="circle"></div>
                                </div>
                                <div class="gap-patch">
                                    <div class="circle"></div>
                                </div>
                                <div class="circle-clipper right">
                                    <div class="circle"></div>
                                </div>
                            </div>

                            <div class="spinner-layer spinner-green">
                                <div class="circle-clipper left">
                                    <div class="circle"></div>
                                </div>
                                <div class="gap-patch">
                                    <div class="circle"></div>
                                </div>
                                <div class="circle-clipper right">
                                    <div class="circle"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="code-output">
                        <p style="background-color: #000;color: #fff;padding: 10px;border-radius: 5px;" class="nonfig-query-output"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-green btn-flat">Copy Code</a>
            </div>
        </div>
        <div id="modal-using-query" class="modal">
            <div class="modal-content">
                <h4>Generate for Query Parmeters</h4>
                <div class="row">
                    <div class="input-field col s6">
                        <select>
                            <option value="query" selected>Query Parameter</option>
                            <option value="url" disabled>URL Parameter</option>
                        </select>
                        <label>Select Parameter Type</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix">add_circle</i>
                        <input placeholder="Parameter Field Name" type="text" class="nonfig-query-field">
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix">build</i>
                        <input placeholder="Do you want to point a path inside the file i.g .path.to.value" type="text" class="nonfig-keypath">
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix">mode_edit</i>

                        <textarea class="materialize-textarea nonfig-label-unresolve" placeholder="Show this if cannot resolve a configuration"></textarea>
                        <label for="textarea2">Default fallback value</label>
                    </div>
                </div>
                <div>
<!--                    <a class="waves-effect waves-light btn-large generate-code">Generate</a>-->
                    <div class="code-output code-output-show" style="display:none;">
                        <input type="text" id="query-output" class="nonfig-label-output" readonly style="background-color: #000;color: #fff; padding: 0 10px; height: 36px;border-radius: 5px;"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="waves-effect waves-green btn-flat code-output-show" style="display:none;" onclick="copy_to_clipboard('query-output');">Copy Code</a>
                <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
            </div>
        </div>
        <div id="modal-using-full-name" class="modal">
            <div class="modal-content">
                <h4>Generate for Query Parmeters</h4>
                <div class="row">
                    <div class="input-field col s6">
                        <i class="material-icons prefix">add_circle</i>
                        <input placeholder="Fully Qualified Name" type="text" class="nonfig-full-name">
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix">build</i>
                        <input placeholder="Do you want to point a path inside the file i.g .path.to.value" type="text" class="nonfig-keypath">
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons prefix">mode_edit</i>

                        <textarea class="materialize-textarea nonfig-label-unresolve" placeholder="Show this if cannot resolve a configuration"></textarea>
                        <label for="textarea2">Default fallback value</label>
                    </div>
                </div>
                <div>
                    <!--                    <a class="waves-effect waves-light btn-large generate-code">Generate</a>-->
                    <div class="code-output code-output-show" style="display:none;">
                        <input type="text" id="full-name-output" class="nonfig-label-output" readonly style="background-color: #000;color: #fff; padding: 0 10px; height: 36px;border-radius: 5px;"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="waves-effect waves-green btn-flat code-output-show" style="display:none;" onclick="copy_to_clipboard('full-name-output');">Copy Code</a>
                <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
            </div>
        </div>
        <div id="modal-using-id" class="modal">
            <div class="modal-content">
                <h4>Generate for Query Parmeters</h4>
                <div class="row">
                    <div class="input-field col s6">
                        <i class="material-icons prefix">add_circle</i>
                        <input placeholder="Enter specific ID for configration" type="text" class="nonfig-id">
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix">build</i>
                        <input placeholder="Do you want to point a path inside the file i.g .path.to.value" type="text" class="nonfig-keypath">
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons prefix">mode_edit</i>

                        <textarea class="materialize-textarea nonfig-label-unresolve" placeholder="Show this if cannot resolve a configuration"></textarea>
                        <label for="textarea2">Default fallback value</label>
                    </div>
                </div>
                <div>
                    <!--                    <a class="waves-effect waves-light btn-large generate-code">Generate</a>-->
                    <div class="code-output code-output-show" style="display:none;">
                        <input type="text" id="id-output" class="nonfig-label-output" readonly style="background-color: #000;color: #fff; padding: 0 10px; height: 36px;border-radius: 5px;"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="waves-effect waves-green btn-flat code-output-show" style="display:none;" onclick="copy_to_clipboard('id-output');">Copy Code</a>
                <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
            </div>
        </div>

        <script>
            jQuery(function($) {
                // register modal plugin
                $('.modal').modal({
                    onCloseStart:function(){
                        $('#modal-using-query .input-field input, #modal-using-query .input-field textarea').val('');
                        $('#modal-using-full-name .input-field input, #modal-using-full-name .input-field textarea').val('');
                        $('.code-output-show').hide();
                    }
                });

                // register chips plugin
                $('.chips-placeholder').chips({
                    placeholder: 'Enter label name',
                    secondaryPlaceholder: '+Label',
                });

                $('select').formSelect();

                $('body').on('blur', '.nonfig-id, .nonfig-id-unresolve', function() {
                    var fildval = $('.nonfig-id').val(),
                        unresl = $('.nonfig-id-unresolve').val();
                    if (fildval != '') {
                        $('.nonfig-id-output').text('[nonfig id="' + fildval + '"] ' + unresl + ' [/nonfig]');
                    } else {
                        $('.nonfig-id-output').text('[nonfig id="enter-id-here"] ' + unresl + ' [/nonfig]');
                    }
                });


                $('body').on('blur', '.nonfig-name, .nonfig-name-unresolve', function() {
                    var fildval = $('.nonfig-name').val(),
                        unresl = $('.nonfig-name-unresolve').val();
                    if (fildval != '') {
                        $('.nonfig-name-output').text('[nonfig name="' + fildval + '"] ' + unresl + ' [/nonfig]');
                    } else {
                        $('.nonfig-name-output').text('[nonfig name="enter-fulll-name-here"] ' + unresl + ' [/nonfig]');
                    }
                });

                $('body').on('click', '#modal-using-query .generate-code', function() {

                });

                $('body').on('blur', '#modal-using-query .input-field input, #modal-using-query .input-field textarea', function() {
                    var paramField = $('#modal-using-query .nonfig-query-field').val(),
                        keypth = $('#modal-using-query .nonfig-keypath').val(),
                        unresl = $('#modal-using-query .nonfig-label-unresolve').val();

                        $('#modal-using-query .nonfig-label-output').val('[nonfig param-type="query" field="' + paramField + '"] ' + unresl + ' [/nonfig]');
                        if (keypth != '') {
                            $('#modal-using-query .nonfig-label-output').val('[nonfig param-type="query" field="' + paramField + '" keypath="' + keypth + '"] ' + unresl + ' [/nonfig]');
                        }
                        if(paramField !== '' && unresl !== ''){$('#modal-using-query .code-output-show').show();}
                });
                $('body').on('blur', '#modal-using-full-name .input-field input, #modal-using-full-name .input-field textarea', function() {
                    var paramField = $('#modal-using-full-name .nonfig-full-name').val(),
                        keypth = $('#modal-using-full-name .nonfig-keypath').val(),
                        unresl = $('#modal-using-full-name .nonfig-label-unresolve').val();

                    $('#modal-using-full-name .nonfig-label-output').val('[nonfig full-name="' + paramField + '"] ' + unresl + ' [/nonfig]');
                    if (keypth != '') {
                        $('#modal-using-full-name .nonfig-label-output').val('[nonfig full-name="' + paramField + '" keypath="' + keypth + '"] ' + unresl + ' [/nonfig]');
                    }
                    if(paramField !== '' && unresl !== ''){$('#modal-using-full-name .code-output-show').show();}
                });
                $('body').on('blur', '#modal-using-id .input-field input, #modal-using-id .input-field textarea', function() {
                    var paramField = $('#modal-using-id .nonfig-id').val(),
                        keypth = $('#modal-using-id .nonfig-keypath').val(),
                        unresl = $('#modal-using-id .nonfig-label-unresolve').val();

                    $('#modal-using-id .nonfig-label-output').val('[nonfig id="' + paramField + '"] ' + unresl + ' [/nonfig]');
                    if (keypth != '') {
                        $('#modal-using-id .nonfig-label-output').val('[nonfig id="' + paramField + '" keypath="' + keypth + '"] ' + unresl + ' [/nonfig]');
                    }
                    if(paramField !== '' && unresl !== ''){$('#modal-using-id .code-output-show').show();}
                });

                // handler: using labels
                $('body')
                    .on(
                        'blur',
                        '.form-input-labels, .form-input-keypath, .form-input-default',
                        function callbackFn() {
                            var chipInstance = M.Chips.getInstance($('.form-input-labels'));
                            var labels = chipInstance.chipsData.map(chip => chip.tag);
                            var keyPath = $('.form-input-keypath').val();
                            var defaultValue = $('.form-input-default').val();

                            if (labels.length > 0) {
                                $('.waiting-for-input-loader').hide();
                                var keyset = [
                                    `labels="${labels.join(',')}"`
                                ]

                                if (keyPath) {
                                    keyset.push(`keypath="${keyPath}"`)
                                }

                                setOutputCode(generateShortcode(keyset, defaultValue));
                            }
                        }
                    )

                function generateShortcode(keyset, defaultValue) {
                    return `[nonfig ${Array.from(keyset).join(' ')}]${defaultValue}[/nonfig]`
                }

                function setOutputCode(result) {
                    $('.code-output p').text(result);
                }

            });
            function copy_to_clipboard(id) {
                var copyText = document.getElementById(id);
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                document.execCommand("copy");
                // alert("Copied the text: " + copyText.value);
                console.log('copied');
                M.toast({html: 'Code copied to clipboard!'})
            }
        </script>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.19/lodash.min.js" integrity="sha512-/A6lxqQJVUIMnx8B/bx/ERfeuJnqoWPJdUxN8aBj+tZYL35O998ry7UUGoN65PSUNlJNrqKZrDENi4i1c3zy4Q==" crossorigin="anonymous"></script>
    </div>
<?php
}
?>