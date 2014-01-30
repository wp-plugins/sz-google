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
if (!class_exists('SZGoogleWidgetCalendar'))
{
	class SZGoogleWidgetCalendar extends SZGoogleWidget
	{
		/**
		 * Costruttore principale della classe widget, definizione
		 * delle opzioni legate al widget e al controllo dello stesso
		 */
		function __construct() 
		{
			parent::__construct('SZ-GOOGLE-CALENDAR',__('SZ-Google - Calendar','szgoogleadmin'),array(
				'classname'   => 'sz-widget-google sz-widget-google-calendar sz-widget-google-calendar-embed', 
				'description' => ucfirst(__('google calendar.','szgoogleadmin'))
			));
		}

		/**
		 * Funzione per la generazione del codice del widget come
		 * visualizzazione completa nella sidebar di appartenenza
		 */
		function widget($args,$instance) 
		{
			// Controllo se esistono le variabili che servono durante l'elaborazione
			// dello script e assegno dei valori di default nel caso non fossero specificati

			$options = $this->common_empty(array(
				'calendars'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'title'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'mode'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'weekstart'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'language'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'timezone'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'height'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'showtitle'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'shownavs'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'showdate'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'showprint'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'showtabs'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'showcalendars' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'showtimezone'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'action'        => SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET,
			),$instance);

			// Definizione delle variabili di controllo del widget, questi valori non
			// interessano le opzioni della funzione base ma incidono su alcuni aspetti

			$controls = $this->common_empty(array(
				'width_auto'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'height_auto'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			),$instance);

			// Correzione del valore di dimensione nel caso venga
			// specificata la maniera automatica e quindi usare javascript

			if ($controls['width_auto']  == SZ_PLUGIN_GOOGLE_VALUE_YES) $options['width']  = SZ_PLUGIN_GOOGLE_VALUE_AUTO;
			if ($controls['height_auto'] == SZ_PLUGIN_GOOGLE_VALUE_YES) $options['height'] = SZ_PLUGIN_GOOGLE_VALUE_AUTO;

			// Creazione del codice HTML per il widget attuale richiamando la
			// funzione base che viene richiamata anche dallo shortcode corrispondente

			if ($object = SZGoogleModule::$SZGoogleModuleCalendar) {
				$HTML = $object->getCalendarEmbedCode($options);
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
				'title'         => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'calendars'     => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'calendarT'     => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'mode'          => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'weekstart'     => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'language'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'timezone'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'width'         => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'height'        => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'showtitle'     => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'shownavs'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'showdate'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'showprint'     => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'showtabs'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'showcalendars' => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'showtimezone'  => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'width_auto'    => SZ_PLUGIN_GOOGLE_VALUE_YES,
				'height_auto'   => SZ_PLUGIN_GOOGLE_VALUE_YES,
			),$new_instance,$old_instance);
		}

		// Funzione per la visualizzazione del form presente sulle 
		// sidebar nel pannello di amministrazione di wordpress
	
		function form($instance) 
		{
			$array = array(
				'title'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'calendars'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'calendarT'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'mode'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'weekstart'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'language'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'timezone'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'height'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'showtitle'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'shownavs'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'showdate'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'showprint'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'showtabs'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'showcalendars' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'showtimezone'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'width_auto'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'height_auto'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			);

			// Creazione array per elenco campi da recuperare su FORM e
			// caricamento del file con il template HTML da visualizzare

			$instance = wp_parse_args((array) $instance,$array);

			// Lettura delle opzioni per il controllo dei valori di default
			// da assegnare al widget nel momento che viene inserito in sidebar

			if ($object = SZGoogleModule::$SZGoogleModuleCalendar) 
			{
				$options = $object->getOptions();

				if ($options['calendar_w_show_title']     == SZ_PLUGIN_GOOGLE_VALUE_YES) $options['calendar_w_show_title']     = 'y'; else $options['calendar_w_show_title']     = 'n';
				if ($options['calendar_w_show_navs']      == SZ_PLUGIN_GOOGLE_VALUE_YES) $options['calendar_w_show_navs']      = 'y'; else $options['calendar_w_show_navs']      = 'n';
				if ($options['calendar_w_show_date']      == SZ_PLUGIN_GOOGLE_VALUE_YES) $options['calendar_w_show_date']      = 'y'; else $options['calendar_w_show_date']      = 'n';
				if ($options['calendar_w_show_print']     == SZ_PLUGIN_GOOGLE_VALUE_YES) $options['calendar_w_show_print']     = 'y'; else $options['calendar_w_show_print']     = 'n';
				if ($options['calendar_w_show_tabs']      == SZ_PLUGIN_GOOGLE_VALUE_YES) $options['calendar_w_show_tabs']      = 'y'; else $options['calendar_w_show_tabs']      = 'n';
				if ($options['calendar_w_show_calendars'] == SZ_PLUGIN_GOOGLE_VALUE_YES) $options['calendar_w_show_calendars'] = 'y'; else $options['calendar_w_show_calendars'] = 'n';
				if ($options['calendar_w_show_timezone']  == SZ_PLUGIN_GOOGLE_VALUE_YES) $options['calendar_w_show_timezone']  = 'y'; else $options['calendar_w_show_timezone']  = 'n';

				if ($instance['mode']          == SZ_PLUGIN_GOOGLE_VALUE_NULL) $instance['mode']          = $options['calendar_o_mode'];
				if ($instance['weekstart']     == SZ_PLUGIN_GOOGLE_VALUE_NULL) $instance['weekstart']     = $options['calendar_o_weekstart'];
				if ($instance['language']      == SZ_PLUGIN_GOOGLE_VALUE_NULL) $instance['language']      = $options['calendar_o_language'];
				if ($instance['timezone']      == SZ_PLUGIN_GOOGLE_VALUE_NULL) $instance['timezone']      = $options['calendar_o_timezone'];
				if ($instance['showtitle']     == SZ_PLUGIN_GOOGLE_VALUE_NULL) $instance['showtitle']     = $options['calendar_w_show_title'];
				if ($instance['shownavs']      == SZ_PLUGIN_GOOGLE_VALUE_NULL) $instance['shownavs']      = $options['calendar_w_show_navs'];
				if ($instance['showdate']      == SZ_PLUGIN_GOOGLE_VALUE_NULL) $instance['showdate']      = $options['calendar_w_show_date'];
				if ($instance['showprint']     == SZ_PLUGIN_GOOGLE_VALUE_NULL) $instance['showprint']     = $options['calendar_w_show_print'];
				if ($instance['showtabs']      == SZ_PLUGIN_GOOGLE_VALUE_NULL) $instance['showtabs']      = $options['calendar_w_show_tabs'];
				if ($instance['showcalendars'] == SZ_PLUGIN_GOOGLE_VALUE_NULL) $instance['showcalendars'] = $options['calendar_w_show_calendars'];
				if ($instance['showtimezone']  == SZ_PLUGIN_GOOGLE_VALUE_NULL) $instance['showtimezone']  = $options['calendar_w_show_timezone'];

				if (!ctype_digit($instance['width']))  $instance['width']  = $options['calendar_w_width'];
				if (!ctype_digit($instance['height'])) $instance['height'] = $options['calendar_w_height'];

				if (!ctype_digit($instance['width']))  $instance['width']  = '300';
				if (!ctype_digit($instance['height'])) $instance['height'] = '400';

				if ($instance['width_auto'] == SZ_PLUGIN_GOOGLE_VALUE_NULL) {
					if ($options['calendar_w_width'] == SZ_PLUGIN_GOOGLE_VALUE_NULL or $options['calendar_w_width'] == SZ_PLUGIN_GOOGLE_VALUE_AUTO) {
						$instance['width_auto'] = SZ_PLUGIN_GOOGLE_VALUE_YES;
					}
				}

				if ($instance['height_auto'] == SZ_PLUGIN_GOOGLE_VALUE_NULL) {
					if ($options['calendar_w_height'] == SZ_PLUGIN_GOOGLE_VALUE_NULL or $options['calendar_w_height'] == SZ_PLUGIN_GOOGLE_VALUE_AUTO) {
						$instance['height_auto'] = SZ_PLUGIN_GOOGLE_VALUE_YES;
					}
				}
			}

			// Richiamo il template per la visualizzazione della
			// parte che riguarda il pannello di amministrazione

			@require(SZ_PLUGIN_GOOGLE_BASENAME_WIDGETS_BACKEND.'sz-google-widget-calendar.php');
		}
	}
}