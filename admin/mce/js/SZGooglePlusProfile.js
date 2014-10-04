// Definizione variabile principale per contenere
// le funzioni che verranno richiamate da popup

var SZGoogleDialog = 
{
	local_ed:'ed',

	// Funzione init per le operazioni iniziali del
	// componente da eseguire in questo stesso file

	init: function(ed) {
		SZGoogleDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},

	// Funzione cancel associata al bottone di fine
	// schermata presente in ogni popup di shortcode

	cancel: function(ed) {
		tinyMCEPopup.close();
	},

	// Funzione insert per la creazione del codice
	// shortcode con tutti le opzioni preimpostate

	insert: function(ed) {

		tinyMCEPopup.execCommand('mceRemoveNode',false,null);
 
		// Calcolo i valori delle variabili direttamente
		// dai campi del form senza sottomissione standard

		var output  = '';

		var id      = jQuery('#ID_specific').val();
		var type    = jQuery('#ID_type'    ).val();
		var width   = jQuery('#ID_width'   ).val();
		var align   = jQuery('#ID_align'   ).val();
		var text    = jQuery('#ID_text'    ).val();
		var image   = jQuery('#ID_image'   ).val();

		var layout  = jQuery("#MCE input[name='NAME_layout' ]:checked").val();
		var theme   = jQuery("#MCE input[name='NAME_theme'  ]:checked").val();
		var cover   = jQuery("#MCE input[name='NAME_cover'  ]:checked").val();
		var tagline = jQuery("#MCE input[name='NAME_tagline']:checked").val();
		var author  = jQuery("#MCE input[name='NAME_author' ]:checked").val();

		if (jQuery('#ID_method').val() == '1')       id    = '';
		if (jQuery('#ID_width_auto').is(':checked')) width = 'auto';

		// Composizione shortcode selezionato con elenco
		// delle opzioni disponibili e valore associato

		output = '[sz-gplus-profile ';

		// Composizione opzioni che sono collegate al
		// tipo di badge nel formato standard 

		if (type == 'standard') {
			if (type    != '') output += 'type="'    + type    + '" ';
			if (id      != '') output += 'id="'      + id      + '" ';
			if (width   != '') output += 'width="'   + width   + '" ';
			if (align   != '') output += 'align="'   + align   + '" ';
			if (layout  != '') output += 'layout="'  + layout  + '" ';
			if (theme   != '') output += 'theme="'   + theme   + '" ';
			if (cover   != '') output += 'cover="'   + cover   + '" ';
			if (tagline != '') output += 'tagline="' + tagline + '" ';
			if (author  != '') output += 'author="'  + author  + '" ';
		}

		// Composizione opzioni che sono collegate al tipo
		// di badge nel formato popup che si attiva in hover

		if (type == 'popup') {
			if (type    != '') output += 'type="'    + type    + '" ';
			if (id      != '') output += 'id="'      + id      + '" ';
			if (text    != '') output += 'text="'    + text    + '" ';
			if (image   != '') output += 'image="'   + image   + '" ';
		}

		output += '/]';

		// Una volta eseguita la composizione del comando shortcode
		// richiamo i metodi di tinyMCE per inserimento in editor		

		tinyMCEPopup.execCommand('mceReplaceContent',false,output);
		tinyMCEPopup.close();
	}
}

// Inizializzo il dialogo tinyMCE e richiamo
// anche la routine init per le operazioni iniziali

tinyMCEPopup.onInit.add(SZGoogleDialog.init,SZGoogleDialog);