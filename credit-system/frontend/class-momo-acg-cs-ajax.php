<?php
/**
 * MoMo ACG - Amin AJAX functions
 *
 * @package momoacg
 * @author MoMo Themes
 * @since v3.0.0
 */
class MoMo_ACG_CS_Ajax {
	/**
	 * Constructor
	 */
	public function __construct() {
		$ajax_events = array(
			'momo_acg_cs_add_to_cart_plan'         => 'momo_acg_cs_add_to_cart_plan', // One.
			'momo_acg_cs_check_user_tokens'        => 'momo_acg_cs_check_user_tokens', // Two.
			'momo_acg_openai_generate_headings_synchronously_fe' => 'momo_acg_openai_generate_headings_synchronously_fe', // Three.
			'momo_acg_openai_generate_contents_synchronously_fe' => 'momo_acg_openai_generate_contents_synchronously_fe', // Four.
			'momo_acg_openai_generate_remaining_synchronously_fe' => 'momo_acg_openai_generate_remaining_synchronously_fe', // Five.
			'momo_acg_openai_generate_headings_fe' => 'momo_acg_openai_generate_headings_fe',

		);
		foreach ( $ajax_events as $ajax_event => $class ) {
			add_action( 'wp_ajax_' . $ajax_event, array( $this, $class ) );
			add_action( 'wp_ajax_nopriv_' . $ajax_event, array( $this, $class ) );
		}
	}
	/**
	 * Generate OpenAI Headings ( Three )
	 */
	public function momo_acg_openai_generate_headings_fe() {
		global $momoacg;
		$res = check_ajax_referer( 'momoacgcs_security_key', 'security' );
		if ( isset( $_POST['action'] ) && 'momo_acg_openai_generate_headings_fe' !== $_POST['action'] ) {
			return;
		}
		$language       = isset( $_POST['language'] ) ? sanitize_text_field( wp_unslash( $_POST['language'] ) ) : '';
		$title          = isset( $_POST['title'] ) ? sanitize_text_field( wp_unslash( $_POST['title'] ) ) : '';
		$nopara         = isset( $_POST['nopara'] ) ? sanitize_text_field( wp_unslash( $_POST['nopara'] ) ) : 4;
		$writing_style  = isset( $_POST['writing_style'] ) ? sanitize_text_field( wp_unslash( $_POST['writing_style'] ) ) : 'informative';
		$modifyheadings = isset( $_POST['modifyheadings'] ) ? sanitize_text_field( wp_unslash( $_POST['modifyheadings'] ) ) : 'off';
		$headingwrapper = isset( $_POST['headingwrapper'] ) ? sanitize_text_field( wp_unslash( $_POST['headingwrapper'] ) ) : 'h1';

		$args = array(
			'language'       => $language,
			'title'          => $title,
			'nopara'         => $nopara,
			'writing_style'  => $writing_style,
			'modifyheadings' => $modifyheadings,
			'headingwrapper' => $headingwrapper,
		);
		$momoacg->api->momoacg_openai_generate_headings_output_json( $args );
	}
	/**
	 * Generate OpenAI Content ( One )
	 */
	public function momo_acg_cs_add_to_cart_plan() {
		global $momoacg;
		$res = check_ajax_referer( 'momoacgcs_security_key', 'security' );
		if ( isset( $_POST['action'] ) && 'momo_acg_cs_add_to_cart_plan' !== $_POST['action'] ) {
			return;
		}
		$plan_id = isset( $_POST['plan_id'] ) ? sanitize_text_field( wp_unslash( $_POST['plan_id'] ) ) : '';
		$url     = isset( $_POST['url'] ) ? sanitize_text_field( wp_unslash( $_POST['url'] ) ) : '';
		$args    = array(
			'plan_id' => $plan_id,
		);
		$user_id = get_current_user_id();
		if ( 0 === $user_id ) {
			$url_link = '<a href="' . esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ) . '">' . esc_html__( ' log in', 'momoacg' ) . '</a>';
			echo wp_json_encode(
				array(
					'status' => 'bad',
					/* translators: %1$1s: success number, %2$2s: failure */
					'msg'    => sprintf( esc_html__( 'Only logged in user can purchase plan. Please %s and try again.', 'momoacg' ), $url_link ),
				)
			);
			exit;
		}
		$return = $momoacg->csfe->momo_acg_cs_add_plan_to_cart( $args );
		echo wp_json_encode( $return );
		exit;
	}
	/**
	 * Check User Tokens ( Two )
	 */
	public function momo_acg_cs_check_user_tokens() {
		global $momoacg;
		$res = check_ajax_referer( 'momoacgcs_security_key', 'security' );
		if ( isset( $_POST['action'] ) && 'momo_acg_cs_check_user_tokens' !== $_POST['action'] ) {
			return;
		}
		$url = isset( $_POST['url'] ) ? sanitize_text_field( wp_unslash( $_POST['url'] ) ) : '';
		if ( ! is_user_logged_in() ) {
			$url_link = '<a class="link" href="' . esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ) . '">' . esc_html__( ' log in', 'momoacg' ) . '</a>';
			echo wp_json_encode(
				array(
					'status'      => 'bad',
					/* translators: %1$1s: success number, %2$2s: failure */
					'msg'         => sprintf( esc_html__( 'Only logged in user with plan purchased can use this content generator. Please %s and try again.', 'momoacg' ), $url_link ),
					'user_tokens' => 0,
				)
			);
			exit;
		}
		$client_access_settings = get_option( 'momo_acg_credit_system_settings' );
		$cs_sales_page          = isset( $client_access_settings['cs_sales_page'] ) ? $client_access_settings['cs_sales_page'] : '';

		$user_id = get_current_user_id();
		$plan_id = get_user_meta( $user_id, '_acg_credit_plan_enabled', true );
		if ( empty( $plan_id ) ) {
			$url_link = '<a class="link" href="' . esc_url( get_permalink( $cs_sales_page ) ) . '">' . esc_html__( 'here', 'momoacg' ) . '</a>';
			echo wp_json_encode(
				array(
					'status'      => 'bad',
					/* translators: %s Url link */
					'msg'         => sprintf( esc_html__( 'You do not have sufficient tokens to use this feature. You can get token from %s.', 'momoacg' ), $url_link ),
					'user_tokens' => 0,
				)
			);
			exit;
		} else {
			$plan   = new WC_Product( $plan_id );
			$tokens = $plan->get_meta( '_momo_acg_token_count' );
			if ( empty( $tokens ) ) {
				echo wp_json_encode(
					array(
						'status'      => 'bad',
						'msg'         => sprintf( esc_html__( 'It seems like selected plan does not have token set. Please contact administrator.', 'momoacg' ) ),
						'user_tokens' => 0,
					)
				);
				exit;
			} else {
				$title       = $plan->get_meta( '_momo_acg_plan_title' );
				$span_title  = '<span class="link">' . esc_html__( 'Purchased Plan : ', 'momoacg' ) . '<i>' . esc_html( $title ) . '</i></span></br>';
				$span_tokens = '<span class="tokens">' . esc_html__( 'Tokens Count : ', 'momoacg' ) . '<i>' . esc_html( $tokens ) . '<i></span>';
				echo wp_json_encode(
					array(
						'status'      => 'good',
						'msg'         => $span_title . $span_tokens,
						'user_tokens' => $tokens,
					)
				);
				exit;
			}
		}
	}
	/**
	 * Generate Content Synchronously
	 */
	public function momo_acg_openai_generate_contents_synchronously_fe() {
		global $momoacg;
		$res = check_ajax_referer( 'momoacgcs_security_key', 'security' );
		if ( isset( $_POST['action'] ) && 'momo_acg_openai_generate_contents_synchronously_fe' !== $_POST['action'] ) {
			return;
		}
		$language        = isset( $_POST['language'] ) ? sanitize_text_field( wp_unslash( $_POST['language'] ) ) : '';
		$title           = isset( $_POST['title'] ) ? sanitize_text_field( wp_unslash( $_POST['title'] ) ) : '';
		$addimage        = isset( $_POST['addimage'] ) ? sanitize_text_field( wp_unslash( $_POST['addimage'] ) ) : 'off';
		$addintroduction = isset( $_POST['addintroduction'] ) ? sanitize_text_field( wp_unslash( $_POST['addintroduction'] ) ) : 'off';
		$addconclusion   = isset( $_POST['addconclusion'] ) ? sanitize_text_field( wp_unslash( $_POST['addconclusion'] ) ) : 'off';
		$addheadings     = isset( $_POST['addheadings'] ) ? sanitize_text_field( wp_unslash( $_POST['addheadings'] ) ) : 'off';
		$nopara          = isset( $_POST['nopara'] ) ? sanitize_text_field( wp_unslash( $_POST['nopara'] ) ) : 4;
		$writing_style   = isset( $_POST['writing_style'] ) ? sanitize_text_field( wp_unslash( $_POST['writing_style'] ) ) : 'informative';
		$headingwrapper  = isset( $_POST['headingwrapper'] ) ? sanitize_text_field( wp_unslash( $_POST['headingwrapper'] ) ) : 'h1';
		$addhyperlink    = isset( $_POST['addhyperlink'] ) ? sanitize_text_field( wp_unslash( $_POST['addhyperlink'] ) ) : 'off';
		$hyperlink_text  = isset( $_POST['hyperlink_text'] ) ? sanitize_text_field( wp_unslash( $_POST['hyperlink_text'] ) ) : '';
		$anchor_link     = isset( $_POST['anchor_link'] ) ? sanitize_text_field( wp_unslash( $_POST['anchor_link'] ) ) : '';
		$modifyheadings  = isset( $_POST['modifyheadings'] ) ? sanitize_text_field( wp_unslash( $_POST['modifyheadings'] ) ) : 'off';
		$headings        = isset( $_POST['headings'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['headings'] ) ) : array();
		$paras           = isset( $_POST['paras'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['paras'] ) ) : array();
		$wrappers        = isset( $_POST['wrappers'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['wrappers'] ) ) : array();
		$stage           = isset( $_POST['stage'] ) ? sanitize_text_field( wp_unslash( $_POST['stage'] ) ) : 'initial';
		$heading         = isset( $_POST['heading'] ) ? sanitize_text_field( wp_unslash( $_POST['heading'] ) ) : '';
		$index           = isset( $_POST['index'] ) ? sanitize_text_field( wp_unslash( $_POST['index'] ) ) : 0;
		$pno             = $index + 1;
		$all_style       = $momoacg->lang->momo_get_all_writing_text( $writing_style );

		/** Text Generation Settings */
		$tg_settings       = isset( $_POST['tg_settings'] ) ? sanitize_text_field( wp_unslash( $_POST['tg_settings'] ) ) : '';
		$temperature       = isset( $_POST['temperature'] ) ? sanitize_text_field( wp_unslash( $_POST['temperature'] ) ) : '';
		$max_tokens        = isset( $_POST['max_tokens'] ) ? sanitize_text_field( wp_unslash( $_POST['max_tokens'] ) ) : '';
		$top_p             = isset( $_POST['top_p'] ) ? sanitize_text_field( wp_unslash( $_POST['top_p'] ) ) : '';
		$frequency_penalty = isset( $_POST['frequency_penalty'] ) ? sanitize_text_field( wp_unslash( $_POST['frequency_penalty'] ) ) : '';
		$presence_penalty  = isset( $_POST['presence_penalty'] ) ? sanitize_text_field( wp_unslash( $_POST['presence_penalty'] ) ) : '';
		/** Image Size */
		$image_size = isset( $_POST['image_size'] ) ? sanitize_text_field( wp_unslash( $_POST['image_size'] ) ) : 'small';

		$response = $momoacg->api->momo_acg_check_api_return_json();
		if ( isset( $response['code'] ) && 404 === $response['code'] ) {
			$message = $response['message'];
			$this->momo_generate_exit_signal( $message );
		}
		if ( empty( $title ) ) {
			$message = esc_html__( 'Search title field is empty', 'momoacg' );
			$this->momo_generate_exit_signal( $message );
		}

		$args = array(
			'language'          => $language,
			'title'             => $title,
			'addimage'          => $addimage,
			'addintroduction'   => $addintroduction,
			'addconclusion'     => $addconclusion,
			'addheadings'       => $addheadings,
			'nopara'            => $nopara,
			'writing_style'     => $writing_style,
			'headingwrapper'    => $headingwrapper,
			'addhyperlink'      => $addhyperlink,
			'hyperlink_text'    => $hyperlink_text,
			'anchor_link'       => $anchor_link,
			'modifyheadings'    => $modifyheadings,
			'headings'          => $headings,
			'paras'             => $paras,
			'wrappers'          => $wrappers,
			'tg_settings'       => $tg_settings,
			'temperature'       => $temperature,
			'max_tokens'        => $max_tokens,
			'top_p'             => $top_p,
			'frequency_penalty' => $frequency_penalty,
			'presence_penalty'  => $presence_penalty,
			'image_size'        => $image_size,
		);
		if ( 'headings' === $stage ) {
			$this->momo_generate_headings( $args );
			return;
		}
		$heading             = trim( preg_replace( '/\s+/', ' ', $heading ) );
		$prompt_text_article = $all_style['article'];
		$formatted_prompt    = 'One long paragraph of ' . $prompt_text_article . ' "' . $heading . '" without introduction and conclusion in ' . $language . ' language';
		if ( 'on' === $addheadings ) {
			$formatted_prompt .= ' with heading "' . $heading . '" wrapped in ' . $headingwrapper . '';
		}
		if ( 'on' === $modifyheadings && isset( $paras[ $index ] ) && isset( $wrappers[ $index ] ) ) {
			if ( ! empty( $paras[ $index ] ) ) {
				$formatted_prompt = $paras[ $index ] . ' long paragraph of ' . $prompt_text_article . ' "' . $heading . '" without introduction and conclusion in ' . $language . ' language';
			}
			if ( 'on' === $addheadings ) {
				if ( ! empty( $wrappers[ $index ] ) ) {
					$formatted_prompt .= ' with heading "' . $heading . '" wrapped in ' . $wrappers[ $index ] . '';
				}
			}
		}
		$openai_settings   = get_option( 'momo_acg_openai_settings' );
		$temperature       = isset( $openai_settings['temperature'] ) && ! empty( $openai_settings['temperature'] ) ? $openai_settings['temperature'] : 0.7;
		$max_tokens        = isset( $openai_settings['max_tokens'] ) && ! empty( $openai_settings['max_tokens'] ) ? $openai_settings['max_tokens'] : 2000;
		$top_p             = isset( $openai_settings['top_p'] ) && ! empty( $openai_settings['top_p'] ) ? $openai_settings['top_p'] : 1.0;
		$frequency_penalty = isset( $openai_settings['frequency_penalty'] ) && ! empty( $openai_settings['frequency_penalty'] ) ? $openai_settings['frequency_penalty'] : 0.0;
		$presence_penalty  = isset( $openai_settings['presence_penalty'] ) && ! empty( $openai_settings['presence_penalty'] ) ? $openai_settings['presence_penalty'] : 0.0;

		$tg_settings = isset( $args['tg_settings'] ) ? $args['tg_settings'] : 'off';
		if ( 'on' === $tg_settings ) {
			$temperature       = isset( $args['temperature'] ) && ! empty( $args['temperature'] ) ? $args['temperature'] : 0.7;
			$max_tokens        = isset( $args['max_tokens'] ) && ! empty( $args['max_tokens'] ) ? $args['max_tokens'] : 2000;
			$top_p             = isset( $args['top_p'] ) && ! empty( $args['top_p'] ) ? $args['top_p'] : 1.0;
			$frequency_penalty = isset( $args['frequency_penalty'] ) && ! empty( $args['frequency_penalty'] ) ? $args['frequency_penalty'] : 0.0;
			$presence_penalty  = isset( $args['presence_penalty'] ) && ! empty( $args['presence_penalty'] ) ? $args['presence_penalty'] : 0.0;
		}

		$language_model = isset( $openai_settings['language_model'] ) && ! empty( $openai_settings['language_model'] ) ? $openai_settings['language_model'] : 'text-davinci-003';
		/** Max token limitations */
		$max_tokens = $max_tokens / count( $headings );

		/** Plan wise max_tokens */
		$user_id    = get_current_user_id();
		$plan_id    = get_user_meta( $user_id, '_acg_credit_plan_enabled', true );
		$plan       = new WC_Product( $plan_id );
		$max_tokens = $plan->get_meta( '_momo_acg_token_count' );
		/** Ends plan wise max_tokens */
		$body = array(
			'model'             => $language_model,
			'prompt'            => $formatted_prompt,
			'temperature'       => (float) $temperature,
			'max_tokens'        => (int) $max_tokens < 4097 ? (int) $max_tokens : 4000,
			'top_p'             => (float) $top_p,
			'frequency_penalty' => (float) $frequency_penalty,
			'presence_penalty'  => (float) $presence_penalty,
		);

		$content  = '';
		$url      = 'https://api.openai.com/v1/completions';
		$response = $momoacg->fn->momo_wsw_run_rest_api( 'POST', $url, $body );
		$message  = '';
		if ( is_wp_error( $response ) || ( isset( $response['status'] ) && 429 === $response['status'] ) ) {
			sleep( 20 );
			if (
				( isset( $response->errors['http_request_failed'] ) ) ||
				( isset( $response['status'] ) && 429 === $response['status'] )
			) {
				$message .= '<b>' . esc_html__( 'Error generating paragraph : ', 'momoacg' ) . $pno . '</b></br>' . esc_html__( 'It seems like server is overloaded or rate limit reached. Please try again later.', 'momoacg' );
			} else {
				$message .= esc_html__( 'It seems like server is overloaded or rate limit reached. Please try again later.', 'momoacg' );
			}
			$content = $content;
		} else {
			if ( isset( $response['status'] ) && 200 === $response['status'] && isset( $response['body']->error ) ) {
				$message .= '<b>' . esc_html__( 'Paragraph no: ', 'momoacg' ) . '</b> ' . $pno . ( isset( $response['body']->error->message ) ? $response['body']->error->message : esc_html__( 'Provided url not found.', 'momoacg' ) );
			}
			if ( isset( $response['status'] ) && 200 === $response['status'] ) {
				$choices = isset( $response['body']->choices ) ? $response['body']->choices : array();
				if ( ! empty( $choices ) ) {
					foreach ( $choices as $choice ) {
						$content .= $choice->text;
						$message .= '<b>' . esc_html__( 'Paragraph no: ', 'momoacg' ) . '</b> ' . $pno . esc_html__( ' generated successfully.', 'momoacg' );
					}
				} else {
					$message .= '<b>' . esc_html__( 'Paragraph no: ', 'momoacg' ) . '</b> ' . $pno . esc_html__( 'Not enough choices generated.', 'momoacg' );
				}
			}
			if ( isset( $response['status'] ) && 504 === $response['status'] ) {
				$message .= '<b>' . esc_html__( 'Error generating paragraph : ', 'momoacg' ) . $pno . '</b>' . esc_html__( '504 Gateway timeout error. Cannot get a response in time. Please try again later.', 'momoacg' );
			}
			if ( isset( $response['status'] ) && 400 === $response['status'] ) {
				if ( isset( $response['body']->error->message ) ) {
					$message .= $response['body']->error->message;
				}
			}
		}
		if ( empty( $content ) ) {
			$this->momo_generate_exit_signal( $message );
		} else {
			echo wp_json_encode(
				array(
					'status'    => 'good',
					'msg'       => $message,
					'stage'     => 'generate_content',
					'completed' => 'content_generated',
					'content'   => $content,
					'settings'  => array(
						'temperature'       => $temperature,
						'max_tokens'        => $max_tokens,
						'top_p'             => $top_p,
						'frequency_penalty' => $frequency_penalty,
						'presence_penalty'  => $presence_penalty,
					),
				)
			);
			exit;
		}
	}
	/**
	 * Generate Content Synchronously
	 */
	public function momo_acg_openai_generate_headings_synchronously_fe() {
		global $momoacg;
		$res = check_ajax_referer( 'momoacgcs_security_key', 'security' );
		if ( isset( $_POST['action'] ) && 'momo_acg_openai_generate_headings_synchronously_fe' !== $_POST['action'] ) {
			return;
		}
		$language       = isset( $_POST['language'] ) ? sanitize_text_field( wp_unslash( $_POST['language'] ) ) : '';
		$title          = isset( $_POST['title'] ) ? sanitize_text_field( wp_unslash( $_POST['title'] ) ) : '';
		$nopara         = isset( $_POST['nopara'] ) ? sanitize_text_field( wp_unslash( $_POST['nopara'] ) ) : 4;
		$writing_style  = isset( $_POST['writing_style'] ) ? sanitize_text_field( wp_unslash( $_POST['writing_style'] ) ) : 'informative';
		$headingwrapper = isset( $_POST['headingwrapper'] ) ? sanitize_text_field( wp_unslash( $_POST['headingwrapper'] ) ) : 'h1';
		$modifyheadings = isset( $_POST['modifyheadings'] ) ? sanitize_text_field( wp_unslash( $_POST['modifyheadings'] ) ) : 'off';

		/** Text Generation Settings */
		$tg_settings       = isset( $_POST['tg_settings'] ) ? sanitize_text_field( wp_unslash( $_POST['tg_settings'] ) ) : '';
		$temperature       = isset( $_POST['temperature'] ) ? sanitize_text_field( wp_unslash( $_POST['temperature'] ) ) : '';
		$max_tokens        = isset( $_POST['max_tokens'] ) ? sanitize_text_field( wp_unslash( $_POST['max_tokens'] ) ) : '';
		$top_p             = isset( $_POST['top_p'] ) ? sanitize_text_field( wp_unslash( $_POST['top_p'] ) ) : '';
		$frequency_penalty = isset( $_POST['frequency_penalty'] ) ? sanitize_text_field( wp_unslash( $_POST['frequency_penalty'] ) ) : '';
		$presence_penalty  = isset( $_POST['presence_penalty'] ) ? sanitize_text_field( wp_unslash( $_POST['presence_penalty'] ) ) : '';
		/** Image Size */
		$image_size = isset( $_POST['image_size'] ) ? sanitize_text_field( wp_unslash( $_POST['image_size'] ) ) : 'small';

		$response = $momoacg->api->momo_acg_check_api_return_json();
		if ( isset( $response['code'] ) && 404 === $response['code'] ) {
			$message = $response['message'];
			$this->momo_generate_exit_signal( $message );
		}
		if ( empty( $title ) ) {
			$message = esc_html__( 'Search title field is empty', 'momoacg' );
			$this->momo_generate_exit_signal( $message );
		}

		$args = array(
			'language'          => $language,
			'title'             => $title,
			'nopara'            => $nopara,
			'writing_style'     => $writing_style,
			'headingwrapper'    => $headingwrapper,
			'modifyheadings'    => $modifyheadings,
			'tg_settings'       => $tg_settings,
			'temperature'       => $temperature,
			'max_tokens'        => $max_tokens,
			'top_p'             => $top_p,
			'frequency_penalty' => $frequency_penalty,
			'presence_penalty'  => $presence_penalty,
			'image_size'        => $image_size,
		);

		$return = $this->momo_generate_headings( $args );
		echo wp_json_encode( $return );
		exit;
	}
	/**
	 * Generate Headings
	 *
	 * @param array $args Arguments.
	 */
	public function momo_generate_headings( $args ) {
		global $momoacg;
		$headings = $momoacg->api->momoacg_openai_generate_headings_array( $args );
		if ( ! empty( $headings ) ) {
			$number = count( $headings );
			/* translators: %s: success number */
			$message = sprintf( esc_html__( '%s heading(s) generated from given title.', 'momoacg' ), $number );
			return array(
				'status'    => 'good',
				'msg'       => $message,
				'stage'     => 'generate_content',
				'completed' => 'headings_generated',
				'headings'  => $headings,
				'hstring'   => implode( ', ', $headings ),
				'settings'  => array(
					'temperature'       => $args['temperature'],
					'max_tokens'        => $args['max_tokens'],
					'top_p'             => $args['top_p'],
					'frequency_penalty' => $args['frequency_penalty'],
					'presence_penalty'  => $args['presence_penalty'],
				),
			);
		} else {
			$message = esc_html__( 'Error generating title headings. Please try again later.', 'momoacg' );
			$this->momo_generate_exit_signal( $message );
		}
	}

	/**
	 * Generate remaining contents (Three)
	 */
	public function momo_acg_openai_generate_remaining_synchronously_fe() {
		global $momoacg;
		$res = check_ajax_referer( 'momoacgcs_security_key', 'security' );
		if ( isset( $_POST['action'] ) && 'momo_acg_openai_generate_remaining_synchronously_fe' !== $_POST['action'] ) {
			return;
		}
		$language       = isset( $_POST['language'] ) ? sanitize_text_field( wp_unslash( $_POST['language'] ) ) : '';
		$title          = isset( $_POST['title'] ) ? sanitize_text_field( wp_unslash( $_POST['title'] ) ) : '';
		$writing_style  = isset( $_POST['writing_style'] ) ? sanitize_text_field( wp_unslash( $_POST['writing_style'] ) ) : 'informative';
		$stage          = isset( $_POST['stage'] ) ? sanitize_text_field( wp_unslash( $_POST['stage'] ) ) : '';
		$headingwrapper = isset( $_POST['headingwrapper'] ) ? sanitize_text_field( wp_unslash( $_POST['headingwrapper'] ) ) : 'h1';
		$addheadings    = isset( $_POST['addheadings'] ) ? sanitize_text_field( wp_unslash( $_POST['addheadings'] ) ) : 'off';

		$all_style         = $momoacg->lang->momo_get_all_writing_text( $writing_style );
		$openai_settings   = get_option( 'momo_acg_openai_settings' );
		$temperature       = isset( $openai_settings['temperature'] ) && ! empty( $openai_settings['temperature'] ) ? $openai_settings['temperature'] : 0.7;
		$max_tokens        = isset( $openai_settings['max_tokens'] ) && ! empty( $openai_settings['max_tokens'] ) ? $openai_settings['max_tokens'] : 2000;
		$top_p             = isset( $openai_settings['top_p'] ) && ! empty( $openai_settings['top_p'] ) ? $openai_settings['top_p'] : 1.0;
		$frequency_penalty = isset( $openai_settings['frequency_penalty'] ) && ! empty( $openai_settings['frequency_penalty'] ) ? $openai_settings['frequency_penalty'] : 0.0;
		$presence_penalty  = isset( $openai_settings['presence_penalty'] ) && ! empty( $openai_settings['presence_penalty'] ) ? $openai_settings['presence_penalty'] : 0.0;

		$language_model = isset( $openai_settings['language_model'] ) && ! empty( $openai_settings['language_model'] ) ? $openai_settings['language_model'] : 'text-davinci-003';

		/** Text Generation Settings */
		$tg_settings = isset( $_POST['tg_settings'] ) ? sanitize_text_field( wp_unslash( $_POST['tg_settings'] ) ) : '';
		/** Image Size */
		$image_size = isset( $_POST['image_size'] ) ? sanitize_text_field( wp_unslash( $_POST['image_size'] ) ) : 'small';
		if ( 'on' === $tg_settings ) {
			$temperature       = isset( $_POST['temperature'] ) ? sanitize_text_field( wp_unslash( $_POST['temperature'] ) ) : 0.7;
			$max_tokens        = isset( $_POST['max_tokens'] ) ? sanitize_text_field( wp_unslash( $_POST['max_tokens'] ) ) : 2000;
			$top_p             = isset( $_POST['top_p'] ) ? sanitize_text_field( wp_unslash( $_POST['top_p'] ) ) : 1.0;
			$frequency_penalty = isset( $_POST['frequency_penalty'] ) ? sanitize_text_field( wp_unslash( $_POST['frequency_penalty'] ) ) : 0.0;
			$presence_penalty  = isset( $_POST['presence_penalty'] ) ? sanitize_text_field( wp_unslash( $_POST['presence_penalty'] ) ) : 0.0;
		}
		$body    = array(
			'model'             => $language_model,
			'temperature'       => (float) $temperature,
			'max_tokens'        => (int) $max_tokens,
			'top_p'             => (float) $top_p,
			'frequency_penalty' => (float) $frequency_penalty,
			'presence_penalty'  => (float) $presence_penalty,
		);
		$url     = 'https://api.openai.com/v1/completions';
		$content = '';
		$message = '';
		$status  = 'bad';
		switch ( $stage ) {
			case 'introduction':
				$prompt_text_introduction = $all_style['introduction'];
				$formatted_prompt         = $prompt_text_introduction . ' ' . $title . ' in ' . $language;
				$body['prompt']           = $formatted_prompt;
				if ( 'on' === $addheadings ) {
					$formatted_prompt .= ' with heading wrapped in <' . $headingwrapper . '>';
				}
				$response = $momoacg->fn->momo_wsw_run_rest_api( 'POST', $url, $body );
				if ( is_wp_error( $response ) ) {
					$message = esc_html__( 'Something went wrong with provided output from server.', 'momoacg' );
					$status  = 'bad';
				}
				if ( isset( $response['status'] ) && 404 === $response['status'] && isset( $response['body']->error ) ) {
					$message = isset( $response['body']->error->message ) ? $response['body']->error->message : '<br>' . esc_html__( 'Provided url not found.', 'momoacg' );
					$status  = 'bad';
				}
				if ( isset( $response['status'] ) && 200 === $response['status'] ) {
					$choices = isset( $response['body']->choices ) ? $response['body']->choices : array();
					$intro   = '';
					if ( ! empty( $choices ) ) {
						foreach ( $choices as $choice ) {
							$intro .= $choice->text;
						}
						$content = $intro;
						$message = esc_html__( 'Introduction generated successfully.', 'momoacg' );
						$status  = 'good';
					} else {
						$message = esc_html__( 'Not enough choices generated.', 'momoacg' );
						$status  = 'bad';
					}
				}
				break;
			case 'conclusion':
				$prompt_text_conclusion = $all_style['conclusion'];
				$formatted_prompt       = $prompt_text_conclusion . ' ' . $title . ' in ' . $language;
				if ( 'on' === $addheadings ) {
					$formatted_prompt .= ' with heading wrapped in <' . $headingwrapper . '>';
				}
				$body['prompt'] = $formatted_prompt;
				$response       = $momoacg->fn->momo_wsw_run_rest_api( 'POST', $url, $body );
				if ( is_wp_error( $response ) ) {
					$message = esc_html__( 'Something went wrong with provided output from server.', 'momoacg' );
				}
				if ( isset( $response['status'] ) && 404 === $response['status'] && isset( $response['body']->error ) ) {
					$message .= isset( $response['body']->error->message ) ? $response['body']->error->message : '<br>' . esc_html__( 'Provided url not found.', 'momoacg' );
				}
				if ( isset( $response['status'] ) && 200 === $response['status'] ) {
					$choices = isset( $response['body']->choices ) ? $response['body']->choices : array();
					$conclu  = '';
					if ( ! empty( $choices ) ) {
						foreach ( $choices as $choice ) {
							$conclu .= $choice->text;
						}
						$content = $conclu;
						$status  = 'good';
						$message = esc_html__( 'Conclusion generated successfully.', 'momoacg' );
					} else {
						$message = esc_html__( 'Not enough choices generated.', 'momoacg' );
					}
				}
				break;
			case 'hyperlink':
				$hyperlink_text  = isset( $_POST['hyperlink_text'] ) ? sanitize_text_field( wp_unslash( $_POST['hyperlink_text'] ) ) : '';
				$anchor_link     = isset( $_POST['anchor_link'] ) ? sanitize_text_field( wp_unslash( $_POST['anchor_link'] ) ) : '';
				$content         = isset( $_POST['content'] ) ? wp_kses_post( wp_unslash( $_POST['content'] ) ) : '';
				$replacement_str = '<a href="' . $anchor_link . '">' . $hyperlink_text . '</a>';
				$content         = $momoacg->fn->momo_replace_first_str( $hyperlink_text, $replacement_str, $content );
				$status          = 'good';
				$message         = esc_html__( 'Hyperlink added successfully.', 'momoacg' );
				break;
			case 'image':
				$size_prompt = '256x256';
				if ( 'small' === $image_size ) {
					$size_prompt = '256x256';
				} elseif ( 'medium' === $image_size ) {
					$size_prompt = '512x512';
				} elseif ( 'large' === $image_size ) {
					$size_prompt = '1024x1024';
				}
				$formatted_promt = esc_html__( 'generate an image of a ', 'momoacg' ) . $title;
				$body            = array(
					'model'  => 'image-alpha-001',
					'prompt' => $title,
					'size'   => $size_prompt,
				);

				$url      = 'https://api.openai.com/v1/images/generations';
				$response = $momoacg->fn->momo_wsw_run_rest_api( 'POST', $url, $body );
				if ( isset( $response['status'] ) && 200 === $response['status'] ) {
					$image = isset( $response['body']->data[0]->url ) ? $response['body']->data[0]->url : '';
					if ( ! empty( $image ) ) {
						$imgresult = "<img src='" . $image . "' alt='" . $title . "' />";
						$content   = "\n\n\n" . $imgresult;
						$message   = esc_html__( 'Image generatd successfully.', 'momoacg' );
						$status    = 'good';
					}
				}
				break;
		}
		echo wp_json_encode(
			array(
				'status'   => $status,
				'msg'      => $message,
				'content'  => $content,
				'settings' => array(
					'temperature'       => $temperature,
					'max_tokens'        => $max_tokens,
					'top_p'             => $top_p,
					'frequency_penalty' => $frequency_penalty,
					'presence_penalty'  => $presence_penalty,
				),
			)
		);
		exit;
	}
	/**
	 * Generate Exit Signal.
	 *
	 * @param string $message Message string.
	 */
	public function momo_generate_exit_signal( $message ) {
		echo wp_json_encode(
			array(
				'status' => 'bad',
				'msg'    => $message,
				'stage'  => 'stop',
			)
		);
		exit;
	}
}
new MoMo_ACG_CS_Ajax();
