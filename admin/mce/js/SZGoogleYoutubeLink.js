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

		var channel      = jQuery('#ID_channel').val();
		var text         = jQuery('#ID_text'   ).val();
		var image        = jQuery('#ID_image'  ).val();

		var subscription = jQuery("#MCE input[name='NAME_subscription']:checked").val();
		var newtab       = jQuery("#MCE input[name='NAME_newtab'      ]:checked").val();

		if (jQuery('#ID_method').val() == '1') channel = '';

		// Composizione shortcode selezionato con elenco
		// delle opzioni disponibili e valore associato

		output = '[sz-ytlink ';

		if (channel      != '') output += 'channel="'      + channel      + '" ';
		if (subscription != '') output += 'subscription="' + subscription + '" ';
		if (text         != '') output += 'text="'         + text         + '" ';
		if (image        != '') output += 'image="'        + image        + '" ';
		if (newtab       != '') output += 'newtab="'       + newtab       + '" ';

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