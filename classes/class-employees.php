<?php

/**
 * A class to customize the Employees plugin
 *
 * @package West_CPA
 * @author DCC Marketing <web@dccmarketing.com>
 */
class westcpa_Employees {

	/**
	 * Constructor
	 */
	public function __construct() {} // __construct()

	/**
	 * Loads all filter and action calls
	 */
	public function hooks() {

		//$templates = Employees_Templates::this();

		add_filter( 'employees-field-honorific-suffix', array( $this, 'add_suffix_honorifics' ), 10, 1 );

	} // hooks()

	public function add_suffix_honorifics( $atts ) {

		$atts['selections'][] 		= array( 'value' => 'CPA', 'label' => esc_html__( 'CPA', 'employees' ) );
		$atts['selections'][] 		= array( 'value' => 'CFPA', 'label' => esc_html__( 'CFPA', 'employees' ) );
		$atts['selections'][] 		= array( 'value' => 'CPA, CFPA', 'label' => esc_html__( 'CPA, CFPA', 'employees' ) );
		$atts['selections'][] 		= array( 'value' => 'CPA, CFE, CSEP', 'label' => esc_html__( 'CPA, CFE, CSEP', 'employees' ) );

		//showme( $atts );

		return $atts;

	} // add_suffix_honorifics()

} // class
