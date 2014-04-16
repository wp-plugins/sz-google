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
if (!function_exists('szgoogle_hangouts_get_code_start')) {
	function szgoogle_hangouts_get_code_start($options=array()) {
		$object = new SZGoogleActionHangoutsStart();
		return $object->getHTMLCode($options);
	}
}