<?php

/**
 * A class of helpful theme functions
 *
 * @package DocBlock
 * @author Slushman <chris@slushman.com>
 */
class function_names_Themekit {

	/**
	 * Constructor
	 */
	public function __construct() {

		// Nothing to see here...

	} // __construct()

	/**
	 * Returns an array of image info from the image URL
	 *
	 * @param 		string 		$name 				The name of the customizer image field
	 *
	 * @return 		array 							The image info array
	 */
	public function get_customizer_image_info( $name ) {

		if ( empty( $name ) ) { return FALSE; }

		$image_url = get_theme_mod( $name );

		if ( empty( $image_url ) ) { return FALSE; }

		$id = $this->get_image_id( $image_url );

		if ( empty( $id ) ) { return FALSE; }

		$info = wp_prepare_attachment_for_js( $id );

		return $info;

	} // get_customizer_image_info()

	/**
	 * Returns an array of the featured image details
	 *
	 * @param 	int 	$postID 		The post ID
	 *
	 * @return 	array 					Array of info about the featured image
	 */
	public function get_featured_images( $postID ) {

		if ( empty( $postID ) ) { return FALSE; }

		$imageID = get_post_thumbnail_id( $postID );

		if ( empty( $imageID ) ) { return FALSE; }

		return wp_prepare_attachment_for_js( $imageID );

	} // get_featured_images()

	/**
	 * Returns the attachment ID from the file URL
	 *
	 * @link 	https://pippinsplugins.com/retrieve-attachment-id-from-image-url/
	 *
	 * @param 	string 		$image_url 			The URL of the image
	 *
	 * @return 	int 							The image ID
	 */
	public function get_image_id( $image_url ) {

		if ( empty( $image_url ) ) { return FALSE; }

		global $wpdb;

		$attachment = $wpdb->get_col(
						$wpdb->prepare(
							"SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url
						)
					);

        return $attachment[0];

	} // get_image_id()

	/**
	 * Returns a post object of the requested post type
	 *
	 * @param 	string 		$post 			The name of the post type
	 * @param   array 		$params 		Optional parameters
	 *
	 * @return 	object 		A post object
	 */
	public function get_posts( $post, $params = array(), $cache = '' ) {

		if ( empty( $post ) ) { return -1; }

		$return = '';
		$cache_name = 'posts';

		if ( ! empty( $cache ) ) {

			$cache_name = '' . $cache . '_posts';

		}

		$return = wp_cache_get( $cache_name, 'posts' );

		if ( false === $return ) {

			$args['post_type'] 				= $post;
			$args['post_status'] 			= 'publish';
			$args['order_by'] 				= 'date';
			$args['posts_per_page'] 		= 50;
			$args['no_found_rows']			= true;
			$args['update_post_meta_cache'] = false;
			$args['update_post_term_cache'] = false;

			$args 	= wp_parse_args( $params, $args );
			$query 	= new WP_Query( $args );

			if ( ! is_wp_error( $query ) && $query->have_posts() ) {

				wp_cache_set( $cache_name, $query, 'posts', 5 * MINUTE_IN_SECONDS );

				$return = $query;

			}

		}

		return $return;

	} // get_posts()

	/**
	 * Returns the URL for the posts page
	 *
	 * @return 		string 						The URL for the posts page
	 */
	public function get_posts_page() {

		if( get_option( 'show_on_front' ) == 'page' ) {

			return get_permalink( get_option( 'page_for_posts' ) );

		} else  {

			return bloginfo( 'url' );

		}

	} // get_posts_page()

	/**
	 * Returns the requested SVG
	 *
	 * @param 	string 		$svg 		The name of the icon to return
	 * @param 	string 		$link 		URL to link from the SVG
	 *
	 * @return 	mixed 					The SVG code
	 */
	public function get_svg( $svg ) {

		if ( empty( $svg ) ) { return; }

		$list = $this->get_svg_list();

		return $list[$svg];

	} // get_svg()

