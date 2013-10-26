<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

/* ************************************************************************** */
/* Definizione costanti che devo essere comuni a tutti i file module          */
/* ************************************************************************** */

define('SZ_PLUGIN_GOOGLE_MODULE',true);
define('SZ_PLUGIN_GOOGLE_MODULE_BASENAME',basename(__FILE__));

/* ************************************************************************** */
/* Caricamento della lingua per il plugin SZ-Google parte fontend             */
/* ************************************************************************** */

function sz_google_language_init() {
	load_plugin_textdomain(
		'szgoogle',false,SZ_PLUGIN_GOOGLE_BASENAME_LANGUAGE);
}

add_action('init','sz_google_language_init');

/* ************************************************************************** */ 
/* Controllo le opzioni generali per sapere i moduli da caricare              */
/* ************************************************************************** */ 

$module = sz_google_module_options();

// Impostazioni variabili per attivazione dei moduli

$SZ_ENABLE_MODULE_PLUS      = $module['plus'];
$SZ_ENABLE_MODULE_ANALYTICS = $module['analytics'];
$SZ_ENABLE_MODULE_DRIVE     = $module['drive'];
$SZ_ENABLE_MODULE_GROUPS    = $module['groups'];
$SZ_ENABLE_MODULE_PANORAMIO = $module['panoramio'];
$SZ_ENABLE_MODULE_TRANSLATE = $module['translate'];
$SZ_ENABLE_MODULE_YOUTUBE   = $module['youtube'];

/* ************************************************************************** */ 
/* Controllo le opzioni generali per i moduli che devo essere caricati        */
/* ************************************************************************** */ 

if ($SZ_ENABLE_MODULE_PLUS      == SZ_PLUGIN_GOOGLE_VALUE_YES) @require_once(dirname(__FILE__).'/sz-google-module-plus.php');
if ($SZ_ENABLE_MODULE_ANALYTICS == SZ_PLUGIN_GOOGLE_VALUE_YES) @require_once(dirname(__FILE__).'/sz-google-module-analytics.php');
if ($SZ_ENABLE_MODULE_DRIVE     == SZ_PLUGIN_GOOGLE_VALUE_YES) @require_once(dirname(__FILE__).'/sz-google-module-drive.php');
if ($SZ_ENABLE_MODULE_GROUPS    == SZ_PLUGIN_GOOGLE_VALUE_YES) @require_once(dirname(__FILE__).'/sz-google-module-groups.php');
if ($SZ_ENABLE_MODULE_PANORAMIO == SZ_PLUGIN_GOOGLE_VALUE_YES) @require_once(dirname(__FILE__).'/sz-google-module-panoramio.php');
if ($SZ_ENABLE_MODULE_TRANSLATE == SZ_PLUGIN_GOOGLE_VALUE_YES) @require_once(dirname(__FILE__).'/sz-google-module-translate.php');
if ($SZ_ENABLE_MODULE_YOUTUBE   == SZ_PLUGIN_GOOGLE_VALUE_YES) @require_once(dirname(__FILE__).'/sz-google-module-youtube.php');

/* ************************************************************************** */ 
/* Funzione generale per il caricamento e la messa in coerenza delle opzioni  */
/* ************************************************************************** */ 

function sz_google_module_options()
{
	$options = get_option('sz_google_options_base');

	// Controllo delle opzioni in caso di valori non esistenti
	// richiamo della funzione per il controllo isset()

	$options = sz_google_module_check_values_isset($options,array(
		'plus'          => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'drive'         => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'analytics'     => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'groups'        => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'panoramio'     => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'translate'     => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'youtube'       => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'documentation' => SZ_PLUGIN_GOOGLE_VALUE_NO,
	));

	// Chiamata alla funzione comune per controllare le variabili che devono avere
	// un valore di YES o NO e nel caso non fosse possibile forzare il valore (NO)

	$options = sz_google_module_check_values_yesno($options,array(
		'plus'          => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'drive'         => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'analytics'     => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'groups'        => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'panoramio'     => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'translate'     => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'youtube'       => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'documentation' => SZ_PLUGIN_GOOGLE_VALUE_NO,
	));

	// Ritorno indietro il gruppo di opzioni corretto dai
	// controlli formali della funzione di reperimento opzioni

	return $options;
}

