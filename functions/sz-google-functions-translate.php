<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_FUNCTIONS') or !SZ_PLUGIN_GOOGLE_FUNCTIONS) die();

/* ************************************************************************** */
/* Funzioni per elaborazione codice HTML di GOOGLE TRANSLATE                  */
/* ************************************************************************** */

function szgoogle_get_translate_meta_ID() {
	if (function_exists('sz_google_modules_translate_get_meta_ID()')) {
		return sz_google_modules_translate_get_meta_ID();
	} else return false;
}

function szgoogle_get_translate_meta() {
	if (function_exists('sz_google_modules_translate_get_meta()')) {
		return sz_google_modules_translate_get_meta();
	} else return false;
}

function szgoogle_get_translate_code() {
	if (function_exists('sz_google_modules_translate_get_code()')) {
		return sz_google_modules_translate_get_code();
	} else return false;
}
