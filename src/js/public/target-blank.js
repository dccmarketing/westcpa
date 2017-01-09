/**
 * target-blank.js
 *
 * Adds the target-blank class to all links with the attribute target="_blank".
 */
( function() {
	
	var links = document.querySelectorAll( '[target="_blank"]' );
	
	if ( 0 === links.length ) { return; }
	
	for ( var l = 0; l < links.length; l++ ) {
		
		links[l].classList.add( 'target-blank' );
		
	}
	
} )();