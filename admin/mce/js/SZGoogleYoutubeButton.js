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

		var channel    = jQuery('#ID_channel').val();
		var layout     = jQuery('#ID_layout' ).val();
		var theme      = jQuery('#ID_theme'  ).val();
		var align      = jQuery('#ID_align'  ).val();

		var subscriber = jQuery("#MCE input[name='NAME_subscriber']:checked").val();

		if (jQuery('#ID_method').val() == '1') channel = '';

		// Composizione shortcode selezionato con elenco
		// delle opzioni disponibili e valore associato

		output = '[sz-ytbutton ';

		if (channel    != '') output += 'channel="'    + channel    + '" ';
		if (layout     != '') output += 'layout="'     + layout     + '" ';
		if (theme      != '') output += 'theme="'      + theme      + '" ';
		if (subscriber != '') output += 'subscriber="' + subscriber + '" ';
		if (align      != '') output += 'align="'      + align      + '" ';

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