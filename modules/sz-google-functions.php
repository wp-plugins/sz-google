<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

/* ************************************************************************** */
/* Definizione costanti che devo essere comuni a tutti i file module          */
/* ************************************************************************** */

define('SZ_PLUGIN_GOOGLE_FUNCTIONS',true);
define('SZ_PLUGIN_GOOGLE_FUNCTIONS_BASENAME',basename(__FILE__));

/* ************************************************************************** */
/* GOOGLE+ BADGES funzioni PHP da richiamare direttamente                     */
/* ************************************************************************** */

function szgoogle_get_gplus_badge_profile($atts=array()) {
	if (function_exists('sz_google_module_plus_get_code_profile')) {
		return sz_google_module_plus_get_code_profile($atts);
	} else return false;
}

function szgoogle_get_gplus_badge_page($atts=array()) {
	if (function_exists('sz_google_module_plus_get_code_page')) {
		return sz_google_module_plus_get_code_page($atts);
	} else return false;
}

function szgoogle_get_gplus_badge_community($atts=array()) {
	if (function_exists('sz_google_module_plus_get_code_community')) {
		return sz_google_module_plus_get_code_community($atts);
	} else return false;
}

function szgoogle_get_gplus_badge_followers($atts=array()) {
	if (function_exists('sz_google_module_plus_get_code_followers')) {
		return sz_google_module_plus_get_code_followers($atts);
	} else return false;
}

/* ************************************************************************** */
/* Funzioni per elaborazione codice HTML di G+ BUTTON                         */
/* ************************************************************************** */

function szgoogle_get_gplus_button_one($atts=array()) {
	if (function_exists('sz_google_module_plus_get_code_plusone')) {
		return sz_google_module_plus_get_code_plusone($atts);
	} else return false;
}

function szgoogle_get_gplus_button_share($atts=array()) {
	if (function_exists('sz_google_module_plus_get_code_sharing')) {
		return sz_google_module_plus_get_code_sharing($atts);
	} else return false;
}

function szgoogle_get_gplus_button_follow($atts=array()) {
	if (function_exists('sz_google_module_plus_get_code_follow')) {
		return sz_google_module_plus_get_code_follow($atts);
	} else return false;
}

/* ************************************************************************** */
/* GOOGLE+ COMMENTS funzioni PHP da richiamare direttamente                   */
/* ************************************************************************** */

function szgoogle_get_gplus_comments($atts=array()) {
	if (function_exists('sz_google_module_plus_get_code_comments')) {
		return sz_google_module_plus_get_code_comments($atts);
	} else return false;
}

/* ************************************************************************** */
/* Funzioni per elaborazione codice HTML di G+ EMBEDDED POST                  */
/* ************************************************************************** */

function szgoogle_get_gplus_post($atts=array()) {
	if (function_exists('sz_google_module_plus_get_code_post')) {
		return sz_google_module_plus_get_code_post($atts);
	} else return false;
}

/* ************************************************************************** */
/* Funzioni per elaborazione codice HTML di GOOGLE DRIVE                     */
/* ************************************************************************** */

function szgoogle_get_drive_savebutton($atts=array()) {
	if (function_exists('sz_google_module_drive_get_code_savebutton')) {
		return sz_google_module_drive_get_code_savebutton($atts);
	} else return false;
}

/* ************************************************************************** */
/* Funzioni per elaborazione codice HTML di GOOGLE ANALYTICS                  */
/* ************************************************************************** */

function szgoogle_get_ga_ID() {
	if (function_exists('sz_google_module_analytics_get_ID')) {
		return sz_google_module_analytics_get_ID();
	} else return false;
}

function szgoogle_get_ga_code() {
	if (function_exists('sz_google_module_analytics_get_code')) {
		return sz_google_module_analytics_get_code();
	} else return false;
}

/* ************************************************************************** */
/* Funzioni per elaborazione codice HTML di GOOGLE GROUPS                     */
/* ************************************************************************** */

function szgoogle_get_groups_code($atts=array()) {
	if (function_exists('sz_google_module_groups_get_code')) {
		return sz_google_module_groups_get_code($atts);
	} else return false;
}






/* ************************************************************************** */
/* Funzioni per elaborazione codice HTML di GOOGLE TRANSLATE                  */
/* ************************************************************************** */

function szgoogle_get_translate_meta_ID() {
	if (function_exists('sz_google_module_translate_get_meta_ID()')) {
		return sz_google_module_translate_get_meta_ID();
	} else return false;
}

function szgoogle_get_translate_meta() {
	if (function_exists('sz_google_module_translate_get_meta()')) {
		return sz_google_module_translate_get_meta();
	} else return false;
}

function szgoogle_get_translate_code($atts=array()) {
	if (function_exists('sz_google_module_translate_get_code()')) {
		return sz_google_module_translate_get_code($atts);
	} else return false;
}

/* ************************************************************************** */
/* Funzioni per elaborazione codice HTML di GOOGLE YOUTUBE                    */
/* ************************************************************************** */

function szgoogle_get_youtube_code_video($atts=array()) {
	if (function_exists('sz_google_module_youtube_get_code_video()')) {
		return sz_google_module_youtube_get_code_video($atts);
	} else return false;
}

function szgoogle_get_youtube_code_badge($atts=array()) {
	if (function_exists('sz_google_module_youtube_get_code_badge()')) {
		return sz_google_module_youtube_get_code_badge($atts);
	} else return false;
}

function szgoogle_get_youtube_code_button($atts=array()) {
	if (function_exists('sz_google_module_youtube_get_code_button()')) {
		return sz_google_module_youtube_get_code_button($atts);
	} else return false;
}

function szgoogle_get_youtube_code_link($atts=array()) {
	if (function_exists('sz_google_module_youtube_get_code_link()')) {
		return sz_google_module_youtube_get_code_link($atts);
	} else return false;
}
