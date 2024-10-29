<?php
/**
 * MoMO ACG - Blocks Settings
 *
 * @author MoMo Themes
 * @package momoacg
 * @since v1.0.0
 */

global $momoacg;
$blocks_settings                  = get_option( 'momo_acg_blocks_settings' );
$enable_blocks_instead_of_metabox = $momoacg->fn->momo_return_check_option( $blocks_settings, 'enable_blocks_instead_of_metabox' );
?>
<div class="momo-admin-content-box">
	<div class="momo-be-table-header">
		<h3><?php esc_html_e( 'OpenAI ACG Instructions', 'momoacg' ); ?></h3>
	</div>
	<div class="momo-ms-admin-content-main momoacg-instructions-main" id="momoacg-momo-acg-instructions-form">
		<div class="momo-be-msg-block"></div>
		<div class="momo-be-block">
			<span class="momo-be-toggle-container">
				<label class="switch">
					<input type="checkbox" class="switch-input" name="momo_acg_blocks_settings[enable_blocks_instead_of_metabox]" autocomplete="off" <?php echo esc_attr( $enable_blocks_instead_of_metabox ); ?>>
					<span class="switch-label" data-on="Yes" data-off="No"></span>
					<span class="switch-handle"></span>
				</label>
			</span>
			<span class="momo-be-toggle-container-label">
				<?php esc_html_e( 'Enable blocks instead of metabox generator', 'momoacg' ); ?>
			</span>
		</div>
	</div>
</div>
