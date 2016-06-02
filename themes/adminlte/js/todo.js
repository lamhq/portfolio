/*
 * javascript for todo module
 */
var module ={
	setupInlineEdit: function () {
		$('body').on('click', '.editable-text', function () {
			$(this).hide();
			$(this).siblings('.editable-input').val($(this).text()).show().focus().select();
		});

		$('body').on('blur', '.editable-input', function () {
			$(this).hide();
			$(this).siblings('.editable-text').show();
		});

		$('body').on('keypress', '.editable-input', function (e) {
			// if enter key
			if ( e.which == 13 ) {
				// hide input
				e.preventDefault();
				$(this).hide();
				$(this).siblings('.editable-text').text($(this).val()).show();
			}
		});
	},

	setupSortable: function () {
		$(".connectedSortable").sortable({
			placeholder: "sort-highlight",
			connectWith: ".connectedSortable",
			handle: ".box-header, .nav-tabs",
			forcePlaceholderSize: true,
			zIndex: 999999
		});
		$(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor", "move");
	},

	setupCheckList: function (todoList) {
		// toggle completed items
		var isShow = true;
		function updateVisibleState() {
			if (isShow) {
				$(todoList).find('li.done').removeClass('hide');
				$('.btn-tog-comp').text('Hide completed');
			} else {
				$(todoList).find('li.done').addClass('hide');
				$('.btn-tog-comp').text('Show completed');
			}
		}

		$('.btn-tog-comp').click(function () {
			isShow = !isShow;
			updateVisibleState();
		});

		function setCompletedTime(checkbox) {
			var li = $(checkbox).closest('li');
			var input = li.find('> .dd-content .completed-time');
			// set/unset the task's completed time
			if ($(checkbox).is(':checked')) {
				if (input.val() != '') return;
				var d = new Date();
				var s = d.getFullYear() +'-'+ 
					(d.getMonth()+1) +'-'+
					d.getDate() +' '+
					d.getHours() + ":" +
					d.getMinutes() + ":" +
					d.getSeconds();
				input.val(s);
			} else {
				input.val('');
			}
		}

		function descendantCascade(checkbox) {
			if (!$(checkbox).is(':checked')) return;

			var li = $(checkbox).closest('li');
			// check all children checkboxes
			$.each(li.find('> ol > li :checkbox'), function() {
				$(this).prop('checked', true);
				descendantCascade(this);
			});
		};

		function ancestorCascade(checkbox) {
			var li = $(checkbox).closest('li');
			// unset the task completed time
			li.find('> .dd-content .completed-time').val('');

			// find the parent li's checkbox
			var parentChk = li.parents('li:first').find('> .dd-content :checkbox');
			if (parentChk.size() == 0) return false;

			// loop though all sibling li's checkbox to determine all of them is checked
			var allCompleted = $(checkbox).is(':checked');
			$.each(li.siblings(), function() {
				if (!$(this).find('> .dd-content :checkbox').is(':checked')) {
					allCompleted = false;
					return false;
				}
			});

			// update the check state of the parent li's checkbox
			parentChk.prop('checked', allCompleted);
			ancestorCascade(parentChk);
		};

		function setCompleteState(todoList) {
			$.each($(todoList).find(':checkbox'), function() {
				setCompletedTime(this);
				var li = $(this).closest('li');
				if ($(this).is(':checked'))
					li.addClass('done');
				else
					li.removeClass('done');
			});
			updateVisibleState();
		};

		$(todoList).on('change', ':checkbox', function () {
			descendantCascade(this);
			ancestorCascade(this);
			setCompleteState(todoList);
		});

		$(todoList).on('click','.btn-remv-task', function () {
			$(this).closest('li').remove();
		});

		setCompleteState(todoList);
	},

	setupPlanPage: function () {
		var tasksContainer = $('#tasks');
		tasksContainer.nestable({ /* config options */ });

		// serialize task tree before form submit
		$('form').submit(function () {
			var tree = $('.nestable').nestable('serialize');
			$('#planform-hierarchyjson').val(JSON.stringify(tree));
		});

		// add new task
		var newItemCounter = 0;
		$('.btn-add').click(function () {
			var li = $('.task-tpl li').clone();
			var id = 'new-'+ newItemCounter;
			li.attr('data-id', id);
			li.find(':hidden').attr('name', 'PlanForm[formTasks]['+id+'][status]');
			li.find(':checkbox').attr('name', 'PlanForm[formTasks]['+id+'][status]');
			li.find(':text').attr('name', 'PlanForm[formTasks]['+id+'][name]');
			tasksContainer.children(':first').prepend(li);
			newItemCounter++;
		});

		// the submit button is outside the form, so we need call form submit
		$('.btn-submit').click(function () {
			$('#planform-hierarchyjson').submit();
		});

		setupCheckList(tasksContainer);
		setupInlineEdit();
	},

	setupPlanGrid: function (updateUrl) {
		var self = this;
		this.timer = null;

		this.saveGrid = function () {
			var data = [];
			$('.connectedSortable').each(function () {
				var colId = $(this).attr('data-col-id');
				var planIds = $(this).children().map(function () {
					return $(this).attr('data-plan-id');
				});
				data[colId] = $.makeArray(planIds);
			});
			$.post(updateUrl, { data: JSON.stringify(data)}, function() {
				console.log('grid update success');
			});
		};

		this.onGridChange = function () {
			clearTimeout(this.timer);
			this.timer = setTimeout(self.saveGrid, 3000);
		};

		$('.connectedSortable').sortable({
			placeholder: 'sort-highlight',
			connectWith: '.connectedSortable',
			handle: '.box-header',
			forcePlaceholderSize: true,
			zIndex: 999999,
			stop: this.onGridChange
		});

		$('.connectedSortable .box-header, .connectedSortable .nav-tabs-custom').css('cursor', 'move');

		$('.edit-plan').click(function (e) {
			e.preventDefault();
			var box = $(this).closest('.box');
			var name = box.find('.box-title').text().trim();
			var desc = box.find('.box-body').html();
			var id = box.attr('data-plan-id');

			$("#update-modal").find('.modal-title').text(name);
			$('#planform-id').val(id);
			$('#planform-name').val(name);
			$('#w1').redactor('code.set', desc);
			$("#update-modal").modal({ show: true });
		});
	}
};

// merge module code to app object
if (typeof app==='undefined') app = {};
app = $.extend(app, module);