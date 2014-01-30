<?php
/**
 * Caricamento delle costanti da utilizzare nei vari moduli del plugin.
 * Questo file viene caricato dal file principale sz-google.php e contiene
 * le costanti di tutti i moduli del plugin sia attivi che disattivi. Usare
 * questo file per definire le costanti dei moduli che si aggiungono.
 *
 * @package SZGoogle
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

/**
 * Definizione delle costanti da usare nel plugin per uso generale,
 * qui vanno definite le costanti per le directory e i path.
 */
define('SZ_PLUGIN_GOOGLE_PATH_JS'                 ,SZ_PLUGIN_GOOGLE_PATH.'includes/js/');
define('SZ_PLUGIN_GOOGLE_PATH_IMAGE'              ,SZ_PLUGIN_GOOGLE_PATH.'includes/images/');
define('SZ_PLUGIN_GOOGLE_PATH_CSS'                ,SZ_PLUGIN_GOOGLE_PATH.'includes/css/');
define('SZ_PLUGIN_GOOGLE_PATH_CSS_IMAGE'          ,SZ_PLUGIN_GOOGLE_PATH.'includes/css/images/');

define('SZ_PLUGIN_GOOGLE_BASENAME_ADMIN'          ,SZ_PLUGIN_GOOGLE_BASENAME.'/admin/');
define('SZ_PLUGIN_GOOGLE_BASENAME_CLASSES'        ,SZ_PLUGIN_GOOGLE_BASENAME.'/classes/');
define('SZ_PLUGIN_GOOGLE_BASENAME_DATA'           ,SZ_PLUGIN_GOOGLE_BASENAME.'/data/');
define('SZ_PLUGIN_GOOGLE_BASENAME_LANGUAGE'       ,SZ_PLUGIN_GOOGLE_BASENAMP.'/languages');
define('SZ_PLUGIN_GOOGLE_BASENAME_MODULES'        ,SZ_PLUGIN_GOOGLE_BASENAME.'/modules/');
define('SZ_PLUGIN_GOOGLE_BASENAME_WIDGETS_BACKEND',SZ_PLUGIN_GOOGLE_BASENAME.'/widgets/backend/');
define('SZ_PLUGIN_GOOGLE_BASENAME_WIDGETS_CLASSES',SZ_PLUGIN_GOOGLE_BASENAME.'/widgets/classes/');

/**
 * Definizione delle costanti da usare nel plugin per uso generale,
 * qui vanno definite le costanti che contengono valori speciali e opzioni.
 */
define('SZ_PLUGIN_GOOGLE_VALUE_NO'   ,'0');
define('SZ_PLUGIN_GOOGLE_VALUE_YES'  ,'1');
define('SZ_PLUGIN_GOOGLE_VALUE_ONE'  ,'1');
define('SZ_PLUGIN_GOOGLE_VALUE_NULL' ,'');
define('SZ_PLUGIN_GOOGLE_VALUE_ZERO' ,'0');
define('SZ_PLUGIN_GOOGLE_VALUE_LANG' ,'99');
define('SZ_PLUGIN_GOOGLE_VALUE_AUTO' ,'auto');
define('SZ_PLUGIN_GOOGLE_VALUE_NONE' ,'none');
define('SZ_PLUGIN_GOOGLE_VALUE_DAY'  ,sprintf('%02d',date('d')));
define('SZ_PLUGIN_GOOGLE_VALUE_MONTH',sprintf('%02d',date('m')));
define('SZ_PLUGIN_GOOGLE_VALUE_YEAR' ,sprintf('%04d',date('Y')));
define('SZ_PLUGIN_GOOGLE_VALUE_OLD_DAY','01');
define('SZ_PLUGIN_GOOGLE_VALUE_OLD_MONTH','01');
define('SZ_PLUGIN_GOOGLE_VALUE_OLD_YEAR','2000');
define('SZ_PLUGIN_GOOGLE_VALUE_TITLEFIX','SZ-Google - ');
define('SZ_PLUGIN_GOOGLE_VALUE_CAPABILITY','manage_options');

define('SZ_PLUGIN_GOOGLE_VALUE_TEXT_MONTH_UPPER','MONTH');
define('SZ_PLUGIN_GOOGLE_VALUE_TEXT_SHORTCODE'  ,'shortcode');
define('SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET'     ,'widget');

