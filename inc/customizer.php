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
add_action( 'customize_register', 'westcpa_register_panels' );
add_action( 'customize_register', 'westcpa_register_sections' );
add_action( 'customize_register', 'westcpa_register_fields' );

// Output custom CSS to live site
add_action( 'wp_head', 'westcpa_header_output' );

// Enqueue live preview javascript in Theme Customizer admin screen
add_action( 'customize_preview_init', 'westcpa_live_preview' );

// Enqueue scripts for the customizer controls
add_action( 'customize_controls_enqueue_scripts', 'westcpa_control_scripts' );

/**
 * Registers custom panels for the Customizer
 *
 * @see			add_action( 'customize_register', $func )
 * @link 		http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
 * @since 		1.0.0
 *
 * @param 		WP_Customize_Manager 		$wp_customize 		Theme Customizer object.
 */
function westcpa_register_panels( $wp_customize ) {

	// Theme Options Panel
	$wp_customize->add_panel( 'theme_options',
		array(
			'capability'  		=> 'edit_theme_options',
			'description'  		=> esc_html__( 'Options for Replace With Theme Name', 'westcpa' ),
			'priority'  		=> 10,
			'theme_supports'  	=> '',
			'title'  			=> esc_html__( 'Theme Options', 'westcpa' ),
		)
	);

	/*
	// Theme Options Panel
	$wp_customize->add_panel( 'theme_options',
		array(
			'capability'  		=> 'edit_theme_options',
			'description'  		=> esc_html__( 'Options for Replace With Theme Name', 'westcpa' ),
			'priority'  		=> 10,
			'theme_supports'  	=> '',
			'title'  			=> esc_html__( 'Theme Options', 'westcpa' ),
		)
	);
	*/

} // westcpa_register_panels()

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
function westcpa_register_sections( $wp_customize ) {



	/*
	// New Section
	$wp_customize->add_section( 'new_section',
		array(
			'capability' 	=> 'edit_theme_options',
			'description' 	=> esc_html__( 'New Customizer Section', 'westcpa' ),
			'panel' 		=> 'theme_options',
			'priority' 		=> 10,
			'title' 		=> esc_html__( 'New Section', 'westcpa' )
		)
	);
	*/

} // westcpa_register_sections()

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
function westcpa_register_fields( $wp_customize ) {

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
			'description' 	=> esc_html__( 'Paste in the Google Tag Manager code here. Do not include the comment tags!', 'westcpa' ),
			'label' => esc_html__( 'Google Tag Manager', 'westcpa' ),
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
			'description' 	=> esc_html__( '', 'westcpa' ),
			'label'  	=> esc_html__( 'Text Field', 'westcpa' ),
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
			'description' 	=> esc_html__( '', 'westcpa' ),
			'label' => esc_html__( 'URL Field', 'westcpa' ),
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
			'description' 	=> esc_html__( '', 'westcpa' ),
			'label' => esc_html__( 'Email Field', 'westcpa' ),
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
			'description' 	=> esc_html__( '', 'westcpa' ),
			'label' => esc_html__( 'Date Field', 'westcpa' ),
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
			'description' 	=> esc_html__( '', 'westcpa' ),
			'label' => esc_html__( 'Checkbox Field', 'westcpa' ),
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
			'description' 	=> esc_html__( '', 'westcpa' ),
			'label' => esc_html__( 'Password Field', 'westcpa' ),
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
				'choice1' => esc_html__( 'Choice 1', 'westcpa' ),
				'choice2' => esc_html__( 'Choice 2', 'westcpa' ),
				'choice3' => esc_html__( 'Choice 3', 'westcpa' )
			),
			'description' 	=> esc_html__( '', 'westcpa' ),
			'label' => esc_html__( 'Radio Field', 'westcpa' ),
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
				'choice1' => esc_html__( 'Choice 1', 'westcpa' ),
				'choice2' => esc_html__( 'Choice 2', 'westcpa' ),
				'choice3' => esc_html__( 'Choice 3', 'westcpa' )
			),
			'description' 	=> esc_html__( '', 'westcpa' ),
			'label' => esc_html__( 'Select Field', 'westcpa' ),
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
			'description' 	=> esc_html__( '', 'westcpa' ),
			'label' => esc_html__( 'Textarea Field', 'westcpa' ),
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
			'description' 	=> esc_html__( '', 'westcpa' ),
			'input_attrs' => array(
				'class' => 'range-field',
				'max' => 100,
				'min' => 0,
				'step' => 1,
				'style' => 'color: #020202'
			),
			'label' => esc_html__( 'Range Field', 'westcpa' ),
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
			'description' 	=> esc_html__( '', 'westcpa' ),
			'label' => esc_html__( 'Select Page', 'westcpa' ),
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
				'description' 	=> esc_html__( '', 'westcpa' ),
				'label' => esc_html__( 'Color Field', 'westcpa' ),
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
				'description' 	=> esc_html__( '', 'westcpa' ),
				'label' => esc_html__( 'File Upload', 'westcpa' ),
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
				'description' 	=> esc_html__( '', 'westcpa' ),
				'label' => esc_html__( 'Image Field', 'westcpa' ),
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
				'description' 	=> esc_html__( '', 'westcpa' ),
				'label' => esc_html__( 'Media Field', 'westcpa' ),
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
				'description' 	=> esc_html__( '', 'westcpa' ),
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
			'choices' 		=> westcpa_country_list(),
			'description' 	=> esc_html__( '', 'westcpa' ),
			'label' 		=> esc_html__( 'Country', 'westcpa' ),
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
				'AL' => esc_html__( 'Alabama', 'westcpa' ),
				'AK' => esc_html__( 'Alaska', 'westcpa' ),
				'AZ' => esc_html__( 'Arizona', 'westcpa' ),
				'AR' => esc_html__( 'Arkansas', 'westcpa' ),
				'CA' => esc_html__( 'California', 'westcpa' ),
				'CO' => esc_html__( 'Colorado', 'westcpa' ),
				'CT' => esc_html__( 'Connecticut', 'westcpa' ),
				'DE' => esc_html__( 'Delaware', 'westcpa' ),
				'DC' => esc_html__( 'District of Columbia', 'westcpa' ),
				'FL' => esc_html__( 'Florida', 'westcpa' ),
				'GA' => esc_html__( 'Georgia', 'westcpa' ),
				'HI' => esc_html__( 'Hawaii', 'westcpa' ),
				'ID' => esc_html__( 'Idaho', 'westcpa' ),
				'IL' => esc_html__( 'Illinois', 'westcpa' ),
				'IN' => esc_html__( 'Indiana', 'westcpa' ),
				'IA' => esc_html__( 'Iowa', 'westcpa' ),
				'KS' => esc_html__( 'Kansas', 'westcpa' ),
				'KY' => esc_html__( 'Kentucky', 'westcpa' ),
				'LA' => esc_html__( 'Louisiana', 'westcpa' ),
				'ME' => esc_html__( 'Maine', 'westcpa' ),
				'MD' => esc_html__( 'Maryland', 'westcpa' ),
				'MA' => esc_html__( 'Massachusetts', 'westcpa' ),
				'MI' => esc_html__( 'Michigan', 'westcpa' ),
				'MN' => esc_html__( 'Minnesota', 'westcpa' ),
				'MS' => esc_html__( 'Mississippi', 'westcpa' ),
				'MO' => esc_html__( 'Missouri', 'westcpa' ),
				'MT' => esc_html__( 'Montana', 'westcpa' ),
				'NE' => esc_html__( 'Nebraska', 'westcpa' ),
				'NV' => esc_html__( 'Nevada', 'westcpa' ),
				'NH' => esc_html__( 'New Hampshire', 'westcpa' ),
				'NJ' => esc_html__( 'New Jersey', 'westcpa' ),
				'NM' => esc_html__( 'New Mexico', 'westcpa' ),
				'NY' => esc_html__( 'New York', 'westcpa' ),
				'NC' => esc_html__( 'North Carolina', 'westcpa' ),
				'ND' => esc_html__( 'North Dakota', 'westcpa' ),
				'OH' => esc_html__( 'Ohio', 'westcpa' ),
				'OK' => esc_html__( 'Oklahoma', 'westcpa' ),
				'OR' => esc_html__( 'Oregon', 'westcpa' ),
				'PA' => esc_html__( 'Pennsylvania', 'westcpa' ),
				'RI' => esc_html__( 'Rhode Island', 'westcpa' ),
				'SC' => esc_html__( 'South Carolina', 'westcpa' ),
				'SD' => esc_html__( 'South Dakota', 'westcpa' ),
				'TN' => esc_html__( 'Tennessee', 'westcpa' ),
				'TX' => esc_html__( 'Texas', 'westcpa' ),
				'UT' => esc_html__( 'Utah', 'westcpa' ),
				'VT' => esc_html__( 'Vermont', 'westcpa' ),
				'VA' => esc_html__( 'Virginia', 'westcpa' ),
				'WA' => esc_html__( 'Washington', 'westcpa' ),
				'WV' => esc_html__( 'West Virginia', 'westcpa' ),
				'WI' => esc_html__( 'Wisconsin', 'westcpa' ),
				'WY' => esc_html__( 'Wyoming', 'westcpa' ),
				'AS' => esc_html__( 'American Samoa', 'westcpa' ),
				'AA' => esc_html__( 'Armed Forces America (except Canada)', 'westcpa' ),
				'AE' => esc_html__( 'Armed Forces Africa/Canada/Europe/Middle East', 'westcpa' ),
				'AP' => esc_html__( 'Armed Forces Pacific', 'westcpa' ),
				'FM' => esc_html__( 'Federated States of Micronesia', 'westcpa' ),
				'GU' => esc_html__( 'Guam', 'westcpa' ),
				'MH' => esc_html__( 'Marshall Islands', 'westcpa' ),
				'MP' => esc_html__( 'Northern Mariana Islands', 'westcpa' ),
				'PR' => esc_html__( 'Puerto Rico', 'westcpa' ),
				'PW' => esc_html__( 'Palau', 'westcpa' ),
				'VI' => esc_html__( 'Virgin Islands', 'westcpa' )
			),
			'description' 	=> esc_html__( '', 'westcpa' ),
			'label' 		=> esc_html__( 'State', 'westcpa' ),
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
				'AB' => esc_html__( 'Alberta', 'westcpa' ),
				'BC' => esc_html__( 'British Columbia', 'westcpa' ),
				'MB' => esc_html__( 'Manitoba', 'westcpa' ),
				'NB' => esc_html__( 'New Brunswick', 'westcpa' ),
				'NL' => esc_html__( 'Newfoundland and Labrador', 'westcpa' ),
				'NT' => esc_html__( 'Northwest Territories', 'westcpa' ),
				'NS' => esc_html__( 'Nova Scotia', 'westcpa' ),
				'NU' => esc_html__( 'Nunavut', 'westcpa' ),
				'ON' => esc_html__( 'Ontario', 'westcpa' ),
				'PE' => esc_html__( 'Prince Edward Island', 'westcpa' ),
				'QC' => esc_html__( 'Quebec', 'westcpa' ),
				'SK' => esc_html__( 'Saskatchewan', 'westcpa' ),
				'YT' => esc_html__( 'Yukon', 'westcpa' )
			),
			'description' 	=> esc_html__( '', 'westcpa' ),
			'label' 		=> esc_html__( 'State', 'westcpa' ),
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
				'ACT' 	=> esc_html__( 'Australian Capital Territory', 'westcpa' ),
				'NSW' 	=> esc_html__( 'New South Wales', 'westcpa' ),
				'NT' 	=> esc_html__( 'Northern Territory', 'westcpa' ),
				'QLD' 	=> esc_html__( 'Queensland', 'westcpa' ),
				'SA' 	=> esc_html__( 'South Australia', 'westcpa' ),
				'TAS' 	=> esc_html__( 'Tasmania', 'westcpa' ),
				'VIC' 	=> esc_html__( 'Victoria', 'westcpa' ),
				'WA' 	=> esc_html__( 'Western Australia', 'westcpa' )
			),
			'description' 	=> esc_html__( '', 'westcpa' ),
			'label' 		=> esc_html__( 'State', 'westcpa' ),
			'priority' 		=> 230,
			'section' 		=> 'contact_info',
			'settings' 		=> 'australia_state',
			'type' 			=> 'select'
		)
	);
	$wp_customize->get_setting( 'australia_state' )->transport = 'postMessage';


	*/

} // westcpa_register_fields()

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
function westcpa_generate_css( $selector, $style, $mod_name, $prefix = '', $postfix = '', $echo = true ) {

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

} // westcpa_generate_css()

