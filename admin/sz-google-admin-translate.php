<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_ADMIN') or !SZ_PLUGIN_GOOGLE_ADMIN) die();

/* ************************************************************************** */
/* Creazione e aggiunta menu di amministrazione                               */
/* ************************************************************************** */

function sz_google_admin_translate_menu() 
{
	if (function_exists('add_submenu_page')) {
		add_submenu_page(SZ_PLUGIN_GOOGLE_ADMIN_BASENAME,'SZ-Google - '.ucwords(__('google translate','szgoogleadmin')),ucwords(__('google translate','szgoogleadmin')),'manage_options','sz-google-admin-translate.php','sz_google_admin_translate_callback'); 
	}
}

/* ************************************************************************** */
/* Registrazione delle opzioni legate al plugin                               */
/* ************************************************************************** */

function sz_google_admin_translate_fields()
{
	register_setting('sz_google_options_translate','sz_google_options_translate','sz_google_admin_translate_validate');

	// Definizione sezione per configurazione GOOGLE TRANSLATE ID

	add_settings_section('sz_google_translate_section','','sz_google_admin_translate_section','sz-google-admin-translate.php');
	add_settings_field('translate_meta',ucfirst(__('code for META','szgoogleadmin')),'sz_google_admin_translate_meta','sz-google-admin-translate.php','sz_google_translate_section');
	add_settings_field('translate_mode',ucfirst(__('display mode','szgoogleadmin')),'sz_google_admin_translate_mode','sz-google-admin-translate.php','sz_google_translate_section');

	// Definizione sezione per configurazione GOOGLE TRANSLATE LANGUAGE

	add_settings_section('sz_google_translate_language','','sz_google_admin_translate_languages','sz-google-admin-translate-language.php');
	add_settings_field('translate_language',ucfirst(__('website language','szgoogleadmin')),'sz_google_admin_translate_language','sz-google-admin-translate-language.php','sz_google_translate_language');

	// Definizione sezione per configurazione GOOGLE TRANSLATE ACTIVATED

	add_settings_section('sz_google_translate_active','','sz_google_admin_translate_active','sz-google-admin-translate-enable.php');
	add_settings_field('translate_widget',ucwords(__('enable widget','szgoogleadmin')),'sz_google_admin_translate_widget','sz-google-admin-translate-enable.php','sz_google_translate_active');
	add_settings_field('translate_shortcode',ucwords(__('enable shortcode','szgoogleadmin')),'sz_google_admin_translate_shortcode','sz-google-admin-translate-enable.php','sz_google_translate_active');

	// Definizione sezione per configurazione GOOGLE TRANSLATE ADVANCED

	add_settings_section('sz_google_translate_advanced','','sz_google_admin_translate_advanced','sz-google-admin-translate-advanced.php');
	add_settings_field('translate_automatic',ucfirst(__('automatic banner','szgoogleadmin')),'sz_google_admin_translate_automatic','sz-google-admin-translate-advanced.php','sz_google_translate_advanced');
	add_settings_field('translate_multiple',ucfirst(__('multiple language','szgoogleadmin')),'sz_google_admin_translate_multiple','sz-google-admin-translate-advanced.php','sz_google_translate_advanced');
	add_settings_field('translate_analytics',ucwords(__('google analytics','szgoogleadmin')),'sz_google_admin_translate_analytics','sz-google-admin-translate-advanced.php','sz_google_translate_advanced');
	add_settings_field('translate_analytics_ua',ucwords(__('google analytics UA','szgoogleadmin')),'sz_google_admin_translate_analytics_ua','sz-google-admin-translate-advanced.php','sz_google_translate_advanced');
}

/* ************************************************************************** */
/* Aggiungo le funzioni per l'esecuzione in admin                             */
/* ************************************************************************** */

add_action('admin_menu','sz_google_admin_translate_menu');
add_action('admin_init','sz_google_admin_translate_fields');

/* ************************************************************************** */
/* Funzioni per SEZIONE Configurazione Google translate                       */
/* ************************************************************************** */

function sz_google_admin_translate_callback() 
{
	// Definizione delle sezioni che devono essere composte in HTML
	// le sezioni devono essere passate come un array con nome => titolo

	$sections = array(
		'sz-google-admin-translate.php'          => ucwords(__('general setting','szgoogleadmin')),
		'sz-google-admin-translate-language.php' => ucwords(__('language setting','szgoogleadmin')),
		'sz-google-admin-translate-enable.php'   => ucwords(__('activation components','szgoogleadmin')),
		'sz-google-admin-translate-advanced.php' => ucwords(__('advanced setting','szgoogleadmin')),
	);

	// Chiamata alla funzione generale per la creazione del form generale
	// le sezioni devono essere passate come un array con nome => titolo

	sz_google_common_form(ucfirst(__('google translate configuration','szgoogleadmin')),'sz_google_options_translate',$sections); 
}

