<?php
/**
 * Replace With Theme Name functions and definitions
 *
 * @link https://codex.wordpress.org/Functions_File_Explained
 *
 * @package DocBlock
 */

if ( ! function_exists( 'function_names_setup' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function function_names_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 */
		load_theme_textdomain( 'text-domain', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/*
		 * Enable support for Post Formats.
		 * See https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		/*add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
		) );*/

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'function_names_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		/**
		 * Enable Yoast Breadcrumb support
		 */
		add_theme_support( 'yoast-seo-breadcrumbs' );

		/**
		 * Register Menus
		 */
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary', 'text-domain' ),
			'social' => esc_html__( 'Social Links', 'text-domain' )
		) );

	} // function_names_setup()

endif; // function_names_setup

add_action( 'after_setup_theme', 'function_names_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global 		int 		$content_width
 */
function function_names_content_width() {

	$GLOBALS['content_width'] = apply_filters( 'function_names_content_width', 640 );

} // function_names_content_width()

add_action( 'after_setup_theme', 'function_names_content_width', 0 );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load Slushman Themekit
 */
require get_template_directory() . '/inc/themekit.php';

/**
 * Load Actions and Filters
 */
require get_template_directory() . '/inc/actions-and-filters.php';

/**
 * Load Themehooks
 */
require get_template_directory() . '/inc/themehooks.php';

/**
 * Load Slushman Menukit
 */
require get_template_directory() . '/inc/menukit.php';


