<?php
/**
 * The metabox-specific functionality of the theme.
 *
 * @since 			1.0.0
 * @package 		West_CPA
 * @subpackage 		West_CPA/classes
 */
class westcpa_Metabox {

	/**
	 * Array of conditions where the metabox should appear.
	 *
	 * @since 		1.0.0
	 * @var 		array
	 */
	protected $conditions = array();

	/**
	 * Array of fields used in these metaboxes.
	 *
	 * @since 		1.0.0
	 *
	 * @var [type]
	 */
	protected $fields = array();

	/**
	 * The post meta data
	 *
	 * @since 		1.0.0
	 * @access 		protected
	 * @var 		string 			$meta    			The post meta data.
	 */
	protected $meta = array();

	/**
	 * The nonce for all the metabox.
	 *
	 * @since 		1.0.0
	 * @access 		protected
	 * @var 		string 			$nonce 			The nonces.
	 */
	protected $nonce = '';

	/**
	 * The metabox properties.
	 *
	 * @since 		1.0.0
	 * @access 		protected
	 * @var 		array 			$props 			The metabox properties.
	 */
	protected $props = '';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 		1.0.0
	 */
	public function __construct( $props, $nonce, $fields, $conditions = '' ) {

		$this->set_conditions( $conditions );
		$this->set_fields( $fields );
		$this->set_nonce( $nonce );
		$this->set_props( $props );

	} // __construct()

	/**
	 * Registers metaboxes with WordPress
	 *
	 * @hooked 		add_meta_boxes
	 * @since 	1.0.0
	 * @access 	public
	 * @param 		string 			$post_type		The post type.
	 * @param 		object 			$post_obj 		The post object.
	 */
	public function add_metaboxes( $post_type, $post_obj ) {

		if ( ! is_admin() ) { return; }
		if ( ! $this->check_conditions( $post_obj ) ) { return; }

		add_meta_box(
			$this->props['id'],
			apply_filters( PARENT_THEME_SLUG . '-' . $this->props['id'] . '-title', esc_html( $this->props['name'] ) ),
			array( $this, 'metabox' ),
			$this->props['screen'],
			$this->props['context'],
			$this->props['priority'],
			array(
				'file' => $this->props['file']
			)
		);

	} // add_metaboxes()

	/**
	 * Returns whether the conditions are met
	 *
	 * @exits 		If the class variable conditions is empty.
	 * @param 		obj 			$post_obj 		The post object
	 * @return 		bool 							Result of the checks.
	 */
	protected function check_conditions( $post_obj ) {

		if ( empty( $this->conditions ) || ! is_array( $this->conditions ) ) { return FALSE; }

		$conditioner = new westcpa_Conditions();

		foreach ( $this->conditions as $type => $condition ) {

			if ( empty( $condition ) ) { continue; }

			$check = $conditioner->check( $type, $condition, $post_obj );

			if ( ! $check ) { break; }

		}

		return $check;

	} // check_conditions()

	/**
	 * Returns the post type or the current screen's post type
	 *
	 * @return 		string 		The post type.
	 */
	protected function get_post_type() {

		if ( array_key_exists( 'post_type', $this->conditions ) ) { return $this->conditions['post_type']; }

		$screen = get_current_screen();

		return $screen->post_type;

	} // get_post_type()

	/**
	 * Calls a metabox file specified in the add_meta_box args
	 *
	 * @exits 		Not in the admin.
	 * @exits 		Not on the correct post type.
	 * @since 		1.0.0
	 * @access 		public
	 */
	public function metabox( $post_obj, $params ) {

		if ( ! is_admin() ) { return FALSE; }
		if ( ! $this->check_conditions( $post_obj ) ) { return FALSE; }

		include( get_stylesheet_directory() . '/template-parts/metaboxes/' . $params['args']['file'] . '.php' );

	} // metabox()

