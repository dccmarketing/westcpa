<?php
/**
 * The Blocks metabox functionality
 *
 * @link 		http://slushman.com
 * @since 		1.0.0
 *
 * @package West_CPA
 * @author Slushman <chris@slushman.com>
 */
class westcpa_Blocks {

	/**
	 * The post meta data
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$meta    			The post meta data.
	 */
	private $meta;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 		1.0.0
	 * @param 		string 			$Now_Hiring 		The name of this plugin.
	 * @param 		string 			$version 			The version of this plugin.
	 */
	public function __construct() {

		$this->loader();

	} // __construct()

	/**
	 * Loads all filter and action calls
	 */
	private function loader() {

		//

	} // loader()

	/**
	 * Registers metaboxes with WordPress
	 *
	 * @since 	1.0.0
	 * @access 	public
	 */
	public function add_metaboxes() {

		//remove_meta_box( 'postimagediv', 'employee', 'side' );

		// add_meta_box( $id, $title, $callback, $screen, $context, $priority, $callback_args );

		add_meta_box(
			'employees_location_info',
			apply_filters( $this->plugin_name . '-metabox-location-info-title', esc_html__( 'Home Blocks', 'westcpa' ) ),
			array( $this, 'metabox' ),
			'employee',
			'normal',
			'default',
			array(
				'file' => 'location-info'
			)
		);

		add_meta_box(
			'employees_contact_info',
			apply_filters( $this->plugin_name . '-metabox-contact-info-title', esc_html__( 'Contact Info', 'westcpa' ) ),
			array( $this, 'metabox' ),
			'employee',
			'normal',
			'default',
			array(
				'file' => 'contact-info'
			)
		);

		add_meta_box(
			'employees_display_order',
			apply_filters( $this->plugin_name . '-metabox-display-order-title', esc_html__( 'Display Order', 'westcpa' ) ),
			array( $this, 'metabox' ),
			'employee',
			'side',
			'low',
			array(
				'file' => 'display-order'
			)
		);

		add_meta_box(
			'employees_links',
			apply_filters( $this->plugin_name . '-metabox-links-title', esc_html__( 'Links', 'westcpa' ) ),
			array( $this, 'metabox' ),
			'employee',
			'side',
			'low',
			array(
				'file' => 'links'
			)
		);

	} // add_metaboxes()

	/**
	 * Check each nonce. If any don't verify, $nonce_check is increased.
	 * If all nonces verify, returns 0.
	 *
	 * @since 		1.0.0
	 * @access 		public
	 * @return 		int 		The value of $nonce_check
	 */
	private function check_nonces( $posted ) {

		$nonces 		= array();
		$nonce_check 	= 0;

		$nonces[] 	= 'nonce_employees_contact_info';

		foreach ( $nonces as $nonce ) {

			if ( ! isset( $posted[$nonce] ) ) { $nonce_check++; }
			if ( isset( $posted[$nonce] ) && ! wp_verify_nonce( $posted[$nonce], $this->plugin_name ) ) { $nonce_check++; }

		}

		return $nonce_check;

	} // check_nonces()

	/**
	 * Returns an array of the all the metabox fields and their respective types
	 *
	 * $fields[] 	= array( 'field-name', 'field-type', 'Field Label' );
	 *
	 * @since 		1.0.0
	 * @access 		public
	 * @return 		array 		Metabox fields and types
	 */
	public static function get_metabox_fields() {

		$fields = array();

		$fields[] 	= array( 'honorific-prefix', 'text', 'Prefix' );

		return $fields;

	} // get_metabox_fields()

	/**
	 * Calls a metabox file specified in the add_meta_box args.
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @return 	void
	 */
	public function metabox( $post, $params ) {

		if ( ! is_admin() ) { return; }
		if (  ) { return; }

		include( plugin_dir_path( __FILE__ ) . 'views/view-metabox-' . $params['args']['file'] . '.php' );

	} // metabox()

	/**
	 * Sets the class variable $options
	 */
	public function set_meta() {

		global $post;

		if ( empty( $post ) ) { return; }

		$this->meta = get_post_custom( $post->ID );

	} // set_meta()

	/**
	 * Saves metabox data
	 *
	 * @since 		1.0.0
	 * @access 		public
	 *
	 * @param 		int 		$post_id 		The post ID
	 * @param 		object 		$post 			The post object
	 */
	public function validate_meta( $post_id, $post ) {

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return $post_id; }
		if ( ! current_user_can( 'edit_post', $post_id ) ) { return $post_id; }
		if ( 'employee' != $post->post_type ) { return $post_id; }

		$nonce_check = $this->check_nonces( $_POST );

		if ( 0 < $nonce_check ) { return $post_id; }

		$metas = $this->get_metabox_fields();

		foreach ( $metas as $meta ) {

			$value 		= ( empty( $this->meta[$meta[0]][0] ) ? '' : $this->meta[$meta[0]][0] );
			$sanitizer 	= new Employees_Sanitize();

			$sanitizer->set_data( $_POST[$meta[0]] );
			$sanitizer->set_type( $meta[1] );

			$new_value = $sanitizer->clean();

			update_post_meta( $post_id, $meta[0], $new_value );

			unset( $sanitizer );

		} // foreach

	} // validate_meta()

} // class

$westcpa_blocks = new westcpa_Blocks();