/* ************************************************************************** */
/* COMMON COMMON COMMON COMMON COMMON COMMON COMMON COMMON COMMON COMMON COMM */
/* COMMON COMMON COMMON COMMON COMMON COMMON COMMON COMMON COMMON COMMON COMM */
/* COMMON COMMON COMMON COMMON COMMON COMMON COMMON COMMON COMMON COMMON COMM */
/* COMMON COMMON COMMON COMMON COMMON COMMON COMMON COMMON COMMON COMMON COMM */
/* COMMON COMMON COMMON COMMON COMMON COMMON COMMON COMMON COMMON COMMON COMM */
/* ************************************************************************** */

function sz_google_module_check_values_isset($options,$names) 
{
	foreach ($names as $key => $value) {
		if (!isset($options[$key])) $options[$key] = $value;
	}
	return $options;
}

/* ************************************************************************** */
/* COMMON CODE funzione per controllo opzioni con valori NULL                 */
/* ************************************************************************** */

function sz_google_module_check_values_isnull($options,$names) 
{
	foreach ($names as $key => $value) {
		if (isset($options[$key]) and $options[$key] == SZ_PLUGIN_GOOGLE_VALUE_NULL) {
			$options[$key] = $value;
		}
	}
	return $options;
}

/* ************************************************************************** */
/* COMMON CODE funzione per controllo opzioni con valori ZERO                 */
/* ************************************************************************** */

function sz_google_module_check_values_iszero($options,$names) 
{
	foreach ($names as $key => $value) {
		if (isset($options[$key]) and $options[$key] == SZ_PLUGIN_GOOGLE_VALUE_ZERO) {
			$options[$key] = $value;
		}
	}
	return $options;
}

/* ************************************************************************** */
/* COMMON CODE funzione per controllo opzioni con valori YES o NO             */
/* ************************************************************************** */

function sz_google_module_check_values_yesno($options,$names) 
{
	foreach ($names as $key => $value) {
		if (isset($options[$key])) { 
			if (!in_array($options[$key],array(SZ_PLUGIN_GOOGLE_VALUE_YES,SZ_PLUGIN_GOOGLE_VALUE_NO))) {
				$options[$key] = $value;
			}
		}
	}
	return $options;
}

/* ************************************************************************** */
/* COMMON CODE creazione widget con il passaggio del nome della classe        */
/* ************************************************************************** */

function sz_google_module_widget_create($nome) {
	add_action('widgets_init',create_function('','return register_widget("'.$nome.'");'));
}

/* ************************************************************************** */
/* COMMON CODE esecuzione operazione di flush_rules su regole rewrite         */
/* ************************************************************************** */

function sz_google_module_flush_rules() {
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}

/* ************************************************************************** */
/* COMMON CODE controllo dei parametri in maniera singola e default           */
/* ************************************************************************** */

function sz_google_module_check_options($name,$value) 
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
/* COMMON CODE array contenente i linguaggi supportati da google              */
/* ************************************************************************** */

