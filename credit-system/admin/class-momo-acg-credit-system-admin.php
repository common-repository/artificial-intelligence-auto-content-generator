<?php
/**
 * Admin Init for Credit System
 *
 * @package momoacg
 * @since v3.0.0
 */
class MoMo_ACG_Credit_System_Admin {
	/**
	 * Construct
	 */
	public function __construct() {

		add_action( 'admin_init', array( $this, 'momoacg_register_cs_settings' ) );

		add_action( 'momo_add_submenu_to_aitools', array( $this, 'momo_add_submenu_of_credit_system' ), 12 );

		add_action( 'admin_enqueue_scripts', array( $this, 'momoacg_credit_system_print_admin_ss' ) );
	}
	/**
	 * Add Submenu Page
	 */
	public function momo_add_submenu_of_credit_system() {
		add_submenu_page(
			'momoacg',
			esc_html__( 'MoMo Themes - Credit System', 'momoacg' ),
			'User Access / Plans',
			'manage_options',
			'momocreditsystem',
			array( $this, 'momo_credit_system_add_admin_settings_page' )
		);
	}
	/**
	 * Settings Page
	 */
	public function momo_credit_system_add_admin_settings_page() {
		global $momoacg;
		?>
		<div id="momo-be-client-access" class="momo-be-admin-content">
			<form method="post" action="options.php" id="momo-momoacg-credit-system-settings-form">
				<?php settings_fields( 'momoacg-settings-credit-system-group' ); ?>
				<?php do_settings_sections( 'momoacg-settings-credit-system-group' ); ?>
				<?php require_once $momoacg->plugin_path . 'credit-system/admin/pages/page-momo-acg-client-access.php'; ?>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}
	/**
	 * Register momoacg Settings
	 */
	public function momoacg_register_cs_settings() {
		register_setting( 'momoacg-settings-credit-system-group', 'momo_acg_credit_system_settings' );
	}
	/**
	 * Add tab li
	 */
	public function momo_acg_add_cs_tab_li() {
		?>
		<li><a class="momo-be-tablinks" href="#momo-be-client-access"><i class='bx bx-credit-card-front'></i><span><?php esc_html_e( 'User Plans', 'momoacg' ); ?></span></a></li>
		<?php
	}
	/**
	 * Add tab content
	 */
	public function momo_acg_add_cs_tab_content() {
		global $momoacg;
		?>
		<div id="momo-be-client-access" class="momo-be-admin-content">
			<form method="post" action="options.php" id="momo-momoacg-credit-system-settings-form">
				<?php settings_fields( 'momoacg-settings-credit-system-group' ); ?>
				<?php do_settings_sections( 'momoacg-settings-credit-system-group' ); ?>
				<?php require_once $momoacg->plugin_path . 'credit-system/admin/pages/page-momo-acg-client-access.php'; ?>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}
	/**
	 * Generate Plan Table Body
	 */
	public static function momo_generate_plan_table() {
		$args  = array(
			'post_type'  => 'product',
			'meta_query' => array(
				array(
					'key'   => '_momo_acg_token_plan',
					'value' => true,
				),
			),
		);
		$plans = new WP_Query( $args );
		if ( $plans->have_posts() ) {
			ob_start();
			while ( $plans->have_posts() ) :
				$plans->the_post();
				$plan_id = $plans->post->ID;
				$plan    = new WC_Product( $plan_id );
				$title   = $plan->get_meta( '_momo_acg_plan_title' );
				$tokens  = $plan->get_meta( '_momo_acg_token_count' );
				$price   = $plan->get_price();
				$status  = get_post_status( $plan_id );
				?>
				<tr data-plan_id="<?php echo esc_attr( $plan_id ); ?>">
					<td><?php echo esc_html( $title ); ?></td>
					<td class="momo-be-center"><?php echo esc_html( $price ); ?></td>
					<td class="momo-be-center"><?php echo esc_html( $tokens ); ?></td>
					<td class="momo-be-center"><?php echo esc_html( $status ); ?></td>
					<td class="momo-be-center">
						<span class="momo-cs-table-action momo-cs-plan-edit"><?php esc_html_e( 'Edit', 'momoacg' ); ?></span> | <span class="momo-cs-table-action momo-cs-plan-delete"><?php esc_html_e( 'Delete', 'momoacg' ); ?></span>
					</td>
				</tr>
				<?php
			endwhile;
			return ob_get_clean();
		} else {
			ob_start();
			?>
			<tr>
				<td colspan="4">
					<div class="momo-be-msg-block show info">
						<?php
						esc_html_e( 'No plan created yet.', 'momoacg' );
						?>
					</div>
				</td>
			</tr>
			<?php
			return ob_get_clean();
		}
	}
	/**
	 * Enqueue script and styles
	 */
	public function momoacg_credit_system_print_admin_ss() {
		global $momoacg;
		wp_enqueue_style( 'momoacg_credit_system_admin', $momoacg->plugin_url . 'credit-system/assets/momo_acg_credit-system.css', array(), $momoacg->version );
		wp_register_script( 'momoacg_credit_system_admin', $momoacg->plugin_url . 'credit-system/assets/momo_acg_credit-system.js', array( 'jquery' ), $momoacg->version, true );
		wp_enqueue_script( 'momoacg_credit_system_admin' );
		$ajaxurl = array(
			'ajaxurl'            => admin_url( 'admin-ajax.php' ),
			'momoacg_ajax_nonce' => wp_create_nonce( 'momoacg_security_key' ),
			'empty_input_fields' => esc_html__( 'Empty input fields or non-numeric value in numeric fields. All field(s) required. Price and Tokens field can only be numeric.', 'momoacg' ),
			'numeric_field'      => esc_html__( 'Price and Tokens field can only be numeric.', 'momoacg' ),
			'confirm_delete'     => esc_html__( 'Are you sure you want to delete this plan?', 'momoacg' ),
		);
		wp_localize_script( 'momoacg_credit_system_admin', 'momoacg_credit_system_admin', $ajaxurl );
	}
}
new MoMo_ACG_Credit_System_Admin();
