<?php

/**
 * Definizione delle funzioni PHP che possono essere richiamate
 * direttamente da un tema o da un plugin per le personalizzazioni
 *
 * @package SZGoogle
 * @subpackage SZGoogleFunctions
 */

if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

if (!function_exists('szgoogle_translate_get_object')) {
	function szgoogle_translate_get_object() { 
		if (!SZGoogleModule::getObject('SZGoogleModuleTranslate')) return false;
			else return SZGoogleModule::getObject('SZGoogleModuleTranslate');
	}
}

if (!function_exists('szgoogle_translate_get_code')) {
	function szgoogle_translate_get_code($options=array()) {
		if (!$object = szgoogle_translate_get_object()) return false;
			else return $object->getTranslateCode($options);
	}
}

if (!function_exists('szgoogle_translate_get_meta')) {
	function szgoogle_translate_get_meta() {
		if (!$object = szgoogle_translate_get_object()) return false;
			else return $object->getTranslateMeta();
	}
}

if (!function_exists('szgoogle_translate_get_meta_ID')) {
	function szgoogle_translate_get_meta_ID() {
		if (!$object = szgoogle_translate_get_object()) return false;
			else return $object->getTranslateMetaID();
	}
}