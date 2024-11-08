<?php
/**
 * MoMO ACG - Chatbot Dashboard
 *
 * @author MoMo Themes
 * @package momoacg
 * @since v3.6.0
 */

global $momoacg;
$cb_dashboard_contents = get_option( 'momo_acg_cb_dashboard_contents' );
$message               = empty( $cb_dashboard_contents ) ? esc_html__( 'No activity till now.', 'momoacg' ) : '';
?>
<div class="momo-admin-content-box">
	<div class="momo-ms-admin-content-main momoacg-chatbot-dashboard-main" id="momoacg-momo-acg-chatbot-dashboard-form">
		<div class="momo-be-msg-block <?php echo ! empty( $message ) ? 'show' : ''; ?>">
			<?php echo esc_html( $message ); ?>
		</div>
		<?php if ( ! empty( $cb_dashboard_contents ) ) : ?>
		<div class="momo-row momo-responsive">
			<div class="momo-col">
				<div class="momo-be-block-section momo-min-h-110">
					<?php
						$count = $momoacg->embeddings->momo_log_get_count( 'daily', 'replies' );
					?>
					<span class="momo-cb-db-count dr"><em><?php echo esc_html( $count ); ?></em></span>
					<span class="momo-cb-db-info"><em><?php esc_html_e( 'replies today', 'momoacg' ); ?></em></span>
				</div>
			</div>
			<div class="momo-col">
				<div class="momo-be-block-section momo-min-h-110">
					<?php
						$count = $momoacg->embeddings->momo_log_get_count( 'daily', 'session' );
					?>
					<span class="momo-cb-db-count ds"><em><?php echo esc_html( $count ); ?></em></span>
					<span class="momo-cb-db-info"><em><?php esc_html_e( 'sessions today', 'momoacg' ); ?></em></span>
				</div>
			</div>
		</div>
		<div class="momo-be-hr-line"></div>
		<div class="momo-row momo-responsive">
			<div class="momo-col">
				<div class="momo-be-block-section momo-min-h-110">
					<?php
						$count = $momoacg->embeddings->momo_log_get_count( 'monthly', 'replies' );
					?>
					<span class="momo-cb-db-count mr"><em><?php echo esc_html( $count ); ?></em></span>
					<span class="momo-cb-db-info"><em><?php esc_html_e( 'monthly replies', 'momoacg' ); ?></em></span>
				</div>
			</div>
			<div class="momo-col">
				<div class="momo-be-block-section momo-min-h-110">
					<?php
						$count = $momoacg->embeddings->momo_log_get_count( 'monthly', 'session' );
					?>
					<span class="momo-cb-db-count ms"><em><?php echo esc_html( $count ); ?></em></span>
					<span class="momo-cb-db-info"><em><?php esc_html_e( 'monthly sessions', 'momoacg' ); ?></em></span>
				</div>
			</div>
		</div>
		<?php endif; ?>
	</div>
</div>
