<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

/* ************************************************************************** */
/* Definizione costanti che devo essere comuni a tutti i file modules         */
/* ************************************************************************** */

define('SZ_PLUGIN_GOOGLE_MODULES',true);
define('SZ_PLUGIN_GOOGLE_MODULES_BASENAME',basename(__FILE__));

/* ************************************************************************** */ 
/* Controllo le opzioni generali per sapere i moduli da caricare              */
/* ************************************************************************** */ 

$modules = sz_google_modules_options();

if ($modules['plus']      == SZ_PLUGIN_GOOGLE_VALUE_YES) @require_once(dirname(__FILE__).'/sz-google-modules-plus.php');
if ($modules['analytics'] == SZ_PLUGIN_GOOGLE_VALUE_YES) @require_once(dirname(__FILE__).'/sz-google-modules-analytics.php');
if ($modules['groups']    == SZ_PLUGIN_GOOGLE_VALUE_YES) @require_once(dirname(__FILE__).'/sz-google-modules-groups.php');
if ($modules['translate'] == SZ_PLUGIN_GOOGLE_VALUE_YES) @require_once(dirname(__FILE__).'/sz-google-modules-translate.php');
if ($modules['youtube']   == SZ_PLUGIN_GOOGLE_VALUE_YES) @require_once(dirname(__FILE__).'/sz-google-modules-youtube.php');

/* ************************************************************************** */ 
/* Funzione generale per il caricamento e la messa in coerenza delle opzioni  */
/* ************************************************************************** */ 

function sz_google_modules_options()
{
	$options = get_option('sz_google_options_base');

	if (!isset($options['plus']))          $options['plus']          = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['analytics']))     $options['analytics']     = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['groups']))        $options['groups']        = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['translate']))     $options['translate']     = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['youtube']))       $options['youtube']       = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['documentation'])) $options['documentation'] = SZ_PLUGIN_GOOGLE_VALUE_NO;

	// Se trovo un valore non riconosciuto imposto la disattivazione del modulo

	$YESNO = array(SZ_PLUGIN_GOOGLE_VALUE_NO,SZ_PLUGIN_GOOGLE_VALUE_YES);

	if (!in_array($options['plus'],$YESNO))          $options['plus']          = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['analytics'],$YESNO))     $options['analytics']     = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['groups'],$YESNO))        $options['groups']        = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['translate'],$YESNO))     $options['translate']     = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['youtube'],$YESNO))       $options['youtube']       = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['documentation'],$YESNO)) $options['documentation'] = SZ_PLUGIN_GOOGLE_VALUE_NO;

	return $options;
}

/* ************************************************************************** */
/* COMMON CODE COMMON CODE COMMON CODE COMMON CODE COMMON CODE COMMON CODE CO */
/* MMON CODE COMMON CODE COMMON CODE COMMON CODE COMMON CODE COMMON CODE COMM */
/* ON CODE COMMON CODE COMMON CODE COMMON CODE COMMON CODE COMMON CODE COMMON */
/* CODE COMMON CODE COMMON CODE COMMON CODE COMMON CODE COMMON CODE COMMON CO */
/* DE COMMON CODE COMMON CODE COMMON CODE COMMON CODE COMMON CODE COMMON CODE */
/* ************************************************************************** */

function sz_google_modules_widget_title($args,$instance) 
{
	extract($args);

	// Costruzione del titolo del widget da utilizzare per tutti i 
	// widgets collegati al modulo attivato con questa pagina PHP

	if (empty($instance['title'])) $title = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		else $title = trim($instance['title']);

	if (!isset($before_title)) $before_title = SZ_PLUGIN_GOOGLE_VALUE_NULL;
	if (!isset($after_title))  $after_title  = SZ_PLUGIN_GOOGLE_VALUE_NULL;

	if ($title and $title <> SZ_PLUGIN_GOOGLE_VALUE_NULL) {
		$title = $before_title.$title.$after_title;
	}

	// Ritorno al widget il titolo calcolato tramite i parametri di 
	// configurazione legati al tema applicato attualmente in wordpress	 

	return $title;
}

/* ************************************************************************** */
/* COMMON CODE esecuzione operazione di flush_rules su regole rewrite         */
/* ************************************************************************** */

function sz_google_modules_flush_rules() {
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}

/* ************************************************************************** */
/* COMMON CODE controllo dei parametri in maniera singola e default           */
/* ************************************************************************** */

function sz_google_check_options($name,$value) 
{
	// Controllo se valori di default per le opzioni 
	// generali sono contenuti dentro un array valido

	if (is_array($value)) { 

		// Controllo se esistono le opzioni richieste, in caso
		// affermativo passo al controllo di ogni singola opzione 

		if ($options = get_option($name)) 
		{
			if (!is_array($options)) $options=array(); 

			foreach ($value as $key=>$item) {
				if (!isset($options[$key])) $options[$key]=$item;
			}

			update_option($name,$options);

		// Se le opzioni non esistono in quanto il plugin potrebbe
		// essere la prima volta che viene installato -> aggiungo array 

		} else {
			add_option($name,$value);
		}
	}
}

