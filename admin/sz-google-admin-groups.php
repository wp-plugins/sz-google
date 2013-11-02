<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_ADMIN') or !SZ_PLUGIN_GOOGLE_ADMIN) die();

/* ************************************************************************** */
/* Creazione e aggiunta menu di amministrazione                               */
/* ************************************************************************** */

function sz_google_admin_groups_menu() 
{
	if (function_exists('add_submenu_page')) {
		$pagehook = add_submenu_page(SZ_PLUGIN_GOOGLE_ADMIN_BASENAME,'SZ-Google - '.ucwords(__('google groups','szgoogleadmin')),ucwords(__('google groups','szgoogleadmin')),'manage_options','sz-google-admin-groups.php','sz_google_admin_groups_callback'); 
		add_action('admin_print_scripts-'.$pagehook,'sz_google_admin_add_plugin');
	}
}

/* ************************************************************************** */
/* Registrazione delle opzioni legate al plugin                               */
/* ************************************************************************** */

function sz_google_admin_groups_fields()
{
	register_setting('sz_google_options_groups','sz_google_options_groups','sz_google_admin_groups_validate');

	// Definizione sezione per configurazione GOOGLE GROUPS ACTIVATED

	add_settings_section('sz_google_groups_active','','sz_google_admin_groups_active','sz-google-admin-groups-enable.php');
	add_settings_field('groups_widget',ucwords(__('enable widget','szgoogleadmin')),'sz_google_admin_groups_widget','sz-google-admin-groups-enable.php','sz_google_groups_active');
	add_settings_field('groups_shortcode',ucwords(__('enable shortcode','szgoogleadmin')),'sz_google_admin_groups_shortcode','sz-google-admin-groups-enable.php','sz_google_groups_active');

	// Definizione sezione per configurazione GOOGLE GROUPS LANGUAGE

	add_settings_section('sz_google_groups_language','','sz_google_admin_groups_languages','sz-google-admin-groups-language.php');
	add_settings_field('groups_language',ucfirst(__('default language','szgoogleadmin')),'sz_google_admin_groups_language','sz-google-admin-groups-language.php','sz_google_groups_language');

	// Definizione sezione per configurazione GOOGLE GROUPS DISPLAY

	add_settings_section('sz_google_groups_display','','sz_google_admin_groups_display','sz-google-admin-groups-display.php');
	add_settings_field('groups_name',ucfirst(__('default group name','szgoogleadmin')),'sz_google_admin_groups_name','sz-google-admin-groups-display.php','sz_google_groups_display');
	add_settings_field('groups_showsearch',ucfirst(__('show search','szgoogleadmin')),'sz_google_admin_groups_showsearch','sz-google-admin-groups-display.php','sz_google_groups_display');
	add_settings_field('groups_showtabs',ucfirst(__('show tabs','szgoogleadmin')),'sz_google_admin_groups_showtabs','sz-google-admin-groups-display.php','sz_google_groups_display');
	add_settings_field('groups_hidetitle',ucfirst(__('hide title','szgoogleadmin')),'sz_google_admin_groups_hidetitle','sz-google-admin-groups-display.php','sz_google_groups_display');
	add_settings_field('groups_hidesubject',ucfirst(__('hide subject','szgoogleadmin')),'sz_google_admin_groups_hidesubject','sz-google-admin-groups-display.php','sz_google_groups_display');
	add_settings_field('groups_width',ucfirst(__('default width','szgoogleadmin')),'sz_google_admin_groups_width','sz-google-admin-groups-display.php','sz_google_groups_display');
	add_settings_field('groups_height',ucfirst(__('default height','szgoogleadmin')),'sz_google_admin_groups_height','sz-google-admin-groups-display.php','sz_google_groups_display');
}

/* ************************************************************************** */
/* Aggiungo le funzioni per l'esecuzione in admin                             */
/* ************************************************************************** */

add_action('admin_menu','sz_google_admin_groups_menu');
add_action('admin_init','sz_google_admin_groups_fields');

/* ************************************************************************** */
/* Funzioni per SEZIONE Configurazione Google Groups                          */
/* ************************************************************************** */

function sz_google_admin_groups_callback() 
{
	// Definizione delle sezioni che devono essere composte in HTML
	// le sezioni devono essere passate come un array con nome => titolo

	$sections = array(
		'sz-google-admin-groups-enable.php'   => ucwords(__('activation components','szgoogleadmin')),
		'sz-google-admin-groups-language.php' => ucwords(__('language setting','szgoogleadmin')),
		'sz-google-admin-groups-display.php'  => ucwords(__('display setting','szgoogleadmin')),
	);

	// Chiamata alla funzione generale per la creazione del form generale
	// le sezioni devono essere passate come un array con nome => titolo

	sz_google_common_form(ucfirst(__('google groups configuration','szgoogleadmin')),'sz_google_options_groups',$sections); 
}

