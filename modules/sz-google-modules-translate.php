<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_MODULES') or !SZ_PLUGIN_GOOGLE_MODULES) die();


/* ************************************************************************** */ 
/* Funzion per caricamento parte header con meta ID di translate              */
/* ************************************************************************** */ 

function sz_google_modules_translate_meta() {
	echo sz_google_modules_translate_get_meta();
}

add_action('wp_head','sz_google_modules_translate_meta');

/* ************************************************************************** */ 
/* Funzione generale per il caricamento e la messa in coerenza delle opzioni  */
/* ************************************************************************** */ 

function sz_google_modules_translate_options()
{
	// Caricamento delle opzioni per modulo google translate

	$options = get_option('sz_google_options_translate');

	// Controllo delle opzioni in caso di valori non validi

	if (!isset($options['translate_meta']))         $options['translate_meta']         = SZ_PLUGIN_GOOGLE_VALUE_NULL;
	if (!isset($options['translate_mode']))         $options['translate_mode']         = 'I1';
	if (!isset($options['translate_language']))     $options['translate_language']     = SZ_PLUGIN_GOOGLE_VALUE_LANG;
	if (!isset($options['translate_to']))           $options['translate_to']           = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['translate_widget']))       $options['translate_widget']       = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['translate_shortcode']))    $options['translate_shortcode']    = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['translate_automatic']))    $options['translate_automatic']    = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['translate_multiple']))     $options['translate_multiple']     = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['translate_analytics']))    $options['translate_analytics']    = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['translate_analytics_ua'])) $options['translate_analytics_ua'] = SZ_PLUGIN_GOOGLE_VALUE_NULL;

	// Controllo delle opzioni in caso di valori non validi

	if (trim($options['translate_language']) == SZ_PLUGIN_GOOGLE_VALUE_NULL) 
		$options['translate_language'] = SZ_PLUGIN_GOOGLE_VALUE_LANG;

	// Controllo opzione di codice GA-UA nel caso debba pendere il valore
	// specificato nel modulo corrispondente se risulta attivo.

	if (function_exists('sz_google_modules_analytics_options') and $options['translate_analytics_ua'] == SZ_PLUGIN_GOOGLE_VALUE_NULL) 
	{
		$options_ga = sz_google_modules_analytics_options();
		$options['translate_analytics_ua'] = $options_ga['ga_uacode'];   
	}

	return $options;
}

/* ************************************************************************** */ 
/* Funzione per la generazione di codice legato a google translate            */
/* ************************************************************************** */ 

function sz_google_modules_translate_get_meta_ID() 
{
	$options = sz_google_modules_translate_options();
	return trim($options['translate_meta']);
}

/* ************************************************************************** */ 
/* Funzione per la generazione di codice legato a google translate            */
/* ************************************************************************** */ 

function sz_google_modules_translate_get_meta()
{
	if (sz_google_modules_translate_get_meta_ID() <> SZ_PLUGIN_GOOGLE_VALUE_NULL) {
		$HTML  = '<meta name="google-translate-customization" ';
		$HTML .= 'content="'.sz_google_modules_translate_get_meta_ID().'">';
		$HTML .= '</meta>';
	}   

	if (isset($HTML)) return $HTML; else return '';
}

/* ************************************************************************** */ 
/* Funzione per la generazione di codice legato a google translate            */
/* ************************************************************************** */ 

function sz_google_modules_translate_get_code()
{
	// Composizione opzioni legate al modulo di google translate 

	$options = sz_google_modules_translate_options();

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
	if ($options['translate_automatic']    <> '1' ) $HTML .= ",autoDisplay:false";
	if ($options['translate_multiple']     == '1' ) $HTML .= ",multilanguagePage:true";
	if ($options['translate_analytics']    == '1' ) $HTML .= ",gaTrack:true";
	if ($options['translate_analytics_ua'] <> ''  ) $HTML .= ",gaID:'".$options['translate_analytics_ua']."'";

	$HTML .= "},'google_translate_element');}";
	$HTML .= '</script>';
	$HTML .= '<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>';

	return $HTML;
}
