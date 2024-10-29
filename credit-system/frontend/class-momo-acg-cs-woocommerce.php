<?php
/**
 * MoMo Credit System Woocommerce
 *
 * @package momoacg
 * @author MoMo Themes
 * @since v3.0.0
 */
class MoMo_ACG_CS_Woocommerce {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'woocommerce_checkout_create_order_line_item', array( $this, 'mom_acg_cs_cart_item_data_to_order_item_meta' ), 1, 4 );
		add_action( 'woocommerce_order_status_completed', array( $this, 'momo_acg_associate_with_user' ), 10, 1 );
	}
	/**
	 * Associate Plan info with user
	 *
	 * @param integer $order_id Order ID.
	 */
	public function momo_acg_associate_with_user( $order_id ) {
		if ( empty( $order_id ) ) {
			return false;
		}
		$wc_order = new WC_Order( $order_id );
		$items    = $wc_order->get_items();
		foreach ( $items as $item_id => $item ) {
			$user_id = wc_get_order_item_meta( $item_id, '_acg_user_id', true );
			$plan_id = wc_get_order_item_meta( $item_id, '_acg_plan', true );
			if ( ! empty( $user_id ) && 0 !== $user_id && ! empty( $plan_id ) ) {
				update_user_meta( $user_id, '_acg_credit_plan_enabled', $plan_id );
			}
		}
	}
	/**
	 * Cart Item meta to order meta
	 *
	 * @param array    $item Item.
	 * @param string   $cart_item_key Key.
	 * @param array    $values Values.
	 * @param WC_Order $order Order.
	 */
	public function mom_acg_cs_cart_item_data_to_order_item_meta( $item, $cart_item_key, $values, $order ) {
		if ( isset( $values['_acg_user_id'] ) ) {
			$item->add_meta_data( '_acg_user_id', $values['_acg_user_id'], true );
		}
		if ( isset( $values['_acg_plan'] ) ) {
			$item->add_meta_data( '_acg_plan', $values['_acg_plan'], true );
		}
	}
}
new MoMo_ACG_CS_Woocommerce();
