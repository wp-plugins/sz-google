<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_ADMIN') or !SZ_PLUGIN_GOOGLE_ADMIN) die();

/* ************************************************************************** */
/* Creazione e aggiunta menu di amministrazione                               */
/* ************************************************************************** */

function sz_google_admin_plus_menu() 
{
	if (function_exists('add_submenu_page')) {
		add_submenu_page(SZ_PLUGIN_GOOGLE_ADMIN_BASENAME,'SZ-Google - Google+','Google+','manage_options','sz-google-admin-gplus.php','sz_google_admin_plus_callback'); 
	}
}

/* ************************************************************************** */
/* Registrazione delle opzioni legate al Plugin                               */
/* ************************************************************************** */

function sz_google_admin_plus_fields()
{
	register_setting('sz_google_options_plus','sz_google_options_plus','sz_google_admin_plus_validate');

	// Definizione sezione per configurazione GOOGLE+

	add_settings_section('sz_google_plus_section',ucfirst(__('google+ ID','szvgoogleadmin')),'sz_google_admin_plus_section','sz-google-admin-plus.php');
	add_settings_field('plus_profile',ucfirst(__('google+ Profile','szgoogleadmin')),'sz_google_admin_plus_profile','sz-google-admin-plus.php','sz_google_plus_section');
	add_settings_field('plus_page',ucfirst(__('google+ Page','szgoogleadmin')),'sz_google_admin_plus_page','sz-google-admin-plus.php','sz_google_plus_section');
	add_settings_field('plus_community',ucfirst(__('google+ Community','szgoogledmin')),'sz_google_admin_plus_community','sz-google-admin-plus.php','sz_google_plus_section');

	// Definizione sezione per configurazione GOOGLE+ LANGUAGE

	add_settings_section('sz_google_plus_language',ucfirst(__('google+ language','szgoogleadmin')),'sz_google_admin_plus_section','sz-google-admin-plus.php');
	add_settings_field('plus_language',ucfirst(__('select language','szgoogleadmin')),'sz_google_admin_plus_language','sz-google-admin-plus.php','sz_google_plus_language');

	// Definizione sezione per configurazione GOOGLE+ BADGE WIDGETS

	add_settings_section('sz_google_plus_widgets',ucfirst(__('google+ badge widget','szgoogleadmin')),'sz_google_admin_plus_section','sz-google-admin-plus.php');
	add_settings_field('plus_widget_pr_enable',ucfirst(__('widget G+ profile','szgoogleadmin')),'sz_google_admin_plus_widget_profile','sz-google-admin-plus.php','sz_google_plus_widgets');
	add_settings_field('plus_widget_pa_enable',ucfirst(__('widget G+ page','szgoogleadmin')),'sz_google_admin_plus_widget_page','sz-google-admin-plus.php','sz_google_plus_widgets');
	add_settings_field('plus_widget_co_enable',ucfirst(__('widget G+ community','szgoogleadmin')),'sz_google_admin_plus_widget_community','sz-google-admin-plus.php','sz_google_plus_widgets');
	add_settings_field('plus_widget_size_portrait',ucfirst(__('widget width portrait','szgoogleadmin')),'sz_google_admin_plus_widget_size_portrait','sz-google-admin-plus.php','sz_google_plus_widgets');
	add_settings_field('plus_widget_size_landscape',ucfirst(__('widget width landscape','szgoogleadmin')),'sz_google_admin_plus_widget_size_landscape','sz-google-admin-plus.php','sz_google_plus_widgets');

	// Definizione sezione per configurazione GOOGLE+ BADGE SHORTCODE

	add_settings_section('sz_google_plus_shortcodes',ucfirst(__('google+ badge shortcodes','szgoogleadmin')),'sz_google_admin_plus_section','sz-google-admin-plus.php');
	add_settings_field('plus_shortcode_pr_enable',ucfirst(__('shortcode G+ profile','szgoogleadmin')),'sz_google_admin_plus_shortcode_profile','sz-google-admin-plus.php','sz_google_plus_shortcodes');
	add_settings_field('plus_shortcode_pa_enable',ucfirst(__('shortcode G+ page','szgoogleadmin')),'sz_google_admin_plus_shortcode_page','sz-google-admin-plus.php','sz_google_plus_shortcodes');
	add_settings_field('plus_shortcode_co_enable',ucfirst(__('shortcode G+ community','szgoogleadmin')),'sz_google_admin_plus_shortcode_community','sz-google-admin-plus.php','sz_google_plus_shortcodes');
	add_settings_field('plus_shortcode_size_portrait',ucfirst(__('shortcode width portrait','szgoogleadmin')),'sz_google_admin_plus_shortcode_size_portrait','sz-google-admin-plus.php','sz_google_plus_shortcodes');
	add_settings_field('plus_shortcode_size_landscape',ucfirst(__('shortcode width landscape','szgoogleadmin')),'sz_google_admin_plus_shortcode_size_landscape','sz-google-admin-plus.php','sz_google_plus_shortcodes');

	// Definizione sezione per configurazione GOOGLE+ BUTTON SHORTCODE
	add_settings_section('sz_google_plus_buttons',ucfirst(__('google+ button shortcodes','szgoogleadmin')),'sz_google_admin_plus_section','sz-google-admin-plus.php');
	add_settings_field('plus_button_enable_plusone',ucfirst(__('shortcode G+ plusone','szgoogleadmin')),'sz_google_admin_plus_button_plusone','sz-google-admin-plus.php','sz_google_plus_buttons');
	add_settings_field('plus_button_enable_sharing',ucfirst(__('shortcode G+ sharing','szgoogleadmin')),'sz_google_admin_plus_button_sharing','sz-google-admin-plus.php','sz_google_plus_buttons');
	add_settings_field('plus_button_enable_follow' ,ucfirst(__('shortcode G+ follow' ,'szgoogleadmin')),'sz_google_admin_plus_button_follow' ,'sz-google-admin-plus.php','sz_google_plus_buttons');

	// Definizione sezione per configurazione GOOGLE+ COMMENTS

	add_settings_section('sz_google_plus_comments',ucfirst(__('google+ comment system','szgoogleadmin')),'sz_google_admin_plus_section','sz-google-admin-plus.php');
	add_settings_field('plus_comments_gp_enable',ucfirst(__('enable G+ comments','szgoogleadmin')),'sz_google_admin_plus_comments_gp','sz-google-admin-plus.php','sz_google_plus_comments');
	add_settings_field('plus_comments_wp_enable',ucfirst(__('enable WP comments','szgoogleadmin')),'sz_google_admin_plus_comments_wp','sz-google-admin-plus.php','sz_google_plus_comments');
	add_settings_field('plus_comments_ac_enable',ucfirst(__('comments after content','szgoogleadmin')),'sz_google_admin_plus_comments_ac','sz-google-admin-plus.php','sz_google_plus_comments');
	add_settings_field('plus_comments_aw_enable',ucfirst(__('comments after WP system','szgoogleadmin')),'sz_google_admin_plus_comments_aw','sz-google-admin-plus.php','sz_google_plus_comments');
	add_settings_field('plus_comments_wd_enable',ucfirst(__('G+ comments widget','szgoogleadmin')),'sz_google_admin_plus_comments_wd','sz-google-admin-plus.php','sz_google_plus_comments');
	add_settings_field('plus_comments_sh_enable',ucfirst(__('G+ comments shortcode','szgoogleadmin')),'sz_google_admin_plus_comments_sh','sz-google-admin-plus.php','sz_google_plus_comments');
	add_settings_field('plus_comments_dt_enable',ucfirst(__('G+ comments date switch','szgoogleadmin')),'sz_google_admin_plus_comments_dt','sz-google-admin-plus.php','sz_google_plus_comments');

	// Definizione sezione per configurazione GOOGLE+ REDIRECT
	add_settings_section('sz_google_plus_redirect',ucfirst(__('google+ custom URL','szgoogleadmin')),'sz_google_admin_plus_section','sz-google-admin-plus.php');
	add_settings_field('plus_redirect_sign',ucfirst(__('enable redirect /+'   ,'szgoogleadmin')),'sz_google_admin_plus_redirect_sign','sz-google-admin-plus.php','sz_google_plus_redirect');
	add_settings_field('plus_redirect_plus',ucfirst(__('enable redirect /plus','szgoogleadmin')),'sz_google_admin_plus_redirect_plus','sz-google-admin-plus.php','sz_google_plus_redirect');
	add_settings_field('plus_redirect_curl',ucfirst(__('enable redirect URL'  ,'szgoogleadmin')),'sz_google_admin_plus_redirect_curl','sz-google-admin-plus.php','sz_google_plus_redirect');
}

