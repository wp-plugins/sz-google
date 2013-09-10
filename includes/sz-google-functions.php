<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

/* ************************************************************************** */
/* Definizione costanti che devo essere comuni a tutti i file modules         */
/* ************************************************************************** */

define('SZ_PLUGIN_GOOGLE_FUNCTIONS',true);
define('SZ_PLUGIN_GOOGLE_FUNCTIONS_BASENAME',basename(__FILE__));

/* ************************************************************************** */
/* Funzione per i controllo dei parametri in maniera singola e default        */
/* ************************************************************************** */

function sz_google_check_options($name,$value) 
{
	// Controllo se valori di default per le opzioni 
	// generali sono contenuti dentro un array valido

	if (is_array($value)) { 

		// Controllo se esistono le opzioni richieste, in caso
		// affermativo passo al controllo di ogni singola opzione 

		if ($options = get_option($name)) 
		{
			if (!is_array($options)) $options=array(); 

			foreach ($value as $key=>$item) {
				if (!isset($options[$key])) $options[$key]=$item;
			}

			update_option($name,$options);

		// Se le opzioni non esistono in quanto il plugin potrebbe
		// essere la prima volta che viene installato -> aggiungo array 

		} else {
			add_option($name,$value);
		}
	}
}

/* ************************************************************************** */
/* Funzione per array contenente i linguaggi supportati da google             */
/* ************************************************************************** */

function sz_google_get_languages() 
{
	$languages = array(
		'99'     => ' '.__('same language theme','szgoogleadmin'),
		'af'     => ucfirst(__('afrikaans','szgoogleadmin')),
		'am'     => ucfirst(__('amharic','szgoogleadmin')),
		'ar'     => ucfirst(__('arabic','szgoogleadmin')),
		'eu'     => ucfirst(__('basque','szgoogleadmin')),
		'bn'     => ucfirst(__('bengali','szgoogleadmin')),
		'bg'     => ucfirst(__('bulgarian','szgoogleadmin')),
		'ca'     => ucfirst(__('catalan','szgoogleadmin')),
		'zh-HK'  => ucfirst(__('chinese (Hong Kong)','szgoogleadmin')),
		'zh-CN'  => ucfirst(__('chinese (Simplified)','szgoogleadmin')),
		'zh-TW'  => ucfirst(__('chinese (Traditional)','szgoogleadmin')),
		'hr'     => ucfirst(__('croatian','szgoogleadmin')),
		'cs'     => ucfirst(__('czech','szgoogleadmin')),
		'da'     => ucfirst(__('danish','szgoogleadmin')),
		'nl'     => ucfirst(__('dutch','szgoogleadmin')),
		'en-GB'  => ucfirst(__('english (UK)','szgoogleadmin')), 	
		'en-US'  => ucfirst(__('english (US)','szgoogleadmin')),
		'et'     => ucfirst(__('estonian','szgoogleadmin')),
		'fil'    => ucfirst(__('filipino','szgoogleadmin')),
		'fi'     => ucfirst(__('finnish','szgoogleadmin')),
		'fr'     => ucfirst(__('french','szgoogleadmin')),
		'fr-CA'  => ucfirst(__('french (Canadian)','szgoogleadmin')),
		'gl'     => ucfirst(__('galician','szgoogleadmin')),
		'de'     => ucfirst(__('german','szgoogleadmin')),
		'el'     => ucfirst(__('greek','szgoogleadmin')),
		'gu'     => ucfirst(__('gujarati','szgoogleadmin')),
		'iw'     => ucfirst(__('hebrew','szgoogleadmin')),
		'hi'     => ucfirst(__('hindi','szgoogleadmin')),
		'hu'     => ucfirst(__('hungarian','szgoogleadmin')),
		'is'     => ucfirst(__('icelandic','szgoogleadmin')),
		'id'     => ucfirst(__('indonesian','szgoogleadmin')),
		'it'     => ucfirst(__('italian','szgoogleadmin')),
		'ja'     => ucfirst(__('japanese','szgoogleadmin')),
		'kn'     => ucfirst(__('kannada','szgoogleadmin')),
		'ko'     => ucfirst(__('korean','szgoogleadmin')),
		'lv'     => ucfirst(__('latvian','szgoogleadmin')),
		'lt'     => ucfirst(__('lithuanian','szgoogleadmin')),
		'ms'     => ucfirst(__('malay','szgoogleadmin')),
		'ml'     => ucfirst(__('malayalam','szgoogleadmin')),
		'mr'     => ucfirst(__('marathi','szgoogleadmin')),
		'no'     => ucfirst(__('norwegian','szgoogleadmin')),
		'fa'     => ucfirst(__('persian','szgoogleadmin')),
		'pl'     => ucfirst(__('polish','szgoogleadmin')), 	
		'pt-BR'  => ucfirst(__('portuguese (Brazil)','szgoogleadmin')),
		'pt-PT'  => ucfirst(__('portuguese (Portugal)','szgoogleadmin')),
		'ro'     => ucfirst(__('romanian','szgoogleadmin')),
		'ru'     => ucfirst(__('russian','szgoogleadmin')),
		'sr'     => ucfirst(__('serbian','szgoogleadmin')),
		'sk'     => ucfirst(__('slovak','szgoogleadmin')),
		'sl'     => ucfirst(__('slovenian','szgoogleadmin')),
		'es'     => ucfirst(__('spanish','szgoogleadmin')),
		'es-419' => ucfirst(__('spanish (Latin America)','szgoogleadmin')),
		'sw'     => ucfirst(__('swahili','szgoogleadmin')),
		'sv'     => ucfirst(__('swedish','szgoogleadmin')),
		'ta'     => ucfirst(__('tamil','szgoogleadmin')),
		'te'     => ucfirst(__('telugu','szgoogleadmin')),
		'th'     => ucfirst(__('thai','szgoogleadmin')),
		'tr'     => ucfirst(__('turkish','szgoogleadmin')),
		'uk'     => ucfirst(__('ukrainian','szgoogleadmin')),
		'ur'     => ucfirst(__('urdu','szgoogleadmin')),
		'vi'     => ucfirst(__('vietnamese','szgoogleadmin')),
		'zu'     => ucfirst(__('zulu','szgoogleadmin')),
	);

	asort($languages);
	return $languages;
}

