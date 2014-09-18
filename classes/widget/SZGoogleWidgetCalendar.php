<?php
/**
 * Classe per la definizione di uno widget che viene
 * richiamato dalla classe del modulo principale
 *
 * @package SZGoogle
 * @subpackage SZGoogleWidget 
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Prima di eseguire il caricamento della classe controllo
// se per caso esiste già una definizione con lo stesso nome

if (!class_exists('SZGoogleWidgetCalendar'))
{
	/**
	 * Definizione della classe principale da utilizzare per questo
	 * modulo. La classe deve essere una extends di SZGoogleWidget
	 */
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
		 * Generazione del codice HTML del widget per la 
		 * visualizzazione completa nella sidebar di appartenenza
		 */
		function widget($args,$instance)
		{
			// Controllo se esistono le variabili che servono durante l'elaborazione
			// dello script e assegno dei valori di default nel caso non fossero specificati

			$options = $this->common_empty(array(
				'title'         => '', // valore predefinito
				'calendar'      => '', // valore predefinito
				'mode'          => '', // valore predefinito
				'weekstart'     => '', // valore predefinito
				'language'      => '', // valore predefinito
				'timezone'      => '', // valore predefinito
				'width'         => '', // valore predefinito
				'height'        => '', // valore predefinito
				'showtitle'     => '', // valore predefinito
				'shownavs'      => '', // valore predefinito
				'showdate'      => '', // valore predefinito
				'showprint'     => '', // valore predefinito
				'showtabs'      => '', // valore predefinito
				'showcalendars' => '', // valore predefinito
				'showtimezone'  => '', // valore predefinito
			),$instance);

			// Definizione delle variabili di controllo del widget, questi valori non
			// interessano le opzioni della funzione base ma incidono su alcuni aspetti

			$controls = $this->common_empty(array(
				'calendarT'     => '', // valore predefinito
				'width_auto'    => '', // valore predefinito
				'height_auto'   => '', // valore predefinito
			),$instance);

			// Correzione del valore di dimensione nel caso venga
			// specificata la maniera automatica e quindi usare javascript

			if ($controls['width_auto']  == '1') $options['width']  = 'auto';
			if ($controls['height_auto'] == '1') $options['height'] = 'auto';

			// Annullo la variabile titolo che appartiene al componente in 
			// quanto esiste il titolo del widget e hanno lo stesso nome

			$options['title'] = $controls['calendarT'];

			// Creazione del codice HTML per il widget attuale richiamando la
			// funzione base che viene richiamata anche dallo shortcode corrispondente

			$OBJC = new SZGoogleActionCalendar();
			$HTML = $OBJC->getHTMLCode($options);

			// Output del codice HTML legato al widget da visualizzare
			// chiamata alla funzione generale per wrap standard

			echo $this->common_widget($args,$instance,$HTML);
		}

		/**
		 * Modifica parametri collegati al FORM del widget con la
		 * memorizzazione dei valori direttamente nel database wordpress
		 */
		function update($new_instance,$old_instance) 
		{
			// Esecuzione operazioni aggiuntive sui campi presenti
			// nel form widget prima della memorizzazione database

			return $this->common_update(array(
				'title'         => '0', // esecuzione strip_tags
				'calendarT'     => '0', // esecuzione strip_tags
				'calendar'      => '1', // esecuzione strip_tags
				'mode'          => '1', // esecuzione strip_tags
				'weekstart'     => '1', // esecuzione strip_tags
				'language'      => '1', // esecuzione strip_tags
				'timezone'      => '1', // esecuzione strip_tags
				'width'         => '1', // esecuzione strip_tags
				'height'        => '1', // esecuzione strip_tags
				'showtitle'     => '1', // esecuzione strip_tags
				'shownavs'      => '1', // esecuzione strip_tags
				'showdate'      => '1', // esecuzione strip_tags
				'showprint'     => '1', // esecuzione strip_tags
				'showtabs'      => '1', // esecuzione strip_tags
				'showcalendars' => '1', // esecuzione strip_tags
				'showtimezone'  => '1', // esecuzione strip_tags
				'width_auto'    => '1', // esecuzione strip_tags
				'height_auto'   => '1', // esecuzione strip_tags
			),$new_instance,$old_instance);
		}

		/**
		 * Visualizzazione FORM del widget presente nella gestione 
		 * delle sidebar nel pannello di amministrazione di wordpress
		 */
		function form($instance) 
		{
			// Creazione array per elenco campi che devono essere 
			// presenti nel form prima di richiamare wp_parse_args()

			$array = array(
				'title'         => '', // valore predefinito
				'calendarT'     => '', // valore predefinito
				'calendar'      => '', // valore predefinito
				'mode'          => '', // valore predefinito
				'weekstart'     => '', // valore predefinito
				'language'      => '', // valore predefinito
				'timezone'      => '', // valore predefinito
				'width'         => '', // valore predefinito
				'height'        => '', // valore predefinito
				'showtitle'     => '', // valore predefinito
				'shownavs'      => '', // valore predefinito
				'showdate'      => '', // valore predefinito
				'showprint'     => '', // valore predefinito
				'showtabs'      => '', // valore predefinito
				'showcalendars' => '', // valore predefinito
				'showtimezone'  => '', // valore predefinito
				'width_auto'    => '', // valore predefinito
				'height_auto'   => '', // valore predefinito
			);

			// Creazione array per elenco campi da recuperare su FORM e
			// caricamento del file con il template HTML da visualizzare

			extract(wp_parse_args($instance,$array),EXTR_OVERWRITE);

			// Lettura delle opzioni per il controllo dei valori di default
			// da assegnare al widget nel momento che viene inserito in sidebar

			if ($object = SZGoogleModule::getObject('SZGoogleModuleCalendar')) 
			{
				$options = (object) $object->getOptions();

				if ($options->calendar_w_show_title     == '1') $options->calendar_w_show_title     = 'y'; else $options->calendar_w_show_title     = 'n';
				if ($options->calendar_w_show_navs      == '1') $options->calendar_w_show_navs      = 'y'; else $options->calendar_w_show_navs      = 'n';
				if ($options->calendar_w_show_date      == '1') $options->calendar_w_show_date      = 'y'; else $options->calendar_w_show_date      = 'n';
				if ($options->calendar_w_show_print     == '1') $options->calendar_w_show_print     = 'y'; else $options->calendar_w_show_print     = 'n';
				if ($options->calendar_w_show_tabs      == '1') $options->calendar_w_show_tabs      = 'y'; else $options->calendar_w_show_tabs      = 'n';
				if ($options->calendar_w_show_calendars == '1') $options->calendar_w_show_calendars = 'y'; else $options->calendar_w_show_calendars = 'n';
				if ($options->calendar_w_show_timezone  == '1') $options->calendar_w_show_timezone  = 'y'; else $options->calendar_w_show_timezone  = 'n';

				if ($mode          == '') $mode          = $options->calendar_o_mode;
				if ($weekstart     == '') $weekstart     = $options->calendar_o_weekstart;
				if ($language      == '') $language      = $options->calendar_o_language;
				if ($timezone      == '') $timezone      = $options->calendar_o_timezone;
				if ($showtitle     == '') $showtitle     = $options->calendar_w_show_title;
				if ($shownavs      == '') $shownavs      = $options->calendar_w_show_navs;
				if ($showdate      == '') $showdate      = $options->calendar_w_show_date;
				if ($showprint     == '') $showprint     = $options->calendar_w_show_print;
				if ($showtabs      == '') $showtabs      = $options->calendar_w_show_tabs;
				if ($showcalendars == '') $showcalendars = $options->calendar_w_show_calendars;
				if ($showtimezone  == '') $showtimezone  = $options->calendar_w_show_timezone;

				if (!ctype_digit($width)  and $width  != 'auto') $width  = $options->calendar_w_width;
				if (!ctype_digit($height) and $height != 'auto') $height = $options->calendar_w_height;
			}

			// Impostazione eventuale di parametri di default per i
			// campi che contengono dei valori non validi o non coerenti 

			$DEFAULT = include(dirname(SZ_PLUGIN_GOOGLE_MAIN)."/options/sz_google_options_calendar.php");

			if (!ctype_digit($width)  or $width  == 0) { $width  = $DEFAULT['calendar_w_width']['value'];  $width_auto  = '1'; }
			if (!ctype_digit($height) or $height == 0) { $height = $DEFAULT['calendar_w_height']['value']; $height_auto = '1'; }

			// Richiamo il template per la visualizzazione della
			// parte che riguarda il pannello di amministrazione

			@include(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/admin/widgets/SZGoogleWidget.php');
			@include(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/admin/widgets/' .__CLASS__.'.php');
		}
	}
}