<?php
/*
Plugin Name: SZ - Google
Plugin URI: http://startbyzero.com/webmaster/wordpress-plugin/sz-google/
Description: Plugin to integrate <a href="http://google.com" target="_blank">Google's</a> products in <a href="http://wordpress.org" target="_blank">WordPress</a> with particular attention to the widgets provided by the social network Google+. Before using the plug-in <em>sz-google</em> pay attention to the options to be specified in the admin panel and enter all the parameters necessary for the proper functioning of the plugin. If you want to know the latest news and releases from the plug-in <a href="http://wordpress.org/plugins/sz-google/">SZ-Google for WordPress</a> follow the official page of <a href="https://plus.google.com/115876177980154798858/" target="_blank">startbyzero</a> present in the social network Google+ or subscribe to our community <a href="https://plus.google.com/communities/109254048492234113886" target="_blank">WordPress Italy+</a> always present on Google+.
Author: Massimo Della Rovere
Version: 0.4
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
define('SZ_PLUGIN_GOOGLE_WIDGET_SIZE_PORTRAIT','180');
define('SZ_PLUGIN_GOOGLE_WIDGET_SIZE_LANDSCAPE','275');

/* ************************************************************************** */
/* Definizione delle costanti da usare nel plugin G+                          */
/* ************************************************************************** */

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
		'plus'      => '1',
		'analytics' => '0',
	);

	// Impostazione valori di default che riguardano  
	// il modulo collegato alle funzione di Google PLus 

	$settings_plus = array(
		'plus_page'                      => '',
		'plus_profile'                   => '',
		'plus_community'                 => '',
		'plus_language'                  => '99',
		'plus_widget_pr_enable'          => '1',
		'plus_widget_pa_enable'          => '1',		
		'plus_widget_co_enable'          => '1',		
		'plus_widget_size_portrait'      => SZ_PLUGIN_GOOGLE_WIDGET_SIZE_PORTRAIT,
		'plus_widget_size_landscape'     => SZ_PLUGIN_GOOGLE_WIDGET_SIZE_LANDSCAPE,
		'plus_shortcode_pr_enable'       => '1',
		'plus_shortcode_pa_enable'       => '1',		
		'plus_shortcode_co_enable'       => '1',		
		'plus_shortcode_size_portrait'   => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_SIZE_PORTRAIT,
		'plus_shortcode_size_landscape'  => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_SIZE_LANDSCAPE,
		'plus_button_enable_plusone'     => '1',
		'plus_button_enable_sharing'     => '1',
		'plus_button_enable_follow'      => '1',
		'plus_comments_gp_enable'        => '0',
		'plus_comments_wp_enable'        => '0',
		'plus_comments_ac_enable'        => '0',
		'plus_comments_aw_enable'        => '0',
		'plus_comments_wd_enable'        => '0',
		'plus_comments_sh_enable'        => '0',
		'plus_comments_dt_enable'        => '0',
		'plus_comments_dt_day'           => sprintf('%02d',date('d')),
		'plus_comments_dt_month'         => sprintf('%02d',date('m')),
		'plus_comments_dt_year'          => sprintf('%04d',date('Y')),
		'plus_redirect_sign'             => '0',
		'plus_redirect_plus'             => '0',
		'plus_redirect_curl'             => '0',
		'plus_redirect_sign_url'         => '',
		'plus_redirect_plus_url'         => '',
		'plus_redirect_curl_fix'         => '',
		'plus_redirect_curl_url'         => '',
		'plus_redirect_curl_dir'         => '',
		'plus_redirect_flush'            => '0',
		'plus_system_javascript'         => '0',
	);

	// Impostazione valori di default che riguardano  
	// il modulo collegato alle funzione di Google Analytics 

	$settings_ga = array(
		'ga_uacode'                      => '',
		'ga_position'                    => 'H',
		'ga_enable_front'                => '1',
		'ga_enable_admin'                => '0',
		'ga_enable_administrator'        => '0',
		'ga_enable_logged'               => '0',
	);

	// Controllo formale delle opzioni e memorizzazione sul database
	// in base ad una prima installazione o update del plugin 

	sz_google_check_options('sz_google_options_base',$settings_base); 
	sz_google_check_options('sz_google_options_plus',$settings_plus); 
	sz_google_check_options('sz_google_options_ga'  ,$settings_ga); 

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

@require_once(dirname(__FILE__).'/functions/sz-google-functions.php');
@require_once(dirname(__FILE__).'/modules/sz-google-modules.php');
@require_once(dirname(__FILE__).'/widgets/sz-google-widgets.php');
@require_once(dirname(__FILE__).'/shortcodes/sz-google-shortcodes.php');

/* ************************************************************************** */
/* Inclusione delle funzioni da usare in admin                                */
/* ************************************************************************** */

if (is_admin()) {
	@include_once(dirname(__FILE__).'/admin/sz-google-admin.php');
}