/* ************************************************************************** */
/* Aggiungo le funzioni per l'esecuzione in admin                             */
/* ************************************************************************** */

add_action('admin_menu','sz_google_admin_plus_menu');
add_action('admin_init','sz_google_admin_plus_fields');

/* ************************************************************************** */
/* Funzioni per SEZIONE Configurazione Google+                                */
/* ************************************************************************** */

function sz_google_admin_plus_callback() {
	sz_google_common_form(
		ucfirst(__('google+ configuration','szgoogleadmin')),
		'sz_google_options_plus',
		'sz-google-admin-plus.php'
	); 
}

/* ************************************************************************** */
/* Funzioni per SEZIONE Configurazione Google+ ID                             */
/* ************************************************************************** */

function sz_google_admin_plus_profile() {
	echo '<input type="hidden" name="sz_google_options_plus[plus_redirect_flush]" value="0">';
	sz_google_common_form_text_medium(
		'sz_google_options_plus','plus_profile',
		__('insert ID your profile','szgoogleadmin')
	);
}

function sz_google_admin_plus_page() {
	sz_google_common_form_text_medium(
		'sz_google_options_plus','plus_page',
		__('insert ID your page','szgoogleadmin')
	);
}

function sz_google_admin_plus_community() {
	sz_google_common_form_text_medium(
		'sz_google_options_plus','plus_community',
		__('insert ID your community','szgoogleadmin')
	);
}

