<?php

/**
 * Definizione delle funzioni PHP che possono essere richiamate
 * direttamente da un tema o da un plugin per le personalizzazioni
 *
 * @package SZGoogle
 * @subpackage SZGoogleFunctions
 */

if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

if (!function_exists('szgoogle_gplus_get_object')) {
	function szgoogle_gplus_get_object() { 
		if (!SZGoogleModule::getObject('SZGoogleModulePlus')) return false;
			else return SZGoogleModule::getObject('SZGoogleModulePlus');
	}
}

if (!function_exists('szgoogle_gplus_get_badge_profile')) {
	function szgoogle_gplus_get_badge_profile($options=array()) {
		if (!$object = szgoogle_gplus_get_object()) return false;
			else return $object->getPlusProfileCode($options);
	}
}

if (!function_exists('szgoogle_gplus_get_badge_page')) {
	function szgoogle_gplus_get_badge_page($options=array()) {
		if (!$object = szgoogle_gplus_get_object()) return false;
			else return $object->getPlusPageCode($options);
	}
}

if (!function_exists('szgoogle_gplus_get_badge_community')) {
	function szgoogle_gplus_get_badge_community($options=array()) {
		if (!$object = szgoogle_gplus_get_object()) return false;
			else return $object->getPlusCommunityCode($options);
	}
}

if (!function_exists('szgoogle_gplus_get_badge_followers')) {
	function szgoogle_gplus_get_badge_followers($options=array()) {
		if (!$object = szgoogle_gplus_get_object()) return false;
			else return $object->getPlusFollowersCode($options);
	}
}

if (!function_exists('szgoogle_gplus_get_button_one')) {
	function szgoogle_gplus_get_button_one($options=array()) {
		if (!$object = szgoogle_gplus_get_object()) return false;
			else return $object->getPlusPlusoneCode($options);
	}
}

if (!function_exists('szgoogle_gplus_get_button_share')) {
	function szgoogle_gplus_get_button_share($options=array()) {
		if (!$object = szgoogle_gplus_get_object()) return false;
			else return $object->getPlusShareCode($options);
	}
}

if (!function_exists('szgoogle_gplus_get_button_follow')) {
	function szgoogle_gplus_get_button_follow($options=array()) {
		if (!$object = szgoogle_gplus_get_object()) return false;
			else return $object->getPlusFollowCode($options);
	}
}

if (!function_exists('szgoogle_gplus_get_comments')) {
	function szgoogle_gplus_get_comments($options=array()) {
		if (!$object = szgoogle_gplus_get_object()) return false;
			else return $object->getPlusCommentsCode($options);
	}
}

if (!function_exists('szgoogle_gplus_get_contact_page')) {
	function szgoogle_gplus_get_contact_page($userid=null) {
		if (!$object = szgoogle_gplus_get_object()) return false;
			else return $object->getPlusContactPage($userid);
	}
}

if (!function_exists('szgoogle_gplus_get_contact_community')) {
	function szgoogle_gplus_get_contact_community($userid=null) {
		if (!$object = szgoogle_gplus_get_object()) return false;
			else return $object->getPlusContactCommunity($userid);
	}
}

if (!function_exists('szgoogle_gplus_get_contact_bestpost')) {
	function szgoogle_gplus_get_contact_bestpost($userid=null) {
		if (!$object = szgoogle_gplus_get_object()) return false;
			else return $object->getPlusContactBestpost($userid);
	}
}

if (!function_exists('szgoogle_gplus_get_post')) {
	function szgoogle_gplus_get_post($options=array()) {
		if (!$object = szgoogle_gplus_get_object()) return false;
			else return $object->getPlusPostCode($options);
	}
}