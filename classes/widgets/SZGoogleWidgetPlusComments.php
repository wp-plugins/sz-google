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
if (!class_exists('SZGoogleWidgetPlusComments'))
{
	class SZGoogleWidgetPlusComments extends SZGoogleWidget
	{
		// Costruttore principale della classe widget, definizione 
		// delle opzioni legate al widget e al controllo dello stesso

		function __construct() 
		{
			parent::__construct('SZ-Google-Comments',__('SZ-Google - G+ Comments','szgoogleadmin'),array(
				'classname'   => 'sz-widget-google sz-widget-google-plus sz-widget-google-plus-comments', 
				'description' => ucfirst(__('google+ comments.','szgoogleadmin'))
			));
		}

		// Funzione per la visualizzazione del widget con lettura parametri
		// di configurazione e preparazione codice HTML da usare nella sidebar

		function widget($args,$instance) 
		{
			// Controllo se esistono le variabili che servono durante l'elaborazione
			// dello script e assegno dei valori di default nel caso non fossero specificati

			$options = $this->common_empty(array(
				'url'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'align'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'title'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'class1'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'class2'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'action'     => SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET,
			),$instance);

			// Definizione delle variabili di controllo del widget, questi valori non
			// interessano le opzioni della funzione base ma incidono su alcuni aspetti

			$controls = $this->common_empty(array(
				'method'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width_auto' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			),$instance);

			// Se sul widget ho escluso il badge dal pulsante azzero anche
			// le variabili del badge eventualmente impostate e memorizzate 

			if ($controls['method']     == SZ_PLUGIN_GOOGLE_VALUE_YES) $options['url']   = SZ_PLUGIN_GOOGLE_VALUE_NULL;
			if ($controls['width_auto'] == SZ_PLUGIN_GOOGLE_VALUE_YES) $options['width'] = SZ_PLUGIN_GOOGLE_VALUE_AUTO;

			// Creazione del codice HTML per il widget attuale richiamando la
			// funzione base che viene richiamata anche dallo shortcode corrispondente

			if ($object = SZGoogleModule::$SZGoogleModulePlus) {
				$HTML = $object->getPlusCommentsShortcode($options);
			}

			// Output del codice HTML legato al widget da visualizzare
			// chiamata alla funzione generale per wrap standard

			echo $this->common_widget($args,$instance,$HTML);
		}

		// Funzione per modifica parametri collegati al widget con 
		// memorizzazione dei valori direttamente nel database wordpress

		function update($new_instance,$old_instance) 
		{
			return $this->common_update(array(
				'title'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'method'     => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'url'        => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'width'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'width_auto' => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'align'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
			),$new_instance,$old_instance);
		}

		// Funzione per la visualizzazione del form presente sulle 
		// sidebar nel pannello di amministrazione di wordpress
	
		function form($instance) 
		{
			$array = array(
				'title'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'url'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'method'     => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'width'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width_auto' => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'align'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			);

			// Creazione array per elenco campi da recuperare su FORM

			$instance   = wp_parse_args((array) $instance,$array);

			// Richiamo il template per la visualizzazione della
			// parte che riguarda il pannello di amministrazione

			@require(SZ_PLUGIN_GOOGLE_BASENAME_WIDGETS_BACKEND.__CLASS__.'.php');
		}
	}
}