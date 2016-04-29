<?php

/**
 * Custom walker for adding a wrapper around submenus in the main menu
 */
class Main_Menu_Walker extends Walker_Nav_Menu {

	/**
	 * Adds a wrapper around submenus
	 *
	 * @see Walker_Nav_Menu::end_lvl()
	 *
	 * @param 	string 		$output 		Passed by reference. Used to append additional content.
	 * @param 	int 		$depth 			Depth of menu item. Used for padding.
	 * @param 	array 		$args 			An array of arguments. @see wp_nav_menu()
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {

		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent<div class=\"wrap-submenu\"><ul class=\"sub-menu\">\n";

	} // start_lvl()

	/**
	 * Adds the end of the submenu wrapper
	 *
	 * @see Walker_Nav_Menu::end_lvl()
	 *
	 * @param 	string 		$output 		Passed by reference. Used to append additional content.
	 * @param 	int 		$depth 			Depth of menu item. Used for padding.
	 * @param 	array 		$args 			An array of arguments. @see wp_nav_menu()
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {

		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul></div>\n";

	} // end_lvl()

} // class