<?php
/*
Plugin Name: SZ - Google
Plugin URI: http://startbyzero.com/webmaster/wordpress-plugin/sz-google/
Description: Plugin to integrate <a href="http://google.com" target="_blank">Google's</a> products in <a href="http://wordpress.org" target="_blank">WordPress</a> with particular attention to the widgets provided by the social network Google+. Before using the plug-in <em>sz-google</em> pay attention to the options to be specified in the admin panel and enter all the parameters necessary for the proper functioning of the plugin. If you want to know the latest news and releases from the plug-in <a href="http://wordpress.org/plugins/sz-google/">SZ-Google for WordPress</a> follow the official page of <a href="https://plus.google.com/115876177980154798858/" target="_blank">startbyzero</a> present in the social network Google+ or subscribe to our community <a href="https://plus.google.com/communities/109254048492234113886" target="_blank">WordPress Italy+</a> always present on Google+.
Author: Massimo Della Rovere
Version: 0.7.0
Author URI: https://plus.google.com/106567288702045182616
License: GPL2

Copyright 2012 startbyzero (email: webmaster@startbyzero.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
if (!defined('ABSPATH')) die("Accesso diretto al file non permesso");

/* ************************************************************************** */
/* Definizione delle costanti da usare nel plugin uso generale                */
/* ************************************************************************** */

define('SZ_PLUGIN_GOOGLE',true);
define('SZ_PLUGIN_GOOGLE_VERSION','0.4');
define('SZ_PLUGIN_GOOGLE_REPOSITORY','http://wordpress.org/plugins/sz-google/');
define('SZ_PLUGIN_GOOGLE_PATH',plugin_dir_url(__FILE__));
define('SZ_PLUGIN_GOOGLE_PATH_CSS',SZ_PLUGIN_GOOGLE_PATH.'css/');
define('SZ_PLUGIN_GOOGLE_PATH_CSS_IMAGE',SZ_PLUGIN_GOOGLE_PATH.'css/images/');
define('SZ_PLUGIN_GOOGLE_PATH_IMAGE',SZ_PLUGIN_GOOGLE_PATH.'images/');

/* ************************************************************************** */
/* Definizione delle costanti da usare nel plugin uso generale                */
/* ************************************************************************** */

define('SZ_PLUGIN_GOOGLE_VALUE_NO'   ,'0');
define('SZ_PLUGIN_GOOGLE_VALUE_YES'  ,'1');
define('SZ_PLUGIN_GOOGLE_VALUE_NULL' ,'');
define('SZ_PLUGIN_GOOGLE_VALUE_LANG' ,'99');
define('SZ_PLUGIN_GOOGLE_VALUE_DAY'  ,sprintf('%02d',date('d')));
define('SZ_PLUGIN_GOOGLE_VALUE_MONTH',sprintf('%02d',date('m')));
define('SZ_PLUGIN_GOOGLE_VALUE_YEAR' ,sprintf('%04d',date('Y')));

/* ************************************************************************** */
/* Definizione delle costanti da usare nel plugin G+                          */
/* ************************************************************************** */

define('SZ_PLUGIN_GOOGLE_WIDGET_SIZE_PORTRAIT','180');
define('SZ_PLUGIN_GOOGLE_WIDGET_SIZE_LANDSCAPE','275');

define('SZ_PLUGIN_GOOGLE_PLUS_ID_PROFILE','106567288702045182616');
define('SZ_PLUGIN_GOOGLE_PLUS_ID_PAGE','117259631219963935481');
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

/* ************************************************************************** */
/* Definizione delle costanti da usare nel modulo GOOGLE ANALYTICS            */
/* ************************************************************************** */

define('SZ_PLUGIN_GOOGLE_GA_HEADER','H');
define('SZ_PLUGIN_GOOGLE_GA_FOOTER','F');
define('SZ_PLUGIN_GOOGLE_GA_MANUAL','M');

/* ************************************************************************** */
/* Definizione delle costanti da usare nel modulo GOOGLE GROUPS               */
/* ************************************************************************** */

define('SZ_PLUGIN_GOOGLE_GROUPS_NAME'  ,'adsense-api');
define('SZ_PLUGIN_GOOGLE_GROUPS_WIDTH' ,'0');
define('SZ_PLUGIN_GOOGLE_GROUPS_HEIGHT','700');

/* ************************************************************************** */
/* Definizione delle costanti da usare nel modulo GOOGLE YOUTUBE              */
/* ************************************************************************** */

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

/* ************************************************************************** */
/* Caricamento della lingua per il plugin SZ-Google                           */
/* ************************************************************************** */

