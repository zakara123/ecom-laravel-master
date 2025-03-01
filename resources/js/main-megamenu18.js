jQuery(document).ready(function($){
	//open/close mega-navigation
	$('#mega-menu-mobile .cd-dropdown-trigger').on('click', function(event){
		event.preventDefault();
		toggleNav();
	});

	/*$('#mega-menu-desktop .cd-dropdown-trigger').on('click', function(event){
		event.preventDefault();
		toggleNavCurrent($(this));
	});*/


	/*function toggleNavCurrent(current){
		var navIsVisible = ( !current.parent().find('.cd-dropdown').hasClass('dropdown-is-active') ) ? true : false;
		if (navIsVisible) {
			$('.cd-dropdown').removeClass('dropdown-is-active');
			$('.cd-dropdown-trigger').removeClass('dropdown-is-active');
		}
		current.parent().find('.cd-dropdown').toggleClass('dropdown-is-active', navIsVisible);
		current.toggleClass('dropdown-is-active', navIsVisible);
		if( !navIsVisible ) {
			current.parent().find('.cd-dropdown').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend',function(){
				current.parent().find('.has-children ul').addClass('is-hidden');
				current.parent().find('.is-active').removeClass('is-active');
			});
		}
	}*/

	//close meganavigation
	/*$('#mega-menu-desktop .cd-dropdown .cd-close').on('click', function(event){
		event.preventDefault();
		toggleNavCurrent();
	});*/
	$('#mega-menu-mobile .cd-dropdown .cd-close').on('click', function(event){
		event.preventDefault();
		toggleNav();
	});

	//on mobile - open submenu
	/*$('#mega-menu-desktop .has-children').children('a').on('click', function(event){
		//prevent default clicking on direct children of .has-children 
		event.preventDefault();
		var selected = $(this);
		selected.next('ul').removeClass('is-hidden');
	});*/
	$('#mega-menu-mobile .has-children').children('a').on('click', function(event){
		event.preventDefault();
		var selected = $(this);
		selected.next('ul').removeClass('is-hidden').end().parent('.has-children').parent('ul').addClass('move-out');
	});

	//on desktop - differentiate between a user trying to hover over a dropdown item vs trying to navigate into a submenu's contents
	var submenuDirection = ( !$('.cd-dropdown-wrapper').hasClass('open-to-left') ) ? 'right' : 'left';
	$('#mega-menu-desktop .cd-dropdown-content').menuAim({
		activate: function(row) {
			$(row).children().addClass('is-active').removeClass('fade-out');
			if( $('.cd-dropdown-content .fade-in').length == 0 ) $(row).children('ul').addClass('fade-in');
		},
		deactivate: function(row) {
			$(row).children().removeClass('is-active');
			if( $('li.has-children:hover').length == 0 || $('li.has-children:hover').is($(row)) ) {
				$('.cd-dropdown-content').find('.fade-in').removeClass('fade-in');
				$(row).children('ul').addClass('fade-out')
			}
		},
		exitMenu: function() {
			$('.cd-dropdown-content').find('.is-active').removeClass('is-active');
			return true;
		},
	});

	$('#mega-menu-mobile .cd-dropdown-content').menuAim({
		activate: function(row) {
			$(row).children().addClass('is-active').removeClass('fade-out');
			if( $('.cd-dropdown-content .fade-in').length == 0 ) $(row).children('ul').addClass('fade-in');
		},
		deactivate: function(row) {
			$(row).children().removeClass('is-active');
			if( $('li.has-children:hover').length == 0 || $('li.has-children:hover').is($(row)) ) {
				$('.cd-dropdown-content').find('.fade-in').removeClass('fade-in');
				$(row).children('ul').addClass('fade-out')
			}
		},
		exitMenu: function() {
			$('.cd-dropdown-content').find('.is-active').removeClass('is-active');
			return true;
		},
		submenuDirection: submenuDirection,
	});

	//submenu items - go back link
	$('#mega-menu-desktop .go-back').on('click', function(){
		var selected = $(this),
			visibleNav = $(this).parent('ul').parent('.has-children').parent('ul');
		selected.parent('ul').addClass('is-hidden');
	});

	$('#mega-menu-mobile .go-back').on('click', function(){
		var selected = $(this),
			visibleNav = $(this).parent('ul').parent('.has-children').parent('ul');
			selected.parent('ul').addClass('is-hidden').parent('.has-children').parent('ul').removeClass('move-out');
	});

	function toggleNav(){
		var navIsVisible = ( !$('.cd-dropdown').hasClass('dropdown-is-active') ) ? true : false;
		$('.cd-dropdown').toggleClass('dropdown-is-active', navIsVisible);
		$('.cd-dropdown-trigger').toggleClass('dropdown-is-active', navIsVisible);
		if( !navIsVisible ) {
			$('.cd-dropdown').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend',function(){
				$('.has-children ul').addClass('is-hidden');
				$('.move-out').removeClass('move-out');
				$('.is-active').removeClass('is-active');
			});
		}
	}

	//IE9 placeholder fallback
	//credits http://www.hagenburger.net/BLOG/HTML5-Input-Placeholder-Fix-With-jQuery.html
	if(!Modernizr.input.placeholder){
		$('[placeholder]').focus(function() {
			var input = $(this);
			if (input.val() == input.attr('placeholder')) {
				input.val('');
			}
		}).blur(function() {
			var input = $(this);
			if (input.val() == '' || input.val() == input.attr('placeholder')) {
				input.val(input.attr('placeholder'));
			}
		}).blur();
		$('[placeholder]').parents('form').submit(function() {
			$(this).find('[placeholder]').each(function() {
				var input = $(this);
				if (input.val() == input.attr('placeholder')) {
					input.val('');
				}
			})
		});
	}
});