/**
 * This will output the custom WordPress settings to the live theme's WP head.
 *
 * Used by hook: 'wp_head'
 *
 * @access 		public
 * @see 		add_action( 'wp_head', $func )
 * @since 		1.0.0
 */
function westcpa_header_output() {

	?><!-- Customizer CSS -->
	<style type="text/css"><?php

		// pattern:
		// westcpa_generate_css( 'selector', 'style', 'mod_name', 'prefix', 'postfix', true );
		//
		// background-image example:
		// westcpa_generate_css( '.class', 'background-image', 'background_image_example', 'url(', ')' );


	?></style><!-- Customizer CSS --><?php

} // westcpa_header_output()

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * Used by hook: 'customize_preview_init'
 *
 * @access 		public
 * @see 		add_action( 'customize_preview_init', $func )
 * @since 		1.0.0
 */
function westcpa_live_preview() {

	wp_enqueue_script( 'westcpa_customizer', get_template_directory_uri() . '/js/customizer.min.js', array( 'jquery', 'customize-preview' ), '', true );

} // westcpa_live_preview()

/**
 * Used by customizer controls, mostly for active callbacks.
 *
 * @hook		customize_controls_enqueue_scripts
 *
 * @access 		public
 * @see 		add_action( 'customize_preview_init', $func )
 * @since 		1.0.0
 */