/* ************************************************************************** */
/* Funzioni per SEZIONE Configurazione GOOGLE TRANSLATE                       */
/* ************************************************************************** */

function sz_google_admin_translate_meta() 
{
	sz_google_common_form_text('sz_google_options_translate','translate_meta','large',__('insert your META code','szgoogleadmin'));
	sz_google_common_form_description(__('before you use the google translate module must register the site that you want to manage on their google account using the following official link <a target="_blank" href="https://translate.google.com/manager/website/">Google Translate Tools</a>. Once inserit your site to perform the action "get code", display meta code and insert this in the field.','szgoogleadmin'));
}

function sz_google_admin_translate_mode() 
{
	$values = array(
		'I1' => __('inline vertical','szgoogleadmin'),
		'I2' => __('inline horizontal','szgoogleadmin'),
		'I3' => __('inline dropdown','szgoogleadmin'),
	); 

	sz_google_common_form_select('sz_google_options_translate','translate_mode',$values,'medium','');
	sz_google_common_form_description(__('with this parameter you can set the type of view you want to use for the widget to translate the language selection, you can choose for example vertical, horizontal or simple. If you want to use a custom positioning can use the function <code>szgoogle_get_translate_code()</code>.','szgoogleadmin'));
}

/* ************************************************************************** */
/* Funzioni per SEZIONE Configurazione GOOGLE TRANSLATE LANGUAGE              */
/* ************************************************************************** */

function sz_google_admin_translate_language() 
{
	$values = sz_google_get_languages(); 

	sz_google_common_form_select('sz_google_options_translate','translate_language',$values,'medium','');
	sz_google_common_form_description(__('specify the language code associated with your website, if you do not specify any value will be called the <code>get_bloginfo(\'language\')</code> and set the same language related to the theme of wordpress. Supported languages ​​can be found on <a target="_blank" href="http://translate.google.com/about/">http://translate.google.com/about/</a>.','szgoogleadmin'));
}

/* ************************************************************************** */
/* Funzioni per SEZIONE Configurazione GOOGLE TRANSLATE COMPONENTS            */
/* ************************************************************************** */

function sz_google_admin_translate_widget() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_translate','translate_widget');
	sz_google_common_form_description(__('if you enable this option you will find the widget required in the administration menu of your widget and you can plug it into any sidebar defined in your theme. If you disable this option, remember not to leave the widget connected to existing sidebar.','szgoogleadmin'));
}

function sz_google_admin_translate_shortcode() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_translate','translate_shortcode');
	sz_google_common_form_description(__('if you enable this option you can use the shortcode [sz-gtranslate] and enter the corresponding component directly in your article or page. Normally shortcodes can be specified in the options, to control parameters given read the official documentation.','szgoogleadmin'));
}

/* ************************************************************************** */
/* Funzioni per SEZIONE Configurazione GOOGLE TRANSLATE ADVANCED              */
/* ************************************************************************** */

function sz_google_admin_translate_automatic() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_translate','translate_automatic');
	sz_google_common_form_description(__('automatically display translation banner to users speaking languages other than the language of your page. If the language set on the visitor\'s browser is different from that of the website page displays the banner of translation. For details read the <a target="_blank" href="https://support.google.com/translate/">official documentation</a>.','szgoogleadmin'));
}

function sz_google_admin_translate_multiple() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_translate','translate_multiple');
	sz_google_common_form_description(__('your page contains content in multiple languages. Enable this option only if your pages contain content in different languages, in this case Google will use an algorithm of analysis other than the standard. For details read the official documentation <a target="_blank" href="https://support.google.com/translate/">https://support.google.com/translate/</a>.','szgoogleadmin'));
}

function sz_google_admin_translate_analytics() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_translate','translate_analytics');
	sz_google_common_form_description(__('track translation traffic using google analytics. If you enable this option, you can check the requirements and the translation statistics directly to your google analytics account. If you enable this option, you can check the requirements and the translation statistics directly to your google analytics account. Remember that to run this option you must specify the code assigned to your profile analytics.','szgoogleadmin'));
}

function sz_google_admin_translate_analytics_ua() 
{
	sz_google_common_form_text('sz_google_options_translate','translate_analytics_ua','medium',__('google analytics UA','szgoogleadmin'));
	sz_google_common_form_description(__('enter the code assigned to the profile of google analytics on which to collect statistical data relating to requests for translation. If you have the google analytics module of the plugin is automatically taken into the UA code shown in the specific module. Example UA-12345-12.','szgoogleadmin'));
}

/* ************************************************************************** */
/* Funzioni per la definizione dei campi legati a modulo                      */
/* ************************************************************************** */

function sz_google_admin_translate_validate($plugin_options) {
  return $plugin_options;
}

function sz_google_admin_translate_section()   {}
function sz_google_admin_translate_languages() {}
function sz_google_admin_translate_active()    {}
function sz_google_admin_translate_advanced()  {}
