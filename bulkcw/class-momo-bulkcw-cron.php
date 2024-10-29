<?php
/**
 * Bulk Content Writer Cron
 *
 * @package momoacg
 * @author MoMo Themes
 * @since v2.5.0
 */
class MoMo_BulkCW_Cron {
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
			'single_content' => 'momo_acg_scw_hook',
		);
		add_action( 'momo_acg_scw_hook', array( $this, 'momo_acg_single_content_writer' ), 10, 4 );
	}
	/**
	 * Add each line to cron queue
	 *
	 * @param array $line Arguments.
	 */
	public function momo_add_item_to_queue( $line ) {
		$title    = $line['title'];
		$date     = $line['date'];
		$noofpara = $line['noofpara'];
		$index    = $line['index'];
		$ptype    = $line['ptype'];
		$addimage = isset( $line['addimage'] ) ? $line['addimage'] : 'off';
		$category = isset( $line['category'] ) ? $line['category'] : '';
		if ( empty( $noofpara ) ) {
			$noofpara = 4;
		}
		if ( empty( $date ) ) {
			$time = time() + ( 60 * 5 * (int) $index );
		} else {
			$time = strtotime( $date );
		}
		$args = array(
			'title'    => $title,
			'noofpara' => $noofpara,
			'other'    => array(),
			'time'     => $time,
			'ptype'    => $ptype,
			'addimage' => $addimage,
			'category' => $category,
		);
		return $this->momo_acg_schedule_single_content_writer( $args );
	}
	/**
	 * Schedule single content writer.
	 *
	 * @param array $args Arguments.
	 */
	public function momo_acg_schedule_single_content_writer( $args ) {
		$key      = md5( wp_json_encode( $args ) );
		$title    = isset( $args['title'] ) ? $args['title'] : '';
		$noofpara = isset( $args['noofpara'] ) ? $args['noofpara'] : '';
		$other    = isset( $args['other'] ) ? $args['other'] : array();
		$time     = isset( $args['time'] ) ? $args['time'] : time();
		$ptype    = isset( $args['ptype'] ) && ! empty( $args['ptype'] ) ? $args['ptype'] : 'momoacg_post_draft';

		$other['addimage'] = $args['addimage'];
		$other['category'] = $args['category'];

		$return = wp_schedule_single_event( $time, $this->cron_hook['single_content'], array( $title, $noofpara, $ptype, $other ) );
		if ( is_wp_error( $return ) ) {
			return false;
		}
		$this->momo_acg_update_single_event_list( $key, $args, 'add' );
		return true;
	}
	/**
	 * Fires single content writer
	 *
	 * @param string  $title Title.
	 * @param integer $noofpara No of Paragraphs.
	 * @param string  $ptype Post Type.
	 * @param array   $other Other.
	 */
	public function momo_acg_single_content_writer( $title, $noofpara, $ptype, $other ) {
		global $momoacg;
		$args     = array(
			'title'    => $title,
			'nopara'   => $noofpara,
			'language' => 'english',
		);
		$headings = $momoacg->api->momoacg_openai_generate_headings_array( $args );
		$output   = $momoacg->api->momo_acg_generate_content_from_headings( $headings, $args );

		$addimage = isset( $other['addimage'] ) ? $other['addimage'] : 'off';
		$category = isset( $other['category'] ) ? $other['category'] : '';

		if ( 'on' === $addimage ) {
			$image = $momoacg->api->momo_acg_generate_image_from_title( $title );
			if ( ! empty( $image ) ) {
				$output['content'] .= $image;
			}
		}
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
			$data = array(
				'post_title'   => $title,
				'post_content' => $output['content'],
				'post_status'  => $pstatus,
				'post_type'    => $posttype,
			);
			if ( 'wp_post_draft' === $ptype || 'wp_post_publish' === $ptype ) {
				if ( ! empty( $category ) ) {
					$data['post_category'] = array( (int) $category );
				}
			}
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
