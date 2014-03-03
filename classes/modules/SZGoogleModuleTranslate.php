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
 * Definizione della classe principale da utilizzare per questo
 * modulo. La classe deve essere una extends di SZGoogleModule
 * dove bisogna ridefinire il metodo per il calcolo delle opzioni.
 */
class SZGoogleModuleTranslate extends SZGoogleModule
{
	/**
	 * Definizione della funzione costruttore che viene richiamata
	 * nel momento della creazione di un'istanza con questa classe
	 */
	function __construct()
	{
		parent::__construct('SZGoogleModuleTranslate');

		$this->moduleShortcodes = array(
			'translate_shortcode' => array('sz-gtranslate','sz_google_shortcodes_translate_widget'),
		);

		$this->moduleWidgets = array(
			'translate_widget'    => 'SZGoogleWidgetTranslate',
		);
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
			'translate_mode'         => SZ_PLUGIN_GOOGLE_TRANSLATE_MODE,
			'translate_language'     => SZ_PLUGIN_GOOGLE_VALUE_LANG,
			'translate_to'           => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'translate_widget'       => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'translate_shortcode'    => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'translate_automatic'    => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'translate_multiple'     => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'translate_analytics'    => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'translate_analytics_ua' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		));

		// Controllo delle opzioni in caso di valori non conformi
		// richiamo della funzione per il controllo isnull()

		$options = $this->checkOptionIsNull($options,array(
			'translate_language'     => SZ_PLUGIN_GOOGLE_VALUE_LANG,
		));

		// Controllo opzione di codice GA-UA nel caso debba pendere il valore
		// specificato nel modulo corrispondente se risulta attivo.

		if (is_object(self::$SZGoogleModuleAnalytics) and $options['translate_analytics_ua'] == SZ_PLUGIN_GOOGLE_VALUE_NULL) 
		{
			$options_ga = self::$SZGoogleModuleAnalytics->getOptions();
			$options['translate_analytics_ua'] = $options_ga['ga_uacode'];   
		}

		// Ritorno indietro il gruppo di opzioni corretto dai
		// controlli formali della funzione di reperimento opzioni

		return $options;
	}
}

/* ************************************************************************** */ 
/* Controllo le opzioni per sapere quali componenti risultano attivati        */ 
/* ************************************************************************** */ 

global $SZ_TRANSLATE_OBJECT;

/**
 * Creazione oggetto principale per creazione ed elaborazione del
 * modulo richiesto, controllare il costruttore per azioni iniziali
 */
$SZ_TRANSLATE_OBJECT = new SZGoogleModuleTranslate();
$SZ_TRANSLATE_OBJECT->moduleAddWidgets();
$SZ_TRANSLATE_OBJECT->moduleAddShortcodes();







/* ************************************************************************** */ 
/* Funzion per caricamento parte header con meta ID di translate              */
/* ************************************************************************** */ 

function sz_google_module_translate_meta() {
	echo sz_google_module_translate_get_meta();
}

add_action('wp_head','sz_google_module_translate_meta');

/* ************************************************************************** */ 
/* Funzione per la generazione di codice legato a google translate            */
/* ************************************************************************** */ 

function sz_google_module_translate_get_meta_ID() 
{
	global $SZ_TRANSLATE_OBJECT;
	$options = $SZ_TRANSLATE_OBJECT->getOptions();

	return trim($options['translate_meta']);
}

/* ************************************************************************** */ 
/* Funzione per la generazione di codice legato a google translate            */
/* ************************************************************************** */ 

function sz_google_module_translate_get_meta()
{
	if (sz_google_module_translate_get_meta_ID() <> SZ_PLUGIN_GOOGLE_VALUE_NULL) {
		$HTML  = '<meta name="google-translate-customization" ';
		$HTML .= 'content="'.sz_google_module_translate_get_meta_ID().'">';
		$HTML .= '</meta>';
	}   

	if (isset($HTML)) return $HTML; else return '';
}

/* ************************************************************************** */ 
/* Funzione per la generazione di codice legato a google translate            */
/* ************************************************************************** */ 

function sz_google_module_translate_get_code($atts=array())
{
	global $SZ_TRANSLATE_OBJECT;
	$options = $SZ_TRANSLATE_OBJECT->getOptions();

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

	// Creazione codice HTML per inserimento javascript di google 

	$HTML  = '<div id="google_translate_element"></div>';
	$HTML .= '<script type="text/javascript">';
	$HTML .= 'function googleTranslateElementInit() {';
	$HTML .= 'new google.translate.TranslateElement({';
	$HTML .= "pageLanguage:'".$language."'";

	if ($options['translate_mode']         == 'I2') $HTML .= ",layout:google.translate.TranslateElement.InlineLayout.HORIZONTAL";
	if ($options['translate_mode']         == 'I3') $HTML .= ",layout:google.translate.TranslateElement.InlineLayout.SIMPLE";

	if ($automatic   <> SZ_PLUGIN_GOOGLE_VALUE_YES ) $HTML .= ",autoDisplay:false";
	if ($multiple    == SZ_PLUGIN_GOOGLE_VALUE_YES ) $HTML .= ",multilanguagePage:true";
	if ($analytics   == SZ_PLUGIN_GOOGLE_VALUE_YES ) $HTML .= ",gaTrack:true";

	if ($options['translate_analytics_ua'] <> ''  ) $HTML .= ",gaID:'".$options['translate_analytics_ua']."'";

	$HTML .= "},'google_translate_element');}";
	$HTML .= '</script>';
	$HTML .= '<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>';

	return $HTML;
}

/* ************************************************************************** */
/* Funzione shortcode per inserimento G+ BADGE su PAGE                        */
/* ************************************************************************** */

function sz_google_shortcodes_translate_widget($atts,$content=null) 
{
	// Estrazione dei valori specificati nello shortcode, i valori ritornati
	// sono contenuti nei nomi di variabili corrispondenti alla chiave

	extract(shortcode_atts(array(
		'language'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'mode'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'automatic' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'multiple'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'analytics' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'uacode'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts));

	// Preparazione codice HTML dello shortcode tramite la funzione
	// standard di preparazione codice sia per shortcode che widgets

	$HTML  = sz_google_module_translate_get_code(array(
		'language'  => trim($language),
		'mode'      => trim($mode),
		'automatic' => trim($automatic),
		'multiple'  => trim($multiple),
		'analytics' => trim($analytics),
		'uacode'    => trim($uacode),
	));

	return $HTML;
}
