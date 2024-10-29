<?php
/**
 * MoMO ACG - OpenAI Settings
 *
 * @author MoMo Themes
 * @package momochatgpt
 * @since v1.0.0
 */

?>
<div class="momo-admin-content-box">
	<div class="momo-ms-admin-content-main momochatgpt-instructions-main" id="momochatgpt-momo-acg-instructions-form">
		<div class="momo-be-msg-block"></div>
		<div class="momo-be-block-section">
			<h2 class="momo-be-block-section-header"><?php esc_html_e( 'OpenAI ChatGPT Instructions', 'momoacg' ); ?></h2>
			<dl>
				<dt><?php esc_html_e( 'Make sure API key is added / Add OpenAI API key if not added already.', 'momoacg' ); ?></dt>
				<dt><?php esc_html_e( 'Copy this shortcode and paste it in the page you want to display the chat : ', 'momoacg' ); ?><code>[momo_add_chatgpt]</code></dt>
			</dl> 
		</div>
	</div>
</div>
