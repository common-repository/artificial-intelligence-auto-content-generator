<?php
/**
 * Rest API Class for MoMo Auto Content Generator
 *
 * @author   mywptrek
 * @version  1.0.0
 * @package  momoacg
 */
class MoMo_ACG_Rest_API {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'momo_acg_initiate_rest_api' ) );
	}
	/**
	 * Register Rest Route
	 */
	public function momo_acg_initiate_rest_api() {
		$version   = '1';
		$namespace = 'momoacg/v' . $version;
		$base      = 'openai-contents';
		register_rest_route(
			$namespace,
			$base,
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'momo_acg_generate_openai_contents' ),
				'permission_callback' => function () {
					return ( '__return_true' );
				},
			)
		);
	}
	/**
	 * Generate OpenAI Contents
	 *
	 * @param WP_Rest_Request $request Request.
	 */
	public function momo_acg_generate_openai_contents( $request ) {
		global $momoacg;
		$attributes          = $request->get_params();
		$language            = isset( $attributes['language'] ) ? $attributes['language'] : 'english';
		$title               = isset( $attributes['title'] ) ? $attributes['title'] : '';
		$no_of_para          = isset( $attributes['noOfPara'] ) ? $attributes['noOfPara'] : 4;
		$headings_yes_no     = isset( $attributes['headingsYesNo'] ) ? ( ( true === $attributes['headingsYesNo'] ) ? 'on' : 'off' ) : 'off';
		$headings_wrapper    = isset( $attributes['headingsWrapper'] ) ? $attributes['headingsWrapper'] : 'h1';
		$writing_style       = isset( $attributes['writingStyle'] ) ? $attributes['writingStyle'] : 'informative';
		$introduction_yes_no = isset( $attributes['introductionYesNo'] ) ? ( ( true === $attributes['introductionYesNo'] ) ? 'on' : 'off' ) : 'off';
		$conclusion_yes_no   = isset( $attributes['conclusionYesNo'] ) ? ( ( true === $attributes['conclusionYesNo'] ) ? 'on' : 'off' ) : 'off';
		$image_yes_no        = isset( $attributes['imageYesNo'] ) ? ( ( true === $attributes['imageYesNo'] ) ? 'on' : 'off' ) : 'off';
		$hyperlink_yes_no    = isset( $attributes['hyperlinkYesNo'] ) ? ( ( true === $attributes['hyperlinkYesNo'] ) ? 'on' : 'off' ) : 'off';
		$hyperlink_text      = isset( $attributes['hyperlinkText'] ) ? ( ( true === $attributes['hyperlinkText'] ) ? 'on' : 'off' ) : 'off';
		$anchor_link         = isset( $attributes['anchorLink'] ) ? ( ( true === $attributes['anchorLink'] ) ? 'on' : 'off' ) : 'off';
		$modifyheadings      = isset( $attributes['modifyHeadings'] ) ? ( ( true === $attributes['modifyHeadings'] ) ? 'on' : 'off' ) : 'off';
		$headings            = isset( $attributes['headings'] ) ? $attributes['headings'] : array();
		$paras               = isset( $attributes['paras'] ) ? $attributes['paras'] : array();
		$wrappers            = isset( $attributes['wrappers'] ) ? $attributes['wrappers'] : array();
		$args                = array(
			'language'        => $language,
			'title'           => $title,
			'nopara'          => $no_of_para,
			'addheadings'     => $headings_yes_no,
			'headingwrapper'  => $headings_wrapper,
			'writing_style'   => $writing_style,
			'addintroduction' => $introduction_yes_no,
			'addconclusion'   => $conclusion_yes_no,
			'addimage'        => $image_yes_no,
			'addhyperlink'    => $hyperlink_yes_no,
			'hyperlink_text'  => $hyperlink_text,
			'anchor_link'     => $anchor_link,
			'modifyheadings'  => $modifyheadings,
			'headings'        => $headings,
			'paras'           => $paras,
			'wrappers'        => $wrappers,
		);

		$return = $this->momoacg_openai_generate_content_output_json( $args );
	}
	/**
	 * Generate json output
	 *
	 * @param array  $args Arguments.
	 * @param string $type Normal or Headings content.
	 */
	public function momoacg_openai_generate_content_output_json( $args, $type = 'normal' ) {
		global $momoacg;
		$language        = isset( $args['language'] ) ? $args['language'] : '';
		$title           = isset( $args['title'] ) ? $args['title'] : '';
		$addimage        = isset( $args['addimage'] ) ? $args['addimage'] : 'off';
		$addintroduction = isset( $args['addintroduction'] ) ? $args['addintroduction'] : 'off';
		$addconclusion   = isset( $args['addconclusion'] ) ? $args['addconclusion'] : 'off';
		$addheadings     = isset( $args['addheadings'] ) ? $args['addheadings'] : 'off';
		$nopara          = isset( $args['nopara'] ) ? $args['nopara'] : 4;
		$writing_style   = isset( $args['writing_style'] ) ? $args['writing_style'] : 'informative';
		$headingwrapper  = isset( $args['headingwrapper'] ) ? $args['headingwrapper'] : 'h1';
		$addhyperlink    = isset( $args['addhyperlink'] ) ? $args['addhyperlink'] : 'off';
		$hyperlink_text  = isset( $args['hyperlink_text'] ) ? $args['hyperlink_text'] : '';
		$anchor_link     = isset( $args['anchor_link'] ) ? $args['anchor_link'] : '';
		$modifyheadings  = isset( $args['modifyheadings'] ) ? $args['modifyheadings'] : 'off';
		$headings        = isset( $args['headings'] ) ? $args['headings'] : array();
		$paras           = isset( $args['paras'] ) ? $args['paras'] : array();
		$wrappers        = isset( $args['wrappers'] ) ? $args['wrappers'] : array();

		$response = $this->momo_acg_check_api_return_json();
		if ( isset( $response['code'] ) && 404 === $response['code'] ) {
			echo wp_json_encode(
				array(
					'status' => 'bad',
					'msg'    => $response['message'],
				)
			);
			exit;
		}
		if ( empty( $title ) ) {
			echo wp_json_encode(
				array(
					'status' => 'bad',
					'msg'    => esc_html__( 'Search title field is empty', 'momoacg' ),
				)
			);
			exit;
		}

		$all_style         = $momoacg->lang->momo_get_all_writing_text( $writing_style );
		$openai_settings   = get_option( 'momo_acg_openai_settings' );
		$temperature       = isset( $openai_settings['temperature'] ) && ! empty( $openai_settings['temperature'] ) ? $openai_settings['temperature'] : 0.7;
		$max_tokens        = isset( $openai_settings['max_tokens'] ) && ! empty( $openai_settings['max_tokens'] ) ? $openai_settings['max_tokens'] : 2000;
		$top_p             = isset( $openai_settings['top_p'] ) && ! empty( $openai_settings['top_p'] ) ? $openai_settings['top_p'] : 1.0;
		$frequency_penalty = isset( $openai_settings['frequency_penalty'] ) && ! empty( $openai_settings['frequency_penalty'] ) ? $openai_settings['frequency_penalty'] : 0.0;
		$presence_penalty  = isset( $openai_settings['presence_penalty'] ) && ! empty( $openai_settings['presence_penalty'] ) ? $openai_settings['presence_penalty'] : 0.0;

		if ( 'on' === $addheadings && 'on' === $modifyheadings ) {
			$prompt_text_heading = $all_style['heading'];
			$formatted_prompt    = strval( $nopara ) . ' ' . $prompt_text_heading . $title . ' in ' . $language . ' language in JSON format';
		}

		$content = '';
		$message = '';

		if ( 'on' === $modifyheadings && ! empty( $headings ) ) {
			$output  = $this->momo_acg_generate_content_from_headings( $headings, $args );
			$message = $output['message'];
			$content = $output['content'];
		} else {
			$headings = $this->momoacg_openai_generate_headings_array( $args );
			$output   = $this->momo_acg_generate_content_from_headings( $headings, $args );
			$message  = $output['message'];
			$content  = $output['content'];
		}
		$formatted_prompt = '';

		$language_model = isset( $openai_settings['language_model'] ) && ! empty( $openai_settings['language_model'] ) ? $openai_settings['language_model'] : 'text-davinci-003';
		$language_model = 'text-davinci-003';

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
		if ( 'on' === $addintroduction ) {
			$prompt_text_introduction = $all_style['introduction'];
			$formatted_prompt         = $prompt_text_introduction . ' ' . $title . ' in ' . $language;
			$body['prompt']           = $formatted_prompt;
			if ( 'on' === $addheadings ) {
				$formatted_prompt .= ' with heading wrapped in <' . $headingwrapper . '>';
			}
			$response = $momoacg->fn->momo_wsw_run_rest_api( 'POST', $url, $body );
			if ( is_wp_error( $response ) ) {
				$message = esc_html__( 'Something went wrong with provided output from server.', 'momoacg' );
				$content = $content;
			}
			if ( isset( $response['status'] ) && 404 === $response['status'] ) {
				$message .= isset( $response['body']->error->message ) ? $response['body']->error->message : '<br>' . esc_html__( 'Provided url not found.', 'momoacg' );
			}
			if ( isset( $response['status'] ) && 200 === $response['status'] ) {
				$choices = isset( $response['body']->choices ) ? $response['body']->choices : array();
				$intro   = '';
				if ( ! empty( $choices ) ) {
					foreach ( $choices as $choice ) {
						$intro .= $choice->text;
					}
					$content = $intro . $content;
				} else {
					$message .= esc_html__( 'Not enough choices generated.', 'momoacg' );
				}
			}
		}
		if ( 'on' === $addconclusion ) {
			$prompt_text_conclusion = $all_style['conclusion'];
			$formatted_prompt       = $prompt_text_conclusion . ' ' . $title . ' in ' . $language;
			if ( 'on' === $addheadings ) {
				$formatted_prompt .= ' with heading wrapped in <' . $headingwrapper . '>';
			}
			$body['prompt'] = $formatted_prompt;
			$response       = $momoacg->fn->momo_wsw_run_rest_api( 'POST', $url, $body );
			if ( is_wp_error( $response ) ) {
				$message = esc_html__( 'Something went wrong with provided output from server.', 'momoacg' );
				$content = $content;
			}
			if ( isset( $response['status'] ) && 404 === $response['status'] ) {
				$message .= isset( $response['body']->error->message ) ? $response['body']->error->message : '<br>' . esc_html__( 'Provided url not found.', 'momoacg' );
			}
			if ( isset( $response['status'] ) && 200 === $response['status'] ) {
				$choices = isset( $response['body']->choices ) ? $response['body']->choices : array();
				$conclu  = '';
				if ( ! empty( $choices ) ) {
					foreach ( $choices as $choice ) {
						$conclu .= $choice->text;
					}
					$content = $content . $conclu;
				} else {
					$message .= esc_html__( 'Not enough choices generated.', 'momoacg' );
				}
			}
		}
		if ( 'on' === $addimage ) {
			$formatted_promt = esc_html__( 'generate an image of a ', 'momoacg' ) . $title;
			$body            = array(
				'model'  => 'image-alpha-001',
				'prompt' => $title,
			);

			$url      = 'https://api.openai.com/v1/images/generations';
			$response = $momoacg->fn->momo_wsw_run_rest_api( 'POST', $url, $body );
			if ( isset( $response['status'] ) && 200 === $response['status'] ) {
				$image = isset( $response['body']->data[0]->url ) ? $response['body']->data[0]->url : '';
				if ( ! empty( $image ) ) {
					$imgresult = "<img src='" . $image . "' alt='" . $title . "' />";
					$content  .= "\n\n\n" . $imgresult;
				}
			}
		}
		if ( ! empty( $content ) ) {
			if ( 'on' === $addhyperlink && ! empty( $hyperlink_text ) && ! empty( $anchor_link ) ) {
				$replacement_str = '<a href="' . $anchor_link . '">' . $hyperlink_text . '</a>';
				$content         = $momoacg->fn->momo_replace_first_str( $hyperlink_text, $replacement_str, $content );
			}
			echo wp_json_encode(
				array(
					'status'  => 'good',
					'msg'     => $message,
					'content' => $content,
				)
			);
			exit;
		}
		echo wp_json_encode(
			array(
				'status' => 'bad',
				'msg'    => empty( $message ) ? esc_html__( 'Something went wrong while generating content. Please try again.', 'momoacg' ) : $message,
			)
		);
		exit;
	}
	/**
	 * Generate json output Headings
	 *
	 * @param array  $args Arguments.
	 * @param string $type Normal or Headings content.
	 */
	public function momoacg_openai_generate_headings_array( $args, $type = 'normal' ) {
		global $momoacg;
		$language          = isset( $args['language'] ) ? $args['language'] : '';
		$title             = isset( $args['title'] ) ? $args['title'] : '';
		$nopara            = isset( $args['nopara'] ) ? $args['nopara'] : 4;
		$writing_style     = isset( $args['writing_style'] ) ? $args['writing_style'] : 'informative';
		$modifyheadings    = isset( $args['modifyheadings'] ) ? $args['modifyheadings'] : 'off';
		$all_style         = $momoacg->lang->momo_get_all_writing_text( $writing_style );
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

		$prompt_text_heading = $all_style['heading'];
		$formatted_prompt    = 'write ' . strval( $nopara ) . ' ' . $prompt_text_heading . ' ' . $title . ' in ' . $language . ' language seperated by <momoseperator>';

		$language_model = isset( $openai_settings['language_model'] ) && ! empty( $openai_settings['language_model'] ) ? $openai_settings['language_model'] : 'text-davinci-003';
		$context        = isset( $chatbot_settings['context'] ) ? $chatbot_settings['context'] : '';
		if ( 'gpt-3.5-turbo' === $language_model || 'gpt-4' === $language_model ) {
			$messages = array(
				'role'    => 'user',
				'content' => $formatted_prompt,
			);
			$body     = array(
				'model'       => $language_model,
				'temperature' => (float) $temperature,
				'max_tokens'  => (int) $max_tokens,
				'messages'    => array( $messages ),
			);
			$url      = 'https://api.openai.com/v1/chat/completions';
		} else {

			$body = array(
				'model'             => $language_model,
				'prompt'            => $formatted_prompt,
				'temperature'       => (float) $temperature,
				'max_tokens'        => (int) 500,
				'top_p'             => (float) $top_p,
				'frequency_penalty' => (float) $frequency_penalty,
				'presence_penalty'  => (float) $presence_penalty,
			);
			$url  = 'https://api.openai.com/v1/completions';
		}
		$response = $momoacg->fn->momo_wsw_run_rest_api( 'POST', $url, $body );
		$headings = array();
		$message  = '';
		if ( is_wp_error( $response ) ) {
			return $headings;
		}
		if ( isset( $response['status'] ) && 404 === $response['status'] ) {
			$message .= isset( $response['body']->error->message ) ? $response['body']->error->message : '<br>' . esc_html__( 'Provided url not found.', 'momoacg' );
		}
		$content = '';
		$message = '';
		if ( isset( $response['status'] ) && 200 === $response['status'] ) {
			$choices = isset( $response['body']->choices ) ? $response['body']->choices : array();
			if ( ! empty( $choices ) ) {
				foreach ( $choices as $choice ) {
					if ( 'gpt-3.5-turbo' === $language_model || 'gpt-4' === $language_model ) {
						$content .= $choice->message->content;
					} else {
						$content .= $choice->text;
					}
				}
			} else {
				$message .= esc_html__( 'Not enough choices generated.', 'momoacg' );
			}
			if ( is_string( $content ) ) {
				$headings = $this->momo_generate_heading_array_from_string( $content );
				if ( empty( $headings ) ) {
					return $headings;
				}
				return $headings;
			} else {
				return $headings;
			}
		}
	}
	/**
	 * Generate json output Headings
	 *
	 * @param array  $args Arguments.
	 * @param string $type Normal or Headings content.
	 */
	public function momoacg_openai_generate_headings_output_json( $args, $type = 'normal' ) {
		global $momoacg;
		$language       = isset( $args['language'] ) ? $args['language'] : '';
		$title          = isset( $args['title'] ) ? $args['title'] : '';
		$nopara         = isset( $args['nopara'] ) ? $args['nopara'] : 4;
		$writing_style  = isset( $args['writing_style'] ) ? $args['writing_style'] : 'informative';
		$modifyheadings = isset( $args['modifyheadings'] ) ? $args['modifyheadings'] : 'off';
		$headingwrapper = isset( $args['headingwrapper'] ) ? $args['headingwrapper'] : 'h1';

		$response = $this->momo_acg_check_api_return_json();
		if ( isset( $response['code'] ) && 404 === $response['code'] ) {
			echo wp_json_encode(
				array(
					'status' => 'bad',
					'msg'    => $response['message'],
				)
			);
			exit;
		}
		if ( empty( $title ) ) {
			echo wp_json_encode(
				array(
					'status' => 'bad',
					'msg'    => esc_html__( 'Search title field is empty', 'momoacg' ),
				)
			);
			exit;
		}

		$all_style         = $momoacg->lang->momo_get_all_writing_text( $writing_style );
		$openai_settings   = get_option( 'momo_acg_openai_settings' );
		$temperature       = isset( $openai_settings['temperature'] ) && ! empty( $openai_settings['temperature'] ) ? $openai_settings['temperature'] : 0.7;
		$max_tokens        = isset( $openai_settings['max_tokens'] ) && ! empty( $openai_settings['max_tokens'] ) ? $openai_settings['max_tokens'] : 2000;
		$top_p             = isset( $openai_settings['top_p'] ) && ! empty( $openai_settings['top_p'] ) ? $openai_settings['top_p'] : 1.0;
		$frequency_penalty = isset( $openai_settings['frequency_penalty'] ) && ! empty( $openai_settings['frequency_penalty'] ) ? $openai_settings['frequency_penalty'] : 0.0;
		$presence_penalty  = isset( $openai_settings['presence_penalty'] ) && ! empty( $openai_settings['presence_penalty'] ) ? $openai_settings['presence_penalty'] : 0.0;

		$language_model = isset( $openai_settings['language_model'] ) && ! empty( $openai_settings['language_model'] ) ? $openai_settings['language_model'] : 'text-davinci-003';
		if ( 'on' === $modifyheadings ) {
			$prompt_text_heading = $all_style['heading'];
			$formatted_prompt    = 'write ' . strval( $nopara ) . ' ' . $prompt_text_heading . ' ' . $title . ' in ' . $language . ' language seperated by <momoseperator>';
			if ( 'gpt-3.5-turbo' === $language_model || 'gpt-4' === $language_model ) {
				$messages = array(
					'role'    => 'user',
					'content' => $formatted_prompt,
				);
				$body     = array(
					'model'       => $language_model,
					'temperature' => (float) $temperature,
					'max_tokens'  => (int) $max_tokens,
					'messages'    => array( $messages ),
				);
				$url      = 'https://api.openai.com/v1/chat/completions';
			} else {
				$body = array(
					'model'             => $language_model,
					'prompt'            => $formatted_prompt,
					'temperature'       => (float) $temperature,
					'max_tokens'        => (int) 500,
					'top_p'             => (float) $top_p,
					'frequency_penalty' => (float) $frequency_penalty,
					'presence_penalty'  => (float) $presence_penalty,
				);

				$url = 'https://api.openai.com/v1/completions';
			}
			$response = $momoacg->fn->momo_wsw_run_rest_api( 'POST', $url, $body );
			if ( is_wp_error( $response ) ) {
				echo wp_json_encode(
					array(
						'status'  => 'bad',
						'msg'     => esc_html__( 'Something went wrong with provided output from server.', 'momoacg' ),
						'content' => $content,
					)
				);
				exit;
			}
			if ( isset( $response['status'] ) && 404 === $response['status'] ) {
				$message .= isset( $response['body']->error->message ) ? $response['body']->error->message : esc_html__( 'Provided url not found.', 'momoacg' );
			}
			$content = '';
			$message = '';
			if ( isset( $response['status'] ) && 200 === $response['status'] ) {
				$choices = isset( $response['body']->choices ) ? $response['body']->choices : array();
				if ( ! empty( $choices ) ) {
					foreach ( $choices as $choice ) {
						$content .= $choice->text;
					}
				} else {
					$message .= esc_html__( 'Not enough choices generated.', 'momoacg' );
				}
				if ( is_string( $content ) ) {
					$content = $this->momo_generate_heading_array_from_string( $content );
					$content = $this->momo_generate_heading_html_container( $content, $headingwrapper );
					if ( empty( $content ) ) {
						echo wp_json_encode(
							array(
								'status' => 'bad',
								'msg'    => esc_html__( 'Something went wrong with provided output from server. Please try again.', 'momoacg' ),
							)
						);
						exit;
					}
					echo wp_json_encode(
						array(
							'status'  => 'good',
							'msg'     => esc_html__( 'Heading(s) generated successfully.', 'momoacg' ),
							'content' => $content,
						)
					);
					exit;
				} else {
					$message .= esc_html__( 'Something went wrong with provided output from server.', 'momoacg' );
				}
			}
		}
	}
	/**
	 * Generate Content from Headings
	 *
	 * @param array $headings Headings.
	 * @param array $args Arguments.
	 */
	public function momo_acg_generate_content_from_headings( $headings, $args ) {
		global $momoacg;
		$message           = '';
		$content           = '';
		$writing_style     = isset( $args['writing_style'] ) ? $args['writing_style'] : 'informative';
		$language          = isset( $args['language'] ) ? $args['language'] : '';
		$addheadings       = isset( $args['addheadings'] ) ? $args['addheadings'] : 'off';
		$headingwrapper    = isset( $args['headingwrapper'] ) ? $args['headingwrapper'] : 'h1';
		$all_style         = $momoacg->lang->momo_get_all_writing_text( $writing_style );
		$openai_settings   = get_option( 'momo_acg_openai_settings' );
		$temperature       = isset( $openai_settings['temperature'] ) && ! empty( $openai_settings['temperature'] ) ? $openai_settings['temperature'] : 0.7;
		$max_tokens        = isset( $openai_settings['max_tokens'] ) && ! empty( $openai_settings['max_tokens'] ) ? $openai_settings['max_tokens'] : 2000;
		$top_p             = isset( $openai_settings['top_p'] ) && ! empty( $openai_settings['top_p'] ) ? $openai_settings['top_p'] : 1.0;
		$frequency_penalty = isset( $openai_settings['frequency_penalty'] ) && ! empty( $openai_settings['frequency_penalty'] ) ? $openai_settings['frequency_penalty'] : 0.0;
		$presence_penalty  = isset( $openai_settings['presence_penalty'] ) && ! empty( $openai_settings['presence_penalty'] ) ? $openai_settings['presence_penalty'] : 0.0;
		$language_model    = isset( $openai_settings['language_model'] ) && ! empty( $openai_settings['language_model'] ) ? $openai_settings['language_model'] : 'text-davinci-003';

		$tg_settings = isset( $args['tg_settings'] ) ? $args['tg_settings'] : 'off';
		if ( 'on' === $tg_settings ) {
			$temperature       = isset( $args['temperature'] ) && ! empty( $args['temperature'] ) ? $args['temperature'] : 0.7;
			$max_tokens        = isset( $args['max_tokens'] ) && ! empty( $args['max_tokens'] ) ? $args['max_tokens'] : 2000;
			$top_p             = isset( $args['top_p'] ) && ! empty( $args['top_p'] ) ? $args['top_p'] : 1.0;
			$frequency_penalty = isset( $args['frequency_penalty'] ) && ! empty( $args['frequency_penalty'] ) ? $args['frequency_penalty'] : 0.0;
			$presence_penalty  = isset( $args['presence_penalty'] ) && ! empty( $args['presence_penalty'] ) ? $args['presence_penalty'] : 0.0;
		}

		$paras          = isset( $args['paras'] ) ? $args['paras'] : array();
		$wrappers       = isset( $args['wrappers'] ) ? $args['wrappers'] : array();
		$modifyheadings = isset( $args['modifyheadings'] ) ? $args['modifyheadings'] : 'off';
		$message        = '';
		$pno            = 1;
		foreach ( $headings as $index => $heading ) {
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
			if ( 'gpt-3.5-turbo' === $language_model || 'gpt-4' === $language_model ) {
				$messages = array(
					'role'    => 'user',
					'content' => $formatted_prompt,
				);
				$body     = array(
					'model'       => $language_model,
					'temperature' => (float) $temperature,
					'max_tokens'  => (int) $max_tokens,
					'messages'    => array( $messages ),
				);
				$url      = 'https://api.openai.com/v1/chat/completions';
			} else {
				$body = array(
					'model'             => $language_model,
					'prompt'            => $formatted_prompt,
					'temperature'       => (float) $temperature,
					'max_tokens'        => (int) $max_tokens,
					'top_p'             => (float) $top_p,
					'frequency_penalty' => (float) $frequency_penalty,
					'presence_penalty'  => (float) $presence_penalty,
				);

				$url = 'https://api.openai.com/v1/completions';
			}
			$response = $momoacg->fn->momo_wsw_run_rest_api( 'POST', $url, $body );
			if ( is_wp_error( $response ) || ( isset( $response['status'] ) && 429 === $response['status'] ) ) {
				sleep( 20 );
				if (
					( isset( $response->errors['http_request_failed'] ) ) ||
					( isset( $response['status'] ) && 429 === $response['status'] )
				) {
					$message .= '<br><b>' . esc_html__( 'Error generating paragraph : ', 'momoacg' ) . $pno . '</b>' . esc_html__( 'It seems like server is overloaded or rate limit reached. Please try again later.', 'momoacg' );
				} else {
					$message .= '<br>' . esc_html__( 'Something went wrong with provided output from server.', 'momoacg' );
				}
				$content  = $content;
			} else {
				if ( isset( $response['status'] ) && 200 === $response['status'] ) {
					$message .= isset( $response['body']->error->message ) ? $response['body']->error->message : esc_html__( 'Provided url not found.', 'momoacg' );
				}
				if ( isset( $response['status'] ) && 200 === $response['status'] ) {
					$choices = isset( $response['body']->choices ) ? $response['body']->choices : array();
					if ( ! empty( $choices ) ) {
						foreach ( $choices as $choice ) {
							if ( 'gpt-3.5-turbo' === $language_model || 'gpt-4' === $language_model ) {
								$content .= $choice->message->content . "\n\n";
							} else {
								$content .= $choice->text;
							}
							$message .= '<b>' . esc_html__( 'Paragraph no: ', 'momoacg' ) . '</b> ' . $pno . esc_html__( ' generated successfully.', 'momoacg' );
						}
					} else {
						$message .= esc_html__( 'Not enough choices generated.', 'momoacg' );
					}
				}
			}
			$pno++;
		}
		return array(
			'message' => $message,
			'content' => $content,
		);
	}
	/**
	 * Generate heading HTML container
	 *
	 * @param array  $content Content generate (JSON).
	 * @param string $headingwrapper Heading Wrapper.
	 */
	public function momo_generate_heading_html_container( $content, $headingwrapper ) {
		global $momoacg;
		if ( ! is_array( $content ) ) {
			return;
		}
		$output = '';
		$index  = 0;
		foreach ( $content as $title ) {
			if ( is_object( $title ) ) {
				$key   = array_keys( get_object_vars( $title ) );
				$key   = $key[0];
				$value = $title->$key;
			} elseif ( is_array( $title ) ) {
				$value = $title[0];
			} else {
				$value = $title;
			}
			$output .= '<div class="momo-be-section-block">';

			$label   = esc_html__( 'Heading ', 'momoacg' ) . ( $index + 1 );
			$args    = array(
				'id'    => 'momo_be_mb_heading[]',
				'label' => $label,
				'value' => $value,
			);
			$output .= $momoacg->fn->momo_generate_text_output( $args );
			/** For new Select number of paragraphs */
			$options = array(
				'1' => 1,
				'2' => 2,
				'3' => 3,
			);
			$select = array(
				'label'   => esc_html__( 'Paragraphs inside this heading', 'momoacg' ),
				'id'      => 'momo_be_mb_heading_para[]',
				'options' => $options,
				'default' => 1,
			);
			$output .= $momoacg->fn->momo_generate_select_output( $select );
			$options = array(
				'h1' => 'h1',
				'h2' => 'h2',
				'h3' => 'h3',
				'h4' => 'h4',
				'h5' => 'h5',
				'h6' => 'h6',
			);
			$select  = array(
				'label'   => esc_html__( 'Change heading wrapper', 'momoacg' ),
				'id'      => 'momo_be_mb_heading_wrapper[]',
				'options' => $options,
				'default' => $headingwrapper,
			);
			$output .= $momoacg->fn->momo_generate_select_output( $select );

			$output .= '</div><!-- ends .momo-be-section-block -->';
			$index++;
		}
		return $output;
	}
	/**
	 * Generate heading HTML array
	 *
	 * @param array $content Content generate (JSON).
	 */
	public function momo_generate_heading_array( $content ) {
		global $momoacg;
		if ( ! is_array( $content ) ) {
			return;
		}
		$headings = array();
		foreach ( $content as $title ) {
			if ( is_object( $title ) ) {
				$key   = array_keys( get_object_vars( $title ) );
				$key   = $key[0];
				$value = $title->$key;
			} elseif ( is_array( $title ) ) {
				$value = $title[0];
			} else {
				$value = $title;
			}
			$headings[] = $value;
		}
		return $headings;
	}
	/**
	 * Generate heading HTML array
	 *
	 * @param array $content Content generate (JSON).
	 */
	public function momo_generate_heading_array_from_string( $content ) {
		$content = preg_replace( '/[0-9]+\./', '', $content );
		$return  = explode( '<momoseperator>', $content );
		$return  = array_filter( $return );
		return $return;
	}
	/**
	 * Check API is set if not return json.
	 */
	public function momo_acg_check_api_return_json() {
		$openai_settings = get_option( 'momo_acg_openai_settings' );
		$api_key         = isset( $openai_settings['api_key'] ) ? $openai_settings['api_key'] : '';
		if ( empty( $api_key ) ) {
			$url      = '<a href="' . admin_url( 'admin.php?page=momoacg' ) . '">' . esc_html__( 'settings page', 'momoacg' ) . '</a>';
			$response = array(
				'status'  => 'bad',
				/* translators: %s: settings url */
				'message' => sprintf( esc_html__( 'Empty API key, please store OpenAI API key in MoMo ACG %s first.', 'momowsw' ), $url ),
				'code'    => 404,
			);
			return $response;
		}
		return true;
	}
	/**
	 * Generate Image from Title.
	 *
	 * @param string $title Title.
	 */
	public function momo_acg_generate_image_from_title( $title ) {
		global $momoacg;
		$content         = '';
		$formatted_promt = esc_html__( 'generate an image of a ', 'momoacg' ) . $title;
		$body            = array(
			'model'  => 'image-alpha-001',
			'prompt' => $title,
		);

		$url      = 'https://api.openai.com/v1/images/generations';
		$response = $momoacg->fn->momo_wsw_run_rest_api( 'POST', $url, $body );
		if ( isset( $response['status'] ) && 200 === $response['status'] ) {
			$image = isset( $response['body']->data[0]->url ) ? $response['body']->data[0]->url : '';
			if ( ! empty( $image ) ) {
				$imgresult = "<img src='" . $image . "' alt='" . $title . "' />";
				$content  .= "\n\n\n" . $imgresult;
			}
		}
		return $content;
	}
}
