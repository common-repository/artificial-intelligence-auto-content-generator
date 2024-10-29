<?php
/**
 * Admin Init
 *
 * @package momoacgwc
 * @author MoMo Themes
 * @since v2.2.0
 */
class MoMo_ACG_WC_Admin_Init {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'momo_acgwc_print_admin_ss' ) );
	}
	/**
	 * Enqueue script and styles
	 */
	public function momo_acgwc_print_admin_ss() {
		global $momoacg;
		wp_register_script( 'momoacgwc_admin_script', $momoacg->plugin_url . 'woocommerce/assets/js/momo_acgwc_admin.js', array( 'jquery' ), $momoacg->version, true );
		wp_enqueue_script( 'momoacgwc_admin_script' );
		$ajaxurl = array(
			'ajaxurl'              => admin_url( 'admin-ajax.php' ),
			'momoacgwc_ajax_nonce' => wp_create_nonce( 'momoacgwc_security_key' ),
			'generating_product'   => esc_html__( 'Generating Product Description..', 'momoacg' ),
		);
		wp_localize_script( 'momoacgwc_admin_script', 'momoacgwc_admin', $ajaxurl );
	}
}
new MoMo_ACG_WC_Admin_Init();
