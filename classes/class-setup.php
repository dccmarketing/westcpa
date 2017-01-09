<?php

/**
 * Methods for setting up the West_CPA theme.
 *
 * @since 			1.0.0
 * @package 		West_CPA
 * @subpackage 		West_CPA/classes
 */
class westcpa_Setup {

	/**
	 * Constructor
	 *
	 * @since 		1.0.0
	 */
	public function __construct() {}

	/**
	 * Registers all the WordPress hooks and filters for this class.
	 */
	public function hooks() {

		add_action( 'init', 								array( $this, 'text_domain' ) );
		add_action( 'init', 								array( $this, 'theme_supports' ) );
		add_action( 'init', 								array( $this, 'register_menus' ) );
		add_action( 'init', 								array( $this, 'content_width' ), 0 );
		add_action( 'widgets_init', 						array( $this, 'widgets_init' ) );

		add_action( 'admin_enqueue_scripts', 				array( $this, 'enqueue_admin' ) );
		add_action( 'customize_preview_init', 				array( $this, 'enqueue_customizer_scripts' ) );
		add_action( 'customize_controls_enqueue_scripts', 	array( $this, 'enqueue_customizer_controls' ) );
		add_action( 'customize_controls_print_styles', 		array( $this, 'enqueue_customizer_styles' ) );
		add_action( 'login_enqueue_scripts',	 			array( $this, 'enqueue_login' ) );
		add_action( 'wp_enqueue_scripts', 					array( $this, 'enqueue_public' ) );

		add_action( 'wp_print_scripts', 					array( $this, 'print_scripts_header' ) );
		add_action( 'wp_print_footer_scripts', 				array( $this, 'print_scripts_footer' ) );

	} // hooks()

	/**
	 * Set the content width in pixels, based on the theme's design and stylesheet.
	 *
	 * Priority 0 to make it available to lower priority callbacks.
	 *
	 * @hooked 		after_setup_theme
	 * @global 		int 		$content_width
	 */
	public function content_width() {

		$GLOBALS['content_width'] = apply_filters( 'westcpa_content_width', 640 );

	} // content_width()

	/**
	 * Enqueues scripts and styles for the admin
	 *
	 * @hooked 		admin_enqueue_scripts
	 */
	public function enqueue_admin( $hook ) {

		wp_enqueue_style( 'wp-color-picker' );

		wp_enqueue_style( 'westcpa-admin', get_stylesheet_directory_uri() . '/admin.css' );

		wp_enqueue_style( 'datepicker', '//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css', array(), PARENT_THEME_VERSION, 'all' );

		wp_enqueue_style( 'timepicker', '//cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css', array(), PARENT_THEME_VERSION, 'all' );



		wp_enqueue_media();

		wp_enqueue_script( 'westcpa-admin', get_stylesheet_directory_uri() . '/assets/js/admin.min.js', array( 'jquery', 'media-upload', 'jquery-ui-datepicker', 'wp-color-picker', 'timepicker', 'jquery-ui-slider' ), PARENT_THEME_VERSION, true );

		wp_enqueue_script( 'timepicker', '//cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js', array( 'jquery', 'jquery-ui-datepicker', 'jquery-ui-slider' ), PARENT_THEME_VERSION, true );



		//if ( 'nav-menus.php' != $hook ) { return; } // Page-specific scripts & styles after this

	} // enqueue_admin()

	/**
	 * Used by customizer controls, mostly for active callbacks.
	 *
	 * @hooked		customize_controls_enqueue_scripts
	 * @access 		public
	 * @see 		add_action( 'customize_preview_init', $func )
	 * @since 		1.0.0
	 */
	public function enqueue_customizer_controls() {

		wp_enqueue_script( 'westcpa-customizer-controls', get_stylesheet_directory_uri() . '/assets/js/customizer-controls.min.js', array( 'jquery', 'customize-controls' ), PARENT_THEME_VERSION, true );

	} // enqueue_customizer_controls()

	/**
	 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
	 *
	 * @hooked 		customize_preview_init
	 */
	public function enqueue_customizer_scripts() {

		wp_enqueue_script( 'westcpa-customizer', get_stylesheet_directory_uri() . '/assets/js/customizer.min.js', array( 'jquery', 'customize-preview' ), PARENT_THEME_VERSION, true );

	} // enqueue_customizer_scripts()

	/**
	 * Loads custopmizer.css file for Customizer Previewer styling.
	 *
	 * @hooked 		customize_controls_print_styles
	 */
	public function enqueue_customizer_styles() {

		wp_enqueue_style( 'westcpa-customizer-style', get_stylesheet_directory_uri() . '/customizer.css', 10, 2 );

	} // enqueue_customizer_styles()

	/**
	 * Enqueues scripts and styles for the login page
	 *
	 * @hooked 		login_enqueue_scripts
	 */
	public function enqueue_login() {

		wp_enqueue_style( 'westcpa-login', get_stylesheet_directory_uri() . '/login.css', 10, 2 );
		wp_enqueue_script( 'enquire', '//cdnjs.cloudflare.com/ajax/libs/enquire.js/2.1.2/enquire.min.js', array(), '20150804', true );


	} // enqueue_login()

