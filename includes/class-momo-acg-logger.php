<?php
/**
 * Logging functions for MoMo ACG
 *
 * @package momoacg
 * @author MoMo Themes
 * @since v2.2.0
 */
class MoMo_ACG_Logger {
	/**
	 * Log Names
	 *
	 * @var array
	 */
	public $log_names;
	/**
	 * Type
	 *
	 * @var string
	 */
	public $type;
	/**
	 * Logs
	 *
	 * @var array
	 */
	public $log;
	/**
	 * Constructor
	 *
	 * @param string $type Log type name.
	 */
	public function __construct( $type = 'all' ) {
		$this->log_names = array(
			'sync_rest' => '_momo_acg_sync_rest_logs',
		);

		$this->type  = $type;
		$this->log   = array();
		$ajax_events = array(
			'momo_acg_flush_debug_logs' => 'momo_acg_flush_debug_logs',
		);
		foreach ( $ajax_events as $ajax_event => $class ) {
			add_action( 'wp_ajax_' . $ajax_event, array( $this, $class ) );
			add_action( 'wp_ajax_nopriv_' . $ajax_event, array( $this, $class ) );
		}
	}
	/**
	 * Set log type
	 *
	 * @param string $type Log type name.
	 */
	public function momo_acg_set_log_type( $type ) {
		$this->type = $type;
	}
	/**
	 * Set Current DateTime
	 */
	public function set_date_time() {
		$this->log['datetime'] = time();
	}
	/**
	 * Set event on current datetime
	 *
	 * @param string $event Event detail.
	 */
	public function set_event( $event ) {
		$this->set_date_time();
		$this->log['event'] = $event;
		$this->momo_acg_logger_save_logs( $this->log );
		$this->flush_log_event();
	}
	/**
	 * Flush Log Event
	 */
	public function flush_log_event() {
		$this->log = array();
	}

	/**
	 * Add remove logs
	 *
	 * @param string $logs_data Data.
	 */
	public function momo_acg_logger_save_logs( $logs_data ) {
		$logs = get_option( $this->log_names[ $this->type ] );

		$logs[] = $logs_data;

		update_option( $this->log_names[ $this->type ], $logs );
	}
	/**
	 * Get Logs
	 */
	public function momo_acg_logger_get_logs() {
		$logs = get_option( $this->log_names[ $this->type ] );

		if ( empty( $logs ) ) {
			return array();
		}
		return $logs;
	}
	/**
	 * Clear Logs
	 */
	public function momo_acg_flush_logs() {
		$logs = get_option( $this->log_names[ $this->type ] );

		if ( empty( $logs ) ) {
			return true;
		}

		$logs = array();

		delete_option( $this->log_names[ $this->type ] );
	}
	/**
	 * Delete Logs Ajax
	 */
	public function momo_acg_flush_debug_logs() {
		global $mmtre;
		$res = check_ajax_referer( 'momoacg_security_key', 'security' );
		if ( isset( $_POST['action'] ) && 'momo_acg_flush_debug_logs' !== $_POST['action'] ) {
			return;
		}
		$type   = isset( $_POST['type'] ) ? sanitize_text_field( wp_unslash( $_POST['type'] ) ) : '';
		$logger = new MoMo_ACG_Logger( $type );
		$logger->momo_acg_flush_logs();
		echo wp_json_encode(
			array(
				'status'  => 'good',
				'message' => esc_html__( 'Debug logs flushed successfully.', 'mmtre' ),
			)
		);
		exit;

	}
}
new MoMo_ACG_Logger();
