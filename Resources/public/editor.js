$(function () {

	if ($("body").attr("data-venne-basepath") !== undefined) {
		var basePath = $("body").attr("data-venne-basepath");
	} else {
		var basePath = "";
	}

	var config = {
		filebrowserBrowseUrl:basePath + '/admin/en/files?lang=cs&panel-tab=2&browserMode=1',
		filebrowserImageBrowseUrl:basePath + '/admin/en/files?lang=cs&panel-tab=2&browserMode=1',
		filebrowserWindowWidth:'1024',
		filebrowserWindowHeight:'768',
		height:550
	};

	function initCkeditor() {
		$('textarea[venne-form-editor]').each(function () {
			$(this).parent().prev().hide();
			$(this).parent().css('margin-left', 0);
			CKEDITOR.replace($(this).attr('id'), config);
		});

	}

	$.nette.ext('ckeditor', {
		complete:function (payload) {
			initCkeditor();
		}
	});

	initCkeditor();
});