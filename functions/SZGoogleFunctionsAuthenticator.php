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

if (!function_exists('szgoogle_authenticator_get_secret')) {
	function szgoogle_authenticator_get_secret($user) { 
		return trim(get_user_option('sz_google_authenticator_secret',$user));
	}
}

if (!function_exists('szgoogle_authenticator_check_emergency')) {
	function szgoogle_authenticator_check_emergency() {
		if (!$object = SZGoogleModule::getObject('SZGoogleModuleAuthenticator')) return false;
			else return $object->checkEmergencyFile();
	}
}

if (!function_exists('szgoogle_authenticator_verify_code')) {
	function szgoogle_authenticator_verify_code($user,$code,$discrepancy=1) {
		if (!$object = new SZGoogleActionAuthenticatorLogin()) return false;
			else return $object->checkAuthenticatorCode(szgoogle_authenticator_get_secret($user),$code,$discrepancy);
	}
}

if (!function_exists('szgoogle_authenticator_create_secret')) {
	function szgoogle_authenticator_create_secret() { 
		if (!$object = new SZGoogleActionAuthenticatorProfile()) return false;
			else return $object->getAuthenticatorCreateSecret();
	}
}

if (!function_exists('szgoogle_authenticator_get_login_field')) {
	function szgoogle_authenticator_get_login_field() {
		if (!$object = new SZGoogleActionAuthenticatorLogin()) return false;
			else return $object->addAuthenticatorLoginForm();
	}
}