<?php
/**
 * Create Page Admin Init
 *
 * @package momoacg
 * @author MoMo Themes
 * @since v2.1.0
 */
class MoMo_ACG_Create_Page_Admin_Init {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'momoacg_set_create_page_admin_menu' ) );
	}
	/**
	 * Set Admin Menu
	 */
	public function momoacg_set_create_page_admin_menu() {
		global $momoacg;
		add_submenu_page(
			'momoacg',
			esc_html__( 'Content Generator', 'momoacg' ),
			esc_html__( 'Create', 'momoacg' ),
			'edit_posts',
			'momoacg-create',
			array( $this, 'momoacg_single_create_page' ),
			0
		);
	}
	/**
	 * Settings Page
	 */
	public function momoacg_single_create_page() {
		global $momoacg;
		include_once $momoacg->plugin_path . 'create-page/pages/momo-acg-create-page.php';
	}
}
new MoMo_ACG_Create_Page_Admin_Init();
