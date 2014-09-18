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

		var channel = jQuery('#ID_channel').val();
		var width   = jQuery('#ID_width'  ).val();
		var height  = jQuery('#ID_height' ).val();

		if (jQuery('#ID_method').val() == '1')        channel = '';
		if (jQuery('#ID_width_auto' ).is(':checked')) width   = 'auto';
		if (jQuery('#ID_height_auto').is(':checked')) height  = 'auto';

		// Composizione shortcode selezionato con elenco
		// delle opzioni disponibili e valore associato

		output = '[sz-ytbadge ';

		if (channel != '') output += 'channel="' + channel + '" ';
		if (width   != '') output += 'width="'   + width   + '" ';
		if (height  != '') output += 'height="'  + height  + '" ';

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