<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_ADMIN') or !SZ_PLUGIN_GOOGLE_ADMIN) die();

/* ************************************************************************** */
/* Creazione e aggiunta menu di amministrazione                               */
/* ************************************************************************** */

function sz_google_admin_fonts_menu() 
{
	if (function_exists('add_submenu_page')) {
		$pagehook = add_submenu_page(SZ_PLUGIN_GOOGLE_ADMIN_BASENAME,'SZ-Google - '.ucwords(__('google fonts','szgoogleadmin')),ucwords(__('google fonts','szgoogleadmin')),'manage_options','sz-google-admin-fonts.php','sz_google_admin_fonts_callback'); 
		add_action('admin_print_scripts-'.$pagehook,'sz_google_admin_add_plugin');
	}
}

/* ************************************************************************** */
/* Registrazione delle opzioni legate al plugin                               */
/* ************************************************************************** */

function sz_google_admin_fonts_fields()
{
	register_setting('sz_google_options_fonts','sz_google_options_fonts','sz_google_admin_fonts_validate');

	// Definizione sezione per configurazione GOOGLE FONTS

	add_settings_section('sz_google_fonts_section','','sz_google_admin_fonts_section','sz-google-admin-fonts.php');
	add_settings_field('fonts_family',ucfirst(__('font family','szgoogleadmin').htmlspecialchars(' <body>')),'sz_google_admin_fonts_family','sz-google-admin-fonts.php','sz_google_fonts_section');

	// Definizione sezione per configurazione GOOGLE FONTS HX

	add_settings_section('sz_google_fonts_section_HX','','sz_google_admin_fonts_section','sz-google-admin-fonts-HX.php');
	add_settings_field('fonts_family_H1',ucfirst(__('font family','szgoogleadmin').htmlspecialchars(' <h1>')),'sz_google_admin_fonts_family_H1','sz-google-admin-fonts-HX.php','sz_google_fonts_section_HX');
	add_settings_field('fonts_family_H2',ucfirst(__('font family','szgoogleadmin').htmlspecialchars(' <h2>')),'sz_google_admin_fonts_family_H2','sz-google-admin-fonts-HX.php','sz_google_fonts_section_HX');
	add_settings_field('fonts_family_H3',ucfirst(__('font family','szgoogleadmin').htmlspecialchars(' <h3>')),'sz_google_admin_fonts_family_H3','sz-google-admin-fonts-HX.php','sz_google_fonts_section_HX');
	add_settings_field('fonts_family_H4',ucfirst(__('font family','szgoogleadmin').htmlspecialchars(' <h4>')),'sz_google_admin_fonts_family_H4','sz-google-admin-fonts-HX.php','sz_google_fonts_section_HX');
	add_settings_field('fonts_family_H5',ucfirst(__('font family','szgoogleadmin').htmlspecialchars(' <h5>')),'sz_google_admin_fonts_family_H5','sz-google-admin-fonts-HX.php','sz_google_fonts_section_HX');
	add_settings_field('fonts_family_H6',ucfirst(__('font family','szgoogleadmin').htmlspecialchars(' <h6>')),'sz_google_admin_fonts_family_H6','sz-google-admin-fonts-HX.php','sz_google_fonts_section_HX');
}

/* ************************************************************************** */
/* Aggiungo le funzioni per l'esecuzione in admin                             */
/* ************************************************************************** */

add_action('admin_menu','sz_google_admin_fonts_menu');
add_action('admin_init','sz_google_admin_fonts_fields');


function sz_google_admin_fonts_callback() 
{
	// Definizione delle sezioni che devono essere composte in HTML
	// le sezioni devono essere passate come un array con nome => titolo

	$sections = array(
		'sz-google-admin-fonts.php'       => ucwords(__('font setting general','szgoogleadmin')),
		'sz-google-admin-fonts-HX.php'    => ucwords(__('font setting headings','szgoogleadmin')),
	);

	// Chiamata alla funzione generale per la creazione del form generale
	// le sezioni devono essere passate come un array con nome => titolo

	sz_google_common_form(ucfirst(__('google fonts configuration','szgoogleadmin')),'sz_google_options_fonts',$sections); 
}

function sz_google_admin_fonts_family() 
{
	sz_google_common_form_checkbox_yn('sz_google_options_fonts','fonts_family_active');
	sz_google_common_form_text('sz_google_options_fonts','fonts_family','large',__('insert your fonts family','szgoogleadmin'));
	sz_google_common_form_description(__('some .','szgoogleadmin'));
}

function sz_google_admin_fonts_family_H1() {
	sz_google_common_form_checkbox_yn('sz_google_options_fonts','fonts_family_H1_active');
	sz_google_common_form_text('sz_google_options_fonts','fonts_family_H1','large',__('insert your fonts family','szgoogleadmin'));
}
function sz_google_admin_fonts_family_H2() {
	sz_google_common_form_checkbox_yn('sz_google_options_fonts','fonts_family_H2_active');
	sz_google_common_form_text('sz_google_options_fonts','fonts_family_H2','large',__('insert your fonts family','szgoogleadmin'));
}
function sz_google_admin_fonts_family_H3() {
	sz_google_common_form_checkbox_yn('sz_google_options_fonts','fonts_family_H3_active');
	sz_google_common_form_text('sz_google_options_fonts','fonts_family_H3','large',__('insert your fonts family','szgoogleadmin'));
}
function sz_google_admin_fonts_family_H4() {
	sz_google_common_form_checkbox_yn('sz_google_options_fonts','fonts_family_H4_active');
	sz_google_common_form_text('sz_google_options_fonts','fonts_family_H4','large',__('insert your fonts family','szgoogleadmin'));
}
function sz_google_admin_fonts_family_H5() {
	sz_google_common_form_checkbox_yn('sz_google_options_fonts','fonts_family_H5_active');
	sz_google_common_form_text('sz_google_options_fonts','fonts_family_H5','large',__('insert your fonts family','szgoogleadmin'));
}
function sz_google_admin_fonts_family_H6() {
	sz_google_common_form_checkbox_yn('sz_google_options_fonts','fonts_family_H6_active');
	sz_google_common_form_text('sz_google_options_fonts','fonts_family_H6','large',__('insert your fonts family','szgoogleadmin'));
}



function sz_google_admin_fonts_validate($plugin_options) {
  return $plugin_options;
}

function sz_google_admin_fonts_section() {}
