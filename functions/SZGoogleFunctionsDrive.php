<?php
/**
 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

/**
 * Calcolo codice HTML per il widget di google drive che
 * permette di inserire documenti embed nella pagina web
 *
 * @param  array $options
 * @return string
 */
if (!function_exists('szgoogle_drive_get_embed')) {
	function szgoogle_drive_get_embed($options=array()) {
		$object = new SZGoogleActionDriveEmbed();
		return $object->getHTMLCode($options);
	}
}

/**
 * Calcolo codice HTML per il widget di google drive che
 * permette la visualizzazione di qualsiasi documento
 *
 * @param  array $options
 * @return string
 */
if (!function_exists('szgoogle_drive_get_viewer')) {
	function szgoogle_drive_get_viewer($options=array()) {
		$object = new SZGoogleActionDriveViewer();
		return $object->getHTMLCode($options);
	}
}

/**
 * Calcolo codice HTML per il widget di google drive che
 * permette la visualizzazione del bottone di salvataggio
 *
 * @param  array $options
 * @return string
 */
if (!function_exists('szgoogle_drive_get_savebutton')) {
	function szgoogle_drive_get_savebutton($options=array()) {
		$object = new SZGoogleActionDriveSave();
		return $object->getHTMLCode($options);
	}
}