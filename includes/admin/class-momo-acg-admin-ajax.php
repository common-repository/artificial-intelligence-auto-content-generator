<?php
/**
 * MoMo ACG - Amin AJAX functions
 *
 * @package momoacg
 * @author MoMo Themes
 * @since v1.0.0
 */
class MoMo_ACG_Admin_Ajax {
	/**
	 * Constructor
	 */
	public function __construct() {
		$ajax_events = array(
			'momo_acg_openai_generate_content'   => 'momo_acg_openai_generate_content', // One.
			'momo_acg_openai_save_draft_content' => 'momo_acg_openai_save_draft_content', // Two.
			'momo_acg_openai_generate_headings'  => 'momo_acg_openai_generate_headings', // Three.
		);
		foreach ( $ajax_events as $ajax_event => $class ) {
			add_action( 'wp_ajax_' . $ajax_event, array( $this, $class ) );
			add_action( 'wp_ajax_nopriv_' . $ajax_event, array( $this, $class ) );
		}
	}
	/**
	 * Generate OpenAI Content ( One )
	 */
	public function momo_acg_openai_generate_content() {
		global $momoacg;
		$res = check_ajax_referer( 'momoacg_security_key', 'security' );
		if ( isset( $_POST['action'] ) && 'momo_acg_openai_generate_content' !== $_POST['action'] ) {
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

		$args = array(
			'language'        => $language,
			'title'           => $title,
			'addimage'        => $addimage,
			'addintroduction' => $addintroduction,
			'addconclusion'   => $addconclusion,
			'addheadings'     => $addheadings,
			'nopara'          => $nopara,
			'writing_style'   => $writing_style,
			'headingwrapper'  => $headingwrapper,
			'addhyperlink'    => $addhyperlink,
			'hyperlink_text'  => $hyperlink_text,
			'anchor_link'     => $anchor_link,
			'modifyheadings'  => $modifyheadings,
			'headings'        => $headings,
		);
		$momoacg->api->momoacg_openai_generate_content_output_json( $args );
	}
	/**
	 * Save Draft Content ( Two )
	 */
	public function momo_acg_openai_save_draft_content() {
		global $momoacg;
		$res = check_ajax_referer( 'momoacg_security_key', 'security' );
		if ( isset( $_POST['action'] ) && 'momo_acg_openai_save_draft_content' !== $_POST['action'] ) {
			return;
		}
		$content  = isset( $_POST['content'] ) ? wp_kses_post( wp_unslash( $_POST['content'] ) ) : '';
		$draft_id = isset( $_POST['draft_id'] ) ? sanitize_text_field( wp_unslash( $_POST['draft_id'] ) ) : '';
		$title    = isset( $_POST['title'] ) ? sanitize_text_field( wp_unslash( $_POST['title'] ) ) : esc_html( 'ACG Draft Content - ' ) . time();
		$user_id  = get_current_user_id();
		if ( empty( $content ) ) {
			echo wp_json_encode(
				array(
					'status' => 'bad',
					'msg'    => esc_html__( 'Generated content field is empty. Please generate some content first before saving it as draft.', 'momoacg' ),
				)
			);
			exit;
		}
		if ( ! empty( $draft_id ) ) {
			$data   = array(
				'ID'           => $draft_id,
				'post_title'   => $title,
				'post_content' => $content,
				'post_status'  => 'draft',
				'post_type'    => 'momoacg',
			);
			$return = wp_update_post( $data );
			if ( is_wp_error( $return ) ) {
				echo wp_json_encode(
					array(
						'status' => 'bad',
						'msg'    => esc_html__( 'Something went wrong while updating draft. Please try again later.', 'momoacg' ),
					)
				);
				exit;
			} else {
				echo wp_json_encode(
					array(
						'status'   => 'good',
						'msg'      => esc_html__( 'Draft updated successfully.', 'momoacg' ),
						'draft_id' => $return,
					)
				);
				exit;
			}
		} else {
			$data   = array(
				'post_title'   => $title,
				'post_content' => $content,
				'post_status'  => 'draft',
				'post_type'    => 'momoacg',
			);
			$return = wp_insert_post( $data );
			if ( is_wp_error( $return ) ) {
				echo wp_json_encode(
					array(
						'status' => 'bad',
						'msg'    => esc_html__( 'Something went wrong while creating draft. Please try again later.', 'momoacg' ),
					)
				);
				exit;
			} else {
				echo wp_json_encode(
					array(
						'status'   => 'good',
						'msg'      => esc_html__( 'Content Draft created successfully.', 'momoacg' ),
						'draft_id' => $return,
					)
				);
				exit;
			}
		}
	}
	/**
	 * Generate OpenAI Headings ( Three )
	 */
	public function momo_acg_openai_generate_headings() {
		global $momoacg;
		$res = check_ajax_referer( 'momoacg_security_key', 'security' );
		if ( isset( $_POST['action'] ) && 'momo_acg_openai_generate_headings' !== $_POST['action'] ) {
			return;
		}
		$language       = isset( $_POST['language'] ) ? sanitize_text_field( wp_unslash( $_POST['language'] ) ) : '';
		$title          = isset( $_POST['title'] ) ? sanitize_text_field( wp_unslash( $_POST['title'] ) ) : '';
		$nopara         = isset( $_POST['nopara'] ) ? sanitize_text_field( wp_unslash( $_POST['nopara'] ) ) : 4;
		$writing_style  = isset( $_POST['writing_style'] ) ? sanitize_text_field( wp_unslash( $_POST['writing_style'] ) ) : 'informative';
		$modifyheadings = isset( $_POST['modifyheadings'] ) ? sanitize_text_field( wp_unslash( $_POST['modifyheadings'] ) ) : 'off';

		$args = array(
			'language'       => $language,
			'title'          => $title,
			'nopara'         => $nopara,
			'writing_style'  => $writing_style,
			'modifyheadings' => $modifyheadings,
		);
		$momoacg->api->momoacg_openai_generate_headings_output_json( $args );
	}
}