function sz_google_admin_plus_language() 
{
	$options = get_option('sz_google_options_plus');

	if (!isset($options['plus_language'])) $options['plus_language'] = '99';

	echo '<select name="sz_google_options_plus[plus_language]">';

	foreach (sz_google_get_languages() as $key=>$value) {
		$selected = ($options['plus_language'] == $key) ? ' selected = "selected"' : '';
		echo '<option value="'.$key.'"'.$selected.'>'.$value.'</option>';
	}

	echo '</select>';
}

/* ************************************************************************** */
/* Funzioni per SEZIONE Configurazione Google+ Widgets                        */
/* ************************************************************************** */

function sz_google_admin_plus_widget_profile() {
	sz_google_common_form_checkbox(
		'sz_google_options_plus','plus_widget_pr_enable'
	);
}

function sz_google_admin_plus_widget_page() {
	sz_google_common_form_checkbox(
		'sz_google_options_plus','plus_widget_pa_enable'
	);
}

function sz_google_admin_plus_widget_community() {
	sz_google_common_form_checkbox(
		'sz_google_options_plus','plus_widget_co_enable'
	);
}

function sz_google_admin_plus_widget_size_portrait() {
	sz_google_common_form_number_step_1(
		'sz_google_options_plus','plus_widget_size_portrait',
		SZ_PLUGIN_GOOGLE_WIDGET_SIZE_PORTRAIT
	);
}

function sz_google_admin_plus_widget_size_landscape() {
	sz_google_common_form_number_step_1(
		'sz_google_options_plus','plus_widget_size_landscape',
		SZ_PLUGIN_GOOGLE_WIDGET_SIZE_LANDSCAPE
	);
}

/* ************************************************************************** */
/* Funzioni per la definizione dei campi legati a G+ shortcodes               */
/* ************************************************************************** */

function sz_google_admin_plus_shortcode_profile() {
	sz_google_common_form_checkbox(
		'sz_google_options_plus','plus_shortcode_pr_enable'
	);
}

function sz_google_admin_plus_shortcode_page() {
	sz_google_common_form_checkbox(
		'sz_google_options_plus','plus_shortcode_pa_enable'
	);
}

function sz_google_admin_plus_shortcode_community() {
	sz_google_common_form_checkbox(
		'sz_google_options_plus','plus_shortcode_co_enable'
	);
}

function sz_google_admin_plus_shortcode_size_portrait() {
	sz_google_common_form_number_step_1(
		'sz_google_options_plus','plus_shortcode_size_portrait',
		SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_SIZE_PORTRAIT
	);
}

