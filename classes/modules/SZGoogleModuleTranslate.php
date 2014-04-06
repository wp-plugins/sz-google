<?php
/**
 * Modulo GOOGLE TRANSLATE per la definizione delle funzioni che riguardano
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
if (!class_exists('SZGoogleModuleTranslate'))
{
	/**
	 * Definizione della classe principale da utilizzare per questo
	 * modulo. La classe deve essere una extends di SZGoogleModule
	 * dove bisogna ridefinire il metodo per il calcolo delle opzioni.
	 */
	class SZGoogleModuleTranslate extends SZGoogleModule
	{
		static protected $NUMBERCALLS = 0;
		static protected $JAVASCRIPTS = array();

		/**
		 * Definizione della funzione costruttore che viene richiamata
		 * nel momento della creazione di un'istanza con questa classe
		 */
		function __construct()
		{
			parent::__construct('SZGoogleModuleTranslate');

			$this->moduleShortcodes = array(
				'translate_shortcode' => array('sz-gtranslate',array($this,'getTranslateShortcode')),
			);

			$this->moduleWidgets = array(
				'translate_widget'    => 'SZGoogleWidgetTranslate',
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
			$options = get_option('sz_google_options_translate');

			// Controllo delle opzioni in caso di valori non esistenti
			// richiamo della funzione per il controllo isset()

			$options = $this->checkOptionIsSet($options,array(
				'translate_meta'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'translate_mode'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'translate_language'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'translate_to'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'translate_widget'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'translate_shortcode'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'translate_automatic'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'translate_multiple'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'translate_analytics'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'translate_analytics_ua' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			));

			// Controllo delle opzioni in caso di valori non conformi
			// richiamo della funzione per il controllo isnull()

			$options = $this->checkOptionIsNull($options,array(
				'translate_mode'         => SZ_PLUGIN_GOOGLE_TRANSLATE_MODE,
				'translate_language'     => SZ_PLUGIN_GOOGLE_VALUE_LANG,
			));

			// Chiamata alla funzione comune per controllare le variabili che devono avere
			// un valore di YES o NO e nel caso non fosse possibile forzare il valore (NO)

			$options = $this->checkOptionIsYesNo($options,array(
				'translate_to'           => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'translate_widget'       => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'translate_shortcode'    => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'translate_automatic'    => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'translate_multiple'     => SZ_PLUGIN_GOOGLE_VALUE_NO,
				'translate_analytics'    => SZ_PLUGIN_GOOGLE_VALUE_NO,
			));

			// Controllo opzione di codice GA-UA nel caso debba pendere il valore
			// specificato nel modulo corrispondente se risulta attivo.

			if (is_object(self::$SZGoogleModuleAnalytics) and 
				$options['translate_analytics_ua'] == SZ_PLUGIN_GOOGLE_VALUE_NULL) 
			{
				$options_ga = self::$SZGoogleModuleAnalytics->getOptions();
				$options['translate_analytics_ua'] = $options_ga['ga_uacode'];   
			}

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
		function moduleAddActions() {
			add_action('szgoogle_head'  ,array($this,'getTranslateMetaHead'));
			add_action('szgoogle_footer',array($this,'addJavascriptToFooter'));
		}

		/**
		 * Funzione per generazione codice HTML da inserire nella     
		 * sezione HEAD come <meta name="google-translate-customization">
		 *
		 * @return string
		 */
		function getTranslateMeta() {
			if ($this->getTranslateMetaID() == SZ_PLUGIN_GOOGLE_VALUE_NULL) return NULL;
				else return '<meta name="google-translate-customization" content="'.$this->getTranslateMetaID().'"></meta>'."\n";
		}

		/**
		 * Funzione per calcolare il codice ID univoco di google da aggiungere 
		 * alla sezione HEAD come <meta name="google-translate-customization">
		 *
		 * @return void
		 */
		function getTranslateMetaID() {
			$options = $this->getOptions();
			return trim($options['translate_meta']);
		}

		/**
		 * Funzione per generazione codice HTML da inserire nella     
		 * sezione HEAD come <meta name="google-translate-customization">
		 *
		 * @return void
		 */
		function getTranslateMetaHead() {
			echo $this->getTranslateMeta();
		}

		/**
		 * Funzione per shortcode [sz-gtranslate] che permette di eseguire
		 * un selettore di lingua da utilizzare nella traduzione automatica
		 *
		 * @return string
		 */
		function getTranslateShortcode($atts,$content=null) 
		{
			return $this->getTranslateCode(shortcode_atts(array(
				'language'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'mode'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'automatic' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'multiple'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'analytics' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'uacode'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'action'    => SZ_PLUGIN_GOOGLE_VALUE_TEXT_SHORTCODE,
			),$atts),$content);
		}

		/**
		 * Aggiungo il modulo generale con lo shortcode e il widget per
		 * eseguire la funzione di start button hangout su google+
		 * Questa funzione definisce il codice HTML che deve essere generato.
		 *
		 * @return string
		 */
		function getTranslateCode($atts=array(),$content=null)
		{
			$options = $this->getOptions();

			// Estrazione dei valori specificati nello shortcode, i valori ritornati
			// sono contenuti nei nomi di variabili corrispondenti alla chiave

			if (!is_array($atts)) $atts = array();

			extract(shortcode_atts(array(
				'language'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'mode'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'automatic' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'multiple'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'analytics' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'uacode'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'action'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			),$atts));

			// Elimino spazi aggiunti di troppo ed esegui la trasformazione in
			// stringa minuscolo per il controllo di valori speciali come "auto"

			$uacode    = trim($uacode);
			$language  = strtolower(trim($language));
			$mode      = strtolower(trim($mode));
			$automatic = strtolower(trim($automatic));
			$multiple  = strtolower(trim($multiple));
			$analytics = strtolower(trim($analytics));

			// Se non sono riuscito ad assegnare nessun valore con le istruzioni
			// precedenti metto dei default assoluti che possono essere cambiati

			if ($language  == SZ_PLUGIN_GOOGLE_VALUE_NULL) $language  = $options['translate_language'];
			if ($mode      == SZ_PLUGIN_GOOGLE_VALUE_NULL) $mode      = $options['translate_mode'];
			if ($automatic == SZ_PLUGIN_GOOGLE_VALUE_NULL) $automatic = $options['translate_automatic'];
			if ($multiple  == SZ_PLUGIN_GOOGLE_VALUE_NULL) $multiple  = $options['translate_multiple'];
			if ($analytics == SZ_PLUGIN_GOOGLE_VALUE_NULL) $analytics = $options['translate_analytics'];
			if ($uacode    == SZ_PLUGIN_GOOGLE_VALUE_NULL) $uacode    = $options['translate_analytics_ua'];

			if ($options['translate_language'] == SZ_PLUGIN_GOOGLE_VALUE_LANG) $language = substr(get_bloginfo('language'),0,2);	
				else $language = trim($options['translate_language']);

			// Incremento la variabile che tiene il conto del numero dei componenti
			// elaborati e creo un id univoco da assegnare al contenitore HTML

			self::$NUMBERCALLS++;
			$uniqueID = 'sz-google-translate-unique-'.self::$NUMBERCALLS;

			// Creazione codice HTML per inserimento javascript di google 
			// inserimento del risultato dentro array globale per scrittura footer

			$JAVA  = '<script type="text/javascript">';
			$JAVA .= 'function szgoogleTranslateElementInit_'.self::$NUMBERCALLS.'() {';
			$JAVA .= 'new google.translate.TranslateElement({';
			$JAVA .= "pageLanguage:'".$language."'";

			if ($options['translate_mode'] == 'I2') $JAVA .= ",layout:google.translate.TranslateElement.InlineLayout.HORIZONTAL";
			if ($options['translate_mode'] == 'I3') $JAVA .= ",layout:google.translate.TranslateElement.InlineLayout.SIMPLE";

			if ($automatic <> SZ_PLUGIN_GOOGLE_VALUE_YES ) $JAVA .= ",autoDisplay:false";
			if ($multiple  == SZ_PLUGIN_GOOGLE_VALUE_YES ) $JAVA .= ",multilanguagePage:true";
			if ($analytics == SZ_PLUGIN_GOOGLE_VALUE_YES ) $JAVA .= ",gaTrack:true";

			if ($options['translate_analytics_ua'] <> '' ) $JAVA .= ",gaID:'".$options['translate_analytics_ua']."'";

			$JAVA .= "},'$uniqueID');}";
			$JAVA .= '</script>';

			// Creazione codice HTML per inserimento javascript di google 
			// inserimento del risultato dentro array globale per scrittura footer

			self::$JAVASCRIPTS[self::$NUMBERCALLS] = $JAVA;

			// Ritorno come codice HTML solo il contenitore con ID univoco in quanto
			// il resto del codcie javascript sarà inserito in fondo alla pagina

			return '<div id="'.$uniqueID.'"></div>';
		}

		/**
		 * Funzione per aggiungere il codice javascript della composizione
		 * widget di traduzione in fondo alla pagina e gestendo anche i casi
		 * di inserimento componenti multipli sulla stessa pagina.
		 *
		 * @return void
		 */
		function addJavascriptToFooter() 
		{
			if(is_array(self::$JAVASCRIPTS) && count(self::$JAVASCRIPTS) > 0) 
			{
				// Per ogni elemento presente in array scrivo la riga singola
				// di codice Javascript con la definizione della funzione

				foreach (self::$JAVASCRIPTS as $key=>$value) {
					echo $value."\n";
				}

				// Creazione di una funzione generica di callback per 
				// richiamare le singole funzioni precedentemente definite

				echo '<script type="text/javascript">';
				echo 'function szgoogleTranslateElementInit_0() { ';

				foreach (self::$JAVASCRIPTS as $key=>$value) {
					echo 'szgoogleTranslateElementInit_'.$key.'(); '; 
				}

				echo "}";
				echo '</script>'."\n";

				// Richiamo dello script ufficiale di google specificando una
				// funzione di callback che corrisponde a quella generica

				echo '<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=szgoogleTranslateElementInit_0"></script>'."\n";
			}
		}
	}

	/**
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 */
	if (!function_exists('szgoogle_translate_get_object')) {
		function szgoogle_translate_get_object() { 
			if (!is_a(SZGoogleModule::$SZGoogleModuleTranslate,'SZGoogleModuleTranslate')) return false;
				else return SZGoogleModule::$SZGoogleModuleTranslate;
		}
	}

	if (!function_exists('szgoogle_translate_get_code')) {
		function szgoogle_translate_get_code($options=array()) {
			if (!$object = szgoogle_translate_get_object()) return false;
				else return $object->getTranslateCode($options);
		}
	}

	if (!function_exists('szgoogle_translate_get_meta')) {
		function szgoogle_translate_get_meta() {
			if (!$object = szgoogle_translate_get_object()) return false;
				else return $object->getTranslateMeta();
		}
	}

	if (!function_exists('szgoogle_translate_get_meta_ID')) {
		function szgoogle_translate_get_meta_ID() {
			if (!$object = szgoogle_translate_get_object()) return false;
				else return $object->getTranslateMetaID();
		}
	}
}