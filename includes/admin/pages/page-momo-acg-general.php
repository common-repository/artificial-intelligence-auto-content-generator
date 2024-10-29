<?php
/**
 * MoMO ACG - General Settings
 *
 * @author MoMo Themes
 * @package momoacg
 * @since v2.0.0
 */

global $momoacg;
$general_settings = get_option( 'momo_acg_general_settings' );

$wp_role = wp_roles();
$roles   = $wp_role->get_names();

$post_types = $momoacg->fn->momo_list_needed_post_types();
?>
<div class="momo-admin-content-box">
	<div class="momo-ms-admin-content-main momoacg-export-settings-main" id="momoacg-momo-wsw-export-settings-form">
		<div class="momo-be-msg-block"></div>
		<div class="momo-be-block-section">
			<h2 class="momo-be-block-section-header"><?php esc_html_e( 'Accessibility', 'momoacg' ); ?></h2>
			<p>
				<?php esc_html_e( 'Provide access of content generator to enabled user roles only', 'momoacg' ); ?>
			</p>
			<div class="momo-flex-row momo-mt-10">
				<?php foreach ( $roles as $role_id => $role_name ) : ?>
					<div class="momo-flex-column">
						<span class="momo-be-toggle-container">
							<label class="switch">
								<?php
								$name    = 'enable_for_role_' . $role_id;
								$name_id = 'momo_acg_general_settings[' . $name . ']';
								$value   = $momoacg->fn->momo_return_check_option( $general_settings, $name );
								?>
								<input type="checkbox" class="switch-input" name="<?php echo esc_attr( $name_id ); ?>" autocomplete="off" <?php echo esc_attr( $value ); ?> >
								<span class="switch-label" data-on="Yes" data-off="No"></span>
								<span class="switch-handle"></span>
							</label>
						</span>
						<span class="momo-be-toggle-container-label">
							<?php echo esc_html( $role_name ); ?>
						</span>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="momo-be-hr-line"></div>
		<div class="momo-be-block-section">
			<h2 class="momo-be-block-section-header"><?php esc_html_e( 'Enable for :', 'momoacg' ); ?></h2>
			<p>
				<?php esc_html_e( 'This will activate content generator for selected post type(s)', 'momoacg' ); ?>
			</p> 
			<div class="momo-flex-row momo-mt-10">
				<?php foreach ( $post_types as $post_type_id => $post_type_name ) : ?>
					<div class="momo-flex-column">
						<span class="momo-be-toggle-container">
							<label class="switch">
								<?php
								$name    = 'enable_for_post_type_' . $post_type_id;
								$name_id = 'momo_acg_general_settings[' . $name . ']';
								$value   = $momoacg->fn->momo_return_check_option( $general_settings, $name );
								?>
								<input type="checkbox" class="switch-input" name="<?php echo esc_attr( $name_id ); ?>" autocomplete="off" <?php echo esc_attr( $value ); ?> >
								<span class="switch-label" data-on="Yes" data-off="No"></span>
								<span class="switch-handle"></span>
							</label>
						</span>
						<span class="momo-be-toggle-container-label">
							<?php echo esc_html( $post_type_name ); ?>
						</span>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="momo-be-hr-line"></div>
		<div class="momo-be-block-section">
			<h2 class="momo-be-block-section-header"><?php esc_html_e( 'Activate:', 'momoacg' ); ?></h2>
			<p>
				<?php esc_html_e( 'This will activate product description generation for WooCommerce', 'momoacg' ); ?>
			</p> 
			<div class="momo-flex-row momo-mt-10">
				<div class="momo-flex-column">
					<span class="momo-be-toggle-container">
						<label class="switch">
							<?php
							$name    = 'enable_for_plugin_woocommerce';
							$name_id = 'momo_acg_general_settings[' . $name . ']';
							$value   = $momoacg->fn->momo_return_check_option( $general_settings, $name );
							?>
							<input type="checkbox" class="switch-input" name="<?php echo esc_attr( $name_id ); ?>" autocomplete="off" <?php echo esc_attr( $value ); ?> >
							<span class="switch-label" data-on="Yes" data-off="No"></span>
							<span class="switch-handle"></span>
						</label>
					</span>
					<span class="momo-be-toggle-container-label">
						<?php esc_html_e( 'WooCommerce', 'momoacg' ); ?>
					</span>
				</div>
			</div>
		</div>
		<div class="momo-be-hr-line"></div>
		<div class="momo-be-block-section">
			<h2 class="momo-be-block-section-header"><?php esc_html_e( 'Frontend Generator:', 'momoacg' ); ?></h2>
			<p>
				<?php esc_html_e( 'Add the shortcode in a page to enable content generator on the user-facing page.', 'momoacg' ); ?>
			</p>
			<div class="momo-be-block">
				<p>
				[momo_add_content_generator]
				</p>
			</div>
		</div>
	</div>
</div>
