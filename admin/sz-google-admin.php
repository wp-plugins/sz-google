<?php
/* ************************************************************************** */
/* ADMIN Controllo se definita la costante del plugin                         */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

/* ************************************************************************** */
/* Definizione costanti che devo essere comuni a tutti i file admin           */
/* ************************************************************************** */

define('SZ_PLUGIN_GOOGLE_ADMIN',true);
define('SZ_PLUGIN_GOOGLE_ADMIN_BASENAME',basename(__FILE__));

/* ************************************************************************** */
/* ADMIN Caricamento della lingua per il plugin su parte amministrazione      */
/* ************************************************************************** */

function sz_google_language_init_admin() {
	load_plugin_textdomain(
		'szgoogleadmin',false,SZ_PLUGIN_GOOGLE_BASENAME_LANGUAGE);
}

add_action('init','sz_google_language_init_admin');

/* ************************************************************************** */
/* ADMIN Creazione e aggiunta menu di amministrazione                         */
/* ************************************************************************** */

function sz_google_admin_menu() 
{
	if (function_exists('add_submenu_page')) {
		add_menu_page('SZ Google','SZ Google','manage_options',SZ_PLUGIN_GOOGLE_ADMIN_BASENAME,'sz_google_admin_callback_generale','div');
		$pagehook = add_submenu_page(SZ_PLUGIN_GOOGLE_ADMIN_BASENAME,'SZ-Google',ucfirst(__('configuration','szgoogleadmin')),'manage_options',SZ_PLUGIN_GOOGLE_ADMIN_BASENAME,'sz_google_admin_base_callback');
		add_action('admin_print_scripts-'.$pagehook,'sz_google_admin_add_plugin');
	}
}

/* ************************************************************************** */
/* ADMIN Registrazione delle opzioni legate al plugin come modulo generale    */
/* ************************************************************************** */

function sz_google_admin_fields()
{
	register_setting('sz_google_options_base','sz_google_options_base','sz_google_admin_base_validate');

	// Definizione sezione per configurazione generale

	add_settings_section('sz_google_base_section','','sz_google_admin_base_section',basename(__FILE__));
	add_settings_field('plus',ucfirst(__('google+','szgoogleadmin')),'sz_google_admin_base_plus',basename(__FILE__),'sz_google_base_section');
	add_settings_field('analytics',ucwords(__('google analytics','szgoogleadmin')),'sz_google_admin_base_analytics',basename(__FILE__),'sz_google_base_section');
	add_settings_field('drive',ucwords(__('google drive','szgoogleadmin')),'sz_google_admin_base_drive',basename(__FILE__),'sz_google_base_section');
	add_settings_field('fonts',ucwords(__('google fonts','szgoogleadmin')),'sz_google_admin_base_fonts',basename(__FILE__),'sz_google_base_section');
	add_settings_field('groups',ucwords(__('google groups','szgoogleadmin')),'sz_google_admin_base_groups',basename(__FILE__),'sz_google_base_section');
	add_settings_field('panoramio',ucwords(__('google panoramio','szgoogleadmin')),'sz_google_admin_base_panoramio',basename(__FILE__),'sz_google_base_section');
	add_settings_field('translate',ucwords(__('google translate','szgoogleadmin')),'sz_google_admin_base_translate',basename(__FILE__),'sz_google_base_section');
	add_settings_field('youtube',ucwords(__('google youtube','szgoogleadmin')),'sz_google_admin_base_youtube',basename(__FILE__),'sz_google_base_section');
	add_settings_field('documentation',ucwords(__('documentation','szgoogleadmin')),'sz_google_admin_base_documentation',basename(__FILE__),'sz_google_base_section');
}

/* ************************************************************************** */
/* ADMIN Registrazione componenti in init su amministrazion generale          */
/* ************************************************************************** */

