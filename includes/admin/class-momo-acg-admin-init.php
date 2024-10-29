<?php
/**
 * Admin Init
 *
 * @package momoacg
 */
class MoMo_ACG_Admin_Init {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'momoacg_set_admin_menu' ) );

		add_action( 'momo_add_submenu_to_aitools', array( $this, 'momo_add_submenu_of_main' ), 11 );

		add_action( 'momo_add_submenu_to_aitools', array( $this, 'momo_add_submenu_of_debug_log' ), 17 );

		add_action( 'momo_add_submenu_to_aitools', array( $this, 'momo_add_submenu_of_instructions' ), 18 );

		add_action( 'momo_add_submenu_to_aitools', array( $this, 'momo_add_submenu_of_helpdesk' ), 19 );

		add_action( 'admin_enqueue_scripts', array( $this, 'momoacg_print_admin_ss' ) );

		add_action( 'admin_init', array( $this, 'momoacg_register_settings' ) );
	}
	/**
	 * Register momoacg Settings
	 */
	public function momoacg_register_settings() {
		register_setting( 'momoacg-settings-openai-group', 'momo_acg_openai_settings' );
		register_setting( 'momoacg-settings-blocks-group', 'momo_acg_blocks_settings' );
		register_setting( 'momoacg-settings-general-group', 'momo_acg_general_settings' );
	}
	/**
	 * Set Admin Menu
	 */
	public function momoacg_set_admin_menu() {
		global $momoacg;
		add_menu_page(
			esc_html__( 'MoMo Auto Content Generator', 'momoacg' ),
			'AI Tools',
			'manage_options',
			'momoacg',
			array( $this, 'momoacg_add_admin_settings_page' ),
			'',
			6
		);
		do_action( 'momo_add_submenu_to_aitools' );
	}
	/**
	 * Add Submenu Page.
	 */
	public function momo_add_submenu_of_main() {
		add_submenu_page(
			'momoacg',
			'Auto Content Generator',
			'Settings',
			'manage_options',
			'momoacg'
		);
		add_submenu_page(
			'momoacg',
			'Draft Contents',
			'Draft Contents',
			'edit_posts',
			'edit.php?post_type=momoacg'
		);
	}
	/**
	 * Settings Page
	 */
	public function momoacg_add_admin_settings_page() {
		global $momoacg;
		include_once $momoacg->plugin_path . 'includes/admin/pages/momo-acg-settings.php';
	}
	/**
	 * Add Instrution Menu.
	 */
	public function momo_add_submenu_of_instructions() {
		add_submenu_page(
			'momoacg',
			'Instructions',
			'Instructions',
			'manage_options',
			'momoinstructions',
			array( $this, 'momo_add_admin_instructions_page' )
		);
	}
	/**
	 * Instructions Page
	 */
	public function momo_add_admin_instructions_page() {
		global $momoacg;
		include_once $momoacg->plugin_path . 'includes/admin/pages/page-momo-acg-openai-instructions.php';
	}
	/**
	 * Add debug log.
	 */
	public function momo_add_submenu_of_debug_log() {
		add_submenu_page(
			'momoacg',
			'Debug Log',
			'Debug Log',
			'manage_options',
			'momodebuglog',
			array( $this, 'momo_debuglog_add_admin_settings_page' )
		);
	}
	/**
	 * Debug log Settings page.
	 */
	public function momo_debuglog_add_admin_settings_page() {
		global $momoacg;
		include_once $momoacg->plugin_path . 'includes/admin/pages/page-momo-acg-debug-log.php';
	}
	/**
	 * Add Helpdesk Menu.
	 */
	public function momo_add_submenu_of_helpdesk() {
		add_submenu_page(
			'momoacg',
			'HelpDesk',
			'HelpDesk',
			'manage_options',
			'momohelpdesk',
			array( $this, 'momo_add_admin_helpdesk_page' )
		);
	}
	/**
	 * HelpDesk Page
	 */
	public function momo_add_admin_helpdesk_page() {
		global $momoacg;
		include_once $momoacg->plugin_path . 'includes/admin/pages/page-momo-acg-support-forum.php';
	}
	/**
	 * Enqueue script and styles
	 */
	public function momoacg_print_admin_ss() {
		global $momoacg;
		wp_enqueue_style( 'momoacg_icon_style', $momoacg->plugin_url . 'assets/css/momo_acg_icon.css', array(), $momoacg->version );
		$screen        = get_current_screen();
		$allowed_pages = array(
			'ai-tools_page_momoacg-create',
			'toplevel_page_momoacg',
			'ai-tools_page_momodebuglog',
			'ai-tools_page_momohelpdesk',
			'ai-tools_page_momochatgpt',
			'ai-tools_page_momobulkcw',
			'ai-tools_page_momoautoblog',
			'ai-tools_page_momochatbot',
			'ai-tools_page_momocreditsystem',
			'ai-tools_page_momoinstructions',
		);

		if ( $screen && in_array( $screen->id, $allowed_pages, true ) ) {
			wp_enqueue_style( 'momoacg_admin_style', $momoacg->plugin_url . 'assets/css/momo_acg_admin.css', array(), $momoacg->version );
			wp_enqueue_style( 'momoacg_admin_settings', $momoacg->plugin_url . 'assets/css/momo-admin-settings.css', array(), $momoacg->version );
			wp_dequeue_style( 'momoacgwc_admin_style' );
			wp_dequeue_style( 'momowsw_admin_style' );
		}
		wp_enqueue_style( 'momoacg_boxicons', $momoacg->plugin_url . 'assets/boxicons/css/boxicons.min.css', array(), '2.1.2' );
		wp_enqueue_style( 'momoacg_oepnai', $momoacg->plugin_url . 'assets/boxicons/css/openai.css', array(), $momoacg->version );
		wp_register_script( 'momoacg_admin_script', $momoacg->plugin_url . 'assets/js/momo_acg_admin.js', array( 'jquery' ), $momoacg->version, true );
		wp_enqueue_script( 'momoacg_admin_script' );
		$ajaxurl = array(
			'ajaxurl'            => admin_url( 'admin-ajax.php' ),
			'momoacg_ajax_nonce' => wp_create_nonce( 'momoacg_security_key' ),
			'generating_content' => esc_html__( 'Generating Content..', 'momoacg' ),
			'generating_heading' => esc_html__( 'Generating Heading(s)..', 'momoacg' ),
			'saving_draft'       => esc_html__( 'Saving Draft..', 'momoacg' ),
			'empty_response'     => esc_html__( 'Something went wrong while generating content.', 'momoacg' ),
		);
		wp_localize_script( 'momoacg_admin_script', 'momoacg_admin', $ajaxurl );
	}
}
new MoMo_ACG_Admin_Init();
