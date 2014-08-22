// Definizione codice per la gestione dei tab presenti nelle
// pagine di configurazione nel pannello di amministrazione

jQuery(document).ready(function()
{
	jQuery('#sz-google-tab').find('a').click(function() 
	{
		// Tolgo da tutti i tab presenti la classe di identificazione
		// elemento attivo e aggiungo questa classe solo a quello attivo

		jQuery('#sz-google-tab').find('a').removeClass('nav-tab-active');
		jQuery(this).addClass('nav-tab-active');

		// Tolgo su tutte le divisioni del contenuto di tab la classe
		// di impostazionne "attivo" e aggiungo solo in quella selezionata

		var id = jQuery(this).attr('id').replace('sz-google-tab-','');

		jQuery('.sz-google-tab-div').removeClass('sz-google-active');
		jQuery('#sz-google-tab-div-'+ id).addClass('sz-google-active');

	});

	// Operazioni iniziali da eseguire subito dopo il caricamento
	// della pagina con attivazione dei link che risultano "active"

	var active_tab = window.location.hash.replace('#','');

	// Se non specifico niente e il tab non viene trovato nel codice HTML
	// utilizzo come tab predefinito il primo div che incontro nel codice

	if (active_tab == '' || !jQuery('#sz-google-tab-'+ active_tab).length) 
	{
		active_tab = jQuery('.sz-google-tab-div').attr('id');

		if (typeof active_tab != 'undefined') {
			active_tab = active_tab.replace('sz-google-tab-div-','');
 		}
	}

	// Attivazione mediante aggiunta delle classi di "active" del link
	// e della divisione che risultano attualmente visualizzate

	jQuery('#sz-google-tab-'     + active_tab).addClass('nav-tab-active');
	jQuery('#sz-google-tab-div-' + active_tab).addClass('sz-google-active');
});
