/**
 * hidden-search.js
 *
 * Handles toggling the appearnace of a hidden search field
 */
( function() {

	var index, search, page, button;

	search = document.getElementById( 'hidden-search-top' );
	if ( ! search ) { return; }

	page = document.getElementById( 'page' );
	if ( ! page ) { return; }

	button = document.getElementsByClassName( 'btn-search' )[0];
	if ( ! button ) { return; }

	search.setAttribute( 'aria-hidden', 'true' );

	button.onclick = function( e ) {

		e.preventDefault();

		if ( -1 !== search.className.indexOf( 'open' ) ) {

			search.className = search.className.replace( ' open', '' );
			search.setAttribute( 'aria-hidden', 'true' );

		} else {

			search.className += ' open';
			search.setAttribute( 'aria-hidden', 'false' );

		}

		var affected = [ page, button ];

		for	( index = 0; index < affected.length; index++ ) {

			if ( -1 !== affected[index].className.indexOf( 'open' ) ) {

				affected[index].className = affected[index].className.replace( ' open', '' );

			} else {

				affected[index].className += ' open';

			}

		}

	};

} )();
