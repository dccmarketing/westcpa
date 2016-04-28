<?php
/**
 * The sidebar for the Sidrbar Content page template
 *
 * @package DocBlock
 */

if ( ! is_active_sidebar( 'sidebar-left' ) ) { return; }

/**
 * The tha_sidebars_before action hook
 */
do_action( 'tha_sidebars_before' );

?><aside id="secondary" class="widget-area sidebar-left" role="complementary"><?php

	/**
	 * The tha_sidebar_top action hook
	 */
	do_action( 'tha_sidebar_top' );

	dynamic_sidebar( 'sidebar-left' );

	/**
	 * The tha_sidebar_bottom action hook
	 */
	do_action( 'tha_sidebar_bottom' );

?></aside><!-- #secondary --><?php

/**
 * The tha_sidebars_after action hook
 */
do_action( 'tha_sidebars_after' );