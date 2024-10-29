<?php
/**
 * Plugin Name:       Momo Acg Block
 * Description:       A Gutenberg block to auto generate content from given topic.
 * Version:           1.1.0
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       momo-acg-block
 *
 * @package           create-block
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_block_momo_acg_block_block_init() {
	global $momoacg;
	register_block_type(
		__DIR__ . '/build',
		array(
			'api_version' => 2,
			'attributes'  => array(
				'language'              => array(
					'type'    => 'string',
					'default' => 'english',
				),
				'title'                 => array(
					'type'    => 'string',
					'default' => '',
				),
				'noOfPara'              => array(
					'type'    => 'number',
					'default' => 4,
				),
				'headingsYesNo'         => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'headingsWrapper'       => array(
					'type'    => 'string',
					'default' => 'h1',
				),
				'writingStyle'          => array(
					'type'    => 'string',
					'default' => 'informative',
				),
				'introductionYesNo'     => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'conclusionYesNo'       => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'imageYesNo'            => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'hyperlinkYesNo'        => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'hyperlinkText'         => array(
					'type'    => 'string',
					'default' => '',
				),
				'anchorLink'            => array(
					'type'    => 'string',
					'default' => '',
				),
				'generatedContent'      => array(
					'type'     => 'string',
					'default'  => '',
					'source'   => 'html',
					'selector' => 'div',
				),
				'isGenerating'          => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'contentGenerated'      => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'generatedResult'       => array(
					'type'    => 'string',
					'default' => '',
				),
				'cannotGenerateContent' => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'errorMessage'          => array(
					'type'    => 'string',
					'default' => '',
				),
			),
		)
	);
	$settings = array(
		'language'      => $momoacg->lang->momo_get_all_langs(),
		'writing_style' => $momoacg->lang->momo_get_all_writing_style(),
		'block_help'    => esc_html__( 'Please select your preferred settings and click generate content from right hand side settings options panel.', 'momoacg' ),
	);
	wp_localize_script( 'momo-acg-block-editor-script', 'momoacg_block_admin', $settings );
}
add_action( 'init', 'create_block_momo_acg_block_block_init', 20 );