function sz_google_language_init() 
{
	load_plugin_textdomain(
		'szgoogleadmin',false,dirname(plugin_basename(__FILE__ )).'/languages');
}

add_action('init','sz_google_language_init');

/* ************************************************************************** */
/* Carico il file pluggable se nessuno ha definito le funzioni utente         */
/* ************************************************************************** */

if (!function_exists('is_user_logged_in()')) {
	require_once (ABSPATH.WPINC.'/pluggable.php');
}

/* ************************************************************************** */
/* Funzione creazione delle opzioni in attivazione                            */
/* ************************************************************************** */

function sz_google_plugin_activate()
{
	// Impostazione valori di default che riguardano  
	// parametri di base come l'attivazione dei moduli 

	$settings_base = array(
		'plus'                           => SZ_PLUGIN_GOOGLE_VALUE_YES,
		'analytics'                      => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'groups'                         => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'translate'                      => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'youtube'                        => SZ_PLUGIN_GOOGLE_VALUE_NO,
	);

	// Impostazione valori di default che riguardano  
	// il modulo collegato alle funzione di Google PLus 

	$settings_plus = array(
		'plus_page'                      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'plus_profile'                   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'plus_community'                 => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'plus_language'                  => SZ_PLUGIN_GOOGLE_VALUE_LANG,
		'plus_widget_pr_enable'          => SZ_PLUGIN_GOOGLE_VALUE_YES,
		'plus_widget_pa_enable'          => SZ_PLUGIN_GOOGLE_VALUE_YES,		
		'plus_widget_co_enable'          => SZ_PLUGIN_GOOGLE_VALUE_YES,		
		'plus_widget_size_portrait'      => SZ_PLUGIN_GOOGLE_WIDGET_SIZE_PORTRAIT,
		'plus_widget_size_landscape'     => SZ_PLUGIN_GOOGLE_WIDGET_SIZE_LANDSCAPE,
		'plus_shortcode_pr_enable'       => SZ_PLUGIN_GOOGLE_VALUE_YES,
		'plus_shortcode_pa_enable'       => SZ_PLUGIN_GOOGLE_VALUE_YES,		
		'plus_shortcode_co_enable'       => SZ_PLUGIN_GOOGLE_VALUE_YES,		
		'plus_shortcode_size_portrait'   => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_SIZE_PORTRAIT,
		'plus_shortcode_size_landscape'  => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_SIZE_LANDSCAPE,
		'plus_button_enable_plusone'     => SZ_PLUGIN_GOOGLE_VALUE_YES,
		'plus_button_enable_sharing'     => SZ_PLUGIN_GOOGLE_VALUE_YES,
		'plus_button_enable_follow'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
		'plus_comments_gp_enable'        => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'plus_comments_wp_enable'        => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'plus_comments_ac_enable'        => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'plus_comments_aw_enable'        => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'plus_comments_wd_enable'        => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'plus_comments_sh_enable'        => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'plus_comments_dt_enable'        => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'plus_comments_dt_day'           => SZ_PLUGIN_GOOGLE_VALUE_DAY,
		'plus_comments_dt_month'         => SZ_PLUGIN_GOOGLE_VALUE_MONTH,
		'plus_comments_dt_year'          => SZ_PLUGIN_GOOGLE_VALUE_YEAR,
		'plus_redirect_sign'             => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'plus_redirect_plus'             => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'plus_redirect_curl'             => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'plus_redirect_sign_url'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'plus_redirect_plus_url'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'plus_redirect_curl_fix'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'plus_redirect_curl_url'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'plus_redirect_curl_dir'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'plus_redirect_flush'            => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'plus_system_javascript'         => SZ_PLUGIN_GOOGLE_VALUE_NO,
	);

	// Impostazione valori di default che riguardano
	// il modulo collegato alle funzione di Google Analytics

	$settings_ga = array(
		'ga_uacode'                      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'ga_position'                    => SZ_PLUGIN_GOOGLE_GA_HEADER,
		'ga_enable_front'                => SZ_PLUGIN_GOOGLE_VALUE_YES,
		'ga_enable_admin'                => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'ga_enable_administrator'        => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'ga_enable_logged'               => SZ_PLUGIN_GOOGLE_VALUE_NO,
	);

	// Impostazione valori di default che riguardano
	// il modulo collegato alle funzione di Google Groups

	$settings_groups = array(
		'groups_widget'                  => SZ_PLUGIN_GOOGLE_VALUE_YES,
		'groups_shortcode'               => SZ_PLUGIN_GOOGLE_VALUE_YES,
		'groups_language'                => SZ_PLUGIN_GOOGLE_VALUE_LANG,
		'groups_name'                    => SZ_PLUGIN_GOOGLE_GROUPS_NAME,
		'groups_showsearch'              => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'groups_showtabs'                => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'groups_hidetitle'               => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'groups_hidesubject'             => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'groups_width'                   => SZ_PLUGIN_GOOGLE_GROUPS_WIDTH,
		'groups_height'                  => SZ_PLUGIN_GOOGLE_GROUPS_HEIGHT,
	);

	// Impostazione valori di default che riguardano
	// il modulo collegato alle funzione di Google Analytics

	$settings_translate = array(
		'translate_meta'                 => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'translate_mode'                 => 'I1',
		'translate_language'             => SZ_PLUGIN_GOOGLE_VALUE_LANG,
		'translate_to'                   => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'translate_widget'               => SZ_PLUGIN_GOOGLE_VALUE_YES,
		'translate_shortcode'            => SZ_PLUGIN_GOOGLE_VALUE_YES,
		'translate_automatic'            => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'translate_multiple'             => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'translate_analytics'            => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'translate_analytics_ua'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	);

	// Impostazione valori di default che riguardano
	// il modulo collegato alle funzione di Google Youtube

	$settings_youtube = array(
		'youtube_widget'                 => SZ_PLUGIN_GOOGLE_VALUE_YES,
		'youtube_shortcode'              => SZ_PLUGIN_GOOGLE_VALUE_YES,
		'youtube_responsive'             => SZ_PLUGIN_GOOGLE_VALUE_YES,
		'youtube_width'                  => SZ_PLUGIN_GOOGLE_YOUTUBE_WIDTH,
		'youtube_height'                 => SZ_PLUGIN_GOOGLE_YOUTUBE_HEIGHT,
		'youtube_margin_top'             => SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_TOP,
		'youtube_margin_right'           => SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_RIGHT,
		'youtube_margin_bottom'          => SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_BOTTOM,
		'youtube_margin_left'            => SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_LEFT,
		'youtube_margin_unit'            => SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_UNIT,
		'youtube_force_ssl'              => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'youtube_autoplay'               => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'youtube_loop'                   => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'youtube_fullscreen'             => SZ_PLUGIN_GOOGLE_VALUE_YES,
		'youtube_disablekeyboard'        => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'youtube_theme'                  => SZ_PLUGIN_GOOGLE_YOUTUBE_THEME,
		'youtube_disableiframe'          => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'youtube_analytics'              => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'youtube_delayed'                => SZ_PLUGIN_GOOGLE_VALUE_NO,
	);

	// Controllo formale delle opzioni e memorizzazione sul database
	// in base ad una prima installazione o update del plugin 

	sz_google_check_options('sz_google_options_base'     ,$settings_base); 
	sz_google_check_options('sz_google_options_plus'     ,$settings_plus); 
	sz_google_check_options('sz_google_options_ga'       ,$settings_ga);
	sz_google_check_options('sz_google_options_groups'   ,$settings_groups);
	sz_google_check_options('sz_google_options_translate',$settings_translate);
	sz_google_check_options('sz_google_options_youtube'  ,$settings_youtube);

	// Esecuzione flush rules per regole di rewrite personalizzate

	add_action('wp_loaded','sz_google_modules_flush_rules');
	
}

register_activation_hook( __FILE__,'sz_google_plugin_activate');

/* ************************************************************************** */
/* Funzione per esecuzione operazioni in fase di disattivazione plugin        */
/* ************************************************************************** */

function sz_google_plugin_deactivate() {
	sz_google_modules_flush_rules();
}

register_deactivation_hook( __FILE__,'sz_google_plugin_deactivate');

/* ************************************************************************** */
/* Inclusione delle funzioni generali per aggiunta di tutti i componenti      */
/* ************************************************************************** */

@require_once(dirname(__FILE__).'/includes/sz-google-functions.php');
@require_once(dirname(__FILE__).'/modules/sz-google-modules.php');
@require_once(dirname(__FILE__).'/widgets/sz-google-widgets.php');
@require_once(dirname(__FILE__).'/shortcodes/sz-google-shortcodes.php');

/* ************************************************************************** */
/* Inclusione delle funzioni da usare in admin                                */
/* ************************************************************************** */

if (is_admin()) {
	@include_once(dirname(__FILE__).'/admin/sz-google-admin.php');
}
