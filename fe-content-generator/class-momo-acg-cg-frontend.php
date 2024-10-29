<?php
/**
 * MoMo Content Generator Frontend
 *
 * @package momoacg
 * @author MoMo Themes
 * @since v3.9.0
 */
class MoMo_ACG_CG_Frontned {
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
		wp_enqueue_style( 'momoacgcs_fe_style', $momoacg->plugin_url . 'fe-content-generator/assets/momo_acgcs_fe.css', array(), $momoacg->version );
		wp_register_script( 'momoacgcs_fe_script', $momoacg->plugin_url . 'fe-content-generator/assets/momo_acgcs_fe.js', array( 'jquery' ), $momoacg->version, true );
		wp_register_script( 'momoacgcs_sync_fe', $momoacg->plugin_url . 'fe-content-generator/assets/momo_acg_sync_fe.js', array( 'jquery' ), $momoacg->version, true );

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
				'class'  => 'momo-no-tborder',
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
				'plan'  => 'Pro',
			),
			array(
				'type'   => 'three-columns',
				'fields' => array(
					array(
						'type'  => 'switch',
						'label' => esc_html__( 'Generate Image', 'momoacg' ),
						'id'    => 'momo_be_mb_add_image',
						'class' => 'momo-no-bborder',
					),
					array(
						'type'  => 'switch',
						'label' => esc_html__( 'Modify headings before generating full content', 'momoacg' ),
						'id'    => 'momo_be_mb_modify_headings',
						'class' => 'momo-no-bborder',
						'plan'  => 'Pro',
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
				'type'    => 'button_block',
				'class'   => 'momo-no-bborder',
				'buttons' => array(
					array(
						'type'  => 'button',
						'label' => esc_html__( 'Generate Content', 'momoacg' ),
						'id'    => 'momo_be_mb_openai_generate_content_fe',
						'class' => 'momo-be-btn-secondary',
					),
					array(
						'type'  => 'button',
						'label' => esc_html__( 'Generate Heading(s)', 'momoacg' ),
						'id'    => 'momo_be_mb_openai_generate_headings',
						'class' => 'momo-be-btn-secondary momo-hidden',
						'plan'  => 'Pro',
					),
				),
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
