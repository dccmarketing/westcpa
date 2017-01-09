<?php

/**
 * Autoloader for PHP 5.3+
 *
 * @since 			1.0.0
 * @package 		West_CPA
 * @subpackage 		West_CPA/classes
 */
class westcpa_Autoloader {

	/**
	* Autoloader function
	*
	* @param 		string 			$class_name
	*/
	public static function autoloader( $class_name ) {

		if ( 0 !== strpos( $class_name, 'westcpa_' ) ) { return; }

		$class_name = str_replace( 'westcpa_', '', $class_name );
		$lower 		= strtolower( $class_name );
		$file      	= 'class-' . str_replace( '_', '-', $lower ) . '.php';
		$base_path 	= trailingslashit( get_stylesheet_directory() );
		$paths[] 	= $base_path . $file;
		$paths[] 	= $base_path . 'classes/' . $file;

		/**
		 * westcpa_autoloader_paths filter
		 */
		$paths = apply_filters( 'westcpa_autoloader_paths', $paths );

		foreach ( $paths as $path ) :

			if ( is_readable( $path ) && file_exists( $path ) ) {

				require_once( $path );
				return;

			}

		endforeach;

		return FALSE;

	} // autoloader()

} // class

spl_autoload_register( 'westcpa_Autoloader::autoloader' );
