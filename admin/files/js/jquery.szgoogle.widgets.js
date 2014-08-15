// Definizione delle funzioni da utilizzare nei form legati
// agli widget e agli shortcode in modalità amministrazione

var szgoogle_media_frame;

// FORM SELECT - Funzione richiamata in maniera diretta dopo la
// composizione dei widget che hanno alcuni campi con lo switch hidden

function szgoogle_switch_hidden_onload(id) {
	jQuery('#' + id + ' .sz-google-switch-hidden').each(function() {
			szgoogle_switch_hidden_onchange(this);
	});
}

function szgoogle_switch_hidden_onchange(clicked) 
{
	var dataopen  = jQuery(clicked).data('open');
	var dataclose = jQuery(clicked).data('close');
	var classname = '.' + jQuery(clicked).data('switch');

	// Controllo se ho definito la funzione per operazione "open"
	// quindi se il valore della select è quello indicato chiudo la classe

	if (jQuery(clicked).attr('data-open')) {
		if (clicked.value == dataopen) jQuery(clicked).parents('form:first').find(classname).slideDown();
			else jQuery(clicked).parents('form:first').find(classname).slideUp();
	}

	// Controllo se ho definito la funzione per operazione "close"
	// quindi se il valore della select è quello indicato apro la classe

	if (jQuery(clicked).attr('data-close')) {
		if (clicked.value == dataclose) jQuery(clicked).parents('form:first').find(classname).slideUp();
			else jQuery(clicked).parents('form:first').find(classname).slideDown();
	}
}

// FORM CHECKBOX - Codice per implementare la visualizzazione di
// divisioni nascoste in base al valore del checkbox selezionato

function szgoogle_checks_hidden_onload(id) {
	jQuery('#' + id + ' .sz-google-checks-hidden').each(function() {
		szgoogle_checks_hidden_onchange(this);
	});
}

function szgoogle_checks_hidden_onchange(clicked) 
{
	var classname = '.' + jQuery(clicked).data('switch');

	if (jQuery(clicked).is(':checked')) jQuery(clicked).parents('form:first').find(classname).prop('readonly',true);
		else jQuery(clicked).parents('form:first').find(classname).prop('readonly',false);
}

// FORM SELECT - Codice per implementare la visualizzazione di
// divisioni nascoste in base al valore della select selezionato

function szgoogle_switch_select_onload(id) {
	jQuery('#' + id + ' .sz-google-row-select').each(function() {
		szgoogle_switch_select_onchange(this);
	});
}

function szgoogle_switch_select_onchange(clicked) 
{
	var dataopen  = jQuery('option:selected',clicked).data('open');
	var classname = '.sz-google-row-tab';
	var classview = classname + '-' + dataopen;

	jQuery(clicked).parents('form:first').find(classname).hide();
	jQuery(clicked).parents('form:first').find(classview).slideDown();
}

// Codice per implementare una chiamata al media uploader
// di selezione attachment collegato ai tasti di scelta file

function szgoogle_upload_select_media() 
{
	jQuery('.sz-upload-image-button').on('click',function() {

		var element   = jQuery(this); 
		var classname = '.' + jQuery(this).data('field-url');

		if (typeof(szgoogle_media_frame)!=='undefined') {
			szgoogle_media_frame.close();
		}

		// Creazione frame per la selezione dei file da allegare al link  
		// impostazione dei parametri per caratteristiche media uploader

		szgoogle_media_frame = wp.media.frames.customHeader = wp.media({
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