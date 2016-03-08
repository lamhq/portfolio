function setupAjaxUploadWidget (options) {
	var widget = $('#'+options.id);

	var checkExtension = function(file) {
		if (options.extensions.length < 1) return true;
		var fileExt = file.name.split('.').pop();
		if ( $.inArray(fileExt.toLowerCase(), options.extensions)<0 ) {
			alert('File type is not allowed');
			return false;
		}
		return true;
	};

	var checkMaxSize = function(file) {
		if (options.maxSize==0) return true;

		if ( file.size > options.maxSize*1000 ) {
			alert('File is too large');
			return false;
		}
		return true;
	};
	
	var uploadFile = function(file) {
		if (!checkExtension(file) || !checkMaxSize(file) ) {
			return false;
		}
		var data = new FormData();
		data.append('ajax-file', file);	// create a field to form

		var request = new XMLHttpRequest();
		request.onreadystatechange = function(){
			if(request.readyState == 4){	// done
				try {
					var resp = JSON.parse(request.response);
					widget.find('.files').append(createPreviewItem(resp));
					widget.find('.holder').remove();
					widget.find('.loader').addClass('hide');
				} catch (e){ }
			}
		};
		// request.upload.addEventListener('progress', function () {}, false);
		request.open('POST', options.uploadUrl);
		request.send(data);
		widget.find('.loader').removeClass('hide'); // show loading
		return true;
	};
	
	var createPreviewItem = function (data) {
		var filename = data.value;
		var removeButton = '&nbsp;<a class="remove fa fa-remove" href="javascript:void(0)"></a>';
		var hiddenInput = '<input type="hidden" name="' +options.name+ (options.multiple ? '[]' : '') 
			+ '" value="' +filename+ '" />';
		return '<li>'+filename + removeButton + hiddenInput + '</li>';
	};

	widget.on('change', '.ajax-file-input', function() {
		if ( this.files.length === 0){
			this.value = '';
			return;
		}

		$(this.files).each(function () {
			uploadFile(this);
		});
		// reset file input
		this.value = '';
	});

	widget.on('click', '.remove', function() {
		$(this).parent().remove();
		if (widget.find('.files li').size()<1) {
			var hidden = '<input type="hidden" name="' +options.name+ '" value="" class="holder" />';
			widget.append(hidden);
		}
	});
}

