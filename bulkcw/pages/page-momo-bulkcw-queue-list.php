<?php
/**
 * MoMO BulkCW - Queue List
 *
 * @author MoMo Themes
 * @package momoacg
 * @since v2.5.0
 */

global $momoacg;
$lists   = $momoacg->bulkcwfn->momo_bulkcw_generate_queue_cron_list();
$allowed = array(
	'tr'    => array(),
	'th'    => array(),
	'td'    => array(
		'class'   => array(),
		'title'   => array(),
		'data-id' => array(),
	),
	'table' => array(
		'class' => array(),
	),
	'div'   => array(
		'class' => array(),
	),
	'i'     => array(
		'class' => array(),
	),
	'span'  => array(
		'class' => array(),
	),
);
?>
<div class="momo-admin-content-box">
	<div class="momo-be-block-section">
		<h2 class="momo-be-block-section-header"><?php esc_html_e( 'Bulk Editor Current Queue', 'momoacg' ); ?></h2>
		<div class="momo-be-block">
			<div class="momo-ms-admin-content-main momobulkcw-editor-main" id="momobulkcw-editor-main-form">
				<div class="momo-be-msg-block"></div>
				<?php echo wp_kses( $lists, $allowed ); ?>
			</div>
		</div>
	</div>
</div>
