<?php
/**
 * West CPA functions and definitions
 *
 * @link https://codex.wordpress.org/Functions_File_Explained
 *
 * @package West_CPA
 */

/**
 * Set the constants used throughout.
 */
define( 'PARENT_THEME_SLUG', 'west-cpa' );
define( 'PARENT_THEME_VERSION', '1.0.1' );

/**
 * Load Imagekit.
 */
require get_stylesheet_directory() . '/functions/imagekit.php';

/**
 * Load Themekit.
 */
require get_stylesheet_directory() . '/functions/themekit.php';

/**
 * Load menu walkers.
 */
require get_stylesheet_directory() . '/classes/class-menu-walker.php';

/**
 * Load Autoloader
 */
require get_stylesheet_directory() . '/classes/class-autoloader.php';


/**
 * Create an instance of each class and load the hooks function.
 */
$classes[] = 'Automattic';
$classes[] = 'Blocks';
$classes[] = 'Critical';
$classes[] = 'Customizer';
$classes[] = 'Employees';
$classes[] = 'Menukit';
$classes[] = 'Setup';
$classes[] = 'Slushicons';
$classes[] = 'Soliloquy';
$classes[] = 'Themehooks';
//$classes[] = 'Users';
$classes[] = 'Utilities';

foreach ( $classes as $class ) {

	$class_name 	= 'westcpa_' . $class;
	$class_obj 		= new $class_name();

	add_action( 'after_setup_theme', array( $class_obj, 'hooks' ) );

}



