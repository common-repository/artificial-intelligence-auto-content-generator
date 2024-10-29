<?php

/**
 * MoMO ACG - Credit System Settings
 *
 * @author MoMo Themes
 * @package momoacg
 * @since v3.0.0
 */
global $momoacg;
$client_access_settings = get_option( 'momo_acg_credit_system_settings' );
$enable_client_access = $momoacg->fn->momo_return_check_option( $client_access_settings, 'enable_client_access' );
$plans = ( isset( $client_access_settings['plans'] ) ? $client_access_settings['plans'] : array() );
$cs_sales_page = ( isset( $client_access_settings['cs_sales_page'] ) ? $client_access_settings['cs_sales_page'] : '' );
$pages_list = get_pages();
$is_premium = momoacg_fs()->is_premium();
if ( !$is_premium ) {
    $enable_client_access = 'off';
    $disabled = "disabled='disabled'";
}
?>
<div class="momo-be-main-tabcontent">
	<div id="momo-be-form">
		<div class="momo-be-wrapper">
			<h2 class="momo-be-settings-header">
				<?php 
esc_html_e( 'MoMo Themes - User Access / Plans', 'momoacg' );
?>
			</h2>
			<div class="momo-be-hr-line"></div>
			<div class="momo-admin-content-box" style="position:relative;">
				<div class="momo-be-working"></div>
				<div class="momo-ms-admin-content-main momoacg-client-access-main" id="momoacg-momo-acg-client-access-form">
					<div class="momo-be-msg-block"></div>
						<div class="momo-be-block-section">
							<h2 class="momo-be-block-section-header">
								<?php 
esc_html_e( 'Credit System', 'momoacg' );
?>
								<?php 
if ( !$is_premium ) {
    ?>
									<span class="momo-pro-label"><?php 
    esc_html_e( 'PRO', 'momoacgwc' );
    ?></span>
									<?php 
}
?>
							</h2>
							<div class="momo-be-block">
								<span class="momo-be-toggle-container" momo-be-tc-yes-container="enable_client_access_afteryes">
									<label class="switch">
										<input type="checkbox" class="switch-input" name="momo_acg_credit_system_settings[enable_client_access]" autocomplete="off" <?php 
echo esc_attr( $enable_client_access );
?> <?php 
echo esc_attr( $disabled );
?>>
										<span class="switch-label" data-on="Yes" data-off="No"></span>
										<span class="switch-handle"></span>
									</label>
								</span>
								<span class="momo-be-toggle-container-label">
									<?php 
esc_html_e( 'Enable Client Access', 'momoacg' );
?>
								</span>
							</div>
							<?php 
if ( $is_premium ) {
    ?>
								<?php 
    ?>
							<?php 
}
?>
						</div>
						<div class="momo-be-hr-line"></div>
						<div class="momo-be-block-section">
							<h2 class="momo-be-block-section-header">
								<?php 
esc_html_e( 'Frontend Generator:', 'momoacg' );
?>
								<?php 
if ( !$is_premium ) {
    ?>
									<span class="momo-pro-label"><?php 
    esc_html_e( 'PRO', 'momoacgwc' );
    ?></span>
									<?php 
}
?>
							</h2>
							<p>
								<?php 
esc_html_e( 'Add the shortcode in a page to enable content generator on the user-facing page.', 'momoacg' );
?>
							</p>
							<div class="momo-be-block">
								<p>
								[momo_add_content_generator]
								</p>
							</div>
						</div>
				</div>
			</div>
		</div>
	</div>
</div>

