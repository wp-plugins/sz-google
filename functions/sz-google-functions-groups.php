<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_FUNCTIONS') or !SZ_PLUGIN_GOOGLE_FUNCTIONS) die();

/* ************************************************************************** */
/* Funzioni per elaborazione codice HTML di G+ BADGE                          */
/* ************************************************************************** */

function szgoogle_get_groups_code($atts) {
	if (function_exists('sz_google_modules_groups_get_code')) {
		return sz_google_modules_groups_get_code($atts);
	}
}
