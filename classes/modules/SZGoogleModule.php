<?php
/**
 * Classe SZGoogleModule per la creazione di istanze che controllino le
 * opzioni e le funzioni comuni che ogni modulo del plugin deve richiamare
 * o elaborare. Tutti i moduli devo fare riferimento a questa classe. 
 *
 * @package SZGoogle
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

/**
 * Prima della definizione della classe controllo se esiste
 * una definizione con lo stesso nome o già definita la stessa.
 */
if (!class_exists('SZGoogleModule'))
{
	class SZGoogleModule
	{
		/**
		 * Definizione delle variabili che contengono il puntatore
		 * oggetto al modulo di riferimento se attivato
		 */
		public static $SZGoogleModulePlus          = false;
		public static $SZGoogleModuleAuthenticator = false;
		public static $SZGoogleModuleAnalytics     = false;
		public static $SZGoogleModuleCalendar      = false;
		public static $SZGoogleModuleDrive         = false;
		public static $SZGoogleModuleGroups        = false;
		public static $SZGoogleModuleFonts         = false;
		public static $SZGoogleModuleHangouts      = false;
		public static $SZGoogleModulePanoramio     = false;
		public static $SZGoogleModuleTranslate     = false;
		public static $SZGoogleModuleYoutube       = false;

		/**
		 * Definizione delle variabili per controllare se
		 * javascript in footer con script è già stato caricato
		 */
		public static $JavascriptPlusone  = false;
		public static $JavascriptPlatform = false;

		/**
		 * Definizione delle variabili che contengono le configurazioni
		 * degli oggetti collegati al modulo attuale come widgets e shortcodes
		 */
		protected $moduleWidgets    = array();
		protected $moduleShortcodes = array();

		/**
		 * Definizione della funzione costruttore che viene richiamata
		 * nel momento della creazione di un'istanza con questa classe
		 */
		function __construct($classname="")
		{
			if ($classname == 'SZGoogleModulePlus')          self::$SZGoogleModulePlus          = $this;
			if ($classname == 'SZGoogleModuleAnalytics')     self::$SZGoogleModuleAnalytics     = $this;
			if ($classname == 'SZGoogleModuleAuthenticator') self::$SZGoogleModuleAuthenticator = $this;
			if ($classname == 'SZGoogleModuleCalendar')      self::$SZGoogleModuleCalendar      = $this;
			if ($classname == 'SZGoogleModuleDrive')         self::$SZGoogleModuleDrive         = $this;
			if ($classname == 'SZGoogleModuleFonts')         self::$SZGoogleModuleFonts         = $this;
			if ($classname == 'SZGoogleModuleGroups')        self::$SZGoogleModuleGroups        = $this;
			if ($classname == 'SZGoogleModuleHangouts')      self::$SZGoogleModuleHangouts      = $this;
			if ($classname == 'SZGoogleModulePanoramio')     self::$SZGoogleModulePanoramio     = $this;
			if ($classname == 'SZGoogleModuleTranslate')     self::$SZGoogleModuleTranslate     = $this;
			if ($classname == 'SZGoogleModuleYoutube')       self::$SZGoogleModuleYoutube       = $this;
 		}

		/**
		 * Calcolo le opzioni legate al modulo con esecuzione dei 
		 * controlli formali di coerenza e impostazione dei default
		 *
		 * @return array
		 */
		function getOptions()
		{
			$options = get_option('sz_google_options_base');

			// Controllo delle opzioni in caso di valori non esistenti
			// richiamo della funzione per il controllo isset()

			$options = $this->checkOptionIsSet($options,array(
				'plus'          => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'analytics'     => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'calendar'      => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'drive'         => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'fonts'         => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'groups'        => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'hangouts'      => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'panoramio'     => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'translate'     => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'youtube'       => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'documentation' => SZ_PLUGIN_GOOGLE_VALUE_NO,
			));

			// Chiamata alla funzione comune per controllare le variabili che devono avere
			// un valore di YES o NO e nel caso non fosse possibile forzare il valore (NO)

			$options = $this->checkOptionIsZero($options,array(
				'plus'          => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'analytics'     => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'calendar'      => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'drive'         => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'fonts'         => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'groups'        => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'hangouts'      => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'panoramio'     => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'translate'     => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'youtube'       => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'documentation' => SZ_PLUGIN_GOOGLE_VALUE_NO,
			));

			// Ritorno indietro il gruppo di opzioni corretto dai
			// controlli formali della funzione di reperimento opzioni

			return $options;
		}

		/**
		 * Aggiungo tutti gli shortcodes che sono presenti nella variabile 
		 * protetta di configurazione del modulo $moduleShortcodes
		 *
		 * @return void
		 */
		function moduleAddShortcodes()
		{
			$options = $this->getOptions();

			foreach($this->moduleShortcodes as $optionName=>$shortcode) 
			{
				if (isset($options[$optionName]) and $options[$optionName] == SZ_PLUGIN_GOOGLE_VALUE_YES) {
					add_shortcode($shortcode[0],$shortcode[1]);
				}
			}
		}

		/**
		 * Aggiungo tutti i widgets che sono presenti nella variabile 
		 * protetta di configurazione del modulo $moduleWidgets
		 *
		 * @return void
		 */
		function moduleAddWidgets()
		{
			$options = $this->getOptions();

			foreach($this->moduleWidgets as $optionName=>$classWidgetName) 
			{
				if (isset($options[$optionName]) and $options[$optionName] == SZ_PLUGIN_GOOGLE_VALUE_YES) {
					add_action('widgets_init',create_function('','return register_widget("'.$classWidgetName.'");'));
				}
			}
		}

		/**
		 * Controllo formale delle opzioni legate al modulo, in questo
		 * caso eseguo un controllo di esistenza opzione in variabile.
		 *
		 * @param  string,array $options,$names
		 * @return array
		 */
		function checkOptionIsSet($options,$names) 
		{
			foreach ($names as $key => $value) {
				if (!isset($options[$key])) $options[$key] = $value;
			}
			return $options;
		}

		/**
		 * Controllo formale delle opzioni legate al modulo, in questo
		 * caso eseguo un controllo se variabile contiene NULL.
		 *
		 * @param  string,array $options,$names
		 * @return array
		 */
		function checkOptionIsNull($options,$names) 
		{
			foreach ($names as $key => $value) {
				if (isset($options[$key]) and $options[$key] == SZ_PLUGIN_GOOGLE_VALUE_NULL) {
					$options[$key] = $value;
				}
			}
			return $options;
		}

		/**
		 * Controllo formale delle opzioni legate al modulo, in questo
		 * caso eseguo un controllo se variabile contiene valori a zero.
		 *
		 * @param  string,array $options,$names
		 * @return array
		 */
		function checkOptionIsZero($options,$names) 
		{
			foreach ($names as $key => $value) {
				if (isset($options[$key]) and $options[$key] == SZ_PLUGIN_GOOGLE_VALUE_ZERO) {
					$options[$key] = $value;
				}
			}
			return $options;
		}

		/**
		 * Controllo formale delle opzioni legate al modulo, in questo
		 * caso eseguo un controllo se variabile contiene Yes or No.
		 *
		 * @param  string,array $options,$names
		 * @return array
		 */
		function checkOptionIsYesNo($options,$names) 
		{
			foreach ($names as $key => $value) {
				if (isset($options[$key])) { 
					if (!in_array($options[$key],array(SZ_PLUGIN_GOOGLE_VALUE_YES,SZ_PLUGIN_GOOGLE_VALUE_NO))) {
						$options[$key] = $value;
					}
				}
			}
			return $options;
		}

		/**
		 * Funzione per aggiungere codice javascript nel footer di 
		 * wordpress con caricamento asincrono seguendo metodo google
		 *
		 * @return void
		 */
		function setJavascriptPlatform()
		{
			// Se ho già inserito il codice javascript nella sezione footer
			// esco dalla funzione altrimenti setto la variabile e continuo

			if (self::$JavascriptPlatform) return;
				else self::$JavascriptPlatform = true;

			// Codice javascript per il rendering dei componenti google platform
			// ad esempio richiamare questo script per i bottoni di hangouts
	
			$javascript  = '<script type="text/javascript">';
			$javascript .= "(function(){";
			$javascript .= "var po=document.createElement('script');po.type='text/javascript';po.async=true;";
			$javascript .= "po.src='https://apis.google.com/js/platform.js';";
			$javascript .=  "var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(po,s);";
			$javascript .=  "})();";
			$javascript .=	"</script>"."\n";
	
			// Esecuzione echo su footer del codice javascript generato

			echo $javascript;
		}

		/**
		 * Creazione del codice CSS per la composizione dei margini
		 * usando le opzioni specificate negli shortcode o nelle funzioni PHP
		 *
		 * @return string
		 */
		function getStyleCSSfromAlign($align)
		{
			// Se non viene specificata una valori di allineamento valido
			// viene impostato il valore speciale "left" e sara applicato al testo.

			if (!in_array(strtolower($align),array('left','right','center'))) $align = 'none'; 
				else $align = strtolower($align);

			if (!empty($align) and $align != 'none') return 'text-align:'.$align.';';
				else return SZ_PLUGIN_GOOGLE_VALUE_NULL;
		}

		/**
		 * Creazione del codice CSS per la composizione dei margini
		 * usando le opzioni specificate negli shortcode o nelle funzioni PHP
		 *
		 * @return string
		 */
		function getStyleCSSfromMargins($margintop,$marginright,$marginbottom,$marginleft,$marginunit)
		{
			// Se non viene specificata una unità di misura corretta verrà
			// impostato il valore speciale "em" e sara applicato ai margini.

			if (!in_array(strtolower($marginunit),array('pt','px','em'))) $marginunit = 'em'; 
				else $marginunit = strtolower($marginunit);

			// Imposto i valori di default nel caso siano specificati dei valori
			// che non appartengono al range dei valori accettati

			if (!ctype_digit($margintop)    and $margintop    != 'none') $margintop    = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
			if (!ctype_digit($marginright)  and $marginright  != 'none') $marginright  = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
			if (!ctype_digit($marginbottom) and $marginbottom != 'none') $marginbottom = SZ_PLUGIN_GOOGLE_VALUE_ONE;
			if (!ctype_digit($marginleft)   and $marginleft   != 'none') $marginleft   = SZ_PLUGIN_GOOGLE_VALUE_NULL; 

			// Creazione del codice CSS per la composizione dei margini
			// usando le opzioni specificate negli shortcode o nelle funzioni PHP

			$HTML = '';

			if (!empty($margintop)    and $margintop    != 'none') $HTML .= 'margin-top:'   .$margintop   .$marginunit.';';
			if (!empty($marginright)  and $marginright  != 'none') $HTML .= 'margin-right:' .$marginright .$marginunit.';';
			if (!empty($marginbottom) and $marginbottom != 'none') $HTML .= 'margin-bottom:'.$marginbottom.$marginunit.';';
			if (!empty($marginleft)   and $marginleft   != 'none') $HTML .= 'margin-left:'  .$marginleft  .$marginunit.';';

			return $HTML;
		}
	}
}