<?php

/**
 * MoMO ACG - Chatbot Settings
 *
 * @author MoMo Themes
 * @package momoacg
 * @since v3.4.0
 */
global $momoacg;
$chatbot_settings = get_option( 'momo_acg_chatbot_settings' );
$default_icon = $momoacg->plugin_url . 'chatbot/assets/images/chatbot.svg';
$context = ( isset( $chatbot_settings['context'] ) ? $chatbot_settings['context'] : '' );
$model = ( isset( $chatbot_settings['model'] ) ? $chatbot_settings['model'] : 'gpt-3.5-turbo' );
$temperature = ( isset( $chatbot_settings['temperature'] ) ? $chatbot_settings['temperature'] : '' );
$max_tokens = ( isset( $chatbot_settings['max_tokens'] ) ? $chatbot_settings['max_tokens'] : '' );
$sentence_buffer = ( isset( $chatbot_settings['sentence_buffer'] ) ? $chatbot_settings['sentence_buffer'] : '' );
$max_length = ( isset( $chatbot_settings['max_length'] ) ? $chatbot_settings['max_length'] : '' );
$embeddings_index = ( isset( $chatbot_settings['embeddings_index'] ) ? $chatbot_settings['embeddings_index'] : '' );
$ai_name = ( isset( $chatbot_settings['ai_name'] ) ? $chatbot_settings['ai_name'] : '' );
$welcome_message = ( isset( $chatbot_settings['welcome_message'] ) ? $chatbot_settings['welcome_message'] : '' );
$username = ( isset( $chatbot_settings['username'] ) ? $chatbot_settings['username'] : '' );
$placeholder = ( isset( $chatbot_settings['placeholder'] ) ? $chatbot_settings['placeholder'] : '' );
$typing = ( isset( $chatbot_settings['typing'] ) ? $chatbot_settings['typing'] : '' );
$position = ( isset( $chatbot_settings['position'] ) ? $chatbot_settings['position'] : 'bright' );
$popup = ( isset( $chatbot_settings['popup'] ) ? $chatbot_settings['popup'] : '' );
$icon_url = ( isset( $chatbot_settings['icon_url'] ) ? $chatbot_settings['icon_url'] : $default_icon );
$width = ( isset( $chatbot_settings['width'] ) ? $chatbot_settings['width'] : '' );
$height = ( isset( $chatbot_settings['height'] ) ? $chatbot_settings['height'] : '' );
$enable_ft_chatbot_modal = $momoacg->fn->momo_return_check_option( $chatbot_settings, 'enable_ft_chatbot_modal' );
$selected_ft_chatbot_modal = ( isset( $chatbot_settings['selected_ft_chatbot_modal'] ) ? $chatbot_settings['selected_ft_chatbot_modal'] : '' );
$body = '';
$url = 'https://api.openai.com/v1/fine-tunes';
$response = $momoacg->fn->momo_wsw_run_rest_api( 'GET', $url, '' );
$list = ( isset( $response['body']->data ) ? $response['body']->data : array() );
$is_premium = $momoacg->fn->momoacg_is_premium();
$disabled = '';
if ( !$is_premium ) {
    $enable_woo_helper_block = 'off';
    $enable_auto_desc_on_save = 'off';
    $disabled = "disabled='disabled'";
}
if ( $is_premium && momoacg_fs()->is__premium_only() ) {
    $field = array(
        'type'  => 'popbox',
        'id'    => 'create-ft-model-popbox',
        'class' => 'momo-effect-1',
    );
    $momoacg->fn->momo_generate_popbox( $field );
}
?>
<div class="momo-admin-content-box">
	<div class="momo-ms-admin-content-main momoacg-client-access-main" id="momoacg-momo-acg-client-access-form">
		<div class="momo-be-msg-block"></div>
		<div class="momo-row momo-responsive">
			<div class="momo-col">
				<div class="momo-be-block-section momo-min-h-110">
					<h2 class="momo-be-block-section-header"><?php 
esc_html_e( 'API Configurations', 'momoacg' );
?></h2>
					<div class="momo-row momo-mt-20">
						<div class="momo-col">
							<label><?php 
esc_html_e( 'Context', 'momoacg' );
?></label>
							<textarea rows="5" class="full-width momo-green" placeholder="<?php 
