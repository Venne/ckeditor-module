$(function()
{
	var config = {
		// skin:'v2'
	};

	function initCkeditor(){
		for(var instanceName in CKEDITOR.instances) {
			CKEDITOR.instances[instanceName].destroy();
		}

		var ckeditor = $('textarea[venne-form-editor]');
		var ckeditorInstance = ckeditor.ckeditor(config);
	}

	$.nette.ext('ckeditor', {
		complete: function (payload) {
			initCkeditor();
		}
	});

	initCkeditor();
});