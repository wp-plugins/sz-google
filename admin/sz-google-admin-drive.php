<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_ADMIN') or !SZ_PLUGIN_GOOGLE_ADMIN) die();

/* ************************************************************************** */
/* Creazione e aggiunta menu di amministrazione                               */
/* ************************************************************************** */

function sz_google_admin_drive_menu() 
{
	if (function_exists('add_submenu_page')) {
		add_submenu_page(SZ_PLUGIN_GOOGLE_ADMIN_BASENAME,'SZ-Google - '.ucwords(__('google drive','szgoogleadmin')),ucwords(__('google drive','szgoogleadmin')),'manage_options','sz-google-admin-drive.php','sz_google_admin_drive_callback'); 
	}
}

/* ************************************************************************** */
/* Registrazione delle opzioni legate al plugin                               */
/* ************************************************************************** */

function sz_google_admin_drive_fields()
{
	register_setting('sz_google_options_drive','sz_google_options_drive','sz_google_admin_drive_validate');

	// Definizione sezione per configurazione GOOGLE DRIVE

	add_settings_section('sz_google_drive_section','','sz_google_admin_drive_section','sz-google-admin-drive.php');
	add_settings_field('drive_sitename',ucfirst(__('site name','szgoogleadmin')),'sz_google_admin_drive_sitename','sz-google-admin-drive.php','sz_google_drive_section');

	// Definizione sezione per configurazione GOOGLE DRIVE SAVE BUTTON

	add_settings_section('sz_google_drive_savebutton','','sz_google_admin_drive_savebutton_active','sz-google-admin-drive-savebutton-enable.php');
	add_settings_field('drive_savebutton_widget',ucwords(__('enable widget','szgoogleadmin')),'sz_google_admin_drive_savebutton_widget','sz-google-admin-drive-savebutton-enable.php','sz_google_drive_savebutton');
	add_settings_field('drive_savebutton_shortcode',ucwords(__('enable shortcode','szgoogleadmin')),'sz_google_admin_drive_savebutton_shortcode','sz-google-admin-drive-savebutton-enable.php','sz_google_drive_savebutton');
}

/* ************************************************************************** */
/* Aggiungo le funzioni per l'esecuzione in admin                             */
/* ************************************************************************** */

add_action('admin_menu','sz_google_admin_drive_menu');
add_action('admin_init','sz_google_admin_drive_fields');

/* ************************************************************************** */
/* Funzioni per SEZIONE Configurazione Google Drive                           */
/* ************************************************************************** */

function sz_google_admin_drive_callback() 
{
	// Definizione delle sezioni che devono essere composte in HTML
	// le sezioni devono essere passate come un array con nome => titolo

	$sections = array(
		'sz-google-admin-drive.php'                   => ucwords(__('general setting','szgoogleadmin')),
		'sz-google-admin-drive-savebutton-enable.php' => ucwords(__('save to drive button','szgoogleadmin')),
	);

	// Chiamata alla funzione generale per la creazione del form generale
	// le sezioni devono essere passate come un array con nome => titolo

	sz_google_common_form(ucfirst(__('google drive configuration','szgoogleadmin')),'sz_google_options_drive',$sections); 
}

/* ************************************************************************** */
/* Funzioni per SEZIONE Configurazione GOOGLE DRIVE                           */
/* ************************************************************************** */

function sz_google_admin_drive_sitename() 
{
	sz_google_common_form_text('sz_google_options_drive','drive_sitename','large',__('insert your site name','szgoogleadmin'));
	sz_google_common_form_description(__('some functions google drive require the information of the name of the site where the operation took place, you can use this field to customize the name, otherwise it will use the default value in wordpress. See general setting in wordpress admin panel.','szgoogleadmin'));
}

/* ************************************************************************** */
/* Funzioni per SEZIONE Configurazione GOOGLE DRIVE SAVE BUTTON               */
/* ************************************************************************** */

function sz_google_admin_drive_savebutton_widget() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_drive','drive_savebutton_widget');
	sz_google_common_form_description(__('if you enable this option you will find the widget required in the administration menu of your widget and you can plug it into any sidebar defined in your theme. If you disable this option, remember not to leave the widget connected to existing sidebar.','szgoogleadmin'));
}

function sz_google_admin_drive_savebutton_shortcode() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_drive','drive_savebutton_shortcode');
	sz_google_common_form_description(__('if you enable this option you can use the shortcode [sz-drive-save] and enter the corresponding component directly in your article or page. Normally shortcodes can be specified in the options, to control parameters given read the official documentation.','szgoogleadmin'));
}

/* ************************************************************************** */
/* Funzioni per la definizione dei campi legati a modulo                      */
/* ************************************************************************** */

function sz_google_admin_drive_validate($plugin_options) {
  return $plugin_options;
}

function sz_google_admin_drive_section() {}
function sz_google_admin_drive_savebutton_active() {}
