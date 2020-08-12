<?php

$nonfig_api_keys = get_option( 'nonfig_api_key_option' );
$active_tab      = ( isset( $_GET['tab'] ) )
	? $_GET['tab']
	: 'api_key_option';
$key_present     = false;

if ( ! empty( $nonfig_api_keys['app_id'] ) &&
	! empty( $nonfig_api_keys['app_secret'] )
) {
	$key_present = true;
}

settings_errors();
?>
<div class="wrap">
	<h2><?php _e( 'Nonfig API Options', 'nonfig_wp_api' ); ?></h2>
	<h2 class="nav-tab-wrapper">
		<a
			href="?page=nonfig_wp_api_options&tab=api_key_option"
			class="nav-tab <?php echo 'api_key_option' === $active_tab ? 'nav-tab-active' : ''; ?>"
		>
		<?php _e( 'Settings', 'nonfig_wp_api' ); ?>
		</a>
		<?php if ( $key_present ) { ?>
			<a
				href="?page=nonfig_wp_api_options&tab=content_options"
				class="nav-tab <?php echo 'content_options' === $active_tab ? 'nav-tab-active' : ''; ?>"
			><?php _e( 'Shortcode Generator', 'nonfig_wp_api' ); ?>
			</a>
		<?php } ?>
	</h2>
	<form method="post" action="options.php">
		<?php
		// decision block
		$settings_field   = 'nonfig_api_key_option';
		$settings_section = 'nonfig_api_key_option';
		$show_submit_btn  = true;

		if ( 'content_options' === $active_tab && $key_present ) {
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
<?php if ( 'content_options' === $active_tab && $key_present ) { ?>
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
							<p>I am a very simple card. I am good at containing small bits of information.
								I am convenient because I require little markup to use effectively.</p>
						</div>
						<div class="card-action">
							<a class="waves-effect waves-light btn-small red">Generate Code</a>
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
							<a class="waves-effect waves-light btn-small red">Generate Code</a>
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
							<a class="waves-effect waves-light btn-small red">Generate Code</a>
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
							<a
								class="waves-effect waves-light btn-small red modal-trigger"
								href="#modal-using-labels"
							>Generate Code</a>
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
						<input
							placeholder="Do you want to point a path inside the file i.g .path.to.value"
							type="text"
							class="form-input-keypath"
						>
					</div>
					<div class="input-field col s12">
						<i class="material-icons prefix">mode_edit</i>
						<textarea
							class="materialize-textarea form-input-default"
							placeholder="Show this if cannot resolve a configuration"
						></textarea>
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
						<p
							style="background-color: #000;color: #fff;padding: 10px;border-radius: 5px;"
							class="nonfig-query-output"
						></p>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a href="#!" class="modal-close waves-effect waves-green btn-flat">Copy Code</a>
			</div>
		</div>

		<script>
			jQuery(function($) {
				// register modal plugin
				$('.modal').modal();

				// register chips plugin
				$('.chips-placeholder').chips({
					placeholder: 'Enter label name',
					secondaryPlaceholder: '+Label',
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
		</script>
		<script
			src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.19/lodash.min.js"
			integrity="sha512-/A6lxqQJVUIMnx8B/bx/ERfeuJnqoWPJdUxN8aBj+tZYL35O998ry7UUGoN65PSUNlJNrqKZrDENi4i1c3zy4Q=="
			crossorigin="anonymous"
		></script>
	</div>
	<?php
}
?>
