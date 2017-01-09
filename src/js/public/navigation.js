/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation suypport for dropdown menus.
 */
( function() {

	var container = document.querySelector( '#site-navigation' );
	if ( ! container ) { return; }

	var menu = container.querySelector( '#primary-menu' );

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {

		var button = container.querySelector( '.menu-primary-toggle' );

		button.style.display = 'none';

		return;

	}

	menu.setAttribute( 'aria-expanded', 'false' );



	/**
	 * Processes the event and call the correct
	 * action based on the event target.
	 *
	 * @param 		object 		event 		The event.
	 */
	function clickEvent( event ) {

		var target = getEventTarget( event );

		event.stopPropagation();
		event.cancelBubble = true;

		if ( target.matches( '.menu-primary-toggle' ) ) {

			toggleMenu( event, target );

		}

		if ( target.matches( '.close-tablet-menu-btn' ) ) {

			toggleMenu( event, target );

		}

		if ( target.matches( '.sub-menu' ) ) {

			toggleAttribute( target, 'aria-haspopup', 'true' );

		}

		if ( target.matches( '.menu-primary-submenu-toggle' ) ) {

			openSubmenu( event, target );

		}

	} // clickEvent()

	/**
	 * Returns the event target.
	 *
	 * @param 		object 		event 		The event.
	 * @return 		object 		target 		The event target.
	 */
	function getEventTarget( event ) {

		event = event || window.event;

		return event.target || event.srcElement;

	} // getEventTarget()

	/**
	 * Returns the parent node with the requested class.
	 *
	 * This is recursive, so it will continue up the DOM tree
	 * until the correct parent is found.
	 *
	 * @param 		object 		el 				The node element.
	 * @param 		string 		className 		Name of the class to find.
	 * @return 		object 						The parent element.
	 */
	function getParent( el, className ) {

		var parent = el.parentNode;

		if ( '' !== parent.classList && parent.classList.contains( className ) ) {

			return parent;

		}

		return getParent( parent, className );

	} // getParent()

	/**
	 * Opens the submenu on mobile and tablets.
	 * Toggles the open class on the menuItem.
	 * Toggles the closed class on subMenu.
	 * Toggles -/+ on the target.
	 *
	 * @param 		object 		event 		The event.
	 * @param 		object 		target 		The event target.
	 */
	function openSubmenu( event, target ) {

		event.preventDefault();

		var menuItem 	= getParent( target, 'menu-item' );
		//var subMenu 	= menuItem.querySelector( '.wrap-submenu' );
		var subMenu 	= menuItem.querySelector( '.primary-menu-items' );
		if ( ! subMenu ) { return; }

		subMenu.classList.toggle( 'primary-menu-items-closed' );
		menuItem.classList.toggle( 'primary-menu-items-open' );

		if ( target.classList.contains( 'primary-menu-items-open' ) ) {

			target.innerHTML = '-';

		} else {

			target.innerHTML = '+';

		}

	} // openSubmenu()

	/**
	 * Toggles the value of an attribute.
	 *
	 * @param 		object 		element 		The element to affect.
	 * @param 		string 		attribute 		The attribute name.
	 * @param 		mixed 		newValue 		The new value.
	 */
	function toggleAttribute( element, attribute, newValue ) {

		var value = element.getAttribute( attribute );

		if ( newValue === value ) { return; }

		element.setAttribute( attribute, newValue );

	} // toggleAttribute()

	/**
	 * Sets or removes .focus class on an element and its parent list items.
	 *
	 * @param 		object 		event 		The event.
	 */
	function toggleFocus( event ) {

		var target = getEventTarget( event );

		event.stopPropagation();
		event.cancelBubble = true;

		if ( target.classList.contains( 'nav-menu' ) ) { return; }

		if ( 'li' === target.tagName.toLowerCase() ) {

			target.classList.toggle( 'focus' );

		} else {

			toggleFocus( event, target.parentNode );

		}

	} // toggleFocus()

	/**
	 * Toggles menu open and closed.
	 *
	 * @param 		object 		event 		The event.
	 * @param 		object 		target 		The event target.
	 */
	function toggleMenu( event, target ) {

		container.classList.toggle( 'nav-primary-open' );

		if ( container.classList.contains( 'nav-primary-open' ) ) {

			toggleAttribute( menu, 'aria-expanded', 'true' );
			toggleAttribute( target, 'aria-expanded', 'true' );

		} else {

			toggleAttribute( menu, 'aria-expanded', 'false' );
			toggleAttribute( target, 'aria-expanded', 'false' );

		}

		var body = document.querySelector( 'body' );

		body.classList.toggle( 'tablet-menu-open' );

	} // toggleMenu()

	/**
	 * Removes the focus class from each sibling link.
	 *
	 * @param 		object 		event 		The event.
	 * @return {[type]}        [description]
	 */
	function touchStart( event ) {

		var target = getEventTarget( event );

		if ( ! target.matches( '.menu-item-has-children > a' ) && ! target.matches( '.page_item_has_children > a' ) ) { return; }

		event.stopPropagation();
		event.cancelBubble = true;

		event.preventDefault();

		var menuItem = target.parentNode;

		for ( var i = 0; i < menuItem.parentNode.children.length; ++i ) {

			if ( menuItem === menuItem.parentNode.children[i] ) { continue; }

			menuItem.parentNode.children[i].classList.remove( 'focus' );

		}

		menuItem.classList.toggle( 'focus' );

	} // touchStart()

	container.addEventListener( 'click', clickEvent );
	container.addEventListener( 'focus', toggleFocus );
	container.addEventListener( 'blur', toggleFocus );
	container.addEventListener( 'touchstart', touchStart );

} )();