echo esc_html__( 'Interact as if you are a helpdesk. Be polite, courteous and helpful', 'momoacg' );
?>" name="momo_acg_chatbot_settings[context]"><?php 
echo esc_html( $context );
?></textarea>
						</div>
					</div>
					<div class="momo-row momo-mt-20">
						<div class="momo-col">
							<label class="regular"><?php 
esc_html_e( 'Model:', 'momoacg' );
?></label>
							<select id="" name="momo_acg_chatbot_settings[model]" class="full-width momo-green">
									<option value="gpt-3.5-turbo" <?php 
echo esc_attr( ( 'gpt-3.5-turbo' === $model ? 'selected="selected"' : '' ) );
?>><?php 
esc_html_e( 'GPT-3.5 Turbo', 'momoacg' );
?></option>
									<option value="gpt-4" <?php 
echo esc_attr( ( 'gpt-4' === $model ? 'selected="selected"' : '' ) );
?>><?php 
esc_html_e( 'GPT-4 Beta', 'momoacg' );
?></option>
									<option value="text-davinci-003" <?php 
echo esc_attr( ( 'text-davinci-003' === $model ? 'selected="selected"' : '' ) );
?>><?php 
esc_html_e( 'Davinci-003', 'momoacg' );
?></option>
									<option value="text-davinci-002" <?php 
echo esc_attr( ( 'text-davinci-002' === $model ? 'selected="selected"' : '' ) );
?>><?php 
esc_html_e( 'Davinci-002', 'momoacg' );
?></option>
							</select>
						</div>
						<div class="momo-col">
							<label class="regular">
								<?php 
esc_html_e( 'Temperature:', 'momoacg' );
?>
								<span class="momo-be-helper bx bxs-help-circle">
									<span class="momo-be-helper-text">
										<?php 
esc_html_e( 'Higher temperature generates less accurate but diverse and creative output. Lesser temperature will generate more accurate results.', 'momoacg' );
?>
									</span>
								</span>
							</label>
							<input type="text" class="full-width momo-green" name="momo_acg_chatbot_settings[temperature]" placeholder="0.2" value="<?php 
echo esc_attr( $temperature );
?>">
						</div>
						<div class="momo-col momo-be-center">
							<label class="block">
								<?php 
esc_html_e( 'Casually fine-tuned', 'momoacg' );
?>
								<span class="momo-be-helper bx bxs-help-circle">
									<span class="momo-be-helper-text">
										<?php 
esc_html_e( 'This will add stop parameter to API if a new line appears to minimize long answers.', 'momoacg' );
?>
									</span>
								</span>
							</label>
							<span class="momo-be-toggle-container momo-mt-10 momo-block">
								<label class="switch">
									<?php 
$name = 'casually_fine_tuned';
$name_id = 'momo_acg_chatbot_settings[' . $name . ']';
$value = $momoacg->fn->momo_return_check_option( $chatbot_settings, $name );
?>
									<input type="checkbox" class="switch-input" name="<?php 
echo esc_attr( $name_id );
?>" autocomplete="off" <?php 
echo esc_attr( $value );
?> >
									<span class="switch-label" data-on="Yes" data-off="No"></span>
									<span class="switch-handle"></span>
								</label>
							</span>
						</div>
					</div>
					<div class="momo-row momo-mt-20">
						<div class="momo-col">
							<label class="regular">
								<?php 
esc_html_e( 'Max tokens', 'momoacg' );
?>:
								<span class="momo-be-helper bx bxs-help-circle">
									<span class="momo-be-helper-text">
										<?php 
esc_html_e( 'Maximum number of tokens allowed in the response generated by the API. Tokens are chunks of text that can represent individual characters, words, or subwords.', 'momoacg' );
?>
									</span>
								</span>
							</label>
							<input type="number" name="momo_acg_chatbot_settings[max_tokens]" placeholder="660" class="full-width momo-green" value="<?php 
echo esc_attr( $max_tokens );
?>">
						</div>
						<div class="momo-col">
							<label class="regular">
								<?php 
esc_html_e( 'Input max-length', 'momoacg' );
?>:
								<span class="momo-be-helper bx bxs-help-circle">
									<span class="momo-be-helper-text">
										<?php 