	/**
	 * Returns an array of the SVGs used in this theme.
	 *
	 * @return 		array 		An array of SVGs
	 */
	public function get_svg_list() {

		$list['caret-down']			= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="caret-down"><path d="M15 8l-4.03 6L7 8h8z"/></svg>';
		$list['caret-left']			= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="caret-left"><path d="M13 14L7 9.97 13 6v8z"/></svg>';
		$list['caret-right']		= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="caret-right"><path d="M8 6l6 4.03L8 14V6z"/></svg>';
		$list['caret-up']			= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="caret-up"><path d="M7 13l4.03-6L15 13H7z"/></svg>';
		$list['cart']				= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="cart"><path d="M6 13h9q.41 0 .705.295T16 14t-.295.705T15 15H5q-.41 0-.705-.295T4 14V4H2q-.41 0-.705-.295T1 3t.295-.705T2 2h3q.41 0 .705.295T6 3v2h13l-4 7H6v1zm-.5 3q.62 0 1.06.44T7 17.5t-.44 1.06T5.5 19t-1.06-.44T4 17.5t.44-1.06T5.5 16zm9 0q.62 0 1.06.44T16 17.5t-.44 1.06-1.06.44-1.06-.44T13 17.5t.44-1.06T14.5 16z"/></svg>';
		$list['email']				= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="email"><path d="M19 14.5v-9q0-.62-.44-1.06T17.5 4H3.49q-.62 0-1.06.44T1.99 5.5v9q0 .62.44 1.06t1.06.44H17.5q.62 0 1.06-.44T19 14.5zm-1.31-9.11q.15.15.175.325t-.04.295-.165.22L13.6 9.95l3.9 4.06q.26.3.06.51-.09.11-.28.12t-.28-.07l-4.37-3.73-2.14 1.95-2.13-1.95-4.37 3.73q-.09.08-.28.07t-.28-.12q-.2-.21.06-.51l3.9-4.06-4.06-3.72q-.1-.1-.165-.22t-.04-.295.175-.325q.4-.4.95.07l6.24 5.04 6.25-5.04q.55-.47.95-.07z"/></svg>';
		$list['facebook']			= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="facebook"><path d="M8.46 18h2.93v-7.3h2.45l.37-2.84h-2.82V6.04q0-.69.295-1.035T12.8 4.66h1.51V2.11Q13.36 2 12.12 2q-1.67 0-2.665.985T8.46 5.76v2.1H6v2.84h2.46V18z"/></svg>';
		$list['facebooksquare']		= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="facebook-square"><path d="M2.89 2h14.23q.37 0 .625.255T18 2.88v14.24q0 .36-.255.62t-.625.26h-4.08v-6.2h2.08l.31-2.41h-2.39V7.85q0-.59.25-.885t.95-.295h1.28V4.51q-.66-.09-1.86-.09-1.42 0-2.265.835T10.55 7.61v1.78H8.46v2.41h2.09V18H2.89q-.37 0-.63-.26T2 17.12V2.88q0-.37.26-.625T2.89 2z"/></svg>';
		$list['fax']				= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="fax"><path d="M5 6.1v12c0 1-.8 1.8-1.8 1.8H1.9c-1 0-1.8-.8-1.8-1.8v-12c0-1 .8-1.8 1.8-1.8h1.4c.9 0 1.7.8 1.7 1.8zm14.9 2.5v8.5c0 1.6-1.3 2.8-2.8 2.8H7.5c-1 0-1.8-.8-1.8-1.8v-17C5.7.5 6.2 0 6.8 0h7.4c.6 0 1.4.3 1.8.8l1.7 1.7c.4.4.8 1.2.8 1.8v1.8c.8.5 1.4 1.4 1.4 2.5zm-2.8-4.3h-1.8c-.6 0-1.1-.5-1.1-1.1V1.5h-7v5.7h9.9V4.3zM10.4 10c0-.2-.2-.4-.4-.4H8.6c-.2 0-.4.2-.4.4v1.4c0 .2.2.4.4.4H10c.2 0 .4-.2.4-.4V10zm0 2.8c0-.2-.2-.4-.4-.4H8.6c-.2 0-.4.2-.4.4v1.4c0 .2.2.4.4.4H10c.2 0 .4-.2.4-.4v-1.4zm0 2.9c0-.2-.2-.4-.4-.4H8.6c-.2 0-.4.2-.4.4v1.4c0 .2.2.4.4.4H10c.2 0 .4-.2.4-.4v-1.4zm2.8-5.7c0-.2-.2-.4-.4-.4h-1.4c-.2 0-.4.2-.4.4v1.4c0 .2.2.4.4.4h1.4c.2 0 .4-.2.4-.4V10zm0 2.8c0-.2-.2-.4-.4-.4h-1.4c-.2 0-.4.2-.4.4v1.4c0 .2.2.4.4.4h1.4c.2 0 .4-.2.4-.4v-1.4zm0 2.9c0-.2-.2-.4-.4-.4h-1.4c-.2 0-.4.2-.4.4v1.4c0 .2.2.4.4.4h1.4c.2 0 .4-.2.4-.4v-1.4zM16 10c0-.2-.2-.4-.4-.4h-1.4c-.2 0-.4.2-.4.4v1.4c0 .2.2.4.4.4h1.4c.2 0 .4-.2.4-.4V10zm0 2.8c0-.2-.2-.4-.4-.4h-1.4c-.2 0-.4.2-.4.4v1.4c0 .2.2.4.4.4h1.4c.2 0 .4-.2.4-.4v-1.4zm0 2.9c0-.2-.2-.4-.4-.4h-1.4c-.2 0-.4.2-.4.4v1.4c0 .2.2.4.4.4h1.4c.2 0 .4-.2.4-.4v-1.4z"/></svg>';
		$list['flickr']				= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="flickr"><path d="M19.8 3.9v12.2c0 2-1.6 3.7-3.7 3.7H3.9c-2 0-3.7-1.6-3.7-3.7V3.9C.2 1.9 1.8.2 3.9.2h12.2c2.1 0 3.7 1.6 3.7 3.7zM6.4 7.3c-1.5 0-2.7 1.2-2.7 2.7s1.2 2.7 2.7 2.7c1.5 0 2.7-1.2 2.7-2.7S7.9 7.3 6.4 7.3zm7.2 0c-1.5 0-2.7 1.2-2.7 2.7s1.2 2.7 2.7 2.7c1.5 0 2.7-1.2 2.7-2.7s-1.2-2.7-2.7-2.7z"/></svg>';
		$list['gallery']			= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="gallery"><path d="M16 4h1.96q.43 0 .735.305T19 5.04v12.92q0 .43-.305.735T17.96 19H5.04q-.43 0-.735-.305T4 17.96V16H2.04q-.43 0-.735-.305T1 14.96V2.04q0-.43.305-.735T2.04 1h12.92q.43 0 .735.305T16 2.04V4zM3 14h11V3H3v11zm5-8.5q0-.62-.44-1.06T6.5 4t-1.06.44T5 5.5t.44 1.06T6.5 7t1.06-.44T8 5.5zm2 4.5q.02-.1.06-.28t.185-.7.305-.995.43-1.05.555-.99.67-.7T13 5v8H4V7q.56 0 .97.31t.6.75.3.88.12.75L6 10q.01-.04.025-.115t.08-.28.155-.395.255-.42.36-.395.49-.28T8 8q.47 0 .845.205t.58.5.345.59.19.505zm7 7V6h-1v8.96q0 .43-.305.735T14.96 16H6v1h11z"/></svg>';
		$list['github']				= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="github"><path d="M19.8 16.1c0 2-1.6 3.7-3.7 3.7h-2.9c-.4 0-.8 0-.8-.6v-3.1c0-.9-.3-1.5-.7-1.8 2.2-.2 4.5-1.1 4.5-4.8 0-1.1-.4-2-1-2.6.1-.3.4-1.3-.1-2.6-.8-.3-2.7 1-2.7 1-.7-.3-1.6-.4-2.4-.4s-1.7.1-2.5.4c0 0-1.9-1.3-2.7-1-.5 1.3-.2 2.3 0 2.6-.6.7-1 1.6-1 2.6 0 3.8 2.3 4.6 4.5 4.8-.3.3-.5.7-.6 1.3-.6.3-2 .7-2.8-.8-.5-.9-1.5-1-1.5-1-1 0-.1.6-.1.6.6.3 1.1 1.4 1.1 1.4.4 1.8 3.2 1.2 3.2 1.2v2.2c0 .6-.4.6-.8.6H3.9c-2 0-3.7-1.6-3.7-3.7V3.9C.2 1.9 1.8.2 3.9.2h12.3c2 0 3.7 1.6 3.7 3.7v12.2h-.1z"/></svg>';
		$list['googleplus']			= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="googleplus"><path d="M9.25 11.64q.88.62 1.23 1.28t.35 1.65q0 .62-.3 1.195t-.845 1.04-1.4.74-1.895.275q-1.26 0-2.31-.315t-1.685-.93-.635-1.405q0-1.28 1.3-2.265t3.14-.985q.14 0 .4-.005t.38-.005q-.61-.61-.61-1.26 0-.43.23-.86-.08.01-.22-.005t-.2-.015q-1.51 0-2.475-.97T2.74 6.43q0-.87.555-1.665t1.47-1.28T6.67 3h4.52l-1.01 1H8.74q.83.87 1.03 1.16.43.63.43 1.44 0 1.35-1.28 2.34-.53.42-.695.67t-.165.62q0 .28.395.705t.795.705zM6.83 9.37q.88.03 1.39-.76t.36-1.94q-.15-1.14-.87-1.95t-1.6-.84q-.88-.02-1.39.75t-.36 1.91q.15 1.15.875 1.98t1.595.85zM17 10v1h-2v2h-1v-2h-2v-1h2V8h1v2h2zM6.38 17.1q1.72 0 2.5-.635t.78-1.705q0-.22-.05-.47-.04-.16-.105-.295t-.18-.275-.205-.235-.28-.24-.295-.215-.365-.25-.38-.26q-.56-.18-1.12-.18-1.31-.02-2.3.685t-.99 1.665q0 1 .855 1.705t2.135.705z"/></svg>';
		$list['hamburger']			= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="hamburger"><path d="M17 7V5H3v2h14zm0 4V9H3v2h14zm0 4v-2H3v2h14z"/></svg>';
		$list['instagram']			= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="instagram"><path d="M19.9 17.3c0 1.4-1.1 2.5-2.5 2.5H2.7c-1.4 0-2.5-1.1-2.5-2.5V2.7C.2 1.3 1.3.2 2.7.2h14.7c1.4 0 2.5 1.1 2.5 2.5v14.6zm-2.3-8.8h-1.7c.2.5.3 1.1.3 1.7 0 3.3-2.7 5.9-6.1 5.9-3.4 0-6.1-2.7-6.1-5.9-.1-.6 0-1.2.1-1.7H2.3v8.3c0 .4.3.8.8.8h13.7c.4 0 .8-.3.8-.8V8.5zM10 6.1c-2.2 0-4 1.7-4 3.8 0 2.1 1.8 3.8 4 3.8s4-1.7 4-3.8c0-2.1-1.8-3.8-4-3.8zm7.6-2.9c0-.5-.4-.9-.9-.9h-2.2c-.5 0-.9.4-.9.9v2.1c0 .5.4.9.9.9h2.2c.5 0 .9-.4.9-.9V3.2z"/></svg>';
		$list['linkedin']			= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="linkedin"><path d="M2.5 5C1 5 .1 4 .1 2.8.1 1.6 1.1.6 2.5.6c1.5 0 2.4 1 2.4 2.2C4.9 4 4 5 2.5 5zm2.1 14.4H.4V6.7h4.2v12.7zm15.3 0h-4.2v-6.8c0-1.7-.6-2.9-2.1-2.9-1.2 0-1.9.8-2.2 1.5-.1.3-.1.7-.1 1v7.1H6.9c.1-11.4 0-12.6 0-12.6h4.2v1.9c.6-.9 1.6-2.1 3.8-2.1 2.8 0 4.9 1.8 4.9 5.7v7.2z"/></svg>';
		$list['linkedinsquare']		= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="linkedin-square"><path d="M19.9 16.2c0 2-1.7 3.7-3.7 3.7H3.8c-2 0-3.7-1.7-3.7-3.7V3.8C.1 1.8 1.8.1 3.8.1h12.3c2 0 3.7 1.7 3.7 3.7v12.4zM4.7 3.4C3.7 3.4 3 4.1 3 5c0 .8.6 1.5 1.6 1.5S6.3 5.8 6.3 5c0-.9-.6-1.6-1.6-1.6zm1.4 13.3v-9h-3v8.9h3zm10.7 0v-5.1c0-2.7-1.5-4-3.4-4-1.6 0-2.3.9-2.7 1.5V7.7h-3v8.9h3v-5c0-.3 0-.5.1-.7.2-.5.7-1.1 1.5-1.1 1.1 0 1.5.8 1.5 2v4.8h3z"/></svg>';
		$list['menu']				= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="menu"><path d="M17 7V5H3v2h14zm0 4V9H3v2h14zm0 4v-2H3v2h14z"/></svg>';
		$list['phone']				= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="phone"><path d="M12.06 6l-.21-.2q-.26-.27-.32-.47t.035-.38.365-.45l2.72-2.75q.11-.11.275-.285t.235-.245.19-.175.185-.12.17-.035.195.03.21.13.27.22l.21.2zm.53.45l4.4-4.4q.21.28.415.595t.47.78.45.95.31 1 .1 1.04-.215.975q-.33.76-.59 1.175t-.695.93-.715.895q-2.26 2.57-6 6.07-.41.29-.9.725t-.915.705-1.185.57q-.43.17-.95.18t-1.035-.125T4.53 18.2t-.97-.445-.8-.455-.62-.4l4.4-4.4 1.18 1.62q.16.23.485.165t.66-.285.655-.54l.925-.93 1.18-1.185 1.045-1.065.85-.89q.32-.32.535-.65t.29-.655-.165-.495zM1.57 16.5l-.21-.21q-.15-.16-.235-.28t-.095-.245-.01-.195.11-.21.17-.205.27-.265.31-.3l2.74-2.72q.41-.39.635-.425t.635.315l.2.21z"/></svg>';
		$list['pinterest']			= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="pinterest"><path d="M10.5.1c3.7 0 7.1 2.6 7.1 6.5 0 3.7-1.9 7.8-6.1 7.8-1 0-2.2-.5-2.7-1.4-.9 3.6-.8 4.1-2.8 6.8l-.2.1-.1-.1c-.1-.7-.2-1.5-.2-2.2 0-2.4 1.1-5.9 1.7-8.3-.3-.6-.4-1.3-.4-2 0-1.2.8-2.7 2.2-2.7 1 0 1.5.8 1.5 1.7 0 1.5-1 3-1 4.5 0 1 .8 1.7 1.8 1.7 2.7 0 3.6-3.9 3.6-6 0-2.8-2-4.3-4.7-4.3C7 2.1 4.6 4.3 4.6 7.5c0 1.5.9 2.3.9 2.7 0 .3-.2 1.4-.6 1.4h-.2C3 11 2.4 8.8 2.4 7.2c0-4.4 4-7.1 8.1-7.1z"/></svg>';
		$list['pinterestsquare']	= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="pinterest-square"><path d="M19.9 3.8v12.3c0 2-1.7 3.7-3.7 3.7H6.9c.4-.6 1.1-1.6 1.4-2.7 0 0 .1-.4.7-2.7.3.7 1.3 1.2 2.4 1.2 3.1 0 5.3-2.9 5.3-6.7 0-2.9-2.5-5.6-6.2-5.6-4.6 0-7 3.3-7 6.1 0 1.7.6 3.2 2 3.7.2.1.4 0 .5-.2 0-.2.1-.6.2-.8.1-.2 0-.3-.1-.5-.4-.5-.6-1.1-.6-1.9C5.5 7.2 7.4 5 10.3 5c2.6 0 4.1 1.6 4.1 3.7 0 2.8-1.2 5.2-3.1 5.2-1 0-1.8-.8-1.5-1.9.3-1.2.9-2.6.9-3.5 0-.8-.4-1.5-1.3-1.5-1 0-1.9 1.1-1.9 2.5 0 0 0 .9.3 1.6-1.1 4.5-1.3 5.3-1.3 5.3-.3 1.2-.2 2.6-.1 3.3H3.8C1.8 19.7.1 18 .1 16V3.8C.1 1.8 1.8.1 3.8.1h12.3c2.1 0 3.8 1.7 3.8 3.7z"/></svg>';
		$list['reddit']				= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="reddit"><path d="M19.9 9.8c0-1.3-1-2.3-2.3-2.3-.6 0-1.1.2-1.5.6-1.5-1-3.5-1.6-5.7-1.7l1.1-3.7 3.3.7c0 1 .8 1.9 1.9 1.9s1.9-.8 1.9-1.9-.8-1.9-1.9-1.9c-.8 0-1.4.5-1.7 1.1L11.5 2c-.2 0-.4.1-.4.2L9.8 6.4c-2.2 0-4.4.6-6 1.7-.4-.4-.9-.6-1.5-.6C1 7.5 0 8.5 0 9.8c0 .8.4 1.5 1.1 1.9 0 .2-.1.4-.1.6 0 1.6.9 3.1 2.7 4.3 1.7 1.1 3.9 1.7 6.2 1.7 2.4 0 4.6-.6 6.2-1.7 1.7-1.1 2.7-2.6 2.7-4.3 0-.2 0-.4-.1-.6.8-.4 1.2-1.1 1.2-1.9zm-3.1-7.5c.6 0 1.2.5 1.2 1.2 0 .6-.5 1.2-1.2 1.2-.6 0-1.2-.5-1.2-1.2 0-.6.6-1.2 1.2-1.2zM.8 9.8c0-.9.7-1.6 1.6-1.6.3 0 .6.1.9.3-1 .7-1.6 1.6-2 2.5-.3-.3-.5-.7-.5-1.2zm9.2 7.9c-4.5 0-8.2-2.4-8.2-5.3V12c0-.2.1-.5.1-.7.4-.8.9-1.6 1.8-2.3.2-.1.4-.3.6-.4 1.4-.9 3.5-1.5 5.7-1.5s4.3.6 5.7 1.5c.2.1.4.3.6.4.8.6 1.4 1.4 1.7 2.3.1.2.1.5.1.7v.4c.1 2.9-3.6 5.3-8.1 5.3zm8.7-6.7c-.3-.9-1-1.8-1.9-2.5.2-.2.6-.3.9-.3.9 0 1.6.7 1.6 1.6-.1.5-.3.9-.6 1.2z"/><path d="M12.7 14.7c-.7.6-1.5.8-2.7.8-1.2 0-2-.2-2.7-.8-.2-.1-.4-.1-.5.1-.1.2-.1.4.1.5.8.7 1.8 1 3.2 1s2.4-.3 3.2-1c.2-.1.2-.4.1-.5-.3-.2-.5-.3-.7-.1zM8.4 11.3c0-.7-.6-1.3-1.4-1.3-.7 0-1.3.6-1.3 1.3 0 .7.6 1.3 1.3 1.3.8.1 1.4-.5 1.4-1.3zM13 10c-.7 0-1.3.6-1.3 1.3 0 .7.6 1.3 1.3 1.3.7 0 1.3-.6 1.3-1.3.1-.7-.5-1.3-1.3-1.3z"/></svg>';
		$list['rss']				= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="rss"><path d="M14.92 18H18q0-2.14-.575-4.18t-1.61-3.765-2.51-3.18-3.23-2.475-3.83-1.585T2 2.25v3.02q2.1 0 4.07.645t3.56 1.82 2.785 2.74 1.85 3.51T14.92 18zm-5.44 0h3.08q0-2.11-.84-4.035t-2.255-3.32-3.37-2.22T2 7.6v3.02q1.5 0 2.86.56t2.43 1.6q1.06 1.04 1.625 2.39T9.48 18zm-5.35-.02q.88 0 1.505-.61t.625-1.48q0-.86-.625-1.475T4.13 13.8t-1.505.615T2 15.89q0 .87.62 1.48t1.51.61z"/></svg>';
		$list['search']				= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="search"><path d="M12.14 4.18q1.39 1.39 1.58 3.345t-.86 3.545q.03.03.155.14t.205.17q.34.27.81.59.62.43.66.47.61.45.94.78.49.49.84 1 .36.5.59 1.04.22.55.18 1-.03.48-.36.81t-.81.36q-.49.03-.99-.19-.52-.21-1.04-.59-.51-.35-1-.84-.33-.33-.77-.93-.02-.03-.47-.66-.32-.46-.56-.78-.24-.3-.44-.5-1.54.83-3.34.57t-3.1-1.55q-1.6-1.61-1.6-3.895t1.6-3.885q1.06-1.06 2.475-1.435t2.83 0T12.14 4.18zm-1.41 6.36q1.02-1.03 1.02-2.475T10.73 5.59Q9.7 4.56 8.25 4.56T5.78 5.59Q4.75 6.62 4.75 8.065t1.03 2.475q1.02 1.03 2.47 1.03t2.48-1.03z"/></svg>';
		$list['slack']				= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="slack"><path d="M19.9 11c0 .8-.4 1.3-1.1 1.5l-2 .7.7 2c.1.2.1.4.1.6 0 .9-.8 1.7-1.7 1.7-.7 0-1.4-.5-1.7-1.2l-.7-2-3.7 1.3.7 1.9c.1.2.1.4.1.6 0 .9-.8 1.7-1.7 1.7-.7 0-1.4-.5-1.6-1.2l-.7-1.9-1.8.6c-.2.1-.4.1-.6.1-1 0-1.7-.7-1.7-1.7 0-.7.5-1.4 1.2-1.6l1.9-.6-1.4-3.7-1.9.6c-.2.1-.4.1-.6.1-1 0-1.7-.7-1.7-1.7 0-.7.5-1.4 1.2-1.6l1.9-.6-.6-1.9c0-.1-.1-.3-.1-.5 0-.9.8-1.7 1.7-1.7.7 0 1.4.5 1.6 1.2l.6 1.9L10 4.4l-.5-2c-.1-.2-.1-.4-.1-.6 0-.9.8-1.7 1.7-1.7.7 0 1.4.5 1.7 1.2l.6 1.9 1.9-.7c.2 0 .3-.1.5-.1.9 0 1.7.7 1.7 1.6 0 .7-.6 1.4-1.2 1.6l-1.9.6 1.2 3.8 1.9-.7c.2-.1.4-.1.5-.1 1.1.1 1.9.8 1.9 1.8zm-7.5.2l-1.2-3.7-3.7 1.2 1.2 3.7 3.7-1.2z"/></svg>';
		$list['snapchat']			= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="snapchat"><path d="M15.7 8.3c.2-.1.5-.2.7-.2.3 0 .7 0 1 .1.5.3.5.9.1 1.2-.4.3-.8.4-1.2.6-1 .4-1.1.6-.6 1.5.8 1.5 1.9 2.6 3.6 3 .2.1.5.2.5.3 0 .2-.1.6-.3.7-.6.3-1.2.5-1.8.6-.4.1-.5.2-.6.6-.2.8-.3.9-1.1.7-1.2-.2-2.2 0-3.2.7-2 1.5-3.6 1.5-5.6 0-1-.7-2-.9-3.2-.7-.8.2-.9.1-1.1-.7-.1-.3-.2-.5-.6-.6-.6-.1-1.2-.3-1.7-.6-.2-.1-.4-.5-.4-.7 0-.1.3-.3.6-.4 1.8-.5 3-1.8 3.7-3.4.2-.4 0-.7-.3-.8-.3-.2-.6-.3-.9-.4l-.6-.3c-.4-.2-.7-.5-.5-1 .1-.3.7-.5 1.1-.3.3.1.5.2.8.2.3.1.5 0 .5-.5 0-1-.1-1.9 0-2.8.2-2 1.3-3.3 3.1-4 2.6-1 5.7-.2 7.1 2.3.5.9.6 1.8.6 2.8 0 .6-.1 1.2-.1 1.8-.1.3.1.4.4.3z"/></svg>';
		$list['tumblr']				= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="tumblr"><path d="M15.7 18.7c-.4.5-2 1.1-3.4 1.2-4.3.1-5.9-3.1-5.9-5.3V8.1h-2V5.6c3-1.1 3.7-3.8 3.9-5.3 0-.1.1-.1.1-.1h2.9v5h4v3h-4v6.1c0 .8.3 2 1.9 1.9.5 0 1.2-.2 1.6-.3l.9 2.8z"/></svg>';
		$list['twitter']			= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="twitter"><path d="M18.94 4.46q-.75 1.12-1.83 1.9.01.15.01.47 0 1.47-.43 2.945T15.38 12.6t-2.1 2.39-2.93 1.66-3.66.62q-3.04 0-5.63-1.65.48.05.88.05 2.55 0 4.55-1.57-1.19-.02-2.125-.73T3.07 11.55q.39.07.69.07.47 0 .96-.13-1.27-.26-2.105-1.27T1.78 7.89v-.04q.8.43 1.66.46-.75-.51-1.19-1.315T1.81 5.25q0-1 .5-1.84Q3.69 5.1 5.655 6.115T9.87 7.24q-.1-.45-.1-.84 0-1.51 1.075-2.585T13.44 2.74q1.6 0 2.68 1.16 1.26-.26 2.33-.89-.43 1.32-1.62 2.02 1.07-.11 2.11-.57z"/></svg>';
		$list['twittersquare']		= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="twitter-square"><path d="M19.9 16.2c0 2-1.7 3.7-3.7 3.7H3.8c-2 0-3.7-1.7-3.7-3.7V3.8C.1 1.8 1.8.1 3.8.1h12.4c2 0 3.7 1.7 3.7 3.7v12.4zM15 6.8c.6-.3 1-.9 1.2-1.5-.5.3-1.1.5-1.7.7-.5-.5-1.2-.8-2-.8-1.5 0-2.7 1.2-2.7 2.7 0 .2 0 .4.1.6-2.3-.2-4.3-1.3-5.6-3-.2.4-.4.9-.4 1.4 0 .9.4 1.8 1.2 2.3-.4 0-.9-.2-1.3-.4 0 1.3 1 2.4 2.2 2.7-.2.1-.4.1-.7.1-.2 0-.3 0-.5-.1.3 1.1 1.3 1.9 2.5 1.9-.9.7-2.1 1.2-3.4 1.2h-.6c1.2.8 2.6 1.2 4.1 1.2 5 0 7.7-4.1 7.7-7.7v-.3c.5-.4 1-.9 1.4-1.4-.4.1-.9.3-1.5.4z"/></svg>';
		$list['vimeosquare']		= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="vimeo-square"><path d="M19.9 16.2c0 2.1-1.7 3.7-3.7 3.7H3.8c-2.1 0-3.7-1.7-3.7-3.7V3.8C.1 1.8 1.8.1 3.8.1h12.4c2.1 0 3.7 1.7 3.7 3.7v12.4zM14.7 3.8c-2-.1-3.3 1.1-4 3.4.3-.2.7-.3 1-.3.7 0 1 .4 1 1.2 0 .5-.4 1.2-1 2.2-.6 1-1.1 1.4-1.4 1.4-.4 0-.7-.7-1.1-2.2 0-.4-.2-1.5-.5-3.2-.2-1.6-.9-2.4-2-2.3-.5 0-1.2.5-2.2 1.3-.6.6-1.3 1.2-2 1.8l.6.9c.6-.4 1-.7 1.1-.7.5 0 1 .8 1.4 2.3l1.2 4.2c.6 1.5 1.3 2.3 2.1 2.3 1.3 0 3-1.3 4.9-3.8 1.9-2.4 2.9-4.3 2.9-5.7.1-1.8-.6-2.7-2-2.8z"/></svg>';
		$list['vine']				= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="vine"><path d="M18.7 12.3c-.8.2-1.7.3-2.4.3-1.7 3.5-4.6 6.5-5.6 7-.7.4-1.3.4-2 0-1.2-.8-5.8-4.6-7.4-16.5h3.4c.8 7.2 2.9 10.9 5.2 13.6 1.3-1.3 2.5-2.9 3.4-4.8-2.3-1.2-3.6-3.7-3.6-6.6 0-3 1.7-5.2 4.6-5.2 2.8 0 4.4 1.8 4.4 4.8 0 1.1-.2 2.4-.7 3.4 0 0-2.1.4-2.9-.9.2-.5.4-1.4.4-2.2 0-1.4-.5-2.1-1.3-2.1s-1.4.8-1.4 2.3c0 3 1.9 4.8 4.4 4.8.4 0 .9 0 1.4-.2v2.3z"/></svg>';
		$list['wordpress']			= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="wordpress"><path d="M20 10q0-1.63-.505-3.155t-1.43-2.755-2.155-2.155-2.755-1.43T10 0 6.845.505 4.09 1.935 1.935 4.09.505 6.845 0 10t.505 3.155 1.43 2.755 2.155 2.155 2.755 1.43T10 20t3.155-.505 2.755-1.43 2.155-2.155 1.43-2.755T20 10zM10 1.01q1.83 0 3.495.71t2.87 1.915 1.915 2.87.71 3.495-.71 3.495-1.915 2.87-2.87 1.915-3.495.71-3.495-.71-2.87-1.915-1.915-2.87T1.01 10t.71-3.495 1.915-2.87 2.87-1.915T10 1.01zM8.01 14.82L4.96 6.61l1.05-.08q.2-.02.27-.275t-.025-.49-.305-.225q-1.29.1-2.13.1-.33 0-.52-.01Q4.4 3.97 6.17 3T10 2.03q1.54 0 2.935.55t2.475 1.54q-.52-.07-.985.305T13.96 5.54q0 .29.115.615t.225.525.37.61l.08.13q.5.87.5 2.21 0 .6-.315 1.72t-.635 1.94l-.32.82-2.71-7.5q.21-.01.4-.05t.27-.08l.08-.03q.2-.02.275-.295t-.025-.535-.3-.25q-1.3.11-2.14.11-.35 0-.875-.03L8.08 5.4l-.36-.03q-.2-.01-.3.255t-.025.54.275.285l.84.08 1.12 3.04zm6.02 2.15L16.64 10q.03-.07.07-.195t.15-.535.155-.82.08-1.05-.065-1.21q.94 1.7.94 3.81 0 2.19-1.065 4.05t-2.875 2.92zM2.68 6.77L6.5 17.25q-2.02-.99-3.245-2.945T2.03 10q0-1.79.65-3.23zm7.45 4.53l2.29 6.25q-1.17.42-2.42.42-1.03 0-2.06-.3z"/></svg>';
		$list['youtube']			= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="youtube"><path d="M17.9 18c-.2.9-.9 1.5-1.8 1.6-2 .2-4.1.2-6.1.2s-4.1 0-6.1-.2c-.9-.1-1.6-.7-1.8-1.6-.3-1.2-.3-2.6-.3-3.9 0-1.3 0-2.6.3-3.9.2-.7.9-1.4 1.8-1.5 2-.2 4.1-.2 6.1-.2s4.1 0 6.1.2c.8.1 1.6.7 1.8 1.6.3 1.2.3 2.6.3 3.9 0 1.3-.1 2.6-.3 3.8zM6.5 11.4v-1H3.1v1h1.2v6.3h1.1v-6.3h1.1zM8.3.1L7 4.5v3H5.9v-3c-.1-.5-.4-1.3-.7-2.3-.3-.7-.5-1.4-.7-2.1h1.2L6.4 3 7.1.1h1.2zm1.2 17.6v-5.4h-1v4.2c-.2.3-.4.5-.6.5-.1 0-.2-.1-.2-.2v-4.4h-1v4.3c0 .4 0 .6.1.8.1.3.3.4.6.4.4 0 .7-.2 1.1-.7v.6h1zm1.7-12c0 .6-.1 1-.3 1.3-.3.4-.7.6-1.2.6-.4 0-.8-.2-1.1-.6-.2-.3-.3-.7-.3-1.3V3.8c0-.6.1-1 .3-1.3.3-.4.7-.6 1.2-.6s.9.2 1.2.6c.2.3.3.7.3 1.3v1.9zm-1-2.1c0-.5-.1-.8-.5-.8-.3 0-.5.3-.5.8v2.3c0 .5.2.8.5.8s.5-.3.5-.8V3.6zm3 10.3c0-.5 0-.9-.1-1.1-.1-.4-.4-.6-.8-.6s-.7.2-1 .6v-2.4h-1v7.3h1v-.5c.3.4.7.6 1 .6.4 0 .7-.2.8-.6.1-.2.1-.6.1-1.1v-2.2zm-1 2.3c0 .5-.1.7-.4.7-.2 0-.3-.1-.5-.2v-3.3c.2-.2.3-.2.5-.2.3 0 .4.3.4.7v2.3zm2.7-8.7h-1v-.6c-.4.5-.8.7-1.1.7-.3 0-.6-.1-.6-.4-.1-.2-.1-.4-.1-.8V2h1v4.4c0 .2.1.2.2.2.2 0 .4-.2.6-.5V2h1v5.5zm2 8.3h-1v.7c-.1.3-.2.4-.4.4-.3 0-.5-.3-.5-.8v-1h2V14c0-.6-.1-1-.3-1.3-.3-.4-.7-.6-1.2-.6s-.9.2-1.2.6c-.2.3-.3.8-.3 1.3v1.9c0 .6.1 1 .3 1.3.3.4.7.6 1.2.6s.9-.2 1.2-.6c.1-.2.2-.4.2-.6v-.8zm-.9-1.4h-1v-.5c0-.5.2-.7.5-.7s.5.3.5.7v.5z"/></svg>';
		$list['youtubesquare']		= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="youtube-square"><path d="M19.9 16.2c0 2-1.7 3.7-3.7 3.7H3.8c-2 0-3.7-1.7-3.7-3.7V3.8C.1 1.8 1.8.1 3.8.1h12.4c2 0 3.7 1.7 3.7 3.7v12.4zm-3.1-6c-.2-.8-.8-1.3-1.5-1.4-1.8-.2-3.5-.2-5.3-.2-1.8 0-3.5 0-5.3.2-.7.1-1.4.6-1.5 1.4-.2 1.1-.3 2.2-.3 3.3 0 1.1 0 2.3.3 3.3.2.7.8 1.3 1.5 1.4 1.8.2 3.5.2 5.3.2s3.5 0 5.3-.2c.7-.1 1.4-.6 1.5-1.4.3-1.1.3-2.3.3-3.3 0-1.1 0-2.3-.3-3.3zm-9.8.9H6v5.4H5v-5.4H4v-.9h3v.9zm1.5-9.8h-1l-.6 2.5-.7-2.5h-1l.6 1.8c.3.9.5 1.6.6 2v2.6h1V5.1l1.1-3.8zm1 15.3h-.8v-.5c-.3.4-.7.6-1 .6-.3 0-.5-.1-.5-.4-.1-.1-.1-.4-.1-.7v-3.7h.8v3.8c0 .1.1.2.2.2.2 0 .3-.1.5-.4v-3.6h.9v4.7zm1.6-12.1c0-.5-.1-.9-.3-1.1-.2-.3-.6-.5-1-.5s-.8.2-1 .5c-.2.2-.3.6-.3 1.1v1.7c0 .5.1.9.3 1.1.2.3.6.5 1 .5s.8-.2 1-.5c.2-.2.3-.6.3-1.1V4.5zm-.9 1.9c0 .4-.1.7-.4.7-.3-.1-.4-.3-.4-.7v-2c0-.4.1-.7.4-.7.3 0 .4.2.4.7v2zm2.6 8.8c0 .4 0 .7-.1.9-.1.4-.3.5-.7.5-.3 0-.6-.2-.9-.5v.5h-.9v-6.3h.9v2.1c.3-.3.6-.5.9-.5.3 0 .6.2.7.5.1.2.1.5.1 1v1.8zm-.9-2c0-.4-.1-.6-.4-.6-.1 0-.3.1-.4.2v2.9c.1.1.3.2.4.2.2 0 .4-.2.4-.6v-2.1zm2.4-5.5V3h-.9v3.6c-.2.3-.4.4-.5.4-.1 0-.2-.1-.2-.2V3h-.9v3.8c0 .3 0 .6.1.7.1.2.3.3.6.3s.6-.2 1-.6v.5h.8zm1.7 7.4v.6c0 .2-.1.4-.2.5-.2.3-.6.5-1 .5-.5 0-.8-.2-1-.5-.2-.2-.3-.6-.3-1.1v-1.7c0-.5.1-.9.3-1.1.2-.3.6-.5 1-.5s.8.2 1 .5c.2.2.3.6.3 1.1v1h-1.7v.8c0 .4.1.7.4.7.2 0 .3-.1.4-.3V15h.8v.1zm-.8-1.4v-.4c0-.4-.1-.7-.4-.7s-.4.2-.4.7v.4h.8z"/></svg>';

		/**
		 * The function_names_svgs filter
		 */
		$list = apply_filters( 'function_names_svgs', $list );

		return $list;

	} // get_svg_list()

