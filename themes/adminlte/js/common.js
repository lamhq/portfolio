/*
 * javascript for common funtion in backend
 */
var module ={
	/*
	 * get page by ajax (do not submit any data to server)
	 */
	loadPage: function(url) {
		app.showLoading();
		$.ajax({
			url: url ? url : window.location.href,
			type: 'GET',
			data: '',
			success: app.onSuccess,
			error: app.onError
		});
	},

	/*
	 * submit form data to url and update page content
	 */
	submitForm: function(form) {
		var action =  $(form).attr('action');
		var data =  $(form).serialize();
		app.showLoading();
		$.ajax({
			type: 'POST',
			url: action,
			data: data,
			success: app.onSuccess,
			error: app.onError
		});
	},

	/*
	 * ajax success, upload page content
	 */
	onSuccess: function(data) {
		var page = $('<div>'+data+'</div>');
		$('.ajax-content').html(page.find('.ajax-content').html());
		$('body').append(page.find('script'));
		window.scrollTo(0,0);
	},

	/*
	 * ajax success, upload page content
	 */
	onError: function(XHR, textStatus, errorThrown) {
		console.log(textStatus);
	},

	/*
	 * show loading animation
	 */
	showLoading: function() {
		$('.ajax-content').prepend('<i class="fa fa-refresh fa-spin fa-2x fa-loading"></i>');
	},

	setupAjaxForm: function(form) {
		var onBeforeSubmit = function(e) {
			e.preventDefault();
			$('.modal').modal('hide');
			app.submitForm(this);
			return false;
		};

		// capture yii activeform event
		$(form).on('beforeSubmit', onBeforeSubmit);
	},

	setupAjaxLink: function(link) {
		$(link).on('click', function(e){
			e.preventDefault();
			app.loadPage(this.href);
		});
	}		
};

// merge module code to app object
if (typeof app==='undefined') app = {};
app = $.extend(app, module);