	/**
	 * Checks conditions before validating metabox submissions
	 *
	 * Returns FALSE under these conditions:
	 * 		Doing autosave.
	 * 		User doesn't have the capabilities.
	 * 		Not on the correct post type.
	 * 		Nonce isn't set.
	 * 		Nonce does't validate.
	 *
	 * @param 		object 		$posted 		The submitted data.
	 * @param 		int 		$post_id 		The post ID.
	 * @param 		object 		$post_obj 			The post object.
	 * @return 		bool 						FALSE if any conditions are met, otherwise TRUE.
	 */
	protected function pre_validation_checks( $posted, $post_id, $post_obj ) {

		if ( wp_is_post_autosave( $post_id ) ) { return FALSE; }
		if ( wp_is_post_revision( $post_id ) ) { return FALSE; }
		if ( ! $this->check_conditions( $post_obj ) ) { return FALSE; }
		if ( ! isset( $posted[$this->nonce] ) ) { return FALSE; }
		if ( isset( $posted[$this->nonce] ) && ! wp_verify_nonce( $posted[$this->nonce], PARENT_THEME_SLUG ) ) { return FALSE; }

		return TRUE;

	} // pre_validation_checks()

	/**
	 * Adds all metaboxes with the "top" context just under the title field
	 *
	 * @exits 		If not on the correct post type.
	 * @hooked 		edit_form_after_title
	 * @param `		object 		$post_obj 		The post object.`
	 */
	public function promote_metaboxes( $post_obj ) {

		if ( ! $this->check_conditions( $post_obj ) ) { return FALSE; }

		global $wp_meta_boxes;

		do_meta_boxes( get_current_screen(), 'top', $post_obj );

		$post_type = $this->get_post_type();

		unset( $wp_meta_boxes[$post_type]['top'] );

	} // promote_metaboxes()

	/**
	 * Sanitizes the metadata
	 *
	 * If $posted is an array:
	 * 		Loop through each posted field and sanitize the value.
	 * If not an array:
	 * 		Sanitize the value.
	 * Return the results.
	 *
	 * @link 		http://www.stillat.com/blog/2013/10/29/passing-data-to-php-anonymous-functions/
	 *
	 * @exits 		If $meta is empty.
	 * @exits 		If $posted is empty.
	 * @param 		array 		$meta 			The field info.
	 * @param 		mixed 		$posted 		Data posted by the form.
	 * @return 		mixed 						The sanitized data.
	 */
	protected function sanitize_meta( $meta, $posted ) {

		if ( empty( $meta ) ) { return FALSE; }
		if ( empty( $posted ) ) { return FALSE; }

		$sanitizer = new westcpa_Sanitize();

		if ( is_array( $meta[0] ) ) {

			foreach ( $meta as $field ) {

				$new_value[$field[0]] = $sanitizer->clean( $posted[$field[0]], $field[1] );

			}

		} else {

			$new_value = $sanitizer->clean( $posted, $meta[1] );

		}

		return $new_value;

	} // sanitize_meta()

	/**
	 * Returns the sanitized values from each repeated item
	 *
	 * Counts how many repeated items were submitted.
	 * Loops through each field in the repeated item and sanitizes the submitted data.
	 * Returns an array containing the sanitized data.
	 *
	 * @exits 		If $meta is empty or not an array.
	 * @exits 		If $posted is empty.
	 * @param 		array 		$meta 			The meta field array.
	 * @param 		array 		$posted 		The posted data.
	 * @return 		array 						The sanitized repeater data.
	 */
	protected function sanitize_repeater( $meta, $posted ) {

		if ( empty( $meta ) || ! is_array( $meta ) ) { return FALSE; }
		if ( empty( $posted ) ) { return FALSE; }

		$new_value 	= array();
		$meta[2][] 	= array( '_repeater_title', 'hidden', '' );
		$meta[2][] 	= array( '_repeater_uid', 'hidden', '' );

		foreach ( $posted as $id => $values ) {

			$new_value[$id] = $this->sanitize_meta( $meta[2], $posted[$id] );

		}

		return $new_value;

	} // sanitize_repeater()