function sz_google_admin_init() 
{
	wp_register_style('sz-google-style-admin',SZ_PLUGIN_GOOGLE_PATH_CSS.'sz-google-style-admin.css');
	wp_enqueue_style('sz-google-style-admin');

	// Caricamento framework javasctipt per media uploader da
	// utilizzare nelle funzioni di scelta attachment come i widgets

	global $pagenow;

	if ($pagenow == 'widgets.php') 
	{
		if (!did_action('wp_enqueue_media')) wp_enqueue_media();

		wp_register_script('sz_google_javascript',SZ_PLUGIN_GOOGLE_PATH_JS.'sz-google.js');
		wp_enqueue_script('sz_google_javascript');
	}
}

/* ************************************************************************** */
/* ADMIN Aggiungo le funzioni per l'esecuzione in admin                       */
/* ************************************************************************** */

add_action('admin_init','sz_google_admin_init');
add_action('admin_init','sz_google_admin_fields');
add_action('admin_menu','sz_google_admin_menu');

/* ************************************************************************** */
/* ADMIN Registrazione componenti solo su pagine del plugin interessate       */
/* ************************************************************************** */

function sz_google_admin_add_plugin() 
{
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('postbox');
	wp_enqueue_script('utils');
	wp_enqueue_script('dashboard');
	wp_enqueue_script('thickbox');
}

/* ************************************************************************** */
/* ADMIN Funzioni per SEZIONE Configurazione Generale BASE                    */
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

	sz_google_common_form(ucfirst(__('configuration version','szgoogleadmin').'&nbsp;'.SZ_PLUGIN_GOOGLE_VERSION),'sz_google_options_base',$sections); 
}

/* ************************************************************************** */
/* ADMIN Funzioni per SEZIONE Configurazione Generale BASE                    */
/* ************************************************************************** */

function sz_google_admin_base_plus() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_base','plus');
	sz_google_common_form_description(__('with this module you can manage some widgets in the social network google+, for example, we can insert badge of the profiles, badge of the pages, badge of the community, buttons follow, buttons share, buttons +1, comments system and much more.','szgoogleadmin'));
}

function sz_google_admin_base_analytics() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_base','analytics');
	sz_google_common_form_description(__('activating this module can handle the tracking code present in google analytics, so as to store the access statistics related to our website. Once you have entered the tracking code, you can view hundreds of statistics from the admin panel of google analytics.','szgoogleadmin'));
}

function sz_google_admin_base_drive()
{
	sz_google_common_form_checkbox_yesno('sz_google_options_base','drive');
	sz_google_common_form_description(__('through this module you can insert into wordpress some features of google drive, you will find widgets and shortcodes to help you with this task. Obviously many functions can only work if you login with a valid account on google.','szgoogleadmin'));
}

function sz_google_admin_base_fonts()
{
	sz_google_common_form_checkbox_yesno('sz_google_options_base','fonts');
	sz_google_common_form_description(__('with this module you can load into your wordpress theme fonts made ​​available on Google CDN. Simply select the desired font and HTML parts concerned. The plugin will automatically add all the necessary parts of the code.','szgoogleadmin'));
}

function sz_google_admin_base_groups() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_base','groups');
	sz_google_common_form_description(__('enabling this module you get a widget and a shortcode to perform embed on google groups. Then you can insert into a wordpress page or in a sidebar content navigable for a group. You can specify various customization options.','szgoogleadmin'));
}

function sz_google_admin_base_panoramio() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_base','panoramio');
	sz_google_common_form_description(__('through this module you can insert some features of photos panoramio, you will find widgets and shortcodes to help you with this task and use the functions in your favorite theme. You can also specify parameters for selecting user, group, tag etc.','szgoogleadmin'));
}

function sz_google_admin_base_translate() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_base','translate');
	sz_google_common_form_description(__('with this module you can place the widget for automatic content translate on your website made ​​available by google translate tools. The widget can be placed in the context of a post or a sidebar defined in your theme.','szgoogleadmin'));
}

