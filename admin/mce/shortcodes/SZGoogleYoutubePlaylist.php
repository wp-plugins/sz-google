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
	'title'           => '', // valore predefinito
	'id'              => '', // valore predefinito
	'responsive'      => '', // valore predefinito
	'width'           => '', // valore predefinito
	'height'          => '', // valore predefinito
	'delayed'         => '', // valore predefinito
	'autoplay'        => '', // valore predefinito
	'loop'            => '', // valore predefinito
	'fullscreen'      => '', // valore predefinito
	'disableiframe'   => '', // valore predefinito
	'disablekeyboard' => '', // valore predefinito
	'disablerelated'  => '', // valore predefinito
	'theme'           => '', // valore predefinito
	'cover'           => '', // valore predefinito
);

// Creazione array per elenco campi da recuperare su FORM e
// caricamento del file con il template HTML da visualizzare

extract(wp_parse_args($instance,$array),EXTR_OVERWRITE);

// Lettura delle opzioni per il controllo dei valori di default
// da assegnare al widget nel momento che viene inserito in sidebar

if ($object = SZGoogleModule::getObject('SZGoogleModuleYoutube')) 
{
	$options = (object) $object->getOptions();

	if (!in_array($theme,array('light','dark')))    $theme = $options->youtube_theme;
	if (!in_array($cover,array('local','youtube'))) $cover = $options->youtube_cover;

	if (!in_array($responsive     ,array('n','y'))) $responsive      = $options->youtube_responsive;
	if (!in_array($delayed        ,array('n','y'))) $delayed         = $options->youtube_delayed;
	if (!in_array($autoplay       ,array('n','y'))) $autoplay        = $options->youtube_autoplay;
	if (!in_array($loop           ,array('n','y'))) $loop            = $options->youtube_loop;
	if (!in_array($fullscreen     ,array('n','y'))) $fullscreen      = $options->youtube_fullscreen;
	if (!in_array($disableiframe  ,array('n','y'))) $disableiframe   = $options->youtube_disableiframe;
	if (!in_array($disablekeyboard,array('n','y'))) $disablekeyboard = $options->youtube_disablekeyboard;
	if (!in_array($disablerelated ,array('n','y'))) $disablerelated  = $options->youtube_disablerelated;

	if (!ctype_digit($width)  and $width  != 'auto') $width  = $options->youtube_width;
	if (!ctype_digit($height) and $height != 'auto') $height = $options->youtube_height;
}

// Impostazione eventuale di parametri di default per i
// campi che contengono dei valori non validi o non coerenti 

$DEFAULT = include(dirname(SZ_PLUGIN_GOOGLE_MAIN)."/options/sz_google_options_youtube.php");

if (!in_array($theme,array('light','dark')))    $theme = 'dark';
if (!in_array($cover,array('local','youtube'))) $cover = 'local';

if (!in_array($responsive     ,array('0','1','n','y'))) $responsive      = $DEFAULT['youtube_responsive']['value'];
if (!in_array($delayed        ,array('0','1','n','y'))) $delayed         = $DEFAULT['youtube_delayed']['value'];
if (!in_array($autoplay       ,array('0','1','n','y'))) $autoplay        = $DEFAULT['youtube_autoplay']['value'];
if (!in_array($loop           ,array('0','1','n','y'))) $loop            = $DEFAULT['youtube_loop']['value'];
if (!in_array($fullscreen     ,array('0','1','n','y'))) $fullscreen      = $DEFAULT['youtube_fullscreen']['value'];
if (!in_array($disableiframe  ,array('0','1','n','y'))) $disableiframe   = $DEFAULT['youtube_disableiframe']['value'];
if (!in_array($disablekeyboard,array('0','1','n','y'))) $disablekeyboard = $DEFAULT['youtube_disablekeyboard']['value'];
if (!in_array($disablerelated ,array('0','1','n','y'))) $disablerelated  = $DEFAULT['youtube_disablerelated']['value'];

if (!ctype_digit($width)  or $width  == 0) { $width  = $DEFAULT['youtube_width']['value'];  $width_auto  = '1'; }
if (!ctype_digit($height) or $height == 0) { $height = $DEFAULT['youtube_height']['value']; $height_auto = '1'; }

// Purtroppo i valori di youtube sono stati impostati diversamente 
// dai valori delle opzioni di configurazione quindi facciamo un replace

$responsive      = str_replace(array('0','1'),array('n','y'),$responsive);
$delayed         = str_replace(array('0','1'),array('n','y'),$delayed);
$autoplay        = str_replace(array('0','1'),array('n','y'),$autoplay);
$loop            = str_replace(array('0','1'),array('n','y'),$loop);
$fullscreen      = str_replace(array('0','1'),array('n','y'),$fullscreen);
$disableiframe   = str_replace(array('0','1'),array('n','y'),$disableiframe);
$disablekeyboard = str_replace(array('0','1'),array('n','y'),$disablekeyboard);
$disablerelated  = str_replace(array('0','1'),array('n','y'),$disablerelated);

// Caricamento template ADMIN per composizione shortcodes
// utilizzando in molti casi lo stesso codice del Widget

@include(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/admin/mce/shortcodes/SZGoogleBaseHeader.php');
@include(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/admin/widgets/SZGoogleWidgetYoutubePlaylist.php');
@include(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/admin/mce/shortcodes/SZGoogleBaseFooter.php');