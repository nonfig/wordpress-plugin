<?php

// phpcs:ignore
$nonfig_api_keys = get_option( 'nonfig_api_key_option' );
$active_tab      = ( sanitize_text_field( isset( $_GET['tab'] ) ) )
	? sanitize_text_field( $_GET['tab'] )
	: 'api_key_option';
$keys_present    = false;

if (
	! empty( $nonfig_api_keys['app_id'] ) &&
	! empty( $nonfig_api_keys['app_secret'] )
) {
	$keys_present = true;
}

settings_errors();
?>
<div class="wrap">
	<h2><?php esc_html_e( 'Nonfig API Options', 'nonfig' ); ?></h2>
	<h2 class="nav-tab-wrapper">
		<a href="?page=nonfig_wp_api_options&tab=api_key_option" class="nav-tab <?php echo 'api_key_option' === $active_tab ? 'nav-tab-active' : ''; ?>">
			<?php esc_html_e( 'Settings', 'nonfig' ); ?>
		</a>
		<?php if ( $keys_present ) { ?>
			<a
				href="?page=nonfig_wp_api_options&tab=content_options"
				class="nav-tab <?php echo 'content_options' === $active_tab ? 'nav-tab-active' : ''; ?>"
			>
				<?php esc_html_e( 'Shortcode Generator', 'nonfig' ); ?></a>
		<?php } ?>
	</h2>
	<form method="post" action="options.php">
		<?php
		// decision block
		$settings_field   = 'nonfig_api_key_option';
		$settings_section = 'nonfig_api_key_option';
		$show_submit_btn  = true;

		if ( 'content_options' === $active_tab && $keys_present ) {
			$settings_field   = 'nonfig_content_options';
			$settings_section = 'nonfig_content_options';
			$show_submit_btn  = false;
		}

		// render block
		settings_fields( $settings_field );
		do_settings_sections( $settings_section );

		if ( $show_submit_btn ) {
			submit_button();
		}
		?>
	</form>
</div><!-- /.wrap -->

<!-- Shortcode Generator section -->
<?php if ( 'content_options' === $active_tab && $keys_present ) { ?>
	<div>
		<style>
			.generator {}

			.generator input {
				width: 50%;
			}

			.generator table {
				min-width: 50%;
			}

			.generator table input {
				width: 100%;
			}
		</style>

		<div>
			<br />
			<div class="row">
				<div class="col s3 m3">
					<div class="card teal accent-4 z-depth-3">
						<div class="card-content white-text">
							<span class="card-title">Query Parameter</span>
							<p>Fetch configuration content from Nonfig using Query parameter. Just
								input the query parameter name, and the value will be used to fetch Config.
							</p>
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
							<p>Fetch configuration content from Nonfig using Full name. Just input
								the exact full name (along with path) and particular config is fetched.
							</p>
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
							<p>Fetch configuration content from Nonfig using Configuration ID. This
								fetches the configuration by ID (NOT RECOMMENDED).
							</p>
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
							<p>Provide the list of labels and we will fetch a configuration list.
								This enables to fetch segmented configurations at any given time.
							</p>
						</div>
						<div class="card-action">
							<a class="waves-effect waves-light btn-small red modal-trigger" href="#modal-using-labels" disabled="">Coming Soon</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="modal-using-labels" class="nonfig-modal modal">
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
		<div id="modal-using-query" class="nonfig-modal modal">
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
						<input type="text" id="query-output" class="nonfig-label-output" readonly style="background-color: #000;color: #fff; padding: 0 10px; height: 36px;border-radius: 5px;" />
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a href="#!" class="waves-effect waves-green btn-flat code-output-show" style="display:none;" onclick="copy_to_clipboard('query-output');">Copy Code</a>
				<a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
			</div>
		</div>
		<div id="modal-using-full-name" class="nonfig-modal modal">
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
						<input type="text" id="full-name-output" class="nonfig-label-output" readonly style="background-color: #000;color: #fff; padding: 0 10px; height: 36px;border-radius: 5px;" />
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a href="#!" class="waves-effect waves-green btn-flat code-output-show" style="display:none;" onclick="copy_to_clipboard('full-name-output');">Copy Code</a>
				<a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
			</div>
		</div>
		<div id="modal-using-id" class="nonfig-modal modal">
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
						<input type="text" id="id-output" class="nonfig-label-output" readonly style="background-color: #000;color: #fff; padding: 0 10px; height: 36px;border-radius: 5px;" />
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
					onCloseStart: function() {
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
					if (paramField !== '' && unresl !== '') {
						$('#modal-using-query .code-output-show').show();
					}
				});
				$('body').on('blur', '#modal-using-full-name .input-field input, #modal-using-full-name .input-field textarea', function() {
					var paramField = $('#modal-using-full-name .nonfig-full-name').val(),
						keypth = $('#modal-using-full-name .nonfig-keypath').val(),
						unresl = $('#modal-using-full-name .nonfig-label-unresolve').val();

					$('#modal-using-full-name .nonfig-label-output').val('[nonfig full-name="' + paramField + '"] ' + unresl + ' [/nonfig]');
					if (keypth != '') {
						$('#modal-using-full-name .nonfig-label-output').val('[nonfig full-name="' + paramField + '" keypath="' + keypth + '"] ' + unresl + ' [/nonfig]');
					}
					if (paramField !== '' && unresl !== '') {
						$('#modal-using-full-name .code-output-show').show();
					}
				});
				$('body').on('blur', '#modal-using-id .input-field input, #modal-using-id .input-field textarea', function() {
					var paramField = $('#modal-using-id .nonfig-id').val(),
						keypth = $('#modal-using-id .nonfig-keypath').val(),
						unresl = $('#modal-using-id .nonfig-label-unresolve').val();

					$('#modal-using-id .nonfig-label-output').val('[nonfig id="' + paramField + '"] ' + unresl + ' [/nonfig]');
					if (keypth != '') {
						$('#modal-using-id .nonfig-label-output').val('[nonfig id="' + paramField + '" keypath="' + keypth + '"] ' + unresl + ' [/nonfig]');
					}
					if (paramField !== '' && unresl !== '') {
						$('#modal-using-id .code-output-show').show();
					}
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
				M.toast({
					html: 'Code copied to clipboard!'
				})
			}
		</script>
	</div>
	<?php
}
?>