function sz_google_admin_base_youtube() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_base','youtube');
	sz_google_common_form_description(__('with this module can be inserted in wordpress a video youtube, you can also use a widget to the inclusion of video in the sidebar on your theme. Through the options in the shortcode you can configure many parameters to customize the embed code.','szgoogleadmin'));
}

function sz_google_admin_base_documentation() 
{
	sz_google_common_form_checkbox_yesno('sz_google_options_base','documentation');
	sz_google_common_form_description(__('activating this option you can see the documentation in the main menu of this plugin with the parameters to be used in [shortcodes] or PHP functions provided. There is a series of boxes in alphabetical order.','szgoogleadmin'));
}

/* ************************************************************************** */
/* ADMIN Funzioni per SEZIONE Configurazione Generale BASE                    */
/* ************************************************************************** */

function sz_google_admin_base_validate($plugin_options) {
  return $plugin_options;
}

function sz_google_admin_base_section() {}
function sz_google_admin_callback_generale() {}

/* ************************************************************************** */
/* ADMIN Aggiunta di tutti i file admin richiesti in base alle attivazioni    */
/* ************************************************************************** */

$a = new SZGoogleModule();
$options_admin = $a->getOptions();

if ($options_admin['plus']          == '1') @require_once(dirname(__FILE__).'/sz-google-admin-plus.php');
if ($options_admin['analytics']     == '1') @require_once(dirname(__FILE__).'/sz-google-admin-analytics.php');
if ($options_admin['drive']         == '1') @require_once(dirname(__FILE__).'/sz-google-admin-drive.php');
if ($options_admin['fonts']         == '1') @require_once(dirname(__FILE__).'/sz-google-admin-fonts.php');
if ($options_admin['groups']        == '1') @require_once(dirname(__FILE__).'/sz-google-admin-groups.php');
if ($options_admin['panoramio']     == '1') @require_once(dirname(__FILE__).'/sz-google-admin-panoramio.php');
if ($options_admin['translate']     == '1') @require_once(dirname(__FILE__).'/sz-google-admin-translate.php');
if ($options_admin['youtube']       == '1') @require_once(dirname(__FILE__).'/sz-google-admin-youtube.php');
if ($options_admin['documentation'] == '1') @require_once(dirname(__FILE__).'/sz-google-admin-documentation.php');

/* ************************************************************************** */
/* ADMIN Funzioni per disegno parte del form (esecuzione generale)            */
/* ************************************************************************** */

