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
// google calendar da inserire in embed in una pagina web

if (!function_exists('szgoogle_calendar_get_widget')) {
	function szgoogle_calendar_get_widget($options=array()) { 
		if (!$object = new SZGoogleActionCalendar()) return false;
			else return $object->getHTMLCode($options);
	}
}