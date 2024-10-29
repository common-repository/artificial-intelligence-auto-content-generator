<?php
/**
 * MoMo Credit System Shortcodes
 *
 * @package momoacg
 * @author MoMo Themes
 * @since v3.0.0
 */
class MoMo_ACG_CS_Shortcodes {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_shortcode( 'momo_purchase_plan', array( $this, 'momo_purchase_plan' ) );
		add_shortcode( 'momo_cs_content_generator', array( $this, 'momo_add_content_generator' ) );
	}
	/**
	 * Add Purchase Plan UI
	 *
	 * @param array $attributes Attributes.
	 */
	public function momo_purchase_plan( $attributes ) {
		global $momoacg;
		wp_enqueue_script( 'momoacgcs_fe_script' );
		return $momoacg->csfe->momo_acg_cs_generate_purchase_plan( $attributes );
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
		return $momoacg->csfe->momo_acg_cs_generate_content_generator( $attributes );
	}
}
new MoMo_ACG_CS_Shortcodes();
