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
			<?php esc_html_e( 'MoMo Themes - RSS Feed', 'momoacg' ); ?>
		</h2>
		<div class="momo-be-hr-line"></div>
		<table class="momo-be-tab-table" width="100%">
			<tbody>
				<tr>
					<td valign="top" class="momo-be-tab-menu">
						<ul class="momo-be-main-tab momo-be-block-section">
							<li><a class="momo-be-tablinks active" href="#momo-be-rssfeed-editor"><i class='bx bx-rss' ></i><span><?php esc_html_e( 'RSS Feed Writer', 'momoacg' ); ?></span></a></li>
							<li><a class="momo-be-tablinks" href="#momo-be-rssfeed-queue-list"><i class='bx bxs-add-to-queue'></i><span><?php esc_html_e( 'Queue List', 'momoacg' ); ?></span></a></li>
						</ul>
					</td>
					<td width="2%"></td>
					<td class="momo-be-main-tabcontent" width="100%" valign="top">
						<div class="momo-be-working"></div>	
						<div id="momo-be-rssfeed-editor" class="momo-be-admin-content active">
							<?php require_once 'page-momo-rssfeed-editor.php'; ?>
						</div>
						<div id="momo-be-rssfeed-queue-list" class="momo-be-admin-content">
							<?php require_once 'page-momo-rssfeed-queue-list.php'; ?>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
