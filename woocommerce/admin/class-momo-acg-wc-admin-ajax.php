<?php
/**
 * MoMo ACGWC - Amin AJAX functions
 *
 * @package momoacgwc
 * @author MoMo Themes
 * @since v1.0.0
 */
class MoMo_ACG_WC_Admin_Ajax {
	/**
	 * Constructor
	 */
	public function __construct() {
		$ajax_events = array(
			'momo_acg_wc_openai_generate_product' => 'momo_acg_wc_openai_generate_product', // One.
		);
		foreach ( $ajax_events as $ajax_event => $class ) {
			add_action( 'wp_ajax_' . $ajax_event, array( $this, $class ) );
			add_action( 'wp_ajax_nopriv_' . $ajax_event, array( $this, $class ) );
		}
	}
	/**
	 * Generate OpenAI Content ( One )
	 */
	public function momo_acg_wc_openai_generate_product() {
		global $momoacg;
		$res = check_ajax_referer( 'momoacgwc_security_key', 'security' );
		if ( isset( $_POST['action'] ) && 'momo_acg_wc_openai_generate_product' !== $_POST['action'] ) {
			return;
		}
		$language          = isset( $_POST['language'] ) ? sanitize_text_field( wp_unslash( $_POST['language'] ) ) : '';
		$title             = isset( $_POST['title'] ) ? sanitize_text_field( wp_unslash( $_POST['title'] ) ) : '';
		$product_id        = isset( $_POST['product_id'] ) ? sanitize_text_field( wp_unslash( $_POST['product_id'] ) ) : '';
		$temperature       = isset( $_POST['temperature'] ) ? sanitize_text_field( wp_unslash( $_POST['temperature'] ) ) : 0.7;
		$max_tokens        = isset( $_POST['max_tokens'] ) ? sanitize_text_field( wp_unslash( $_POST['max_tokens'] ) ) : 2000;
		$top_p             = isset( $_POST['top_p'] ) ? sanitize_text_field( wp_unslash( $_POST['top_p'] ) ) : 1.0;
		$frequency_penalty = isset( $_POST['frequency_penalty'] ) ? sanitize_text_field( wp_unslash( $_POST['frequency_penalty'] ) ) : 0.0;
		$presence_penalty  = isset( $_POST['presence_penalty'] ) ? sanitize_text_field( wp_unslash( $_POST['presence_penalty'] ) ) : 0.0;
		$args              = array(
			'language'          => $language,
			'title'             => $title,
			'product_id'        => $product_id,
			'temperature'       => $temperature,
			'max_tokens'        => $max_tokens,
			'top_p'             => $top_p,
			'frequency_penalty' => $frequency_penalty,
			'presence_penalty'  => $presence_penalty,
		);
		$momoacg->wcapi->momoacgwc_openai_generate_content_output_json( $args );
	}
}
new MoMo_ACG_WC_Admin_Ajax();
