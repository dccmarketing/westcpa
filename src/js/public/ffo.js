/**

 * ffo.js
 *
 * Initializes Font Face Observer script.
 */
( function() {

	var openSans = new FontFaceObserver( 'Open Sans' );
	
	openSans.load().then(function () {
		document.documentElement.className += " openSans-loaded";
	});

} )();
