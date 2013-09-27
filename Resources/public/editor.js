$(function () {

	if ($("body").attr("data-venne-basepath") !== undefined) {
		var basePath = $("body").attr("data-venne-basepath");
	} else {
		var basePath = "";
	}

	function initCkeditor() {
		$('textarea[venne-form-editor]').each(function () {
			if (!$(this).data('ckeditor')) {
				$(this).data('ckeditor', true);
				$(this).parent().prev().hide();
				$(this).parent().css('margin-left', 0);

				var _this = $(this);

				var config = {
					filebrowserBrowseUrl: basePath + '/admin/en/files?lang=cs&panel-tab=2&browserMode=1',
					filebrowserImageBrowseUrl: basePath + '/admin/en/files?lang=cs&panel-tab=2&browserMode=1',
					filebrowserWindowWidth: '1024',
					filebrowserWindowHeight: '768',
					height: 550
				};

				$.ajax({
					url: basePath + '/public/ckeditor/backend.json',
					dataType: "json",
					success: function () {
						var c = jQuery.parseJSON('{ "name": "John" }');
					}
				})
					.done(function (data) {
						config = $.extend({}, config, data);
					})
					.always(function () {
						CKEDITOR.replace(_this.attr('id'), config);
					});
			}
		});

	}

	$.nette.ext('ckeditor', {
		load: function () {
			initCkeditor();
		},
		complete: function (payload) {
			initCkeditor();
		}
	});

});