/* ************************************************************************** */
/* Funzioni per elaborazione codice HTML di G+ BADGE                          */
/* ************************************************************************** */

function szgoogle_get_gplus_badge_profile($atts=array()) {
	if (function_exists('sz_google_shortcodes_plus_profile')) {
		return sz_google_shortcodes_plus_profile($atts);
	} else return false;
}

function szgoogle_get_gplus_badge_page($atts=array()) {
	if (function_exists('sz_google_shortcodes_plus_page')) {
		return sz_google_shortcodes_plus_page($atts);
	} else return false;
}

function szgoogle_get_gplus_badge_community($atts=array()) {
	if (function_exists('sz_google_shortcodes_plus_community')) {
		return sz_google_shortcodes_plus_community($atts);
	} else return false;
}

/* ************************************************************************** */
/* Funzioni per elaborazione codice HTML di G+ BUTTON                         */
/* ************************************************************************** */

function szgoogle_get_gplus_button_one($atts=array()) {
	if (function_exists('sz_google_shortcodes_plus_plusone')) {
		return sz_google_shortcodes_plus_plusone($atts);
	} else return false;
}

function szgoogle_get_gplus_button_share($atts=array()) {
	if (function_exists('sz_google_shortcodes_plus_sharing')) {
		return sz_google_shortcodes_plus_sharing($atts);
	} else return false;
}

function szgoogle_get_gplus_button_follow($atts=array()) {
	if (function_exists('sz_google_shortcodes_plus_follow')) {
		return sz_google_shortcodes_plus_follow($atts);
	} else return false;
}

/* ************************************************************************** */
/* Funzioni per elaborazione codice HTML di G+ COMMENTS                       */
/* ************************************************************************** */

function szgoogle_get_gplus_comments($atts=array()) {
	if (function_exists('sz_google_shortcodes_plus_comments')) {
		return sz_google_shortcodes_plus_comments($atts);
	} else return false;
}

/* ************************************************************************** */
/* Funzioni per elaborazione codice HTML di G+ EMBEDDED POST                  */
/* ************************************************************************** */

function szgoogle_get_gplus_post($atts=array()) {
	if (function_exists('sz_google_modules_plus_get_code_post')) {
		return sz_google_modules_plus_get_code_post($atts);
	} else return false;
}

/* ************************************************************************** */
/* Funzioni per elaborazione codice HTML di GOOGLE ANALYTICS                  */
/* ************************************************************************** */

function szgoogle_get_ga_ID() {
	if (function_exists('sz_google_modules_analytics_get_ID')) {
		return sz_google_modules_analytics_get_ID();
	} else return false;
}

function szgoogle_get_ga_code() {
	if (function_exists('sz_google_modules_analytics_get_code')) {
		return sz_google_modules_analytics_get_code();
	} else return false;
}

/* ************************************************************************** */
/* Funzioni per elaborazione codice HTML di GOOGLE GROUPS                     */
/* ************************************************************************** */

function szgoogle_get_groups_code($atts=array()) {
	if (function_exists('sz_google_modules_groups_get_code')) {
		return sz_google_modules_groups_get_code($atts);
	} else return false;
}

/* ************************************************************************** */
/* Funzioni per elaborazione codice HTML di GOOGLE TRANSLATE                  */
/* ************************************************************************** */

function szgoogle_get_translate_meta_ID() {
	if (function_exists('sz_google_modules_translate_get_meta_ID()')) {
		return sz_google_modules_translate_get_meta_ID();
	} else return false;
}

function szgoogle_get_translate_meta() {
	if (function_exists('sz_google_modules_translate_get_meta()')) {
		return sz_google_modules_translate_get_meta();
	} else return false;
}

function szgoogle_get_translate_code($atts=array()) {
	if (function_exists('sz_google_modules_translate_get_code()')) {
		return sz_google_modules_translate_get_code($atts);
	} else return false;
}

/* ************************************************************************** */
/* Funzioni per elaborazione codice HTML di GOOGLE YOUTUBE                    */
/* ************************************************************************** */

function szgoogle_get_youtube_code_video($atts=array()) {
	if (function_exists('sz_google_modules_youtube_get_code_video()')) {
		return sz_google_modules_youtube_get_code_video($atts);
	} else return false;
}

function szgoogle_get_youtube_code_badge($atts=array()) {
	if (function_exists('sz_google_modules_youtube_get_code_badge()')) {
		return sz_google_modules_youtube_get_code_badge($atts);
	} else return false;
}

function szgoogle_get_youtube_code_button($atts=array()) {
	if (function_exists('sz_google_modules_youtube_get_code_button()')) {
		return sz_google_modules_youtube_get_code_button($atts);
	} else return false;
}

function szgoogle_get_youtube_code_link($atts=array()) {
	if (function_exists('sz_google_modules_youtube_get_code_link()')) {
		return sz_google_modules_youtube_get_code_link($atts);
	} else return false;
}
