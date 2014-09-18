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

		var template    = jQuery('#ID_template'   ).val();
		var user        = jQuery('#ID_user'       ).val();
		var group       = jQuery('#ID_group'      ).val();
		var tag         = jQuery('#ID_tag'        ).val();
		var set         = jQuery('#ID_set'        ).val();
		var width       = jQuery('#ID_width'      ).val();
		var height      = jQuery('#ID_height'     ).val();
		var columns     = jQuery('#ID_columns'    ).val();
		var rows        = jQuery('#ID_rows'       ).val();
		var orientation = jQuery('#ID_orientation').val();
		var position    = jQuery('#ID_position'   ).val();

		if (jQuery('#ID_width_auto' ).is(':checked')) width  = 'auto';
		if (jQuery('#ID_height_auto').is(':checked')) height = 'auto';

		// Composizione shortcode selezionato con elenco
		// delle opzioni disponibili e valore associato

		output = '[sz-panoramio ';

		if (template    != '') output += 'template="'    + template    + '" ';
		if (user        != '') output += 'user="'        + user        + '" ';
		if (group       != '') output += 'group="'       + group       + '" ';
		if (tag         != '') output += 'tag="'         + tag         + '" ';
		if (set         != '') output += 'set="'         + set         + '" ';
		if (width       != '') output += 'width="'       + width       + '" ';
		if (height      != '') output += 'height="'      + height      + '" ';
		if (columns     != '') output += 'columns="'     + columns     + '" ';
		if (rows        != '') output += 'rows="'        + rows        + '" ';
		if (orientation != '') output += 'orientation="' + orientation + '" ';
		if (position    != '') output += 'position="'    + position    + '" ';

		output += '/]';

		// Una volta eseguita la composizione del comando shotcode
		// richiamo i metodi di tinyMCE per inserimento in editor		
		
		tinyMCEPopup.execCommand('mceReplaceContent',false,output);
		tinyMCEPopup.close();
	}
};

// Inizializzo il dialogo tinyMCE e richiamo
// anche la routine init per le operazioni iniziali

tinyMCEPopup.onInit.add(SZGoogleDialog.init,SZGoogleDialog);