esc_html_e( 'Maximum character limit for chatbot input. If left 0, there will not be any restriction on input limit.', 'momoacg' );
?>
									</span>
								</span>
							</label>
							<input type="text" class="full-width momo-green" name="momo_acg_chatbot_settings[max_length]" value="<?php 
echo esc_attr( $max_length );
?>">
						</div>
						<div class="momo-col">
							<label class="regular">
								<?php 
esc_html_e( 'Sentence Buffer', 'momoacg' );
?>:
								<span class="momo-be-helper bx bxs-help-circle">
									<span class="momo-be-helper-text">
										<?php 
esc_html_e( 'This allows for the temporary storage of conversations, enabling the chatbot to utilize them in determining the appropriate reply.', 'momoacg' );
?>
									</span>
								</span>
							</label>
							<span class="momo-be-toggle-container momo-mt-10 momo-block">
								<label class="switch">
									<?php 
$name = 'sentence_buffer';
$name_id = 'momo_acg_chatbot_settings[' . $name . ']';
$value = $momoacg->fn->momo_return_check_option( $chatbot_settings, $name );
?>
									<input type="checkbox" class="switch-input" name="<?php 
echo esc_attr( $name_id );
?>" autocomplete="off" <?php 
echo esc_attr( $value );
?> >
									<span class="switch-label" data-on="Yes" data-off="No"></span>
									<span class="switch-handle"></span>
								</label>
							</span>
						</div>
					</div>
					<div class="momo-row momo-mt-20">
						<div class="momo-col momo-be-center">
							<label class="block">
								<?php 
esc_html_e( 'Content Aware', 'momoacg' );
?>
								<span class="momo-be-helper bx bxs-help-circle">
									<span class="momo-be-helper-text">
										<?php 
esc_html_e( 'This enables the chatbot to utilize the aforementioned context while generating a reply.', 'momoacg' );
?>
									</span>
								</span>
							</label>
							<span class="momo-be-toggle-container momo-mt-10 momo-block">
								<label class="switch">
									<?php 
$name = 'content_aware';
$name_id = 'momo_acg_chatbot_settings[' . $name . ']';
$value = $momoacg->fn->momo_return_check_option( $chatbot_settings, $name );
?>
									<input type="checkbox" class="switch-input" name="<?php 
echo esc_attr( $name_id );
?>" autocomplete="off" <?php 
echo esc_attr( $value );
?> >
									<span class="switch-label" data-on="Yes" data-off="No"></span>
									<span class="switch-handle"></span>
								</label>
							</span>
						</div>
					</div>
					<div class="momo-be-hr-line"></div>
					<div class="momo-be-block">
						<h2 class="momo-be-block-section-header momo-capitalize"><?php 
esc_html_e( 'Shortcode', 'momoacg' );
?></h2>
						<p>
							<?php 
esc_html_e( 'Copy the shortcode and paste it in a page where you want to activate the shortcode.', 'momoacg' );
?>
						</p>
						<p><code>[momo_add_single_chatbot]</code></p>
					</div>
				</div>
			</div>
			<div class="momo-col momo-p-col"></div>
			<div class="momo-col">
				<div class="momo-be-block-section momo-min-h-110">
					<h2 class="momo-be-block-section-header"><?php 
esc_html_e( 'UI Styling', 'momoacg' );
?></h2>
						<div class="momo-row momo-mt-20">
							<div class="momo-col-4">
								<label  class="regular"><?php 
esc_html_e( 'AI Name', 'momoacg' );
?>:</label>
								<input type="text" class="full-width momo-green" placeholder="AI" name="momo_acg_chatbot_settings[ai_name]" value="<?php 
echo esc_attr( $ai_name );
?>">
							</div>
							<div class="momo-col-8">
								<label  class="regular"><?php 
esc_html_e( 'Welcome Message', 'momoacg' );
?>:</label>
								<input type="text" class="full-width momo-green" name="momo_acg_chatbot_settings[welcome_message]" placeholder="How can I help?" value="<?php 
echo esc_attr( $welcome_message );
?>">
							</div>	
						</div>
						<div class="momo-row momo-mt-20">
							<div class="momo-col-4">
								<label  class="regular"><?php 
