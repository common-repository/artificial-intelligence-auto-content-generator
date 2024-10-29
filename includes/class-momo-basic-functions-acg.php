<?php
/**
 * MoMo Themes Basic functions
 *
 * @package momoacg
 * @author MoMo Themes
 * @since v1.0.0
 */
class MoMo_Basic_Functions_ACG {
	/**
	 * Get Submenu Position
	 *
	 * @param string $name Name.
	 */
	public function momo_get_submenu_position( $name ) {
		$lists = array(
			'user_plan'   => 2,
			'chatgpt'     => 3,
			'bulk_writer' => 4,
			'auto_blog'   => 5,
			'chat_bot'    => 6,
			'debug_log'   => 7,
			'help_desk'   => 8,
		);
		return isset( $lists[ $name ] ) ? $lists[ $name ] : 10;
	}
	/**
	 * Checks woocommerce enabled or not
	 */
	public function momo_woocommerce_enabled() {
		if ( class_exists( 'woocommerce' ) ) {
			return true;
		} else {
			return false;
		}
	}
	/**
	 * Get all needed post types
	 */
	public function momo_list_needed_post_types() {
		$post_types     = get_post_types();
		$list_post_type = array(
			'post' => esc_html__( 'Post', 'momoacg' ),
			'page' => esc_html__( 'Page', 'momoacg' ),
		);
		if ( isset( $post_types['product'] ) ) {
			$list_post_type['product'] = esc_html__( 'Product', 'momoacg' );
		}
		$list_post_type['momoacg'] = esc_html__( 'ACG Draft Content', 'momoacg' );
		return $list_post_type;
	}
	/**
	 * List needed Page Builders
	 */
	public function momo_list_needed_page_builders() {
		$page_builders = array(
			'elementor' => esc_html__( 'Elementor', 'momoacg' ),
			'divi'      => esc_html__( 'Divi Builder', 'momoacg' ),
			'beaver'    => esc_html__( 'Beaver Builder', 'momoacg' ),
			'wp_bakery' => esc_html__( 'Visual Composer / WP Bakery', 'momoacg' ),
		);
		return $page_builders;
	}
	/**
	 * Check if string is json
	 *
	 * @param string $string Provided string.
	 * @return boolean
	 */
	public function momo_is_json( $string ) {
		json_decode( $string );
		return json_last_error() === JSON_ERROR_NONE;
	}
	/**
	 * Run plugin rest API function
	 *
	 * @param string $method Method.
	 * @param string $url Remaining url.
	 * @param array  $body Body arguments.
	 */
	public function momo_wsw_run_rest_api( $method, $url, $body ) {
		global $momowsw;
		$openai_settings = get_option( 'momo_acg_openai_settings' );
		$api_key         = isset( $openai_settings['api_key'] ) ? $openai_settings['api_key'] : '';
		if ( empty( $api_key ) ) {
			$response = array(
				'status'  => 'bad',
				'message' => esc_html__( 'Empty API key, please store OpenAI API key in MoMo ACG settings first.', 'momowsw' ),
			);
			return $response;
		}
		$timeout = 45;
		$timeout = isset( $openai_settings['timeout'] ) ? $openai_settings['timeout'] : 45;
		$args    = array(
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
		$logger   = new MoMo_ACG_Logger( 'sync_rest' );
		if ( ! is_wp_error( $response ) && isset( $response['response'] ) ) {
			if ( isset( $response['body']->error->message ) ) {
				$details = isset( $body['prompt'] ) ? implode( ' ', array_slice( str_word_count( $body['prompt'], 2 ), 0, 5 ) ) . ' ....' : $url;

				$log = array(
					'status'  => 'bad',
					'message' => $response['body']->error->message,
					'detail'  => $details,
					'code'    => $response['response']['code'],
				);
			} else {
				$details = isset( $body['prompt'] ) ? implode( ' ', array_slice( str_word_count( $body['prompt'], 2 ), 0, 5 ) ) . ' ....' : $url;

				$log = array(
					'status'  => 'good',
					'message' => esc_html__( 'Choices generated successfully.', 'momoacg' ),
					'detail'  => $details,
					'code'    => $response['response']['code'],
				);
			}
			$logger->set_event( $log );

			$response = array(
				'status'  => $response['response']['code'],
				'message' => $response['response']['message'],
				'code'    => $response['response']['code'],
				'body'    => json_decode( $response['body'] ),
			);
			return $response;
		} else {
			$log = array(
				'status'  => 'bad',
				'message' => $response->get_error_message(),
				'detail'  => isset( $body['prompt'] ) ? implode( ' ', array_slice( str_word_count( $body['prompt'], 2 ), 0, 5 ) ) . ' ....' : $url,
				'code'    => $response->get_error_code(),
			);
			$logger->set_event( $log );
			return $response;
		}
	}
	/**
	 * Remote Post file
	 *
	 * @param string $url URL.
	 * @param array  $body Body.
	 * @param string $file_path Filepath.
	 */
	public function momo_acg_remote_post_file( $url, $body, $file_path ) {
		global $momowsw;
		$openai_settings = get_option( 'momo_acg_openai_settings' );
		$api_key         = isset( $openai_settings['api_key'] ) ? $openai_settings['api_key'] : '';
		if ( empty( $api_key ) ) {
			$response = array(
				'status'  => 'bad',
				'message' => esc_html__( 'Empty API key, please store OpenAI API key in MoMo ACG settings first.', 'momowsw' ),
			);
			return $response;
		}

		$logger = new MoMo_ACG_Logger( 'sync_rest' );

		$timeout = 45;
		$timeout = isset( $openai_settings['timeout'] ) ? $openai_settings['timeout'] : 45;

		$boundary = md5( time() );

		$file_content = file_get_contents( $file_path );
		$file_name    = basename( $file_path );
		$file_type    = mime_content_type( $file_path );

		$request_body = "--{$boundary}\r\n"
			. "Content-Disposition: form-data; name=\"purpose\"\r\n\r\n"
			. "fine-tune\r\n"
			. "--{$boundary}\r\n"
			. "Content-Disposition: form-data; name=\"file\"; filename=\"{$file_name}\"\r\n"
			. "Content-Type: {$file_type}\r\n\r\n"
			. $file_content . "\r\n"
			. "--{$boundary}--\r\n";

		$args = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $api_key,
				'Content-Type'  => 'multipart/form-data; boundary=' . $boundary,
			),
			'timeout' => $timeout,
			'body'    => $request_body,
		);

