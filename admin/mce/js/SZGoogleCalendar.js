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

		var calendar      = jQuery('#ID_calendar' ).val();
		var title         = jQuery('#ID_calendarT').val();
		var width         = jQuery('#ID_width'    ).val();
		var height        = jQuery('#ID_height'   ).val();
		var mode          = jQuery('#ID_mode'     ).val();
		var weekstart     = jQuery('#ID_weekstart').val();
		var language      = jQuery('#ID_language' ).val();
		var timezone      = jQuery('#ID_timezone' ).val();

		var showtitle     = jQuery("#MCE input[name='NAME_showtitle'    ]:checked").val();
		var shownavs      = jQuery("#MCE input[name='NAME_shownavs'     ]:checked").val();
		var showdate      = jQuery("#MCE input[name='NAME_showdate'     ]:checked").val();
		var showprint     = jQuery("#MCE input[name='NAME_showprint'    ]:checked").val();
		var showcalendars = jQuery("#MCE input[name='NAME_showcalendars']:checked").val();
		var showtimezone  = jQuery("#MCE input[name='NAME_showtimezone' ]:checked").val();

		if (jQuery('#ID_width_auto' ).is(':checked')) width  = 'auto';
		if (jQuery('#ID_height_auto').is(':checked')) height = 'auto';

		if (language == '99') language = '';

		// Composizione shortcode selezionato con elenco
		// delle opzioni disponibili e valore associato

		output = '[sz-gplus-calendar ';

		if (calendar      != '') output += 'calendar="'      + calendar      + '" ';
		if (title         != '') output += 'title="'         + title         + '" ';
		if (mode          != '') output += 'mode="'          + mode          + '" ';
		if (weekstart     != '') output += 'weekstart="'     + weekstart     + '" ';
		if (language      != '') output += 'language="'      + language      + '" ';
		if (timezone      != '') output += 'timezone="'      + timezone      + '" ';
		if (width         != '') output += 'width="'         + width         + '" ';
		if (height        != '') output += 'height="'        + height        + '" ';
		if (showtitle     != '') output += 'showtitle="'     + showtitle     + '" ';
		if (shownavs      != '') output += 'shownavs="'      + shownavs      + '" ';
		if (showdate      != '') output += 'showdate="'      + showdate      + '" ';
		if (showprint     != '') output += 'showprint="'     + showprint     + '" ';
		if (showcalendars != '') output += 'showcalendars="' + showcalendars + '" ';
		if (showtimezone  != '') output += 'showtimezone="'  + showtimezone  + '" ';

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