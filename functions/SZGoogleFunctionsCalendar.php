<?php
/**
 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

/**
 * Calcolo codice HTML per il widget di google calendar
 * da inserire in embed in una pagina web di wordpress
 *
 * @param  array $options
 * @return string
 */
if (!function_exists('szgoogle_calendar_get_widget')) {
	function szgoogle_calendar_get_widget($options=array()) { 
		$object = new SZGoogleActionCalendar();
		return $object->getHTMLCode($options);
	}
}