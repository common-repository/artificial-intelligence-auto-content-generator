<?php
/**
 * MoMO ACG - OpenAI Settings
 *
 * @author MoMo Themes
 * @package momoacg
 * @since v1.1.0
 */

global $momoacg;
$openai_settings   = get_option( 'momo_chatgpt_openai_settings' );
$api_key           = isset( $openai_settings['api_key'] ) ? $openai_settings['api_key'] : '';
$temperature       = isset( $openai_settings['temperature'] ) ? $openai_settings['temperature'] : '';
$max_tokens        = isset( $openai_settings['max_tokens'] ) ? $openai_settings['max_tokens'] : '';
$top_p             = isset( $openai_settings['top_p'] ) ? $openai_settings['top_p'] : '';
$frequency_penalty = isset( $openai_settings['frequency_penalty'] ) ? $openai_settings['frequency_penalty'] : '';
$presence_penalty  = isset( $openai_settings['presence_penalty'] ) ? $openai_settings['presence_penalty'] : '';
$language_model    = isset( $openai_settings['language_model'] ) ? $openai_settings['language_model'] : 'text-davinci-003';

$heading    = isset( $openai_settings['heading'] ) ? $openai_settings['heading'] : '';
$subheading = isset( $openai_settings['subheading'] ) ? $openai_settings['subheading'] : '';
$writer     = isset( $openai_settings['writer'] ) ? $openai_settings['writer'] : '';
$replier    = isset( $openai_settings['replier'] ) ? $openai_settings['replier'] : '';
?>
<div class="momo-admin-content-box">
	<div class="momo-ms-admin-content-main momoacg-export-settings-main" id="momoacg-momo-wsw-export-settings-form">
		<div class="momo-be-msg-block"></div>
		<div class="momo-row momo-responsive">
			<div class="momo-col">
				<div class="momo-be-block-section momo-min-h-110">
					<h2 class="momo-be-block-section-header"><?php esc_html_e( 'Shortcode page settings', 'momoacg' ); ?></h2>
					<div class="momo-be-block">
						<label class="regular"><?php esc_html_e( 'Heading', 'momowsw' ); ?></label>
						<input type="text" class="wide" name="momo_chatgpt_openai_settings[heading]" value="<?php echo esc_attr( $heading ); ?>" placeholder="<?php echo esc_attr( 'Hello, Welcome!' ); ?>"/>
					</div>
					<div class="momo-be-block">
						<label class="regular"><?php esc_html_e( 'Subheading', 'momowsw' ); ?></label>
						<input type="text" class="wide" name="momo_chatgpt_openai_settings[subheading]" value="<?php echo esc_attr( $subheading ); ?>" placeholder="<?php echo esc_attr( 'Ask Me' ); ?>"/>
					</div>
				</div>
			</div>
			<div class="momo-col momo-p-col"></div>
			<div class="momo-col">
				<div class="momo-be-block-section momo-min-h-110">
					<h2 class="momo-be-block-section-header"><?php esc_html_e( 'Output Settings', 'momoacg' ); ?></h2>
					<div class="momo-be-block">
						<label class="regular"><?php esc_html_e( 'Writer', 'momowsw' ); ?></label>
						<input type="text" class="wide" name="momo_chatgpt_openai_settings[writer]" value="<?php echo esc_attr( $writer ); ?>" placeholder="<?php echo esc_attr( 'Question' ); ?>"/>
					</div>
					<div class="momo-be-block">
						<label class="regular"><?php esc_html_e( 'Replier', 'momowsw' ); ?></label>
						<input type="text" class="wide" name="momo_chatgpt_openai_settings[replier]" value="<?php echo esc_attr( $replier ); ?>" placeholder="<?php echo esc_attr( 'Answer' ); ?>"/>
					</div>
				</div>
			</div>
		</div>
		<div class="momo-be-hr-line"></div>
		<div class="momo-be-block-section">
			<h2 class="momo-be-block-section-header"><?php esc_html_e( 'API Settings ( Optional )', 'momoacg' ); ?></h2>
			<div class="momo-be-block">
				<div class="momo-padding-12 momo-col-3">
					<label class="regular inline"><?php esc_html_e( 'Language Model', 'momoacg' ); ?></label>
					<select class="inline" name="momo_chatgpt_openai_settings[language_model]">
						<option value="text-davinci-003" <?php echo ( 'text-davinci-003' === $language_model ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'DaVinci-003', 'momoacg' ); ?></option>
						<option value="gpt-3.5-turbo" <?php echo ( 'gpt-3.5-turbo' === $language_model ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'GPT-3.5-Turbo', 'momoacg' ); ?></option>
						<option value="gpt-4" <?php echo ( 'gpt-4' === $language_model ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'GPT-4 Beta', 'momoacg' ); ?></option>
					</select>
				</div>
			</div>
			<div class="momo-be-hr-line"></div>
			<div class="momo-row">
				<div class="momo-padding-12 momo-col-3">
					<div class="momo-be-range-slider-container momo-full-page">
						<label for="momo_chatgpt_openai_settings[temperature]" class="block">
							<?php esc_html_e( 'Temperature', 'momoacg' ); ?>
							<span class="momo-be-helper bx bxs-help-circle">
								<span class="momo-be-helper-text">
									<?php esc_html_e( 'Higher temperature generates less accurate but diverse and creative output. Lesser temperature will generate more accurate results.', 'momoacg' ); ?>
								</span>
							</span>
						</label>
						<span class="momo-range-input-holder">
							<input name="momo_chatgpt_openai_settings[temperature]" type="range" min="0.1" max="1" step="0.1" value="<?php echo esc_attr( $temperature ); ?>" class="momo-be-range-slider inline" autocomplete="off">
							<span class="momo-be-rs-value"><?php echo esc_html( $temperature ); ?></span>
						</span>
					</div>
				</div>
				<div class="momo-padding-12 momo-col-3">
					<div class="momo-be-range-slider-container momo-full-page">
						<label for="momo_chatgpt_openai_settings[max_tokens]" class="block">
							<?php esc_html_e( 'Maximum Tokens', 'momoacg' ); ?>
							<span class="momo-be-helper bx bxs-help-circle">
								<span class="momo-be-helper-text">
									<?php esc_html_e( 'Use it in combination with "Temperature" to control the randomness and creativity of the output.', 'momoacg' ); ?>
								</span>
							</span>
						</label>
						<span class="momo-range-input-holder">
							<input name="momo_chatgpt_openai_settings[max_tokens]" type="range" min="0" max="3000" step="30" value="<?php echo esc_attr( $max_tokens ); ?>" class="momo-be-range-slider inline" autocomplete="off">
							<span class="momo-be-rs-value"><?php echo esc_html( $max_tokens ); ?></span>
						</span>
					</div>
				</div>
				<div class="momo-padding-12 momo-col-3">
					<div class="momo-be-range-slider-container momo-full-page">
						<label for="momo_chatgpt_openai_settings[top_p]" class="block">
							<?php esc_html_e( 'Top P', 'momoacg' ); ?>
							<span class="momo-be-helper bx bxs-help-circle">
								<span class="momo-be-helper-text">
									<?php esc_html_e( 'To control randomness of the output.', 'momoacg' ); ?>
								</span>
							</span>
						</label>
						<span class="momo-range-input-holder">
							<input name="momo_chatgpt_openai_settings[top_p]" type="range" min="0" max="1" step="0.1" value="<?php echo esc_attr( $top_p ); ?>" class="momo-be-range-slider inline" autocomplete="off">
							<span class="momo-be-rs-value"><?php echo esc_html( $top_p ); ?></span>
						</span>
					</div>
				</div>
			</div>
			<div class="momo-row">
				<div class="momo-col momo-col-3">
					<div class="momo-be-range-slider-container momo-full-page">
						<label for="momo_chatgpt_openai_settings[frequency_penalty]" class="block">
							<?php esc_html_e( 'Frequency Penalty', 'momoacg' ); ?>
							<span class="momo-be-helper bx bxs-help-circle">
								<span class="momo-be-helper-text">
									<?php esc_html_e( 'For improving the quality and coherence of the generated text.', 'momoacg' ); ?>
								</span>
							</span>
						</label>
						<span class="momo-range-input-holder">
							<input name="momo_chatgpt_openai_settings[frequency_penalty]" type="range" min="0" max="2" step="0.2" value="<?php echo esc_attr( $frequency_penalty ); ?>" class="momo-be-range-slider inline" autocomplete="off">
							<span class="momo-be-rs-value"><?php echo esc_html( $frequency_penalty ); ?></span>
						</span>
					</div>
				</div>
				<div class="momo-col momo-col-3">
					<div class="momo-be-range-slider-container momo-full-page">
						<label for="momo_chatgpt_openai_settings[presence_penalty]" class="block">
							<?php esc_html_e( 'Presence Penalty', 'momoacg' ); ?>
							<span class="momo-be-helper bx bxs-help-circle">
								<span class="momo-be-helper-text">
									<?php esc_html_e( 'To produce more concise text.', 'momoacg' ); ?>
								</span>
							</span>
						</label>
						<span class="momo-range-input-holder">
							<input name="momo_chatgpt_openai_settings[presence_penalty]" type="range" min="0" max="2" step="0.2" value="<?php echo esc_attr( $presence_penalty ); ?>" class="momo-be-range-slider inline" autocomplete="off">
							<span class="momo-be-rs-value"><?php echo esc_html( $presence_penalty ); ?></span>
						</span>
					</div>
				</div>
				<div class="momo-col momo-col-3"></div>
			</div>
		</div>
	</div>
</div>
