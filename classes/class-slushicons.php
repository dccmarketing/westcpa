<?php

/**
 * A class of methods for adding icons to menu items.
 *
 * @since 			1.0.0
 * @package 		West_CPA
 * @subpackage 		West_CPA/classes
 */
class westcpa_Slushicons {

	/**
	 * Constructor
	 */
	public function __construct() {}

	/**
	 * Registers all the WordPress hooks and filters for this class.
	 */
	public function hooks() {

		add_filter( 'nav_menu_item_title', 				array( $this, 'add_icons_to_menu' ), 10, 4 );
		add_filter( 'westcpa_menu_item_icon_name', 		array( $this, 'get_icon_info' ), 10, 3 );
		add_filter( 'westcpa_menu_item_text_position', 	array( $this, 'get_text_position' ), 10, 3 );
		add_filter( 'westcpa_change_svg', 					array( $this, 'change_default_svgs' ), 10, 1 );

	} // hooks()
	
	/**
	* Adds an icon in the menu item title, either with or without the title text.
	*
	* @exits 		If $args is empty or an array.
	* @exits 		If 'slushicons' is not in the classes array.
	* @hooked 		nav_menu_item_title 			10
	* @param 		string 		$title 				The menu item title.
	* @param 		object 		$item				The current menu item.
	* @param 		array 		$args 				The wp_nav_menu args.
	* @param 		int 		$depth 				The menu item depth.
	* @return 		string 							The modified menu item title.
	*/
	public function add_icons_to_menu( $title, $item, $args, $depth ) {

		if ( empty( $args ) || is_array( $args ) ) { return $title; }
		if ( ! in_array( 'slushicons', $item->classes ) ) { return $title; }

		$icon_name 	= apply_filters( 'westcpa_menu_item_icon_name', '', $item, $args );
		$icon 		= $this->get_icon( $icon_name );
		$textpos 	= apply_filters( 'westcpa_menu_item_text_position', '', $item, $args );

		if ( empty( $icon_name ) && empty( $textpos ) ) { return $title; }

		$output = '';

		if ( 'right' === $textpos ) {

			$output .= $icon;

		}

		if ( 'hide' === $textpos ) {

			$output .= '<span class="screen-reader-text">' . esc_html( $title ) . '</span>';
			$output .= $icon;

		} elseif ( 'coin' === $textpos ) {

			$output .= '<div class="front menu-icon">';
			$output .= $icon;
			$output .= '</div><div class="back menu-label"><span class="text">';
			$output .= esc_html( $title );
			$output .= '</span></div>';

		} else {

			$output .= '<span class="menu-label">' . esc_html( $title ) . '</span>';

		}

		if ( 'left' === $textpos ) {

			$output .= $icon;

		}

		return $output;

	} // add_icons_to_menu()
	
	/**
	 * Returns the proper name for certain requested svgs.
	 *  
	 * @param 		string 		$svg 		Name of the svg.
	 * @return 		string 					The correct name of the SVG.
	 */
	public function change_default_svgs( $svg ) {
		
		if ( empty( $svg ) ) { return $svg; }
		
		$shorts['caret-down'] 			= 'arrow-down-alt2';
		$shorts['caret-left'] 			= 'arrow-left-alt2';
		$shorts['caret-right'] 			= 'arrow-right-alt2';
		$shorts['caret-up'] 			= 'arrow-up-alt2';
		$shorts['email'] 				= 'email-alt';
		$shorts['facebook'] 			= 'facebook-alt';
		$shorts['facebook-square'] 		= 'facebook';
		$shorts['gallery'] 				= 'format-gallery';
		$shorts['hamburger'] 			= 'menu';
		$shorts['map'] 					= 'location-alt';
		$shorts['menu'] 				= 'menu-alt';
		
		if ( array_key_exists( $svg, $shorts ) ) {
			
			return $shorts[$svg];
			
		}
		
		return $svg;
		
	} // change_default_svgs()
	
	/**
	 * Returns the code for the icon.
	 *
	 * @exits 		If $icon is empty
	 * @exits 		if $icon is not an array.
	 * @hooked
	 * @param 		array 		$icon 			The icon info array.
	 * @return 		mixed 						The icon markup.
	 */
	private function get_icon( $icon ) {

		if ( empty( $icon ) || ! is_array( $icon ) ) { return; }

		$svg = westcpa_get_svg( $icon );

		if ( is_null( $svg ) ) { return FALSE; }

		return $svg;

	} // get_icon()

	/**
	 * Returns an array of info about the icon.
	 *
	 * @exits 		If $classes is empty.
	 * @hooked 		westcpa_menu_item_icon_name 		10
	 * @param 		string 		$icon 					The current icon name.
	 * @param 		object 		$item					The menu item object.
	 * @param 		array 		$args 					The menu arguments.
	 * @return 		array 								The type and name of the icon.
	 */
	public function get_icon_info( $icon, $item, $args  ) {

		if ( empty( $item->classes ) ) { return; }

		$return = array();
		$checks = array( 'dic-', 'fas-', 'svg-' );

		foreach ( $item->classes as $class ) {

			if ( stripos( $class, $checks[0] ) !== FALSE ) {

				$return = str_replace( $checks[0], '', $class );
				break;

			}

			if ( stripos( $class, $checks[1] ) !== FALSE ) {

				$return = str_replace( $checks[1], '', $class );
				break;

			}
			
			if ( stripos( $class, $checks[3] ) !== FALSE ) {

				$return = str_replace( $checks[2], '', $class );
				break;

			}

		} // foreach

		return $return;

	} // get_icon_info()
	
	/**
	 * Returns the text position from the menu item class.
	 *
	 * @exits 		If $classes is empty.
	 * @hooked 		westcpa_menu_item_text_position 		10
	 * @param 		string 		$position 					The current text position.
	 * @param 		object 		$item						The menu item object.
	 * @param 		array 		$args 						The menu arguments.
	 * @return 		string 									The text position.
	 */
	public function get_text_position( $position, $item, $args ) {

		if ( empty( $item->classes ) ) { return; }

		if ( in_array( 'no-text', $item->classes ) ) { return 'hide'; }
		if ( in_array( 'text-left', $item->classes ) ) { return 'left'; }
		if ( in_array( 'text-right', $item->classes ) ) { return 'right'; }
		if ( in_array( 'text-coin', $item->classes ) ) { return 'coin'; }
		if ( in_array( 'text-above', $item->classes ) ) { return 'above'; }
		if ( in_array( 'text-below', $item->classes ) ) { return 'below'; }

		return;

	} // get_text_position()

} // class