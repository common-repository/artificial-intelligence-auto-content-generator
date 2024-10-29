<?php
/**
 * MoMO ACG - Support Page
 *
 * @author MoMo Themes
 * @package momoacg
 * @since v2.2.0
 */

global $momoacg;
$image_url = $momoacg->plugin_url . '/assets/images/helpdesk.png';
?>
<div id="momo-be-form">
	<div class="momo-be-wrapper">
		<h2 class="momo-be-settings-header">
			<?php esc_html_e( 'MoMo Themes - HelpDesk', 'momoacg' ); ?>
		</h2>
		<div class="momo-be-hr-line"></div>
		<div class="momo-admin-content-box">
			<div class="momo-ms-admin-content-main momoacg-instructions-main" id="momoacg-momo-acg-instructions-form">
				<div class="momo-be-msg-block"></div>
				<div class="momo-be-block-section">
					<h2 class="momo-be-block-section-header"><?php esc_html_e( 'Helpdesk', 'momoacg' ); ?></h2>
					<p class="momo-be-support-para">
						<?php esc_html_e( 'For support, you can contact us on our helpdesk. Please open a ticket and one of our staffs will reply promptly. We work on weekdays only and tickets opened on weekdays will be assisted next week.', 'momoacg' ); ?>
					</p>
					<p class="momo-be-support-para">
						<?php esc_html_e( 'Thank you', 'momoacg' ); ?>
					</p>
					<center><img src="<?php echo esc_url( $image_url ); ?>" alt="helpdesk"></center>
					<p class="momo-be-support-para momo-support-link">
						<a href="<?php echo esc_url( 'http://helpdesk.momothemes.com/' ); ?>">
							<?php esc_html_e( 'Visit Helpdesk', 'momoacg' ); ?> | <?php esc_html_e( 'Get Support', 'momoacg' ); ?>
						</a>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