function sz_google_common_form($title,$setting,$sections,$documentation=false)
{

	echo '<div id="sz-google-wrap" class="wrap">';
	echo '<h2>'.ucwords($title).'</h2>';

	if (!$documentation) echo '<p>'.ucfirst(__('overriding the default settings with your own specific preferences','szgoogleadmin')).'</p>';
		else echo '<p>'.ucfirst(__('select the module documentation to read','szgoogleadmin')).'</p>';

	// Contenitore principale con zona dedicata ai parametri di configurazione
	// definiti tramite le chiamate dei singoli moduli attivati da pannello ammnistrativo

	echo '<div class="postbox-container" id="sz-google-admin-options">';
	echo '<div class="metabox-holder">';
	echo '<div class="meta-box-sortables ui-sortable" id="sz-google-box">';

	// Se la chiamata contiene un array di documentazione posso disattivare
	// il form per la modifica di parametri dato che si tratta di solo lettura

	if (!$documentation) {
		echo '<form method="post" action="options.php" enctype="multipart/form-data">';
		echo '<input type="hidden" name="sz_google_options_plus[plus_redirect_flush]" value="0">';
	}

	// Se la chiamata non contiene un array di documentazione eseguo
	// la creazione del codice HTML con tutti i campi opzione da modificare

	settings_fields($setting);

	foreach ($sections as $section => $title) {
		echo '<div class="postbox'; if ($documentation) echo " closed";
		echo '">';
		echo '<div class="handlediv" title="'.ucfirst(__('click to toggle','szgoogleadmin')).'"><br></div>';
		echo '<h3 class="hndle"><span>'.$title.'</span></h3>';
		echo '<div class="inside">';
		do_settings_sections($section);
		echo '</div>';
		echo '</div>';
	}	

	// Se la chiamata contiene un array di documentazione posso disattivare
	// il form per la modifica di parametri dato che si tratta di solo lettura

	if (!$documentation) {
		echo '<p class="submit"><input name="Submit" type="submit" class="button-primary" value="'.ucfirst(__('save changes','szgoogleadmin')).'"/></p>';
		echo '</form>';
	}

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
	echo '<li><a target="_blank" href="http://wordpress.org/support/view/plugin-reviews/sz-google">'.ucfirst(__('rate the plugin','szgoogleadmin')).'</a></li>';
	echo '<li><a target="_blank" href="https://plus.google.com/communities/109254048492234113886">'.ucfirst(__('join our community','szgoogleadmin')).'</a></li>';
	echo '<li><a target="_blank" href="https://plus.google.com/+wpitalyplus">'.ucfirst(__('join our google+ page','szgoogleadmin')).'</a></li>';
	echo '</ul>';
	echo '</div>';
	echo '</div>';

	// Sezione su sidebar per "pagina ufficiale"

	echo '<div id="official-plugin" class="postbox">';
	echo '<div class="handlediv" title="'.ucfirst(__('click to toggle','szgoogleadmin')).'"><br></div>';
	echo '<h3 class="hndle"><span><strong>'.ucwords(__('official page','szgoogleadmin')).'</strong></span></h3>';
	echo '<div class="inside">';
	echo '<a target="_blank" href="https://plus.google.com/+wpitalyplus"><img src="'.SZ_PLUGIN_GOOGLE_PATH_IMAGE.'wpitalyplus.png'.'" alt="WordPress Italy+" style="width:100%;height:auto;vertical-align:bottom;"></a>';
	echo '</div>';
	echo '</div>';

	// Sezione su sidebar per "Richiesta di supporto"

	echo '<div id="support-plugin" class="postbox">';
	echo '<div class="handlediv" title="'.ucfirst(__('click to toggle','szgoogleadmin')).'"><br></div>';
	echo '<h3 class="hndle"><span><strong>'.ucwords(__('support','szgoogleadmin')).'</strong></span></h3>';
	echo '<div class="inside">';
	echo '<ul>';
	echo '<li><a target="_blank" href="http://wordpress.org/support/plugin/sz-google">'.ucfirst(__('support for bugs and reports','szgoogleadmin')).'</a></li>';
	echo '<li><a target="_blank" href="https://plus.google.com/communities/109254048492234113886">'.ucfirst(__('support for new requests','szgoogleadmin')).'</a></li>';
	echo '</ul>';
	echo '</div>';
	echo '</div>';

	// Sezione su sidebar per "Autori del plugin"

	echo '<div id="authors-plugin" class="postbox">';
	echo '<div class="handlediv" title="'.ucfirst(__('click to toggle','szgoogleadmin')).'"><br></div>';
	echo '<h3 class="hndle"><span><strong>'.ucwords(__('authors','szgoogleadmin')).'</strong></span></h3>';
	echo '<div class="inside">';
	echo '<ul>';
	echo '<li><a target="_blank" href="https://plus.google.com/+EugenioPetullà">Eugenio Petullà</a></li>';
	echo '<li><a target="_blank" href="https://plus.google.com/+MassimoDellaRovere">Massimo Della Rovere</a></li>';
	echo '</ul>';
	echo '</div>';
	echo '</div>';

	// Sezione su sidebar per "Informazioni sul plugin"

	echo '<div id="info-plugin" class="postbox">';
	echo '<div class="handlediv" title="'.ucfirst(__('click to toggle','szgoogleadmin')).'"><br></div>';
	echo '<h3 class="hndle"><span><strong>'.ucwords(__('latest news','szgoogleadmin')).'</strong></span></h3>';
	echo '<div class="inside">';
	echo '<ul>';
	echo '<li><a target="_blank" href="https://plus.google.com/+wpitalyplus">'.ucfirst(__('news:','szgoogleadmin'))."&nbsp;".ucfirst(__('official page','szgoogleadmin')).'</a></li>';
	echo '<li><a target="_blank" href="http://wpitalyplus.com">'.ucfirst(__('news:','szgoogleadmin'))."&nbsp;".ucfirst(__('official website','szgoogleadmin')).'</a></li>';
	echo '<li><a target="_blank" href="https://plus.google.com/communities/109254048492234113886">'.ucfirst(__('news:','szgoogleadmin'))."&nbsp;".ucfirst(__('community WordPress','szgoogleadmin')).'</a></li>';
	echo '<li><a target="_blank" href="http://www.youtube.com/user/wpitalyplus?sub_confirmation=1">'.ucfirst(__('news:','szgoogleadmin'))."&nbsp;".ucfirst(__('youtube channel','szgoogleadmin')).'</a></li>';
	echo '<li><a target="_blank" href="https://startbyzero.com/wordpress/plugin-google/">'.ucfirst(__('news:','szgoogleadmin'))."&nbsp;".ucfirst(__('official documentation','szgoogleadmin')).'</a></li>';
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
/* ADMIN Funzioni per disegno descrizione aggiuntiva sotto i campi opzione    */
/* ************************************************************************** */

function sz_google_common_form_description($description) 
{
	echo '<tr valign="top"><td class="description" colspan="2">';
	echo ucfirst(trim($description));
	echo '</td></tr>';
}

/* ************************************************************************** */
/* ADMIN Funzioni per disegno parte del form (campi alfanumerici)             */
/* ************************************************************************** */

function sz_google_common_form_text($optionset,$name,$class='medium',$placeholder='') 
{	
	$options = get_option($optionset);

	if (!isset($options[$name])) $options[$name] = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		else $options[$name] =  esc_html($options[$name]);

	echo '<input name="'.$optionset.'['.$name.']" type="text" class="'.$class.'" ';
	echo 'value="'.$options[$name].'" placeholder="'.$placeholder.'"/>';
}

/* ************************************************************************** */
/* ADMIN Funzioni per disegno parte del form (SELECT)                         */
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
/* ADMIN Funzioni per disegno parte del form (campi con checkbox S/N)         */
/* ************************************************************************** */

function sz_google_common_form_checkbox_yesno($optionset,$name,$class='medium') 
{
	$options = get_option($optionset);

	if (!isset($options[$name])) $options[$name] = '0';

	echo '<label class="sz-google"><input name="'.$optionset.'['.$name.']" type="checkbox" value="1" ';
	echo 'class="'.$class.'" '.checked(1,$options[$name],false).'/><span class="checkbox" style="display:none">'.__('YES / NO','szgoogleadmin').'</span></label>';
}

/* ************************************************************************** */
/* ADMIN Funzioni per disegno parte del form (campi con checkbox S/N)         */
/* ************************************************************************** */

function sz_google_common_form_checkbox_yn($optionset,$name,$class='small') 
{
	$options = get_option($optionset);

	if (!isset($options[$name])) $options[$name] = '0';

	echo '<label class="sz-google"><input name="'.$optionset.'['.$name.']" type="checkbox" value="1" ';
	echo 'class="'.$class.'" '.checked(1,$options[$name],false).'/><span class="checkbox checkboxsmall" style="display:none">'.__('Y/N','szgoogleadmin').'</span></label>';
}

/* ************************************************************************** */
/* ADMIN Funzioni per disegno parte del form (campi numerici con step 1)      */
/* ************************************************************************** */

function sz_google_common_form_number_step_1($optionset,$name,$class='medium',$placeholder='') 
{
	$options = get_option($optionset);

	if (!isset($options[$name])) $options[$name]=""; 

	echo '<input name="'.$optionset.'['.$name.']" type="number" step="1" class="'.$class.'" ';
	echo 'value="'.$options[$name].'" placeholder="'.$placeholder.'"/>';
}