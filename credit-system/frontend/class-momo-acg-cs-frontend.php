<?php
/**
 * MoMo Credit System Frontend
 *
 * @package momoacg
 * @author MoMo Themes
 * @since v3.0.0
 */
class MoMo_ACG_CS_Frontned {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'momo_acg_cs_load_scripts_styles' ), 10 );
	}
	/**
	 * Load script and styles
	 *
	 * @return void
	 */
	public function momo_acg_cs_load_scripts_styles() {
		global $momoacg;
		wp_enqueue_style( 'momoacgcs_boxicons', $momoacg->plugin_url . 'assets/boxicons/css/boxicons.min.css', array(), '2.2.0' );
		wp_enqueue_style( 'momoacgcs_fe_style', $momoacg->plugin_url . 'credit-system/assets/momo_acgcs_fe.css', array(), $momoacg->version );
		wp_register_script( 'momoacgcs_fe_script', $momoacg->plugin_url . 'credit-system/assets/momo_acgcs_fe.js', array( 'jquery' ), $momoacg->version, true );
		wp_register_script( 'momoacgcs_sync_fe', $momoacg->plugin_url . 'credit-system/assets/momo_acg_sync_fe.js', array( 'jquery' ), $momoacg->version, true );

		$ajaxurl = array(
			'ajaxurl'              => admin_url( 'admin-ajax.php' ),
			'momoacgcs_ajax_nonce' => wp_create_nonce( 'momoacgcs_security_key' ),
		);
		wp_localize_script( 'momoacgcs_fe_script', 'momoacgcs_fe', $ajaxurl );
		$stages  = array(
			'headings',
			'content',
			'introduction',
			'conclusion',
			'hyperlink',
			'image',
		);
		$ajaxurl = array(
			'ajaxurl'                      => admin_url( 'admin-ajax.php' ),
			'momoacgcs_ajax_nonce'         => wp_create_nonce( 'momoacgcs_security_key' ),
			'mb_add_content'               => esc_html__( 'Generating Content..', 'momoacg' ),
			'mb_add_headings'              => esc_html__( 'Generating Heading(s)..', 'momoacg' ),
			'empty_response'               => esc_html__( 'Something went wrong while generating content.', 'momoacg' ),
			'completed_content_generation' => esc_html__( 'paragraphs generated successfully.', 'momoacg' ),
			'mb_add_introduction'          => esc_html__( 'Adding introduction to content.', 'momoacg' ),
			'mb_add_conclusion'            => esc_html__( 'Adding conclusion to content.', 'momoacg' ),
			'mb_add_hyperlink'             => esc_html__( 'Adding hyperlink to content.', 'momoacg' ),
			'mb_add_image'                 => esc_html__( 'Adding image to content.', 'momoacg' ),
			'time_taken'                   => esc_html__( 'Time taken to complete this operation : ', 'momoacg' ),
			'stages'                       => $stages,
			'generating_content'           => esc_html__( 'Generating Content..', 'momoacg' ),
			'generating_heading'           => esc_html__( 'Generating Heading(s)..', 'momoacg' ),
			'saving_draft'                 => esc_html__( 'Saving Draft..', 'momoacg' ),
			'empty_response'               => esc_html__( 'Something went wrong while generating content.', 'momoacg' ),
			'schedule_content_generation'  => esc_html__( 'Schedule Content Generation', 'momoacg' ),
		);
		wp_localize_script( 'momoacgcs_sync_fe', 'momoacgcs_fe', $ajaxurl );
	}
	/**
	 * Generate Purchase Plan Column
	 *
	 * @param array $attributes Attributes.
	 */
	public function momo_acg_cs_generate_purchase_plan( $attributes ) {
		ob_start();
		$url = $this->momo_get_current_url();
		?>
		<div class="momo-cs-plan-relative-container">
			<div class="momo-fe-msg-block"></div>
			<div class="momo-cs-plan-holder-container" data-url="<?php echo esc_url( $url ); ?>">
		<?php
		$args     = array(
			'post_type'  => 'product',
			'meta_query' => array(
				array(
					'key'   => '_momo_acg_token_plan',
					'value' => true,
				),
			),
		);
		$plans    = new WP_Query( $args );
		$selected = false;
		if ( $plans->have_posts() ) {
			while ( $plans->have_posts() ) :
				$plans->the_post();
				$plan_id = $plans->post->ID;
				$plan    = new WC_Product( $plan_id );
				$title   = $plan->get_meta( '_momo_acg_plan_title' );
				$tokens  = $plan->get_meta( '_momo_acg_token_count' );
				$price   = $plan->get_price_html();
				$status  = get_post_status( $plan_id );
				$select  = '';
				if ( false === $selected ) {
					$select   = 'checked';
					$selected = true;
				}
				?>
				<span data-plan_id="<?php echo esc_attr( $plan_id ); ?>" class="momo-plan-single-holder">
					<span class="momo-left-holder momo-radio-button">
						<input type="radio" name="plan" value="<?php echo esc_attr( $plan_id ); ?>" <?php echo esc_attr( $select ); ?>/>
					</span>
					<span class="momo-middle-holder">
						<span class="momo-title">
							<?php echo esc_html( $title ); ?>
						</span>
						<span class="momo-tokens">
							<?php echo esc_html( $tokens ) . esc_html__( ' Tokens', 'momoacg' ); ?>
						</span>
					</span>
					<span class="momo-right-holder momo-price">
						<?php echo wp_kses_post( $price ); ?>
					</span>
				</span>
				<?php
			endwhile;
			?>
			<div class="momo-plan-button-holder">
				<span class="momo-cs-continue-checkout-cart"><?php esc_html_e( 'Continue', 'momoacg' ); ?>
			</div>
			<?php
		} else {
			?>
			<div class="momo-be-msg-block show info">
				<?php
				esc_html_e( 'No plan created yet.', 'momoacg' );
				?>
			</div>
			<?php
		}
		?>
			</div><!-- ends .momo-cs-plan-holder-container -->
		</div><!-- ends .momo-cs-plan-relative-container -->
		<?php
		return ob_get_clean();
	}
	/**
	 * Generate Content Generator
	 *
	 * @param array $attributes Attributes.
	 */
	public function momo_acg_cs_generate_content_generator( $attributes ) {
		global $momoacg;
		$fields = array(
			array(
				'type'   => 'section',
				'id'     => 'momo-be-acg-mb-top-section',
				'class'  => 'momo-no-tborder momo-no-bborder',
				'fields' => array(
					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Title', 'momoacg' ),
						'placeholder' => esc_html__( 'Write Here', 'momoacg' ),
						'id'          => 'momo_be_mb_search_title',
					),
					array(
						'type'    => 'select',
						'label'   => esc_html__( 'Language', 'momoacg' ),
						'default' => 'english',
						'options' => $momoacg->lang->momo_get_all_langs(),
						'id'      => 'momo_be_mb_language',
					),
					array(
						'type'    => 'select',
						'label'   => esc_html__( 'No. of paragraphs', 'momoacg' ),
						'default' => '4',
						'class'   => 'momo-be-inline-column',
						'options' => array(
							'1'  => esc_html__( '1', 'momoacg' ),
							'2'  => esc_html__( '2', 'momoacg' ),
							'3'  => esc_html__( '3', 'momoacg' ),
							'4'  => esc_html__( '4', 'momoacg' ),
							'5'  => esc_html__( '5', 'momoacg' ),
							'6'  => esc_html__( '6', 'momoacg' ),
							'7'  => esc_html__( '7', 'momoacg' ),
							'8'  => esc_html__( '8', 'momoacg' ),
							'9'  => esc_html__( '9', 'momoacg' ),
							'10' => esc_html__( '10', 'momoacg' ),
						),
						'id'      => 'momo_be_mb_nopara',
						'after'   => array(
							array(
								'type'     => 'switch',
								'label'    => esc_html__( 'Add headings to paragraph', 'momoacg' ),
								'id'       => 'momo_be_mb_add_headings',
								'class'    => 'momo-be-inline-column',
								'afteryes' => array(
									array(
										'type'    => 'select',
										'label'   => esc_html__( 'Wrap headings with', 'momoacg' ),
										'default' => 'h1',
										'options' => array(
											'h1' => 'h1',
											'h2' => 'h2',
											'h3' => 'h3',
											'h4' => 'h4',
											'h5' => 'h5',
										),
										'id'      => 'momo_be_mb_heading_wrapper',
									),
								),
							),
						),
					),
					array(
						'type'  => 'switch',
						'label' => esc_html__( 'Add Introduction', 'momoacg' ),
						'id'    => 'momo_be_mb_add_introduction',
						'class' => 'momo-mb-be-label-blank momo-no-bborder',
					),
					array(
						'type'  => 'switch',
						'label' => esc_html__( 'Add Conclusion', 'momoacg' ),
						'id'    => 'momo_be_mb_add_conclusion',
						'class' => 'momo-mb-be-label-blank momo-no-bborder',
					),
					array(
						'type'    => 'select',
						'label'   => esc_html__( 'Writing Style', 'momoacg' ),
						'default' => 'informative',
						'options' => $momoacg->lang->momo_get_all_writing_style(),
						'id'      => 'momo_be_mb_writing_style',
					),
				),
			),
			array(
				'type'  => 'working',
				'id'    => 'momo_be_mb_working',
				'class' => 'notontop',
			),
			array(
				'type'    => 'messagebox',
				'id'      => 'momo_be_mb_openai_messagebox',
				'default' => 'none',
				'class'   => 'notontop',
			),
			array(
				'type'  => 'textarea',
				'label' => esc_html__( 'Generated Content', 'momoacg' ),
				'id'    => 'momo_be_mb_generated_content',
				'rows'  => 10,
				'attr'  => array(
					'data-draft_id' => '',
				),
				'class' => 'momo-be-section-generated-content',
			),
			array(
				'type'  => 'custom',
				'label' => esc_html__( 'Generated Heading(s)', 'momoacg' ),
				'class' => 'momo-be-section momo-hidden momo-be-section-generated-headings momo-bborder',
				'value' => '',
			),
			array(
				'type'   => 'three-columns',
				'class'  => 'momo-bborder momo-margin-minus momo-padding-plus',
				'fields' => array(
					array(
						'type'     => 'switch',
						'label'    => esc_html__( 'Generate Image', 'momoacg' ),
						'id'       => 'momo_be_mb_add_image',
						'class'    => 'momo-no-bborder ',
						'afteryes' => array(
							array(
								'type'    => 'select',
								'label'   => '',
								'default' => 'small',
								'options' => array(
									'small'  => esc_html__( 'Small ( 256 * 256 )', 'momoacg' ),
									'medium' => esc_html__( 'Medium ( 512 * 512 )', 'momoacg' ),
									'large'  => esc_html__( 'Large ( 1024 * 1024 )', 'momoacg' ),
								),
								'size'    => 3,
								'id'      => 'momo_be_mb_image_size',
								'nolabel' => true,
							),
						),
					),
					array(
						'type'  => 'switch',
						'label' => esc_html__( 'Modify headings before generating full content', 'momoacg' ),
						'id'    => 'momo_be_mb_modify_headings',
						'class' => 'momo-no-bborder',
					),
					array(
						'type'     => 'switch',
						'label'    => esc_html__( 'Add hyperlink to selected text', 'momoacg' ),
						'id'       => 'momo_be_mb_add_hyperlink',
						'class'    => 'momo-no-bborder momo-full-afteryes',
						'afteryes' => array(),
					),
				),
			),
			array(
				'type'   => 'afteryes',
				'id'     => 'momo_be_mb_add_hyperlink',
				'class'  => '',
				'fields' => array(
					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Search text', 'momoacg' ),
						'placeholder' => esc_html__( 'Artificial Inteligence', 'momoacg' ),
						'id'          => 'momo_be_mb_search_hyperlink_text',
					),
					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Anchor Link', 'momoacg' ),
						'placeholder' => esc_html__( 'https://', 'momoacg' ),
						'id'          => 'momo_be_mb_anchor_link',
					),
				),
			),
			array(
				'type'     => 'switch',
				'label'    => esc_html__( 'Text Generation Settings', 'momoacg' ),
				'id'       => 'momo_be_mb_text_generation_settings',
				'class'    => 'momo-no-bborder momo-full-afteryes',
				'afteryes' => array(
					array(
						'type'   => 'three-columns',
						'class'  => 'momo-no-bborder',
						'fields' => array(
							array(
								'type'    => 'range-slider',
								'label'   => esc_html__( 'Temperature', 'momoacg' ),
								'helper'  => esc_html__( 'Higher temperature generates less accurate but diverse and creative output. Lesser temperature will generate more accurate results.', 'momoacg' ),
								'id'      => 'momo_be_mb_temperature',
								'min'     => 0.1,
								'max'     => 1.0,
								'step'    => 0.1,
								'default' => 0.7,
							),
							/* array(
								'type'    => 'range-slider',
								'label'   => esc_html__( 'Maximum Tokens', 'momoacg' ),
								'helper'  => esc_html__( 'Use it in combination with "Temperature" to control the randomness and creativity of the output.', 'momoacg' ),
								'id'      => 'momo_be_mb_max_tokens',
								'min'     => 0,
								'max'     => 3000,
								'step'    => 30,
								'default' => 2000,
							), */
							array(
								'type'    => 'range-slider',
								'label'   => esc_html__( 'Top P', 'momoacg' ),
								'helper'  => esc_html__( 'To control randomness of the output.', 'momoacg' ),
								'id'      => 'momo_be_mb_top_p',
								'min'     => 0,
								'max'     => 1,
								'step'    => 0.1,
								'default' => 0.9,
							),
						),
					),
					array(
						'type'   => 'three-columns',
						'class'  => 'momo-no-bborder momo-mt-15',
						'fields' => array(
							array(
								'type'    => 'range-slider',
								'label'   => esc_html__( 'Frequency Penalty', 'momoacg' ),
								'helper'  => esc_html__( 'For improving the quality and coherence of the generated text.', 'momoacg' ),
								'id'      => 'momo_be_mb_frequency_penalty',
								'min'     => 0,
								'max'     => 2,
								'step'    => 0.2,
								'default' => 1,
							),
							array(
								'type'    => 'range-slider',
								'label'   => esc_html__( 'Presence Penalty', 'momoacg' ),
								'helper'  => esc_html__( 'To produce more concise text.', 'momoacg' ),
								'id'      => 'momo_be_mb_presence_penalty',
								'min'     => 0,
								'max'     => 2,
								'step'    => 0.2,
								'default' => 1,
							),
							array(
								'type' => 'custom',
							),
						),
					),
				),
			),
			array(
				'type'    => 'button_block',
				'class'   => 'momo-be-center momo-min-h-30 momo-no-bborder',
				'buttons' => array(
					array(
						'type'  => 'button',
						'label' => esc_html__( 'Generate Content', 'momoacg' ),
						'id'    => 'momo_be_mb_openai_generate_content',
						'class' => 'momo-be-btn-secondary',
					),
					array(
						'type'  => 'button',
						'label' => esc_html__( 'Generate Heading(s)', 'momoacg' ),
						'id'    => 'momo_be_mb_openai_generate_headings',
						'class' => 'momo-be-btn-secondary momo-hidden',
					),
					/* array(
						'type'  => 'button',
						'label' => esc_html__( 'Schedule', 'momoacg' ),
						'id'    => 'momo_be_mb_openai_schedule_generator',
						'class' => 'momo-be-btn-extra momo-pb-triggerer',
						'data'  => array(
							'target'  => 'create-page-popbox',
							'ajax'    => 'momo_acg_create_schedule_popbox',
							'header'  => 'schedule_content_generation',
							'trigger' => 'momo_acg_datepicker',
						),
					),
					array(
						'type'  => 'button',
						'label' => esc_html__( 'Save as Draft', 'momoacg' ),
						'id'    => 'momo_be_mb_openai_draft_content',
						'class' => 'momo-be-btn-extra momo-be-float-right',
					), */
				),
			),
			array(
				'type'  => 'messagebox',
				'class' => 'momo-fe-bottom',
				'id'    => 'momo-fe-cg-msgbox',
			),
		);
		ob_start();
		?>
		<div class="momo-acg-cs-generator" id="openai-content-generator" data-url="<?php echo esc_url( $this->momo_get_current_url() ); ?>">
			<span class="header-title"><?php esc_html_e( 'Content Generator', 'momoacg' ); ?></span>
		<?php
			$momoacg->fn->momo_generate_elements_from_array( $fields );
		?>
		</div><!-- .momo-acg-cs-generator -->
		<?php
		return ob_get_clean();
	}
	/**
	 * Add Plan to Cart
	 *
	 * @param array $args Arguments.
	 */
	public function momo_acg_cs_add_plan_to_cart( $args ) {
		$plan_id = $args['plan_id'];
		$wc_plan = new WC_Product( $plan_id );
		$price   = $wc_plan->get_price();
		$user_id = get_current_user_id();

		$cart_item_data_array = array(
			'_acg_user_id' => $user_id,
			'_acg_plan'    => $plan_id,
		);

		$cart_item_data = apply_filters( 'momo_acg_cs_add_cart_item_meta', $cart_item_data_array );
		$cart_item_keys = WC()->cart->add_to_cart(
			$plan_id,
			1,
			0,
			array(),
			$cart_item_data
		);
		if ( false !== $cart_item_keys ) {
			$status  = 'good';
			$message = $this->momo_acg_cs_added_to_cart_html();
		} else {
			$status  = 'bad';
			$message = esc_html__( 'Could not add plan to cart, please try later!', 'momoacg' );
		}
		return array(
			'status' => $status,
			'msg'    => $message,
		);
	}
	/**
	 * Plan added to cart html.
	 */
	public function momo_acg_cs_added_to_cart_html() {
		$cart     = wc_get_cart_url();
		$checkout = wc_get_checkout_url();
		ob_start();
		?>
		<p><?php esc_html_e( 'Plan successfully added to cart.', 'momoacg' ); ?></p>
		<p><a href="<?php echo esc_url( $cart ); ?>"><?php esc_html_e( 'View Cart', 'momoacg' ); ?></a></p>
		<p><a href="<?php echo esc_url( $checkout ); ?>"><?php esc_html_e( 'Visit Checkout', 'momoacg' ); ?></a></p>
		<?php
		return ob_get_clean();
	}
	/**
	 * Get Current URL.
	 */
	public function momo_get_current_url() {
		if ( isset( $_SERVER['HTTPS'] ) && 'on' === $_SERVER['HTTPS'] ) {
			$url = 'https://';
		} else {
			$url = 'http://';
		}
		$url .= isset( $_SERVER['HTTP_HOST'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) : '';

		$url .= isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
		return $url;
	}
}
