<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

/* ************************************************************************** */
/* Definizione costanti che devo essere comuni a tutti i file admin           */
/* ************************************************************************** */

define('SZ_PLUGIN_GOOGLE_ADMIN',true);
define('SZ_PLUGIN_GOOGLE_ADMIN_BASENAME',basename(__FILE__));

/* ************************************************************************** */
/* Creazione e aggiunta menu di amministrazione                               */
/* ************************************************************************** */

function sz_google_admin_menu() 
{
	if (function_exists('add_submenu_page')) {
		add_menu_page('SZ Google','SZ Google','manage_options',SZ_PLUGIN_GOOGLE_ADMIN_BASENAME,'sz_google_admin_callback_generale',SZ_PLUGIN_GOOGLE_PATH_IMAGE.'google-16x16.png');
		add_submenu_page(SZ_PLUGIN_GOOGLE_ADMIN_BASENAME,'SZ-Google',ucfirst(__('configuration','szgoogleadmin')),'manage_options',SZ_PLUGIN_GOOGLE_ADMIN_BASENAME,'sz_google_admin_base_callback'); 
	}
}

/* ************************************************************************** */
/* Registrazione delle opzioni legate al plugin come modulo generale          */
/* ************************************************************************** */

function sz_google_admin_fields()
{
	register_setting('sz_google_options_base','sz_google_options_base','sz_google_admin_base_validate');

	// Definizione sezione per configurazione generale

	add_settings_section('sz_google_base_section',ucfirst(__('activation modules','szgoogleadmin')),'sz_google_admin_base_section',basename(__FILE__));
	add_settings_field('plus',ucfirst(__('activation','szgoogleadmin')).' [Google+]','sz_google_admin_base_plus',basename(__FILE__),'sz_google_base_section');
}

/* ************************************************************************** */
/* Registrazione del foglio stile per pannello di amministrazione             */
/* ************************************************************************** */

function sz_google_admin_add_stylesheet() 
{
	wp_register_style('sz-google-style-admin',SZ_PLUGIN_GOOGLE_PATH_CSS.'sz-google-style-admin.css');
	wp_enqueue_style('sz-google-style-admin');
}

/* ************************************************************************** */
/* Aggiungo le funzioni per l'esecuzione in admin                             */
/* ************************************************************************** */

add_action('admin_menu','sz_google_admin_menu');
add_action('admin_init','sz_google_admin_fields');
// add_action('admin_enqueue_scripts','sz_google_admin_add_stylesheet');

/* ************************************************************************** */
/* Funzioni per SEZIONE Configurazione Generale BASE                          */
/* ************************************************************************** */

function sz_google_admin_base_callback() {
	sz_google_common_form(
		ucfirst(__('configuration','szgoogleadmin')),
		'sz_google_options_base',
		basename(__FILE__)
	); 
}

function sz_google_admin_base_plus() {
	sz_google_common_form_checkbox(
		'sz_google_options_base','plus'
	);
}

function sz_google_admin_base_validate($plugin_options) {
  return $plugin_options;
}

function sz_google_admin_base_section() {}
function sz_google_admin_callback_generale() {}

/* ************************************************************************** */
/* Aggiunta di tutti i file admin richiesti in base alle attivazioni          */
/* ************************************************************************** */

$options = get_option('sz_google_options_base');

if (!isset($options['plus'])) $options['plus'] = '0';

if ($options['plus']=='1') @require_once(dirname(__FILE__).'/sz-google-admin-plus.php');


/* ************************************************************************** */
/* Funzioni per disegno parte del form (esecuzione generale)                  */
/* ************************************************************************** */

function sz_google_common_form($title,$setting,$section)
{

	echo '<div class="sz-google-wrap">';
	echo '<div class="sz-google-header"><div class="sz-google-gconfig sz-google-clear-right"></div>';
//	echo '<div class="wrap">';
//	echo '<div id="icon-options-general" class="icon32"><br></div>';
	echo '<h2>'.$title.'</h2>';
	echo '<p>'.ucfirst(__('overriding the default settings with your own specific preferences','szgoogleadmin')).'</p>';
	echo '<form method="post" action="options.php" enctype="multipart/form-data">';

	settings_fields($setting);
	do_settings_sections($section);

	echo '<p class="submit"><input name="Submit" type="submit" ';
	echo 'class="button-primary" value="'.ucfirst(__('save changes','szgoogleadmin')).'"/></p>';
	echo '</form>';
	echo '</div>';
}

/* ************************************************************************** */
/* Funzioni per disegno parte del form (campi alfanumerici)                   */
/* ************************************************************************** */

function sz_google_common_form_text_medium($optionset,$name,$placeholder) 
{	
	$options = get_option($optionset);

	if (!isset($options[$name])) $options[$name]=""; 

	echo '<input name="'.$optionset.'['.$name.']" type="text" class="medium-text" ';
	echo 'value="'.$options[$name].'" placeholder="'.$placeholder.'"/>';
}

/* ************************************************************************** */
/* Funzioni per disegno parte del form (campi con checkbox S/N)               */
/* ************************************************************************** */

function sz_google_common_form_checkbox($optionset,$name) 
{
	$options = get_option($optionset);

	if (!isset($options[$name])) { 
		$options[$name] = '0';
	} 

//	echo '<label class="sz-google"><input name="'.$optionset.'['.$name.']" type="checkbox" value="1" ';
//	echo 'class="code" '.checked(1,$options[$name],false).'/><span><p>ON / OFF</p></span></label>';

	echo '<input name="'.$optionset.'['.$name.']" type="checkbox" value="1" ';
	echo 'class="code" '.checked(1,$options[$name],false).'/>';
}

/* ************************************************************************** */
/* Funzioni per disegno parte del form (campi numerici con step 1)            */
/* ************************************************************************** */

function sz_google_common_form_number_step_1($optionset,$name,$placeholder) 
{
	$options = get_option($optionset);

	if (!isset($options[$name])) $options[$name]=""; 

	echo '<input size="40" name="'.$optionset.'['.$name.']" type="text" class="medium-text" ';
	echo 'value="'.$options[$name].'" placeholder="'.$placeholder.'"/>';
//	echo '<input name="'.$optionset.'['.$name.']" type="number" step="1" class="small-text" ';
//	echo 'value="'.$options[$name].'" placeholder="'.$placeholder.'"/>';
}