function sz_google_get_languages() 
{
	$languages = array(
		'99'     => ' '.__('same language theme','szgoogle'),
		'af'     => ucfirst(__('afrikaans','szgoogle')),
		'am'     => ucfirst(__('amharic','szgoogle')),
		'ar'     => ucfirst(__('arabic','szgoogle')),
		'eu'     => ucfirst(__('basque','szgoogle')),
		'bn'     => ucfirst(__('bengali','szgoogle')),
		'bg'     => ucfirst(__('bulgarian','szgoogle')),
		'ca'     => ucfirst(__('catalan','szgoogle')),
		'zh-HK'  => ucfirst(__('chinese (Hong Kong)','szgoogle')),
		'zh-CN'  => ucfirst(__('chinese (Simplified)','szgoogle')),
		'zh-TW'  => ucfirst(__('chinese (Traditional)','szgoogle')),
		'hr'     => ucfirst(__('croatian','szgoogle')),
		'cs'     => ucfirst(__('czech','szgoogle')),
		'da'     => ucfirst(__('danish','szgoogle')),
		'nl'     => ucfirst(__('dutch','szgoogle')),
		'en-GB'  => ucfirst(__('english (UK)','szgoogle')), 	
		'en-US'  => ucfirst(__('english (US)','szgoogle')),
		'et'     => ucfirst(__('estonian','szgoogle')),
		'fil'    => ucfirst(__('filipino','szgoogle')),
		'fi'     => ucfirst(__('finnish','szgoogle')),
		'fr'     => ucfirst(__('french','szgoogle')),
		'fr-CA'  => ucfirst(__('french (Canadian)','szgoogle')),
		'gl'     => ucfirst(__('galician','szgoogle')),
		'de'     => ucfirst(__('german','szgoogle')),
		'el'     => ucfirst(__('greek','szgoogle')),
		'gu'     => ucfirst(__('gujarati','szgoogle')),
		'iw'     => ucfirst(__('hebrew','szgoogle')),
		'hi'     => ucfirst(__('hindi','szgoogle')),
		'hu'     => ucfirst(__('hungarian','szgoogle')),
		'is'     => ucfirst(__('icelandic','szgoogle')),
		'id'     => ucfirst(__('indonesian','szgoogle')),
		'it'     => ucfirst(__('italian','szgoogle')),
		'ja'     => ucfirst(__('japanese','szgoogle')),
		'kn'     => ucfirst(__('kannada','szgoogle')),
		'ko'     => ucfirst(__('korean','szgoogle')),
		'lv'     => ucfirst(__('latvian','szgoogle')),
		'lt'     => ucfirst(__('lithuanian','szgoogle')),
		'ms'     => ucfirst(__('malay','szgoogle')),
		'ml'     => ucfirst(__('malayalam','szgoogle')),
		'mr'     => ucfirst(__('marathi','szgoogle')),
		'no'     => ucfirst(__('norwegian','szgoogle')),
		'fa'     => ucfirst(__('persian','szgoogle')),
		'pl'     => ucfirst(__('polish','szgoogle')), 	
		'pt-BR'  => ucfirst(__('portuguese (Brazil)','szgoogle')),
		'pt-PT'  => ucfirst(__('portuguese (Portugal)','szgoogle')),
		'ro'     => ucfirst(__('romanian','szgoogle')),
		'ru'     => ucfirst(__('russian','szgoogle')),
		'sr'     => ucfirst(__('serbian','szgoogle')),
		'sk'     => ucfirst(__('slovak','szgoogle')),
		'sl'     => ucfirst(__('slovenian','szgoogle')),
		'es'     => ucfirst(__('spanish','szgoogle')),
		'es-419' => ucfirst(__('spanish (Latin America)','szgoogle')),
		'sw'     => ucfirst(__('swahili','szgoogle')),
		'sv'     => ucfirst(__('swedish','szgoogle')),
		'ta'     => ucfirst(__('tamil','szgoogle')),
		'te'     => ucfirst(__('telugu','szgoogle')),
		'th'     => ucfirst(__('thai','szgoogle')),
		'tr'     => ucfirst(__('turkish','szgoogle')),
		'uk'     => ucfirst(__('ukrainian','szgoogle')),
		'ur'     => ucfirst(__('urdu','szgoogle')),
		'vi'     => ucfirst(__('vietnamese','szgoogle')),
		'zu'     => ucfirst(__('zulu','szgoogle')),
	);

	asort($languages);
	return $languages;
}

/* ************************************************************************** */
/* COMMON CODE codice per disegnare il wrap dei bottoni di google             */
/* ************************************************************************** */