	/**
	 * Saves metabox data
	 *
	 * Check the validation requirements.
	 * Loops through each field in the metabox.
	 * If the field is a repeater and the third array value is an array:
	 * 		Send field and posted data to sanitize_repeater().
	 * 		Save the result to $new_value.
	 * Otherwise:
	 * 		Send the form and posted data to sanitize_meta().
	 * 		Save the result to $new_value.
	 * Save $new_value to the appropriate meta key for the post.
	 * Unset $new_value.
	 *
	 * @exits 		If the pre-validation requirements return FALSE.
	 * @hooked 		save_post 		10
	 * @since 		1.0.0
	 * @access 		public
	 * @param 		int 			$post_id 		The post ID
	 * @param 		object 			$post_obj 			The post object
	 */
	public function save_meta( $post_id, $post_obj ) {

		//wp_die( print_r( $_POST ) );

		$validate = $this->pre_validation_checks( $_POST, $post_id, $post_obj );

		if ( ! $validate ) { return $post_id; }

		foreach ( $this->fields as $meta ) {

			if ( is_array( $meta[2] ) && 'repeater' === $meta[1] ) {

				$new_value = $this->sanitize_repeater( $meta, $_POST[$meta[0]] );

			} else {

				$new_value = $this->sanitize_meta( $meta, $_POST[$meta[0]] );

			}

			update_post_meta( $post_id, $meta[0], $new_value );

			unset( $new_value );

		} // foreach metabox field.

	} // save_meta()

	/**
	 * Sets the class variable $meta
	 *
	 * @exits 		Post is empty.
	 * @exits 		Not on the correct post type.
	 * @hooked 		add_meta_boxes
	 * @param 		string 			$post_type			The post type.
	 * @param 		object 			$post_obj 			The post object.
	 */
	public function set_meta( $post_type, $post_obj ) {

		if ( empty( $post_obj ) ) { return FALSE; }
		if ( ! $this->check_conditions( $post_obj ) ) { return FALSE; }

		$this->meta = get_post_custom( $post_obj->ID );

	} // set_meta()

	/**
	 * Sets the $conditions class variable
	 *
	 * @param 		array 		$conditions 		The conditions for this metabox.
	 */
	public function set_conditions( $conditions ) {

		$defaults['cap'] 		= 'edit_post';
		$defaults['post_type'] 	= 'page';
		$this->conditions 		= wp_parse_args( $conditions, $defaults );

	} // set_conditions()

	/**
	 * Sets the $fields class variable
	 *
	 * @param 		array 		$fields 		Array of field data.
	 */
	public function set_fields( $fields ) {

		$this->fields = $fields;

	} // set_fields()

	/**
	 * Sets the $nonce class variable
	 *
	 * @param 		string 		$nonce 		The nonce name for this metabox.
	 */
	public function set_nonce( $nonce ) {

		$this->nonce = $nonce;

	} // set_nonce()

	/**
	 * Sets the $props class variable
	 *
	 * All properties:
	 * 		screen 			Screen where the box is shown.				post type, link, comment, etc.
	 * 		context 		Where on the screen to show the box. 		normal, side, advanced
	 * 		priority 		Priority within the context. 				default, high, low
	 * 		id 				Unique ID for this box. 					Like a page slug.
	 * 		name 			Name for the box.							Text string.
	 * 		file 			The file for the view. 						Defaults to ID.
	 *
	 * @param 		array 		$props 		The metabox properties.
	 */
	public function set_props( $props ) {

		$defaults['context'] 	= 'normal';
		$defaults['id'] 		= '';
		$defaults['name'] 		= __( 'Metabox', 'westcpa' );
		$defaults['priority'] 	= 'default';
		$defaults['screen'] 	= 'page';
		$defaults['file'] 		= $defaults['id'];

		$this->props = wp_parse_args( $props, $defaults );

		if ( empty( $this->props['file'] ) ) {

			$this->props['file'] = $this->props['id'];

		}

	} // set_props()

} // class
