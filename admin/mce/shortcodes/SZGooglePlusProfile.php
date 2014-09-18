<?php
/**
 * Codice HTML per il form di impostazione collegato 
 * al widget presente nella parte di amministrazione, questo
 * codice è su file separato per escluderlo dal frontend
 *
 * @package SZGoogle
 * @subpackage SZGoogleTinyMCE
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Creazione array per elenco campi che devono essere 
// presenti nel form prima di richiamare wp_parse_args()

$array = array(
	'title'      => '', // valore predefinito
	'method'     => '', // valore predefinito
	'specific'   => '', // valore predefinito
	'width'      => '', // valore predefinito
	'width_auto' => '', // valore predefinito
	'align'      => '', // valore predefinito
	'layout'     => '', // valore predefinito
	'theme'      => '', // valore predefinito
	'cover'      => '', // valore predefinito
	'tagline'    => '', // valore predefinito
	'author'     => '', // valore predefinito
);

// Creazione array per elenco campi da recuperare su FORM e
// caricamento del file con il template HTML da visualizzare

extract(wp_parse_args($instance,$array),EXTR_OVERWRITE);

// Lettura delle opzioni per il controllo dei valori di default
// da assegnare al widget nel momento che viene inserito in sidebar

if ($object = SZGoogleModule::getObject('SZGoogleModulePlus')) 
{
	$options = (object) $object->getOptions();

	if (!ctype_digit($width) and $width != 'auto') {
		if($layout == 'landscape') $width = $options->plus_shortcode_size_landscape;
			else $width = $options->plus_shortcode_size_portrait;
	}
}

// Impostazione eventuale di parametri di default per i
// campi che contengono dei valori non validi o non coerenti 

$DEFAULT = include(dirname(SZ_PLUGIN_GOOGLE_MAIN)."/options/sz_google_options_plus.php");

if (!in_array($cover  ,array('true','false')))         $cover   = 'true';
if (!in_array($tagline,array('true','false')))         $tagline = 'true';
if (!in_array($author ,array('true','false')))         $author  = 'false';
if (!in_array($theme  ,array('light','dark')))         $theme   = 'light';
if (!in_array($layout ,array('portrait','landscape'))) $layout  = 'portrait';

if (!ctype_digit($method) or $method == 0) { $method = '1'; }

if (!ctype_digit($width)  or $width  == 0) { 
	if($layout == 'landscape') $width = $DEFAULT['plus_shortcode_size_landscape']['value'];  
		else $width = $DEFAULT['plus_shortcode_size_portrait']['value'];
	$width_auto = '1';
}

// Caricamento template ADMIN per composizione shortcodes
// utilizzando in molti casi lo stesso codice del Widget

@include(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/admin/mce/shortcodes/SZGoogleBaseHeader.php');
@include(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/admin/widgets/SZGoogleWidgetPlusProfile.php');
@include(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/admin/mce/shortcodes/SZGoogleBaseFooter.php');