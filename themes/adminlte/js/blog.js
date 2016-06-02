/*
 * javascript for blog module
 */
var module ={
	
	setupBlogPage: function (val) {
		app.setupAjaxForm('form');
		app.setupAjaxLink('.pagination a');
		$('.post-content img').addClass('img-responsive');
		// setup bootstrap affix
		$('#post-nav').affix({
			offset: { top: 525 }
		});
		
		// setup bootstrap scrollby
		$('body').css('position', 'relative');
		$('body').scrollspy({ target: '#post-nav' });
	}
	
};

// merge module code to app object
if (typeof app==='undefined') app = {};
app = $.extend(app, module);