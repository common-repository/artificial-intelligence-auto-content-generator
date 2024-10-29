<?php
/**
 * OpenAI Metabox
 *
 * @package momoacg
 */
class MoMo_ACG_OpenAI_Metabox {
	/**
	 * Allowed post type
	 *
	 * @var array
	 */
	private $allowed_post_type = array(
		'post',
		'page',
		'momoacg',
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
	 * Allowed Roles
	 *
	 * @var array
	 */
	public $allowed_roles;
	/**
	 * Constructor
	 */
	public function __construct() {
		global $momoacg;
		$this->title               = esc_html__( 'Content Generator', 'momoacg' );
		$this->context             = 'normal';
		$this->priority            = 'default';
		$openai_settings           = get_option( 'momo_acg_openai_settings' );
		$enable_openai_post_option = $momoacg->fn->momo_return_option_yesno( $openai_settings, 'enable_openai_post_option' );
		add_action( 'add_meta_boxes', array( $this, 'momo_openai_add_meta_boxes' ) );
		$this->allowed_post_type = $this->momo_get_allowed_post_types();
		$this->allowed_roles     = $this->momo_get_allowed_roles();
	}
	/**
	 * Get current user role
	 */
	public function momo_get_user_role() {
		global $current_user;
		$user_roles = $current_user->roles;
		$user_role  = array_shift( $user_roles );
		return $user_role;
	}
	/**
	 * Get Allowed Post Types
	 */
	public function momo_get_allowed_post_types() {
		global $momoacg;
		$allowed          = array();
		$general_settings = get_option( 'momo_acg_general_settings' );
		$post_types       = $momoacg->fn->momo_list_needed_post_types();
		foreach ( $post_types as $id => $name ) {
			$name = 'enable_for_post_type_' . $id;
			if ( isset( $general_settings[ $name ] ) && 'on' === $general_settings[ $name ] ) {
				$allowed[] = $id;
			}
		}
		return $allowed;
	}
	/**
	 * Get Allowed Roles
	 */
	public function momo_get_allowed_roles() {
		global $momoacg;
		$allowed          = array();
		$general_settings = get_option( 'momo_acg_general_settings' );
		$wp_role          = wp_roles();
		$roles            = $wp_role->get_names();
		foreach ( $roles as $id => $name ) {
			$name = 'enable_for_role_' . $id;
			if ( isset( $general_settings[ $name ] ) && 'on' === $general_settings[ $name ] ) {
				$allowed[] = $id;
			}
		}
		return $allowed;
	}
	/**
	 * Add OpenAI Content Generator
	 */
	public function momo_openai_add_meta_boxes() {
		if ( empty( $this->allowed_post_type ) || empty( $this->allowed_roles ) ) {
			return;
		}
		$user_role = $this->momo_get_user_role();
		foreach ( $this->allowed_post_type as $screen ) {
			if ( in_array( $user_role, $this->allowed_roles, true ) ) {
				add_meta_box(
					'openai-content-generator',
					$this->title,
					array( $this, 'momo_acg_openai_amb_callback' ),
					$screen,
					$this->context,
					$this->priority
				);
			}
		}
	}
	/**
	 * Metaxbox Creator
	 */
	public function momo_acg_openai_amb_callback() {
		global $momoacg;
		$fields = array(
			array(
				'type'   => 'section',
				'id'     => 'momo-be-acg-mb-top-section',
				'class'  => '',
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
						'plan'  => 'Pro',
					),
					array(
						'type'  => 'button',
						'label' => esc_html__( 'Save as Draft', 'momoacg' ),
						'id'    => 'momo_be_mb_openai_draft_content',
						'class' => 'momo-be-btn-extra momo-be-float-right',
					),
				),
			),
		);

		$content = $momoacg->fn->momo_generate_elements_from_array( $fields );
		return $content;
	}
}
new MoMo_ACG_OpenAI_Metabox();
