<?php

/**
 * Definizione delle funzioni PHP che possono essere richiamate
 * direttamente da un tema o da un plugin per le personalizzazioni
 *
 * @package SZGoogle
 * @subpackage SZGoogleFunctions
 */

if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Funzione PHP per calcolo codice HTML per il widget di
// google groups che permette di inserire un forum embed

if (!function_exists('szgoogle_groups_get_code')) {
	function szgoogle_groups_get_code($options=array()) {
		if (!$object = new SZGoogleActionGroups()) return false;
			else return $object->getHTMLCode($options);
	}
}