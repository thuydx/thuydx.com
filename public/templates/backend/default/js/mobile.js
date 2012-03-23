/**
 * Template JS for mobile pages
 */

(function($)
{
	$(document).ready(function()
	{
		// Menu
		var menu = $('#menu > ul'),
			menuHeight = menu.height(),
			currentMenu = menu;
		
		// Open
		$('#menu > a').click(function(event)
		{
			event.preventDefault();
			
			var parent = $(this).parent();
			if (parent.hasClass('active'))
			{
				menu.css({
					display: '',
					height: menuHeight
				});
			}
			parent.toggleClass('active');
		});
		
		// Menus with sub-menus
		$('#menu ul li:has(ul)').addClass('with-subs').children('a').click(function(event)
		{
			// Stop link
			event.preventDefault();
			
			// Show sub-menu
			var li = $(this).parent();
			li.addClass('active').siblings().removeClass('active');
			
			// Scroll
			currentMenu = li.children('ul:first');
			menu.animate({
				scrollLeft:	currentMenu.offset().left+menu.scrollLeft(),
				height:		currentMenu.height()
			});
		})
		.siblings('ul').prepend('<li class="back"><a href="#">Back</a></li>')
		.find('li.back > a').click(function(event)
		{
			// Stop link
			event.preventDefault();
			
			// Prepare
			var li = $(this).parent().parent().parent();
			currentMenu = li.parent();
			var isRoot = (currentMenu.parent().attr('id') == 'menu'),
				scrollVal = isRoot ? currentMenu.offset().left : currentMenu.offset().left+menu.scrollLeft(),
				newHeight = isRoot ? menuHeight : currentMenu.height();
			
			// Animate
			menu.animate({
				scrollLeft:	scrollVal,
				height:		newHeight
			}, {
				complete: function()
				{
					// Close sub-menu
					li.removeClass('active');
				}
			});
		});
		
		// Watch for screen orientation change
		$(window).bind('orientationchange resize', function()
		{
			// Prepare
			var isRoot = (currentMenu.parent().attr('id') == 'menu'),
				scrollVal = isRoot ? currentMenu.offset().left : currentMenu.offset().left+menu.scrollLeft();
			
			menu.scrollLeft(scrollVal);
		});
	});

})(jQuery);