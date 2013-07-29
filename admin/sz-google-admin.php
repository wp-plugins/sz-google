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
		add_menu_page('SZ Google','SZ Google','manage_options',SZ_PLUGIN_GOOGLE_ADMIN_BASENAME,'sz_google_admin_callback_generale',SZ_PLUGIN_GOOGLE_PATH_CSS_IMAGE.'google-16x16.png');
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

	add_settings_section('sz_google_base_section','','sz_google_admin_base_section',basename(__FILE__));
	add_settings_field('plus',ucfirst(__('google+','szgoogleadmin')),'sz_google_admin_base_plus',basename(__FILE__),'sz_google_base_section');
	add_settings_field('analytics',ucwords(__('google analytics','szgoogleadmin')),'sz_google_admin_base_analytics',basename(__FILE__),'sz_google_base_section');
	add_settings_field('translate',ucwords(__('google translate','szgoogleadmin')),'sz_google_admin_base_translate',basename(__FILE__),'sz_google_base_section');
}

/* ************************************************************************** */
/* Registrazione del foglio stile per pannello di amministrazione             */
/* ************************************************************************** */

function sz_google_admin_add_stylesheet() 
{
	wp_register_style('sz-google-style-admin',SZ_PLUGIN_GOOGLE_PATH_CSS.'sz-google-style-admin.css');
	wp_enqueue_style('sz-google-style-admin');

	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('postbox');
	wp_enqueue_script('utils');
	wp_enqueue_script('dashboard');
	wp_enqueue_script('thickbox');
}

/* ************************************************************************** */
/* Aggiungo le funzioni per l'esecuzione in admin                             */
/* ************************************************************************** */

add_action('admin_menu','sz_google_admin_menu');
add_action('admin_init','sz_google_admin_fields');
add_action('admin_enqueue_scripts','sz_google_admin_add_stylesheet');

/* ************************************************************************** */
/* Funzioni per SEZIONE Configurazione Generale BASE                          */
/* ************************************************************************** */

function sz_google_admin_base_callback() 
{
	// Definizione delle sezioni che devono essere composte in HTML
	// le sezioni devono essere passate come un array con nome => titolo

	$sections = array(
		basename(__FILE__) => ucwords(__('activation modules','szgoogleadmin')),
	);

	// Chiamata alla funzione generale per la creazione del form generale
	// le sezioni devono essere passate come un array con nome => titolo

	sz_google_common_form(
		ucfirst(__('configuration','szgoogleadmin')),'sz_google_options_base',$sections
	); 
}

/* ************************************************************************** */
/* Funzioni per SEZIONE Configurazione Generale BASE                          */
/* ************************************************************************** */

function sz_google_admin_base_plus() {
	sz_google_common_form_checkbox_yesno(
		'sz_google_options_base','plus'
	);
}

function sz_google_admin_base_analytics() {
	sz_google_common_form_checkbox_yesno(
		'sz_google_options_base','analytics'
	);
}

function sz_google_admin_base_translate() {
	sz_google_common_form_checkbox_yesno(
		'sz_google_options_base','translate'
	);
}

/* ************************************************************************** */
/* Funzioni per SEZIONE Configurazione Generale BASE                          */
/* ************************************************************************** */

function sz_google_admin_base_validate($plugin_options) {
  return $plugin_options;
}

function sz_google_admin_base_section() {}
function sz_google_admin_callback_generale() {}

/* ************************************************************************** */
/* Aggiunta di tutti i file admin richiesti in base alle attivazioni          */
/* ************************************************************************** */

$options_admin = sz_google_modules_options();

if ($options_admin['plus'] == '1') {
	@require_once(dirname(__FILE__).'/sz-google-admin-plus.php');
}

if ($options_admin['analytics'] == '1') {
	@require_once(dirname(__FILE__).'/sz-google-admin-analytics.php');
}

if ($options_admin['translate'] == '1') {
	@require_once(dirname(__FILE__).'/sz-google-admin-translate.php');
}

/* ************************************************************************** */
/* Funzioni per disegno parte del form (esecuzione generale)                  */
/* ************************************************************************** */

