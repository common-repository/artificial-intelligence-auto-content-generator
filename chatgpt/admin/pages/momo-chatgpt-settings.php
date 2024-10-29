<?php
/**
 * MoMo ChatGPT - Admin Settings Page
 *
 * @author MoMo Themes
 * @package momochatgpt
 * @since v1.0.0
 */

?>
<div id="momo-be-form">
	<div class="momo-be-wrapper">
		<h2 class="momo-be-settings-header">
			<?php esc_html_e( 'MoMo Themes - ChatGPT', 'momoacg' ); ?>
		</h2>
		<div class="momo-be-hr-line"></div>
		<table class="momo-be-tab-table" width="100%">
			<tbody>
				<tr>
					<td valign="top" class="momo-be-tab-menu">
						<ul class="momo-be-main-tab momo-be-block-section">
							<li><a class="momo-be-tablinks active" href="#momo-be-instructions-openai"><i class='bx bx-notepad' ></i><span><?php esc_html_e( 'Instructions', 'momoacg' ); ?></span></a></li>
							<li><a class="momo-be-tablinks" href="#momo-be-settings-openai"><i class='bx openai-icon-custom'></i><span><?php esc_html_e( 'Settings', 'momoacg' ); ?></span></a></li>
						</ul>
					</td>
					<td width="2%"></td>
					<td class="momo-be-main-tabcontent" width="100%" valign="top">
						<div class="momo-be-working"></div>	
						<div id="momo-be-instructions-openai" class="momo-be-admin-content active">
							<?php require_once 'page-momo-chatgpt-openai-instructions.php'; ?>
						</div>
						<div id="momo-be-settings-openai" class="momo-be-admin-content">
							<form method="post" action="options.php" id="momo-momoacg-admin-settings-form">
								<?php settings_fields( 'momoacg-settings-chatgpt-group' ); ?>
								<?php do_settings_sections( 'momoacg-settings-chatgpt-group' ); ?>
								<?php require_once 'page-momo-chatgpt-openai.php'; ?>
								<?php submit_button(); ?>
							</form>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
