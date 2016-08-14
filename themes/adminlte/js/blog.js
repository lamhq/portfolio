/*
 * javascript for blog module
 */
var module ={
	
	setupBlogPage: function (val) {
		// search
		$('form').on('beforeSubmit', function(e) {
			e.preventDefault();
			var form = $(this);
			app.loadPage(form.attr('action'), form.serializeArray());
			return false;
		});
		$('.btnReset').click(function() {
			$('#postsearch-key, #postsearch-minrating').val('');
			$("#postsearch-searchtags").select2("val", "");
			$('.search-form form').submit();
		});
		
		// pagination
		app.setupAjaxLink('.pagination a');
		
		// setup bootstrap affix
		$('#post-nav').affix({
			offset: { top: 525 }
		});
		
		// setup bootstrap scrollby
		$('body').css('position', 'relative');
		$('body').scrollspy({ target: '#post-nav' });
		$('.post-content img').addClass('img-responsive');
	}
	
};

// merge module code to app object
if (typeof app==='undefined') app = {};
app = $.extend(app, module);