function westcpa_control_scripts() {

	wp_enqueue_script( 'westcpa_customizer_controls', get_template_directory_uri() . '/js/customizer-controls.min.js', array( 'jquery', 'customize-controls' ), false, true );

} // westcpa_control_scripts()

/**
 * Returns TRUE based on which link type is selected, otherwise FALSE
 *
 * @param 	object 		$control 			The control object
 * @return 	bool 							TRUE if conditions are met, otherwise FALSE
 */
function westcpa_states_of_country_callback( $control ) {

	$country_setting = $control->manager->get_setting('country')->value();

	//wp_die( print_r( $radio_setting ) );
	//wp_die( print_r( $control->id ) );

	if ( 'us_state' === $control->id && 'US' === $country_setting ) { return true; }
	if ( 'canada_state' === $control->id && 'CA' === $country_setting ) { return true; }
	if ( 'australia_state' === $control->id && 'AU' === $country_setting ) { return true; }
	if ( 'default_state' === $control->id && ! westcpa_custom_countries( $country_setting ) ) { return true; }

	return false;

} // westcpa_states_of_country_callback()

/**
 * Returns true if a country has a custom select menu
 *
 * @param 		string 		$country 			The country code to check
 *
 * @return 		bool 							TRUE if the code is in the array, FALSE otherwise
 */
