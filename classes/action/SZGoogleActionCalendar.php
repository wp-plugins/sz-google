<?php
/**
 * Definizione di una classe che identifica un'azione richiamata dal
 * modulo principale in base alle opzioni che sono state attivate
 * nel pannello di amministrazione o nella configurazione del plugin
 *
 * @package SZGoogle
 * @subpackage SZGoogleActions
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Prima di eseguire il caricamento della classe controllo
// se per caso esiste già una definizione con lo stesso nome

if (!class_exists('SZGoogleActionCalendar'))
{
	/**
	 * Definizione della classe principale da utilizzare per questa
	 * azione. La classe deve essere una extends di SZGoogleAction
	 */
	class SZGoogleActionCalendar extends SZGoogleAction
	{
		/**
		 * Funzione per shortcode widget calendario che permette di
		 * eseguire un codice embed per il prodotto google calendar
		 *
		 * @return string
		 */
		function getShortcode($atts,$content=null) 
		{
			return $this->getHTMLCode(shortcode_atts(array(
				'calendar'      => '', // valore predefinito
				'title'         => '', // valore predefinito
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
				'action'        => 'shortcode',
			),$atts),$content);
		}

		/**
		 * Creazione codice HTML per il componente richiamato che
		 * deve essere usato in comune sia per widget che shortcode
		 *
		 * @return string
		 */
		function getHTMLCode($atts=array(),$content=null)
		{
			if (!is_array($atts)) $atts = array();

			// Estrazione dei valori specificati nello shortcode, i valori ritornati
			// sono contenuti nei nomi di variabili corrispondenti alla chiave

			extract(shortcode_atts(array(
				'calendars'     => '', // valore predefinito
				'title'         => '', // valore predefinito
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
				'action'        => '', // valore predefinito
			),$atts));

			// Caricamento opzioni per le variabili di configurazione che 
			// contengono i valori di default per shortcode e widgets

			$options = (object) $this->getModuleOptions('SZGoogleModuleCalendar');

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

			if ($showtitle     == 'yes' or $showtitle     == 'y') $showtitle     = '1'; 
			if ($shownavs      == 'yes' or $shownavs      == 'y') $shownavs      = '1'; 
			if ($showdate      == 'yes' or $showdate      == 'y') $showdate      = '1'; 
			if ($showprint     == 'yes' or $showprint     == 'y') $showprint     = '1'; 
			if ($showtabs      == 'yes' or $showtabs      == 'y') $showtabs      = '1'; 
			if ($showcalendars == 'yes' or $showcalendars == 'y') $showcalendars = '1'; 
			if ($showtimezone  == 'yes' or $showtimezone  == 'y') $showtimezone  = '1'; 

			if ($showtitle     == 'no'  or $showtitle     == 'n') $showtitle     = '0'; 
			if ($shownavs      == 'no'  or $shownavs      == 'n') $shownavs      = '0'; 
			if ($showdate      == 'no'  or $showdate      == 'n') $showdate      = '0'; 
			if ($showprint     == 'no'  or $showprint     == 'n') $showprint     = '0'; 
			if ($showtabs      == 'no'  or $showtabs      == 'n') $showtabs      = '0'; 
			if ($showcalendars == 'no'  or $showcalendars == 'n') $showcalendars = '0'; 
			if ($showtimezone  == 'no'  or $showtimezone  == 'n') $showtimezone  = '0'; 

			// Se non sono riuscito ad assegnare nessun valore con le istruzioni
			// precedenti metto dei default assoluti che possono essere cambiati

			$YESNO = array('1','0');

			if ($action == 'widget')
			{
				if ($calendars == '') $calendars = $options->calendar_w_calendars;
				if ($title     == '') $title     = $options->calendar_w_title;
				if ($width     == '') $width     = $options->calendar_w_width;
				if ($height    == '') $height    = $options->calendar_w_height;
	
				if (!in_array($showtitle    ,$YESNO)) $showtitle     = $options->calendar_w_show_title;
				if (!in_array($shownavs     ,$YESNO)) $shownavs      = $options->calendar_w_show_navs;
				if (!in_array($showdate     ,$YESNO)) $showdate      = $options->calendar_w_show_date;
				if (!in_array($showprint    ,$YESNO)) $showprint     = $options->calendar_w_show_print;
				if (!in_array($showtabs     ,$YESNO)) $showtabs      = $options->calendar_w_show_tabs;
				if (!in_array($showcalendars,$YESNO)) $showcalendars = $options->calendar_w_show_calendars;
				if (!in_array($showtimezone ,$YESNO)) $showtimezone  = $options->calendar_w_show_timezone;

			} else {

				if ($calendars == '') $calendars = $options->calendar_s_calendars;
				if ($title     == '') $title     = $options->calendar_s_title;
				if ($width     == '') $width     = $options->calendar_s_width;
				if ($height    == '') $height    = $options->calendar_s_height;

				if (!in_array($showtitle    ,$YESNO)) $showtitle     = $options->calendar_s_show_title;
				if (!in_array($shownavs     ,$YESNO)) $shownavs      = $options->calendar_s_show_navs;
				if (!in_array($showdate     ,$YESNO)) $showdate      = $options->calendar_s_show_date;
				if (!in_array($showprint    ,$YESNO)) $showprint     = $options->calendar_s_show_print;
				if (!in_array($showtabs     ,$YESNO)) $showtabs      = $options->calendar_s_show_tabs;
				if (!in_array($showcalendars,$YESNO)) $showcalendars = $options->calendar_s_show_calendars;
				if (!in_array($showtimezone ,$YESNO)) $showtimezone  = $options->calendar_s_show_timezone;
			}

			// Controllo la variabile titolo se specificata nella opzione
			// in caso contrario assegno il valore speciale con traduzione in lingua

			if ($calendars == '') $calendars = $options->calendar_o_calendars;
			if ($title     == '') $title     = $options->calendar_o_title;
			if ($mode      == '') $mode      = $options->calendar_o_mode;
			if ($weekstart == '') $weekstart = $options->calendar_o_weekstart;
			if ($language  == '') $language  = $options->calendar_o_language;
			if ($timezone  == '') $timezone  = $options->calendar_o_timezone;

			if (!in_array($weekstart,array('1','2','7')))  $weekstart = '1';

			// Calcolo la variabile della lingua di traduzione da applicare al codice
			// embed del calendario di google. Valore speciale 99 per quella wordpress.

			if (!array_key_exists($language,SZGoogleCommon::getLanguages())) $language = $options->calendar_o_language;
			if (!array_key_exists($language,SZGoogleCommon::getLanguages())) $language = '99';

			if ($language == '99') $language = substr(get_bloginfo('language'),0,2);	

			if (!array_key_exists($timezone,SZGoogleCommon::getTimeZone())) $timezone = $options->calendar_o_timezone;
			if (!array_key_exists($timezone,SZGoogleCommon::getTimeZone())) $timezone = 'none';

			// Controllo i valori passati in array che specificano la dimensione del widget
			// in caso contrario imposto il valore su quello specificato nelle opzioni

			if (!ctype_digit($width)  and $width  != 'auto') $width  = 'auto';
			if (!ctype_digit($height) and $height != 'auto') $height = 'auto';

			// Controllo la dimensione del widget e controllo formale dei valori numerici
			// se trovo qualche incongruenza applico i valori di default prestabiliti

			if ($width  == '')     $width  = "100%";
			if ($width  == 'auto') $width  = "100%";

			if ($height == '')     $height = '400';
			if ($height == 'auto') $height = '400';

			// Creazione array contenente le variabili che devono essere usate
			// nella stringa URL di riferimento al codice embed su iframe

			$URLarray = array();

			$URLarray[] = "hl=".urlencode($language);
			$URLarray[] = "height=".urlencode($height);

			if ($title     != '') $URLarray[] = 'title='.urlencode($title);
			if ($weekstart != '') $URLarray[] = 'wkst=' .urlencode($weekstart);
			if ($timezone  != '') $URLarray[] = 'ctz='  .urlencode($timezone);

			if ($mode == 'AGENDA') $URLarray[] = "mode=".urlencode($mode);
			if ($mode == 'WEEK')   $URLarray[] = "mode=".urlencode($mode);

			if ($showtitle     != '1') $URLarray[] = "showTitle=0";
			if ($shownavs      != '1') $URLarray[] = "showNav=0";
			if ($showdate      != '1') $URLarray[] = "showDate=0";
			if ($showprint     != '1') $URLarray[] = "showPrint=0";
			if ($showtabs      != '1') $URLarray[] = "showTabs=0";
			if ($showcalendars != '1') $URLarray[] = "showCalendars=0";
			if ($showtimezone  != '1') $URLarray[] = "showTz=0";

			// Creazione array contenente i nomi dei calendari da visualizzare.
			// I nomi devono essere divisi da una virgola nella variabile specifica.

			$CALarray = explode(',',$calendars);

			foreach ($CALarray as $key=>$value) {
				if (trim($value) != '') $URLarray[] = 'src='.urlencode(trim($value));
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
	}
}