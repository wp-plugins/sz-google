<?php
/**
 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Funzione PHP per esecuzione EMBED Video con passaggio di parametri
// tramite array associativo e condivisione codice con shortcode

if (!function_exists('szgoogle_youtube_get_code_video')) {
	function szgoogle_youtube_get_code_video($options=array()) {
		if (!$object = new SZGoogleActionYoutubeVideo()) return false;
			else return $object->getHTMLCode($options);
	}
}

// Funzione PHP per esecuzione EMBED Playlist con passaggio di parametri
// tramite array associativo e condivisione codice con shortcode

if (!function_exists('szgoogle_youtube_get_code_playlist')) {
	function szgoogle_youtube_get_code_playlist($options=array()) {
		if (!$object = new SZGoogleActionYoutubePlaylist()) return false;
			else return $object->getHTMLCode($options);
	}
}

// Funzione PHP per esecuzione EMBED Badge con passaggio di parametri
// tramite array associativo e condivisione codice con shortcode

if (!function_exists('szgoogle_youtube_get_code_badge')) {
	function szgoogle_youtube_get_code_badge($options=array()) {
		if (!$object = new SZGoogleActionYoutubeBadge()) return false;
			else return $object->getHTMLCode($options);
	}
}





if (!function_exists('szgoogle_youtube_get_object')) {
	function szgoogle_youtube_get_object() { 
		if (!SZGoogleModule::getObject('SZGoogleModuleYoutube')) return false;
			else return SZGoogleModule::getObject('SZGoogleModuleYoutube');
	}
}

if (!function_exists('sz_google_module_youtube_check_channel')) {
	function sz_google_module_youtube_check_channel($options=array()) {
		if (!$object = szgoogle_youtube_get_object()) return false;
			else return $object->youtubeCheckChannel($options);
	}
}


if (!function_exists('szgoogle_youtube_get_code_button')) {
	function szgoogle_youtube_get_code_button($options=array()) {
		if (!$object = szgoogle_youtube_get_object()) return false;
			else return $object->getYoutubeButtonCode($options);
	}
}

if (!function_exists('szgoogle_youtube_get_code_link')) {
	function szgoogle_youtube_get_code_link($options=array()) {
		if (!$object = szgoogle_youtube_get_object()) return false;
			else return $object->getYoutubeLinkCode($options);
	}
}

