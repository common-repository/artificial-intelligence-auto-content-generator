<?php
/**
 * MoMo ChatGPT Frontend
 *
 * @package momochatgpt
 * @author MoMo Themes
 * @since v1.0.0
 */
class MoMo_ChatGPT_Frontend {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'momo_chatgpt_load_scripts_styles' ), 10 );
	}
	/**
	 * Load script and styles
	 *
	 * @return void
	 */
	public function momo_chatgpt_load_scripts_styles() {
		global $momoacg;
		wp_enqueue_style( 'momochatgpt_boxicons', $momoacg->plugin_url . 'assets/boxicons/css/boxicons.min.css', array(), '2.2.0' );
		wp_enqueue_style( 'momochatgpt_fe_style', $momoacg->plugin_url . 'chatgpt/assets/css/momo_chatgpt_fe.css', array(), $momoacg->version );
		wp_register_script( 'momochatgpt_fe_script', $momoacg->plugin_url . 'chatgpt/assets/js/momo_chatgpt_fe.js', array( 'jquery' ), $momoacg->version, true );

		$openai_settings = get_option( 'momo_chatgpt_openai_settings' );
		$writer          = isset( $openai_settings['writer'] ) && ! empty( $openai_settings['writer'] ) ? $openai_settings['writer'] : esc_html__( 'Question', 'momoacg' );
		$replier         = isset( $openai_settings['replier'] ) && ! empty( $openai_settings['replier'] ) ? $openai_settings['replier'] : esc_html__( 'Answer', 'momoacg' );

		$ajaxurl = array(
			'ajaxurl'                => admin_url( 'admin-ajax.php' ),
			'momochatgpt_ajax_nonce' => wp_create_nonce( 'momochatgpt_security_key' ),
			'sender'                 => $writer,
			'answer'                 => $replier,
		);
		wp_localize_script( 'momochatgpt_fe_script', 'momochatgpt_fe', $ajaxurl );
	}
	/**
	 * Generate CHhatGPT UI
	 *
	 * @param array $attributes Attributes.
	 */
	public function momo_chatgpt_generate_chat_ui( $attributes ) {
		$openai_settings = get_option( 'momo_chatgpt_openai_settings' );
		$heading         = isset( $openai_settings['heading'] ) && ! empty( $openai_settings['heading'] ) ? $openai_settings['heading'] : esc_html__( 'Hello, Welcome!', 'momoacg' );
		$subheading      = isset( $openai_settings['subheading'] ) && ! empty( $openai_settings['subheading'] ) ? $openai_settings['subheading'] : esc_html__( 'Ask Me', 'momoacg' );
		ob_start();
		?>
		<div class="momo-chatgpt-ui-container">
			<div class="momo-chatgpt-uic-top-section">
				<div class="momo-chatgpt-ui-header">
					<?php echo esc_html( $heading ); ?>
				</div>
				<div class="momo-chatgpt-ui-subheader">
					<?php echo esc_html( $subheading ); ?>
				</div>
			</div>
			<div class="momo-chatgpt-uic-middle-section">
				<div class="momo-chatgpt-messages"></div>
			</div>
			<div class="momo-chatgpt-uic-bottom-section">
				<div class="momo-fe-working"></div>
				<div class="momo-chatgpt-sender-box">
					<input type="text" name="momo_chatgpt_sender_input" class="momo-chatgpt-sender-input">
					<i class='bx bxs-send'></i>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
	/**
	 * Run plugin rest API function
	 *
	 * @param string $method Method.
	 * @param string $url Remaining url.
	 * @param array  $body Body arguments.
	 */
	public function momo_chatgpt_run_rest_api( $method, $url, $body ) {
		$openai_settings = get_option( 'momo_acg_openai_settings' );
		$api_key         = isset( $openai_settings['api_key'] ) ? $openai_settings['api_key'] : '';
		if ( empty( $api_key ) ) {
			$response = array(
				'status'  => 'bad',
				'message' => esc_html__( 'Empty API key, please store OpenAI API key in MoMo ACG settings first.', 'momoacg' ),
			);
			return $response;
		}
		$timeout = 45;

		$args = array(
			'headers' => array(
				'Content-Type'  => 'application/json',
				'Authorization' => 'Bearer ' . $api_key,
			),
			'method'  => $method,
			'timeout' => $timeout,
		);
		if ( ! empty( $body ) ) {
			$args['body'] = wp_json_encode( $body );
		}
		$response = 'POST' === $method ? wp_remote_post( $url, $args ) : wp_remote_request( $url, $args );
		$json     = wp_remote_retrieve_body( $response );
		$details  = json_decode( $json );
		if ( ! is_wp_error( $response ) && isset( $response['response'] ) ) {
			$response = array(
				'status'  => $response['response']['code'],
				'message' => $response['response']['message'],
				'code'    => $response['response']['code'],
				'body'    => json_decode( $response['body'] ),
			);
			return $response;
		}
		return $response;
	}
	/**
	 * Generate Answer JSON format
	 *
	 * @param array $args Arguments.
	 */
	public function momo_chatgpt_openai_generate_answer_output_json( $args ) {
		$question          = isset( $args['question'] ) ? $args['question'] : '';
		$openai_settings   = get_option( 'momo_chatgpt_openai_settings' );
		$temperature       = isset( $openai_settings['temperature'] ) && ! empty( $openai_settings['temperature'] ) ? $openai_settings['temperature'] : 0.7;
		$max_tokens        = isset( $openai_settings['max_tokens'] ) && ! empty( $openai_settings['max_tokens'] ) ? $openai_settings['max_tokens'] : 100;
		$top_p             = isset( $openai_settings['top_p'] ) && ! empty( $openai_settings['top_p'] ) ? $openai_settings['top_p'] : 1.0;
		$frequency_penalty = isset( $openai_settings['frequency_penalty'] ) && ! empty( $openai_settings['frequency_penalty'] ) ? $openai_settings['frequency_penalty'] : 0.0;
		$presence_penalty  = isset( $openai_settings['presence_penalty'] ) && ! empty( $openai_settings['presence_penalty'] ) ? $openai_settings['presence_penalty'] : 0.0;
		$language_model    = isset( $openai_settings['language_model'] ) && ! empty( $openai_settings['language_model'] ) ? $openai_settings['language_model'] : 'text-davinci-003';

		$formatted_prompt = $question . ' ?';
		switch ( $language_model ) {
			case 'text-davinci-003':
				$body = array(
					'model'             => $language_model,
					'prompt'            => $formatted_prompt,
					'temperature'       => (float) $temperature,
					'max_tokens'        => (int) $max_tokens,
					'top_p'             => (float) $top_p,
					'frequency_penalty' => (float) $frequency_penalty,
					'presence_penalty'  => (float) $presence_penalty,
				);
				$url  = 'https://api.openai.com/v1/completions';
				break;
			case 'gpt-3.5-turbo':
				$body = array(
					'model'             => 'gpt-3.5-turbo',
					'messages'          => array(
						array(
							'role'    => 'user',
							'content' => $formatted_prompt,
						),
					),
					'temperature'       => (float) $temperature,
					'max_tokens'        => (int) $max_tokens,
					'top_p'             => (float) $top_p,
					'frequency_penalty' => (float) $frequency_penalty,
					'presence_penalty'  => (float) $presence_penalty,
				);
				$url  = 'https://api.openai.com/v1/chat/completions';
				break;
			case 'gpt-4':
				$body = array(
					'model'             => $language_model,
					'prompt'            => $formatted_prompt,
					'temperature'       => (float) $temperature,
					'max_tokens'        => (int) 60,
					'top_p'             => (float) $top_p,
					'frequency_penalty' => (float) $frequency_penalty,
					'presence_penalty'  => (float) $presence_penalty,
				);
				$url  = 'https://api.openai.com/v1/engine/chat';
				$url  = 'https://api.openai.com/v1/chat/completions';
				break;
			default:
				$body = array(
					'model'             => $language_model,
					'prompt'            => $formatted_prompt,
					'temperature'       => (float) $temperature,
					'max_tokens'        => (int) $max_tokens,
					'top_p'             => (float) $top_p,
					'frequency_penalty' => (float) $frequency_penalty,
					'presence_penalty'  => (float) $presence_penalty,
				);
				$url  = 'https://api.openai.com/v1/completions';
				break;
		}

		$content  = '';
		$message  = '';
		$response = $this->momo_chatgpt_run_rest_api( 'POST', $url, $body );
		if ( isset( $response['status'] ) && 404 === $response['status'] ) {
			$message .= isset( $response['body']->error->message ) ? $response['body']->error->message : esc_html__( 'Provided url not found.', 'momoacg' );
		}
		if ( isset( $response['status'] ) && 200 === $response['status'] ) {
			$choices = isset( $response['body']->choices ) ? $response['body']->choices : array();
			if ( ! empty( $choices ) ) {
				foreach ( $choices as $choice ) {
					if ( 'gpt-4' === $language_model || 'text-davinci-003' === $language_model ) {
						$content .= $choice->text;
					} elseif ( 'gpt-3.5-turbo' === $language_model ) {
						$content .= $choice->message->content;
					}
				}
			} else {
				$message .= esc_html__( 'Not enough choices generated.', 'momoacg' );
			}
		}
		if ( ! empty( $content ) ) {
			echo wp_json_encode(
				array(
					'status'  => 'good',
					'msg'     => esc_html__( 'Content generated successfully.', 'momoacg' ),
					'content' => $content,
				)
			);
			exit;
		}
		echo wp_json_encode(
			array(
				'status'  => 'bad',
				'msg'     => empty( $message ) ? esc_html__( 'Something went wrong while generating answer. Please try again.', 'momoacg' ) : $message,
				'content' => empty( $message ) ? esc_html__( 'Something went wrong while generating answer. Please try again.', 'momoacg' ) : $message
			)
		);
		exit;
	}
}
