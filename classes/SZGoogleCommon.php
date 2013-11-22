<?php
/**
 * Classe SZGoogleCommon per esecuzione funzioni di uso generale o calcolo
 * di variabili da usare in qualsiasi modulo del plugin. Inserire in questa
 * classe le funzioni che vengono richiamate da moduli differenti.
 *
 * @package SZGoogle
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

/**
 * Prima della definizione della classe controllo se esiste
 * una definizione con lo stesso nome o già definita la stessa.
 */
if (!class_exists('SZGoogleCommon'))
{
	class SZGoogleCommon
	{
		/**
		 * Calcolo il nome del domnio corrente utilizzato dalla
		 * pagina visualizzata. Utilizzo della funzione get_site_url()
		 *
		 * @return string|false
		 */
		static function getCurrentDomain()
		{
			$pieces = parse_url(get_site_url());
  			$domain = isset($pieces['host']) ? $pieces['host'] : '';

			if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i',$domain,$regs)) {
    			return $regs['domain'];
  			}

			return false;
		}

		/**
		 * Esecuzione del flush per le regole di rewrite definite, questa funzione
		 * non va richiamate sempre ma solo quando vengono attivate le funzioni
		 * collegate in qualche maniera al rewite rules, per questioni di performance.
		 *
		 * @return string
		 */
		static function rewriteFlushRules() 
		{
			// Controllo costante di DEBUG per scrittura messaggio di
			// breakpoint nel file di log PHP indicato in php.ini

			if (SZ_PLUGIN_GOOGLE_DEBUG) {
				SZGoogleDebug::log('execute rewrite flush rules');
			}

			global $wp_rewrite;
			$wp_rewrite->flush_rules();
		}

		/**
		 * Traduzione delle stringe che riguarda il frontend, infatti i domini tra
		 * admin e frontend sono diversi e rispettivamento szgoogle e szgoogleadmin
		 *
		 * @return string
		 */
		static function getTranslate($string) {
			return __($string,'szgoogle');
		}

		/**
		 * Elenco delle lingue presenti in google da utilizzare
		 * in molti moduli presenti nel plugin come un'elenco standard.
		 *
		 * @return array
		 */
		static function getLanguages()
		{
			// Controllo costante di DEBUG per scrittura messaggio di
			// breakpoint nel file di log PHP indicato in php.ini

			if (SZ_PLUGIN_GOOGLE_DEBUG) {
				SZGoogleDebug::log('get array for language code');
			}

			// Preparazione array con i codice lingua supportati da google,
			// questo array può essere ulizzato per diversi moduli 

			$languages = array(
				'99'     => ' '.self::getTranslate('same language theme'),
				'af'     => ucfirst(self::getTranslate('afrikaans')),
				'am'     => ucfirst(self::getTranslate('amharic')),
				'ar'     => ucfirst(self::getTranslate('arabic')),
				'eu'     => ucfirst(self::getTranslate('basque')),
				'bn'     => ucfirst(self::getTranslate('bengali')),
				'bg'     => ucfirst(self::getTranslate('bulgarian')),
				'ca'     => ucfirst(self::getTranslate('catalan')),
				'zh-HK'  => ucfirst(self::getTranslate('chinese (Hong Kong)')),
				'zh-CN'  => ucfirst(self::getTranslate('chinese (Simplified)')),
				'zh-TW'  => ucfirst(self::getTranslate('chinese (Traditional)')),
				'hr'     => ucfirst(self::getTranslate('croatian')),
				'cs'     => ucfirst(self::getTranslate('czech')),
				'da'     => ucfirst(self::getTranslate('danish')),
				'nl'     => ucfirst(self::getTranslate('dutch')),
				'en-GB'  => ucfirst(self::getTranslate('english (UK)')), 	
				'en-US'  => ucfirst(self::getTranslate('english (US)')),
				'et'     => ucfirst(self::getTranslate('estonian')),
				'fil'    => ucfirst(self::getTranslate('filipino')),
				'fi'     => ucfirst(self::getTranslate('finnish')),
				'fr'     => ucfirst(self::getTranslate('french')),
				'fr-CA'  => ucfirst(self::getTranslate('french (Canadian)')),
				'gl'     => ucfirst(self::getTranslate('galician')),
				'de'     => ucfirst(self::getTranslate('german')),
				'el'     => ucfirst(self::getTranslate('greek')),
				'gu'     => ucfirst(self::getTranslate('gujarati')),
				'iw'     => ucfirst(self::getTranslate('hebrew')),
				'hi'     => ucfirst(self::getTranslate('hindi')),
				'hu'     => ucfirst(self::getTranslate('hungarian')),
				'is'     => ucfirst(self::getTranslate('icelandic')),
				'id'     => ucfirst(self::getTranslate('indonesian')),
				'it'     => ucfirst(self::getTranslate('italian')),
				'ja'     => ucfirst(self::getTranslate('japanese')),
				'kn'     => ucfirst(self::getTranslate('kannada')),
				'ko'     => ucfirst(self::getTranslate('korean')),
				'lv'     => ucfirst(self::getTranslate('latvian')),
				'lt'     => ucfirst(self::getTranslate('lithuanian')),
				'ms'     => ucfirst(self::getTranslate('malay')),
				'ml'     => ucfirst(self::getTranslate('malayalam')),
				'mr'     => ucfirst(self::getTranslate('marathi')),
				'no'     => ucfirst(self::getTranslate('norwegian')),
				'fa'     => ucfirst(self::getTranslate('persian')),
				'pl'     => ucfirst(self::getTranslate('polish')), 	
				'pt-BR'  => ucfirst(self::getTranslate('portuguese (Brazil)')),
				'pt-PT'  => ucfirst(self::getTranslate('portuguese (Portugal)')),
				'ro'     => ucfirst(self::getTranslate('romanian')),
				'ru'     => ucfirst(self::getTranslate('russian')),
				'sr'     => ucfirst(self::getTranslate('serbian')),
				'sk'     => ucfirst(self::getTranslate('slovak')),
				'sl'     => ucfirst(self::getTranslate('slovenian')),
				'es'     => ucfirst(self::getTranslate('spanish','szgoogle')),
				'es-419' => ucfirst(self::getTranslate('spanish (Latin America)')),
				'sw'     => ucfirst(self::getTranslate('swahili')),
				'sv'     => ucfirst(self::getTranslate('swedish')),
				'ta'     => ucfirst(self::getTranslate('tamil')),
				'te'     => ucfirst(self::getTranslate('telugu')),
				'th'     => ucfirst(self::getTranslate('thai')),
				'tr'     => ucfirst(self::getTranslate('turkish')),
				'uk'     => ucfirst(self::getTranslate('ukrainian')),
				'ur'     => ucfirst(self::getTranslate('urdu')),
				'vi'     => ucfirst(self::getTranslate('vietnamese')),
				'zu'     => ucfirst(self::getTranslate('zulu')),
			);

			// Eseguo ordinamento array in base alla nazione e alla
			// stringa di traduzione eseguita dopo il rendering

			asort($languages);
			return $languages;
		}

		/**
		 * Funzione per disegno wrapper legato ad un bottone di uso
		 * comune a più moduli del plugin e con le stesse opzioni.
		 *
		 * @param  array $atts
		 * @return string
		 */
		static function getCodeButtonWrap($atts) 
		{
			// Controllo costante di DEBUG per scrittura messaggio di
			// breakpoint nel file di log PHP indicato in php.ini

			if (SZ_PLUGIN_GOOGLE_DEBUG) {
				SZGoogleDebug::log('execute function getCodeButtonWrap for buttons');
			}

			extract(shortcode_atts(array(
				'html'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'text'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'image'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'content'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'float'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'align'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'position'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'class'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'margintop'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginright'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginbottom' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginleft'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
				'marginunit'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			),$atts));

			// Imposto i valori di default nel caso siano specificati dei valori
			// che non appartengono al range dei valori accettati

			if (!ctype_digit($margintop)    and $margintop    != 'none') $margintop    = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
			if (!ctype_digit($marginright)  and $marginright  != 'none') $marginright  = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
			if (!ctype_digit($marginbottom) and $marginbottom != 'none') $marginbottom = '1'; 
			if (!ctype_digit($marginleft)   and $marginleft   != 'none') $marginleft   = SZ_PLUGIN_GOOGLE_VALUE_NULL; 

			if (!in_array($marginunit,array('px','pt','em'))) $marginunit = 'em';

			// Calcolo il codice HTML per eseguire un WRAP sul
			// codice del bottone preparato in precedenza dal chiamante
	
			$HTML  = '<div class="'.$class.'" style="';
				if (!empty($float) and $float != 'none') $HTML .= 'float:'.$float.';';
				if (!empty($align) and $align != 'none') $HTML .= 'text-align:'.$align.';';
			$HTML .= '"">';

			$HTML .= '<div class="sz-google-button" style="';

			if (!empty($margintop)    and $margintop    != 'none') $HTML .= 'margin-top:'   .$margintop   .$marginunit.';';
			if (!empty($marginright)  and $marginright  != 'none') $HTML .= 'margin-right:' .$marginright .$marginunit.';';
			if (!empty($marginbottom) and $marginbottom != 'none') $HTML .= 'margin-bottom:'.$marginbottom.$marginunit.';';
			if (!empty($marginleft)   and $marginleft   != 'none') $HTML .= 'margin-left:'  .$marginleft  .$marginunit.';';

			$HTML .= '">';

			$HTML .= '<div class="sz-google-button-wrap" style="position:relative;display:inline-block;">';
			$HTML .= '<div class="sz-google-button-body">';

			// Se trovo contenuto per il parametro "text" dello shortcode
			// lo aggiungo prima del codice embed originale di google

			if ($text != SZ_PLUGIN_GOOGLE_VALUE_NULL) {
				$HTML .= '<div class="sz-google-button-text">';
				$HTML .= '<p>'.$text.'</p>';
				$HTML .= '</div>';
			}

			// Se trovo contenuto per il parametro "image" dello shortcode
			// lo aggiungo prima del codice embed originale di google

			if ($image != SZ_PLUGIN_GOOGLE_VALUE_NULL) {
				$HTML .= '<div class="sz-google-button-imgs">';
				$HTML .= '<p><img src="'.$image.'" alt=""/></p>';
				$HTML .= '</div>';
			}

			// Se trovo contenuto tra inizio e fine dello shortcode
			// lo aggiungo prima del codice embed originale di google

			if ($content != SZ_PLUGIN_GOOGLE_VALUE_NULL) {
				$HTML .= '<div class="sz-google-button-cont">';
				$HTML .= $content;
				$HTML .= '</div>';
			}

			$HTML .= '</div>';

			// Aggiunta del codice per inserimento iframe originale
			// di google con allineamento e posizionamento

			$HTML .= '<div class="sz-google-button-code">';
			$HTML .= '<div class="sz-google-button-side"';
			$HTML .= ' style="display:block;';

			if ($position == 'top')    $HTML .= 'position:absolute;width:100%;padding:0;top:1em;';		
			if ($position == 'center') $HTML .= 'position:absolute;width:100%;padding:0;top:40%;';		
			if ($position == 'bottom') $HTML .= 'position:absolute;width:100%;padding:0;bottom:1em;';		

			if ($align    == 'left')   $HTML .= 'left:1em;text-align:left';		
			if ($align    == 'center') $HTML .= 'left:0;text-align:center';		
			if ($align    == 'right')  $HTML .= 'right:1em;text-align:right';		

			$HTML .= '">';
			$HTML .= $html;
			$HTML .= '</div>';
			$HTML .= '</div>';

			$HTML .= '</div>';
			$HTML .= '</div>';
			$HTML .= '</div>';

			// Ritorno per la funzione con tutta la stringa contenente
			// il codice HTML per l'inserimento del codice nella pagina

			return $HTML;
		}
	}
}
