<?php
/**
 * Replace With Theme Name Customizer
 *
 * Contains methods for customizing the theme customization screen.
 *
 * @link 		https://codex.wordpress.org/Theme_Customization_API
 * @since 		1.0.0
 * @package  	DocBlock
 */

// Register panels, sections, and controls
add_action( 'customize_register', 'function_names_register_panels' );
add_action( 'customize_register', 'function_names_register_sections' );
add_action( 'customize_register', 'function_names_register_fields' );

// Output custom CSS to live site
add_action( 'wp_head', 'function_names_header_output' );

// Enqueue live preview javascript in Theme Customizer admin screen
add_action( 'customize_preview_init', 'function_names_live_preview' );

// Enqueue scripts for the customizer controls
add_action( 'customize_controls_enqueue_scripts', 'function_names_control_scripts' );

/**
 * Registers custom panels for the Customizer
 *
 * @see			add_action( 'customize_register', $func )
 * @link 		http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
 * @since 		1.0.0
 *
 * @param 		WP_Customize_Manager 		$wp_customize 		Theme Customizer object.
 */
function function_names_register_panels( $wp_customize ) {

	// Theme Options Panel
	$wp_customize->add_panel( 'theme_options',
		array(
			'capability'  		=> 'edit_theme_options',
			'description'  		=> esc_html__( 'Options for Replace With Theme Name', 'text-domain' ),
			'priority'  		=> 10,
			'theme_supports'  	=> '',
			'title'  			=> esc_html__( 'Theme Options', 'text-domain' ),
		)
	);

	/*
	// Theme Options Panel
	$wp_customize->add_panel( 'theme_options',
		array(
			'capability'  		=> 'edit_theme_options',
			'description'  		=> esc_html__( 'Options for Replace With Theme Name', 'text-domain' ),
			'priority'  		=> 10,
			'theme_supports'  	=> '',
			'title'  			=> esc_html__( 'Theme Options', 'text-domain' ),
		)
	);
	*/

} // function_names_register_panels()

/**
 * Registers custom sections for the Customizer
 *
 * Existing sections:
 *
 * Slug 				Priority 		Title
 *
 * title_tagline 		20 				Site Identity
 * colors 				40				Colors
 * header_image 		60				Header Image
 * background_image 	80				Background Image
 * nav 					100 			Navigation
 * widgets 				110 			Widgets
 * static_front_page 	120 			Static Front Page
 * default 				160 			all others
 *
 * @see			add_action( 'customize_register', $func )
 * @link 		http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
 * @since 		1.0.0
 *
 * @param 		WP_Customize_Manager 		$wp_customize 		Theme Customizer object.
 */
function function_names_register_sections( $wp_customize ) {



	/*
	// New Section
	$wp_customize->add_section( 'new_section',
		array(
			'capability' 	=> 'edit_theme_options',
			'description' 	=> esc_html__( 'New Customizer Section', 'text-domain' ),
			'panel' 		=> 'theme_options',
			'priority' 		=> 10,
			'title' 		=> esc_html__( 'New Section', 'text-domain' )
		)
	);
	*/

} // function_names_register_sections()

/**
 * Registers controls/fields for the Customizer
 *
 * Note: To enable instant preview, we have to actually write a bit of custom
 * javascript. See live_preview() for more.
 *
 * Note: To use active_callbacks, don't add these to the selecting control, it apepars these conflict:
 * 		'transport' => 'postMessage'
 * 		$wp_customize->get_setting( 'field_name' )->transport = 'postMessage';
 *
 * @see			add_action( 'customize_register', $func )
 * @link 		http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
 * @since 		1.0.0
 *
 * @param 		WP_Customize_Manager 		$wp_customize 		Theme Customizer object.
 */
