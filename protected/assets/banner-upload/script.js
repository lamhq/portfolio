function setupBannerUploadWidget (options) {
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
		var tpl = '<li><img src="{{LINK}}" alt=""/>'
				+'<p class="name">{{NAME}}</p>'+
				+'&nbsp;<a class="remove fa fa-trash" href="javascript:void(0)"></a>' +
				+'<input type="hidden" name="' +options.name+ (options.multiple ? '[]' : '') +'[image]'
				+'" value="' +filename+ '" />'
			+'</li>';
		var filename = data.value;
		var image = '<img src="'+data.link+'" alt=""/>';
		var removeButton = '&nbsp;<a class="remove fa fa-trash" href="javascript:void(0)"></a>';
		var id = '<input type="hidden" name="' +options.name+ (options.multiple ? '[]' : '') +'[image]'
			+ '" value="' +filename+ '" />';
		return '<li>'+ image + filename + removeButton + id + '</li>';
	};

	widget.on('change', '.banner-file-input', function() {
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
		var p = $(this).closest('li');
		p.remove();
		if (widget.find('.files li').size()<1) {
			var hidden = '<input type="hidden" name="' +options.name+ '" value="" class="holder" />';
			widget.append(hidden);
		}
	});
}

