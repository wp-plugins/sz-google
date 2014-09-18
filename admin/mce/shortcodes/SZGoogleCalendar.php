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
	'title'         => '', // valore predefinito
	'calendarT'     => '', // valore predefinito
	'calendar'      => '', // valore predefinito
	'mode'          => '', // valore predefinito
	'weekstart'     => '', // valore predefinito
	'language'      => '', // valore predefinito
	'timezone'      => '', // valore predefinito
	'width'         => '', // valore predefinito
	'height'        => '', // valore predefinito
	'showtitle'     => '', // valore predefinito
	'shownavs'      => '', // valore predefinito
	'showdate'      => '', // valore predefinito
	'showprint'     => '', // valore predefinito
	'showtabs'      => '', // valore predefinito
	'showcalendars' => '', // valore predefinito
	'showtimezone'  => '', // valore predefinito
	'width_auto'    => '', // valore predefinito
	'height_auto'   => '', // valore predefinito
);

// Creazione array per elenco campi da recuperare su FORM e
// caricamento del file con il template HTML da visualizzare

extract(wp_parse_args($instance,$array),EXTR_OVERWRITE);

// Lettura delle opzioni per il controllo dei valori di default
// da assegnare al widget nel momento che viene inserito in sidebar

if ($object = SZGoogleModule::getObject('SZGoogleModuleCalendar')) 
{
	$options = (object) $object->getOptions();

	if ($options->calendar_s_show_title     == '1') $options->calendar_s_show_title     = 'y'; else $options->calendar_s_show_title     = 'n';
	if ($options->calendar_s_show_navs      == '1') $options->calendar_s_show_navs      = 'y'; else $options->calendar_s_show_navs      = 'n';
	if ($options->calendar_s_show_date      == '1') $options->calendar_s_show_date      = 'y'; else $options->calendar_s_show_date      = 'n';
	if ($options->calendar_s_show_print     == '1') $options->calendar_s_show_print     = 'y'; else $options->calendar_s_show_print     = 'n';
	if ($options->calendar_s_show_tabs      == '1') $options->calendar_s_show_tabs      = 'y'; else $options->calendar_s_show_tabs      = 'n';
	if ($options->calendar_s_show_calendars == '1') $options->calendar_s_show_calendars = 'y'; else $options->calendar_s_show_calendars = 'n';
	if ($options->calendar_s_show_timezone  == '1') $options->calendar_s_show_timezone  = 'y'; else $options->calendar_s_show_timezone  = 'n';

	if ($mode          == '') $mode          = $options->calendar_o_mode;
	if ($weekstart     == '') $weekstart     = $options->calendar_o_weekstart;
	if ($language      == '') $language      = $options->calendar_o_language;
	if ($timezone      == '') $timezone      = $options->calendar_o_timezone;
	if ($showtitle     == '') $showtitle     = $options->calendar_s_show_title;
	if ($shownavs      == '') $shownavs      = $options->calendar_s_show_navs;
	if ($showdate      == '') $showdate      = $options->calendar_s_show_date;
	if ($showprint     == '') $showprint     = $options->calendar_s_show_print;
	if ($showtabs      == '') $showtabs      = $options->calendar_s_show_tabs;
	if ($showcalendars == '') $showcalendars = $options->calendar_s_show_calendars;
	if ($showtimezone  == '') $showtimezone  = $options->calendar_s_show_timezone;

	if (!ctype_digit($width)  and $width  != 'auto') $width  = $options->calendar_s_width;
	if (!ctype_digit($height) and $height != 'auto') $height = $options->calendar_s_height;
}

// Impostazione eventuale di parametri di default per i
// campi che contengono dei valori non validi o non coerenti 

$DEFAULT = include(dirname(SZ_PLUGIN_GOOGLE_MAIN)."/options/sz_google_options_calendar.php");

if (!ctype_digit($width)  or $width  == 0) { $width  = $DEFAULT['calendar_s_width']['value'];  $width_auto  = '1'; }
if (!ctype_digit($height) or $height == 0) { $height = $DEFAULT['calendar_s_height']['value']; $height_auto = '1'; }

// Caricamento template ADMIN per composizione shortcodes
// utilizzando in molti casi lo stesso codice del Widget

@include(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/admin/mce/shortcodes/SZGoogleBaseHeader.php');
@include(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/admin/widgets/SZGoogleWidgetCalendar.php');
@include(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/admin/mce/shortcodes/SZGoogleBaseFooter.php');