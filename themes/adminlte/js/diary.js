/*
 * javascript for common funtion in backend
 */
var module ={
	activities: {},
	
	setActivityData: function (val) {
		app.activities[val.id] = val;
	},
	
	setupDiaryPage: function() {
		// create/update activity modal
		$('#act-modal').on('shown.bs.modal', function (event) {
			var button = $(event.relatedTarget); // Button that triggered the modal
			var actId = button.data('act-id'); // Extract info from data-* attributes
			if (typeof actId === 'undefined') return; // in case modal is launched by code
			
			/*
			 * instead of perform an ajax load to get activity data,
			 * i stored a list of activity data in app.activities array
			 * when modal show up, i populated form values with data stored in app.activities
			 */
			var data = app.activities[actId];
			var modal = $(this);
			$('#activity-id').val(data.id);
			$('#activity-note').val(data.note);
			$('#activity-inputtime').val(data.inputTime);
			$('#activity-income').val(data.income);
			$('#activity-outcome').val(data.outcome);
			$('#activity-tagvalues').val(data.tagValues).trigger("change");
			modal.find('.modal-title').text(data.title);
		});

		// delete activity modal
		$('#del-modal').on('shown.bs.modal', function (event) {
			var button = $(event.relatedTarget); // Button that triggered the modal
			var actId = button.data('act-id'); // Extract info from data-* attributes
			var data = app.activities[actId];
			var modal = $(this);
			modal.find('.act-id').val(actId);
			modal.find('.modal-title').text('Delete '+data.title);
		});

		// search
		function updateDateRangeVisibility() {
			if ($('.date-range').val()=='custom') {
				$('.from-date, .to-date').removeClass('hide');
			} else {
				$('.from-date, .to-date').addClass('hide');
			}
		}
		$('.date-range').change(updateDateRangeVisibility);
		updateDateRangeVisibility();

		// instead post submit, submit form by ajax
		// to create/update an activity, we submit activity form (new activity has id = 0)
		// to delete an activity, we submit delete form
		$('form').on('beforeSubmit', function(e) {
			e.preventDefault();
			var form = $(this);
			form.closest('.modal').modal('hide');
			app.loadPage(form.attr('action'), form.serializeArray());
			return false;
		});

		app.setupAjaxLink('.pagination a');
		$('[data-toggle=popover]').popover();
	},
	
	refreshOutComePage: function() {
		var form = $('#filter-form');
		app.loadPage(form.attr('action')+'?'+form.serialize());
	},

	setupOutcomePage: function () {
		$('.not-used').remove();

		// reload page when changing select box
		$('.month-sel, .year-sel').change(app.refreshOutComePage);

		var modal = $('#budget-modal');
		// show form when click add button
		$('.btn-add, .btn-edit').click(function (e) {
			e.preventDefault();
			var body = modal.find('.modal-body');
			var query = '';
			
			// show budget modal
			if (typeof $(this).data('id') === 'undefined') {
				modal.find('.modal-title').text('Add new Budget');
			} else {
				query = 'id='+$(this).data('id');
				modal.find('.modal-title').text('Update Budget');
			}
			body.html('').addClass('loading');
			modal.modal('show');
			// load form by ajax
			body.load(app.baseUrl + '/p/f', query,
				function (data) {
					$('#plan-month').val($('.month-sel').val());
					$('#plan-year').val($('.year-sel').val());
					body.removeClass('loading');
				}
			);
		});

		$('a.btn-delete').on('click', function(e) {
			e.preventDefault();
			var url = this.href;
			app.showModal({
				header: 'Delete',
				content: 'Are you sure to delete this?',
				onOk: function() {
					$.post(url, '', app.refreshOutComePage);
				}
			});
		});
	},

	setupBudgetForm: function () {
		var modal = $('#budget-modal');
		var form = modal.find('form');

		form.on('beforeSubmit', function () {
			modal.modal('hide');
			app.showLoading();
			// submit form by ajax
			$.ajax({
				url: form.attr('action'),
				data: form.serialize()+'&ajax-submit=1',
				type: "post",
				success: app.refreshOutComePage
			});			
			return false;
		});
	}
};

// merge module code to app object
if (typeof app==='undefined') app = {};
app = $.extend(app, module);