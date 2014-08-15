<?php
/**
 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Funzione PHP per calcolo codice HTML per il widget di google drive
// che permette di inserire documenti embed nella pagina web

if (!function_exists('szgoogle_drive_get_embed')) {
	function szgoogle_drive_get_embed($options=array()) {
		if (!$object = new SZGoogleActionDriveEmbed()) return false;
			else return $object->getHTMLCode($options);
	}
}

// Funzione PHP per calcolo codice HTML per il widget di 
// google drive che permette la visualizzazione di documenti

if (!function_exists('szgoogle_drive_get_viewer')) {
	function szgoogle_drive_get_viewer($options=array()) {
		if (!$object = new SZGoogleActionDriveViewer()) return false;
			else return $object->getHTMLCode($options);
	}
}

// Funzione PHP per calcolo codice HTML per il widget di google drive
// che permette la visualizzazione del bottone di salvataggio

if (!function_exists('szgoogle_drive_get_savebutton')) {
	function szgoogle_drive_get_savebutton($options=array()) {
		if (!$object = new SZGoogleActionDriveSave()) return false;
			else return $object->getHTMLCode($options);
	}
}