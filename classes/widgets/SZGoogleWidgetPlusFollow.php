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
if (!class_exists('SZGoogleWidgetPlusFollow'))
{
	class SZGoogleWidgetPlusFollow extends SZGoogleWidget
	{
		// Costruttore principale della classe widget, definizione 
		// delle opzioni legate al widget e al controllo dello stesso

		function __construct() 
		{
			parent::__construct('SZ-GOOGLE-PLUS-FOLLOW',__('SZ-Google - G+ Follow','szgoogleadmin'),array(
				'classname'   => 'sz-widget-google sz-widget-google-plus sz-widget-google-plus-follow', 
				'description' => ucfirst(__('google+ follow.','szgoogleadmin'))
			));
		}

		// Funzione per la visualizzazione del widget con lettura parametri
		// di configurazione e preparazione codice HTML da usare nella sidebar

		function widget($args,$instance) 
		{
			// Controllo se esistono le variabili che servono durante l'elaborazione
			// dello script e assegno dei valori di default nel caso non fossero specificati

			$options = $this->common_empty(array(
				'url'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'size'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'annotation'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'float'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'align'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'text'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'img'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'rel'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'position'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'margintop'    => SZ_PLUGIN_GOOGLE_VALUE_NONE,
				'marginright'  => SZ_PLUGIN_GOOGLE_VALUE_NONE,
				'marginbottom' => SZ_PLUGIN_GOOGLE_VALUE_NONE,
				'marginleft'   => SZ_PLUGIN_GOOGLE_VALUE_NONE,
				'marginunit'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'action'       => SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET,
			),$instance);

			// Definizione delle variabili di controllo del widget, questi valori non
			// interessano le opzioni della funzione base ma incidono su alcuni aspetti

			$controls = $this->common_empty(array(
				'badge'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'urltype'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			),$instance);

			// Se sul widget ho escluso il badge dal pulsante azzero anche
			// le variabili del badge eventualmente impostate e memorizzate 

			if ($controls['badge'] != SZ_PLUGIN_GOOGLE_VALUE_YES) 
			{
				$options['img']      = SZ_PLUGIN_GOOGLE_VALUE_NULL;
				$options['text']     = SZ_PLUGIN_GOOGLE_VALUE_NULL;
				$options['position'] = SZ_PLUGIN_GOOGLE_VALUE_NULL;
			}

			// Lettura opzioni generali per impostazione dei dati di default

			global $SZ_PLUS_OBJECT;
			$general = $SZ_PLUS_OBJECT->getOptions();

			// Imposto i valori di default nel caso siano specificati dei valori
			// che non appartengono al range dei valori accettati

			if ($controls['urltype'] == '2') {
				if ($general['plus_page'] == SZ_PLUGIN_GOOGLE_VALUE_NULL) $options['url'] = 'https://plus.google.com/'.SZ_PLUGIN_GOOGLE_PLUS_ID_PAGE;
					else $options['url'] = 'https://plus.google.com/'.$general['plus_page'];
			}

			if ($controls['urltype'] == '3') {
				if ($general['plus_profile'] == SZ_PLUGIN_GOOGLE_VALUE_NULL) $options['url'] = 'https://plus.google.com/'.SZ_PLUGIN_GOOGLE_PLUS_ID_PROFILE;
					else $options['url'] = 'https://plus.google.com/'.$general['plus_profile'];
			}

			// Creazione del codice HTML per il widget attuale richiamando la
			// funzione base che viene richiamata anche dallo shortcode corrispondente

			$HTML = sz_google_module_plus_get_code_follow($options);

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
				'badge'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'url'        => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'urltype'    => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'text'       => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'img'        => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'align'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'position'   => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'size'       => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'annotation' => SZ_PLUGIN_GOOGLE_VALUE_YES,
			),$new_instance,$old_instance);
		}

		// Funzione per la visualizzazione del form presente sulle 
		// sidebar nel pannello di amministrazione di wordpress

		function form($instance) 
		{
			$array = array(
				'title'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'badge'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'url'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'urltype'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'text'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'img'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'align'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'position'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'size'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'annotation' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			);

			// Creazione array per elenco campi da recuperare su FORM

			$instance = wp_parse_args((array) $instance,$array);

			// Richiamo il template per la visualizzazione della
			// parte che riguarda il pannello di amministrazione

			@require(SZ_PLUGIN_GOOGLE_BASENAME_WIDGETS_BACKEND.__CLASS__.'.php');
		}
	}
}