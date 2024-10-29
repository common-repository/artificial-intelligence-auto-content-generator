<?php
/**
 * Admin Init
 *
 * @package momoacg
 */
class MoMo_RssFeed_Admin_Init {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'momo_add_submenu_to_aitools', array( $this, 'momo_add_submenu_of_autoblog' ), 13 );

		add_action( 'admin_init', array( $this, 'momorssfeed_register_settings' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'momoacg_rssfeed_print_admin_ss' ) );
		add_filter( 'momo_acg_add_extra_screens_for_body_class', array( $this, 'momo_acg_add_screen_id' ), 10, 1 );
	}
	/**
	 * Add screen id for styles
	 *
	 * @param array $screen_ids Current Ids.
	 */
	public function momo_acg_add_screen_id( $screen_ids ) {
		$screen_id    = 'auto-content-generator_page_momorssfeed';
		$screen_ids[] = $screen_id;
		return $screen_ids;
	}
	/**
	 * Register momoacg Settings
	 */
	public function momorssfeed_register_settings() {
		register_setting( 'momoacg-settings-rssfeed-group', 'momo_rssfeed_openai_settings' );
		register_setting( 'momoacg-settings-autoblog-group', 'momo_autoblog_openai_settings' );
	}
	/**
	 * Set Admin Menu
	 */
	public function momo_add_submenu_of_autoblog() {
		global $momoacg;
		add_submenu_page(
			'momoacg',
			esc_html__( 'MoMo Auto Blog', 'momoacg' ),
			'Auto Blog',
			'manage_options',
			'momoautoblog',
			array( $this, 'momorssfeed_add_admin_settings_page' )
		);
	}
	/**
	 * Settings Page
	 */
	public function momorssfeed_add_admin_settings_page() {
		global $momoacg;
		include_once $momoacg->plugin_path . 'autoblog/admin/pages/momo-acg-auto-blog-settings.php';
	}
	/**
	 * Enqueue script and styles
	 */
	public function momoacg_rssfeed_print_admin_ss() {
		global $momoacg;
		wp_enqueue_style( 'momoacg_rssfeed_admin', $momoacg->plugin_url . 'autoblog/assets/css/momo_rssfeed.css', array(), $momoacg->version );
		wp_register_script( 'momoacg_rssfeed_admin', $momoacg->plugin_url . 'autoblog/assets/js/momo_rssfeed.js', array( 'jquery' ), $momoacg->version, true );
		wp_enqueue_script( 'momoacg_rssfeed_admin' );
		$ajaxurl = array(
			'ajaxurl'            => admin_url( 'admin-ajax.php' ),
			'momoacg_ajax_nonce' => wp_create_nonce( 'momoacg_security_key' ),
			'empty_feed_url'     => esc_html__( 'RSS feed url field is empty. Please enter URL before processing.', 'momoacg' ),
			'empty_tag_field'    => esc_html__( 'Tag field is empty. Please add some tag(s) before processing.', 'momoacg' ),
			'generating_titles'  => esc_html__( 'Generating title(s)', 'momoacg' ),
			'generating_cron'    => esc_html__( 'Generating cron job(s)', 'momoacg' ),
		);
		wp_localize_script( 'momoacg_rssfeed_admin', 'momoacg_rssfeed_admin', $ajaxurl );
	}
}
new MoMo_RssFeed_Admin_Init();