		$response = wp_remote_post( $url, $args );
		if ( ! is_wp_error( $response ) && isset( $response['response'] ) ) {
			if ( isset( $response['body']->error->message ) ) {
				$details = esc_html__( 'File exporting', 'momoacg' );

				$log = array(
					'status'  => 'bad',
					'message' => $response['body']->error->message,
					'detail'  => $details,
					'code'    => $response['response']['code'],
				);
			} else {
				$details = esc_html__( 'File exporting', 'momoacg' );

				$log = array(
					'status'  => 'good',
					'message' => esc_html__( 'File exported successfully.', 'momoacg' ),
					'detail'  => $details,
					'code'    => $response['response']['code'],
				);
			}
			$logger->set_event( $log );

			$response = array(
				'status'  => $response['response']['code'],
				'message' => $response['response']['message'],
				'code'    => $response['response']['code'],
				'body'    => json_decode( $response['body'] ),
			);
			return $response;
		} else {
			$log = array(
				'status'  => 'bad',
				'message' => $response->get_error_message(),
				'detail'  => implode( ' ', array_slice( str_word_count( $body['prompt'], 2 ), 0, 5 ) ) . ' ....',
				'code'    => $response->get_error_code(),
			);
			$logger->set_event( $log );
			return $response;
		}

	}
	/**
	 * Run plugin rest API function
	 *
	 * @param string $method Method.
	 * @param string $url Remaining url.
	 * @param array  $body Body arguments.
	 */
	public function momo_acg_run_rest_api( $method, $url, $body ) {
		global $momowsw;
		$openai_settings = get_option( 'momo_acg_openai_settings' );
		$api_key         = isset( $openai_settings['api_key'] ) ? $openai_settings['api_key'] : '';
		if ( empty( $api_key ) ) {
			$response = array(
				'status'  => 'bad',
				'message' => esc_html__( 'Empty API key, please store OpenAI API key in MoMo ACG settings first.', 'momowsw' ),
			);
			return $response;
		}
		$timeout = 45;
		$timeout = isset( $openai_settings['timeout'] ) ? $openai_settings['timeout'] : 45;
		$args    = array(
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
		} else {
			return $response;
		}
	}
	/**
	 * Returns check option check or unchecked
	 *
	 * @param array  $settings Settings array.
	 * @param string $key Option key.
	 */
	public function momo_return_check_option( $settings, $key ) {
		$option = isset( $settings[ $key ] ) ? $settings[ $key ] : 'off';
		if ( 'on' === $option ) {
			$check = 'checked="checked"';
		} else {
			$check = '';
		}
		return $check;
	}
	/**
	 * Returns check option check or unchecked
	 *
	 * @param array  $settings Settings array.
	 * @param string $key Option key.
	 */
	public function momo_return_option_yesno( $settings, $key ) {
		$option = isset( $settings[ $key ] ) ? $settings[ $key ] : 'off';
		return $option;
	}
	/**
	 * Check API Cache enabled or disabled.
	 *
	 * @return boolean
	 */
	public function momoacg_disable_cache_is_enabled() {
		$cache_settings    = get_option( 'momo_wsw_api_cache_settings' );
		$disable_api_cache = isset( $cache_settings['disable_api_cache'] ) ? $cache_settings['disable_api_cache'] : 'off';
		if ( 'on' === $disable_api_cache ) {
			return true;
		}
		return false;
	}
	/**
	 * Generate Frontend contents
	 *
	 * @param [type] $fields
	 * @return void
	 */
	public function momo_generate_frontned_elements( $fields ) {

	}
	/**
	 * Create content from array fields.
	 *
	 * @param array  $fields Fileds.
	 * @param string $context Area.
	 */
	public function momo_generate_elements_from_array( $fields, $context = 'momo-mb-normal' ) {
		if ( ! is_array( $fields ) ) {
			return;
		}
		ob_start();
		?>
		<div class="momo-be-mb-form <?php echo esc_attr( $context ); ?>">
			<div class="momo-be-section-block">
		<?php
		foreach ( $fields as $field ) {
			$this->momo_switch_and_generate_field( $field );
		}
		?>
			</div><!-- ends momo-be-mb-form -->
		</div><!-- ends momo-be-section-block -->
		<?php
		return ob_get_flush();
	}
	/**
	 * Check and generate field.
	 *
	 * @param array $field Field.
	 * @return void
	 */
	public function momo_switch_and_generate_field( $field ) {
		switch ( $field['type'] ) {
			case 'popbox':
				$this->momo_generate_popbox( $field );
				break;
			case 'select':
				$this->momo_generate_select( $field );
				break;
			case 'multiselect':
				$this->momo_generate_multiselect( $field );
				break;
			case 'switch':
				$this->momo_generate_switch( $field );
				break;
			case 'text':
				$this->momo_generate_text( $field );
				break;
			case 'textarea':
				$this->momo_generate_textarea( $field );
				break;
			case 'button_block':
				$this->momo_generate_button_block( $field );
				break;
			case 'button':
				$this->momo_generate_button( $field );
				break;
			case 'messagebox':
				$this->momo_generate_messagebox( $field );
				break;
			case 'working':
				$this->momo_generate_working( $field );
				break;
			case 'custom':
				$this->momo_generate_custom_field( $field );
				break;
			case 'section':
				$this->momo_generate_section_block( $field );
				break;
			case 'three-columns':
				$this->momo_generate_three_column_section( $field );
				break;
			case 'inline-after':
				$this->momo_generate_inline_after( $field );
				break;
			case 'afteryes':
				$this->momo_generate_seperate_afteryes( $field );
				break;
			case 'range-slider':
				$this->momo_generate_range_slider( $field );
				break;
			case 'side-buttons-bottom':
				$this->momo_generate_side_buttons_bottom( $field );
				break;
			case 'spinner':
				$this->momo_generate_spinner( $field );
				break;
			default:
				break;
		}
	}
	/**
	 * Generate Popbox
	 *
	 * @param array $field Fields.
	 */
	public function momo_generate_popbox( $field ) {
		$id    = isset( $field['id'] ) ? $field['id'] : '';
		$class = isset( $field['class'] ) ? $field['class'] : '';
		?>
		<div class="momo-popbox <?php echo esc_attr( $class ); ?>" id="<?php echo esc_attr( $id ); ?>">
			<div class="momo-pb-container">
				<div class="momo-pb-header">
					<span class="header-text"></span>
					<i class='momo-pb-close bx bxs-x-circle'></i>
				</div>
				<div class="momo-pb-content">
					<div class="momo-be-working"></div>
					<div class="content-html"></div>
				</div>
				<div class="momo-pb-footer">
					<div class="momo-pb-message"></div>
				</div>
			</div>
		</div>
		<div class="momo-pb-overlay" data-target="<?php echo esc_attr( $id ); ?>"></div>
		<?php
	}
	/**
	 * Generate Side Bottoms Block
	 *
	 * @param array $field Filed.
	 */
	public function momo_generate_side_buttons_bottom( $field ) {
		$fields = isset( $field['fields'] ) ? $field['fields'] : array();
		$class  = isset( $field['class'] ) ? $field['class'] : '';
		$id     = isset( $field['id'] ) ? $field['id'] : '';
		?>
		<div class="momo-be-side-bottom <?php echo esc_attr( $class ); ?>" id=<?php echo esc_attr( $id ); ?>>
			<div class="momo-right-button">
			<?php
			foreach ( $fields as $field ) {
				$this->momo_switch_and_generate_field( $field );
			}
			?>
			</div>
			<div class="clear"></div>
		</div>
		<?php
	}
	/**
	 * Generate Spinner
	 *
	 * @param array $field Fields.
	 */
	public function momo_generate_spinner( $field ) {
		$id    = isset( $field['id'] ) ? $field['id'] : '';
		$class = isset( $field['class'] ) ? $field['class'] : '';
		?>
		<span class="momo-be-side-spinner spinner <?php echo esc_attr( $class ); ?>" id="<?php echo esc_attr( $id ); ?>">
		</span>
		<?php
	}
	/**
	 * Generate Seperate afteryes
	 *
	 * @param array $field Fields.
	 */
	public function momo_generate_seperate_afteryes( $field ) {
		$fields   = isset( $field['fields'] ) ? $field['fields'] : array();
		$class    = isset( $field['class'] ) ? $field['class'] : '';
		$afteryes = $field['id'] . '_afteryes';
		if ( ! empty( $afteryes ) ) :
			?>
			<div class="momo-be-tc-yes-container" id="<?php echo esc_attr( $afteryes ); ?>">
				<?php $this->momo_generate_elements_from_array( $fields ); ?>
			</div>
			<?php
		endif;
	}
	/**
	 * Create 3 column section
	 *
	 * @param array $field Fields.
	 */
	public function momo_generate_three_column_section( $field ) {
		$fields = isset( $field['fields'] ) ? $field['fields'] : array();
		$class  = isset( $field['class'] ) ? $field['class'] : '';
		?>
		<div class="momo-flex-columns <?php echo esc_attr( $class ); ?>">
			<?php
			foreach ( $fields as $field ) :
				?>
				<div class="momo-three-column">
				<?php
					$this->momo_switch_and_generate_field( $field );
				?>
				</div>
				<?php
			endforeach;
			?>
		</div>
		<?php
	}
	/**
	 * Generate before stuff
	 *
	 * @param array $fields Fields.
	 */
	public function momo_generate_before_inline( $fields ) {
		foreach ( $fields as $field ) {
			?>
			<div class="momo-be-inline-before">
			<?php
			$this->momo_switch_and_generate_field( $field );
			?>
			</div>
			<?php
		}
	}
	/**
	 * Generate after stuff
	 *
	 * @param array $fields Fields.
	 */
	public function momo_generate_after_inline( $fields ) {
		foreach ( $fields as $field ) {
			?>
			<div class="momo-be-inline-after">
			<?php
			$this->momo_switch_and_generate_field( $field );
			?>
			</div>
			<?php
		}
	}
	/**
	 * Generate Select
	 *
	 * @param array $field Filed.
	 */
	public function momo_generate_select( $field ) {
		$class   = isset( $field['class'] ) ? $field['class'] : '';
		$nolabel = isset( $field['nolabel'] ) ? $field['nolabel'] : false;
		?>
		<div class="momo-be-block <?php echo esc_attr( $class ); ?>">
			<?php if ( ! $nolabel ) : ?>
			<label class="regular inline"><?php echo esc_html( $field['label'] ); ?></label>
			<?php endif; ?>
			<select class="inline" name="<?php echo esc_attr( $field['id'] ); ?>" <?php echo esc_attr( isset( $field['size'] ) ? 'size=' . $field['size'] : '' ); ?>>
			<?php foreach ( $field['options'] as $value => $option ) { ?>
				<option value="<?php echo esc_attr( $value ); ?>" 
				<?php echo esc_attr( $field['default'] === $value ? 'selected="selected"' : '' ); ?>
				><?php echo esc_html( $option ); ?></option>
			<?php } ?>
			</select>
			<?php
			if ( isset( $field['after'] ) && is_array( $field['after'] ) ) {
				$this->momo_generate_after_inline( $field['after'] );
			}
			?>
		</div>
		<?php
	}
	/**
	 * Generate Select
	 *
	 * @param array $field Filed.
	 */
	public function momo_generate_multiselect( $field ) {
		$class = isset( $field['class'] ) ? $field['class'] : '';
		?>
		<div class="momo-be-block <?php echo esc_attr( $class ); ?>">
		<?php if ( isset( $field['label'] ) && ! empty( $field['label'] ) ) : ?>
			<label class="regular inline"><?php echo esc_html( $field['label'] ); ?></label>
		<?php endif; ?>
			<select class="inline" name="<?php echo esc_attr( $field['id'] ); ?>" multiple autocomplete="off">
			<?php foreach ( $field['options'] as $value => $option ) { ?>
				<option value="<?php echo esc_attr( $value ); ?>" 
				<?php echo esc_attr( $field['default'] === $value ? 'selected="selected"' : '' ); ?>
				><?php echo esc_html( $option ); ?></option>
			<?php } ?>
			</select>
			<?php
			if ( isset( $field['after'] ) && is_array( $field['after'] ) ) {
				$this->momo_generate_after_inline( $field['after'] );
			}
			?>
		</div>
		<?php
	}
	/**
	 * Generate Switch
	 *
	 * @param array $field Filed.
	 */
	public function momo_generate_switch( $field ) {
		$afteryes = '';
		$value    = isset( $field['value'] ) ? $field['value'] : 'off';
		$class    = isset( $field['class'] ) ? $field['class'] : '';
		if ( 'on' === $value ) {
			$check = 'checked="checked"';
		} else {
			$check = '';
		}
		$afteryes_fields = array();
		if ( isset( $field['afteryes'] ) ) {
			$afteryes        = $field['id'] . '_afteryes';
			$afteryes_fields = $field['afteryes'];
			if ( empty( $afteryes_fields ) ) {
				$afteryes_fields = array();
			}
		}
		?>
		<div class="momo-be-switch-block <?php echo esc_attr( $class ); ?>">
			<div class="momo-be-block">
				<span class="momo-be-toggle-container" <?php echo esc_attr( ! empty( $afteryes ) ? 'momo-be-tc-yes-container=' . $afteryes : '' ); ?>>
					<label class="switch">
						<input type="checkbox" class="switch-input" name="<?php echo esc_attr( $field['id'] ); ?>" autocomplete="off" <?php echo esc_attr( $check ); ?>>
						<span class="switch-label" data-on="Yes" data-off="No"></span>
						<span class="switch-handle"></span>
					</label>
				</span>
				<span class="momo-be-toggle-container-label">
					<?php echo esc_html( $field['label'] ); ?>
				</span>
				<?php if ( ! empty( $afteryes_fields ) ) : ?>
				<div class="momo-be-tc-yes-container momo-no-padding-bottom" id="<?php echo esc_attr( $afteryes ); ?>">
					<?php $this->momo_generate_elements_from_array( $afteryes_fields ); ?>
				</div>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
	/**
	 * Generate Text
	 *
	 * @param array $field Filed.
	 */
	public function momo_generate_text( $field ) {
		?>
		<div class="momo-be-block">
			<label class="regular inline"><?php echo esc_html( $field['label'] ); ?></label>
			<input type="text" class="inline wide" name="<?php echo esc_attr( $field['id'] ); ?>" placeholder="<?php echo esc_attr( isset( $field['placeholder'] ) ? $field['placeholder'] : '' ); ?>"
			value="<?php echo esc_attr( isset( $field['value'] ) ? $field['value'] : '' ); ?>"
			/>
		</div>
		<?php
	}
	/**
	 * Generate Text
	 *
	 * @param array $field Filed.
	 */
	public function momo_generate_text_output( $field ) {
		ob_start();
		$this->momo_generate_text( $field );
		return ob_get_clean();
	}
	/**
	 * Generate Select
	 *
	 * @param array $field Filed.
	 */
	public function momo_generate_select_output( $field ) {
		ob_start();
		$this->momo_generate_select( $field );
		return ob_get_clean();
	}
	/**
	 * Generate Textarea
	 *
	 * @param array $field Filed.
	 */
	public function momo_generate_textarea( $field ) {
		$content = isset( $field['value'] ) ? $field['value'] : '';
		$class   = isset( $field['class'] ) ? $field['class'] : '';
		$attr    = isset( $field['attr'] ) ? $field['attr'] : array();
		?>
		<div class="momo-be-section <?php echo esc_attr( $class ); ?>">
			<h2><?php echo esc_html( $field['label'] ); ?></h2>
			<div class="momo-be-section">
				<div class="momo-be-block">
					<textarea class="full-width" rows="<?php echo esc_attr( $field['rows'] ); ?>" autocomplete="off" id="<?php echo esc_attr( $field['id'] ); ?>"
					<?php echo esc_attr( $this->momo_generate_attr( $attr ) ); ?>
					><?php echo wp_kses_post( $content ); ?></textarea>
				</div>
			</div>
		</div>
		<?php
	}
	/**
	 * Generate Custom Field
	 *
	 * @param array $field Filed.
	 */
	public function momo_generate_custom_field( $field ) {
		$content = isset( $field['value'] ) ? $field['value'] : '';
		$class   = isset( $field['class'] ) ? $field['class'] : '';
		$label   = isset( $field['label'] ) ? $field['label'] : '';
		?>
		<div class="momo-be-section <?php echo esc_attr( $class ); ?>">
			<?php if ( ! empty( $label ) ) : ?>
			<h2><?php echo esc_html( $label ); ?></h2>
			<?php endif; ?>
			<div class="momo-be-section momo-be-section-container">
				<?php echo wp_kses_post( $content ); ?>
			</div>
		</div>
		<?php
	}
	/**
	 * Generate Button Block
	 *
	 * @param array $field Filed.
	 */
	public function momo_generate_button_block( $field ) {
		$buttons = isset( $field['buttons'] ) ? $field['buttons'] : array();
		$class   = isset( $field['class'] ) ? $field['class'] : '';
		?>
		<div class="momo-be-buttons-block <?php echo esc_attr( $class ); ?>">
			<?php
			foreach ( $buttons as $button ) {
				$this->momo_generate_button( $button );
			}
			?>
		</div>
		<?php
	}
	/**
	 * Generate Section Block
	 *
	 * @param array $field Filed.
	 */
	public function momo_generate_section_block( $field ) {
		$fields   = isset( $field['fields'] ) ? $field['fields'] : array();
		$label    = isset( $field['label'] ) ? $field['label'] : array();
		$sublabel = isset( $field['sublabel'] ) ? $field['sublabel'] : array();
		$class    = isset( $field['class'] ) ? $field['class'] : '';
		$id       = isset( $field['id'] ) ? $field['id'] : array();
		?>
		<div class="momo-be-buttons-block <?php echo esc_attr( $class ); ?>" id=<?php echo esc_attr( $id ); ?>>
			<?php if ( ! empty( $label ) ) : ?>
			<h2 class="momo-section-block"><?php echo esc_html( $label ); ?></h2>
			<?php endif; ?>
			<?php if ( ! empty( $sublabel ) ) : ?>
			<h3 class="momo-section-block"><?php echo esc_html( $sublabel ); ?></h3>
			<?php endif; ?>
			<?php
			foreach ( $fields as $field ) {
				$this->momo_switch_and_generate_field( $field );
			}
			?>
		</div>
		<?php
	}
	/**
	 * Generate Button
	 *
	 * @param array $field Filed.
	 */
	public function momo_generate_button( $field ) {
		$is_pro = isset( $field['pro'] ) ? $field['pro'] : false;
		$class  = isset( $field['class'] ) ? $field['class'] : '';
		$id     = $field['id'];
		if ( isset( $field['pro'] ) && false === $is_pro ) {
			$id = 'momo-disabled-button';
		}
		$data = isset( $field['data'] ) ? $field['data'] : array();
		if ( isset( $field['before'] ) && is_array( $field['before'] ) ) {
			$this->momo_generate_before_inline( $field['before'] );
		}
		$datas = '';
		if ( ! empty( $data ) ) {
			foreach ( $data as $key => $value ) {
				$datas .= 'data-' . $key . '=' . $value . ' ';
			}
		}
		?>
		<span class="momo-be-btn <?php echo esc_attr( $class ); ?>" id="<?php echo esc_attr( $id ); ?>" <?php echo esc_attr( $datas ); ?>>
		<?php echo esc_html( $field['label'] ); ?>
		</span>
		<?php
		if ( isset( $field['pro'] ) && false === $is_pro ) {
			?>
			<span class="momo-pro-label"><?php esc_html_e( 'PRO', 'momoacg' ); ?></span>
			<?php
		}
	}
	/**
	 * Generate Messagebox
	 *
	 * @param array $field Filed.
	 */
	public function momo_generate_messagebox( $field ) {
		?>
		<div class="momo-be-msg-block <?php echo esc_attr( isset( $field['class'] ) ? $field['class'] : '' ); ?>" id="<?php echo esc_attr( $field['id'] ); ?>"
		></div>
		<?php
	}
	/**
	 * Generate Working
	 *
	 * @param array $field Filed.
	 */
	public function momo_generate_working( $field ) {
		if ( isset( $field['class'] ) && 'notontop' === $field['class'] ) {
			?>
			<div class="momo-be-working-parent-holder">
			<?php
		}
		?>
		<div class="momo-be-working" id="<?php echo esc_attr( $field['id'] ); ?>"
		<?php echo esc_attr( isset( $field['class'] ) ? 'class="' . $field['class'] . '"' : '' ); ?>
		></div>
		<?php
		if ( isset( $field['class'] ) && 'notontop' === $field['class'] ) {
			?>
			</div>
			<?php
		}
	}
	/**
	 * Generate attribute data
	 *
	 * @param array $attr Attributes.
	 */
	public function momo_generate_attr( $attr ) {
		$output = '';
		if ( ! empty( $attr ) ) {
			foreach ( $attr as $id => $value ) {
				$output .= $id . '=' . $value . ' ';
			}
		}
		return $output;
	}
	/**
	 * Custom string replace for first occurance
	 *
	 * @param string $search_str Search String.
	 * @param string $replacement_str Replacement String.
	 * @param string $src_str Source String.
	 */
	public function momo_replace_first_str( $search_str, $replacement_str, $src_str ) {
		$pos = strpos( $src_str, $search_str );
		return ( false !== ( $pos ) ) ? substr_replace( $src_str, $replacement_str, $pos, strlen( $search_str ) ) : $src_str;
	}
	/**
	 * Generate Section Block
	 *
	 * @param array $field Filed.
	 */
	public function momo_generate_inline_after( $field ) {
		$fields = isset( $field['fields'] ) ? $field['fields'] : array();
		$label  = isset( $field['label'] ) ? $field['label'] : array();
		$class  = isset( $field['class'] ) ? $field['class'] : '';
		$id     = isset( $field['id'] ) ? $field['id'] : array();
		$rows   = isset( $field['rows'] ) ? $field['rows'] : 1;
		?>
		<div class="momo-be-inline-table <?php echo esc_attr( $class ); ?>" id=<?php echo esc_attr( $id ); ?>>
			<?php if ( ! empty( $label ) ) : ?>
			<h2><?php echo esc_html( $label ); ?></h2>
			<?php endif; ?>
			<div class="momo-be-inline-row">
			<?php
			foreach ( $fields as $field ) {
				$this->momo_switch_and_generate_field( $field );
			}
			?>
			</div>
		</div>
		<?php
	}
	/**
	 * Generate Section Block
	 *
	 * @param array $field Filed.
	 */
	public function momo_generate_range_slider( $field ) {
		$label   = isset( $field['label'] ) ? $field['label'] : array();
		$class   = isset( $field['class'] ) ? $field['class'] : '';
		$id      = isset( $field['id'] ) ? $field['id'] : '';
		$helper  = isset( $field['helper'] ) ? $field['helper'] : '';
		$min     = isset( $field['min'] ) ? $field['min'] : 0;
		$max     = isset( $field['max'] ) ? $field['max'] : 10;
		$default = isset( $field['default'] ) ? $field['default'] : 5;
		$step    = isset( $field['step'] ) ? $field['step'] : 1;
		?>
		<div class="momo-be-range-slider-container">
			<label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $label ); ?>
			<?php if ( ! empty( $helper ) ) : ?>
				<span class='momo-be-helper bx bxs-help-circle'>
					<span class="momo-be-helper-text"><?php echo esc_html( $helper ); ?></span>
				</span>
			<?php endif; ?>
			</label>
			<span class="momo-range-input-holder">
				<input name="<?php echo esc_attr( $id ); ?>" type="range" min="<?php echo esc_attr( $min ); ?>" max="<?php echo esc_attr( $max ); ?>" step="<?php echo esc_attr( $step ); ?>" value="<?php echo esc_attr( $default ); ?>" class="momo-be-range-slider" autocomplete="off"/>
				<span class="momo-be-rs-value"><?php echo esc_html( $default ); ?></span>
			</span>
		</div>
		<?php
	}
	/**
	 * Recursive sanitation for an array
	 *
	 * @param array $array Post array data.
	 */
	public function momo_recursive_sanitize_text_field( $array ) {
		foreach ( $array as $key => &$value ) {
			if ( is_array( $value ) ) {
				$value = $this->momo_recursive_sanitize_text_field( $value );
			} else {
				$value = sanitize_text_field( $value );
			}
		}

		return $array;
	}
	/**
	 * Check is premium version
	 */
	public function momoacg_is_premium() {
		return momoacg_fs()->is_premium();
	}
}
