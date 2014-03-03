<?php
/**
 * Elenco delle funzioni PHP messe a disposizione dal plugin per  
 * essere usate direttamente nei temi o in altri plugin richiamando
 * direttamente la funzione con le opzioni di personalizzazione.
 *
 * @package SZGoogle
 */
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
/* GOOGLE+ BUTTONS funzioni PHP da richiamare direttamente                    */
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
/* GOOGLE+ EMBEDDED POST funzioni PHP da richiamare direttamente              */
/* ************************************************************************** */

function szgoogle_get_gplus_post($atts=array()) {
	if (function_exists('sz_google_module_plus_get_code_post')) {
		return sz_google_module_plus_get_code_post($atts);
	} else return false;
}

/* ************************************************************************** */
/* GOOGLE DRIVE funzioni PHP da richiamare direttamente                       */
/* ************************************************************************** */

function szgoogle_get_drive_savebutton($atts=array()) {
	if (function_exists('sz_google_module_drive_get_code_savebutton')) {
		return sz_google_module_drive_get_code_savebutton($atts);
	} else return false;
}

/**
 * Modulo Google Analytics e funzioni PHP disponibili
 * generazione codice di monitoraggio e reperimento informazioni
 */
function szgoogle_get_ga_ID() {
	if ($object = SZGoogleModule::$SZGoogleModuleAnalytics) {
		return $object->getGAId();
	} else return false; 
}

function szgoogle_get_ga_code($options=array()) {
	if ($object = SZGoogleModule::$SZGoogleModuleAnalytics) {
		return $object->moduleMonitorCodeCommon($options);
	} else return false; 
}

/* ************************************************************************** */
/* GOOGLE GROUPS funzioni PHP da richiamare direttamente                      */
/* ************************************************************************** */

function szgoogle_get_groups_code($atts=array()) {
	if (function_exists('sz_google_module_groups_get_code')) {
		return sz_google_module_groups_get_code($atts);
	} else return false;
}

/**
 * Modulo Google Hangouts e funzioni PHP disponibili
 * Avvio hangout tramite bottone messo a disposizione da google+
 */
function szgoogle_get_hangouts_code_start($options=array()) 
{
	if ($object = SZGoogleModule::$SZGoogleModuleHangouts) {
		return $object->getHangoutsStartCode($options);
	} else return false; 
}

/* ************************************************************************** */
/* GOOGLE PANORAMIO funzioni PHP da richiamare direttamente                   */
/* ************************************************************************** */

function szgoogle_get_panoramio_code($atts=array()) {
	if (function_exists('sz_google_module_panoramio_get_code')) {
		return sz_google_module_panoramio_get_code($atts);
	} else return false;
}

/* ************************************************************************** */
/* GOOGLE TRANSLATE funzioni PHP da richiamare direttamente                   */
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
/* GOOGLE YOUTUBE funzioni PHP da richiamare direttamente                     */
/* ************************************************************************** */

function szgoogle_get_youtube_code_video($atts=array()) {
	if (function_exists('sz_google_module_youtube_get_code_video()')) {
		return sz_google_module_youtube_get_code_video($atts);
	} else return false;
}

function szgoogle_get_youtube_code_playlist($atts=array()) {
	if (function_exists('sz_google_module_youtube_get_code_playlist()')) {
		return sz_google_module_youtube_get_code_playlist($atts);
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
