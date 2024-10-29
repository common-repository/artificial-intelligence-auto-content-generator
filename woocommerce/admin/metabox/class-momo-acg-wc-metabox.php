<?php
/**
 * Woo Product Writer Metabox
 *
 * @package momoacg
 * @author MoMo Themes
 * @since v2.2.0
 */
class MoMo_ACG_WC_Metabox {
	/**
	 * Allowed post type
	 *
	 * @var array
	 */
	private $allowed_post_type = array(
		'product',
	);
	/**
	 * MB Title
	 *
	 * @var string
	 */
	public $title;
	/**
	 * MB Context
	 *
	 * @var string
	 */
	public $context;
	/**
	 * MB Priority
	 *
	 * @var string
	 */
	public $priority;
	/**
	 * Constructor
	 */
	public function __construct() {
		global $momoacgwc;
		$this->title    = esc_html__( 'Product Description', 'momoacg' );
		$this->context  = 'side';
		$this->priority = 'default';
		add_action( 'add_meta_boxes', array( $this, 'momo_acg_wc_add_meta_boxes' ) );
	}
	/**
	 * Add OpenAI Content Generator
	 */
	public function momo_acg_wc_add_meta_boxes() {
		foreach ( $this->allowed_post_type as $screen ) {
			add_meta_box(
				'woocommerce-content-generator',
				$this->title,
				array( $this, 'momo_acg_wc_amb_callback' ),
				$screen,
				$this->context,
				$this->priority
			);
		}
	}
	/**
	 * Metaxbox Creator
	 */
	public function momo_acg_wc_amb_callback() {
		global $momoacg;
		$openai_settings   = get_option( 'momo_acg_wc_openai_settings' );
		$temperature       = 0.7;
		$max_tokens        = 2000;
		$top_p             = 1.0;
		$frequency_penalty = 0.0;
		$presence_penalty  = 0.0;

		$fields = array(
			array(
				'type'    => 'messagebox',
				'id'      => 'momo_be_mb_generate_product_messagebox',
				'default' => 'none',
				'class'   => 'momo-mb-10',
			),
			array(
				'type'    => 'select',
				'label'   => esc_html__( 'Language', 'momoacg' ),
				'default' => 'english',
				'options' => $momoacg->lang->momo_get_all_langs(),
				'id'      => 'momo_be_mb_language',
			),
			array(
				'type'        => 'text',
				'label'       => esc_html__( 'Temperature', 'momoacg' ),
				'placeholder' => esc_html__( '0.7', 'momoacg' ),
				'id'          => 'momo_be_mb_temperature',
				'woohelper'   => esc_html__( 'Higher temperature generates less accurate but diverse and creative output. Lesser temperature will generate more accurate results.', 'momoacg' ),
				'value'       => $temperature,
			),
			array(
				'type'        => 'text',
				'label'       => esc_html__( 'Max Tokens', 'momoacg' ),
				'placeholder' => esc_html__( '2000', 'momoacg' ),
				'id'          => 'momo_be_mb_max_tokens',
				'woohelper'   => esc_html__( 'Use it in combination with "Temperature" to control the randomness and creativity of the output.', 'momoacg' ),
				'value'       => $max_tokens,
			),
			array(
				'type'        => 'text',
				'label'       => esc_html__( 'Top P', 'momoacg' ),
				'placeholder' => esc_html__( '1.0', 'momoacg' ),
				'id'          => 'momo_be_mb_top_p',
				'woohelper'   => esc_html__( 'To control randomness of the output.', 'momoacg' ),
				'value'       => $top_p,
			),
			array(
				'type'        => 'text',
				'label'       => esc_html__( 'Frequency Penalty', 'momoacg' ),
				'placeholder' => esc_html__( '0.0', 'momoacg' ),
				'id'          => 'momo_be_mb_frequency_penalty',
				'woohelper'   => esc_html__( 'For improving the quality and coherence of the generated text.', 'momoacg' ),
				'value'       => $frequency_penalty,
			),
			array(
				'type'        => 'text',
				'label'       => esc_html__( 'Presence Penalty', 'momoacg' ),
				'placeholder' => esc_html__( '0.0', 'momoacg' ),
				'id'          => 'momo_be_mb_presence_penalty',
				'woohelper'   => esc_html__( 'To produce more concise text.', 'momoacg' ),
				'value'       => $presence_penalty,
			),
			array(
				'type'   => 'side-buttons-bottom',
				'fields' => array(
					array(
						'type' => 'spinner',
					),
					array(
						'type'  => 'button',
						'id'    => 'momo-acg-wc-generate-product',
						'label' => esc_html__( 'Generate', 'momoacg' ),
						'class' => 'button button-primary button-large',
					),
				),
			),
		);

		/* $content = $momoacg->fn->momo_generate_elements_from_array( $fields, 'momo-mb-side' ); */
		$content = $momoacg->fn->momo_generate_elements_from_array( $fields, 'momo-mb-side' );
		return $content;
	}
}
new MoMo_ACG_WC_Metabox();
