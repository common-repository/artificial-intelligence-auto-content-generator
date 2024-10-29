<?php
/**
 * MoMo ACG BulkCW - Amin AJAX functions
 *
 * @package momoacg
 * @author MoMo Themes
 * @since v2.5.0
 */
class MoMo_BulkCW_Admin_Ajax {
	/**
	 * Constructor
	 */
	public function __construct() {
		$ajax_events = array(
			'momo_acg_bulkcw_add_new_title_row'        => 'momo_acg_bulkcw_add_new_title_row', // One.
			'momo_acg_bulkcw_queue_titles_to_generate' => 'momo_acg_bulkcw_queue_titles_to_generate', // Two.
			'momo_acg_bulkcw_delete_cron_by_id'        => 'momo_acg_bulkcw_delete_cron_by_id', // Three.
		);
		foreach ( $ajax_events as $ajax_event => $class ) {
			add_action( 'wp_ajax_' . $ajax_event, array( $this, $class ) );
			add_action( 'wp_ajax_nopriv_' . $ajax_event, array( $this, $class ) );
		}
	}
	/**
	 * Generate New Title Row ( One )
	 */
	public function momo_acg_bulkcw_add_new_title_row() {
		global $momoacg;
		$res = check_ajax_referer( 'momoacg_security_key', 'security' );
		if ( isset( $_POST['action'] ) && 'momo_acg_bulkcw_add_new_title_row' !== $_POST['action'] ) {
			return;
		}
		$rowcount = isset( $_POST['rowcount'] ) ? sanitize_text_field( wp_unslash( $_POST['rowcount'] ) ) : '';
		if ( (int) $rowcount >= 15 ) {
			echo wp_json_encode(
				array(
					'status' => 'bad',
					'msg'    => esc_html__( 'Maximum number of titles exceeded ( 15 titles ).', 'momoacg' ),
				)
			);
			exit;
		}
		$content  = $momoacg->bulkcwfn->momo_generate_bulkcw_row();
		$rowcount = (int) $rowcount + 1;
		echo wp_json_encode(
			array(
				'status'  => 'good',
				'msg'     => esc_html__( 'Title row generated successfully.', 'momoacg' ),
				'content' => $content,
				'count'   => $rowcount,
			)
		);
		exit;
	}
	/**
	 * Add title to cron job ( Two )
	 */
	public function momo_acg_bulkcw_queue_titles_to_generate() {
		global $momoacg;
		$res = check_ajax_referer( 'momoacg_security_key', 'security' );
		if ( isset( $_POST['action'] ) && 'momo_acg_bulkcw_queue_titles_to_generate' !== $_POST['action'] ) {
			return;
		}
		$post_data = isset( $_POST['post_data'] ) ? wp_unslash( $_POST['post_data'] ) : array(); // phpcs:ignore Standard.Category.SniffName.ErrorCode Sanitization in next line
		$post_data = $this->momo_recursive_sanitize_text_field( $post_data );
		// Remove empty titles.
		$queue = array();
		foreach ( $post_data as $data ) {
			if ( ! empty( $data['title'] ) ) {
				$queue[] = $data;
			}
		}
		if ( empty( $queue ) ) {
			echo wp_json_encode(
				array(
					'status' => 'bad',
					'msg'    => esc_html__( 'All title field(s) are empty. Please enter some title in order to generate content.', 'momoacg' ),
				)
			);
			exit;
		}
		$index   = 1;
		$success = 0;
		$failure = 0;
		foreach ( $queue as $line ) {
			$line['index'] = $index;
			$return        = $momoacg->bulkcwcron->momo_add_item_to_queue( $line );
			if ( $return ) {
				$success++;
			} else {
				$failure++;
			}
			$index++;
		}
		if ( 0 === $failure ) {
			echo wp_json_encode(
				array(
					'status' => 'good',
					/* translators: %s: success number */
					'msg'    => sprintf( esc_html__( '%s title(s) are added to schedule.', 'momoacg' ), $success ),
				)
			);
			exit;
		} else {
			echo wp_json_encode(
				array(
					'status' => 'good',
					/* translators: %1$1s: success number, %2$2s: failure */
					'msg'    => sprintf( esc_html__( '%1$1s title(s) are added to schedule with %2$2s failed to add.', 'momoacg' ), $success, $failure ),
					'queue'  => $momoacg->bulkcwfn->momo_bulkcw_generate_queue_cron_list(),
				)
			);
			exit;
		}
	}
	/**
	 * Delete Cron by Cron ID.
	 */
	public function momo_acg_bulkcw_delete_cron_by_id() {
		global $momoacg;
		$res = check_ajax_referer( 'momoacg_security_key', 'security' );
		if ( isset( $_POST['action'] ) && 'momo_acg_bulkcw_delete_cron_by_id' !== $_POST['action'] ) {
			return;
		}
		$cron_id = isset( $_POST['cron_id'] ) ? sanitize_text_field( wp_unslash( $_POST['cron_id'] ) ) : '';

		$single = $momoacg->bulkcwfn->momo_get_bulkcw_single_event( $cron_id );
		if ( $single ) {
			wp_unschedule_event( $single['timestamp'], $single['hook'], $single['args'] );
			echo wp_json_encode(
				array(
					'status' => 'good',
					'msg'    => esc_html__( 'Cron event unscheduled successfully.', 'momoacg' ),
				)
			);
			exit;
		} else {
			echo wp_json_encode(
				array(
					'status' => 'bad',
					'msg'    => esc_html__( 'Cron event not found for given cron ID.', 'momoacg' ),
				)
			);
			exit;
		}
	}
	/**
	 * Recursive sanitation for an array
	 *
	 * @param array $array Post array data.
	 */
	public function momo_recursive_sanitize_text_field( $array ) {
		foreach ( $array as $key => &$value ) {
			if ( is_array( $value ) ) {
				$value = $this->momo_recursive_sanitize_text_field( $value );
			} else {
				$value = sanitize_text_field( $value );
			}
		}

		return $array;
	}
}
new MoMo_BulkCW_Admin_Ajax();
