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
if (!class_exists('SZGoogleWidgetYoutubeVideo'))
{
	class SZGoogleWidgetYoutubeVideo extends SZGoogleWidget
	{
		function __construct() 
		{
			parent::__construct('SZ-Google-Youtube-Video',__('SZ-Google - Youtube video','szgoogleadmin'),array(
				'classname'   => 'sz-widget-google sz-widget-google-youtube sz-widget-google-youtube-video', 
				'description' => ucfirst(__('youtube video.','szgoogleadmin'))
			));
		}

		// Funzione per la visualizzazione del widget con lettura parametri
		// di configurazione e preparazione codice HTML da usare nella sidebar

		function widget($args,$instance) 
		{
			// Controllo se esistono le variabili che servono durante l'elaborazione
			// dello script e assegno dei valori di default nel caso non fossero specificati

			$options = $this->common_empty(array(
				'title'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'url'             => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'responsive'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'height'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'margintop'       => SZ_PLUGIN_GOOGLE_VALUE_ZERO,
				'marginright'     => SZ_PLUGIN_GOOGLE_VALUE_ZERO,
				'marginbottom'    => SZ_PLUGIN_GOOGLE_VALUE_ZERO,
				'marginleft'      => SZ_PLUGIN_GOOGLE_VALUE_ZERO,
				'marginunit'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'analytics'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'delayed'         => SZ_PLUGIN_GOOGLE_YOUTUBE_NO,
				'autoplay'        => SZ_PLUGIN_GOOGLE_YOUTUBE_NO,
				'loop'            => SZ_PLUGIN_GOOGLE_YOUTUBE_NO,
				'fullscreen'      => SZ_PLUGIN_GOOGLE_YOUTUBE_YES,
				'schemaorg'       => SZ_PLUGIN_GOOGLE_YOUTUBE_NO,
				'disableiframe'   => SZ_PLUGIN_GOOGLE_YOUTUBE_NO,
				'disablekeyboard' => SZ_PLUGIN_GOOGLE_YOUTUBE_NO,
				'disablerelated'  => SZ_PLUGIN_GOOGLE_YOUTUBE_NO,
				'name'            => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'description'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'duration'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'start'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'end'             => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'theme'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'cover'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			),$instance);

			// Azzeramento variabile title per non confonderla con il title che deve
			// essere usato a livello di shortcode e non nei widgets

			$options['title'] = SZ_PLUGIN_GOOGLE_VALUE_NULL;

			// Creazione del codice HTML per il widget attuale richiamando la
			// funzione base che viene richiamata anche dallo shortcode corrispondente

			$HTML = sz_google_module_youtube_get_code_video($options);

			// Output del codice HTML legato al widget da visualizzare
			// chiamata alla funzione generale per wrap standard

			echo $this->common_widget($args,$instance,$HTML);
		}

		// Funzione per modifica parametri collegati al widget con 
		// memorizzazione dei valori direttamente nel database wordpress

		function update($new_instance,$old_instance) 
		{
			return $this->common_update(array(
				'title'           => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'url'             => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'responsive'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'width'           => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'height'          => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'delayed'         => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'autoplay'        => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'loop'            => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'fullscreen'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'schemaorg'       => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'disableiframe'   => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'disablekeyboard' => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'disablerelated'  => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'start'           => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'end'             => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'theme'           => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'cover'           => SZ_PLUGIN_GOOGLE_VALUE_YES,
			),$new_instance,$old_instance);
		}

		// Funzione per la visualizzazione del form presente sulle 
		// sidebar nel pannello di amministrazione di wordpress
	
		function form($instance) 
		{
			$array = array(
				'title'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'url'             => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'responsive'      => SZ_PLUGIN_GOOGLE_YOUTUBE_YES,
				'width'           => SZ_PLUGIN_GOOGLE_YOUTUBE_WIDGET_WIDTH,
				'height'          => SZ_PLUGIN_GOOGLE_YOUTUBE_WIDGET_HEIGHT,
				'delayed'         => SZ_PLUGIN_GOOGLE_YOUTUBE_NO,
				'autoplay'        => SZ_PLUGIN_GOOGLE_YOUTUBE_NO,
				'loop'            => SZ_PLUGIN_GOOGLE_YOUTUBE_NO,
				'fullscreen'      => SZ_PLUGIN_GOOGLE_YOUTUBE_YES,
				'schemaorg'       => SZ_PLUGIN_GOOGLE_YOUTUBE_NO,
				'disableiframe'   => SZ_PLUGIN_GOOGLE_YOUTUBE_NO,
				'disablekeyboard' => SZ_PLUGIN_GOOGLE_YOUTUBE_NO,
				'disablerelated'  => SZ_PLUGIN_GOOGLE_YOUTUBE_NO,
				'start'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'end'             => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'theme'           => SZ_PLUGIN_GOOGLE_YOUTUBE_THEME,
				'cover'           => SZ_PLUGIN_GOOGLE_YOUTUBE_COVER,
			);

			// Creazione array per elenco campi da recuperare su FORM

			$instance = wp_parse_args((array)$instance,$array);

			// Richiamo il template per la visualizzazione della
			// parte che riguarda il pannello di amministrazione

			@require(SZ_PLUGIN_GOOGLE_BASENAME_WIDGETS_BACKEND.__CLASS__.'.php');
		}
	}
}