function sz_google_common_form($title,$setting,$sections)
{

	echo '<div id="sz-google-wrap" class="wrap">';
	echo '<div id="sz-google-icon-gplus" class="icon32"><br></div>';
	echo '<h2>'.ucwords($title).'</h2>';
	echo '<p>'.ucfirst(__('overriding the default settings with your own specific preferences','szgoogleadmin')).'</p>';

	// Contenitore principale con zona dedicata ai parametri di configurazione
	// definiti tramite le chiamate dei singoli moduli attivati da pannello ammnistrativo

	echo '<div class="postbox-container" id="sz-google-admin-options">';
	echo '<div class="metabox-holder">';
	echo '<div class="meta-box-sortables ui-sortable" id="sz-google-box">';

	echo '<form method="post" action="options.php" enctype="multipart/form-data">';
	echo '<input type="hidden" name="sz_google_options_plus[plus_redirect_flush]" value="0">';

	settings_fields($setting);

	foreach ($sections as $section => $title) {
		echo '<div class="postbox">';
		echo '<div class="handlediv" title="'.ucfirst(__('click to toggle','szgoogleadmin')).'"><br></div>';
		echo '<h3 class="hndle"><span>'.$title.'</span></h3>';
		echo '<div class="inside">';
		do_settings_sections($section);
		echo '</div>';
		echo '</div>';
	}	

	echo '<p class="submit"><input name="Submit" type="submit" class="button-primary" value="'.ucfirst(__('save changes','szgoogleadmin')).'"/></p>';
	echo '</form>';

	echo '</div>';
	echo '</div>';
	echo '</div>';

	// Contenitore secondario con informazioni degli autori e alcuni link
	// come ad esempio la community di  wordpress italiana for ever :)

	echo '<div class="postbox-container" id="sz-google-admin-sidebar">';
	echo '<div class="metabox-holder">';
	echo '<div class="meta-box-sortables ui-sortable">';

	// Sezione su sidebar per "Dacci un piccolo aiuto"

	echo '<div id="help-us" class="postbox">';
	echo '<div class="handlediv" title="'.ucfirst(__('click to toggle','szgoogleadmin')).'"><br></div>';
	echo '<h3 class="hndle"><span><strong>'.ucwords(__('give us a little help','szgoogleadmin')).'</strong></span></h3>';
	echo '<div class="inside">';
	echo '<ul>';
	echo '<li><a target="_blank" href="http://wordpress.org/support/view/plugin-reviews/sz-google">'.ucfirst(__('rate the plugin on WordPress.org','szgoogleadmin')).'</a></li>';
	echo '<li><a target="_blank" href="https://plus.google.com/communities/109254048492234113886">'.ucfirst(__('join our community WordPress Italy+','szgoogleadmin')).'</a></li>';
	echo '</ul>';
	echo '</div>';
	echo '</div>';

	// Sezione su sidebar per "pagina ufficiale"

	echo '<div id="authors-plugin" class="postbox">';
	echo '<div class="handlediv" title="'.ucfirst(__('click to toggle','szgoogleadmin')).'"><br></div>';
	echo '<h3 class="hndle"><span><strong>'.ucwords(__('official page','szgoogleadmin')).'</strong></span></h3>';
	echo '<div class="inside">';
	echo '<a target="_blank" href="https://plus.google.com/117259631219963935481/"><img src="'.SZ_PLUGIN_GOOGLE_PATH_CSS_IMAGE.'wordpress-italy.jpg'.'" alt="WordPress Italy+" style="width:100%;height:auto"></a>';
	echo '</div>';
	echo '</div>';

	// Sezione su sidebar per "Autori del plugin"

	echo '<div id="authors-plugin" class="postbox">';
	echo '<div class="handlediv" title="'.ucfirst(__('click to toggle','szgoogleadmin')).'"><br></div>';
	echo '<h3 class="hndle"><span><strong>'.ucwords(__('authors','szgoogleadmin')).'</strong></span></h3>';
	echo '<div class="inside">';
	echo '<ul>';
	echo '<li><a target="_blank" href="https://plus.google.com/106567288702045182616/">Massimo Della Rovere</a></li>';
	echo '<li><a target="_blank" href="https://plus.google.com/101045287591082507791/">Eugenio Petullà</a></li>';
	echo '<li><a target="_blank" href="https://plus.google.com/106445867693191019124/">Andrea Barghigiani</a></li>';
	echo '</ul>';
	echo '</div>';
	echo '</div>';

	// Sezione su sidebar per "Informazioni sul plugin"

	echo '<div id="info-plugin" class="postbox">';
	echo '<div class="handlediv" title="'.ucfirst(__('click to toggle','szgoogleadmin')).'"><br></div>';
	echo '<h3 class="hndle"><span><strong>'.ucwords(__('latest news on the plugin','szgoogleadmin')).'</strong></span></h3>';
	echo '<div class="inside">';
	echo '<ul>';
	echo '<li><a target="_blank" href="https://plus.google.com/communities/109254048492234113886">'.ucfirst(__('community WordPress','szgoogleadmin')).'</a></li>';
	echo '<li><a target="_blank" href="https://plus.google.com/117259631219963935481/">'.ucfirst(__('official page','szgoogleadmin')).'</a></li>';
	echo '<li><a target="_blank" href="http://startbyzero.com/webmaster/wordpress-plugin/sz-google/">'.ucfirst(__('official documentation','szgoogleadmin')).'</a></li>';
	echo '</ul>';
	echo '</div>';
	echo '</div>';

	// Sezione su sidebar chiusura

	echo '</div>';
	echo '</div>';
	echo '</div>';

	echo '</div>';
}

