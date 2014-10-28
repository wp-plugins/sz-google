<?php

/**
 * Definizione delle funzioni PHP che possono essere richiamate
 * direttamente da un tema o da un plugin per le personalizzazioni
 *
 * @package SZGoogle
 * @subpackage SZGoogleFunctions
 */

if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Funzione PHP per calcolare il codice di monitoraggio da aggiungere
// alla pagina web ed ottenere le statistiche di google analytics

if (!function_exists('szgoogle_analytics_get_code')) {
	function szgoogle_analytics_get_code($options=array()) { 
		if (!$object = new SZGoogleActionAnalytics()) return false;
			else return $object->getHTMLCode($options);
	}
}

// Funzione PHP per calcolare il codice ID di google analytics che
// può essere utilizzato per la creazione di codice personalizzato

if (!function_exists('szgoogle_analytics_get_ID')) {
	function szgoogle_analytics_get_ID() { 
		if (!$object = SZGoogleModule::getObject('SZGoogleModuleAnalytics')) return false;
			else return $object->getGAId();
	}
}