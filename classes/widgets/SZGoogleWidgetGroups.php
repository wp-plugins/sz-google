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
if (!class_exists('SZGoogleWidgetGroups'))
{
	class SZGoogleWidgetGroups extends SZGoogleWidget
	{
		// Costruttore principale della classe widget, definizione 
		// delle opzioni legate al widget e al controllo dello stesso

		function __construct() 
		{
			parent::__construct('sz-google-groups-iframe',__('SZ-Google - Groups','szgoogleadmin'),array(
				'classname'   => 'sz-widget-google sz-widget-google-groups sz-widget-google-groups-iframe', 
				'description' => ucfirst(__('google groups.','szgoogleadmin'))
			));
		}

		// Funzione per la visualizzazione del widget con lettura parametri
		// di configurazione e preparazione codice HTML da usare nella sidebar

		function widget($args,$instance) 
		{
			// Controllo se esistono le variabili che servono durante l'elaborazione
			// dello script e assegno dei valori di default nel caso non fossero specificati

			$options = $this->common_empty(array(
				'name'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'height'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'showsearch'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'showtabs'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'hideforumtitle' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'hidesubject'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'hl'             => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'action'         => SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET,
			),$instance);

			// Definizione delle variabili di controllo del widget, questi valori non
			// interessano le opzioni della funzione base ma incidono su alcuni aspetti

			$controls = $this->common_empty(array(
				'width_auto'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'height_auto' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			),$instance);

			// Correzione del valore di dimensione nel caso venga
			// specificata la maniera automatica e quindi usare javascript

			if ($controls['width_auto']  == SZ_PLUGIN_GOOGLE_VALUE_YES) $options['width']  = SZ_PLUGIN_GOOGLE_VALUE_AUTO;
			if ($controls['height_auto'] == SZ_PLUGIN_GOOGLE_VALUE_YES) $options['height'] = SZ_PLUGIN_GOOGLE_VALUE_AUTO;

			// Creazione del codice HTML per il widget attuale richiamando la
			// funzione base che viene richiamata anche dallo shortcode corrispondente

			if ($object = SZGoogleModule::$SZGoogleModuleGroups) {
				$HTML = $object->getGoogleGroupsCode($options);
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
				'title'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'name'           => SZ_PLUGIN_GOOGLE_GROUPS_NAME,
				'width'          => SZ_PLUGIN_GOOGLE_GROUPS_WIDTH,
				'width_auto'     => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'height'         => SZ_PLUGIN_GOOGLE_GROUPS_HEIGHT,
				'height_auto'    => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'showsearch'     => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'showtabs'       => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'hideforumtitle' => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'hidesubject'    => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'hl'             => SZ_PLUGIN_GOOGLE_VALUE_LANG,
			),$new_instance,$old_instance);
		}

		// Funzione per la visualizzazione del form presente sulle 
		// sidebar nel pannello di amministrazione di wordpress
	
		function form($instance) 
		{
			$array = array(
				'title'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'name'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width_auto'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'height'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'height_auto'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'showsearch'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'showtabs'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'hideforumtitle' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'hidesubject'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'hl'             => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			);

			// Creazione array per elenco campi da recuperare su FORM

			$instance = wp_parse_args((array) $instance,$array);

			// Lettura delle opzioni per il controllo dei valori di default
			// da assegnare al widget nel momento che viene inserito in sidebar

			if ($object = SZGoogleModule::$SZGoogleModuleGroups) 
			{
				$options = $object->getOptions();

				if (!ctype_digit($instance['width']))  $instance['width']  = $options['groups_width'];
				if (!ctype_digit($instance['height'])) $instance['height'] = $options['groups_height'];

				if (!ctype_digit($instance['width']))  { $instance['width']  = '300'; $instance['width_auto']  = SZ_PLUGIN_GOOGLE_VALUE_YES; }
				if (!ctype_digit($instance['height'])) { $instance['height'] = '700'; $instance['height_auto'] = SZ_PLUGIN_GOOGLE_VALUE_YES; }
			}

			// Richiamo il template per la visualizzazione della
			// parte che riguarda il pannello di amministrazione

			@require(SZ_PLUGIN_GOOGLE_BASENAME_WIDGETS_BACKEND.__CLASS__.'.php');
		}
	}
}