	/**
	 * Returns the URL of the featured image
	 *
	 * @param 	int 		$postID 		The post ID
	 * @param 	string 		$size 			The image size to return
	 *
	 * @return 	string | bool 				The URL of the featured image, otherwise FALSE
	 */
	public function get_thumbnail_url( $postID, $size = 'thumbnail' ) {

		if ( empty( $postID ) ) { return FALSE; }

		$thumb_id = get_post_thumbnail_id( $postID );

		if ( empty( $thumb_id ) ) { return FALSE; }

		$thumb_array = wp_get_attachment_image_src( $thumb_id, $size );

		if ( empty( $thumb_array ) ) { return FALSE; }

		return $thumb_array[0];

	} // get_thumbnail_url()

	/**
	 * Returns a Google Map link from an address
	 *
	 * @param 	string 		$address 		An address
	 *
	 * @return 	string 						URL for Google Maps
	 */
	public function make_map_link( $address ) {

		if( empty( $address ) ) { return FALSE; }

		$return = '';

		$query_args['q'] 	= urlencode( $address );
		$return 			= add_query_arg( $query_args, 'http://www.google.com/maps/' );

		return $return;

	} // make_map_link()

	/**
	 * Converts a phone number into a tel link
	 *
	 * @param 	string 		$number 			A phone number
	 *
	 * @return 	mixed 							Formatted HTML telephone link
	 */
	public function make_phone_link( $number ) {

		if ( empty( $number ) ) { return FALSE; }

		$return = '';

		$formatted 	= preg_replace( '/[^0-9]/', '', $number );

		$return .= '<span itemprop="telephone">';
		$return .= '<a href="tel:' . $formatted . '">';
		$return .= '<span class="screen-reader-text">';
		$return .= esc_html__( 'Call ', 'text-domain' ) . '</span>';
		$return .= $number . '</a>';
		$return .= '</span>';

		return $return;

	} // make_phone_link()

