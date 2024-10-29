<?php
/**
 * MoMo ACG - Admin Settings Page
 *
 * @author MoMo Themes
 * @package momoacg
 * @since v1.0
 */

?>
<div id="momo-be-form">
	<div class="momo-be-wrapper">
		<h2 class="momo-be-settings-header">
			<?php esc_html_e( 'MoMo Themes - Auto Content Generator', 'momoacg' ); ?>
		</h2>
		<div class="momo-be-hr-line"></div>
		<table class="momo-be-tab-table" width="100%">
			<tbody>
				<tr>
					<td valign="top" class="momo-be-tab-menu">
						<ul class="momo-be-main-tab momo-be-block-section">
							<li><a class="momo-be-tablinks active" href="#momo-be-settings-general"><i class='bx bx-cog'></i><span><?php esc_html_e( 'General', 'momoacg' ); ?></span></a></li>
							<li><a class="momo-be-tablinks" href="#momo-be-settings-openai"><i class='bx openai-icon-custom'></i><span><?php esc_html_e( 'API Settings', 'momoacg' ); ?></span></a></li>
							<?php do_action( 'momo_acg_admin_tab_li' ); ?>
						</ul>
					</td>
					<td width="2%"></td>
					<td class="momo-be-main-tabcontent" width="100%" valign="top">
						<div class="momo-be-working"></div>	
						<div id="momo-be-settings-general" class="momo-be-admin-content active">
							<form method="post" action="options.php" id="momo-momoacg-general-settings-form">
								<?php settings_fields( 'momoacg-settings-general-group' ); ?>
								<?php do_settings_sections( 'momoacg-settings-general-group' ); ?>
								<?php require_once 'page-momo-acg-general.php'; ?>
								<?php submit_button(); ?>
							</form>
						</div>
						<div id="momo-be-settings-openai" class="momo-be-admin-content">
							<form method="post" action="options.php" id="momo-momoacg-admin-settings-form">
								<?php settings_fields( 'momoacg-settings-openai-group' ); ?>
								<?php do_settings_sections( 'momoacg-settings-openai-group' ); ?>
								<?php require_once 'page-momo-acg-openai.php'; ?>
								<?php submit_button(); ?>
							</form>
						</div>
						<?php do_action( 'momo_acg_admin_tab_content' ); ?>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
