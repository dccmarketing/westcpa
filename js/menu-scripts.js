/**
 * Opens the current page's submenu. When hovering over another top-level
 * menu item, it closes the current page's submenu and opens the other.
 *
 * Only operates if the current menu item is defined (so not on the homepage).
 */

( function( $ ) {

	$( ".menu-item-has-children" ).each( function() {

		var parent, wrap, submenu, clicker;

		parent = $(this);
		wrap = parent.children( '.wrap-submenu' );
		submenu = wrap.children( ".sub-menu" );
		clicker = parent.children( ".show-hide" );

		enquire.register( "screen and (max-width: 1023px)" , {
			match: function() {
				if ( ! parent.hasClass( "open" ) ) {

					clicker.click( function( event ) {

						event.preventDefault();

						submenu.slideToggle(250);
						parent.toggleClass( "open" );

						if ( parent.hasClass( "open" ) ) {

							clicker.html("-");

						} else {

							clicker.html("+");

						}

					});

				} // if
			},
			unmatch: function() {
				submenu.attr( 'style', '' );
			}
		}); // enquire
	}); // each

} )( jQuery );