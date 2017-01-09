<?php

/**
 * West_CPA Customizer
 *
 * Contains methods for customizing the theme customization screen.
 *
 * @link 			https://codex.wordpress.org/Theme_Customization_API
 * @since 			1.0.0
 * @package 		West_CPA
 * @subpackage 		West_CPA/classes
 */
class westcpa_Customizer {

	/**
	 * Constructor
	 */
	public function __construct() {}

	/**
	 * Registers all the WordPress hooks and filters for this class.
	 */
	public function hooks() {

		add_action( 'customize_register', 	array( $this, 'register_panels' ) );
		add_action( 'customize_register', 	array( $this, 'register_sections' ) );
		add_action( 'customize_register', 	array( $this, 'register_fields' ) );
		add_action( 'wp_head', 				array( $this, 'header_output' ) );
		//add_action( 'customize_register', 	array( $this, 'load_customize_controls' ), 0 );

	} // hooks()

	/**
	 * Registers custom panels for the Customizer
	 *
	 * @hooked 		customize_register
	 * @see			add_action( 'customize_register', $func )
	 * @link 		http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
	 * @since 		1.0.0
	 * @param 		WP_Customize_Manager 		$wp_customize 		Theme Customizer object.
	 */
	public function register_panels( $wp_customize ) {

		// Register panels here

	} // register_panels()

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
	 * nav_menus			100 			Navigation
	 * widgets 				110 			Widgets
	 * static_front_page 	120 			Static Front Page
	 * default 				160 			all others
	 *
	 * @hooked 		customize_register
	 * @see			add_action( 'customize_register', $func )
	 * @link 		http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
	 * @since 		1.0.0
	 * @param 		WP_Customize_Manager 		$wp_customize 		Theme Customizer object.
	 */
	public function register_sections( $wp_customize ) {

		// Tablet Menu Section
		$wp_customize->add_section( 'tablet_menu',
			array(
				'active_callback' 	=> '',
				'capability'  		=> 'edit_theme_options',
				'description'  		=> esc_html__( '', 'westcpa' ),
				'panel' 			=> 'nav_menus',
				'priority'  		=> 10,
				'theme_supports'  	=> '',
				'title'  			=> esc_html__( 'Tablet Menu Style', 'westcpa' ),
			)
		);
		
		// Images Section
		$wp_customize->add_section( 'images',
			array(
				'active_callback' 	=> '',
				'capability'  		=> 'edit_theme_options',
				'description'  		=> esc_html__( '', 'westcpa' ),
				'panel' 			=> '',
				'priority'  		=> 10,
				'theme_supports'  	=> '',
				'title'  			=> esc_html__( 'Images', 'westcpa' ),
			)
		);
		
		// Footer Section
		$wp_customize->add_section( 'footer',
			array(
				'capability' 	=> 'edit_theme_options',
				'description' 	=> esc_html__( '', 'westcpa' ),
				'panel' 		=> 'theme_options',
				'priority' 		=> 10,
				'title' 		=> esc_html__( 'Footer', 'westcpa' )
			)
		);

	} // register_sections()

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
	 * @hooked 		customize_register
	 * @see			add_action( 'customize_register', $func )
	 * @link 		http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
	 * @since 		1.0.0
	 * @param 		WP_Customize_Manager 		$wp_customize 		Theme Customizer object.
	 */
	public function register_fields( $wp_customize ) {

		// Enable live preview JS for default fields
		$wp_customize->get_setting( 'blogname' )->transport 		= 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport 	= 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';



		// Site Identity Section Fields

		// Google Tag Manager ID Field
		$wp_customize->add_setting(
			'tag_manager_id',
			array(
				'capability' 		=> 'edit_theme_options',
				'default'  			=> '',
				'sanitize_callback' => 'sanitize_text_field',
				'transport' 		=> 'postMessage',
				'type' 				=> 'theme_mod'
			)
		);
		$wp_customize->add_control(
			'tag_manager_id',
			array(
				'active_callback' 	=> '',
				'description' 		=> esc_html__( 'Enter the Google Tag Manager container ID.', 'westcpa' ),
				'label'  			=> esc_html__( 'Google Tag Manager ID', 'westcpa' ),
				'priority' 			=> 10,
				'section'  			=> 'title_tagline',
				'settings' 			=> 'tag_manager_id',
				'type' 				=> 'text'
			)
		);
		$wp_customize->get_setting( 'tag_manager_id' )->transport = 'postMessage';


		// Tablet Menu Field
		$wp_customize->add_setting(
			'tablet_menu',
			array(
				'capability' 		=> 'edit_theme_options',
				'default'  			=> '',
				'sanitize_callback' => 'sanitize_text_field',
				'transport' 		=> 'postMessage',
				'type' 				=> 'theme_mod'
			)
		);
		$wp_customize->add_control(
			'tablet_menu',
			array(
				'active_callback' 	=> '',
				'choices' 			=> array(
					'tablet-slide-ontop-from-left' 		=> esc_html__( 'Slide On Top from Left', 'westcpa' ),
					'tablet-slide-ontop-from-right' 	=> esc_html__( 'Slide On Top from Right', 'westcpa' ),
					'tablet-slide-ontop-from-top' 		=> esc_html__( 'Slide On Top from Top', 'westcpa' ),
					'tablet-slide-ontop-from-bottom' 	=> esc_html__( 'Slide On Top from Bottom', 'westcpa' ),
					'tablet-push-from-left' 			=> esc_html__( 'Push In from Left', 'westcpa' ),
					'tablet-push-from-right' 			=> esc_html__( 'Push In from Right', 'westcpa' ),
				),
				'description' 		=> esc_html__( 'Select how the tablet menu appears.', 'westcpa' ),
				'label'  			=> esc_html__( 'Tablet Menu', 'westcpa' ),
				'priority' 			=> 10,
				'section'  			=> 'tablet_menu',
				'settings' 			=> 'tablet_menu',
				'type' 				=> 'select'
			)
		);
		$wp_customize->get_setting( 'tablet_menu' )->transport = 'postMessage';
		
		
		
		// Images Fields
		
		// Default Featured Image Field
		$wp_customize->add_setting(
			'default_featured_image' ,
			array(
				'capability' 			=> 'edit_theme_options',
				'default'  				=> '',
				'sanitize_callback' 	=> 'esc_url_raw',
				'transport' 			=> 'postMessage',
				'type' 					=> 'theme_mod'
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Media_Control(
				$wp_customize,
				'default_featured_image',
				array(
					'active_callback' 	=> '',
					'description' 		=> esc_html__( '', 'westcpa' ),
					'label' 			=> esc_html__( 'Default Featured Image', 'westcpa' ),
					'priority' 			=> 10,
					'section' 			=> 'images',
					'settings' 			=> 'default_featured_image'
				)
			)
		);
		
		
		
		// Footer Locations Label Field
		$wp_customize->add_setting(
			'footer_locs_label',
			array(
				'default'  			=> '',
				'sanitize_callback' => 'sanitize_text_field',
				'transport' 		=> 'postMessage'
			)
		);
		$wp_customize->add_control(
			'footer_locs_label',
			array(
				'description' 	=> esc_html__( '', 'westcpa' ),
				'label'  	=> esc_html__( 'Footer Locations Label', 'westcpa' ),
				'priority' => 10,
				'section'  	=> 'footer',
				'settings' 	=> 'footer_locs_label',
				'type' 		=> 'text'
			)
		);
		$wp_customize->get_setting( 'footer_locs_label' )->transport = 'postMessage';






		// Register more fields here.

	} // register_fields()

	/**
	 * This will generate a line of CSS for use in header output. If the setting
	 * ($mod_name) has no defined value, the CSS will not be output.
	 *
	 * @access 		public
	 * @since 		1.0.0
	 * @see 		header_output()
	 * @param 		string 		$selector 		CSS selector
	 * @param 		string 		$style 			The name of the CSS *property* to modify
	 * @param 		string 		$mod_name 		The name of the 'theme_mod' option to fetch
	 * @param 		string 		$prefix 		Optional. Anything that needs to be output before the CSS property
	 * @param 		string 		$postfix 		Optional. Anything that needs to be output after the CSS property
	 * @param 		bool 		$echo 			Optional. Whether to print directly to the page (default: true).
	 * @return 		string 						Returns a single line of CSS with selectors and a property.
	 */
	public function generate_css( $selector, $style, $mod_name, $prefix = '', $postfix = '', $echo = true ) {

		$return = '';
		$mod 	= get_theme_mod( $mod_name );
		
		if ( empty( $mod ) ) { return; }

		$return = sprintf('%s { %s:%s; }',
			$selector,
			$style,
			$prefix . $mod . $postfix
		);

		if ( $echo ) {

			echo $return;
			return;

		}

		return $return;

	} // generate_css()

	/**
	 * This will output the custom WordPress settings to the live theme's WP head.
	 *
	 * @hooked 		wp_head
	 * @access 		public
	 * @see 		add_action( 'wp_head', $func )
	 * @since 		1.0.0
	 */
	public function header_output() {

		?><!-- Customizer CSS -->
		<style type="text/css"><?php

			// pattern:
			// $this->generate_css( 'selector', 'style', 'mod_name', 'prefix', 'postfix', true );
			//
			// background-image example:
			// $this->generate_css( '.class', 'background-image', 'background_image_example', 'url(', ')' );

		?></style><!-- Customizer CSS --><?php

		/**
		 * Hides all but the first Soliloquy slide while using Customizer previewer.
		 */
		if ( is_customize_preview() ) {

			?><style type="text/css">

				li.soliloquy-item:not(:first-child) {
					display: none !important;
				}

			</style><!-- Customizer CSS --><?php

		}

	} // header_output()

	/**
	 * Returns TRUE based on which link type is selected, otherwise FALSE
	 *
	 * @param 	object 		$control 			The control object
	 * @return 	bool 							TRUE if conditions are met, otherwise FALSE
	 */
	public function states_of_country_callback( $control ) {

		$country_setting = $control->manager->get_setting('country')->value();

		if ( 'us_state' === $control->id && 'US' === $country_setting ) { return true; }
		if ( 'canada_state' === $control->id && 'CA' === $country_setting ) { return true; }
		if ( 'australia_state' === $control->id && 'AU' === $country_setting ) { return true; }
		if ( 'default_state' === $control->id && ! $this->custom_countries( $country_setting ) ) { return true; }

		return false;

	} // states_of_country_callback()

	/**
	 * Returns true if a country has a custom select menu
	 *
	 * @param 		string 		$country 			The country code to check
	 * @return 		bool 							TRUE if the code is in the array, FALSE otherwise
	 */
	public function custom_countries( $country ) {

		$countries = array( 'US', 'CA', 'AU' );

		return in_array( $country, $countries );

	} // custom_countries()

	/**
	 * Returns an array of countries or a country name.
	 *
	 * @param 		string 		$country 		Country code to return (optional)
	 * @return 		array|string 				Array of countries or a single country name
	 */
	public function country_list( $country = '' ) {

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

	} // country_list()

	/**
	 * Loads files for Custom Controls.
	 *
	 * @hooked
	 */
	public function load_customize_controls() {

		$files[] = 'control-editor.php';
		$files[] = 'control-layout-picker.php';
		$files[] = 'control-multiple-checkboxes.php';
		$files[] = 'control-select-category.php';
		$files[] = 'control-select-menu.php';
		$files[] = 'control-select-post.php';
		$files[] = 'control-select-post-type.php';
		//$files[] = 'control-select-recent-post.php';
		$files[] = 'control-select-tag.php';
		$files[] = 'control-select-taxonomy.php';
		$files[] = 'control-select-user.php';

		foreach ( $files as $file ) {

			require_once( trailingslashit( get_stylesheet_directory() ) . 'classes/customizer/' . $file );

		}

	} // load_customize_controls()

	/**
	 * Returns an array of the Australian states and Territories.
	 * The optional parameters allows for returning just one state.
	 *
	 * @param 		string 		$state 		The state to return.
	 * @return 		array 					An array containing states.
	 */
	private function states_list_australia( $state = '' ) {

		$states = array();

		$states['ACT'] = esc_html__( 'Australian Capital Territory', 'westcpa' );
		$states['NSW'] = esc_html__( 'New South Wales', 'westcpa' );
		$states['NT' ] = esc_html__( 'Northern Territory', 'westcpa' );
		$states['QLD'] = esc_html__( 'Queensland', 'westcpa' );
		$states['SA' ] = esc_html__( 'South Australia', 'westcpa' );
		$states['TAS'] = esc_html__( 'Tasmania', 'westcpa' );
		$states['VIC'] = esc_html__( 'Victoria', 'westcpa' );
		$states['WA' ] = esc_html__( 'Western Australia', 'westcpa' );

		if ( ! empty( $state ) ) {

			return $states[$state];

		}

		return $states;

	} // states_list_australia()



	/**
	 * Returns an array of the Canadian states and Territories.
	 * The optional parameters allows for returning just one state.
	 *
	 * @param 		string 		$state 		The state to return.
	 * @return 		array 					An array containing states.
	 */
	private function states_list_canada( $state = '' ) {

		$states = array();

		$states['AB'] = esc_html__( 'Alberta', 'westcpa' );
		$states['BC'] = esc_html__( 'British Columbia', 'westcpa' );
		$states['MB'] = esc_html__( 'Manitoba', 'westcpa' );
		$states['NB'] = esc_html__( 'New Brunswick', 'westcpa' );
		$states['NL'] = esc_html__( 'Newfoundland and Labrador', 'westcpa' );
		$states['NT'] = esc_html__( 'Northwest Territories', 'westcpa' );
		$states['NS'] = esc_html__( 'Nova Scotia', 'westcpa' );
		$states['NU'] = esc_html__( 'Nunavut', 'westcpa' );
		$states['ON'] = esc_html__( 'Ontario', 'westcpa' );
		$states['PE'] = esc_html__( 'Prince Edward Island', 'westcpa' );
		$states['QC'] = esc_html__( 'Quebec', 'westcpa' );
		$states['SK'] = esc_html__( 'Saskatchewan', 'westcpa' );
		$states['YT'] = esc_html__( 'Yukon', 'westcpa' );

		if ( ! empty( $state ) ) {

			return $states[$state];

		}

		return $states;

	} // states_list_canada()

	/**
	 * Returns an array of the US states and Territories.
	 * The optional parameters allows for returning just one state.
	 *
	 * @param 		string 		$state 		The state to return.
	 * @return 		array 					An array containing states.
	 */
	private function states_list_unitedstates( $state = '' ) {

		$states = array();

		$states['AL'] = esc_html__( 'Alabama', 'westcpa' );
		$states['AK'] = esc_html__( 'Alaska', 'westcpa' );
		$states['AZ'] = esc_html__( 'Arizona', 'westcpa' );
		$states['AR'] = esc_html__( 'Arkansas', 'westcpa' );
		$states['CA'] = esc_html__( 'California', 'westcpa' );
		$states['CO'] = esc_html__( 'Colorado', 'westcpa' );
		$states['CT'] = esc_html__( 'Connecticut', 'westcpa' );
		$states['DE'] = esc_html__( 'Delaware', 'westcpa' );
		$states['DC'] = esc_html__( 'District of Columbia', 'westcpa' );
		$states['FL'] = esc_html__( 'Florida', 'westcpa' );
		$states['GA'] = esc_html__( 'Georgia', 'westcpa' );
		$states['HI'] = esc_html__( 'Hawaii', 'westcpa' );
		$states['ID'] = esc_html__( 'Idaho', 'westcpa' );
		$states['IL'] = esc_html__( 'Illinois', 'westcpa' );
		$states['IN'] = esc_html__( 'Indiana', 'westcpa' );
		$states['IA'] = esc_html__( 'Iowa', 'westcpa' );
		$states['KS'] = esc_html__( 'Kansas', 'westcpa' );
		$states['KY'] = esc_html__( 'Kentucky', 'westcpa' );
		$states['LA'] = esc_html__( 'Louisiana', 'westcpa' );
		$states['ME'] = esc_html__( 'Maine', 'westcpa' );
		$states['MD'] = esc_html__( 'Maryland', 'westcpa' );
		$states['MA'] = esc_html__( 'Massachusetts', 'westcpa' );
		$states['MI'] = esc_html__( 'Michigan', 'westcpa' );
		$states['MN'] = esc_html__( 'Minnesota', 'westcpa' );
		$states['MS'] = esc_html__( 'Mississippi', 'westcpa' );
		$states['MO'] = esc_html__( 'Missouri', 'westcpa' );
		$states['MT'] = esc_html__( 'Montana', 'westcpa' );
		$states['NE'] = esc_html__( 'Nebraska', 'westcpa' );
		$states['NV'] = esc_html__( 'Nevada', 'westcpa' );
		$states['NH'] = esc_html__( 'New Hampshire', 'westcpa' );
		$states['NJ'] = esc_html__( 'New Jersey', 'westcpa' );
		$states['NM'] = esc_html__( 'New Mexico', 'westcpa' );
		$states['NY'] = esc_html__( 'New York', 'westcpa' );
		$states['NC'] = esc_html__( 'North Carolina', 'westcpa' );
		$states['ND'] = esc_html__( 'North Dakota', 'westcpa' );
		$states['OH'] = esc_html__( 'Ohio', 'westcpa' );
		$states['OK'] = esc_html__( 'Oklahoma', 'westcpa' );
		$states['OR'] = esc_html__( 'Oregon', 'westcpa' );
		$states['PA'] = esc_html__( 'Pennsylvania', 'westcpa' );
		$states['RI'] = esc_html__( 'Rhode Island', 'westcpa' );
		$states['SC'] = esc_html__( 'South Carolina', 'westcpa' );
		$states['SD'] = esc_html__( 'South Dakota', 'westcpa' );
		$states['TN'] = esc_html__( 'Tennessee', 'westcpa' );
		$states['TX'] = esc_html__( 'Texas', 'westcpa' );
		$states['UT'] = esc_html__( 'Utah', 'westcpa' );
		$states['VT'] = esc_html__( 'Vermont', 'westcpa' );
		$states['VA'] = esc_html__( 'Virginia', 'westcpa' );
		$states['WA'] = esc_html__( 'Washington', 'westcpa' );
		$states['WV'] = esc_html__( 'West Virginia', 'westcpa' );
		$states['WI'] = esc_html__( 'Wisconsin', 'westcpa' );
		$states['WY'] = esc_html__( 'Wyoming', 'westcpa' );
		$states['AS'] = esc_html__( 'American Samoa', 'westcpa' );
		$states['AA'] = esc_html__( 'Armed Forces America (except Canada)', 'westcpa' );
		$states['AE'] = esc_html__( 'Armed Forces Africa/Canada/Europe/Middle East', 'westcpa' );
		$states['AP'] = esc_html__( 'Armed Forces Pacific', 'westcpa' );
		$states['FM'] = esc_html__( 'Federated States of Micronesia', 'westcpa' );
		$states['GU'] = esc_html__( 'Guam', 'westcpa' );
		$states['MH'] = esc_html__( 'Marshall Islands', 'westcpa' );
		$states['MP'] = esc_html__( 'Northern Mariana Islands', 'westcpa' );
		$states['PR'] = esc_html__( 'Puerto Rico', 'westcpa' );
		$states['PW'] = esc_html__( 'Palau', 'westcpa' );
		$states['VI'] = esc_html__( 'Virgin Islands', 'westcpa' );

		if ( ! empty( $state ) ) {

			return $states[$state];

		}

		return $states;

	} // states_list_unitedstates()

} // class

/**
 * Sanitizes the input for the Google Analytics code field.
 * 
 * @param 		mixed 		$input 		The field input.
 * @return 		mixed 					The sanitized input.
 */
function westcpa_sanitize_analytics_code( $input ) {
	
	return stripslashes( wp_filter_post_kses( $input ) );
	
} // westcpa_sanitize_analytics_code()
