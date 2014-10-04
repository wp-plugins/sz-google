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

		var url             = jQuery('#ID_url'   ).val();
		var width           = jQuery('#ID_width' ).val();
		var height          = jQuery('#ID_height').val();
		var theme           = jQuery('#ID_theme' ).val();
		var cover           = jQuery('#ID_cover' ).val();
		var start           = jQuery('#ID_start' ).val();
		var end             = jQuery('#ID_end'   ).val();
		
		var responsive      = jQuery("#MCE input[name='NAME_responsive'     ]:checked").val();
		var autoplay        = jQuery("#MCE input[name='NAME_autoplay'       ]:checked").val();
		var loop            = jQuery("#MCE input[name='NAME_loop'           ]:checked").val();
		var fullscreen      = jQuery("#MCE input[name='NAME_fullscreen'     ]:checked").val();
		var disablekeyboard = jQuery("#MCE input[name='NAME_disablekeyboard']:checked").val();
		var disableiframe   = jQuery("#MCE input[name='NAME_disableiframe'  ]:checked").val();
		var disablerelated  = jQuery("#MCE input[name='NAME_disablerelated' ]:checked").val();
		var delayed         = jQuery("#MCE input[name='NAME_delayed'        ]:checked").val();
		var schemaorg       = jQuery("#MCE input[name='NAME_schemaorg'      ]:checked").val();
	
		if (responsive == 'y') width  = '';
		if (responsive == 'y') height = '';	

		// Composizione shortcode selezionato con elenco
		// delle opzioni disponibili e valore associato

		output = '[sz-ytvideo ';

		if (url             != '') output += 'url="'             + url             + '" ';
		if (width           != '') output += 'width="'           + width           + '" ';
		if (height          != '') output += 'height="'          + height          + '" ';
		if (theme           != '') output += 'theme="'           + theme           + '" ';
		if (cover           != '') output += 'cover="'           + cover           + '" ';
		if (start           != '') output += 'start="'           + start           + '" ';
		if (end             != '') output += 'end="'             + end             + '" ';
		if (responsive      != '') output += 'responsive="'      + responsive      + '" ';
		if (autoplay        != '') output += 'autoplay="'        + autoplay        + '" ';
		if (loop            != '') output += 'loop="'            + loop            + '" ';
		if (fullscreen      != '') output += 'fullscreen="'      + fullscreen      + '" ';
		if (disablekeyboard != '') output += 'disablekeyboard="' + disablekeyboard + '" ';
		if (disableiframe   != '') output += 'disableiframe="'   + disableiframe   + '" ';
		if (disablerelated  != '') output += 'disablerelated="'  + disablerelated  + '" ';
		if (delayed         != '') output += 'delayed="'         + delayed         + '" ';
		if (schemaorg       != '') output += 'schemaorg="'       + schemaorg       + '" ';

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