function sz_google_admin_plus_shortcode_size_landscape() {
	sz_google_common_form_number_step_1(
		'sz_google_options_plus','plus_shortcode_size_landscape',
		SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_SIZE_LANDSCAPE
	);
}
/* ************************************************************************** */
/* Funzioni per la definizione dei campi legati a G+ BUTTONS                  */
/* ************************************************************************** */

function sz_google_admin_plus_button_plusone() {
	sz_google_common_form_checkbox(
		'sz_google_options_plus','plus_button_enable_plusone'
	);
}

function sz_google_admin_plus_button_sharing() {
	sz_google_common_form_checkbox(
		'sz_google_options_plus','plus_button_enable_sharing'
	);
}

function sz_google_admin_plus_button_follow() {
	sz_google_common_form_checkbox(
		'sz_google_options_plus','plus_button_enable_follow'
	);
}

/* ************************************************************************** */
/* Funzioni per la definizione dei campi legati a G+ COMMENTS                 */
/* ************************************************************************** */

function sz_google_admin_plus_comments_gp() {
	sz_google_common_form_checkbox(
		'sz_google_options_plus','plus_comments_gp_enable'
	);
}

function sz_google_admin_plus_comments_wp() {
	sz_google_common_form_checkbox(
		'sz_google_options_plus','plus_comments_wp_enable'
	);
}

function sz_google_admin_plus_comments_ac() {
	sz_google_common_form_checkbox(
		'sz_google_options_plus','plus_comments_ac_enable'
	);
}

function sz_google_admin_plus_comments_aw() {
	sz_google_common_form_checkbox(
		'sz_google_options_plus','plus_comments_aw_enable'
	);
}

function sz_google_admin_plus_comments_wd() {
	sz_google_common_form_checkbox(
		'sz_google_options_plus','plus_comments_wd_enable'
	);
}

function sz_google_admin_plus_comments_sh() {
	sz_google_common_form_checkbox(
		'sz_google_options_plus','plus_comments_sh_enable'
	);
}

/* ************************************************************************** */
/* Funzioni per la definizione dei campi legati a G+ COMMENTS DATE            */
/* ************************************************************************** */

function sz_google_admin_plus_comments_dt() 
{
	sz_google_common_form_checkbox(
		'sz_google_options_plus','plus_comments_dt_enable'
	);

	// Creazione delle select per l'indicazione della data
	
	echo '&nbsp;';
	$date_format = __('MDA','szgoogleadmin');

	// Creazione delle select per l'indicazione della data

	if ($date_format == 'MDA') {
		sz_google_admin_plus_comments_dt_month(); 
		sz_google_admin_plus_comments_dt_day(); 
		sz_google_admin_plus_comments_dt_year(); 
		echo '&nbsp;'.__('(month / day / year)','szgoogleadmin');
	}

	if ($date_format == 'DMA') {
		sz_google_admin_plus_comments_dt_day(); 
		sz_google_admin_plus_comments_dt_month(); 
		sz_google_admin_plus_comments_dt_year(); 
		echo '&nbsp;'.__('(day / month / year)','szgoogleadmin');
	}

	if ($date_format == 'AMD') {
		sz_google_admin_plus_comments_dt_year(); 
		sz_google_admin_plus_comments_dt_month(); 
		sz_google_admin_plus_comments_dt_day(); 
		echo '&nbsp;'.__('(year / month / day)','szgoogleadmin');
	}

}

function sz_google_admin_plus_comments_dt_day() 
{
	$options = get_option('sz_google_options_plus');

	if (!isset($options['plus_comments_dt_day']))   $options['plus_comments_dt_day']   = sprintf('%02d',date('d'));
	if (!isset($options['plus_comments_dt_month'])) $options['plus_comments_dt_month'] = sprintf('%02d',date('m')); 
	if (!isset($options['plus_comments_dt_year']))  $options['plus_comments_dt_year']  = sprintf('%04d',date('Y')); 

	// Creazione campo per giorno di selezione
	
	echo '<select name="sz_google_options_plus[plus_comments_dt_day]">';

	foreach (range(1,31) as $key) {
		$selected = ($options['plus_comments_dt_day'] == sprintf('%02d',$key)) ? ' selected = "selected"' : '';
		echo '<option value="'.sprintf('%02d',$key).'"'.$selected.'>'.sprintf('%02d',$key).'</option>';
	}

	echo '</select>';
}

