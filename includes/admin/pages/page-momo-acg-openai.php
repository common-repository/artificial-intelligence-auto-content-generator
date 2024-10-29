<?php
/**
 * MoMO ACG - OpenAI Settings
 *
 * @author MoMo Themes
 * @package momoacg
 * @since v1.1.0
 */

global $momoacg;
$openai_settings           = get_option( 'momo_acg_openai_settings' );
$enable_openai_post_option = $momoacg->fn->momo_return_check_option( $openai_settings, 'enable_openai_post_option' );
$api_key                   = isset( $openai_settings['api_key'] ) ? $openai_settings['api_key'] : '';
$language_model            = isset( $openai_settings['language_model'] ) ? $openai_settings['language_model'] : 'text-davinci-003';
$temperature               = isset( $openai_settings['temperature'] ) ? $openai_settings['temperature'] : '';
$max_tokens                = isset( $openai_settings['max_tokens'] ) ? $openai_settings['max_tokens'] : '';
$top_p                     = isset( $openai_settings['top_p'] ) ? $openai_settings['top_p'] : '';
$frequency_penalty         = isset( $openai_settings['frequency_penalty'] ) ? $openai_settings['frequency_penalty'] : '';
$presence_penalty          = isset( $openai_settings['presence_penalty'] ) ? $openai_settings['presence_penalty'] : '';
$timeout                   = isset( $openai_settings['timeout'] ) ? $openai_settings['timeout'] : 45;
$ak_class                  = '';
if ( ! empty( $api_key ) ) {
	$ak_class = 'momo-hidden';
}
?>
<div class="momo-admin-content-box">
	<div class="momo-ms-admin-content-main momoacg-export-settings-main" id="momoacg-momo-wsw-export-settings-form">
		<div class="momo-be-msg-block"></div>
		<div class="momo-row momo-responsive">
			<div class="momo-col">
				<div class="momo-be-block-section momo-min-h-110">
					<h2 class="momo-be-block-section-header"><?php esc_html_e( 'API Settings', 'momoacg' ); ?></h2>
					<p>
						<?php
						$here = '<a href="' . esc_url( 'https://beta.openai.com/account/api-keys' ) . '" target="_blank">' . esc_html__( 'here', 'momoacg' ) . '</a>';
						/* translators: %s Url link */
						printf( esc_html__( 'Get your API OpenAI keys from %s.', 'momoacg' ), wp_kses_post( $here ) );
						?>
					</p>
					<span class="block">
					<input type="text" class="wide <?php echo esc_attr( $ak_class ); ?>" name="momo_acg_openai_settings[api_key]" value="<?php echo esc_attr( $api_key ); ?>"/>
					</span>
					<?php
					if ( ! empty( $api_key ) ) :
						$after_three      = substr( $api_key, 3 );
						$masked_substring = str_repeat( '*', strlen( $after_three ) - 3 );
						$masked           = substr( $api_key, 0, 3 ) . $masked_substring . substr( $api_key, -3, 3 );
						?>
					<span class="momo-block-with-asterix">
							<?php echo esc_html( $masked ); ?>
						<span class="momo-clear-api"><?php esc_html_e( 'Clear API Key', 'momoacg' ); ?></span>
					</span>
					<?php endif; ?>
				</div>
			</div>
			<div class="momo-col momo-p-col"></div>
			<div class="momo-col">
				<div class="momo-be-block-section momo-min-h-110">
					<h2 class="momo-be-block-section-header"><?php esc_html_e( 'Language Model', 'momoacg' ); ?></h2>
					<p>	
						<?php esc_html_e( 'Learn more about language models and pricing here ', 'momoacg' ); ?><a href="https://platform.openai.com/docs/models/gpt-3" class="momo-pl-5" target="_blank"><?php esc_html_e( 'Models', 'momoacg' ); ?></a>
					</p>
					<select class="wide" name="momo_acg_openai_settings[language_model]">
						<option value="gpt-4" <?php echo ( 'gpt-4' === $language_model ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'GPT-4', 'momoacg' ); ?></option>
						<option value="gpt-3.5-turbo" <?php echo ( 'gpt-3.5-turbo' === $language_model ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'GPT-3.5-Turbo', 'momoacg' ); ?></option>
						<option value="text-davinci-003" <?php echo ( 'text-davinci-003' === $language_model ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'DaVinci-003', 'momoacg' ); ?></option>
						<option value="text-curie-001" <?php echo ( 'text-curie-001' === $language_model ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Curie-003', 'momoacg' ); ?></option>
						<option value="text-babbage-001" <?php echo ( 'text-babbage-001' === $language_model ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Babbage-001', 'momoacg' ); ?></option>
						<option value="text-ada-001" <?php echo ( 'text-ada-001' === $language_model ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Ada-001', 'momoacg' ); ?></option>
					</select>
				</div>
			</div>
		</div>
		<div class="momo-be-hr-line"></div>
		<div class="momo-be-block-section">
			<h2 class="momo-be-block-section-header"><?php esc_html_e( 'Text Generation Settings', 'momoacg' ); ?></h2>
			<p>	
				<?php esc_html_e( 'These settings determine the output of the text / content. Different settings will generate the same conent in various styles. ', 'momoacg' ); ?>
			</p>
			<div class="momo-row">
				<div class="momo-padding-12 momo-col-3">
					<div class="momo-be-range-slider-container momo-full-page">
						<label for="momo_acg_openai_settings[temperature]" class="block">
							<?php esc_html_e( 'Temperature', 'momoacg' ); ?>
							<span class="momo-be-helper bx bxs-help-circle">
								<span class="momo-be-helper-text">
									<?php esc_html_e( 'Higher temperature generates less accurate but diverse and creative output. Lesser temperature will generate more accurate results.', 'momoacg' ); ?>
								</span>
							</span>
						</label>
						<span class="momo-range-input-holder">
							<input name="momo_acg_openai_settings[temperature]" type="range" min="0.1" max="1" step="0.1" value="<?php echo esc_attr( $temperature ); ?>" class="momo-be-range-slider inline" autocomplete="off">
							<span class="momo-be-rs-value"><?php echo esc_html( $temperature ); ?></span>
						</span>
					</div>
				</div>
				<div class="momo-padding-12 momo-col-3">
					<div class="momo-be-range-slider-container momo-full-page">
						<label for="momo_acg_openai_settings[max_tokens]" class="block">
							<?php esc_html_e( 'Maximum Tokens', 'momoacg' ); ?>
							<span class="momo-be-helper bx bxs-help-circle">
								<span class="momo-be-helper-text">
									<?php esc_html_e( 'Use it in combination with "Temperature" to control the randomness and creativity of the output.', 'momoacg' ); ?>
								</span>
							</span>
						</label>
						<span class="momo-range-input-holder">
							<input name="momo_acg_openai_settings[max_tokens]" type="range" min="0" max="3000" step="30" value="<?php echo esc_attr( $max_tokens ); ?>" class="momo-be-range-slider inline" autocomplete="off">
							<span class="momo-be-rs-value"><?php echo esc_html( $max_tokens ); ?></span>
						</span>
					</div>
				</div>
				<div class="momo-col momo-col-3">
					<div class="momo-be-range-slider-container momo-full-page">
						<label for="momo_acg_openai_settings[top_p]" class="block">
							<?php esc_html_e( 'Top P', 'momoacg' ); ?>
							<span class="momo-be-helper bx bxs-help-circle">
								<span class="momo-be-helper-text">
									<?php esc_html_e( 'To control randomness of the output.', 'momoacg' ); ?>
								</span>
							</span>
						</label>
						<span class="momo-range-input-holder">
							<input name="momo_acg_openai_settings[top_p]" type="range" min="0" max="1" step="0.1" value="<?php echo esc_attr( $top_p ); ?>" class="momo-be-range-slider inline" autocomplete="off">
							<span class="momo-be-rs-value"><?php echo esc_html( $top_p ); ?></span>
						</span>
					</div>
				</div>
			</div><!-- ends .momo-row -->
			<div class="momo-row">
				<div class="momo-col momo-col-3">
					<div class="momo-be-range-slider-container momo-full-page">
						<label for="momo_acg_openai_settings[frequency_penalty]" class="block">
							<?php esc_html_e( 'Frequency Penalty', 'momoacg' ); ?>
							<span class="momo-be-helper bx bxs-help-circle">
								<span class="momo-be-helper-text">
									<?php esc_html_e( 'For improving the quality and coherence of the generated text.', 'momoacg' ); ?>
								</span>
							</span>
						</label>
						<span class="momo-range-input-holder">
							<input name="momo_acg_openai_settings[frequency_penalty]" type="range" min="0" max="2" step="0.2" value="<?php echo esc_attr( $frequency_penalty ); ?>" class="momo-be-range-slider inline" autocomplete="off">
							<span class="momo-be-rs-value"><?php echo esc_html( $frequency_penalty ); ?></span>
						</span>
					</div>
				</div>
				<div class="momo-col momo-col-3">
					<div class="momo-be-range-slider-container momo-full-page">
						<label for="momo_acg_openai_settings[presence_penalty]" class="block">
							<?php esc_html_e( 'Presence Penalty', 'momoacg' ); ?>
							<span class="momo-be-helper bx bxs-help-circle">
								<span class="momo-be-helper-text">
									<?php esc_html_e( 'To produce more concise text.', 'momoacg' ); ?>
								</span>
							</span>
						</label>
						<span class="momo-range-input-holder">
							<input name="momo_acg_openai_settings[presence_penalty]" type="range" min="0" max="2" step="0.2" value="<?php echo esc_attr( $presence_penalty ); ?>" class="momo-be-range-slider inline" autocomplete="off">
							<span class="momo-be-rs-value"><?php echo esc_html( $presence_penalty ); ?></span>
						</span>
					</div>
				</div>
				<div class="momo-col momo-col-3"></div>
			</div><!-- ends momo-row -->
			<div class="momo-be-hr-line"></div>
			<div class="momo-be-block momo-m-40">
				<div class="momo-be-range-slider-container momo-full-page">
					<label for="momo_acg_openai_settings[timeout]" class="block">
						<?php esc_html_e( 'Remote Timeout', 'momoacg' ); ?>
						<span class="momo-be-helper bx bxs-help-circle">
							<span class="momo-be-helper-text">
								<?php esc_html_e( 'If you\'re experiencing a timeout error (fsocket timed out/gateway timeout), you can increase this value so that request can wait longer amount of time to get response from API server.', 'momoacg' ); ?>
							</span>
						</span>
					</label>
					<span class="momo-range-input-holder">
						<input name="momo_acg_openai_settings[timeout]" type="range" min="10" max="200" step="1" value="<?php echo esc_attr( $timeout ); ?>" class="momo-be-range-slider inline" autocomplete="off">
						<span class="momo-be-rs-value"><?php echo esc_html( $timeout ); ?></span>
					</span>
				</div>
			</div>
		</div>
	</div>
</div>
