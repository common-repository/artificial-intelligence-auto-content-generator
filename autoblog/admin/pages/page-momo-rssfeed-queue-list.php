<?php

/**
 * MoMO rssfeed - Queue List
 *
 * @author MoMo Themes
 * @package momoacg
 * @since v2.5.0
 */
global $momoacg;
if ( momoacg_fs()->is_premium() ) {
}
?>
<div class="momo-admin-content-box">
	<div class="momo-be-block-section">
		<h2 class="momo-be-block-section-header"><?php 
esc_html_e( 'RSS Feeds Current Queue', 'momoacg' );
?></h2>
		<div class="momo-be-block">
			<div class="momo-ms-admin-content-main momorssfeed-editor-main" id="momorssfeed-editor-main-form">
				<div class="momo-be-msg-block"></div>
				<?php 
if ( momoacg_fs()->is_premium() ) {
    echo wp_kses( $lists, $allowed );
} else {
    ?>
					<span class="momo-pro-label"><?php 
    esc_html_e( 'PRO', 'momoacg' );
    ?></span>
					<?php 
}
?>
			</div>
		</div>
	</div>
	<div class="momo-be-hr-line"></div>
	<div class="momo-be-block-section">
		<h2 class="momo-be-block-section-header"><?php 
esc_html_e( 'Auto Blogging Current Queue', 'momoacg' );
?></h2>
		<div class="momo-be-block">
			<div class="momo-ms-admin-content-main momoautoblog-editor-main" id="momoautoblog-editor-main-form">
				<div class="momo-be-msg-block"></div>
				<?php 
if ( momoacg_fs()->is_premium() ) {
    echo wp_kses( $autoblog, $allowed );
} else {
    ?>
					<span class="momo-pro-label"><?php 
    esc_html_e( 'PRO', 'momoacg' );
    ?></span>
					<?php 
}
?>
			</div>
		</div>
	</div>
</div>
