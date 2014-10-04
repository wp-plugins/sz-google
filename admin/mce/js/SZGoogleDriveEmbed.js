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

		var type       = jQuery('#ID_type'      ).val();
		var id         = jQuery('#ID_id'        ).val();
		var width      = jQuery('#ID_width'     ).val();
		var height     = jQuery('#ID_height'    ).val();
		var gid        = jQuery('#ID_gid'       ).val();
		var range      = jQuery('#ID_range'     ).val();
		var delay      = jQuery('#ID_delay'     ).val();
		var folderview = jQuery('#ID_folderview').val();

		var single     = jQuery("#MCE input[name='NAME_single']:checked").val();
		var start      = jQuery("#MCE input[name='NAME_start' ]:checked").val();
		var loop       = jQuery("#MCE input[name='NAME_loop'  ]:checked").val();

		if (jQuery('#ID_width_auto' ).is(':checked')) width  = 'auto';
		if (jQuery('#ID_height_auto').is(':checked')) height = 'auto';

		// Calcolo i valori delle variabili direttamente
		// dai campi del form senza sottomissione standard

		if (type != 'spreadsheet')  single     = '';
		if (type != 'spreadsheet')  gid        = '';
		if (type != 'spreadsheet')  range      = '';

		if (type != 'presentation') start      = '';
		if (type != 'presentation') loop       = '';
		if (type != 'presentation') delay      = '';

		if (type != 'folder')       folderview = '';

		// Composizione shortcode selezionato con elenco
		// delle opzioni disponibili e valore associato

		output = '[sz-drive-embed ';

		if (type       != '') output += 'type="'      + type       + '" ';
		if (id         != '') output += 'id="'        + id         + '" ';
		if (width      != '') output += 'width="'     + width      + '" ';
		if (height     != '') output += 'height="'    + height     + '" ';
		if (gid        != '') output += 'gid="'       + gid        + '" ';
		if (range      != '') output += 'range="'     + range      + '" ';
		if (delay      != '') output += 'delay="'     + delay      + '" ';
		if (single     != '') output += 'single="'    + single     + '" ';
		if (folderview != '') output += 'folderview="'+ folderview + '" ';
		if (start      != '') output += 'start="'     + start      + '" ';
		if (loop       != '') output += 'loop="'      + loop       + '" ';

		output += '/]';

		// Una volta eseguita la composizione del comando shortcode
		// richiamo i metodi di tinyMCE per inserimento in editor		
		
		tinyMCEPopup.execCommand('mceReplaceContent',false,output);
		tinyMCEPopup.close();
	}
};

// Inizializzo il dialogo tinyMCE e richiamo
// anche la routine init per le operazioni iniziali

tinyMCEPopup.onInit.add(SZGoogleDialog.init,SZGoogleDialog);