window.app = {
	/*
	 * hightlight active menu
	 */
	setupMenu: function () {
		var path = window.location.pathname;
		path = path.replace(/\/$/, "");
		path = decodeURIComponent(path).split("?")[0];

		$("#main-nav li > a").each(function () {
			var href = $(this).attr('href').split("?")[0].replace(/\/+$/, '').replace(window.location.origin, '');
			if (path === href) {
				$(this).closest('li').addClass('active');
			}
		});		
	},

	setActiveMenu: function(cssClass) {
		$("#main-nav li."+cssClass).addClass('active');
	}
}