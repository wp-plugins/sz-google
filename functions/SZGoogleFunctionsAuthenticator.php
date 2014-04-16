<?php
/**
 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

/**
 * Funzione PHP per reperire il codice segreto legato al 
 * profilo wordpress che permette la sincronizzazione
 *
 * @param  array $user
 * @return string
 */
if (!function_exists('szgoogle_authenticator_get_secret')) {
	function szgoogle_authenticator_get_secret($user) { 
		return trim(get_user_option('sz_google_authenticator_secret',$user));
	}
}

/**
 * Controllo se è stato attivato il filedi emergenza
 * per la disattivazione temporaneo di authenticator
 *
 * @param  array $user
 * @return string
 */
if (!function_exists('szgoogle_authenticator_check_emergency')) {
	function szgoogle_authenticator_check_emergency() {
		if (!$object = SZGoogleModule::getObject('SZGoogleModuleAuthenticator')) return false;
			else return $object->checkEmergencyFile();
	}
}

/**
 * Funzione per controllare se il codice a tempo è
 * valido in questo momento rispetto al nome utente
 *
 * @param  array $user
 * @param  array $code
 * @param  array $discrepancy
 * @return string
 */
if (!function_exists('szgoogle_authenticator_verify_code')) {
	function szgoogle_authenticator_verify_code($user,$code,$discrepancy=1) {
		$object = new SZGoogleActionAuthenticatorLogin();
		return $object->checkAuthenticatorCode(szgoogle_authenticator_get_secret($user),$code,$discrepancy);
	}
}

/**
 * Creazione automatica di una stringa contenente
 * un codice segreto di sincronizzazione con un device
 *
 * @return string
 */
if (!function_exists('szgoogle_authenticator_create_secret')) {
	function szgoogle_authenticator_create_secret() { 
		$object = new SZGoogleActionAuthenticatorProfile();
		return $object->getAuthenticatorCreateSecret();
	}
}

/**
 * Calcolo codice HTML da aggiungere ad un form di login
 * con i nuovi campi che riguardano il codice a tempo
 *
 * @return string
 */
if (!function_exists('szgoogle_authenticator_get_login_field')) {
	function szgoogle_authenticator_get_login_field() {
		$object = new SZGoogleActionAuthenticatorLogin();
		return $object->addAuthenticatorLoginForm();
	}
}
