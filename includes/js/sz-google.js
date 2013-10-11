
var szgoogle_media_frame;

// Funzione richiamata in maniera diretta dopo la composizione
// dei widget che hanno alcuni campi con lo switch hidden

function szgoogle_switch_hidden_ready() 
{
	jQuery(".sz-google-switch-hidden").each(function() 
	{
		var element_switch_class   = "." + jQuery(this).data("switch");
		var element_switch_close   = jQuery(this).data("close");
		var element_switch_display = jQuery(this).parents("form:first").find(element_switch_class);

		if (jQuery(this).val() == element_switch_close) jQuery(element_switch_display).hide();
	});
}

function szgoogle_checks_hidden_ready() 
{
	jQuery(".sz-google-checks-hidden").each(function() 
	{
		var element_switch_class   = "." + jQuery(this).data("switch");
		var element_switch_display = jQuery(this).parents("form:first").find(element_switch_class);

		if (jQuery(this).is(":checked")) jQuery(element_switch_display).prop("readonly",true);
			else jQuery(element_switch_display).prop("readonly",false);
	});
}

// Funzione richiamata durante la modifica del campo
// sul widget come ad esempio una select e un campo input

function szgoogle_switch_hidden(clicked) 
{
	var dataclose = jQuery(clicked).data("close")
	var classname = '.' + jQuery(clicked).data("switch");

	if (clicked.value == dataclose) {
		jQuery(clicked).parents("form:first").find(classname).slideUp();
	} else {
		jQuery(clicked).parents("form:first").find(classname).slideDown();
	}
}

function szgoogle_checks_hidden(clicked) 
{
	var classname = '.' + jQuery(clicked).data("switch");

	if (jQuery(clicked).is(":checked")) {
		jQuery(clicked).parents("form:first").find(classname).prop("readonly",true);
	} else {
		jQuery(clicked).parents("form:first").find(classname).prop("readonly",false);
	}
}

// Codice per implementare una chiamata al media uploader
// di selezione attachment collegato ai tasti di scelta file

function szgoogle_media_uploader() 
{
	jQuery('.sz-upload-image-button').on('click',function() {

		var element   = jQuery(this); 
		var classname = '.' + jQuery(this).data('field-url');

		if (typeof(szgoogle_media_frame)!=="undefined") {
			szgoogle_media_frame.close();
		}

		// Creazione frame per la selezione dei file da allegare al link  
		// impostazione dei parametri per caratteristiche media uploader

		szgoogle_media_frame = wp.media.frames.customHeader = wp.media(
		{
			frame: 'select',
			title: jQuery(element).data('title'),
			button: {
				text: jQuery(element).data('button-text'),
				close:true
				},
			multiple:false
		});
 
		// Funzione di callback che viene richiamata quando
		// viene confermata la selezione della risorsa sulla libreria

		szgoogle_media_frame.on('select',function() {
			attachment = szgoogle_media_frame.state().get('selection').first().toJSON();
			jQuery(element).parents('form:first').find(classname).val(attachment.url);
		});
 
		// Apertura della finestra popup per media uploader

		szgoogle_media_frame.open();
	});
}									