/* ************************************************************************** */
/* COMMON CODE array contenente i linguaggi supportati da google              */
/* ************************************************************************** */

function sz_google_get_languages() 
{
	$languages = array(
		'99'     => ' '.__('same language theme','szgoogleadmin'),
		'af'     => ucfirst(__('afrikaans','szgoogleadmin')),
		'am'     => ucfirst(__('amharic','szgoogleadmin')),
		'ar'     => ucfirst(__('arabic','szgoogleadmin')),
		'eu'     => ucfirst(__('basque','szgoogleadmin')),
		'bn'     => ucfirst(__('bengali','szgoogleadmin')),
		'bg'     => ucfirst(__('bulgarian','szgoogleadmin')),
		'ca'     => ucfirst(__('catalan','szgoogleadmin')),
		'zh-HK'  => ucfirst(__('chinese (Hong Kong)','szgoogleadmin')),
		'zh-CN'  => ucfirst(__('chinese (Simplified)','szgoogleadmin')),
		'zh-TW'  => ucfirst(__('chinese (Traditional)','szgoogleadmin')),
		'hr'     => ucfirst(__('croatian','szgoogleadmin')),
		'cs'     => ucfirst(__('czech','szgoogleadmin')),
		'da'     => ucfirst(__('danish','szgoogleadmin')),
		'nl'     => ucfirst(__('dutch','szgoogleadmin')),
		'en-GB'  => ucfirst(__('english (UK)','szgoogleadmin')), 	
		'en-US'  => ucfirst(__('english (US)','szgoogleadmin')),
		'et'     => ucfirst(__('estonian','szgoogleadmin')),
		'fil'    => ucfirst(__('filipino','szgoogleadmin')),
		'fi'     => ucfirst(__('finnish','szgoogleadmin')),
		'fr'     => ucfirst(__('french','szgoogleadmin')),
		'fr-CA'  => ucfirst(__('french (Canadian)','szgoogleadmin')),
		'gl'     => ucfirst(__('galician','szgoogleadmin')),
		'de'     => ucfirst(__('german','szgoogleadmin')),
		'el'     => ucfirst(__('greek','szgoogleadmin')),
		'gu'     => ucfirst(__('gujarati','szgoogleadmin')),
		'iw'     => ucfirst(__('hebrew','szgoogleadmin')),
		'hi'     => ucfirst(__('hindi','szgoogleadmin')),
		'hu'     => ucfirst(__('hungarian','szgoogleadmin')),
		'is'     => ucfirst(__('icelandic','szgoogleadmin')),
		'id'     => ucfirst(__('indonesian','szgoogleadmin')),
		'it'     => ucfirst(__('italian','szgoogleadmin')),
		'ja'     => ucfirst(__('japanese','szgoogleadmin')),
		'kn'     => ucfirst(__('kannada','szgoogleadmin')),
		'ko'     => ucfirst(__('korean','szgoogleadmin')),
		'lv'     => ucfirst(__('latvian','szgoogleadmin')),
		'lt'     => ucfirst(__('lithuanian','szgoogleadmin')),
		'ms'     => ucfirst(__('malay','szgoogleadmin')),
		'ml'     => ucfirst(__('malayalam','szgoogleadmin')),
		'mr'     => ucfirst(__('marathi','szgoogleadmin')),
		'no'     => ucfirst(__('norwegian','szgoogleadmin')),
		'fa'     => ucfirst(__('persian','szgoogleadmin')),
		'pl'     => ucfirst(__('polish','szgoogleadmin')), 	
		'pt-BR'  => ucfirst(__('portuguese (Brazil)','szgoogleadmin')),
		'pt-PT'  => ucfirst(__('portuguese (Portugal)','szgoogleadmin')),
		'ro'     => ucfirst(__('romanian','szgoogleadmin')),
		'ru'     => ucfirst(__('russian','szgoogleadmin')),
		'sr'     => ucfirst(__('serbian','szgoogleadmin')),
		'sk'     => ucfirst(__('slovak','szgoogleadmin')),
		'sl'     => ucfirst(__('slovenian','szgoogleadmin')),
		'es'     => ucfirst(__('spanish','szgoogleadmin')),
		'es-419' => ucfirst(__('spanish (Latin America)','szgoogleadmin')),
		'sw'     => ucfirst(__('swahili','szgoogleadmin')),
		'sv'     => ucfirst(__('swedish','szgoogleadmin')),
		'ta'     => ucfirst(__('tamil','szgoogleadmin')),
		'te'     => ucfirst(__('telugu','szgoogleadmin')),
		'th'     => ucfirst(__('thai','szgoogleadmin')),
		'tr'     => ucfirst(__('turkish','szgoogleadmin')),
		'uk'     => ucfirst(__('ukrainian','szgoogleadmin')),
		'ur'     => ucfirst(__('urdu','szgoogleadmin')),
		'vi'     => ucfirst(__('vietnamese','szgoogleadmin')),
		'zu'     => ucfirst(__('zulu','szgoogleadmin')),
	);

	asort($languages);
	return $languages;
}
