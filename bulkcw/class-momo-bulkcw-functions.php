<?php
/**
 * MoMo Bulk CW Functions
 *
 * @package momoacg
 * @author MoMo Themes
 * @since v2.3.0
 */
class MoMo_Bulkcw_Functions {
	/**
	 * Constructor
	 */
	public function __construct() {
	}
	/**
	 * Generate title row.
	 */
	public function momo_generate_bulkcw_row() {
		ob_start();
		?>
		<tr>
			<td>
				<input name="momo_bulkcw_title_text" type="text" class="full-width" placeholder="<?php esc_attr_e( 'Write title here', 'momoacg' ); ?>"/>
			</td>
			<td class="momo-be-center" width="40px">
				<input type="text" name="momo_bulkcw_select_date" class="momo_jquery_date_selector full-width"/>
			</td>
			<td>
				<select name="momo_bulkcw_noofpara" class="momo_bulkcw_noofpara">
					<option value="1"><?php esc_html_e( '1', 'momoacg' ); ?></option>
					<option value="2"><?php esc_html_e( '2', 'momoacg' ); ?></option>
					<option value="3"><?php esc_html_e( '3', 'momoacg' ); ?></option>
					<option value="4" selected="selected"><?php esc_html_e( '4', 'momoacg' ); ?></option>
					<option value="5"><?php esc_html_e( '5', 'momoacg' ); ?></option>
					<option value="6"><?php esc_html_e( '6', 'momoacg' ); ?></option>
					<option value="7"><?php esc_html_e( '7', 'momoacg' ); ?></option>
					<option value="8"><?php esc_html_e( '8', 'momoacg' ); ?></option>
				</select>
			</td>
			<td>
				<select name="momo_bulkcw_category" class="full-width">
				<?php
				$categories = get_categories(
					array(
						'orderby'    => 'name',
						'order'      => 'ASC',
						'hide_empty' => false,
					)
				);

				foreach ( $categories as $category ) {
					?>
					<option value="<?php echo esc_attr( $category->term_id ); ?>"><?php echo esc_html( $category->name ); ?></option>
					<?php
				}
				?>
				</select>
			</td>
			<td>
				<span class="momo-be-toggle-container">
					<label class="switch">
						<input type="checkbox" class="switch-input" name="momo_bulkcw_enable_image" autocomplete="off">
						<span class="switch-label" data-on="Yes" data-off="No"></span>
						<span class="switch-handle"></span>
					</label>
				</span>
			</td>
		</tr>
		<?php
		$content = ob_get_clean();
		return $content;
	}
	/**
	 * Echo given row
	 */
	public function momo_echo_bulkcw_title_row() {
		$content = $this->momo_generate_bulkcw_row();
		$allowed = array(
			'tr'     => array(),
			'td'     => array(
				'class' => array(),
			),
			'input'  => array(
				'name'        => array(),
				'type'        => array(),
				'class'       => array(),
				'placeholder' => array(),
				'disabled'    => array(),
			),
			'select' => array(
				'name'     => array(),
				'class'    => array(),
				'disabled' => array(),
			),
			'option' => array(
				'value'    => array(),
				'selected' => array(),
			),
			'span'   => array(
				'class'    => array(),
				'data-on'  => array(),
				'data-off' => array(),
			),
			'label'  => array(
				'class' => array(),
			),
		);
		echo wp_kses( $content, $allowed );
	}
	/**
	 * Generate Cron queue Lists.
	 */
	public function momo_bulkcw_generate_queue_cron_list() {
		$lists = $this->momo_get_cron_events_list();
		ob_start();
		if ( empty( $lists ) ) {
			?>
			<div class="momo-bulkcw-empty-queue">
				<?php esc_html_e( 'Empty queue list.', 'momoacg' ); ?>
			</div>
			<?php
		} else {
			?>
			<table class="momo-bulkcw-queue-list-table">
				<thead>
					<tr>
						<th class="action"></th>
						<th><?php esc_html_e( 'ID', 'momoacg' ); ?></th>
						<th><?php esc_html_e( 'Title', 'momoacg' ); ?></th>
						<th><?php esc_html_e( 'Category', 'momoacg' ); ?></th>
						<th><?php esc_html_e( 'Scheduled Datetime', 'momoacg' ); ?></th>
					</tr>
				</thead>
				<tbody>
			<?php
			foreach ( $lists as $list ) {
				$cron_id = '';
				?>
				<tr>
				<?php
				$timestamp = $list['timestamp'];
				$datetime  = date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), $timestamp );
				foreach ( $list['content'] as $id => $content ) {
					$cron_id = $id;
					$title   = isset( $content['args'][0]['title'] ) ? $content['args'][0]['title'] : $content['args'][0];
					$cat_id  = isset( $content['args'][3]['category'] ) ? $content['args'][3]['category'] : '';

					$category_name = '';
					if ( ! empty( $cat_id ) ) {
						$category_name = get_cat_name( $cat_id );
					}
				}
				?>
					<td class="action" title="<?php esc_html_e( 'Remove', 'momoacg' ); ?>" data-id="<?php echo esc_html( $cron_id ); ?>">
						<span class="momo-remove-holder">
							<i class="bx bxs-trash momo-bulkcw-remove-cron"></i>
						</span>
					</td>
					<td><?php echo esc_html( $cron_id ); ?></td>
					<td><?php echo esc_html( $title ); ?></td>
					<td><?php echo esc_html( $category_name ); ?></td>
					<td><?php echo esc_html( $datetime ); ?></td>
				</tr>
				<?php
			}
			?>
				</tbody>
			</table>
			<?php
		}
		return ob_get_clean();
	}
	/**
	 * Get cron events list
	 */
	public function momo_get_cron_events_list() {
		$crons = _get_cron_array();
		$lists = array();
		foreach ( $crons as $timestamp => $cron ) {
			if ( isset( $cron['momo_acg_scw_hook'] ) || isset( $cron['momo_acg_create_page_hook'] ) ) {
				if ( isset( $cron['momo_acg_scw_hook'] ) ) {
					$lists[] = array(
						'timestamp' => $timestamp,
						'content'   => $cron['momo_acg_scw_hook'],
					);
				} elseif ( isset( $cron['momo_acg_create_page_hook'] ) ) {
					$lists[] = array(
						'timestamp' => $timestamp,
						'content'   => $cron['momo_acg_create_page_hook'],
					);
				}
			}
		}
		return $lists;
	}
	/**
	 * Get cron events list normal
	 */
	public function momo_get_cron_events_list_normal() {
		$crons = _get_cron_array();
		$lists = array();
		foreach ( $crons as $timestamp => $cron ) {
			foreach ( $cron as $event_hook => $event_args ) {
				foreach ( $event_args as $cron_id => $args ) {
					if ( 'momo_acg_scw_hook' === $event_hook || 'momo_acg_create_page_hook' === $event_hook ) {
						if ( 'momo_acg_scw_hook' === $event_hook ) {
							$args['hook']      = $event_hook;
							$args['timestamp'] = $timestamp;
							$lists[ $cron_id ] = $args;
						} elseif ( 'momo_acg_create_page_hook' === $event_hook ) {
							$args['hook']      = $event_hook;
							$args['timestamp'] = $timestamp;
							$lists[ $cron_id ] = $args;
						}
					}
				}
			}
		}
		return $lists;
	}
	/**
	 * Get single event by cron id.
	 *
	 * @param string $cron_id Cron ID.
	 */
	public function momo_get_bulkcw_single_event( $cron_id ) {
		$events = $this->momo_get_cron_events_list_normal();
		return isset( $events[ $cron_id ] ) ? $events[ $cron_id ] : false;
	}
}
