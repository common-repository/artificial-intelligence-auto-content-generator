<?php
/**
 * Forms and Toolbars Block
 *
 * @package momoacg
 * @author MoMo Themes
 * @since v3.12.0
 */
class MoMo_ACG_Forms_Block {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'momo_acg_forms_toolbars_block_init' ), 20 );
		add_action( 'rest_api_init', array( $this, 'momo_ai_forms_rest_api_init' ) );
		add_action( 'rest_api_init', array( $this, 'momo_ai_toolbar_rest_api_init' ) );
	}
	/**
	 * Blocks Init
	 */
	public function momo_acg_forms_toolbars_block_init() {
		global $momoacg;
		wp_enqueue_script( 'momo_forms_script', $momoacg->plugin_url . 'forms/assets/momo-forms-fe.js', array( 'jquery' ), $momoacg->version, true );
		register_block_type( __DIR__ . '/build' );
		$settings = array(
			'rest_endpoint'           => get_rest_url() . 'momoacg/v1/aiformresult',
			'rest_toolbar'            => get_rest_url() . 'momoacg/v1/aitoolbar',
			'momoacgforms_ajax_nonce' => wp_create_nonce( 'wp_rest' ),
		);
		wp_localize_script( 'momo_forms_script', 'momo_forms_script', $settings );
	}

	/**
	 * Initialize rest route
	 */
	public function momo_ai_forms_rest_api_init() {
		$slug     = 'momoacg';
		$version  = 'v1';
		$endpoint = 'aiformresult';
		register_rest_route(
			"$slug/$version",
			"/$endpoint",
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'momo_acg_form_post_handler' ),
				'permission_callback' => function () {
					return ( '__return_true' );
				},
			)
		);
	}
	/**
	 * Initialize rest route
	 *
	 * @return void
	 */
	public function momo_ai_toolbar_rest_api_init() {
		$slug     = 'momoacg';
		$version  = 'v1';
		$endpoint = 'aitoolbar';
		register_rest_route(
			"$slug/$version",
			"/$endpoint",
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'momo_acg_toolbar_click_handler' ),
				'permission_callback' => function () {
					return ( '__return_true' );
				},
			)
		);
	}
	/**
	 * Handle Form Request
	 *
	 * @param WP_Request $request request.
	 */
	public function momo_acg_form_post_handler( $request ) {
		global $momoacg;
		$attributes = $request->get_params();
		$forms      = isset( $attributes['forms'] ) && ! empty( $attributes['forms'] ) ? $attributes['forms'] : array();
		$submit     = isset( $attributes['submit'] ) && ! empty( $attributes['submit'] ) ? $attributes['submit'] : '';
		$prompt     = isset( $attributes['prompt'] ) && ! empty( $attributes['prompt'] ) ? $attributes['prompt'] : '';
		if ( empty( $prompt ) ) {
			$data = '';
			foreach ( $forms as $fe ) {
				$data .= $fe['label'] . ' - ' . $fe['value'] . "\n";
			}
			$query_prompt = $submit . ' with following data available ( ' . $data . ' ), without saying that youre an AI model and please a long paragraph';
			$message      = array(
				'role'    => 'user',
				'content' => $query_prompt,
			);
		} else {
			$data = '';
			foreach ( $forms as $fe ) {
				$prompt = str_replace( '{' . $fe['name'] . '}', $fe['value'], $prompt );
			}
			$message = array(
				'role'    => 'user',
				'content' => $prompt,
			);
		}
		$model       = isset( $chatbot_settings['selected_ft_chatbot_modal'] ) ? $chatbot_settings['selected_ft_chatbot_modal'] : 'gpt-3.5-turbo';
		$temperature = isset( $chatbot_settings['temperature'] ) && ! empty( $chatbot_settings['temperature'] ) ? $chatbot_settings['temperature'] : '0.7';
		$max_tokens  = isset( $chatbot_settings['max_tokens'] ) && ! empty( $chatbot_settings['max_tokens'] ) ? $chatbot_settings['max_tokens'] : '660';

		$body     = array(
			'model'             => $model,
			'temperature'       => (float) $temperature,
			'max_tokens'        => (int) $max_tokens,
			'top_p'             => 1,
			'frequency_penalty' => 0,
			'presence_penalty'  => 0,
			'messages'          => array( $message ),
		);
		$url      = 'https://api.openai.com/v1/chat/completions';
		$response = $momoacg->fn->momo_wsw_run_rest_api( 'POST', $url, $body );
		$content  = '';
		$message  = '';
		$status   = 'bad';
		if ( is_wp_error( $response ) ) {
			$message = esc_html__( 'Something went wrong with provided output from server.', 'momoacg' );
			$status  = 'bad';
		}
		if ( isset( $response['status'] ) && 404 === $response['status'] ) {
			$message .= isset( $response['body']->error->message ) ? $response['body']->error->message : esc_html__( 'Provided url not found.', 'momoacg' );
			$status   = 'bad';
		}
		if ( isset( $response['status'] ) && 400 === $response['status'] ) {
			$message .= isset( $response['body']->error->message ) ? $response['body']->error->message : esc_html__( 'Provided url not found.', 'momoacg' );
			$status   = 'bad';
		}
		if ( isset( $response['status'] ) && 200 === $response['status'] ) {
			$choices = isset( $response['body']->choices ) ? $response['body']->choices : array();

			foreach ( $choices as $choice ) {
				if ( 'gpt-3.5-turbo' === $model || 'gpt-4' === $model ) {
					$message .= $choice->message->content;

				} else {
					$message .= $choice->text;

				}
				$status = 'good';
			}
		}
		return new WP_REST_Response(
			array(
				'status'  => $status,
				'message' => $message,
				'content' => '',
			),
			200
		);
	}
	/**
	 * Handle Form Request
	 *
	 * @param WP_Request $request request.
	 */
	public function momo_acg_toolbar_click_handler( $request ) {
		global $momoacg;
		$attributes = $request->get_params();
		$content    = isset( $attributes['content'] ) && ! empty( $attributes['content'] ) ? $attributes['content'] : '';
		$type       = isset( $attributes['type'] ) && ! empty( $attributes['type'] ) ? $attributes['type'] : 'summarize';

		$prompt = '';
		switch ( $type ) {
			case 'summarize':
				$prompt = esc_html__( 'Summarize this content : ', 'momoacg' );
				break;
			case 'paraphrase':
				$prompt = esc_html__( 'Paraphrase this content : ', 'momoacg' );
				break;
			case 'rewrite':
				$prompt = esc_html__( 'Rewrite this content : ', 'momoacg' );
				break;
			case 'write_title':
				$prompt = esc_html__( 'Write a title for this content : ', 'momoacg' );
				break;
			default:
				$prompt = esc_html__( 'Summarize this content : ', 'momoacg' );
				break;
		}
		$model       = isset( $toolbar_settings['selected_toolbar_modal'] ) ? $toolbar_settings['selected_toolbar_modal'] : 'text-davinci-003';
		$temperature = isset( $toolbar_settings['temperature'] ) && ! empty( $toolbar_settings['temperature'] ) ? $toolbar_settings['temperature'] : '0.7';
		$max_tokens  = isset( $toolbar_settings['max_tokens'] ) && ! empty( $toolbar_settings['max_tokens'] ) ? $toolbar_settings['max_tokens'] : '660';

		$body     = array(
			'model'             => $model,
			'temperature'       => (float) $temperature,
			'max_tokens'        => (int) $max_tokens,
			'top_p'             => 1,
			'frequency_penalty' => 0,
			'presence_penalty'  => 0,
			'prompt'            => $prompt . "\n$content",
		);
		$url      = 'https://api.openai.com/v1/completions';
		$response = $momoacg->fn->momo_wsw_run_rest_api( 'POST', $url, $body );
		if ( is_wp_error( $response ) ) {
			$message = esc_html__( 'Something went wrong with provided output from server.', 'momoacg' );
			$status  = 'bad';
		}
		if ( isset( $response['status'] ) && 404 === $response['status'] ) {
			$message .= isset( $response['body']->error->message ) ? $response['body']->error->message : esc_html__( 'Provided url not found.', 'momoacg' );
			$status   = 'bad';
		}
		if ( isset( $response['status'] ) && 400 === $response['status'] ) {
			$message .= isset( $response['body']->error->message ) ? $response['body']->error->message : esc_html__( 'Provided url not found.', 'momoacg' );
			$status   = 'bad';
		}
		if ( isset( $response['status'] ) && 200 === $response['status'] ) {
			$choices = isset( $response['body']->choices ) ? $response['body']->choices : array();

			foreach ( $choices as $choice ) {
				if ( 'gpt-3.5-turbo' === $model || 'gpt-4' === $model ) {
					$message .= $choice->message->content;

				} else {
					$message .= $choice->text;

				}
				$status = 'good';
			}
		}
		return new WP_REST_Response(
			array(
				'status'  => $status,
				'message' => $message,
				'content' => '',
			),
			200
		);

	}
}
new MoMo_ACG_Forms_Block();