function function_names_register_fields( $wp_customize ) {

	// Enable live preview JS for default fields
	$wp_customize->get_setting( 'blogname' )->transport 		= 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport 	= 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';



	// Site Identity Section Fields

	// Google Tag Manager Field
	$wp_customize->add_setting(
		'tag_manager',
		array(
			'default'  	=> '',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'tag_manager',
		array(
			'description' 	=> esc_html__( 'Paste in the Google Tag Manager code here. Do not include the comment tags!', 'text-domain' ),
			'label' => esc_html__( 'Google Tag Manager', 'text-domain' ),
			'priority' => 90,
			'section' => 'title_tagline',
			'settings' => 'tag_manager',
			'type' => 'textarea'
		)
	);
	$wp_customize->get_setting( 'tag_manager' )->transport = 'postMessage';




	/*
	// Fields & Controls

	// Text Field
	$wp_customize->add_setting(
		'text_field',
		array(
			'default'  			=> '',
			'sanitize_callback' => 'sanitize_text_field',
			'transport' 		=> 'postMessage'
		)
	);
	$wp_customize->add_control(
		'text_field',
		array(
			'description' 	=> esc_html__( '', 'text-domain' ),
			'label'  	=> esc_html__( 'Text Field', 'text-domain' ),
			'priority' => 10,
			'section'  	=> 'new_section',
			'settings' 	=> 'text_field',
			'type' 		=> 'text'
		)
	);
	$wp_customize->get_setting( 'text_field' )->transport = 'postMessage';



	// URL Field
	$wp_customize->add_setting(
		'url_field',
		array(
			'default'  			=> '',
			'sanitize_callback' => 'esc_url_raw'
			'transport' 		=> 'postMessage'
		)
	);
	$wp_customize->add_control(
		'url_field',
		array(
			'description' 	=> esc_html__( '', 'text-domain' ),
			'label' => esc_html__( 'URL Field', 'text-domain' ),
			'priority' => 10,
			'section' => 'new_section',
			'settings' => 'url_field',
			'type' => 'url'
		)
	);
	$wp_customize->get_setting( 'url_field' )->transport = 'postMessage';



	// Email Field
	$wp_customize->add_setting(
		'email_field',
		array(
			'default'  	=> '',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'email_field',
		array(
			'description' 	=> esc_html__( '', 'text-domain' ),
			'label' => esc_html__( 'Email Field', 'text-domain' ),
			'priority' => 10,
			'section' => 'new_section',
			'settings' => 'email_field',
			'type' => 'email'
		)
	);
	$wp_customize->get_setting( 'email_field' )->transport = 'postMessage';

	// Date Field
	$wp_customize->add_setting(
		'date_field',
		array(
			'default'  	=> '',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'date_field',
		array(
			'description' 	=> esc_html__( '', 'text-domain' ),
			'label' => esc_html__( 'Date Field', 'text-domain' ),
			'priority' => 10,
			'section' => 'new_section',
			'settings' => 'date_field',
			'type' => 'date'
		)
	);
	$wp_customize->get_setting( 'date_field' )->transport = 'postMessage';


	// Checkbox Field
	$wp_customize->add_setting(
		'checkbox_field',
		array(
			'default'  	=> 'true',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'checkbox_field',
		array(
			'description' 	=> esc_html__( '', 'text-domain' ),
			'label' => esc_html__( 'Checkbox Field', 'text-domain' ),
			'priority' => 10,
			'section' => 'new_section',
			'settings' => 'checkbox_field',
			'type' => 'checkbox'
		)
	);
	$wp_customize->get_setting( 'checkbox_field' )->transport = 'postMessage';




	// Password Field
	$wp_customize->add_setting(
		'password_field',
		array(
			'default'  	=> '',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'password_field',
		array(
			'description' 	=> esc_html__( '', 'text-domain' ),
			'label' => esc_html__( 'Password Field', 'text-domain' ),
			'priority' => 10,
			'section' => 'new_section',
			'settings' => 'password_field',
			'type' => 'password'
		)
	);
	$wp_customize->get_setting( 'password_field' )->transport = 'postMessage';



	// Radio Field
	$wp_customize->add_setting(
		'radio_field',
		array(
			'default'  	=> 'choice1',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'radio_field',
		array(
			'choices' => array(
				'choice1' => esc_html__( 'Choice 1', 'text-domain' ),
				'choice2' => esc_html__( 'Choice 2', 'text-domain' ),
				'choice3' => esc_html__( 'Choice 3', 'text-domain' )
			),
			'description' 	=> esc_html__( '', 'text-domain' ),
			'label' => esc_html__( 'Radio Field', 'text-domain' ),
			'priority' => 10,
			'section' => 'new_section',
			'settings' => 'radio_field',
			'type' => 'radio'
		)
	);
	$wp_customize->get_setting( 'radio_field' )->transport = 'postMessage';



	// Select Field
	$wp_customize->add_setting(
		'select_field',
		array(
			'default'  	=> 'choice1',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'select_field',
		array(
			'choices' => array(
				'choice1' => esc_html__( 'Choice 1', 'text-domain' ),
				'choice2' => esc_html__( 'Choice 2', 'text-domain' ),
				'choice3' => esc_html__( 'Choice 3', 'text-domain' )
			),
			'description' 	=> esc_html__( '', 'text-domain' ),
			'label' => esc_html__( 'Select Field', 'text-domain' ),
			'priority' => 10,
			'section' => 'new_section',
			'settings' => 'select_field',
			'type' => 'select'
		)
	);
	$wp_customize->get_setting( 'select_field' )->transport = 'postMessage';



	// Textarea Field
	$wp_customize->add_setting(
		'textarea_field',
		array(
			'default'  	=> '',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'textarea_field',
		array(
			'description' 	=> esc_html__( '', 'text-domain' ),
			'label' => esc_html__( 'Textarea Field', 'text-domain' ),
			'priority' => 10,
			'section' => 'new_section',
			'settings' => 'textarea_field',
			'type' => 'textarea'
		)
	);
	$wp_customize->get_setting( 'textarea_field' )->transport = 'postMessage';



	// Range Field
	$wp_customize->add_setting(
		'range_field',
		array(
			'default'  			=> '',
			'sanitize_callback' => 'sanitize_hex_color'
			'transport' 		=> 'postMessage'
		)
	);
	$wp_customize->add_control(
		'range_field',
		array(
			'description' 	=> esc_html__( '', 'text-domain' ),
			'input_attrs' => array(
				'class' => 'range-field',
				'max' => 100,
				'min' => 0,
				'step' => 1,
				'style' => 'color: #020202'
			),
			'label' => esc_html__( 'Range Field', 'text-domain' ),
			'priority' => 10,
			'section' => 'new_section',
			'settings' => 'range_field',
			'type' => 'range'
		)
	);
	$wp_customize->get_setting( 'range_field' )->transport = 'postMessage';



	// Page Select Field
	$wp_customize->add_setting(
		'select_page_field',
		array(
			'default'  	=> '',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'select_page_field',
		array(
			'description' 	=> esc_html__( '', 'text-domain' ),
			'label' => esc_html__( 'Select Page', 'text-domain' ),
			'priority' => 10,
			'section' => 'new_section',
			'settings' => 'select_page_field',
			'type' => 'dropdown-pages'
		)
	);
	$wp_customize->get_setting( 'dropdown-pages' )->transport = 'postMessage';



	// Color Chooser Field
	$wp_customize->add_setting(
		'color_field',
		array(
			'default'  	=> '#ffffff',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'color_field',
			array(
				'description' 	=> esc_html__( '', 'text-domain' ),
				'label' => esc_html__( 'Color Field', 'text-domain' ),
				'priority' => 10,
				'section' => 'new_section',
				'settings' => 'color_field'
			),
		)
	);
	$wp_customize->get_setting( 'color_field' )->transport = 'postMessage';



	// File Upload Field
	$wp_customize->add_setting( 'file_upload' );
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'file_upload',
			array(
				'description' 	=> esc_html__( '', 'text-domain' ),
				'label' => esc_html__( 'File Upload', 'text-domain' ),
				'priority' => 10,
				'section' => 'new_section',
				'settings' => 'file_upload'
			),
		)
	);



	// Image Upload Field
	$wp_customize->add_setting(
		'image_upload',
		array(
			'default' => '',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'image_upload',
			array(
				'description' 	=> esc_html__( '', 'text-domain' ),
				'label' => esc_html__( 'Image Field', 'text-domain' ),
				'priority' => 10,
				'section' => 'new_section',
				'settings' => 'image_upload'
			)
		)
	);
	$wp_customize->get_setting( 'image_upload' )->transport = 'postMessage';



	// Media Upload Field
	// Can be used for images
	// Returns the image ID, not a URL
	$wp_customize->add_setting(
		'media_upload',
		array(
			'default' => '',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'media_upload',
			array(
				'description' 	=> esc_html__( '', 'text-domain' ),
				'label' => esc_html__( 'Media Field', 'text-domain' ),
				'mime_type' => '',
				'priority' => 10,
				'section' => 'new_section',
				'settings' => 'media_upload'
			)
		)
	);
	$wp_customize->get_setting( 'media_upload' )->transport = 'postMessage';




	// Cropped Image Field
	$wp_customize->add_setting(
		'cropped_image',
		array(
			'default' => '',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Cropped_Image_Control(
			$wp_customize,
			'cropped_image',
			array(
				'description' 	=> esc_html__( '', 'text-domain' ),
				'flex_height' => '',
				'flex_width' => '',
				'height' => '1080',
				'priority' => 10,
				'section' => 'new_section',
				'settings' => 'cropped_image',
				width' => '1920'
			)
		)
	);
	$wp_customize->get_setting( 'cropped_image' )->transport = 'postMessage';


	// Country Select Field
	$wp_customize->add_setting(
		'country',
		array(
			'default'  	=> '',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'country',
		array(
			'choices' 		=> function_names_country_list(),
			'description' 	=> esc_html__( '', 'text-domain' ),
			'label' 		=> esc_html__( 'Country', 'text-domain' ),
			'priority' 		=> 250,
			'section' 		=> 'contact_info',
			'settings' 		=> 'country',
			'type' 			=> 'select'
		)
	);
	$wp_customize->get_setting( 'country' )->transport = 'postMessage';


	// US States Select Field
	$wp_customize->add_setting(
		'us_state',
		array(
			'default'  	=> '',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'us_state',
		array(
			'choices' => array(
				'AL' => esc_html__( 'Alabama', 'text-domain' ),
				'AK' => esc_html__( 'Alaska', 'text-domain' ),
				'AZ' => esc_html__( 'Arizona', 'text-domain' ),
				'AR' => esc_html__( 'Arkansas', 'text-domain' ),
				'CA' => esc_html__( 'California', 'text-domain' ),
				'CO' => esc_html__( 'Colorado', 'text-domain' ),
				'CT' => esc_html__( 'Connecticut', 'text-domain' ),
				'DE' => esc_html__( 'Delaware', 'text-domain' ),
				'DC' => esc_html__( 'District of Columbia', 'text-domain' ),
				'FL' => esc_html__( 'Florida', 'text-domain' ),
				'GA' => esc_html__( 'Georgia', 'text-domain' ),
				'HI' => esc_html__( 'Hawaii', 'text-domain' ),
				'ID' => esc_html__( 'Idaho', 'text-domain' ),
				'IL' => esc_html__( 'Illinois', 'text-domain' ),
				'IN' => esc_html__( 'Indiana', 'text-domain' ),
				'IA' => esc_html__( 'Iowa', 'text-domain' ),
				'KS' => esc_html__( 'Kansas', 'text-domain' ),
				'KY' => esc_html__( 'Kentucky', 'text-domain' ),
				'LA' => esc_html__( 'Louisiana', 'text-domain' ),
				'ME' => esc_html__( 'Maine', 'text-domain' ),
				'MD' => esc_html__( 'Maryland', 'text-domain' ),
				'MA' => esc_html__( 'Massachusetts', 'text-domain' ),
				'MI' => esc_html__( 'Michigan', 'text-domain' ),
				'MN' => esc_html__( 'Minnesota', 'text-domain' ),
				'MS' => esc_html__( 'Mississippi', 'text-domain' ),
				'MO' => esc_html__( 'Missouri', 'text-domain' ),
				'MT' => esc_html__( 'Montana', 'text-domain' ),
				'NE' => esc_html__( 'Nebraska', 'text-domain' ),
				'NV' => esc_html__( 'Nevada', 'text-domain' ),
				'NH' => esc_html__( 'New Hampshire', 'text-domain' ),
				'NJ' => esc_html__( 'New Jersey', 'text-domain' ),
				'NM' => esc_html__( 'New Mexico', 'text-domain' ),
				'NY' => esc_html__( 'New York', 'text-domain' ),
				'NC' => esc_html__( 'North Carolina', 'text-domain' ),
				'ND' => esc_html__( 'North Dakota', 'text-domain' ),
				'OH' => esc_html__( 'Ohio', 'text-domain' ),
				'OK' => esc_html__( 'Oklahoma', 'text-domain' ),
				'OR' => esc_html__( 'Oregon', 'text-domain' ),
				'PA' => esc_html__( 'Pennsylvania', 'text-domain' ),
				'RI' => esc_html__( 'Rhode Island', 'text-domain' ),
				'SC' => esc_html__( 'South Carolina', 'text-domain' ),
				'SD' => esc_html__( 'South Dakota', 'text-domain' ),
				'TN' => esc_html__( 'Tennessee', 'text-domain' ),
				'TX' => esc_html__( 'Texas', 'text-domain' ),
				'UT' => esc_html__( 'Utah', 'text-domain' ),
				'VT' => esc_html__( 'Vermont', 'text-domain' ),
				'VA' => esc_html__( 'Virginia', 'text-domain' ),
				'WA' => esc_html__( 'Washington', 'text-domain' ),
				'WV' => esc_html__( 'West Virginia', 'text-domain' ),
				'WI' => esc_html__( 'Wisconsin', 'text-domain' ),
				'WY' => esc_html__( 'Wyoming', 'text-domain' ),
				'AS' => esc_html__( 'American Samoa', 'text-domain' ),
				'AA' => esc_html__( 'Armed Forces America (except Canada)', 'text-domain' ),
				'AE' => esc_html__( 'Armed Forces Africa/Canada/Europe/Middle East', 'text-domain' ),
				'AP' => esc_html__( 'Armed Forces Pacific', 'text-domain' ),
				'FM' => esc_html__( 'Federated States of Micronesia', 'text-domain' ),
				'GU' => esc_html__( 'Guam', 'text-domain' ),
				'MH' => esc_html__( 'Marshall Islands', 'text-domain' ),
				'MP' => esc_html__( 'Northern Mariana Islands', 'text-domain' ),
				'PR' => esc_html__( 'Puerto Rico', 'text-domain' ),
				'PW' => esc_html__( 'Palau', 'text-domain' ),
				'VI' => esc_html__( 'Virgin Islands', 'text-domain' )
			),
			'description' 	=> esc_html__( '', 'text-domain' ),
			'label' 		=> esc_html__( 'State', 'text-domain' ),
			'priority' 		=> 230,
			'section' 		=> 'contact_info',
			'settings' 		=> 'us_state',
			'type' 			=> 'select'
		)
	);
	$wp_customize->get_setting( 'us_state' )->transport = 'postMessage';


	// Canadian States Select Field
	$wp_customize->add_setting(
		'canada_state',
		array(
			'default'  	=> '',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'canada_state',
		array(
			'choices' => array(
				'AB' => esc_html__( 'Alberta', 'text-domain' ),
				'BC' => esc_html__( 'British Columbia', 'text-domain' ),
				'MB' => esc_html__( 'Manitoba', 'text-domain' ),
				'NB' => esc_html__( 'New Brunswick', 'text-domain' ),
				'NL' => esc_html__( 'Newfoundland and Labrador', 'text-domain' ),
				'NT' => esc_html__( 'Northwest Territories', 'text-domain' ),
				'NS' => esc_html__( 'Nova Scotia', 'text-domain' ),
				'NU' => esc_html__( 'Nunavut', 'text-domain' ),
				'ON' => esc_html__( 'Ontario', 'text-domain' ),
				'PE' => esc_html__( 'Prince Edward Island', 'text-domain' ),
				'QC' => esc_html__( 'Quebec', 'text-domain' ),
				'SK' => esc_html__( 'Saskatchewan', 'text-domain' ),
				'YT' => esc_html__( 'Yukon', 'text-domain' )
			),
			'description' 	=> esc_html__( '', 'text-domain' ),
			'label' 		=> esc_html__( 'State', 'text-domain' ),
			'priority' 		=> 230,
			'section' 		=> 'contact_info',
			'settings' 		=> 'canada_state',
			'type' 			=> 'select'
		)
	);
	$wp_customize->get_setting( 'canada_state' )->transport = 'postMessage';


	// Australian States Select Field
	$wp_customize->add_setting(
		'australia_state',
		array(
			'default'  	=> '',
			'transport' => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'australia_state',
		array(
			'choices' => array(
				'ACT' 	=> esc_html__( 'Australian Capital Territory', 'text-domain' ),
				'NSW' 	=> esc_html__( 'New South Wales', 'text-domain' ),
				'NT' 	=> esc_html__( 'Northern Territory', 'text-domain' ),
				'QLD' 	=> esc_html__( 'Queensland', 'text-domain' ),
				'SA' 	=> esc_html__( 'South Australia', 'text-domain' ),
				'TAS' 	=> esc_html__( 'Tasmania', 'text-domain' ),
				'VIC' 	=> esc_html__( 'Victoria', 'text-domain' ),
				'WA' 	=> esc_html__( 'Western Australia', 'text-domain' )
			),
			'description' 	=> esc_html__( '', 'text-domain' ),
			'label' 		=> esc_html__( 'State', 'text-domain' ),
			'priority' 		=> 230,
			'section' 		=> 'contact_info',
			'settings' 		=> 'australia_state',
			'type' 			=> 'select'
		)
	);
	$wp_customize->get_setting( 'australia_state' )->transport = 'postMessage';


	*/

} // function_names_register_fields()

/**
 * This will generate a line of CSS for use in header output. If the setting
 * ($mod_name) has no defined value, the CSS will not be output.
 *
 * @access 		public
 * @since 		1.0.0
 *
 * @param 		string 		$selector 		CSS selector
 * @param 		string 		$style 			The name of the CSS *property* to modify
 * @param 		string 		$mod_name 		The name of the 'theme_mod' option to fetch
 * @param 		string 		$prefix 		Optional. Anything that needs to be output before the CSS property
 * @param 		string 		$postfix 		Optional. Anything that needs to be output after the CSS property
 * @param 		bool 		$echo 			Optional. Whether to print directly to the page (default: true).
 *
 * @return 		string 						Returns a single line of CSS with selectors and a property.
 */
function function_names_generate_css( $selector, $style, $mod_name, $prefix = '', $postfix = '', $echo = true ) {

	$return = '';
	$mod 	= get_theme_mod( $mod_name );

	if ( ! empty( $mod ) ) {

		$return = sprintf('%s { %s:%s; }',
			$selector,
			$style,
			$prefix . $mod . $postfix
		);

		if ( $echo ) {

			echo $return;

		}

	}

	return $return;

} // function_names_generate_css()

/**
 * This will output the custom WordPress settings to the live theme's WP head.
 *
 * Used by hook: 'wp_head'
 *
 * @access 		public
 * @see 		add_action( 'wp_head', $func )
 * @since 		1.0.0
 */
function function_names_header_output() {

	?><!-- Customizer CSS -->
	<style type="text/css"><?php

		// pattern:
		// function_names_generate_css( 'selector', 'style', 'mod_name', 'prefix', 'postfix', true );
		//
		// background-image example:
		// function_names_generate_css( '.class', 'background-image', 'background_image_example', 'url(', ')' );


	?></style><!-- Customizer CSS --><?php

} // function_names_header_output()

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * Used by hook: 'customize_preview_init'
 *
 * @access 		public
 * @see 		add_action( 'customize_preview_init', $func )
 * @since 		1.0.0
 */
function function_names_live_preview() {

	wp_enqueue_script( 'function_names_customizer', get_template_directory_uri() . '/js/customizer.min.js', array( 'jquery', 'customize-preview' ), '', true );

} // function_names_live_preview()

/**
 * Used by customizer controls, mostly for active callbacks.
 *
 * @hook		customize_controls_enqueue_scripts
 *
 * @access 		public
 * @see 		add_action( 'customize_preview_init', $func )
 * @since 		1.0.0
 */
function function_names_control_scripts() {

	wp_enqueue_script( 'function_names_customizer_controls', get_template_directory_uri() . '/js/customizer-controls.min.js', array( 'jquery', 'customize-controls' ), false, true );

} // function_names_control_scripts()

/**
 * Returns TRUE based on which link type is selected, otherwise FALSE
 *
 * @param 	object 		$control 			The control object
 * @return 	bool 							TRUE if conditions are met, otherwise FALSE
 */
function function_names_states_of_country_callback( $control ) {

	$country_setting = $control->manager->get_setting('country')->value();

	//wp_die( print_r( $radio_setting ) );
	//wp_die( print_r( $control->id ) );

	if ( 'us_state' === $control->id && 'US' === $country_setting ) { return true; }
	if ( 'canada_state' === $control->id && 'CA' === $country_setting ) { return true; }
	if ( 'australia_state' === $control->id && 'AU' === $country_setting ) { return true; }
	if ( 'default_state' === $control->id && ! function_names_custom_countries( $country_setting ) ) { return true; }

	return false;

} // function_names_states_of_country_callback()

/**
 * Returns true if a country has a custom select menu
 *
 * @param 		string 		$country 			The country code to check
 *
 * @return 		bool 							TRUE if the code is in the array, FALSE otherwise
 */
function function_names_custom_countries( $country ) {

	$countries = array( 'US', 'CA', 'AU' );

	return in_array( $country, $countries );

} // function_names_custom_countries()


/**
 * Returns an array of countries or a country name.
 *
 * @param 		string 		$country 		Country code to return (optional)
 *
 * @return 		array|string 				Array of countries or a single country name
 */
function function_names_country_list( $country = '' ) {

	$countries = array();

	$countries['AF'] = esc_html__( 'Afghanistan (‫افغانستان‬‎)', 'text-domain' );
	$countries['AX'] = esc_html__( 'Åland Islands (Åland)', 'text-domain' );
	$countries['AL'] = esc_html__( 'Albania (Shqipëri)', 'text-domain' );
	$countries['DZ'] = esc_html__( 'Algeria (‫الجزائر‬‎)', 'text-domain' );
	$countries['AS'] = esc_html__( 'American Samoa', 'text-domain' );
	$countries['AD'] = esc_html__( 'Andorra', 'text-domain' );
	$countries['AO'] = esc_html__( 'Angola', 'text-domain' );
	$countries['AI'] = esc_html__( 'Anguilla', 'text-domain' );
	$countries['AQ'] = esc_html__( 'Antarctica', 'text-domain' );
	$countries['AG'] = esc_html__( 'Antigua and Barbuda', 'text-domain' );
	$countries['AR'] = esc_html__( 'Argentina', 'text-domain' );
	$countries['AM'] = esc_html__( 'Armenia (Հայաստան)', 'text-domain' );
	$countries['AW'] = esc_html__( 'Aruba', 'text-domain' );
	$countries['AC'] = esc_html__( 'Ascension Island', 'text-domain' );
	$countries['AU'] = esc_html__( 'Australia', 'text-domain' );
	$countries['AT'] = esc_html__( 'Austria (Österreich)', 'text-domain' );
	$countries['AZ'] = esc_html__( 'Azerbaijan (Azərbaycan)', 'text-domain' );
	$countries['BS'] = esc_html__( 'Bahamas', 'text-domain' );
	$countries['BH'] = esc_html__( 'Bahrain (‫البحرين‬‎)', 'text-domain' );
	$countries['BD'] = esc_html__( 'Bangladesh (বাংলাদেশ)', 'text-domain' );
	$countries['BB'] = esc_html__( 'Barbados', 'text-domain' );
	$countries['BY'] = esc_html__( 'Belarus (Беларусь)', 'text-domain' );
	$countries['BE'] = esc_html__( 'Belgium (België)', 'text-domain' );
	$countries['BZ'] = esc_html__( 'Belize', 'text-domain' );
	$countries['BJ'] = esc_html__( 'Benin (Bénin)', 'text-domain' );
	$countries['BM'] = esc_html__( 'Bermuda', 'text-domain' );
	$countries['BT'] = esc_html__( 'Bhutan (འབྲུག)', 'text-domain' );
	$countries['BO'] = esc_html__( 'Bolivia', 'text-domain' );
	$countries['BA'] = esc_html__( 'Bosnia and Herzegovina (Босна и Херцеговина)', 'text-domain' );
	$countries['BW'] = esc_html__( 'Botswana', 'text-domain' );
	$countries['BV'] = esc_html__( 'Bouvet Island', 'text-domain' );
	$countries['BR'] = esc_html__( 'Brazil (Brasil)', 'text-domain' );
	$countries['IO'] = esc_html__( 'British Indian Ocean Territory', 'text-domain' );
	$countries['VG'] = esc_html__( 'British Virgin Islands', 'text-domain' );
	$countries['BN'] = esc_html__( 'Brunei', 'text-domain' );
	$countries['BG'] = esc_html__( 'Bulgaria (България)', 'text-domain' );
	$countries['BF'] = esc_html__( 'Burkina Faso', 'text-domain' );
	$countries['BI'] = esc_html__( 'Burundi (Uburundi)', 'text-domain' );
	$countries['KH'] = esc_html__( 'Cambodia (កម្ពុជា)', 'text-domain' );
	$countries['CM'] = esc_html__( 'Cameroon (Cameroun)', 'text-domain' );
	$countries['CA'] = esc_html__( 'Canada', 'text-domain' );
	$countries['IC'] = esc_html__( 'Canary Islands (islas Canarias)', 'text-domain' );
	$countries['CV'] = esc_html__( 'Cape Verde (Kabu Verdi)', 'text-domain' );
	$countries['BQ'] = esc_html__( 'Caribbean Netherlands', 'text-domain' );
	$countries['KY'] = esc_html__( 'Cayman Islands', 'text-domain' );
	$countries['CF'] = esc_html__( 'Central African Republic (République centrafricaine)', 'text-domain' );
	$countries['EA'] = esc_html__( 'Ceuta and Melilla (Ceuta y Melilla)', 'text-domain' );
	$countries['TD'] = esc_html__( 'Chad (Tchad)', 'text-domain' );
	$countries['CL'] = esc_html__( 'Chile', 'text-domain' );
	$countries['CN'] = esc_html__( 'China (中国)', 'text-domain' );
	$countries['CX'] = esc_html__( 'Christmas Island', 'text-domain' );
	$countries['CP'] = esc_html__( 'Clipperton Island', 'text-domain' );
	$countries['CC'] = esc_html__( 'Cocos (Keeling) Islands (Kepulauan Cocos (Keeling))', 'text-domain' );
	$countries['CO'] = esc_html__( 'Colombia', 'text-domain' );
	$countries['KM'] = esc_html__( 'Comoros (‫جزر القمر‬‎)', 'text-domain' );
	$countries['CD'] = esc_html__( 'Congo (DRC) (Jamhuri ya Kidemokrasia ya Kongo)', 'text-domain' );
	$countries['CG'] = esc_html__( 'Congo (Republic) (Congo-Brazzaville)', 'text-domain' );
	$countries['CK'] = esc_html__( 'Cook Islands', 'text-domain' );
	$countries['CR'] = esc_html__( 'Costa Rica', 'text-domain' );
	$countries['CI'] = esc_html__( 'Côte d’Ivoire', 'text-domain' );
	$countries['HR'] = esc_html__( 'Croatia (Hrvatska)', 'text-domain' );
	$countries['CU'] = esc_html__( 'Cuba', 'text-domain' );
	$countries['CW'] = esc_html__( 'Curaçao', 'text-domain' );
	$countries['CY'] = esc_html__( 'Cyprus (Κύπρος)', 'text-domain' );
	$countries['CZ'] = esc_html__( 'Czech Republic (Česká republika)', 'text-domain' );
	$countries['DK'] = esc_html__( 'Denmark (Danmark)', 'text-domain' );
	$countries['DG'] = esc_html__( 'Diego Garcia', 'text-domain' );
	$countries['DJ'] = esc_html__( 'Djibouti', 'text-domain' );
	$countries['DM'] = esc_html__( 'Dominica', 'text-domain' );
	$countries['DO'] = esc_html__( 'Dominican Republic (República Dominicana)', 'text-domain' );
	$countries['EC'] = esc_html__( 'Ecuador', 'text-domain' );
	$countries['EG'] = esc_html__( 'Egypt (‫مصر‬‎)', 'text-domain' );
	$countries['SV'] = esc_html__( 'El Salvador', 'text-domain' );
	$countries['GQ'] = esc_html__( 'Equatorial Guinea (Guinea Ecuatorial)', 'text-domain' );
	$countries['ER'] = esc_html__( 'Eritrea', 'text-domain' );
	$countries['EE'] = esc_html__( 'Estonia (Eesti)', 'text-domain' );
	$countries['ET'] = esc_html__( 'Ethiopia', 'text-domain' );
	$countries['FK'] = esc_html__( 'Falkland Islands (Islas Malvinas)', 'text-domain' );
	$countries['FO'] = esc_html__( 'Faroe Islands (Føroyar)', 'text-domain' );
	$countries['FJ'] = esc_html__( 'Fiji', 'text-domain' );
	$countries['FI'] = esc_html__( 'Finland (Suomi)', 'text-domain' );
	$countries['FR'] = esc_html__( 'France', 'text-domain' );
	$countries['GF'] = esc_html__( 'French Guiana (Guyane française)', 'text-domain' );
	$countries['PF'] = esc_html__( 'French Polynesia (Polynésie française)', 'text-domain' );
	$countries['TF'] = esc_html__( 'French Southern Territories (Terres australes françaises)', 'text-domain' );
	$countries['GA'] = esc_html__( 'Gabon', 'text-domain' );
	$countries['GM'] = esc_html__( 'Gambia', 'text-domain' );
	$countries['GE'] = esc_html__( 'Georgia (საქართველო)', 'text-domain' );
	$countries['DE'] = esc_html__( 'Germany (Deutschland)', 'text-domain' );
	$countries['GH'] = esc_html__( 'Ghana (Gaana)', 'text-domain' );
	$countries['GI'] = esc_html__( 'Gibraltar', 'text-domain' );
	$countries['GR'] = esc_html__( 'Greece (Ελλάδα)', 'text-domain' );
	$countries['GL'] = esc_html__( 'Greenland (Kalaallit Nunaat)', 'text-domain' );
	$countries['GD'] = esc_html__( 'Grenada', 'text-domain' );
	$countries['GP'] = esc_html__( 'Guadeloupe', 'text-domain' );
	$countries['GU'] = esc_html__( 'Guam', 'text-domain' );
	$countries['GT'] = esc_html__( 'Guatemala', 'text-domain' );
	$countries['GG'] = esc_html__( 'Guernsey', 'text-domain' );
	$countries['GN'] = esc_html__( 'Guinea (Guinée)', 'text-domain' );
	$countries['GW'] = esc_html__( 'Guinea-Bissau (Guiné Bissau)', 'text-domain' );
	$countries['GY'] = esc_html__( 'Guyana', 'text-domain' );
	$countries['HT'] = esc_html__( 'Haiti', 'text-domain' );
	$countries['HM'] = esc_html__( 'Heard & McDonald Islands', 'text-domain' );
	$countries['HN'] = esc_html__( 'Honduras', 'text-domain' );
	$countries['HK'] = esc_html__( 'Hong Kong (香港)', 'text-domain' );
	$countries['HU'] = esc_html__( 'Hungary (Magyarország)', 'text-domain' );
	$countries['IS'] = esc_html__( 'Iceland (Ísland)', 'text-domain' );
	$countries['IN'] = esc_html__( 'India (भारत)', 'text-domain' );
	$countries['ID'] = esc_html__( 'Indonesia', 'text-domain' );
	$countries['IR'] = esc_html__( 'Iran (‫ایران‬‎)', 'text-domain' );
	$countries['IQ'] = esc_html__( 'Iraq (‫العراق‬‎)', 'text-domain' );
	$countries['IE'] = esc_html__( 'Ireland', 'text-domain' );
	$countries['IM'] = esc_html__( 'Isle of Man', 'text-domain' );
	$countries['IL'] = esc_html__( 'Israel (‫ישראל‬‎)', 'text-domain' );
	$countries['IT'] = esc_html__( 'Italy (Italia)', 'text-domain' );
	$countries['JM'] = esc_html__( 'Jamaica', 'text-domain' );
	$countries['JP'] = esc_html__( 'Japan (日本)', 'text-domain' );
	$countries['JE'] = esc_html__( 'Jersey', 'text-domain' );
	$countries['JO'] = esc_html__( 'Jordan (‫الأردن‬‎)', 'text-domain' );
	$countries['KZ'] = esc_html__( 'Kazakhstan (Казахстан)', 'text-domain' );
	$countries['KE'] = esc_html__( 'Kenya', 'text-domain' );
	$countries['KI'] = esc_html__( 'Kiribati', 'text-domain' );
	$countries['XK'] = esc_html__( 'Kosovo (Kosovë)', 'text-domain' );
	$countries['KW'] = esc_html__( 'Kuwait (‫الكويت‬‎)', 'text-domain' );
	$countries['KG'] = esc_html__( 'Kyrgyzstan (Кыргызстан)', 'text-domain' );
	$countries['LA'] = esc_html__( 'Laos (ລາວ)', 'text-domain' );
	$countries['LV'] = esc_html__( 'Latvia (Latvija)', 'text-domain' );
	$countries['LB'] = esc_html__( 'Lebanon (‫لبنان‬‎)', 'text-domain' );
	$countries['LS'] = esc_html__( 'Lesotho', 'text-domain' );
	$countries['LR'] = esc_html__( 'Liberia', 'text-domain' );
	$countries['LY'] = esc_html__( 'Libya (‫ليبيا‬‎)', 'text-domain' );
	$countries['LI'] = esc_html__( 'Liechtenstein', 'text-domain' );
	$countries['LT'] = esc_html__( 'Lithuania (Lietuva)', 'text-domain' );
	$countries['LU'] = esc_html__( 'Luxembourg', 'text-domain' );
	$countries['MO'] = esc_html__( 'Macau (澳門)', 'text-domain' );
	$countries['MK'] = esc_html__( 'Macedonia (FYROM) (Македонија)', 'text-domain' );
	$countries['MG'] = esc_html__( 'Madagascar (Madagasikara)', 'text-domain' );
	$countries['MW'] = esc_html__( 'Malawi', 'text-domain' );
	$countries['MY'] = esc_html__( 'Malaysia', 'text-domain' );
	$countries['MV'] = esc_html__( 'Maldives', 'text-domain' );
	$countries['ML'] = esc_html__( 'Mali', 'text-domain' );
	$countries['MT'] = esc_html__( 'Malta', 'text-domain' );
	$countries['MH'] = esc_html__( 'Marshall Islands', 'text-domain' );
	$countries['MQ'] = esc_html__( 'Martinique', 'text-domain' );
	$countries['MR'] = esc_html__( 'Mauritania (‫موريتانيا‬‎)', 'text-domain' );
	$countries['MU'] = esc_html__( 'Mauritius (Moris)', 'text-domain' );
	$countries['YT'] = esc_html__( 'Mayotte', 'text-domain' );
	$countries['MX'] = esc_html__( 'Mexico (México)', 'text-domain' );
	$countries['FM'] = esc_html__( 'Micronesia', 'text-domain' );
	$countries['MD'] = esc_html__( 'Moldova (Republica Moldova)', 'text-domain' );
	$countries['MC'] = esc_html__( 'Monaco', 'text-domain' );
	$countries['MN'] = esc_html__( 'Mongolia (Монгол)', 'text-domain' );
	$countries['ME'] = esc_html__( 'Montenegro (Crna Gora)', 'text-domain' );
	$countries['MS'] = esc_html__( 'Montserrat', 'text-domain' );
	$countries['MA'] = esc_html__( 'Morocco (‫المغرب‬‎)', 'text-domain' );
	$countries['MZ'] = esc_html__( 'Mozambique (Moçambique)', 'text-domain' );
	$countries['MM'] = esc_html__( 'Myanmar (Burma) (မြန်မာ)', 'text-domain' );
	$countries['NA'] = esc_html__( 'Namibia (Namibië)', 'text-domain' );
	$countries['NR'] = esc_html__( 'Nauru', 'text-domain' );
	$countries['NP'] = esc_html__( 'Nepal (नेपाल)', 'text-domain' );
	$countries['NL'] = esc_html__( 'Netherlands (Nederland)', 'text-domain' );
	$countries['NC'] = esc_html__( 'New Caledonia (Nouvelle-Calédonie)', 'text-domain' );
	$countries['NZ'] = esc_html__( 'New Zealand', 'text-domain' );
	$countries['NI'] = esc_html__( 'Nicaragua', 'text-domain' );
	$countries['NE'] = esc_html__( 'Niger (Nijar)', 'text-domain' );
	$countries['NG'] = esc_html__( 'Nigeria', 'text-domain' );
	$countries['NU'] = esc_html__( 'Niue', 'text-domain' );
	$countries['NF'] = esc_html__( 'Norfolk Island', 'text-domain' );
	$countries['MP'] = esc_html__( 'Northern Mariana Islands', 'text-domain' );
	$countries['KP'] = esc_html__( 'North Korea (조선 민주주의 인민 공화국)', 'text-domain' );
	$countries['NO'] = esc_html__( 'Norway (Norge)', 'text-domain' );
	$countries['OM'] = esc_html__( 'Oman (‫عُمان‬‎)', 'text-domain' );
	$countries['PK'] = esc_html__( 'Pakistan (‫پاکستان‬‎)', 'text-domain' );
	$countries['PW'] = esc_html__( 'Palau', 'text-domain' );
	$countries['PS'] = esc_html__( 'Palestine (‫فلسطين‬‎)', 'text-domain' );
	$countries['PA'] = esc_html__( 'Panama (Panamá)', 'text-domain' );
	$countries['PG'] = esc_html__( 'Papua New Guinea', 'text-domain' );
	$countries['PY'] = esc_html__( 'Paraguay', 'text-domain' );
	$countries['PE'] = esc_html__( 'Peru (Perú)', 'text-domain' );
	$countries['PH'] = esc_html__( 'Philippines', 'text-domain' );
	$countries['PN'] = esc_html__( 'Pitcairn Islands', 'text-domain' );
	$countries['PL'] = esc_html__( 'Poland (Polska)', 'text-domain' );
	$countries['PT'] = esc_html__( 'Portugal', 'text-domain' );
	$countries['PR'] = esc_html__( 'Puerto Rico', 'text-domain' );
	$countries['QA'] = esc_html__( 'Qatar (‫قطر‬‎)', 'text-domain' );
	$countries['RE'] = esc_html__( 'Réunion (La Réunion)', 'text-domain' );
	$countries['RO'] = esc_html__( 'Romania (România)', 'text-domain' );
	$countries['RU'] = esc_html__( 'Russia (Россия)', 'text-domain' );
	$countries['RW'] = esc_html__( 'Rwanda', 'text-domain' );
	$countries['BL'] = esc_html__( 'Saint Barthélemy (Saint-Barthélemy)', 'text-domain' );
	$countries['SH'] = esc_html__( 'Saint Helena', 'text-domain' );
	$countries['KN'] = esc_html__( 'Saint Kitts and Nevis', 'text-domain' );
	$countries['LC'] = esc_html__( 'Saint Lucia', 'text-domain' );
	$countries['MF'] = esc_html__( 'Saint Martin (Saint-Martin (partie française))', 'text-domain' );
	$countries['PM'] = esc_html__( 'Saint Pierre and Miquelon (Saint-Pierre-et-Miquelon)', 'text-domain' );
	$countries['WS'] = esc_html__( 'Samoa', 'text-domain' );
	$countries['SM'] = esc_html__( 'San Marino', 'text-domain' );
	$countries['ST'] = esc_html__( 'São Tomé and Príncipe (São Tomé e Príncipe)', 'text-domain' );
	$countries['SA'] = esc_html__( 'Saudi Arabia (‫المملكة العربية السعودية‬‎)', 'text-domain' );
	$countries['SN'] = esc_html__( 'Senegal (Sénégal)', 'text-domain' );
	$countries['RS'] = esc_html__( 'Serbia (Србија)', 'text-domain' );
	$countries['SC'] = esc_html__( 'Seychelles', 'text-domain' );
	$countries['SL'] = esc_html__( 'Sierra Leone', 'text-domain' );
	$countries['SG'] = esc_html__( 'Singapore', 'text-domain' );
	$countries['SX'] = esc_html__( 'Sint Maarten', 'text-domain' );
	$countries['SK'] = esc_html__( 'Slovakia (Slovensko)', 'text-domain' );
	$countries['SI'] = esc_html__( 'Slovenia (Slovenija)', 'text-domain' );
	$countries['SB'] = esc_html__( 'Solomon Islands', 'text-domain' );
	$countries['SO'] = esc_html__( 'Somalia (Soomaaliya)', 'text-domain' );
	$countries['ZA'] = esc_html__( 'South Africa', 'text-domain' );
	$countries['GS'] = esc_html__( 'South Georgia & South Sandwich Islands', 'text-domain' );
	$countries['KR'] = esc_html__( 'South Korea (대한민국)', 'text-domain' );
	$countries['SS'] = esc_html__( 'South Sudan (‫جنوب السودان‬‎)', 'text-domain' );
	$countries['ES'] = esc_html__( 'Spain (España)', 'text-domain' );
	$countries['LK'] = esc_html__( 'Sri Lanka (ශ්‍රී ලංකාව)', 'text-domain' );
	$countries['VC'] = esc_html__( 'St. Vincent & Grenadines', 'text-domain' );
	$countries['SD'] = esc_html__( 'Sudan (‫السودان‬‎)', 'text-domain' );
	$countries['SR'] = esc_html__( 'Suriname', 'text-domain' );
	$countries['SJ'] = esc_html__( 'Svalbard and Jan Mayen (Svalbard og Jan Mayen)', 'text-domain' );
	$countries['SZ'] = esc_html__( 'Swaziland', 'text-domain' );
	$countries['SE'] = esc_html__( 'Sweden (Sverige)', 'text-domain' );
	$countries['CH'] = esc_html__( 'Switzerland (Schweiz)', 'text-domain' );
	$countries['SY'] = esc_html__( 'Syria (‫سوريا‬‎)', 'text-domain' );
	$countries['TW'] = esc_html__( 'Taiwan (台灣)', 'text-domain' );
	$countries['TJ'] = esc_html__( 'Tajikistan', 'text-domain' );
	$countries['TZ'] = esc_html__( 'Tanzania', 'text-domain' );
	$countries['TH'] = esc_html__( 'Thailand (ไทย)', 'text-domain' );
	$countries['TL'] = esc_html__( 'Timor-Leste', 'text-domain' );
	$countries['TG'] = esc_html__( 'Togo', 'text-domain' );
	$countries['TK'] = esc_html__( 'Tokelau', 'text-domain' );
	$countries['TO'] = esc_html__( 'Tonga', 'text-domain' );
	$countries['TT'] = esc_html__( 'Trinidad and Tobago', 'text-domain' );
	$countries['TA'] = esc_html__( 'Tristan da Cunha', 'text-domain' );
	$countries['TN'] = esc_html__( 'Tunisia (‫تونس‬‎)', 'text-domain' );
	$countries['TR'] = esc_html__( 'Turkey (Türkiye)', 'text-domain' );
	$countries['TM'] = esc_html__( 'Turkmenistan', 'text-domain' );
	$countries['TC'] = esc_html__( 'Turks and Caicos Islands', 'text-domain' );
	$countries['TV'] = esc_html__( 'Tuvalu', 'text-domain' );
	$countries['UM'] = esc_html__( 'U.S. Outlying Islands', 'text-domain' );
	$countries['VI'] = esc_html__( 'U.S. Virgin Islands', 'text-domain' );
	$countries['UG'] = esc_html__( 'Uganda', 'text-domain' );
	$countries['UA'] = esc_html__( 'Ukraine (Україна)', 'text-domain' );
	$countries['AE'] = esc_html__( 'United Arab Emirates (‫الإمارات العربية المتحدة‬‎)', 'text-domain' );
	$countries['GB'] = esc_html__( 'United Kingdom', 'text-domain' );
	$countries['US'] = esc_html__( 'United States', 'text-domain' );
	$countries['UY'] = esc_html__( 'Uruguay', 'text-domain' );
	$countries['UZ'] = esc_html__( 'Uzbekistan (Oʻzbekiston)', 'text-domain' );
	$countries['VU'] = esc_html__( 'Vanuatu', 'text-domain' );
	$countries['VA'] = esc_html__( 'Vatican City (Città del Vaticano)', 'text-domain' );
	$countries['VE'] = esc_html__( 'Venezuela', 'text-domain' );
	$countries['VN'] = esc_html__( 'Vietnam (Việt Nam)', 'text-domain' );
	$countries['WF'] = esc_html__( 'Wallis and Futuna', 'text-domain' );
	$countries['EH'] = esc_html__( 'Western Sahara (‫الصحراء الغربية‬‎)', 'text-domain' );
	$countries['YE'] = esc_html__( 'Yemen (‫اليمن‬‎)', 'text-domain' );
	$countries['ZM'] = esc_html__( 'Zambia', 'text-domain' );
	$countries['ZW'] = esc_html__( 'Zimbabwe', 'text-domain' );

	if ( ! empty( $country ) ) {

		return $countries[$country];

	}

	return $countries;

} // function_names_country_list()

