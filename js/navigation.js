jQuery(document).ready(function ($) {

	var PortfolioPlusJS = {
		'nav' : $('#navigation'),
		'menu' : $('#navigation .nav-menu'),
		'submenu' : false,
	};

	// Enable menu toggle for small screens
	(function() {
		if ( ! PortfolioPlusJS.nav ) {
			return;
		}

		button = PortfolioPlusJS.nav.find('.menu-toggle');
		if ( ! button ) {
			return;
		}

		// Hide button if menu is missing or empty.
		if ( ! PortfolioPlusJS.menu || ! PortfolioPlusJS.menu.children().length ) {
			button.hide();
			return;
		}

		button.on( 'click', function() {
			PortfolioPlusJS.nav.toggleClass('toggled-on');
			PortfolioPlusJS.menu.slideToggle( '200' );
		} );
	})();

	// Centers the submenus directly under the top menu
    function portfolio_desktop_submenus() {
		if ( document.body.clientWidth > 780 && !PortfolioPlusJS.submenu ) {
			PortfolioPlusJS.menu.attr('style','');
			PortfolioPlusJS.nav.find('div > ul > li').each( function() {
				var ul = $(this).find('> ul');
			    if ( ul.length > 0 ) {
			        var parent_width = $(this).outerWidth( true );
			        var child_width = ul.outerWidth( true );
			        var new_width = parseInt((child_width - parent_width)/2);
			        ul.css('margin-left', -new_width + "px");
			    }
			});
			PortfolioPlusJS.submenu = true;
		}
	}

	// Clears submenu alignment for the mobile menu
	function portfolio_mobile_submenus() {
		if ( document.body.clientWidth <= 780 && PortfolioPlusJS.submenu ) {
			PortfolioPlusJS.nav.find('ul').css('margin-left', '');
			PortfolioPlusJS.submenu = false;
		}
	}

	// Fired by the resize event
	function menu_alignment() {
		portfolio_desktop_submenus();
		portfolio_mobile_submenus();
	}

	// Debounce function
	// http://remysharp.com/2010/07/21/throttling-function-calls/
	function debounce(fn, delay) {
		var timer = null;
			return function () {
			var context = this, args = arguments;
			clearTimeout(timer);
			timer = setTimeout(function () {
			  fn.apply(context, args);
			}, delay);
		};
	}

	// If the site title and menu don't fit on the same line, clear the menu
	if ( $('#branding .col-width').width() < ( $('#logo').outerWidth() + PortfolioPlusJS.nav.outerWidth() ) ) {
		$('body').addClass('clear-menu');
	}

	// Menu Alignment
    portfolio_desktop_submenus();

    // Recheck menu alignment on resize
    $(window).on( 'resize', debounce( menu_alignment, 100) );

});