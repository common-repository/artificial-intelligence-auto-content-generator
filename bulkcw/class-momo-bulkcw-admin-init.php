<?php
/**
 * Bulk Content Writer Admin Init
 *
 * @package momoacg
 */
class MoMo_Bulkcw_Admin_Init {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'momo_add_submenu_to_aitools', array( $this, 'momo_add_submenu_of_bulkwriter' ), 16 );

		add_action( 'admin_enqueue_scripts', array( $this, 'momoacg_bulkcw_print_admin_ss' ) );
		add_filter( 'momo_acg_add_extra_screens_for_body_class', array( $this, 'momo_acg_add_screen_id' ), 10, 1 );
	}
	/**
	 * Add screen id for styles
	 *
	 * @param array $screen_ids Current Ids.
	 */
	public function momo_acg_add_screen_id( $screen_ids ) {
		$screen_id    = 'auto-content-generator_page_bulkcw';
		$screen_ids[] = $screen_id;
		return $screen_ids;
	}
	/**
	 * Set Menu for Bulk Content Writer
	 */
	public function momo_add_submenu_of_bulkwriter() {
		global $momoacg;
		add_submenu_page(
			'momoacg',
			esc_html__( 'Bulk Content Writer', 'momoacg' ),
			esc_html__( 'Bulk Content Writer', 'momoacg' ),
			'manage_options',
			'momobulkcw',
			array( $this, 'momo_bulkcw_add_admin_settings_page' )
		);
	}
	/**
	 * Set Menu for Bulk Content Writer
	 */
	public function momo_add_submenu_of_support() {
		add_submenu_page(
			'momoacg',
			'Support Forum',
			'Support Forum',
			'manage_options',
			'http://helpdesk.momothemes.com/',
			false
		);
	}
	/**
	 * Settings Page
	 */
	public function momo_bulkcw_add_admin_settings_page() {
		global $momoacg;
		include_once $momoacg->plugin_path . 'bulkcw/pages/momo-bulkcw-settings.php';
	}
	/**
	 * Enqueue script and styles
	 */
	public function momoacg_bulkcw_print_admin_ss() {
		global $momoacg;
		wp_enqueue_style( 'momoacg_bulkcw_admin', $momoacg->plugin_url . 'bulkcw/assets/momo_acg_bulkcw.css', array(), $momoacg->version );
		wp_enqueue_style( 'jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/blitzer/jquery-ui.css', array(), '1.13.2' );
		wp_register_script( 'momoacg_bulkcw_admin', $momoacg->plugin_url . 'bulkcw/assets/momo_acg_bulkcw.js', array( 'jquery', 'jquery-ui-datepicker' ), $momoacg->version, true );
		wp_enqueue_script( 'momoacg_bulkcw_admin' );
		$ajaxurl = array(
			'ajaxurl'            => admin_url( 'admin-ajax.php' ),
			'momoacg_ajax_nonce' => wp_create_nonce( 'momoacg_security_key' ),
			'generating_row'     => esc_html__( 'Generating new title row', 'momoacg' ),
			'queueing_titles'    => esc_html__( 'Adding title(s) to queue', 'momoacg' ),
		);
		wp_localize_script( 'momoacg_bulkcw_admin', 'momoacg_bulkcw_admin', $ajaxurl );
	}
}
new MoMo_Bulkcw_Admin_Init();