/* ************************************************************************** */
/* Funzioni per disegno descrizione aggiuntiva sotto i campi opzione          */
/* ************************************************************************** */

function sz_google_common_form_description($description) 
{
	echo '<tr valign="top"><td colspan="2"><small>';
	echo ucfirst(trim($description));
	echo '</small></td></tr>';
}

/* ************************************************************************** */
/* Funzioni per disegno parte del form (campi alfanumerici)                   */
/* ************************************************************************** */

function sz_google_common_form_text($optionset,$name,$class='medium',$placeholder='') 
{	
	$options = get_option($optionset);

	if (!isset($options[$name])) $options[$name] = ""; 

	echo '<input name="'.$optionset.'['.$name.']" type="text" class="'.$class.'" ';
	echo 'value="'.$options[$name].'" placeholder="'.$placeholder.'"/>';
}

/* ************************************************************************** */
/* Funzioni per disegno parte del form (SELECT)                               */
/* ************************************************************************** */

function sz_google_common_form_select($optionset,$name,$values,$class='medium',$placeholder='') 
{
	$options = get_option($optionset);

	if (!isset($options[$name])) $options[$name] = ""; 
	if (!isset($options['plus_language'])) $options['plus_language'] = '99';

	echo '<select name="'.$optionset.'['.$name.']" class="'.$class.'">';

	foreach ($values as $key=>$value) {
		$selected = ($options[$name] == $key) ? ' selected = "selected"' : '';
		echo '<option value="'.$key.'"'.$selected.'>'.$value.'</option>';
	}

	echo '</select>';
}

/* ************************************************************************** */
/* Funzioni per disegno parte del form (campi con checkbox S/N)               */
/* ************************************************************************** */

function sz_google_common_form_checkbox_yesno($optionset,$name,$class='medium') 
{
	$options = get_option($optionset);

	if (!isset($options[$name])) $options[$name] = '0';

	echo '<label class="sz-google"><input name="'.$optionset.'['.$name.']" type="checkbox" value="1" ';
	echo 'class="'.$class.'" '.checked(1,$options[$name],false).'/><span class="checkbox" style="display:none">'.__('YES / NO','szgoogleadmin').'</span></label>';
}

/* ************************************************************************** */
/* Funzioni per disegno parte del form (campi numerici con step 1)            */
/* ************************************************************************** */

function sz_google_common_form_number_step_1($optionset,$name,$class='medium',$placeholder='') 
{
	$options = get_option($optionset);

	if (!isset($options[$name])) $options[$name]=""; 

	echo '<input name="'.$optionset.'['.$name.']" type="number" step="1" class="'.$class.'" ';
	echo 'value="'.$options[$name].'" placeholder="'.$placeholder.'"/>';
}