define('SZ_PLUGIN_GOOGLE_VALUE_BUTTON_MARGIN_TOP','none');
define('SZ_PLUGIN_GOOGLE_VALUE_BUTTON_MARGIN_RIGHT','none');
define('SZ_PLUGIN_GOOGLE_VALUE_BUTTON_MARGIN_BOTTOM','1');
define('SZ_PLUGIN_GOOGLE_VALUE_BUTTON_MARGIN_LEFT','none');
define('SZ_PLUGIN_GOOGLE_VALUE_BUTTON_MARGIN_UNITS','em');
define('SZ_PLUGIN_GOOGLE_VALUE_BUTTON_FLOAT','none');
define('SZ_PLUGIN_GOOGLE_VALUE_BUTTON_ALIGN','none');
define('SZ_PLUGIN_GOOGLE_VALUE_BUTTON_POSITION','outside');

/**
 * Definizione delle costanti per il modulo di GOOGLE PLUS,
 * qui vanno definite le costanti che contengono valori speciali e opzioni.
 */
define('SZ_PLUGIN_GOOGLE_PLUS_ID_PAGE'     ,'117259631219963935481');
define('SZ_PLUGIN_GOOGLE_PLUS_ID_PROFILE'  ,'106567288702045182616');
define('SZ_PLUGIN_GOOGLE_PLUS_ID_COMMUNITY','109254048492234113886');

define('SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_WIDTH','');
define('SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_LAYOUT','portrait');
define('SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_THEME','light');
define('SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_COVER','true');
define('SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_PHOTO','true');
define('SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_TAGLINE','true');
define('SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_AUTHOR','false');
define('SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_PUBLISHER','false');
define('SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_OWNER','false');
define('SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_SIZE_PORTRAIT','350');
define('SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_SIZE_LANDSCAPE','350');

define('SZ_PLUGIN_GOOGLE_PLUS_WIDGET_LAYOUT','portrait');
define('SZ_PLUGIN_GOOGLE_PLUS_WIDGET_THEME','light');
define('SZ_PLUGIN_GOOGLE_PLUS_WIDGET_COVER','true');
define('SZ_PLUGIN_GOOGLE_PLUS_WIDGET_PHOTO','true');
define('SZ_PLUGIN_GOOGLE_PLUS_WIDGET_TAGLINE','true');
define('SZ_PLUGIN_GOOGLE_PLUS_WIDGET_AUTHOR','false');
define('SZ_PLUGIN_GOOGLE_PLUS_WIDGET_PUBLISHER','false');
define('SZ_PLUGIN_GOOGLE_PLUS_WIDGET_OWNER','false');
define('SZ_PLUGIN_GOOGLE_PLUS_WIDGET_SIZE_PORTRAIT','180');
define('SZ_PLUGIN_GOOGLE_PLUS_WIDGET_SIZE_LANDSCAPE','275');
define('SZ_PLUGIN_GOOGLE_PLUS_WIDGET_HEIGHT','300');

/**
 * Definizione delle costanti per il modulo di GOOGLE ANALYTICS,
 * qui vanno definite le costanti che contengono valori speciali e opzioni.
 */
define('SZ_PLUGIN_GOOGLE_GA_TYPE','classic');
define('SZ_PLUGIN_GOOGLE_GA_CLASSIC','classic');
define('SZ_PLUGIN_GOOGLE_GA_UNIVERSAL','universal');
define('SZ_PLUGIN_GOOGLE_GA_HEADER','H');
define('SZ_PLUGIN_GOOGLE_GA_FOOTER','F');
define('SZ_PLUGIN_GOOGLE_GA_MANUAL','M');

/**
 * Definizione delle costanti per il modulo di GOOGLE CALENDAR,
 * qui vanno definite le costanti che contengono valori speciali e opzioni.
 */
define('SZ_PLUGIN_GOOGLE_CALENDAR_O_CALENDARS'     ,SZ_PLUGIN_GOOGLE_VALUE_NULL);
define('SZ_PLUGIN_GOOGLE_CALENDAR_O_TITLE'         ,SZ_PLUGIN_GOOGLE_VALUE_NULL);
define('SZ_PLUGIN_GOOGLE_CALENDAR_O_MODE'          ,SZ_PLUGIN_GOOGLE_VALUE_TEXT_MONTH_UPPER);
define('SZ_PLUGIN_GOOGLE_CALENDAR_O_WEEKSTART'     ,SZ_PLUGIN_GOOGLE_VALUE_ONE);
define('SZ_PLUGIN_GOOGLE_CALENDAR_O_LANGUAGE'      ,SZ_PLUGIN_GOOGLE_VALUE_NULL);
define('SZ_PLUGIN_GOOGLE_CALENDAR_O_TIMEZONE'      ,SZ_PLUGIN_GOOGLE_VALUE_NONE);

