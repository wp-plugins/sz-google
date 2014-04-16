<?php
/**
 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

/**
 * Calcolo codice HTML per il widget di google groups che
 * permette di inserire un forum embed nella pagina web
 *
 * @param  array $options
 * @return string
 */
if (!function_exists('szgoogle_groups_get_code')) {
	function szgoogle_groups_get_code($options=array()) {
		$object = new SZGoogleActionGroups();
		return $object->getHTMLCode($options);
	}
}