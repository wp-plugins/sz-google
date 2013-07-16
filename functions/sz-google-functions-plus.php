<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_FUNCTIONS') or !SZ_PLUGIN_GOOGLE_FUNCTIONS) die();

/* ************************************************************************** */
/* Funzioni per elaborazione codice HTML di G+ BADGE                          */
/* ************************************************************************** */

function szgoogle_get_gplus_badge_profile($atts) {
	if (function_exists('sz_google_shortcodes_plus_profile')) {
		return sz_google_shortcodes_plus_profile($atts);
	}
}

function szgoogle_get_gplus_badge_page($atts) {
	if (function_exists('sz_google_shortcodes_plus_page')) {
		return sz_google_shortcodes_plus_page($atts);
	}
}

function szgoogle_get_gplus_badge_community($atts) {
	if (function_exists('sz_google_shortcodes_plus_community')) {
		return sz_google_shortcodes_plus_community($atts);
	}
}

/* ************************************************************************** */
/* Funzioni per elaborazione codice HTML di G+ BUTTON                         */
/* ************************************************************************** */

function szgoogle_get_gplus_button_one($atts) {
	if (function_exists('sz_google_shortcodes_plus_plusone')) {
		return sz_google_shortcodes_plus_plusone($atts);
	}
}

function szgoogle_get_gplus_button_share($atts) {
	if (function_exists('sz_google_shortcodes_plus_sharing')) {
		return sz_google_shortcodes_plus_sharing($atts);
	}
}

function szgoogle_get_gplus_button_follow($atts) {
	if (function_exists('sz_google_shortcodes_plus_follow')) {
		return sz_google_shortcodes_plus_follow($atts);
	}
}

/* ************************************************************************** */
/* Funzioni per elaborazione codice HTML di G+ COMMENTS                       */
/* ************************************************************************** */

function szgoogle_get_gplus_comments($atts) {
	if (function_exists('sz_google_shortcodes_plus_comments')) {
		return sz_google_shortcodes_plus_comments($atts);
	}
}