define('SZ_PLUGIN_GOOGLE_CALENDAR_S_ENABLE'        ,SZ_PLUGIN_GOOGLE_VALUE_YES);
define('SZ_PLUGIN_GOOGLE_CALENDAR_S_CALENDARS'     ,SZ_PLUGIN_GOOGLE_VALUE_NULL);
define('SZ_PLUGIN_GOOGLE_CALENDAR_S_TITLE'         ,SZ_PLUGIN_GOOGLE_VALUE_NULL);
define('SZ_PLUGIN_GOOGLE_CALENDAR_S_WIDTH'         ,SZ_PLUGIN_GOOGLE_VALUE_AUTO);
define('SZ_PLUGIN_GOOGLE_CALENDAR_S_HEIGHT'        ,SZ_PLUGIN_GOOGLE_VALUE_AUTO);
define('SZ_PLUGIN_GOOGLE_CALENDAR_S_SHOW_TITLE'    ,SZ_PLUGIN_GOOGLE_VALUE_NO);
define('SZ_PLUGIN_GOOGLE_CALENDAR_S_SHOW_NAVS'     ,SZ_PLUGIN_GOOGLE_VALUE_NO);
define('SZ_PLUGIN_GOOGLE_CALENDAR_S_SHOW_DATE'     ,SZ_PLUGIN_GOOGLE_VALUE_NO);
define('SZ_PLUGIN_GOOGLE_CALENDAR_S_SHOW_PRINT'    ,SZ_PLUGIN_GOOGLE_VALUE_NO);
define('SZ_PLUGIN_GOOGLE_CALENDAR_S_SHOW_TABS'     ,SZ_PLUGIN_GOOGLE_VALUE_NO);
define('SZ_PLUGIN_GOOGLE_CALENDAR_S_SHOW_CALENDARS',SZ_PLUGIN_GOOGLE_VALUE_NO);
define('SZ_PLUGIN_GOOGLE_CALENDAR_S_SHOW_TIMEZONE' ,SZ_PLUGIN_GOOGLE_VALUE_NO);

define('SZ_PLUGIN_GOOGLE_CALENDAR_W_ENABLE'        ,SZ_PLUGIN_GOOGLE_VALUE_YES);
define('SZ_PLUGIN_GOOGLE_CALENDAR_W_CALENDARS'     ,SZ_PLUGIN_GOOGLE_VALUE_NULL);
define('SZ_PLUGIN_GOOGLE_CALENDAR_W_TITLE'         ,SZ_PLUGIN_GOOGLE_VALUE_NULL);
define('SZ_PLUGIN_GOOGLE_CALENDAR_W_WIDTH'         ,SZ_PLUGIN_GOOGLE_VALUE_AUTO);
define('SZ_PLUGIN_GOOGLE_CALENDAR_W_HEIGHT'        ,SZ_PLUGIN_GOOGLE_VALUE_AUTO);
define('SZ_PLUGIN_GOOGLE_CALENDAR_W_SHOW_TITLE'    ,SZ_PLUGIN_GOOGLE_VALUE_NO);
define('SZ_PLUGIN_GOOGLE_CALENDAR_W_SHOW_NAVS'     ,SZ_PLUGIN_GOOGLE_VALUE_NO);
define('SZ_PLUGIN_GOOGLE_CALENDAR_W_SHOW_DATE'     ,SZ_PLUGIN_GOOGLE_VALUE_NO);
define('SZ_PLUGIN_GOOGLE_CALENDAR_W_SHOW_PRINT'    ,SZ_PLUGIN_GOOGLE_VALUE_NO);
define('SZ_PLUGIN_GOOGLE_CALENDAR_W_SHOW_TABS'     ,SZ_PLUGIN_GOOGLE_VALUE_NO);
define('SZ_PLUGIN_GOOGLE_CALENDAR_W_SHOW_CALENDARS',SZ_PLUGIN_GOOGLE_VALUE_NO);
define('SZ_PLUGIN_GOOGLE_CALENDAR_W_SHOW_TIMEZONE' ,SZ_PLUGIN_GOOGLE_VALUE_NO);

/**
 * Definizione delle costanti per il modulo di GOOGLE DRIVE,
 * qui vanno definite le costanti che contengono valori speciali e opzioni.
 */
define('SZ_PLUGIN_GOOGLE_DRIVE_SITENAME','Website');

/**
 * Definizione delle costanti per il modulo di GOOGLE FONTS,
 * qui vanno definite le costanti che contengono valori speciali e opzioni.
 */
define('SZ_PLUGIN_GOOGLE_FONTS_NULL','nofonts');
define('SZ_PLUGIN_GOOGLE_FONTS_FAMILY','Roboto');

/**
 * Definizione delle costanti per il modulo di GOOGLE GROUPS,
 * qui vanno definite le costanti che contengono valori speciali e opzioni.
 */
