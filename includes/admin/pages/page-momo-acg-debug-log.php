<?php
/**
 * MoMO ACG - Debugger
 *
 * @author MoMo Themes
 * @package momoacg
 * @since v3.2.0
 */

$max_execution_time = ini_get( 'max_execution_time' );
if ( false === $max_execution_time ) {
	$max_execution_time = 30;
}

$logger  = new MoMo_ACG_Logger( 'sync_rest' );
$logs    = $logger->momo_acg_logger_get_logs();
$content = '';
if ( ! empty( $logs ) ) {
	foreach ( $logs as $detail ) {
		$datetime = $detail['datetime'];
		$event    = $detail['event'];
		if ( 'bad' === $event['status'] ) {
			$_status = '<span class="bad">' . esc_html__( 'Bad', 'momoacg' ) . '</span>';
		} else {
			$_status = '<span class="good">' . esc_html__( 'Good', 'momoacg' ) . '</span>';
		}
		$content .= '<code>' . gmdate( 'd-m-Y H:s', $datetime ) . $_status . "\t" . '<span class="code">' . $event['code'] . '</span>' . "\t" . $event['message'] . '<span class="detail">' . $event['detail'] . '</span></code>';
	}
}
?>
<div id="momo-be-form">
	<div class="momo-be-wrapper">
		<h2 class="momo-be-settings-header">
			<?php esc_html_e( 'MoMo Themes - Debug Log', 'momoacg' ); ?>
		</h2>
		<div class="momo-be-hr-line"></div>
		<div class="momo-admin-content-box">
			<div class="momo-ms-admin-content-main momoacg-debug-log" id="momoacg-debug-log-form">
				<div class="momo-be-block-section">
					<h2 class="momo-be-block-section-header"><?php esc_html_e( 'Debug Log', 'momoacg' ); ?></h2>
					<div class="momo-be-msg-block"></div>
					<div class="momo-be-block">
						<div class="momo-be-textarea-style" id="momoacg_debug_logs_textarea">
							<?php echo wp_kses_post( $content ); ?>
						</div>
					</div>
					<p>
						<a href="#" class="button button-small button-secondary" id="mmtre_flush_debug_logs" data-type="sync_rest">
							<?php esc_html_e( 'Clear Logs', 'momoacg' ); ?>
						</a>
					</p>
					<div class="momo-be-hr-line"></div>
					<p>
						<span class="momo-be-note">
						<?php
						/* translators: %s: max_execution_time */
						printf( esc_html__( 'Note: The maximum execution time for PHP scripts is currently set to %s. If you are experiencing errors due to timeouts or recieving fsocket errors, you may need to increase this value in your PHP configuration file. Also, please chaeck \'Remote Timeout\' value in API settings.', 'momoacg' ), esc_html( $max_execution_time ) );
						?>
						</span>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
