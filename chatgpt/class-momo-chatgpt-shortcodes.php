<?php
/**
 * MoMo ChatGPT Shortcodes
 *
 * @package momoacg
 * @author MoMo Themes
 * @since v1.0.0
 */
class MoMo_ChatGPT_Shortcodes {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_shortcode( 'momo_add_chatgpt', array( $this, 'momo_add_chatgpt' ) );
	}
	/**
	 * Add ChatGPT UI
	 *
	 * @param array $attributes Attributes.
	 */
	public function momo_add_chatgpt( $attributes ) {
		global $momoacg;
		wp_enqueue_script( 'momochatgpt_fe_script' );
		return $momoacg->cgptfe->momo_chatgpt_generate_chat_ui( $attributes );
	}
}
new MoMo_ChatGPT_Shortcodes();
