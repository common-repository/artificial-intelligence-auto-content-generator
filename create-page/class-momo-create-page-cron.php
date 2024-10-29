<?php
/**
 * Bulk Content Writer Cron
 *
 * @package momoacg
 * @author MoMo Themes
 * @since v2.5.0
 */
class MoMo_Create_Page_Cron {
	/**
	 * Cron Hook(s)
	 *
	 * @var array
	 */
	private $cron_hook;
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->cron_hook = array(
			'create_single_content' => 'momo_acg_create_page_hook',
		);
		add_action( 'momo_acg_create_page_hook', array( $this, 'momo_acg_single_content_writer' ), 10, 1 );
	}
	/**
	 * Schedule single content writer.
	 *
	 * @param array $args Arguments.
	 */
	public function momo_acg_schedule_create_page_single_content_writer( $args ) {
		$key  = md5( wp_json_encode( $args ) );
		$date = $args['date'];
		if ( empty( $date ) ) {
			$time = time() + ( 60 * 5 * (int) 1 );
		} else {
			$time = strtotime( $date );
		}
		$return = wp_schedule_single_event( $time, $this->cron_hook['create_single_content'], array( $args ) );
		if ( is_wp_error( $return ) ) {
			return false;
		}
		$this->momo_acg_update_single_event_list( $key, $args, 'add' );
		return true;
	}
	/**
	 * Fires single content writer
	 *
	 * @param array $args Args.
	 */
	public function momo_acg_single_content_writer( $args ) {
		global $momoacg;
		$ptype    = $args['ptype'];
		$title    = $args['title'];
		$headings = $momoacg->api->momoacg_openai_generate_headings_array( $args );
		$output   = $momoacg->api->momo_acg_generate_content_from_headings( $headings, $args );
		if ( isset( $output['content'] ) && ! empty( $output['content'] ) ) {
			$posttype = 'momoacg';
			$pstatus  = 'draft';
			switch ( $ptype ) {
				case 'momoacg_post_draft':
					$posttype = 'momoacg';
					$pstatus  = 'draft';
					break;
				case 'wp_post_draft':
					$posttype = 'post';
					$pstatus  = 'draft';
					break;
				case 'wp_post_publish':
					$posttype = 'post';
					$pstatus  = 'publish';
					break;
			}
			$data   = array(
				'post_title'   => $title,
				'post_content' => $output['content'],
				'post_status'  => $pstatus,
				'post_type'    => $posttype,
			);
			$return = wp_insert_post( $data );
		}
	}
	/**
	 * Update Single event list options
	 *
	 * @param string $key Key.
	 * @param array  $args Arguments.
	 * @param string $type Add or Delete.
	 */
	public function momo_acg_update_single_event_list( $key, $args, $type = 'add' ) {
		$single_event_list = get_option( 'momo_acg_scw_event_list' );
		if ( 'add' === $type ) {
			$single_event_list[ $key ] = $args;
			update_option( 'momo_acg_scw_event_list', $single_event_list );
		}
	}
}
