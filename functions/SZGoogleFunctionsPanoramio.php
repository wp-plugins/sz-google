<?php
/**
 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

/**
 * Inserimento bottone per avvio hangout con possibilità
 * di scegliere un'applicazione personalizzata da avviare
 *
 * @param  array $options
 * @return string
 */
if (!function_exists('szgoogle_panoramio_get_code')) {
	function szgoogle_panoramio_get_code($options=array()) {
		$object = new SZGoogleActionPanoramio();
		return $object->getHTMLCode($options);
	}
}