/* ************************************************************************** */
/* Funzioni per SEZIONE Configurazione GOOGLE GROUPS COMPONENTS               */
/* ************************************************************************** */

function sz_google_admin_groups_widget() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_groups','groups_widget');
	sz_google_common_form_description(__('if you enable this option you will find the widget required in the administration menu of your widget and you can plug it into any sidebar defined in your theme. If you disable this option, remember not to leave the widget connected to existing sidebar.','szgoogleadmin'));
}

function sz_google_admin_groups_shortcode() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_groups','groups_shortcode');
	sz_google_common_form_description(__('if you enable this option you can use the shortcode <code>[sz-ggroups]</code> and enter the corresponding component directly in your article or page. Normally shortcodes can be specified in the options, to control parameters given read the official documentation.','szgoogleadmin'));
}

/* ************************************************************************** */
/* Funzioni per SEZIONE Configurazione GOOGLE GROUPS LANGUAGE                 */
/* ************************************************************************** */

function sz_google_admin_groups_language() 
{
	$values = sz_google_get_languages(); 

	sz_google_common_form_select('sz_google_options_groups','groups_language',$values,'medium','');
	sz_google_common_form_description(__('specify the language code associated with your website, if you do not specify any value will be called the <code>get_bloginfo(\'language\')</code> and set the same language related to the theme of wordpress. Supported languages ​​can be found on <a target="_blank" href="http://translate.google.com/about/">http://translate.google.com/about/</a>.','szgoogleadmin'));
}

/* ************************************************************************** */
/* Funzioni per SEZIONE Configurazione GOOGLE GROUPS DISPLAY                  */
/* ************************************************************************** */

function sz_google_admin_groups_name() 
{
	sz_google_common_form_text('sz_google_options_groups','groups_name','medium',__('insert default name','szgoogleadmin'));
	sz_google_common_form_description(__('in this area specify a group name that will be used in all those conditions in which you do not specify any value for the parameter "name". In any case, you can specify any name that is on the shortcode on the widget module google groups.','szgoogleadmin'));
}

function sz_google_admin_groups_showsearch() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_groups','groups_showsearch');
	sz_google_common_form_description(__('select value "yes" if you want to show a search box, "no" if you don\'t want the box to show. This field is used as default value, but you can change this by specifying a specific value via the shortcode or php function. See official documentation for more details.','szgoogleadmin'));
}

function sz_google_admin_groups_showtabs() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_groups','groups_showtabs');
	sz_google_common_form_description(__('select value "yes" if you want to show the view selector tabs, "no" if you don\'t want to show tabs. This field is used as default value, but you can change this by specifying a specific value via the shortcode or php function. See official documentation for more details','szgoogleadmin'));
}

function sz_google_admin_groups_hidetitle() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_groups','groups_hidetitle');
	sz_google_common_form_description(__('select value "yes" if you want to hide the forum title and description, "no" if you don\'t want to leave the title or description. This field is used as default value, but you can change this by specifying a specific value via the shortcode or php function. See official documentation for more details','szgoogleadmin'));
}

function sz_google_admin_groups_hidesubject() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_groups','groups_hidesubject');
	sz_google_common_form_description(__('select value "yes" if you want to hide the subject of the last post in My Forums view, "no" if you want to leave the subject visible. This field is used as default value, but you can change this by specifying a specific value via the shortcode or php function. See documentation for more details','szgoogleadmin'));
}

function sz_google_admin_groups_width() 
{
	sz_google_common_form_number_step_1('sz_google_options_groups','groups_width','medium',0);
	sz_google_common_form_description(__('with this field you can set the width of the container iframe that will be used by defaul, when not specified as a parameter of the widget or the shortcode, if you see a value equal to zero, the default size will be 100% and will occupy the entire space of parent container.','szgoogleadmin'));
}

function sz_google_admin_groups_height() 
{
	sz_google_common_form_number_step_1('sz_google_options_groups','groups_height','medium',700);
	sz_google_common_form_description(__('with this field you can set the height in pixels of the container iframe that will be used by defaul, when not specified as a parameter of the widget or the shortcode, if you see a value equal to zero, the default size will be 700 pixels.','szgoogleadmin'));
}

/* ************************************************************************** */
/* Funzioni per la definizione dei campi legati a modulo                      */
/* ************************************************************************** */

function sz_google_admin_groups_validate($plugin_options) {
  return $plugin_options;
}

function sz_google_admin_groups_active()    {}
function sz_google_admin_groups_languages() {}
function sz_google_admin_groups_display()   {}