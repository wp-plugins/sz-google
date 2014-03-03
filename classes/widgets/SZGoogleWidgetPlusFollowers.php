<?php
/**
 * Classe SZGoogleWidget per la definizione di uno widget standard
 * da utilizzare nel plugin. Tutti gli widget definiti dovranno 
 * essere specificati come extended di questa classe.
 *
 * @package SZGoogle
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

/**
 * Creazione WIDGET per il modulo del plugin richiesto.
 * Creazione della classe con riferimento a quella generica.
 */
if (!class_exists('SZGoogleWidgetPlusFollowers'))
{
	class SZGoogleWidgetPlusFollowers extends SZGoogleWidget 
	{
		// Costruttore principale della classe widget, definizione 
		// delle opzioni legate al widget e al controllo dello stesso

		function __construct() 
		{
			parent::__construct('SZ-Google-Followers',__('SZ-Google - G+ Followers','szgoogleadmin'),array(
				'classname'   => 'sz-widget-google sz-widget-google-plus sz-widget-google-plus-followers', 
				'description' => ucfirst(__('google+ followers.','szgoogleadmin'))
			));
		}

		// Funzione per la visualizzazione del widget con lettura parametri
		// di configurazione e preparazione codice HTML da usare nella sidebar

		function widget($args,$instance) 
		{
			// Controllo se esistono le variabili che servono durante l'elaborazione
			// dello script e assegno dei valori di default nel caso non fossero specificati

			$options = $this->common_empty(array(
				'id'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'height'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'align'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'action'      => SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET,
			),$instance);

			// Definizione delle variabili di controllo del widget, questi valori non
			// interessano le opzioni della funzione base ma incidono su alcuni aspetti

			$controls = $this->common_empty(array(
				'method'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'specific'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width_auto'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'height_auto' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			),$instance);

			// Correzione del valore di dimensione nel caso venga
			// specificata la maniera automatica e quindi usare javascript

			if ($controls['method']      != SZ_PLUGIN_GOOGLE_VALUE_YES) $options['id']     = $controls['specific']; 
			if ($controls['method']      == SZ_PLUGIN_GOOGLE_VALUE_YES) $options['id']     = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
			if ($controls['width_auto']  == SZ_PLUGIN_GOOGLE_VALUE_YES) $options['width']  = SZ_PLUGIN_GOOGLE_VALUE_AUTO;
			if ($controls['height_auto'] == SZ_PLUGIN_GOOGLE_VALUE_YES) $options['height'] = SZ_PLUGIN_GOOGLE_VALUE_AUTO;

			// Creazione del codice HTML per il widget attuale richiamando la
			// funzione base che viene richiamata anche dallo shortcode corrispondente

			$HTML = sz_google_module_plus_get_code_followers($options);

			// Output del codice HTML legato al widget da visualizzare
			// chiamata alla funzione generale per wrap standard

			echo $this->common_widget($args,$instance,$HTML);
		}

		// Funzione per modifica parametri collegati al widget con 
		// memorizzazione dei valori direttamente nel database wordpress

		function update($new_instance,$old_instance) 
		{
			return $this->common_update(array(
				'title'       => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'method'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'specific'    => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'width'       => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'width_auto'  => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'height'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'height_auto' => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'align'       => SZ_PLUGIN_GOOGLE_VALUE_YES,
			),$new_instance,$old_instance);
		}

		// Funzione per la visualizzazione del form presente sulle 
		// sidebar nel pannello di amministrazione di wordpress
	
		function form($instance) 
		{
			$array = array(
				'title'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'method'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'specific'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width'       => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_SIZE_PORTRAIT,
				'width_auto'  => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'height'      => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_HEIGHT,
				'height_auto' => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'align'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			);

			// Creazione array per elenco campi da recuperare su FORM

			$instance = wp_parse_args((array) $instance,$array);

			// Richiamo il template per la visualizzazione della
			// parte che riguarda il pannello di amministrazione

			@require(SZ_PLUGIN_GOOGLE_BASENAME_WIDGETS_BACKEND.__CLASS__.'.php');
		}
	}
}