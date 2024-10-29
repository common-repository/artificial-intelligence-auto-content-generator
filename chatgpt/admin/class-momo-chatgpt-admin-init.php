<?php
/**
 * Admin Init
 *
 * @package momoacg
 */
class MoMo_ChatGPT_Admin_Init {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'momo_add_submenu_to_aitools', array( $this, 'momo_add_submenu_of_chatgpt' ), 15 );

		add_action( 'admin_init', array( $this, 'momochatgpt_register_settings' ) );
		add_filter( 'momo_acg_add_extra_screens_for_body_class', array( $this, 'momo_acg_add_screen_id' ), 10, 1 );
	}
	/**
	 * Add screen id for styles
	 *
	 * @param array $screen_ids Current Ids.
	 */
	public function momo_acg_add_screen_id( $screen_ids ) {
		$screen_id    = 'auto-content-generator_page_momochatgpt';
		$screen_ids[] = $screen_id;
		return $screen_ids;
	}
	/**
	 * Register momoacg Settings
	 */
	public function momochatgpt_register_settings() {
		register_setting( 'momoacg-settings-chatgpt-group', 'momo_chatgpt_openai_settings' );
	}
	/**
	 * Set Admin Menu
	 */
	public function momo_add_submenu_of_chatgpt() {
		global $momoacg;
		add_submenu_page(
			'momoacg',
			esc_html__( 'MoMo ChatGPT', 'momoacg' ),
			'ChatGPT',
			'manage_options',
			'momochatgpt',
			array( $this, 'momochatgpt_add_admin_settings_page' )
		);
	}
	/**
	 * Settings Page
	 */
	public function momochatgpt_add_admin_settings_page() {
		global $momoacg;
		include_once $momoacg->plugin_path . 'chatgpt/admin/pages/momo-chatgpt-settings.php';
	}
}
new MoMo_ChatGPT_Admin_Init();
