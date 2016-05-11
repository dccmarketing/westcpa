<?php

/**
 * A class of methods using hooks in the theme.
 *
 * @package West_CPA
 * @author Slushman <chris@slushman.com>
 */
class westcpa_Soliloquy {

	/**
	 * Constructor
	 */
	public function __construct() {

		$this->loader();

	} // __construct()

	/**
	 * Loads all filter and action calls
	 */
	private function loader() {

		add_action( 'tha_content_before', array( $this, 'soliloquy_home' ), 10 );

	} // loader()

	/**
	 * Displays the "Home" Soliloquy slider on the front page.
	 *
	 * @hooked 		tha_content_while_before 		10
	 *
	 * @return 		mixed 							The Home Soliloquy slider
	 */
	public function soliloquy_home() {

		if ( ! is_front_page() ) { return; }
		if ( ! function_exists( 'soliloquy' ) ) { return; }

		soliloquy( 'home', 'slug' );

	} // soliloquy_home()

} // class

/**
 * Make an instance so its ready to be used
 */
$westcpa_soliloquy = new westcpa_Soliloquy();