function sz_google_admin_plus_comments_dt_month() 
{
	$options = get_option('sz_google_options_plus');

	if (!isset($options['plus_comments_dt_day']))   $options['plus_comments_dt_day']   = sprintf('%02d',date('d'));
	if (!isset($options['plus_comments_dt_month'])) $options['plus_comments_dt_month'] = sprintf('%02d',date('m')); 
	if (!isset($options['plus_comments_dt_year']))  $options['plus_comments_dt_year']  = sprintf('%04d',date('Y')); 

	// Creazione campo per mese di selezione

	echo '<select name="sz_google_options_plus[plus_comments_dt_month]">';

	foreach (range(1,12) as $key) {
		$selected = ($options['plus_comments_dt_month'] == sprintf('%02d',$key)) ? ' selected = "selected"' : '';
		echo '<option value="'.sprintf('%02d',$key).'"'.$selected.'>'.sprintf('%02d',$key).'</option>';
	}

	echo '</select>';
}

function sz_google_admin_plus_comments_dt_year() 
{
	$options = get_option('sz_google_options_plus');

	if (!isset($options['plus_comments_dt_day']))   $options['plus_comments_dt_day']   = sprintf('%02d',date('d'));
	if (!isset($options['plus_comments_dt_month'])) $options['plus_comments_dt_month'] = sprintf('%02d',date('m')); 
	if (!isset($options['plus_comments_dt_year']))  $options['plus_comments_dt_year']  = sprintf('%04d',date('Y')); 

	// Creazione campo per anno di selezione
	
	echo '<select name="sz_google_options_plus[plus_comments_dt_year]">';

	foreach (array_reverse(range(2000,date('Y')+1)) as $key) {
		$selected = ($options['plus_comments_dt_year'] == sprintf('%04d',$key)) ? ' selected = "selected"' : '';
		echo '<option value="'.sprintf('%04d',$key).'"'.$selected.'>'.sprintf('%04d',$key).'</option>';
	}

	echo '</select>';
}

/* ************************************************************************** */
/* Funzioni per la definizione dei campi legati a G+ REDIRECT                 */
/* ************************************************************************** */

function sz_google_admin_plus_redirect_sign() {
	sz_google_common_form_checkbox(
		'sz_google_options_plus','plus_redirect_sign'
	);
	sz_google_admin_plus_redirect_text(
		'sz_google_options_plus','plus_redirect_sign_url',
		__('destination URL','szgoogleadmin')	
	);
} 

function sz_google_admin_plus_redirect_plus() {
	sz_google_common_form_checkbox(
		'sz_google_options_plus','plus_redirect_plus'
	);
	sz_google_admin_plus_redirect_text(
		'sz_google_options_plus','plus_redirect_plus_url',
		__('destination URL','szgoogleadmin')	
	);
} 

function sz_google_admin_plus_redirect_curl() 
{

	sz_google_common_form_checkbox(
		'sz_google_options_plus','plus_redirect_curl'
	);

	sz_google_admin_plus_redirect_text(
		'sz_google_options_plus','plus_redirect_curl_dir',
		__('source path URL for redirect','szgoogleadmin')	
	);

	echo '<br/><span style="visibility:hidden">';

	sz_google_common_form_checkbox(
		'sz_google_options_plus','plus_redirect_curl_fix'
	);

	echo '</span>';

	sz_google_admin_plus_redirect_text(
		'sz_google_options_plus','plus_redirect_curl_url',
		__('destination URL','szgoogleadmin')	
	);

} 

/* ************************************************************************** */
/* Funzioni per la definizione dei campi legati a G+ REDIRECT                 */
/* ************************************************************************** */

function sz_google_admin_plus_redirect_text($set,$name,$placeholder) 
{
	$options = get_option($set);
	if (!isset($options[$name])) $options[$name] = '';
	echo '&nbsp;<input type="text" size="50" name="'.$set.'['.$name.']" value="'.trim($options[$name]).'" placeholder="'.$placeholder.'">';
} 
 
/* ************************************************************************** */
/* Funzioni per la definizione dei campi legati a G+ controlli generali       */
/* ************************************************************************** */

function sz_google_admin_plus_validate($plugin_options) {
  return $plugin_options;
}

function sz_google_admin_plus_section() {}