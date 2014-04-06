<?php
/**
 * Modulo GOOGLE CALENDAR per la definizione delle funzioni che riguardano
 * sia i widget che i shortcode ma anche filtri e azioni che il modulo
 * può integrare durante l'aggiunta di funzionalità a wordpress.
 *
 * @package SZGoogle
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

/**
 * Prima della definizione della classe controllo se esiste
 * una definizione con lo stesso nome o già definita la stessa.
 */
if (!class_exists('SZGoogleModuleCalendar'))
{
	/**
	 * Definizione della classe principale da utilizzare per questo
	 * modulo. La classe deve essere una extends di SZGoogleModule
	 * dove bisogna ridefinire il metodo per il calcolo delle opzioni.
	 */
	class SZGoogleModuleCalendar extends SZGoogleModule
	{
		/**
		 * Definizione della funzione costruttore che viene richiamata
		 * nel momento della creazione di un'istanza con questa classe
		 */
		function __construct()
		{
			// Assegnazione variabile con nome classe per attivare il flag del modulo
			// nella classe di riferimento e sapere quali moduli risultano attivi

			parent::__construct('SZGoogleModuleCalendar');

			// Definizione degli shortcode collegati al modulo con un array in cui bisogna
			// specificare l'opzione di attivazione il nome dello shortcode e la funzione da eseguire

			$this->moduleShortcodes = array(
				'calendar_s_enable' => array('sz-calendar',array($this,'getCalendarEmbedShortcode'))
			);

			$this->moduleWidgets = array(
				'calendar_w_enable' => 'SZGoogleWidgetCalendar',
			);

			// Esecuzione dei componenti esistenti legati al modulo come
			// le azioni generali e la generazione di shortcode e widget.

			$this->moduleAddActions();
			$this->moduleAddShortcodes();
			$this->moduleAddWidgets();
		}

		/**
		 * Calcolo le opzioni legate al modulo con esecuzione dei 
		 * controlli formali di coerenza e impostazione dei default
		 *
		 * @return array
		 */
		function getOptions()
		{
			$options = get_option('sz_google_options_calendar');

			// Controllo delle opzioni in caso di valori non esistenti
			// richiamo della funzione per il controllo isset()

			$options = $this->checkOptionIsSet($options,array(
				'calendar_o_calendars'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'calendar_o_title'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'calendar_o_mode'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'calendar_o_weekstart'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'calendar_o_language'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'calendar_o_timezone'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'calendar_s_enable'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'calendar_s_calendars'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'calendar_s_title'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'calendar_s_width'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'calendar_s_height'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'calendar_s_show_title'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'calendar_s_show_navs'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'calendar_s_show_date'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'calendar_s_show_print'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'calendar_s_show_tabs'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'calendar_s_show_calendars' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'calendar_s_show_timezone'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'calendar_w_enable'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'calendar_w_calendars'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'calendar_w_title'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'calendar_w_width'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'calendar_w_height'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'calendar_w_show_title'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'calendar_w_show_navs'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'calendar_w_show_date'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'calendar_w_show_print'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'calendar_w_show_tabs'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'calendar_w_show_calendars' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'calendar_w_show_timezone'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			));

			// Controllo delle opzioni in caso di valori non conformi
			// richiamo della funzione per il controllo Yes o No

			$options = $this->checkOptionIsYesNo($options,array(
				'calendar_s_enable'         => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'calendar_s_show_title'     => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'calendar_s_show_navs'      => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'calendar_s_show_date'      => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'calendar_s_show_print'     => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'calendar_s_show_tabs'      => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'calendar_s_show_calendars' => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'calendar_s_show_timezone'  => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'calendar_w_enable'         => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'calendar_w_show_title'     => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'calendar_w_show_navs'      => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'calendar_w_show_date'      => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'calendar_w_show_print'     => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'calendar_w_show_tabs'      => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'calendar_w_show_calendars' => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'calendar_w_show_timezone'  => SZ_PLUGIN_GOOGLE_VALUE_NO,
			));

			// Ritorno indietro il gruppo di opzioni corretto dai
			// controlli formali della funzione di reperimento opzioni

			return $options;
		}

		/**
		 * Aggiungo le azioni del modulo corrente, questa funzione deve
		 * essere implementate per ogni modulo in maniera personalizzata
		 * non è possibile creare una funzione di standardizzazione
		 *
		 * @return void
		 */
		function moduleAddActions()
		{
			$options = $this->getOptions();
		}

		/**
		 * Aggiungo il modulo generale con lo shortcode e il widget per
		 * eseguire la funzione di embed codice google calendar
		 *
		 * @return string
		 */
		function getCalendarEmbedCode($atts=array(),$content=null)
		{
			// Estrazione dei valori specificati nello shortcode, i valori ritornati
			// sono contenuti nei nomi di variabili corrispondenti alla chiave

			if (!is_array($atts)) $atts = array();

			extract(shortcode_atts(array(
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
				'action'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			),$atts));

			// Caricamento opzioni per le variabili di configurazione che 
			// contengono i valori di default per shortcode e widgets

			$options = $this->getOptions();

			// Elimino spazi aggiunti di troppo ed eseguo la trasformazione in
			// stringa minuscolo per il controllo di valori speciali come "auto"

			$calendars     = trim($calendars);
			$title         = trim($title);
			$action        = trim($action);
			$language      = trim($language);
			$timezone      = trim($timezone);

			$mode          = strtoupper(trim($mode));
			$weekstart     = strtolower(trim($weekstart));
			$width         = strtolower(trim($width));
			$height        = strtolower(trim($height));
			$showtitle     = strtolower(trim($showtitle));
			$shownavs      = strtolower(trim($shownavs));
			$showdate      = strtolower(trim($showdate));
			$showprint     = strtolower(trim($showprint));
			$showtabs      = strtolower(trim($showtabs));
			$showcalendars = strtolower(trim($showcalendars));
			$showtimezone  = strtolower(trim($showtimezone));

			// Conversione dei valori specificati direttamete nei parametri con
			// i valori usati per la memorizzazione dei valori di default

			if ($showtitle     == 'yes' or $showtitle     == 'y') $showtitle     = SZ_PLUGIN_GOOGLE_VALUE_YES; 
			if ($shownavs      == 'yes' or $shownavs      == 'y') $shownavs      = SZ_PLUGIN_GOOGLE_VALUE_YES; 
			if ($showdate      == 'yes' or $showdate      == 'y') $showdate      = SZ_PLUGIN_GOOGLE_VALUE_YES; 
			if ($showprint     == 'yes' or $showprint     == 'y') $showprint     = SZ_PLUGIN_GOOGLE_VALUE_YES; 
			if ($showtabs      == 'yes' or $showtabs      == 'y') $showtabs      = SZ_PLUGIN_GOOGLE_VALUE_YES; 
			if ($showcalendars == 'yes' or $showcalendars == 'y') $showcalendars = SZ_PLUGIN_GOOGLE_VALUE_YES; 
			if ($showtimezone  == 'yes' or $showtimezone  == 'y') $showtimezone  = SZ_PLUGIN_GOOGLE_VALUE_YES; 

			if ($showtitle     == 'no'  or $showtitle     == 'n') $showtitle     = SZ_PLUGIN_GOOGLE_VALUE_NO; 
			if ($shownavs      == 'no'  or $shownavs      == 'n') $shownavs      = SZ_PLUGIN_GOOGLE_VALUE_NO; 
			if ($showdate      == 'no'  or $showdate      == 'n') $showdate      = SZ_PLUGIN_GOOGLE_VALUE_NO; 
			if ($showprint     == 'no'  or $showprint     == 'n') $showprint     = SZ_PLUGIN_GOOGLE_VALUE_NO; 
			if ($showtabs      == 'no'  or $showtabs      == 'n') $showtabs      = SZ_PLUGIN_GOOGLE_VALUE_NO; 
			if ($showcalendars == 'no'  or $showcalendars == 'n') $showcalendars = SZ_PLUGIN_GOOGLE_VALUE_NO; 
			if ($showtimezone  == 'no'  or $showtimezone  == 'n') $showtimezone  = SZ_PLUGIN_GOOGLE_VALUE_NO; 

			// Se non sono riuscito ad assegnare nessun valore con le istruzioni
			// precedenti metto dei default assoluti che possono essere cambiati

			$YESNO = array(SZ_PLUGIN_GOOGLE_VALUE_YES,SZ_PLUGIN_GOOGLE_VALUE_NO);

			if ($action == SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET)
			{
				if ($calendars == SZ_PLUGIN_GOOGLE_VALUE_NULL) $calendars = $options['calendar_w_calendars'];
				if ($title     == SZ_PLUGIN_GOOGLE_VALUE_NULL) $title     = $options['calendar_w_title'];
				if ($width     == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width     = $options['calendar_w_width'];
				if ($height    == SZ_PLUGIN_GOOGLE_VALUE_NULL) $height    = $options['calendar_w_height'];
	
				if (!in_array($showtitle    ,$YESNO)) $showtitle     = $options['calendar_w_show_title'];
				if (!in_array($shownavs     ,$YESNO)) $shownavs      = $options['calendar_w_show_navs'];
				if (!in_array($showdate     ,$YESNO)) $showdate      = $options['calendar_w_show_date'];
				if (!in_array($showprint    ,$YESNO)) $showprint     = $options['calendar_w_show_print'];
				if (!in_array($showtabs     ,$YESNO)) $showtabs      = $options['calendar_w_show_tabs'];
				if (!in_array($showcalendars,$YESNO)) $showcalendars = $options['calendar_w_show_calendars'];
				if (!in_array($showtimezone ,$YESNO)) $showtimezone  = $options['calendar_w_show_timezone'];

			} else {

				if ($calendars == SZ_PLUGIN_GOOGLE_VALUE_NULL) $calendars = $options['calendar_s_calendars'];
				if ($title     == SZ_PLUGIN_GOOGLE_VALUE_NULL) $title     = $options['calendar_s_title'];
				if ($width     == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width     = $options['calendar_s_width'];
				if ($height    == SZ_PLUGIN_GOOGLE_VALUE_NULL) $height    = $options['calendar_s_height'];

				if (!in_array($showtitle    ,$YESNO)) $showtitle     = $options['calendar_s_show_title'];
				if (!in_array($shownavs     ,$YESNO)) $shownavs      = $options['calendar_s_show_navs'];
				if (!in_array($showdate     ,$YESNO)) $showdate      = $options['calendar_s_show_date'];
				if (!in_array($showprint    ,$YESNO)) $showprint     = $options['calendar_s_show_print'];
				if (!in_array($showtabs     ,$YESNO)) $showtabs      = $options['calendar_s_show_tabs'];
				if (!in_array($showcalendars,$YESNO)) $showcalendars = $options['calendar_s_show_calendars'];
				if (!in_array($showtimezone ,$YESNO)) $showtimezone  = $options['calendar_s_show_timezone'];
			}

			// Controllo la variabile titolo se specificata nella opzione
			// in caso contrario assegno il valore speciale con traduzione in lingua

			if ($calendars == SZ_PLUGIN_GOOGLE_VALUE_NULL) $calendars = $options['calendar_o_calendars'];
			if ($title     == SZ_PLUGIN_GOOGLE_VALUE_NULL) $title     = $options['calendar_o_title'];
			if ($mode      == SZ_PLUGIN_GOOGLE_VALUE_NULL) $mode      = $options['calendar_o_mode'];
			if ($weekstart == SZ_PLUGIN_GOOGLE_VALUE_NULL) $weekstart = $options['calendar_o_weekstart'];
			if ($language  == SZ_PLUGIN_GOOGLE_VALUE_NULL) $language  = $options['calendar_o_language'];
			if ($timezone  == SZ_PLUGIN_GOOGLE_VALUE_NULL) $timezone  = $options['calendar_o_timezone'];

			if (!in_array($weekstart,array('1','2','7')))  $weekstart = SZ_PLUGIN_GOOGLE_VALUE_ONE;

			// Calcolo la variabile della lingua di traduzione da applicare al codice
			// embed del calendario di google. Valore speciale 99 per quella wordpress.

			if (!array_key_exists($language,SZGooglePluginCommon::getLanguages())) $language = $options['calendar_o_language'];;
			if (!array_key_exists($language,SZGooglePluginCommon::getLanguages())) $language = SZ_PLUGIN_GOOGLE_VALUE_LANG;

			if ($language == SZ_PLUGIN_GOOGLE_VALUE_LANG) $language = substr(get_bloginfo('language'),0,2);	

			if (!array_key_exists($timezone,SZGooglePluginCommon::getTimeZone())) $timezone = $options['calendar_o_timezone'];;
			if (!array_key_exists($timezone,SZGooglePluginCommon::getTimeZone())) $timezone = SZ_PLUGIN_GOOGLE_VALUE_NONE;

			// Controllo i valori passati in array che specificano la dimensione del widget
			// in caso contrario imposto il valore su quello specificato nelle opzioni

			if (!ctype_digit($width)  and $width  != SZ_PLUGIN_GOOGLE_VALUE_AUTO) $width  = SZ_PLUGIN_GOOGLE_VALUE_AUTO;
			if (!ctype_digit($height) and $height != SZ_PLUGIN_GOOGLE_VALUE_AUTO) $height = SZ_PLUGIN_GOOGLE_VALUE_AUTO;

			// Controllo la dimensione del widget e controllo formale dei valori numerici
			// se trovo qualche incongruenza applico i valori di default prestabiliti

			if ($width  == SZ_PLUGIN_GOOGLE_VALUE_AUTO) $width  = "100%";
			if ($width  == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width  = "100%";

			if ($height == SZ_PLUGIN_GOOGLE_VALUE_AUTO) $height = '400';
			if ($height == SZ_PLUGIN_GOOGLE_VALUE_NULL) $height = '400';

			// Creazione array contenente le variabili che devono essere usate
			// nella stringa URL di riferimento al codice embed su iframe

			$URLarray = array();

			$URLarray[] = "hl=".urlencode($language);
			$URLarray[] = "height=".urlencode($height);

			if ($title     != SZ_PLUGIN_GOOGLE_VALUE_NULL) $URLarray[] = 'title='.urlencode($title);
			if ($weekstart != SZ_PLUGIN_GOOGLE_VALUE_NULL) $URLarray[] = 'wkst=' .urlencode($weekstart);
			if ($timezone  != SZ_PLUGIN_GOOGLE_VALUE_NONE) $URLarray[] = 'ctz='  .urlencode($timezone);

			if ($mode == 'AGENDA') $URLarray[] = "mode=".urlencode($mode);
			if ($mode == 'WEEK')   $URLarray[] = "mode=".urlencode($mode);

			if ($showtitle     != SZ_PLUGIN_GOOGLE_VALUE_YES) $URLarray[] = "showTitle=0";
			if ($shownavs      != SZ_PLUGIN_GOOGLE_VALUE_YES) $URLarray[] = "showNav=0";
			if ($showdate      != SZ_PLUGIN_GOOGLE_VALUE_YES) $URLarray[] = "showDate=0";
			if ($showprint     != SZ_PLUGIN_GOOGLE_VALUE_YES) $URLarray[] = "showPrint=0";
			if ($showtabs      != SZ_PLUGIN_GOOGLE_VALUE_YES) $URLarray[] = "showTabs=0";
			if ($showcalendars != SZ_PLUGIN_GOOGLE_VALUE_YES) $URLarray[] = "showCalendars=0";
			if ($showtimezone  != SZ_PLUGIN_GOOGLE_VALUE_YES) $URLarray[] = "showTz=0";

			// Creazione array contenente i nomi dei calendari da visualizzare.
			// I nomi devono essere divisi da una virgola nella variabile specifica.

			$CALarray = explode(',',$calendars);

			foreach ($CALarray as $key=>$value) {
				if (trim($value) != SZ_PLUGIN_GOOGLE_VALUE_NULL) {
					$URLarray[] = 'src='.urlencode(trim($value));
				}
			}

			// Creazione codice HTML per embed code da inserire nella pagina wordpress
			// prima praparo il codice del bottone singolo e poi chiamo funzione di wrapping

			$HTML  = '<script type="text/javascript">';
			$HTML .= "var h='<'+'";
			$HTML .= 'iframe src="https://www.google.com/calendar/embed?'.implode("&amp;",$URLarray).'" ';
			$HTML .= 'style="border-width:0" ';
			$HTML .= 'width="' .$width .'" ';
			$HTML .= 'height="'.$height.'" ';
			$HTML .= 'frameborder="0" scrolling="no"';
			$HTML .= "></'+'iframe'+'>';";
			$HTML .= "document.write(h);";
			$HTML .= '</script>';

			// Ritorno per la funzione con tutta la stringa contenente
			// il codice HTML per l'inserimento del codice nella pagina

			return $HTML;
		}

		/**
		 * Funzione per shortcode [sz-calendar] che permette di
		 * eseguire un codice embed per il prodotto google calendar
		 *
		 * @return string
		 */
		function getCalendarEmbedShortcode($atts,$content=null) 
		{
			return $this->getCalendarEmbedCode(shortcode_atts(array(
				'calendar'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
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
				'action'        => SZ_PLUGIN_GOOGLE_VALUE_TEXT_SHORTCODE,
			),$atts),$content);
		}
	}

	/**
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 */
	if (!function_exists('szgoogle_calendar_get_object')) {
		function szgoogle_calendar_get_object() { 
			if (!is_a(SZGoogleModule::$SZGoogleModuleCalendar,'SZGoogleModuleCalendar')) return false;
				else return SZGoogleModule::$SZGoogleModuleCalendar;
		}
	}

	if (!function_exists('szgoogle_calendar_get_widget')) {
		function szgoogle_calendar_get_widget($options=array()) { 
			if (!$object = szgoogle_calendar_get_object()) return false;
				else return $object->getCalendarEmbedShortcode($options);
		}
	}
}