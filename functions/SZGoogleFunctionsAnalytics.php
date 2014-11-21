<?php

/**
 * Definition of the PHP functions that can be called directly 
 * by a theme or a plugin for customizations without use shortcode
 *
 * @package SZGoogle
 * @subpackage SZGoogleFunctions
 * @author Massimo Della Rovere
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Definition of the call wrapper functions for modules
// With these features, you can customize themes and other plugins

if (!function_exists('szgoogle_analytics_get_code')) {
	function szgoogle_analytics_get_code($options=array()) { 
		if (!$object = new SZGoogleActionAnalytics()) return false;
			else return $object->getHTMLCode($options);
	}
}

if (!function_exists('szgoogle_analytics_get_ID')) {
	function szgoogle_analytics_get_ID() { 
		if (!$object = SZGoogleModule::getObject('SZGoogleModuleAnalytics')) return false;
			else return $object->getGAId();
	}
}