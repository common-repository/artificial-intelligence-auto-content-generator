<?php
/**
 * MoMo Frontend Content Generator Shortcodes
 *
 * @package momoacg
 * @author MoMo Themes
 * @since v3.9.0
 */
class MoMo_ACG_FE_CG_Shortcodes {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_shortcode( 'momo_add_content_generator', array( $this, 'momo_add_content_generator' ) );
	}
	/**
	 * Add Content Generator UI
	 *
	 * @param array $attributes Attributes.
	 */
	public function momo_add_content_generator( $attributes ) {
		global $momoacg;
		wp_enqueue_script( 'momoacgcs_fe_script' );
		wp_enqueue_script( 'momoacgcs_sync_fe' );
		return $momoacg->cgfe->momo_acg_cs_generate_content_generator( $attributes );
	}
}
new MoMo_ACG_FE_CG_Shortcodes();