	/**
	 * Enqueue scripts and styles for the front end.
	 *
	 * @hooked 		wp_enqueue_scripts
	 */
	public function enqueue_public() {
		
		wp_scripts()->add_data( 'jquery', 'group', 1 );
		wp_scripts()->add_data( 'jquery-core', 'group', 1 );
		wp_scripts()->add_data( 'jquery-migrate', 'group', 1 );

		wp_enqueue_style( 'westcpa-style', get_stylesheet_uri() );

		wp_enqueue_script( 'enquire', '//cdnjs.cloudflare.com/ajax/libs/enquire.js/2.1.2/enquire.min.js', array(), PARENT_THEME_VERSION, true );

		wp_enqueue_script( 'westcpa-libs', get_stylesheet_directory_uri() . '/assets/js/lib.min.js', array(), PARENT_THEME_VERSION, true );

		wp_enqueue_script( 'westcpa-public', get_stylesheet_directory_uri() . '/assets/js/public.min.js', array( 'jquery', 'westcpa-libs' ), PARENT_THEME_VERSION, true );
		
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		
			wp_enqueue_script( 'comment-reply' );
		
		}
		
		wp_enqueue_style( 'westcpa-fonts', $this->fonts_url(), array(), null );

		wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css' );

		// wp_enqueue_style( 'westcpa-fonts', $this->fonts_url(), array(), null );

	} // enqueue_public()

	/**
	 * Properly encode a font URLs to enqueue a Google font
	 *
	 * @see 		enqueue_public()
	 * @return 		mixed 		A properly formatted, translated URL for a Google font
	 */
	public static function fonts_url() {

		$return 	= '';
		$families 	= '';
		$fonts[] 	= array( 'font' => 'Open Sans', 'weights' => '400,700', 'translate' => esc_html_x( 'on', 'Open Sans font: on or off', 'westcpa' ) );

		foreach ( $fonts as $font ) {

			if ( 'off' == $font['translate'] ) { continue; }

			$families[] = $font['font'] . ':' . $font['weights'];

		}

		if ( ! empty( $families ) ) {

			$query_args['family'] 	= urlencode( implode( '|', $families ) );
			$query_args['subset'] 	= urlencode( 'latin' );
			$return 				= add_query_arg( $query_args, '//fonts.googleapis.com/css' );

		}

		return $return;

	} // fonts_url()

	/**
	 * Prints scripts in the footer.
	 */
	public function print_scripts_footer() {

		//

	} // print_scripts_footer()

	/**
	 * Prints scripts in the header.
	 */
	public function print_scripts_header() {

		//

	} // print_scripts_header()

	/**
	 * Registers Menus
	 *
	 * @hooked 		after_setup_theme
	 */
	public function register_menus() {

		register_nav_menus( array(
			'primary' 		=> esc_html__( 'Primary', 'westcpa' ),
			'social' 		=> esc_html__( 'Social Links', 'westcpa' ),
			'legal' 		=> esc_html__( 'Legal', 'westcpa' )
		) );

	} // register_menus()

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /assets/languages/ directory.
	 *
	 * @hooked 		after_setup_theme
	 */
	public function text_domain() {

		load_theme_textdomain( 'westcpa', get_stylesheet_directory() . '/languages' );

	} // text_domain()

	/**
	 * Setup theme support options.
	 *
	 * @hooked 		after_setup_theme
	 */
	public function theme_supports() {

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
		 *
		 * @see 		https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		add_theme_support( 'post-formats', array(
			'aside',
			'audio',
			'chat',
			'gallery',
			'image',
			'link',
			'quote',
			'status',
			'video',
		) );

		/**
		 * Set up the WordPress core custom logo feature.
		 *
		 * Add an array to the decalaration below to add these features.
		 *
		 * @param  	int 	height 			Defined height
		 * @param 	int 	width 			Defined width
		 * @param  	bool 	flex-height 	True if the theme has additional space for the logo vertically.
		 * @param 	bool 	flex-width 		True if the theme has additional space for the logo horizontally.
		 */
		add_theme_support( 'custom-logo', array(
			'flex-width' => true
		) );
		
		/**
		 * Enable Yoast Breadcrumb support
		 */
		//add_theme_support( 'yoast-seo-breadcrumbs' );

	} // theme_supports()

	/**
	 * Register widget areas.
	 *
	 * @hooked 		widgets_init
	 * @link 		https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
	 */
	public function widgets_init() {

		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar', 'westcpa' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', '_s' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Footer Middle', 'westcpa' ),
			'id'            => 'footer-middle',
			'description'   => esc_html__( 'Add widgets here.', '_s' ),
			'before_widget' => '<section id="%1$s" class="block widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Footer Right', 'westcpa' ),
			'id'            => 'footer-right',
			'description'   => esc_html__( 'Add widgets here.', '_s' ),
			'before_widget' => '<section id="%1$s" class="block widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );


	} // widgets_init()

} // class
