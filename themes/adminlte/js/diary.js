/*
 * javascript for common funtion in backend
 */
var module ={
	setupDiaryPage: function() {
		$('#act-modal').on('shown.bs.modal', function (event) {
			var button = $(event.relatedTarget); // Button that triggered the modal
			var actId = button.data('act-id'); // Extract info from data-* attributes
			if (typeof actId === 'undefined')
				return;		// in case modal is launched by code
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


		$('#del-modal').on('shown.bs.modal', function (event) {
			var button = $(event.relatedTarget); // Button that triggered the modal
			var actId = button.data('act-id'); // Extract info from data-* attributes
			var data = app.activities[actId];
			var modal = $(this);
			modal.find('.act-id').val(actId);
			modal.find('.modal-title').text('Delete '+data.title);
		});

		$('[data-toggle=popover]').popover();
		
		function updateDateRangeVisibility() {
			if ($('.date-range').val()=='custom') {
				$('.from-date, .to-date').removeClass('hide');
			} else {
				$('.from-date, .to-date').addClass('hide');
			}
		}
		
		$('.content-wrapper').on('change', '.date-range', updateDateRangeVisibility);
		updateDateRangeVisibility();
		app.setupAjaxForm('form');
		app.setupAjaxLink('.pagination a');
	},
	
	activities: {},
	
	setActivityData: function (val) {
		app.activities[val.id] = val;
	}
	
};

// merge module code to app object
if (typeof app==='undefined') app = {};
app = $.extend(app, module);