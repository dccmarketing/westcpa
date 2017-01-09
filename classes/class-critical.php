<?php

/**
 * Methods for creating and using critical CSS.
 *
 * @since 			1.0.0
 * @package 		West_CPA
 * @subpackage 		West_CPA/classes
 */
class westcpa_Critical {
	
	/**
	 * The stylesheets used in this theme.
	 * @var array
	 */
	var $stylesheets = array();
	
	/**
	 * The templates used in this theme.
	 * @var array
	 */
	var $templates = array();

	/**
	 * Constructor
	 *
	 * @since 		1.0.0
	 */
	public function __construct() {
		
		$this->set_templates();
		$this->set_stylesheets();

	} // __construct()

	/**
	 * Registers all the WordPress hooks and filters for this class.
	 */
	public function hooks() {
		
		add_action( 'wp_head', 				array( $this, 'print_critical' ) );
		add_action( 'wp_enqueue_scripts', 	array( $this, 'enqueue_scripts' ) );
		add_action( 'wp_head', 				array( $this, 'print_header_scripts' ) );
		//add_filter( 'style_loader_tag', 	array( $this, 'tweak_tag' ), 99, 4 );
		
	} // hooks()
	
	/**
	 * Enqueues the stylesheets, if there's already a cookie.
	 */
	public function enqueue_scripts() {
		
		if ( empty( $this->stylesheets ) ) { return; }
		if ( ! isset( $_COOKIE['csscached'] ) || $_COOKIE['csscached'] !== PARENT_THEME_VERSION ) { return; }
		
		foreach ( $this->stylesheets as $name => $stylesheet ) {
			
			if ( empty( $stylesheet ) ) { continue; }
			
			wp_enqueue_style( $name, $stylesheet );
			
		} // foreach
		
	} // enqueue_scripts()
	
	/**
	 * Prints the loadCSS script in the header, if the cookie is not set.
	 * 
	 * @return 		mixed 		The inline scripts.
	 */
	public function print_header_scripts() {
		
		if ( isset( $_COOKIE['csscached'] ) && $_COOKIE['csscached'] === PARENT_THEME_VERSION ) { return; }
		
		echo '<script type="text/javascript">';
		
		include trailingslashit( get_stylesheet_directory() ) . 'assets/js/loadcss.min.js';
				
		foreach ( $this->stylesheets as $name => $stylesheet ) {
			
			$newname = westcpa_camelcase( $name, '-' );
			
			echo 'var ' . $newname . ' = loadCSS(\'' . $stylesheet . '\');';
			
			echo 'onloadCSS( ' . $newname . ', function(){
				var expires = new Date(+new Date + (7 * 24 * 60 * 60 * 1000)).toUTCString();
				document.cookie = fullCSS=true; expires= + expires;
			});';
			
		}
		
		echo '</script><!-- loadcss -->';
		
		$days30 = time() + ( 30 * DAY_IN_SECONDS );
		
		echo '<script>document.cookie = "csscached=' . PARENT_THEME_VERSION . ';expires=' . $days30 . ';path=/;"</script><!-- cookie -->';
		echo '<noscript><link href="' . esc_url( $stylesheet ) . '" rel="stylesheet"></noscript>';
		
	} // print_header_scripts()
	
	/**
	 * Prints the critical CSS inline styles.
	 * 
	 * @return 		mixed 		Inline styles.
	 */
	public function print_critical() {
		
		if ( isset( $_COOKIE['csscached'] ) && $_COOKIE['csscached'] === PARENT_THEME_VERSION ) { return; }
		
		//$template = ''; // get the page template.

		//if ( empty( $template ) ) { return; }
	
		?><style type="text/css"><?php
		
			include trailingslashit( get_stylesheet_directory() ) . 'critical.css';
		
			//include trailingslashit( get_stylesheet_directory() ) . 'critical/critical/' . $template . '.min.css';
		
		?></style><?php
		
	} // print_critical()
	
	/**
	 * Sets the stylesheet class variable.
	 */
	public function set_stylesheets() {
		
		$this->stylesheets['westcpa-style'] = get_stylesheet_uri();
		
		/**
		 * The westcpa_async_stylesheets filter.
		 */
		$this->stylesheets = apply_filters( 'westcpa_async_stylesheets', $this->stylesheets );
		
	} // set_stylesheets()
	
	/**
	 * Sets the templates class variable.
	 */
	public function set_templates() {
		
		$this->templates[] = 'page';
		$this->templates[] = 'post';
		$this->templates[] = 'search';
		$this->templates[] = '404';
		$this->templates[] = 'content-sidebar';
		$this->templates[] = 'sidebar-content';
		$this->templates[] = 'blog';
		$this->templates[] = 'single';
		
		/**
		 * The westcpa_critical_css_templates filter.
		 */
		$this->templates = apply_filters( 'westcpa_critical_css_templates', $this->templates );
		
	} // set_templates()
	
	/**
	 * Alters the link tag for enqueued stylesheets.
	 * 
	 * @param  [type] $tag    [description]
	 * @param  [type] $handle [description]
	 * @param  [type] $href   [description]
	 * @param  [type] $media  [description]
	 * @return [type]         [description]
	 */
	public function tweak_tag( $tag, $handle, $href, $media ) {
		
		if ( 'westcpa-style' !== $handle ) { return $tag; }
		
		return "<link rel=\"preload\" id=\"$handle-css\" $title href=\"$href\" type=\"text/css\" media=\"media\" as=\"style\" onload=\"this.rel='stylesheet'\" />";
		
	} // tweak_tag()
	
} // class
