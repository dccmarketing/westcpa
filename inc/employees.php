<?php

/**
 * A class to customize the Employees plugin
 *
 * @package West_CPA
 * @author Slushman <chris@slushman.com>
 */
class westcpa_Employees {

	/**
	 * Constructor
	 */
	public function __construct() {

		$this->loader();

	} // __construct()

	/**
	 * Loads all filter and action calls
	 */
	private function loader() {

		$templates = Employees_Templates::this();

		add_filter( 'employees-field-honorific-suffix', array( $this, 'add_suffix_honorifics' ), 10, 1 );

	} // loader()

	public function add_suffix_honorifics( $atts ) {

		$atts['selections'][] 		= array( 'value' => 'CPA', 'label' => esc_html__( 'CPA', 'employees' ) );
		$atts['selections'][] 		= array( 'value' => 'CFPA', 'label' => esc_html__( 'CFPA', 'employees' ) );
		$atts['selections'][] 		= array( 'value' => 'CPA, CFPA', 'label' => esc_html__( 'CPA, CFPA', 'employees' ) );
		$atts['selections'][] 		= array( 'value' => 'CPA, CFE, CSEP', 'label' => esc_html__( 'CPA, CFE, CSEP', 'employees' ) );

		//showme( $atts );

		return $atts;

	} // add_suffix_honorifics()

} // class

/**
 * Make an instance so its ready to be used
 */
$westcpa_employees = new westcpa_Employees();