/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation suypport for dropdown menus.
 */
( function() {

	/**
	 * Sets or removes .focus class on an element.
	 */
	function toggleFocus() {

		var self = this;

		// Move up through the ancestors of the current link until we hit .nav-menu.
		while ( -1 === self.className.indexOf( 'nav-menu' ) ) {

			// On li elements toggle the class .focus.
			if ( 'li' === self.tagName.toLowerCase() ) {

				if ( -1 !== self.className.indexOf( 'focus' ) ) {

					self.className = self.className.replace( ' focus', '' );

				} else {

					self.className += ' focus';

				}

			}

			self = self.parentElement;
		}
	}

	var container, button, menu, links, subMenus, bod;

	container = document.getElementById( 'site-navigation' );
	if ( ! container ) {

		return;

	}

	button = container.getElementsByTagName( 'button' )[0];
	if ( 'undefined' === typeof button ) {

		return;

	}

	menu = container.getElementsByTagName( 'ul' )[0];

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {

		button.style.display = 'none';

		return;

	}

	menu.setAttribute( 'aria-expanded', 'false' );

	if ( -1 === menu.className.indexOf( 'nav-menu' ) ) {

		menu.className += ' nav-menu';

	}

	/**
	 * Tablet menu - pushing out from left
	 */
	bod = document.getElementsByTagName( 'body' )[0];
	if ( 'undefined' === typeof bod ) {

		return;

	}

	button.onclick = function() {

		if ( -1 !== container.className.indexOf( 'toggled' ) ) {

			container.className = container.className.replace( ' toggled', '' );
			button.setAttribute( 'aria-expanded', 'false' );
			menu.setAttribute( 'aria-expanded', 'false' );

		} else {

			container.className += ' toggled';
			button.setAttribute( 'aria-expanded', 'true' );
			menu.setAttribute( 'aria-expanded', 'true' );

		}

		/**
		 * Tablet menu - pushing out from left
		 */
		if ( -1 !== bod.className.indexOf( 'toggled' ) ) {

			bod.className = bod.className.replace( ' toggled', '' );

		} else {

			bod.className += ' toggled';

		}
	};

	// Get all the link elements within the menu.
	links    = menu.getElementsByTagName( 'a' );
	subMenus = menu.getElementsByTagName( 'ul' );

	// Set menu items with submenus to aria-haspopup="true".
	for ( var i = 0, len = subMenus.length; i < len; i++ ) {

		subMenus[i].parentNode.setAttribute( 'aria-haspopup', 'true' );

	}

	// Each time a menu link is focused or blurred, toggle focus.
	for ( i = 0, len = links.length; i < len; i++ ) {

		links[i].addEventListener( 'focus', toggleFocus, true );
		links[i].addEventListener( 'blur', toggleFocus, true );

	}

} )();
