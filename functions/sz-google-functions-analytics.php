<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_FUNCTIONS') or !SZ_PLUGIN_GOOGLE_FUNCTIONS) die();

/* ************************************************************************** */
/* Funzioni per elaborazione codice HTML di G+ BADGE                          */
/* ************************************************************************** */

function szgoogle_get_ga_ID() {
	if (function_exists('sz_google_modules_analytics_get_ID')) {
		return sz_google_modules_analytics_get_ID();
	} else return false;
}

function szgoogle_get_ga_code() {
	if (function_exists('sz_google_modules_analytics_get_code')) {
		return sz_google_modules_analytics_get_code();
	} else return false;
}
