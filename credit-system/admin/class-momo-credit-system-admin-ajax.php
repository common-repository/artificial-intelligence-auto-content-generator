<?php
/**
 * MoMo ACG Credit System - Amin AJAX functions
 *
 * @package momoacg
 * @author MoMo Themes
 * @since v3.0.0
 */
class MoMo_Credit_System_Admin_Ajax {
	/**
	 * Constructor
	 */
	public function __construct() {
		$ajax_events = array(
			'momo_acg_cs_create_new_plan' => 'momo_acg_cs_create_new_plan', // One.
			'momo_acg_cs_access_old_plan' => 'momo_acg_cs_access_old_plan', // Two.
			'momo_acg_cs_update_old_plan' => 'momo_acg_cs_update_old_plan', // Three.
			'momo_acg_cs_delete_old_plan' => 'momo_acg_cs_delete_old_plan', // Four.
		);
		foreach ( $ajax_events as $ajax_event => $class ) {
			add_action( 'wp_ajax_' . $ajax_event, array( $this, $class ) );
			add_action( 'wp_ajax_nopriv_' . $ajax_event, array( $this, $class ) );
		}
	}
	/**
	 * Generate New Title Row ( One )
	 */
	public function momo_acg_cs_create_new_plan() {
		global $momoacg;
		$res = check_ajax_referer( 'momoacg_security_key', 'security' );
		if ( isset( $_POST['action'] ) && 'momo_acg_cs_create_new_plan' !== $_POST['action'] ) {
			return;
		}
		$title  = isset( $_POST['title'] ) ? sanitize_text_field( wp_unslash( $_POST['title'] ) ) : '';
		$price  = isset( $_POST['price'] ) ? sanitize_text_field( wp_unslash( $_POST['price'] ) ) : '';
		$tokens = isset( $_POST['tokens'] ) ? sanitize_text_field( wp_unslash( $_POST['tokens'] ) ) : '';

		$plan  = new WC_Product_Simple();
		$front = esc_html__( 'ACG Token Plan: ', 'momoacg' );
		$plan->set_name( $front . $title );
		$plan->set_slug( sanitize_title( $title ) );
		$plan->set_regular_price( $price );
		$category_id = $this->momo_create_or_return_acg_plan_term_id();
		$plan->set_category_ids( array( $category_id ) );
		$plan->update_meta_data( '_momo_acg_plan_title', $title );
		$plan->update_meta_data( '_momo_acg_token_plan', true );
		$plan->update_meta_data( '_momo_acg_token_count', $tokens );
		$plan->set_virtual( true );
		$plan->save();
		$content = MoMo_ACG_Credit_System_Admin::momo_generate_plan_table();
		echo wp_json_encode(
			array(
				'status'  => 'good',
				'msg'     => esc_html__( 'Plan added successfully.', 'momoacg' ),
				'content' => $content,
			)
		);
		exit;
	}
	/**
	 * Access Old Plan ( One )
	 */
	public function momo_acg_cs_access_old_plan() {
		global $momoacg;
		$res = check_ajax_referer( 'momoacg_security_key', 'security' );
		if ( isset( $_POST['action'] ) && 'momo_acg_cs_access_old_plan' !== $_POST['action'] ) {
			return;
		}
		$plan_id = isset( $_POST['plan_id'] ) ? sanitize_text_field( wp_unslash( $_POST['plan_id'] ) ) : '';

		$wc_product = wc_get_product( $plan_id );
		if ( $wc_product ) {
			$plan_title  = $wc_product->get_meta( '_momo_acg_plan_title' );
			$token_count = $wc_product->get_meta( '_momo_acg_token_count' );
			$price       = $wc_product->get_price();
			echo wp_json_encode(
				array(
					'status'  => 'good',
					'msg'     => esc_html__( 'Plan accessed successfully.', 'momoacg' ),
					'plan_id' => $plan_id,
					'title'   => $plan_title,
					'tokens'  => $token_count,
					'price'   => $price,
				)
			);
			exit;
		}
		echo wp_json_encode(
			array(
				'status'  => 'bad',
				'msg'     => esc_html__( 'Something went wrong while accessing plan.', 'momoacg' ),
				'plan_id' => $plan_id,
			)
		);
		exit;
	}
	/**
	 * Update Old plan ( Three )
	 */
	public function momo_acg_cs_update_old_plan() {
		global $momoacg;
		$res = check_ajax_referer( 'momoacg_security_key', 'security' );
		if ( isset( $_POST['action'] ) && 'momo_acg_cs_update_old_plan' !== $_POST['action'] ) {
			return;
		}
		$plan_id = isset( $_POST['plan_id'] ) ? sanitize_text_field( wp_unslash( $_POST['plan_id'] ) ) : '';
		$title   = isset( $_POST['title'] ) ? sanitize_text_field( wp_unslash( $_POST['title'] ) ) : '';
		$price   = isset( $_POST['price'] ) ? sanitize_text_field( wp_unslash( $_POST['price'] ) ) : '';
		$tokens  = isset( $_POST['tokens'] ) ? sanitize_text_field( wp_unslash( $_POST['tokens'] ) ) : '';

		$plan  = new WC_Product_Simple( $plan_id );
		$front = esc_html__( 'ACG Token Plan: ', 'momoacg' );
		$plan->set_name( $front . $title );
		$plan->set_slug( sanitize_title( $title ) );
		$plan->set_regular_price( $price );
		$plan->update_meta_data( '_momo_acg_plan_title', $title );
		$plan->update_meta_data( '_momo_acg_token_plan', true );
		$plan->update_meta_data( '_momo_acg_token_count', $tokens );
		$plan->set_virtual( true );
		$plan->save();
		$content = MoMo_ACG_Credit_System_Admin::momo_generate_plan_table();
		echo wp_json_encode(
			array(
				'status'  => 'good',
				'msg'     => esc_html__( 'Plan updated successfully.', 'momoacg' ),
				'content' => $content,
			)
		);
		exit;

	}
	/**
	 * Delete Old Plan ( Four )
	 */
	public function momo_acg_cs_delete_old_plan() {
		global $momoacg;
		$res = check_ajax_referer( 'momoacg_security_key', 'security' );
		if ( isset( $_POST['action'] ) && 'momo_acg_cs_delete_old_plan' !== $_POST['action'] ) {
			return;
		}
		$plan_id = isset( $_POST['plan_id'] ) ? sanitize_text_field( wp_unslash( $_POST['plan_id'] ) ) : '';
		if ( wc_get_product( $plan_id ) ) {
			wp_delete_post( $plan_id, true );
			$content = MoMo_ACG_Credit_System_Admin::momo_generate_plan_table();
			echo wp_json_encode(
				array(
					'status'  => 'good',
					'msg'     => esc_html__( 'Plan deleted successfully.', 'momoacg' ),
					'content' => $content,
				)
			);
			exit;
		} else {
			echo wp_json_encode(
				array(
					'status'  => 'bad',
					'msg'     => esc_html__( 'Something went wrong while deleting plan. Plan does not exist.', 'momoacg' ),
					'plan_id' => $plan_id,
				)
			);
			exit;
		}
	}
	/**
	 * Create or Return term ID for Product Category (acg_plan)
	 */
	public function momo_create_or_return_acg_plan_term_id() {
		$term        = term_exists( 'momo-acg-token-plan', 'product_cat' );
		$tax_term_id = null;
		if ( ! empty( $term ) && 0 !== $term && null !== $term ) {
			$tax_term_id = (int) $term['term_id'];
		} else {
			$new_term = wp_insert_term(
				'ACG Token Plan',
				'product_cat',
				array(
					'description' => 'MoMo ACG Credit System Token Plan',
					'parent'      => 0,
					'slug'        => 'momo-acg-token-plan',
				)
			);
			if ( ! is_wp_error( $new_term ) ) {
				$tax_term_id = intval( $new_term['term_id'] );
			}
		}
		return $tax_term_id;
	}
}
new MoMo_Credit_System_Admin_Ajax();
