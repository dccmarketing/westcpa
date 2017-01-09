<?php
/**
 * Jetpack Compatibility File.
 *
 * @link https://jetpack.com/
 * @since 			1.0.0
 * @package 		West_CPA
 * @subpackage 		West_CPA/classes
 */
class westcpa_Automattic {

	/**
	 * Constructor
	 */
	public function __construct() {} // __construct()

	/**
	 * Registers all the WordPress hooks and filters for this class.
	 */
	public function hooks () {

		add_action( 'after_setup_theme', array( $this, 'jetpack_setup' ) );
		add_action( 'after_setup_theme', array( $this, 'wpcom_setup' ) );

	} // hooks()

	/**
	 * Jetpack setup function.
	 *
	 * @see: https://jetpack.com/support/infinite-scroll/
	 * @see: https://jetpack.com/support/responsive-videos/
	 * @hooked 		after_setup_theme
	 */
	function jetpack_setup() {

		add_theme_support( 'infinite-scroll', array(
			'container' => 'main',
			'render'    => 'westcpa_infinite_scroll_render',
			'footer'    => 'page',
		) );

		add_theme_support( 'jetpack-responsive-videos' );

	} // jetpack_setup()

	/**
	 * Adds support for wp.com-specific theme functions.
	 *
	 * @hooked 		after_setup_theme
	 * @global array $themecolors
	 */
	function wpcom_setup() {

		global $themecolors;

		if ( isset( $themecolors ) ) { return; }

		$themecolors = array(
			'bg'     => '',
			'border' => '',
			'text'   => '',
			'link'   => '',
			'url'    => '',
		);

	} // wpcom_setup()

} // class

/**
 * Custom render function for Infinite Scroll.
 */
function westcpa_infinite_scroll_render() {

	while ( have_posts() ) {

		the_post();

		if ( is_search() ) {

			get_template_part( 'template-parts/content', 'search' );

		} else {

			get_template_part( 'template-parts/content', get_post_format() );

		}

	}

} // westcpa_infinite_scroll_render()
