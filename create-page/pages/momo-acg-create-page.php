<?php
/**
 * MoMo ACG - Single Create Page
 *
 * @author MoMo Themes
 * @package momoacg
 * @since v2.1.0
 */

global $momoacg;
$is_premium = momoacg_fs()->is_premium();

$fields = array(
	array(
		'type'  => 'popbox',
		'id'    => 'create-page-popbox',
		'class' => 'momo-effect-1',
	),
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
					array(
						'type'    => 'range-slider',
						'label'   => esc_html__( 'Maximum Tokens', 'momoacg' ),
						'helper'  => esc_html__( 'Use it in combination with "Temperature" to control the randomness and creativity of the output.', 'momoacg' ),
						'id'      => 'momo_be_mb_max_tokens',
						'min'     => 0,
						'max'     => 3000,
						'step'    => 30,
						'default' => 2000,
					),
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
		'class'   => 'momo-be-center momo-min-h-30',
		'buttons' => array(
			array(
				'type'  => 'button',
				'label' => esc_html__( 'Generate Content', 'momoacg' ),
				'id'    => 'momo_be_mb_openai_generate_content',
				'class' => 'momo-be-btn-secondary momo-be-float-left',
			),
			array(
				'type'  => 'button',
				'label' => esc_html__( 'Generate Heading(s)', 'momoacg' ),
				'id'    => 'momo_be_mb_openai_generate_headings',
				'class' => 'momo-be-btn-secondary momo-hidden momo-be-float-left',
			),
			array(
				'type'  => 'button',
				'label' => esc_html__( 'Schedule', 'momoacg' ),
				'pro'   => $is_premium,
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
			),
		),
	),
);
?>
<div class="wrap">
	<div class="momo-acg-single-page-create" id="openai-content-generator">
		<span class="header-title"><?php esc_html_e( 'Content Generator', 'momoacg' ); ?></span>
<?php
	$momoacg->fn->momo_generate_elements_from_array( $fields );
?>
	</div><!-- .momo-acg-single-page-create -->
</div><!-- ends .wrap -->
<?php
