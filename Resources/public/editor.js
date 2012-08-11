$(function()
{
	var config = {
		filebrowserBrowseUrl : '/venne/www/admin/cms/files?lang=cs&panel-tab=2&browserMode=1',
		filebrowserImageBrowseUrl : '/venne/www/admin/cms/files?lang=cs&panel-tab=2&browserMode=1',
		filebrowserWindowWidth : '1024',
		filebrowserWindowHeight : '768',
		skin : 'BootstrapCK-Skin',
		height: 700
	};

	function initCkeditor(){
		for(var instanceName in CKEDITOR.instances) {
			CKEDITOR.instances[instanceName].destroy();
		}

		var ckeditor = $('textarea[venne-form-editor]');
		var ckeditorInstance = ckeditor.ckeditor(config);

		$( "#cke_frmformEdit-text" ).droppable({
			drop: function( event, ui ) {
				alert('yeah');
			}
		});
	}

	$.nette.ext('ckeditor', {
		complete: function (payload) {
			initCkeditor();
		}
	});

	initCkeditor();
});