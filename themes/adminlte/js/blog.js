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
		
		$('.btnReset').click(function() {
			$('#postsearch-key, #postsearch-minrating').val('');
			$("#postsearch-searchtags").select2("val", "");
			$('.search-form form').submit();
		});
	}
	
};

// merge module code to app object
if (typeof app==='undefined') app = {};
app = $.extend(app, module);