esc_html_e( 'Username', 'momoacg' );
?>:</label>
								<input type="text" class="full-width momo-green" placeholder="User" name="momo_acg_chatbot_settings[username]" value="<?php 
echo esc_attr( $username );
?>">
							</div>
							<div class="momo-col-8">
								<label  class="regular"><?php 
esc_html_e( 'Placeholder', 'momoacg' );
?>:</label>
								<input type="text" class="full-width momo-green" name="momo_acg_chatbot_settings[placeholder]" placeholder="Type your message here....." value="<?php 
echo esc_attr( $placeholder );
?>">
							</div>	
						</div>
						<!-- <div class="momo-row momo-mt-20">
							<div class="momo-col-8">
								<label  class="regular"><?php 
esc_html_e( 'Typing', 'momoacg' );
?>:</label>
								<input type="text" class="full-width momo-green" name="momo_acg_chatbot_settings[typing]" placeholder="Collecting data" value="<?php 
echo esc_attr( $typing );
?>">
							</div>
						</div> -->
						<div class="momo-row momo-mt-20">
							<div class="momo-col-4">
								<label class="regular"><?php 
esc_html_e( 'Position', 'momoacg' );
?>:</label>
								<select name="momo_acg_chatbot_settings[position]" class="full-width momo-green">
									<option value="bright" <?php 
echo esc_attr( ( 'bright' === $position ? 'selected="selected"' : '' ) );
?>><?php 
esc_html_e( 'Bottom Right', 'momoacg' );
?></option>
									<option value="bleft" <?php 
echo esc_attr( ( 'bleft' === $position ? 'selected="selected"' : '' ) );
?>><?php 
esc_html_e( 'Bottom Left', 'momoacg' );
?></option>
									<option value="tleft" <?php 
echo esc_attr( ( 'tleft' === $position ? 'selected="selected"' : '' ) );
?>><?php 
esc_html_e( 'Top Left', 'momoacg' );
?></option>
									<option value="tright" <?php 
echo esc_attr( ( 'tright' === $position ? 'selected="selected"' : '' ) );
?>><?php 
esc_html_e( 'Top Right', 'momoacg' );
?></option>
								</select>
							</div>
							<div class="momo-col-8">
								<label  class="regular"><?php 
esc_html_e( 'Popup', 'momoacg' );
?>:</label>
								<input type="text" class="full-width momo-green" name="momo_acg_chatbot_settings[popup]" value="<?php 
echo esc_attr( $popup );
?>">
							</div>	
						</div>

						<div class="momo-row momo-mt-20">
							<div class="momo-col">
								<label  class="regular"><?php 
esc_html_e( 'Custom Icon URL', 'momoacg' );
?>:</label>
								<input type="text" class="full-width momo-green" name="momo_acg_chatbot_settings[icon_url]" placeholder="<?php 
echo esc_url( $default_icon );
?>" value="<?php 
echo esc_attr( $icon_url );
?>">
							</div>
						</div>	
						<div class="momo-row momo-mt-20">
							<div class="momo-col">
								<label  class="regular"><?php 
esc_html_e( 'Width', 'momoacg' );
?>:</label>
								<input type="text" class="full-width momo-green" name="momo_acg_chatbot_settings[width]" placeholder="400px" value="<?php 
echo esc_attr( $width );
?>">
							</div>
							<div class="momo-col">
								<label  class="regular"><?php 
esc_html_e( 'Height', 'momoacg' );
?>:</label>
								<input type="text" class="full-width momo-green" name="momo_acg_chatbot_settings[height]" placeholder="600px" value="<?php 
echo esc_attr( $height );
?>">
							</div>
						</div>
				</div>
				<div class="momo-be-hr-line"></div>
				<div class="momo-be-block-section momo-min-h-110">
					<h2 class="momo-be-block-section-header"><?php 
esc_html_e( 'Fine Tuning', 'momoacg' );
?>
					<?php 
if ( !$is_premium ) {
    ?>
						<span class="momo-pro-label"><?php 
    esc_html_e( 'PRO', 'momoacgwc' );
    ?></span>
						<?php 
}
?>
					</h2>
					<div class="momo-be-msg-block"></div>
					<?php 
if ( $is_premium ) {
    ?>
						<?php 
    ?>
					<?php 
}
?>
				</div>
			</div>
		</div>
	</div>
</div>
