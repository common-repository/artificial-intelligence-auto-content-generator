<?php

/**
 * MoMo ACG - Autoblog Settings Page
 *
 * @author MoMo Themes
 * @package momoacg
 * @since v3.5.0
 */
global $momoacg;
?>
<div id="momo-be-form">
	<div class="momo-be-wrapper">
		<h2 class="momo-be-settings-header">
			<?php 
esc_html_e( 'MoMo Themes - Auto Blogging', 'momoacg' );
?>
		</h2>
		<div class="momo-be-hr-line"></div>
		<table class="momo-be-tab-table" width="100%">
			<tbody>
				<tr>
					<td valign="top" class="momo-be-tab-menu">
						<ul class="momo-be-main-tab momo-be-block-section">
							<li><a class="momo-be-tablinks active" href="#momo-be-auto-blog-settings"><i class='bx bx-timer'></i><span><?php 
esc_html_e( 'Auto Blogging', 'momoacg' );
?></span></a></li>
							<li><a class="momo-be-tablinks" href="#momo-be-rssfeed-editor"><i class='bx bx-rss' ></i><span><?php 
esc_html_e( 'RSS Feed Writer', 'momoacg' );
?></span></a></li>
							<li><a class="momo-be-tablinks" href="#momo-be-rssfeed-queue-list"><i class='bx bxs-add-to-queue'></i><span><?php 
esc_html_e( 'Queue List', 'momoacg' );
?></span></a></li>
						</ul>
					</td>
					<td width="2%"></td>
					<td class="momo-be-main-tabcontent" width="100%" valign="top">
						<div class="momo-be-working"></div>	
						<div id="momo-be-auto-blog-settings" class="momo-be-admin-content active">
							<?php 
if ( momoacg_fs()->is_premium() ) {
    ?>
									<?php 
    ?>
								<?php 
} else {
    $pagetitle = esc_html__( 'Auto Blogging', 'momowsw' );
    $line_two = esc_html__( 'Auto Blogging', 'momowsw' );
    require $momoacg->plugin_path . 'includes/admin/pages/page-momo-acg-upgrade.php';
}
?>
						</div>
						<div id="momo-be-rssfeed-editor" class="momo-be-admin-content">
							<?php 
if ( momoacg_fs()->is_premium() ) {
    ?>
									<?php 
    ?>
								<?php 
} else {
    $pagetitle = esc_html__( 'RSS Feed', 'momowsw' );
    $line_two = esc_html__( 'Generate blogs from RSS feed', 'momowsw' );
    require $momoacg->plugin_path . 'includes/admin/pages/page-momo-acg-upgrade.php';
}
?>
						</div>
						<div id="momo-be-rssfeed-queue-list" class="momo-be-admin-content">
							<?php 
require_once 'page-momo-rssfeed-queue-list.php';
?>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
