<?php
/**
 * Classe SZGoogleModule per la creazione di istanze che controllino le
 * opzioni e le funzioni comuni che ogni modulo del plugin deve richiamare
 * o elaborare. Tutti i moduli devo fare riferimento a questa classe. 
 *
 * @package SZGoogle
 * @subpackage SZGoogleModule
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Prima di eseguire il caricamento della classe controllo
// se per caso esiste già una definizione con lo stesso nome

if (!class_exists('SZGoogleModule'))
{
	/**
	 * Definizione della classe principale da utilizzare come oggetto
	 * padre della definizione dei singoli moduli. Vedere il costruttore
	 * per le funzioni che devono essere implementate nel nuovo modulo
	 */
	class SZGoogleModule
	{
		/**
		 * Definizione delle variabili che contengono il puntatore
		 * oggetto al modulo di riferimento se attivato
		 */
		static private $SZGoogleModulePlus          = false;
		static private $SZGoogleModuleAuthenticator = false;
		static private $SZGoogleModuleAnalytics     = false;
		static private $SZGoogleModuleCalendar      = false;
		static private $SZGoogleModuleDrive         = false;
		static private $SZGoogleModuleGroups        = false;
		static private $SZGoogleModuleFonts         = false;
		static private $SZGoogleModuleHangouts      = false;
		static private $SZGoogleModulePanoramio     = false;
		static private $SZGoogleModuleTranslate     = false;
		static private $SZGoogleModuleYoutube       = false;

		/**
		 * Definizione delle variabili per controllare se
		 * javascript in footer con script è già stato caricato
		 */
		static private $JavascriptPlusone  = false;
		static private $JavascriptPlatform = false;

		/**
		 * Definizione delle variabili che contengono le impostazioni
		 * fatte durante la chiamata alla funzione moduleAddSetup()
		 */
		private $moduleClassName  = false;
		private $moduleOptions    = false;
		private $moduleOptionSet  = false;

		/**
		 * Definizione delle variabili che contengono le configurazioni
		 * degli oggetti collegati al modulo attuale come widgets e shortcodes
		 */
		private $moduleActions    = array();
		private $moduleShortcodes = array();
		private $moduleWidgets    = array();

		/**
		 * Definizione della funzione costruttore che viene richiamata
		 * nel momento della creazione di un'istanza con questa classe
		 */
		function __construct()
		{
			// Quando la classe viene utilizzata da una definizione di un modulo questa
			// funzione deve essere implementata per la configurazione delle opzioni

			$this->moduleAddSetup();

			// Se viene definito un nome di classe memorizzo il riferimento oggetto
			// in una variabile statica da utilizzare nelle funzioni esterne

			if (isset($this->moduleClassName)) 
			{
				if ($this->moduleClassName == 'SZGoogleModulePlus')          self::$SZGoogleModulePlus          = $this;
				if ($this->moduleClassName == 'SZGoogleModuleAnalytics')     self::$SZGoogleModuleAnalytics     = $this;
				if ($this->moduleClassName == 'SZGoogleModuleAuthenticator') self::$SZGoogleModuleAuthenticator = $this;
				if ($this->moduleClassName == 'SZGoogleModuleCalendar')      self::$SZGoogleModuleCalendar      = $this;
				if ($this->moduleClassName == 'SZGoogleModuleDrive')         self::$SZGoogleModuleDrive         = $this;
				if ($this->moduleClassName == 'SZGoogleModuleFonts')         self::$SZGoogleModuleFonts         = $this;
				if ($this->moduleClassName == 'SZGoogleModuleGroups')        self::$SZGoogleModuleGroups        = $this;
				if ($this->moduleClassName == 'SZGoogleModuleHangouts')      self::$SZGoogleModuleHangouts      = $this;
				if ($this->moduleClassName == 'SZGoogleModulePanoramio')     self::$SZGoogleModulePanoramio     = $this;
				if ($this->moduleClassName == 'SZGoogleModuleTranslate')     self::$SZGoogleModuleTranslate     = $this;
				if ($this->moduleClassName == 'SZGoogleModuleYoutube')       self::$SZGoogleModuleYoutube       = $this;
			}

			// Esecuzione dei componenti esistenti legati al modulo come
			// le azioni generali e la generazione di shortcode e widget

			if ($this->moduleOptionSet) 
			{
				$this->moduleAddActions();
				$this->moduleAddShortcodes();
				$this->moduleAddWidgets();
	 		}
 		}

		/**
		 * Calcolo le opzioni legate al modulo con esecuzione dei 
		 * controlli formali di coerenza e impostazione dei default
		 *
		 * @return array
		 */
		function getOptions()
		{ 
			if ($this->moduleOptions) return $this->moduleOptions;
				else $this->moduleOptions = $this->getOptionsSet($this->moduleOptionSet);

			// Ritorno indietro il gruppo di opzioni corretto dai
			// controlli formali eseguito dalla funzione di controllo

			return $this->moduleOptions;
		}

		/**
		 * Calcolo le opzioni legate al modulo con esecuzione dei 
		 * controlli formali di coerenza e impostazione dei default
		 *
		 * @return array
		 */
		function getOptionsSet($nameset)
		{
			$optionsDB   = get_option($nameset);
			$optionsList = include(dirname(SZ_PLUGIN_GOOGLE_MAIN)."/options/{$nameset}.php");

			// Controllo delle opzioni in caso di valori non esistenti
			// richiamo della funzione per il controllo isset()

			foreach($optionsList as $key => $item) 
			{
				// Controllo esistenza campo in elenco opzioni wordpress
				// in caso contrario aggiungo il campo in array orginale

				if (!isset($optionsDB[$key])) $optionsDB[$key] = $item['value'];

				// Controllo se il campo opzione contiene un valore di NULL
				// in questo caso assegno al valore opzione quello di default

				if (isset($item['N']) and $item['N'] == '1') {
					if ($optionsDB[$key] == '') $optionsDB[$key] = $item['value'];
				}

				// Controllo se il campo opzione contiene un valore di ZERO
				// in questo caso assegno al valore opzione quello di default

				if (isset($item['Z']) and $item['Z'] == '1') {
					if ($optionsDB[$key] == '0') $optionsDB[$key] = $item['value'];
				}

				// Controllo se il campo opzione contiene un valore di YES/NO
				// in questo caso assegno al valore opzione quello di default

				if (isset($item['Y']) and $item['Y'] == '1') {
					if (!in_array($optionsDB[$key],array('1','0'))) $optionsDB[$key] = '0';
				}
			}

			return $optionsDB;
		}

		/**
		 * Funzione per aggiungere le variabili di configurazione che
		 * permettono alle funzioni successivi di caricare i moduli
		 *
		 * @return void
		 */
		function moduleAddSetup() {}

		/**
		 * Funzione per aggiungere le azioni da eseguire in base 
		 * alle opzioni peresenti sul pannello di amministrazione
		 *
		 * @return void
		 */
		function moduleAddActions() {}

		/**
		 * Aggiungo tutti gli shortcodes che sono presenti nella variabile 
		 * protetta di configurazione del modulo $moduleShortcodes
		 *
		 * @return void
		 */
		function moduleAddShortcodes()
		{
			$options = $this->getOptions();

			foreach($this->moduleShortcodes as $optionName=>$shortcode) {
				if (isset($options[$optionName]) and $options[$optionName] == '1') {
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

			foreach($this->moduleWidgets as $optionName=>$classWidgetName) {
				if (isset($options[$optionName]) and $options[$optionName] == '1') {
					add_action('widgets_init',create_function('','return register_widget("'.$classWidgetName.'");'));
				}
			}
		}

		/**
		 * Funzioni per assegnazione valori che servono alla configurazione
		 * inziale del modulo come il nome della classe e il set di opzioni
		 */
		function moduleSetClassName($classname) { $this->moduleClassName = $classname; }
		function moduleSetOptionSet($nameset)   { $this->moduleOptionSet = $nameset;   }

		/**
		 * Aggiungo tutti gli shortcode che dovranno essere caricati
		 * tramite la memorizzazione nella variabile privata della classe
		 */
		function moduleSetShortcodes($items) {
			if (is_array($items)) $this->moduleShortcodes = $items;
		}

		/**
		 * Aggiungo tutti i widget che dovranno essere caricati
		 * tramite la memorizzazione nella variabile privata della classe
		 */
		function moduleSetWidgets($items) {
			if (is_array($items)) $this->moduleWidgets = $items;
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
		 * Funzione per aggiungere codice javascript nel footer di 
		 * wordpress con caricamento asincrono seguendo metodo google
		 *
		 * @return void
		 */
		function setJavascriptPlusOne()
		{
			// Se ho già inserito il codice javascript nella sezione footer
			// esco dalla funzione altrimenti setto la variabile e continuo

			if (self::$JavascriptPlusone) return;
				else self::$JavascriptPlusone = true;

			$addLanguage     = '';
			$addURLforScript = '';
	
			// Controllo se istanza di google plus è attiva altrimenti
			// inserisco il codice senza parametri di personalizzazione

			if ($object = self::getObject('SZGoogleModulePlus')) 
			{
				$options = (object) $object->getOptions();

				// Se nel modulo di google+ è stato indicato di non caricare
				// il framework javascript di google esco dalla funzione

				if ($options->plus_system_javascript == '1') return;

				// Controllo il codice lingua da associare al framework javascript
				// se viene indicato "99" prendo il codice lingua di wordpress

				if ($options->plus_language == '99') $addLanguage = substr(get_bloginfo('language'),0,2);	
					else $addLanguage = $options->plus_language;

				// Controllo se devo attivare raccomandazioni mobile e quindi aggiungere publisher id
				// in mancanza del plublisher di defaul o funzione disattivata non aggiungo niente

				if ($options->plus_enable_recommendations == '1' and $options->plus_page != '') {
					$addURLforScript = "?publisherid=".trim($options->plus_page);
				}
			}

			// Codice javascript per il rendering dei componenti google plus
	
			$javascript  = '<script type="text/javascript">';

			if ($addLanguage != '') $javascript .= "window.___gcfg = {lang:'".trim($addLanguage)."'};";

			$javascript .= "(function() {";
			$javascript .= "var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;";
			$javascript .= "po.src = 'https://apis.google.com/js/plusone.js".$addURLforScript."';";
			$javascript .=  "var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);";
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

			if (empty($align) or $align == 'none') return ''; 
				else return 'text-align:'.$align.';';
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

			if (!ctype_digit($margintop)    and $margintop    != 'none') $margintop    = ''; 
			if (!ctype_digit($marginright)  and $marginright  != 'none') $marginright  = ''; 
			if (!ctype_digit($marginbottom) and $marginbottom != 'none') $marginbottom = '1';
			if (!ctype_digit($marginleft)   and $marginleft   != 'none') $marginleft   = ''; 

			// Creazione del codice CSS per la composizione dei margini
			// usando le opzioni specificate negli shortcode o nelle funzioni PHP

			$HTML = '';

			if (!empty($margintop)    and $margintop    != 'none') $HTML .= 'margin-top:'   .$margintop   .$marginunit.';';
			if (!empty($marginright)  and $marginright  != 'none') $HTML .= 'margin-right:' .$marginright .$marginunit.';';
			if (!empty($marginbottom) and $marginbottom != 'none') $HTML .= 'margin-bottom:'.$marginbottom.$marginunit.';';
			if (!empty($marginleft)   and $marginleft   != 'none') $HTML .= 'margin-left:'  .$marginleft  .$marginunit.';';

			return $HTML;
		}

		/**
		 * Funzione statica per reperire il puntatore oggetto di uno 
		 * specifico modulo in modo da richiamare si suo metodi dall'esterno
		 */
		static function getObject($object) {
			if (is_a(self::${$object},$object)) return self::${$object};
				else return false;
		}
	}
}