	/**
	 * Reduce the length of a string by character count
	 *
	 * @param 	string 		$text 		The string to reduce
	 * @param 	int 		$limit 		Max amount of characters to allow
	 * @param 	string 		$after 		Text for after the limit
	 *
	 * @return 	string 					The possibly reduced string
	 */
	public function shorten_text( $text, $limit = 100, $after = '...' ) {

		$length = strlen( $text );
		$text 	= substr( $text, 0, $limit );

		if ( $length > $limit ) {

			$text = $text . $after;

		} // Ellipsis

		return $text;

	} // shorten_text()

	/**
	 * Echos the requested SVG
	 *
	 * @param 	string 		$svg 		The name of the icon to return
	 *
	 * @return 	mixed 					The SVG code
	 */
	public function the_svg( $svg ) {

		echo $this->get_svg( $svg );

	} // the_svg()

	/**
	 * Returns an attachment by the filename
	 *
	 * @param 		string 			$post_name 				The post name
	 *
	 * @return 		object 									The attachment post object
	 */
	function wp_get_attachment_by_post_name( $post_name ) {

		if ( empty( $post_name ) ) { return 'Post name is empty'; }

		$args['name'] 			= trim ( $post_name );
		$args['post_per_page'] 	= 1;
		$args['post_status'] 	= 'any';

		$posts = $this->get_posts( 'attachment', $args, $post_name . '_attachments' );

		if ( $posts->posts[0] ) {

			return $posts->posts[0];

		}

		return FALSE;

	} // wp_get_attachment_by_post_name()

} // class

/**
 * Make an instance so its ready to be used
 */
$function_names_themekit = new function_names_Themekit();