function westcpa_custom_countries( $country ) {

	$countries = array( 'US', 'CA', 'AU' );

	return in_array( $country, $countries );

} // westcpa_custom_countries()


/**
 * Returns an array of countries or a country name.
 *
 * @param 		string 		$country 		Country code to return (optional)
 *
 * @return 		array|string 				Array of countries or a single country name
 */
function westcpa_country_list( $country = '' ) {

	$countries = array();

	$countries['AF'] = esc_html__( 'Afghanistan (‫افغانستان‬‎)', 'westcpa' );
	$countries['AX'] = esc_html__( 'Åland Islands (Åland)', 'westcpa' );
	$countries['AL'] = esc_html__( 'Albania (Shqipëri)', 'westcpa' );
	$countries['DZ'] = esc_html__( 'Algeria (‫الجزائر‬‎)', 'westcpa' );
	$countries['AS'] = esc_html__( 'American Samoa', 'westcpa' );
	$countries['AD'] = esc_html__( 'Andorra', 'westcpa' );
	$countries['AO'] = esc_html__( 'Angola', 'westcpa' );
	$countries['AI'] = esc_html__( 'Anguilla', 'westcpa' );
	$countries['AQ'] = esc_html__( 'Antarctica', 'westcpa' );
	$countries['AG'] = esc_html__( 'Antigua and Barbuda', 'westcpa' );
	$countries['AR'] = esc_html__( 'Argentina', 'westcpa' );
	$countries['AM'] = esc_html__( 'Armenia (Հայաստան)', 'westcpa' );
	$countries['AW'] = esc_html__( 'Aruba', 'westcpa' );
	$countries['AC'] = esc_html__( 'Ascension Island', 'westcpa' );
	$countries['AU'] = esc_html__( 'Australia', 'westcpa' );
	$countries['AT'] = esc_html__( 'Austria (Österreich)', 'westcpa' );
	$countries['AZ'] = esc_html__( 'Azerbaijan (Azərbaycan)', 'westcpa' );
	$countries['BS'] = esc_html__( 'Bahamas', 'westcpa' );
	$countries['BH'] = esc_html__( 'Bahrain (‫البحرين‬‎)', 'westcpa' );
	$countries['BD'] = esc_html__( 'Bangladesh (বাংলাদেশ)', 'westcpa' );
	$countries['BB'] = esc_html__( 'Barbados', 'westcpa' );
	$countries['BY'] = esc_html__( 'Belarus (Беларусь)', 'westcpa' );
	$countries['BE'] = esc_html__( 'Belgium (België)', 'westcpa' );
	$countries['BZ'] = esc_html__( 'Belize', 'westcpa' );
	$countries['BJ'] = esc_html__( 'Benin (Bénin)', 'westcpa' );
	$countries['BM'] = esc_html__( 'Bermuda', 'westcpa' );
	$countries['BT'] = esc_html__( 'Bhutan (འབྲུག)', 'westcpa' );
	$countries['BO'] = esc_html__( 'Bolivia', 'westcpa' );
	$countries['BA'] = esc_html__( 'Bosnia and Herzegovina (Босна и Херцеговина)', 'westcpa' );
	$countries['BW'] = esc_html__( 'Botswana', 'westcpa' );
	$countries['BV'] = esc_html__( 'Bouvet Island', 'westcpa' );
	$countries['BR'] = esc_html__( 'Brazil (Brasil)', 'westcpa' );
	$countries['IO'] = esc_html__( 'British Indian Ocean Territory', 'westcpa' );
	$countries['VG'] = esc_html__( 'British Virgin Islands', 'westcpa' );
	$countries['BN'] = esc_html__( 'Brunei', 'westcpa' );
	$countries['BG'] = esc_html__( 'Bulgaria (България)', 'westcpa' );
	$countries['BF'] = esc_html__( 'Burkina Faso', 'westcpa' );
	$countries['BI'] = esc_html__( 'Burundi (Uburundi)', 'westcpa' );
	$countries['KH'] = esc_html__( 'Cambodia (កម្ពុជា)', 'westcpa' );
	$countries['CM'] = esc_html__( 'Cameroon (Cameroun)', 'westcpa' );
	$countries['CA'] = esc_html__( 'Canada', 'westcpa' );
	$countries['IC'] = esc_html__( 'Canary Islands (islas Canarias)', 'westcpa' );
	$countries['CV'] = esc_html__( 'Cape Verde (Kabu Verdi)', 'westcpa' );
	$countries['BQ'] = esc_html__( 'Caribbean Netherlands', 'westcpa' );
	$countries['KY'] = esc_html__( 'Cayman Islands', 'westcpa' );
	$countries['CF'] = esc_html__( 'Central African Republic (République centrafricaine)', 'westcpa' );
	$countries['EA'] = esc_html__( 'Ceuta and Melilla (Ceuta y Melilla)', 'westcpa' );
	$countries['TD'] = esc_html__( 'Chad (Tchad)', 'westcpa' );
	$countries['CL'] = esc_html__( 'Chile', 'westcpa' );
	$countries['CN'] = esc_html__( 'China (中国)', 'westcpa' );
	$countries['CX'] = esc_html__( 'Christmas Island', 'westcpa' );
	$countries['CP'] = esc_html__( 'Clipperton Island', 'westcpa' );
	$countries['CC'] = esc_html__( 'Cocos (Keeling) Islands (Kepulauan Cocos (Keeling))', 'westcpa' );
	$countries['CO'] = esc_html__( 'Colombia', 'westcpa' );
	$countries['KM'] = esc_html__( 'Comoros (‫جزر القمر‬‎)', 'westcpa' );
	$countries['CD'] = esc_html__( 'Congo (DRC) (Jamhuri ya Kidemokrasia ya Kongo)', 'westcpa' );
	$countries['CG'] = esc_html__( 'Congo (Republic) (Congo-Brazzaville)', 'westcpa' );
	$countries['CK'] = esc_html__( 'Cook Islands', 'westcpa' );
	$countries['CR'] = esc_html__( 'Costa Rica', 'westcpa' );
	$countries['CI'] = esc_html__( 'Côte d’Ivoire', 'westcpa' );
	$countries['HR'] = esc_html__( 'Croatia (Hrvatska)', 'westcpa' );
	$countries['CU'] = esc_html__( 'Cuba', 'westcpa' );
	$countries['CW'] = esc_html__( 'Curaçao', 'westcpa' );
	$countries['CY'] = esc_html__( 'Cyprus (Κύπρος)', 'westcpa' );
	$countries['CZ'] = esc_html__( 'Czech Republic (Česká republika)', 'westcpa' );
	$countries['DK'] = esc_html__( 'Denmark (Danmark)', 'westcpa' );
	$countries['DG'] = esc_html__( 'Diego Garcia', 'westcpa' );
	$countries['DJ'] = esc_html__( 'Djibouti', 'westcpa' );
	$countries['DM'] = esc_html__( 'Dominica', 'westcpa' );
	$countries['DO'] = esc_html__( 'Dominican Republic (República Dominicana)', 'westcpa' );
	$countries['EC'] = esc_html__( 'Ecuador', 'westcpa' );
	$countries['EG'] = esc_html__( 'Egypt (‫مصر‬‎)', 'westcpa' );
	$countries['SV'] = esc_html__( 'El Salvador', 'westcpa' );
	$countries['GQ'] = esc_html__( 'Equatorial Guinea (Guinea Ecuatorial)', 'westcpa' );
	$countries['ER'] = esc_html__( 'Eritrea', 'westcpa' );
	$countries['EE'] = esc_html__( 'Estonia (Eesti)', 'westcpa' );
	$countries['ET'] = esc_html__( 'Ethiopia', 'westcpa' );
	$countries['FK'] = esc_html__( 'Falkland Islands (Islas Malvinas)', 'westcpa' );
	$countries['FO'] = esc_html__( 'Faroe Islands (Føroyar)', 'westcpa' );
	$countries['FJ'] = esc_html__( 'Fiji', 'westcpa' );
	$countries['FI'] = esc_html__( 'Finland (Suomi)', 'westcpa' );
	$countries['FR'] = esc_html__( 'France', 'westcpa' );
	$countries['GF'] = esc_html__( 'French Guiana (Guyane française)', 'westcpa' );
	$countries['PF'] = esc_html__( 'French Polynesia (Polynésie française)', 'westcpa' );
	$countries['TF'] = esc_html__( 'French Southern Territories (Terres australes françaises)', 'westcpa' );
	$countries['GA'] = esc_html__( 'Gabon', 'westcpa' );
	$countries['GM'] = esc_html__( 'Gambia', 'westcpa' );
	$countries['GE'] = esc_html__( 'Georgia (საქართველო)', 'westcpa' );
	$countries['DE'] = esc_html__( 'Germany (Deutschland)', 'westcpa' );
	$countries['GH'] = esc_html__( 'Ghana (Gaana)', 'westcpa' );
	$countries['GI'] = esc_html__( 'Gibraltar', 'westcpa' );
	$countries['GR'] = esc_html__( 'Greece (Ελλάδα)', 'westcpa' );
	$countries['GL'] = esc_html__( 'Greenland (Kalaallit Nunaat)', 'westcpa' );
	$countries['GD'] = esc_html__( 'Grenada', 'westcpa' );
	$countries['GP'] = esc_html__( 'Guadeloupe', 'westcpa' );
	$countries['GU'] = esc_html__( 'Guam', 'westcpa' );
	$countries['GT'] = esc_html__( 'Guatemala', 'westcpa' );
	$countries['GG'] = esc_html__( 'Guernsey', 'westcpa' );
	$countries['GN'] = esc_html__( 'Guinea (Guinée)', 'westcpa' );
	$countries['GW'] = esc_html__( 'Guinea-Bissau (Guiné Bissau)', 'westcpa' );
	$countries['GY'] = esc_html__( 'Guyana', 'westcpa' );
	$countries['HT'] = esc_html__( 'Haiti', 'westcpa' );
	$countries['HM'] = esc_html__( 'Heard & McDonald Islands', 'westcpa' );
	$countries['HN'] = esc_html__( 'Honduras', 'westcpa' );
	$countries['HK'] = esc_html__( 'Hong Kong (香港)', 'westcpa' );
	$countries['HU'] = esc_html__( 'Hungary (Magyarország)', 'westcpa' );
	$countries['IS'] = esc_html__( 'Iceland (Ísland)', 'westcpa' );
	$countries['IN'] = esc_html__( 'India (भारत)', 'westcpa' );
	$countries['ID'] = esc_html__( 'Indonesia', 'westcpa' );
	$countries['IR'] = esc_html__( 'Iran (‫ایران‬‎)', 'westcpa' );
	$countries['IQ'] = esc_html__( 'Iraq (‫العراق‬‎)', 'westcpa' );
	$countries['IE'] = esc_html__( 'Ireland', 'westcpa' );
	$countries['IM'] = esc_html__( 'Isle of Man', 'westcpa' );
	$countries['IL'] = esc_html__( 'Israel (‫ישראל‬‎)', 'westcpa' );
	$countries['IT'] = esc_html__( 'Italy (Italia)', 'westcpa' );
	$countries['JM'] = esc_html__( 'Jamaica', 'westcpa' );
	$countries['JP'] = esc_html__( 'Japan (日本)', 'westcpa' );
	$countries['JE'] = esc_html__( 'Jersey', 'westcpa' );
	$countries['JO'] = esc_html__( 'Jordan (‫الأردن‬‎)', 'westcpa' );
	$countries['KZ'] = esc_html__( 'Kazakhstan (Казахстан)', 'westcpa' );
	$countries['KE'] = esc_html__( 'Kenya', 'westcpa' );
	$countries['KI'] = esc_html__( 'Kiribati', 'westcpa' );
	$countries['XK'] = esc_html__( 'Kosovo (Kosovë)', 'westcpa' );
	$countries['KW'] = esc_html__( 'Kuwait (‫الكويت‬‎)', 'westcpa' );
	$countries['KG'] = esc_html__( 'Kyrgyzstan (Кыргызстан)', 'westcpa' );
	$countries['LA'] = esc_html__( 'Laos (ລາວ)', 'westcpa' );
	$countries['LV'] = esc_html__( 'Latvia (Latvija)', 'westcpa' );
	$countries['LB'] = esc_html__( 'Lebanon (‫لبنان‬‎)', 'westcpa' );
	$countries['LS'] = esc_html__( 'Lesotho', 'westcpa' );
	$countries['LR'] = esc_html__( 'Liberia', 'westcpa' );
	$countries['LY'] = esc_html__( 'Libya (‫ليبيا‬‎)', 'westcpa' );
	$countries['LI'] = esc_html__( 'Liechtenstein', 'westcpa' );
	$countries['LT'] = esc_html__( 'Lithuania (Lietuva)', 'westcpa' );
	$countries['LU'] = esc_html__( 'Luxembourg', 'westcpa' );
	$countries['MO'] = esc_html__( 'Macau (澳門)', 'westcpa' );
	$countries['MK'] = esc_html__( 'Macedonia (FYROM) (Македонија)', 'westcpa' );
	$countries['MG'] = esc_html__( 'Madagascar (Madagasikara)', 'westcpa' );
	$countries['MW'] = esc_html__( 'Malawi', 'westcpa' );
	$countries['MY'] = esc_html__( 'Malaysia', 'westcpa' );
	$countries['MV'] = esc_html__( 'Maldives', 'westcpa' );
	$countries['ML'] = esc_html__( 'Mali', 'westcpa' );
	$countries['MT'] = esc_html__( 'Malta', 'westcpa' );
	$countries['MH'] = esc_html__( 'Marshall Islands', 'westcpa' );
	$countries['MQ'] = esc_html__( 'Martinique', 'westcpa' );
	$countries['MR'] = esc_html__( 'Mauritania (‫موريتانيا‬‎)', 'westcpa' );
	$countries['MU'] = esc_html__( 'Mauritius (Moris)', 'westcpa' );
	$countries['YT'] = esc_html__( 'Mayotte', 'westcpa' );
	$countries['MX'] = esc_html__( 'Mexico (México)', 'westcpa' );
	$countries['FM'] = esc_html__( 'Micronesia', 'westcpa' );
	$countries['MD'] = esc_html__( 'Moldova (Republica Moldova)', 'westcpa' );
	$countries['MC'] = esc_html__( 'Monaco', 'westcpa' );
	$countries['MN'] = esc_html__( 'Mongolia (Монгол)', 'westcpa' );
	$countries['ME'] = esc_html__( 'Montenegro (Crna Gora)', 'westcpa' );
	$countries['MS'] = esc_html__( 'Montserrat', 'westcpa' );
	$countries['MA'] = esc_html__( 'Morocco (‫المغرب‬‎)', 'westcpa' );
	$countries['MZ'] = esc_html__( 'Mozambique (Moçambique)', 'westcpa' );
	$countries['MM'] = esc_html__( 'Myanmar (Burma) (မြန်မာ)', 'westcpa' );
	$countries['NA'] = esc_html__( 'Namibia (Namibië)', 'westcpa' );
	$countries['NR'] = esc_html__( 'Nauru', 'westcpa' );
	$countries['NP'] = esc_html__( 'Nepal (नेपाल)', 'westcpa' );
	$countries['NL'] = esc_html__( 'Netherlands (Nederland)', 'westcpa' );
	$countries['NC'] = esc_html__( 'New Caledonia (Nouvelle-Calédonie)', 'westcpa' );
	$countries['NZ'] = esc_html__( 'New Zealand', 'westcpa' );
	$countries['NI'] = esc_html__( 'Nicaragua', 'westcpa' );
	$countries['NE'] = esc_html__( 'Niger (Nijar)', 'westcpa' );
	$countries['NG'] = esc_html__( 'Nigeria', 'westcpa' );
	$countries['NU'] = esc_html__( 'Niue', 'westcpa' );
	$countries['NF'] = esc_html__( 'Norfolk Island', 'westcpa' );
	$countries['MP'] = esc_html__( 'Northern Mariana Islands', 'westcpa' );
	$countries['KP'] = esc_html__( 'North Korea (조선 민주주의 인민 공화국)', 'westcpa' );
	$countries['NO'] = esc_html__( 'Norway (Norge)', 'westcpa' );
	$countries['OM'] = esc_html__( 'Oman (‫عُمان‬‎)', 'westcpa' );
	$countries['PK'] = esc_html__( 'Pakistan (‫پاکستان‬‎)', 'westcpa' );
	$countries['PW'] = esc_html__( 'Palau', 'westcpa' );
	$countries['PS'] = esc_html__( 'Palestine (‫فلسطين‬‎)', 'westcpa' );
	$countries['PA'] = esc_html__( 'Panama (Panamá)', 'westcpa' );
	$countries['PG'] = esc_html__( 'Papua New Guinea', 'westcpa' );
	$countries['PY'] = esc_html__( 'Paraguay', 'westcpa' );
	$countries['PE'] = esc_html__( 'Peru (Perú)', 'westcpa' );
	$countries['PH'] = esc_html__( 'Philippines', 'westcpa' );
	$countries['PN'] = esc_html__( 'Pitcairn Islands', 'westcpa' );
	$countries['PL'] = esc_html__( 'Poland (Polska)', 'westcpa' );
	$countries['PT'] = esc_html__( 'Portugal', 'westcpa' );
	$countries['PR'] = esc_html__( 'Puerto Rico', 'westcpa' );
	$countries['QA'] = esc_html__( 'Qatar (‫قطر‬‎)', 'westcpa' );
	$countries['RE'] = esc_html__( 'Réunion (La Réunion)', 'westcpa' );
	$countries['RO'] = esc_html__( 'Romania (România)', 'westcpa' );
	$countries['RU'] = esc_html__( 'Russia (Россия)', 'westcpa' );
	$countries['RW'] = esc_html__( 'Rwanda', 'westcpa' );
	$countries['BL'] = esc_html__( 'Saint Barthélemy (Saint-Barthélemy)', 'westcpa' );
	$countries['SH'] = esc_html__( 'Saint Helena', 'westcpa' );
	$countries['KN'] = esc_html__( 'Saint Kitts and Nevis', 'westcpa' );
	$countries['LC'] = esc_html__( 'Saint Lucia', 'westcpa' );
	$countries['MF'] = esc_html__( 'Saint Martin (Saint-Martin (partie française))', 'westcpa' );
	$countries['PM'] = esc_html__( 'Saint Pierre and Miquelon (Saint-Pierre-et-Miquelon)', 'westcpa' );
	$countries['WS'] = esc_html__( 'Samoa', 'westcpa' );
	$countries['SM'] = esc_html__( 'San Marino', 'westcpa' );
	$countries['ST'] = esc_html__( 'São Tomé and Príncipe (São Tomé e Príncipe)', 'westcpa' );
	$countries['SA'] = esc_html__( 'Saudi Arabia (‫المملكة العربية السعودية‬‎)', 'westcpa' );
	$countries['SN'] = esc_html__( 'Senegal (Sénégal)', 'westcpa' );
	$countries['RS'] = esc_html__( 'Serbia (Србија)', 'westcpa' );
	$countries['SC'] = esc_html__( 'Seychelles', 'westcpa' );
	$countries['SL'] = esc_html__( 'Sierra Leone', 'westcpa' );
	$countries['SG'] = esc_html__( 'Singapore', 'westcpa' );
	$countries['SX'] = esc_html__( 'Sint Maarten', 'westcpa' );
	$countries['SK'] = esc_html__( 'Slovakia (Slovensko)', 'westcpa' );
	$countries['SI'] = esc_html__( 'Slovenia (Slovenija)', 'westcpa' );
	$countries['SB'] = esc_html__( 'Solomon Islands', 'westcpa' );
	$countries['SO'] = esc_html__( 'Somalia (Soomaaliya)', 'westcpa' );
	$countries['ZA'] = esc_html__( 'South Africa', 'westcpa' );
	$countries['GS'] = esc_html__( 'South Georgia & South Sandwich Islands', 'westcpa' );
	$countries['KR'] = esc_html__( 'South Korea (대한민국)', 'westcpa' );
	$countries['SS'] = esc_html__( 'South Sudan (‫جنوب السودان‬‎)', 'westcpa' );
	$countries['ES'] = esc_html__( 'Spain (España)', 'westcpa' );
	$countries['LK'] = esc_html__( 'Sri Lanka (ශ්‍රී ලංකාව)', 'westcpa' );
	$countries['VC'] = esc_html__( 'St. Vincent & Grenadines', 'westcpa' );
	$countries['SD'] = esc_html__( 'Sudan (‫السودان‬‎)', 'westcpa' );
	$countries['SR'] = esc_html__( 'Suriname', 'westcpa' );
	$countries['SJ'] = esc_html__( 'Svalbard and Jan Mayen (Svalbard og Jan Mayen)', 'westcpa' );
	$countries['SZ'] = esc_html__( 'Swaziland', 'westcpa' );
	$countries['SE'] = esc_html__( 'Sweden (Sverige)', 'westcpa' );
	$countries['CH'] = esc_html__( 'Switzerland (Schweiz)', 'westcpa' );
	$countries['SY'] = esc_html__( 'Syria (‫سوريا‬‎)', 'westcpa' );
	$countries['TW'] = esc_html__( 'Taiwan (台灣)', 'westcpa' );
	$countries['TJ'] = esc_html__( 'Tajikistan', 'westcpa' );
	$countries['TZ'] = esc_html__( 'Tanzania', 'westcpa' );
	$countries['TH'] = esc_html__( 'Thailand (ไทย)', 'westcpa' );
	$countries['TL'] = esc_html__( 'Timor-Leste', 'westcpa' );
	$countries['TG'] = esc_html__( 'Togo', 'westcpa' );
	$countries['TK'] = esc_html__( 'Tokelau', 'westcpa' );
	$countries['TO'] = esc_html__( 'Tonga', 'westcpa' );
	$countries['TT'] = esc_html__( 'Trinidad and Tobago', 'westcpa' );
	$countries['TA'] = esc_html__( 'Tristan da Cunha', 'westcpa' );
	$countries['TN'] = esc_html__( 'Tunisia (‫تونس‬‎)', 'westcpa' );
	$countries['TR'] = esc_html__( 'Turkey (Türkiye)', 'westcpa' );
	$countries['TM'] = esc_html__( 'Turkmenistan', 'westcpa' );
	$countries['TC'] = esc_html__( 'Turks and Caicos Islands', 'westcpa' );
	$countries['TV'] = esc_html__( 'Tuvalu', 'westcpa' );
	$countries['UM'] = esc_html__( 'U.S. Outlying Islands', 'westcpa' );
	$countries['VI'] = esc_html__( 'U.S. Virgin Islands', 'westcpa' );
	$countries['UG'] = esc_html__( 'Uganda', 'westcpa' );
	$countries['UA'] = esc_html__( 'Ukraine (Україна)', 'westcpa' );
	$countries['AE'] = esc_html__( 'United Arab Emirates (‫الإمارات العربية المتحدة‬‎)', 'westcpa' );
	$countries['GB'] = esc_html__( 'United Kingdom', 'westcpa' );
	$countries['US'] = esc_html__( 'United States', 'westcpa' );
	$countries['UY'] = esc_html__( 'Uruguay', 'westcpa' );
	$countries['UZ'] = esc_html__( 'Uzbekistan (Oʻzbekiston)', 'westcpa' );
	$countries['VU'] = esc_html__( 'Vanuatu', 'westcpa' );
	$countries['VA'] = esc_html__( 'Vatican City (Città del Vaticano)', 'westcpa' );
	$countries['VE'] = esc_html__( 'Venezuela', 'westcpa' );
	$countries['VN'] = esc_html__( 'Vietnam (Việt Nam)', 'westcpa' );
	$countries['WF'] = esc_html__( 'Wallis and Futuna', 'westcpa' );
	$countries['EH'] = esc_html__( 'Western Sahara (‫الصحراء الغربية‬‎)', 'westcpa' );
	$countries['YE'] = esc_html__( 'Yemen (‫اليمن‬‎)', 'westcpa' );
	$countries['ZM'] = esc_html__( 'Zambia', 'westcpa' );
	$countries['ZW'] = esc_html__( 'Zimbabwe', 'westcpa' );

	if ( ! empty( $country ) ) {

		return $countries[$country];

	}

	return $countries;

} // westcpa_country_list()

