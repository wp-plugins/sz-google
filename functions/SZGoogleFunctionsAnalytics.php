<?php
/**
 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

/**
 * Funzione PHP per calcolare il codice di monitoraggio da aggiungere
 * alla pagina web ed ottenere le statistiche di google analytics
 *
 * @param  array $options
 * @return string
 */
if (!function_exists('szgoogle_analytics_get_code')) {
	function szgoogle_analytics_get_code($options=array()) { 
		$object = new SZGoogleActionAnalytics();
		return $object->getMonitorCode($options);
	}
}

/**
 * Funzione PHP per calcolare il codice ID di google analytics che
 * può essere utilizzato per la creazione di codice personalizzato
 *
 * @return string
 */
if (!function_exists('szgoogle_analytics_get_ID')) {
	function szgoogle_analytics_get_ID() { 
		if (!$object = SZGoogleModule::getObject('SZGoogleModuleAnalytics')) return false;
			else return $object->getGAId();
	}
}