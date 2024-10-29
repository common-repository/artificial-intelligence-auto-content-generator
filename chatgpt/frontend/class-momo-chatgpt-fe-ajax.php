<?php
/**
 * MoMo ACG - Amin AJAX functions
 *
 * @package momochatgpt
 * @author MoMo Themes
 * @since v1.0.0
 */
class MoMo_ChatGPT_FE_Ajax {
	/**
	 * Constructor
	 */
	public function __construct() {
		$ajax_events = array(
			'momo_chatgpt_openai_generate_answer' => 'momo_chatgpt_openai_generate_answer', // One.
		);
		foreach ( $ajax_events as $ajax_event => $class ) {
			add_action( 'wp_ajax_' . $ajax_event, array( $this, $class ) );
			add_action( 'wp_ajax_nopriv_' . $ajax_event, array( $this, $class ) );
		}
	}
	/**
	 * Generate OpenAI Content ( One )
	 */
	public function momo_chatgpt_openai_generate_answer() {
		global $momoacg;
		$res = check_ajax_referer( 'momochatgpt_security_key', 'security' );
		if ( isset( $_POST['action'] ) && 'momo_chatgpt_openai_generate_answer' !== $_POST['action'] ) {
			return;
		}
		$question = isset( $_POST['question'] ) ? sanitize_text_field( wp_unslash( $_POST['question'] ) ) : '';

		$args = array(
			'question' => $question,
		);
		$momoacg->cgptfe->momo_chatgpt_openai_generate_answer_output_json( $args );
	}
}
new MoMo_ChatGPT_FE_Ajax();
