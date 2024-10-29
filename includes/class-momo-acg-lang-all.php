<?php
/**
 * MoMo Themes Basic functions
 *
 * @package momoacg
 * @author MoMo Themes
 * @since v1.0.0
 */
class MoMo_ACG_Lang_All {
	/**
	 * Lanugage List
	 *
	 * @var array
	 */
	public $langs;
	/**
	 * Writing Style
	 *
	 * @var srray
	 */
	public $writing_style;
	/**
	 * Writing Text
	 *
	 * @var array
	 */
	public $writing_text;
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->langs         = array(
			'english'          => esc_html__( 'English', 'momoacg' ),
			'dutch'            => esc_html__( 'Dutch', 'momoacg' ),
			'french'           => esc_html__( 'French', 'momoacg' ),
			'german'           => esc_html__( 'German', 'momoacg' ),
			'hindi'            => esc_html__( 'Hindi', 'momoacg' ),
			'indonesian'       => esc_html__( 'Indonesian', 'momoacg' ),
			'italian'          => esc_html__( 'Italian', 'momoacg' ),
			'japanese'         => esc_html__( 'Japanese', 'momoacg' ),
			'arabic'           => esc_html__( 'Arabic', 'momoacg' ),
			'chinese'          => esc_html__( 'Chinese', 'momoacg' ),
			'hongkong chinese' => esc_html__( 'Hongkong Chinese', 'momoacg' ),
			'korean'           => esc_html__( 'Korean', 'momoacg' ),
			'polish'           => esc_html__( 'Polish', 'momoacg' ),
			'portuguese'       => esc_html__( 'Portuguese', 'momoacg' ),
			'russian'          => esc_html__( 'Russian', 'momoacg' ),
			'spanish'          => esc_html__( 'Spanish', 'momoacg' ),
			'turkish'          => esc_html__( 'Turkish', 'momoacg' ),
			'ukranian'         => esc_html__( 'Ukranian', 'momoacg' ),
			'vietnamese'       => esc_html__( 'Vietnamese', 'momoacg' ),
			'bengali'          => esc_html__( 'Bengali', 'momoacg' ),
			'persian'          => esc_html__( 'Persian', 'momoacg' ),
			'malay'            => esc_html__( 'Malay', 'momoacg' ),
		);
		$this->writing_style = array(
			'simple'      => esc_html__( 'Simple', 'momoacg' ),
			'informative' => esc_html__( 'Informative', 'momoacg' ),
			'descriptive' => esc_html__( 'Descriptive', 'momoacg' ),
		);
		$this->writing_text  = array();
		foreach ( $this->writing_style as $style => $desc ) {
			$this->writing_text[ $style ] = array(
				'introduction' => $style . ' introduction about',
				'article'      => $style . ' article about',
				'conclusion'   => $style . ' conclusion about',
				'heading'      => $style . ' heading(s) about',
			);
		}
	}
	/**
	 * Get all Langugae
	 */
	public function momo_get_all_langs() {
		return $this->langs;
	}
	/**
	 * Get all Writing styles.
	 */
	public function momo_get_all_writing_style() {
		return $this->writing_style;
	}
	/**
	 * Get all Writing Text
	 *
	 * @param string $style Style.
	 */
	public function momo_get_all_writing_text( $style = 'informative' ) {
		return $this->writing_text[ $style ];
	}
}
