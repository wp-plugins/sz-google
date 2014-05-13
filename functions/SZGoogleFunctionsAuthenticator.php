<?php
/**
 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Funzione PHP per reperire il codice segreto legato al 
// profilo wordpress che permette la sincronizzazione

if (!function_exists('szgoogle_authenticator_get_secret')) {
	function szgoogle_authenticator_get_secret($user) { 
		return trim(get_user_option('sz_google_authenticator_secret',$user));
	}
}

// Funzione PHP per controllo se è stato attivato il file di
// emergenza per la disattivazione temporaneo di authenticator

if (!function_exists('szgoogle_authenticator_check_emergency')) {
	function szgoogle_authenticator_check_emergency() {
		if (!$object = SZGoogleModule::getObject('SZGoogleModuleAuthenticator')) return false;
			else return $object->checkEmergencyFile();
	}
}

// Funzione PHP per controllare se il codice a tempo è
// valido in questo momento rispetto al nome utente

if (!function_exists('szgoogle_authenticator_verify_code')) {
	function szgoogle_authenticator_verify_code($user,$code,$discrepancy=1) {
		if (!$object = new SZGoogleActionAuthenticatorLogin()) return false;
			else return $object->checkAuthenticatorCode(szgoogle_authenticator_get_secret($user),$code,$discrepancy);
	}
}

// Funzione PHP per creazione automatica di una stringa contenente
// un codice segreto di sincronizzazione con un device

if (!function_exists('szgoogle_authenticator_create_secret')) {
	function szgoogle_authenticator_create_secret() { 
		if (!$object = new SZGoogleActionAuthenticatorProfile()) return false;
			else return $object->getAuthenticatorCreateSecret();
	}
}

// Funzione PHP per calcolo codice HTML da aggiungere ad un form
// do login con i nuovi campi che riguardano il codice a tempo

if (!function_exists('szgoogle_authenticator_get_login_field')) {
	function szgoogle_authenticator_get_login_field() {
		if (!$object = new SZGoogleActionAuthenticatorLogin()) return false;
			else return $object->addAuthenticatorLoginForm();
	}
}