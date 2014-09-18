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
	'type'        => '', // valore predefinito
	'id'          => '', // valore predefinito
	'folderview'  => '', // valore predefinito
	'single'      => '', // valore predefinito
	'gid'         => '', // valore predefinito
	'range'       => '', // valore predefinito
	'start'       => '', // valore predefinito
	'loop'        => '', // valore predefinito
	'delay'       => '', // valore predefinito
	'width'       => '', // valore predefinito
	'width_auto'  => '', // valore predefinito
	'height'      => '', // valore predefinito
	'height_auto' => '', // valore predefinito
);

// Creazione array per elenco campi da recuperare su FORM e
// caricamento del file con il template HTML da visualizzare

extract(wp_parse_args($instance,$array),EXTR_OVERWRITE);

// Lettura delle opzioni per il controllo dei valori di default
// da assegnare al widget nel momento che viene inserito in sidebar

if ($object = SZGoogleModule::getObject('SZGoogleModuleDrive')) 
{
	$options = (object) $object->getOptions();

	if (!ctype_digit($width)  and $width  != 'auto') $width  = $options->drive_embed_s_width;
	if (!ctype_digit($height) and $height != 'auto') $height = $options->drive_embed_s_height;
}

// Impostazione eventuale di parametri di default per i
// campi che contengono dei valori non validi o non coerenti 

$DEFAULT = include(dirname(SZ_PLUGIN_GOOGLE_MAIN)."/options/sz_google_options_drive.php");

if (!ctype_digit($width)  or $width  == 0) { $width  = $DEFAULT['drive_embed_s_width']['value'];  $width_auto  = '1'; }
if (!ctype_digit($height) or $height == 0) { $height = $DEFAULT['drive_embed_s_height']['value']; $height_auto = '1'; }

// Caricamento template ADMIN per composizione shortcodes
// utilizzando in molti casi lo stesso codice del Widget

@include(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/admin/mce/shortcodes/SZGoogleBaseHeader.php');
@include(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/admin/widgets/SZGoogleWidgetDriveEmbed.php');
@include(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/admin/mce/shortcodes/SZGoogleBaseFooter.php');