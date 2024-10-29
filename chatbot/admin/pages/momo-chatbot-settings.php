<?php
/**
 * MoMo ChatGPT - Chatbot Settings Page
 *
 * @author MoMo Themes
 * @package momochatgpt
 * @since v3.6.0
 */

?>
<div id="momo-be-form">
	<div class="momo-be-wrapper">
		<h2 class="momo-be-settings-header">
			<?php esc_html_e( 'MoMo Themes - ChatBot', 'momoacg' ); ?>
		</h2>
		<div class="momo-be-hr-line"></div>
		<table class="momo-be-tab-table" width="100%">
			<tbody>
				<tr>
					<td valign="top" class="momo-be-tab-menu">
						<ul class="momo-be-main-tab momo-be-block-section">
							<li><a class="momo-be-tablinks active" href="#momo-be-chatbot-dashboard"><i class='bx bxs-dashboard'></i><span><?php esc_html_e( 'Dashboard', 'momoacg' ); ?></span></a></li>
							<li><a class="momo-be-tablinks" href="#momo-be-chatbot-settings"><i class='bx bxs-cog' ></i><span><?php esc_html_e( 'Settings', 'momoacg' ); ?></span></a></li>
							<li><a class="momo-be-tablinks" href="#momo-be-chatbot-trainings"><i class='bx bx-bookmarks' ></i><span><?php esc_html_e( 'Trainings', 'momoacg' ); ?></span></a></li>
						</ul>
					</td>
					<td width="2%"></td>
					<td class="momo-be-main-tabcontent" width="100%" valign="top">
						<div class="momo-be-working"></div>	
						<div id="momo-be-chatbot-dashboard" class="momo-be-admin-content active">
							<?php require_once 'page-momo-acg-chatbot-dashboard.php'; ?>
						</div>
						<div id="momo-be-chatbot-settings" class="momo-be-admin-content">
							<form method="post" action="options.php" id="momo-momoacg-chatbot-settings-form">
								<?php settings_fields( 'momoacg-settings-chatbot-group' ); ?>
								<?php do_settings_sections( 'momoacg-settings-chatbot-group' ); ?>
								<?php require_once 'page-momo-acg-chatbot.php'; ?>
								<?php submit_button(); ?>
							</form>
						</div>
						<div id="momo-be-chatbot-trainings" class="momo-be-admin-content">
							<form method="post" action="options.php" id="momo-momoacg-admin-settings-form">
								<?php settings_fields( 'momoacg-settings-cb-trainings-group' ); ?>
								<?php do_settings_sections( 'momoacg-settings-cb-trainings-group' ); ?>
								<?php require_once 'page-momo-acg-chatbot-trainings.php'; ?>
								<?php submit_button(); ?>
							</form>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