define('SZ_PLUGIN_GOOGLE_GROUPS_NAME'  ,'adsense-api');
define('SZ_PLUGIN_GOOGLE_GROUPS_WIDTH' ,'0');
define('SZ_PLUGIN_GOOGLE_GROUPS_HEIGHT','700');

/**
 * Definizione delle costanti per il modulo di GOOGLE HANGOUTS,
 * qui vanno definite le costanti che contengono valori speciali e opzioni.
 */
define('SZ_PLUGIN_GOOGLE_HANGOUTS_TYPE','normal');
define('SZ_PLUGIN_GOOGLE_HANGOUTS_BUTTON_CLASS','sz-google-hangouts-button');
define('SZ_PLUGIN_GOOGLE_HANGOUTS_BUTTON_SIZE_WIDGET','180');
define('SZ_PLUGIN_GOOGLE_HANGOUTS_BUTTON_SIZE_SHORTCODE','180');

/**
 * Definizione delle costanti per il modulo di GOOGLE PANORAMIO,
 * qui vanno definite le costanti che contengono valori speciali e opzioni.
 */
define('SZ_PLUGIN_GOOGLE_PANORAMIO_S_TEMPLATE','photo');
define('SZ_PLUGIN_GOOGLE_PANORAMIO_S_WIDTH' ,'auto');
define('SZ_PLUGIN_GOOGLE_PANORAMIO_S_HEIGHT','300');
define('SZ_PLUGIN_GOOGLE_PANORAMIO_S_ORIENTATION','horizontal');
define('SZ_PLUGIN_GOOGLE_PANORAMIO_S_LIST_SIZE','6');
define('SZ_PLUGIN_GOOGLE_PANORAMIO_S_POSITION','bottom');
define('SZ_PLUGIN_GOOGLE_PANORAMIO_S_PARAGRAPH','1');
define('SZ_PLUGIN_GOOGLE_PANORAMIO_S_DELAY','2');
define('SZ_PLUGIN_GOOGLE_PANORAMIO_S_SET','public');
define('SZ_PLUGIN_GOOGLE_PANORAMIO_S_COLUMNS','4');
define('SZ_PLUGIN_GOOGLE_PANORAMIO_S_ROWS','1');

define('SZ_PLUGIN_GOOGLE_PANORAMIO_W_TEMPLATE','photo');
define('SZ_PLUGIN_GOOGLE_PANORAMIO_W_WIDTH' ,'auto');
define('SZ_PLUGIN_GOOGLE_PANORAMIO_W_HEIGHT','300');
define('SZ_PLUGIN_GOOGLE_PANORAMIO_W_ORIENTATION','horizontal');
define('SZ_PLUGIN_GOOGLE_PANORAMIO_W_LIST_SIZE','6');
define('SZ_PLUGIN_GOOGLE_PANORAMIO_W_POSITION','bottom');
define('SZ_PLUGIN_GOOGLE_PANORAMIO_W_DELAY','2');
define('SZ_PLUGIN_GOOGLE_PANORAMIO_W_SET','public');
define('SZ_PLUGIN_GOOGLE_PANORAMIO_W_COLUMNS','4');
define('SZ_PLUGIN_GOOGLE_PANORAMIO_W_ROWS','1');

/**
 * Definizione delle costanti per il modulo di GOOGLE TRANSLATE,
 * qui vanno definite le costanti che contengono valori speciali e opzioni.
 */
define('SZ_PLUGIN_GOOGLE_TRANSLATE_MODE','I1');

/**
 * Definizione delle costanti per il modulo di GOOGLE YOUTUBE,
 * qui vanno definite le costanti che contengono valori speciali e opzioni.
 */
define('SZ_PLUGIN_GOOGLE_YOUTUBE_NO' ,'n');
define('SZ_PLUGIN_GOOGLE_YOUTUBE_YES','y');
define('SZ_PLUGIN_GOOGLE_YOUTUBE_WIDTH' ,'600');
define('SZ_PLUGIN_GOOGLE_YOUTUBE_HEIGHT','400');
define('SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_TOP','');
define('SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_RIGHT','');
define('SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_BOTTOM','1');
define('SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_LEFT','');
define('SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_UNIT','em');
define('SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_AUTO','auto');
define('SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_ZERO','0');
define('SZ_PLUGIN_GOOGLE_YOUTUBE_THEME','dark');
define('SZ_PLUGIN_GOOGLE_YOUTUBE_COVER','local');
define('SZ_PLUGIN_GOOGLE_YOUTUBE_CHANNEL','startbyzero');
define('SZ_PLUGIN_GOOGLE_YOUTUBE_WIDGET_WIDTH' ,'300');
define('SZ_PLUGIN_GOOGLE_YOUTUBE_WIDGET_HEIGHT','200');