function sz_google_module_get_code_button_wrap($atts) 
{
	extract(shortcode_atts(array(
		'html'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'text'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'image'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'content'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
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
	
	$HTML   = '<div class="'.$class.'">';
	$HTML  .= '<div class="sz-google-button">';
	$HTML  .= '<div class="sz-google-button-wrap"';
	$HTML  .= ' style="position:relative;';

	if (!empty($margintop)    and $margintop    != 'none') $HTML .= 'margin-top:'   .$margintop   .$marginunit.';';
	if (!empty($marginright)  and $marginright  != 'none') $HTML .= 'margin-right:' .$marginright .$marginunit.';';
	if (!empty($marginbottom) and $marginbottom != 'none') $HTML .= 'margin-bottom:'.$marginbottom.$marginunit.';';
	if (!empty($marginleft)   and $marginleft   != 'none') $HTML .= 'margin-left:'  .$marginleft  .$marginunit.';';

	$HTML  .= '">';
	$HTML  .= '<div class="sz-google-button-body">';

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

	if ($position == 'top')    $HTML .= 'position:absolute;width:100%;left:0;padding:1em;top:0;';		
	if ($position == 'center') $HTML .= 'position:absolute;width:100%;left:0;padding:1em;top:40%;';		
	if ($position == 'bottom') $HTML .= 'position:absolute;width:100%;left:0;padding:1em;bottom:0;';		

	if ($align == 'left')   $HTML .= 'text-align:left';		
	if ($align == 'center') $HTML .= 'text-align:center';		
	if ($align == 'right')  $HTML .= 'text-align:right';		

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

/* ************************************************************************** */
/* COMMON CODE definizione di un widget generico da usare nel plugin          */
/* ************************************************************************** */

class WP_Widget_SZ_Google extends WP_Widget
{
	// Costruzione del titolo del widget da utilizzare per tutti i 
	// widgets collegati al modulo attivato con questa pagina PHP

	function common_title($args,$instance)
	{
		extract($args);

		if (empty($instance['title'])) $title = SZ_PLUGIN_GOOGLE_VALUE_NULL;
			else $title = trim($instance['title']);

		if (!isset($before_title)) $before_title = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (!isset($after_title))  $after_title  = SZ_PLUGIN_GOOGLE_VALUE_NULL;

		if ($title and $title <> SZ_PLUGIN_GOOGLE_VALUE_NULL) {
			$title = $before_title.$title.$after_title;
		}

		// Ritorno al widget il titolo calcolato tramite i parametri di 
		// configurazione legati al tema applicato attualmente in wordpress	 

		return $title;
	}

	// Funzione per il controllo di variabili vuote all'interno
	// array widget contenente i nomi delle opzioni specificate

	function common_empty($names,$instance) 
	{
		foreach ($names as $key=>$value) {
			if (empty($instance[$key])) $instance[$key] = trim($value);
				else $instance[$key] = trim($instance[$key]);
		}

		return $instance;
	}

	// Funzione per emissione codie HTML con calcolo del titolo
	// e codice predefinito prima e dopo il widgets su sidebar

	function common_widget($args,$instance,$HTML) 
	{
		extract($args);

		// Calcolo del titolo legato al widget passato tramite la 
		// variabile presente nella instanza dei parametri memorizzata

		if (empty($instance['title'])) $title = SZ_PLUGIN_GOOGLE_VALUE_NULL;
			else $title = trim($instance['title']);

		if (!isset($before_title)) $before_title = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (!isset($after_title))  $after_title  = SZ_PLUGIN_GOOGLE_VALUE_NULL;

		if ($title and $title <> SZ_PLUGIN_GOOGLE_VALUE_NULL) {
			$title = $before_title.$title.$after_title;
		}

		// Calcolo del codice HTML definitivo facendo il wrap
		// con la variabile HTML generata dal widget specifico

		$output  = $before_widget;
		$output .= $title;
		$output .= $HTML;
		$output .= $after_widget;

		return $output;
	}

	// Funzione per modifica parametri collegati al widget con 
	// memorizzazione dei valori direttamente nel database wordpress

	function common_update($names,$new_instance,$old_instance) 
	{
		$instance = $old_instance;

		foreach ($names as $key=>$value) 
		{
			if (!isset($new_instance[$key])) $instance[$key] = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
				else $instance[$key] = trim($new_instance[$key]);

			if ($value == SZ_PLUGIN_GOOGLE_VALUE_YES) {
				$instance[$key] = strip_tags($instance[$key]);
			}
		}

		// Ritorno al widget array con le opzioni di update corrette e
		// gli eventuali elementi nuovi che sul vecchio widget era mancanti

		return $instance;
	}
}
