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

		var name            = jQuery('#ID_name'   ).val();
		var domain          = jQuery('#ID_domain' ).val();
		var width           = jQuery('#ID_width'  ).val();
		var height          = jQuery('#ID_height' ).val();

		var showsearch      = jQuery("#MCE input[name='NAME_showsearch'    ]:checked").val();
		var showtabs        = jQuery("#MCE input[name='NAME_showtabs'      ]:checked").val();
		var hideforumtitle  = jQuery("#MCE input[name='NAME_hideforumtitle']:checked").val();
		var hidesubject     = jQuery("#MCE input[name='NAME_hidesubject'   ]:checked").val();

		if (jQuery('#ID_width_auto' ).is(':checked')) width  = 'auto';
		if (jQuery('#ID_height_auto').is(':checked')) height = 'auto';

		// Composizione shortcode selezionato con elenco
		// delle opzioni disponibili e valore associato

		output = '[sz-ggroups ';

		if (name           != '') output += 'name="'           + name           + '" ';
		if (domain         != '') output += 'domain="'         + domain         + '" ';
		if (width          != '') output += 'width="'          + width          + '" ';
		if (height         != '') output += 'height="'         + height         + '" ';
		if (showsearch     != '') output += 'showsearch="'     + showsearch     + '" ';
		if (showtabs       != '') output += 'showtabs="'       + showtabs       + '" ';
		if (hideforumtitle != '') output += 'hideforumtitle="' + hideforumtitle + '" ';
		if (hidesubject    != '') output += 'hidesubject="'    + hidesubject    + '" ';

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