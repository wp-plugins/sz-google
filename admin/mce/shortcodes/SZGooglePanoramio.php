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
	'title'       => '', // valore predefinito
	'template'    => '', // valore predefinito
	'width'       => '', // valore predefinito
	'width_auto'  => '', // valore predefinito
	'height'      => '', // valore predefinito
	'height_auto' => '', // valore predefinito
	'user'        => '', // valore predefinito
	'group'       => '', // valore predefinito
	'tag'         => '', // valore predefinito
	'set'         => '', // valore predefinito
	'columns'     => '', // valore predefinito
	'rows'        => '', // valore predefinito
	'orientation' => '', // valore predefinito
	'position'    => '', // valore predefinito
);

// Creazione array per elenco campi da recuperare su FORM e
// caricamento del file con il template HTML da visualizzare

extract(wp_parse_args($instance,$array),EXTR_OVERWRITE);

// Lettura delle opzioni per il controllo dei valori di default
// da assegnare al widget nel momento che viene inserito in sidebar

if ($object = SZGoogleModule::getObject('SZGoogleModulePanoramio')) 
{
	$options = (object) $object->getOptions();

	if (!ctype_digit($columns)) $columns = $options->panoramio_s_columns;
	if (!ctype_digit($rows))    $rows    = $options->panoramio_s_rows;

	if (!in_array($template    ,array('photo','slideshow','list','photo_list'))) $options->panoramio_s_template;
	if (!in_array($set         ,array('all','public','recent')))                 $options->panoramio_s_set;
	if (!in_array($orientation ,array('horizontal','vertical')))                 $options->panoramio_s_orientation;
	if (!in_array($position    ,array('left','top','right','bottom')))           $options->panoramio_s_position;

	if (!ctype_digit($width)  and $width  != 'auto') $width  = $options->panoramio_s_width;
	if (!ctype_digit($height) and $height != 'auto') $height = $options->panoramio_s_height;
}

// Impostazione eventuale di parametri di default per i
// campi che contengono dei valori non validi o non coerenti 

$DEFAULT = include(dirname(SZ_PLUGIN_GOOGLE_MAIN)."/options/sz_google_options_panoramio.php");

if (!ctype_digit($columns)) $columns = $DEFAULT['panoramio_s_columns']['value'];
if (!ctype_digit($rows))    $rows    = $DEFAULT['panoramio_s_rows']['value'];

if (!in_array($template    ,array('photo','slideshow','list','photo_list'))) $template    = $DEFAULT['panoramio_s_template']['value'];
if (!in_array($set         ,array('all','public','recent')))                 $set         = $DEFAULT['panoramio_s_set']['value'];
if (!in_array($orientation ,array('horizontal','vertical')))                 $orientation = $DEFAULT['panoramio_s_orientation']['value'];
if (!in_array($position    ,array('left','top','right','bottom')))           $position    = $DEFAULT['panoramio_s_position']['value'];

if (!ctype_digit($width)  or $width  == 0) { $width  = $DEFAULT['panoramio_s_width']['value'];  $width_auto  = '1'; }
if (!ctype_digit($height) or $height == 0) { $height = $DEFAULT['panoramio_s_height']['value']; $height_auto = '1'; }

// Caricamento template ADMIN per composizione shortcodes
// utilizzando in molti casi lo stesso codice del Widget

@include(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/admin/mce/shortcodes/SZGoogleBaseHeader.php');
@include(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/admin/widgets/SZGoogleWidgetPanoramio.php');
@include(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/admin/mce/shortcodes/SZGoogleBaseFooter.php');