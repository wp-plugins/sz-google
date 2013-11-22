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
		public static $SZGoogleModulePlus      = false;
		public static $SZGoogleModuleAnalytics = false;
		public static $SZGoogleModuleDrive     = false;
		public static $SZGoogleModuleGroups    = false;
		public static $SZGoogleModulePanoramio = false;
		public static $SZGoogleModuleTranslate = false;
		public static $SZGoogleModuleYoutube   = false;

		/**
		 * Definizione delle variabili che contengono le configurazioni
		 * degli oggetti collegati al modulo attuale come widgets e shortcodes
		 */

		protected $moduleWidgets    = array();
		protected $moduleShortcodes = array();

		function __construct()
		{
			$classname = get_called_class();

			// Controllo costante di DEBUG per scrittura messaggio di
			// breakpoint nel file di log PHP indicato in php.ini

			if (SZ_PLUGIN_GOOGLE_DEBUG) {
				SZGoogleDebug::log('execute construct class '.$classname);
			}

		    if ($classname == 'SZGoogleModulePlus')        self::$SZGoogleModulePlus = $this;
		    if ($classname == 'SZGoogleModuleAnalytics')   self::$SZGoogleModuleAnalytics = $this;
		    if ($classname == 'SZGoogleModuleDrive')       self::$SZGoogleModuleDrive = $this;
		    if ($classname == 'SZGoogleModuleGroups')      self::$SZGoogleModuleGroups = $this;
		    if ($classname == 'SZGoogleModulePanoramio')   self::$SZGoogleModulePanoramio = $this;
		    if ($classname == 'SZGoogleModuleTranslate')   self::$SZGoogleModuleTranslate = $this;
		    if ($classname == 'SZGoogleModuleYoutube')     self::$SZGoogleModuleYoutube = $this;
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
				'drive'         => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'analytics'     => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'groups'        => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'panoramio'     => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'translate'     => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'youtube'       => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'documentation' => SZ_PLUGIN_GOOGLE_VALUE_NO,
			));

			// Chiamata alla funzione comune per controllare le variabili che devono avere
			// un valore di YES o NO e nel caso non fosse possibile forzare il valore (NO)

			$options = $this->checkOptionIsZero($options,array(
				'plus'          => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'drive'         => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'analytics'     => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'groups'        => SZ_PLUGIN_GOOGLE_VALUE_NO,
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
				if (isset($options[$optionName]) and $options[$optionName] == SZ_PLUGIN_GOOGLE_VALUE_YES) 
				{
					if (SZ_PLUGIN_GOOGLE_DEBUG) {
						SZGoogleDebug::log('execute exec-mods point register shortcode '.$shortcode[0]);
					}
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
				if (isset($options[$optionName]) and $options[$optionName] == SZ_PLUGIN_GOOGLE_VALUE_YES) 
				{
					if (SZ_PLUGIN_GOOGLE_DEBUG) {
						SZGoogleDebug::log('execute exec-mods point register widget '.$optionName);
					}
					add_action('widgets_init',create_function('','return register_widget("'.$classWidgetName.'");'));
				}
			}
		}

		/**
		 * Aggiunta del domino di traduzione collegato al frontend
		 * con nome dominio szgoogle mentre su admin useremo szgoogleadmin 
		 *
		 * @return void
		 */
		function addLanguageDomain() {
			add_action('init',array($this,'setLanguageDomain'));
		}

		function setLanguageDomain() 
		{
			// Controllo costante di DEBUG per scrittura messaggio di
			// breakpoint nel file di log PHP indicato in php.ini

			if (SZ_PLUGIN_GOOGLE_DEBUG) {
				SZGoogleDebug::log('execute init-load point textdomain szgoogle');
			}

			load_plugin_textdomain(
				'szgoogle',false,SZ_PLUGIN_GOOGLE_BASENAME_LANGUAGE);
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
	}
}
