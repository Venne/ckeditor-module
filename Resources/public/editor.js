$(function () {
	var config = {
		filebrowserBrowseUrl:'/venne/www/admin/en/files?lang=cs&panel-tab=2&browserMode=1',
		filebrowserImageBrowseUrl:'/venne/www/admin/en/files?lang=cs&panel-tab=2&browserMode=1',
		filebrowserWindowWidth:'1024',
		filebrowserWindowHeight:'768',
		height:700,
		toolbar:[
			{ name:'document', items:[ 'Source', '-', 'DocProps', 'Preview', 'Print', '-', 'Templates' ] },
			{ name:'clipboard', items:[ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
			{ name:'editing', items:[ 'Find', 'Replace', '-', 'SelectAll', '-', 'SpellChecker', 'Scayt' ] },
			{ name:'forms', items:[ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
			'/',
			{ name:'basicstyles', items:[ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
			{ name:'paragraph', items:[ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl' ] },
			{ name:'links', items:[ 'Link', 'Unlink', 'Anchor' ] },
			{ name:'insert', items:[ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak' ] },
			'/',
			{ name:'styles', items:[ 'Styles', 'Format', 'Font', 'FontSize' ] },
			{ name:'colors', items:[ 'TextColor', 'BGColor' ] },
			{ name:'tools', items:[ 'Maximize', 'ShowBlocks', '-', 'About' ] }
		]
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