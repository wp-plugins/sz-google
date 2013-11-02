<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_MODULE') or !SZ_PLUGIN_GOOGLE_MODULE) die();

/* ************************************************************************** */ 
/* Controllo le opzioni per sapere quali componenti risultano attivati        */ 
/* ************************************************************************** */ 

$options = sz_google_module_translate_options();

if ($options['translate_shortcode'] == SZ_PLUGIN_GOOGLE_VALUE_YES) { 
	add_shortcode('sz-gtranslate','sz_google_shortcodes_translate_widget');
}

if ($options['translate_widget'] == SZ_PLUGIN_GOOGLE_VALUE_YES) { 
	add_action('widgets_init',create_function('','return register_widget("SZ_Widget_Google_Translate");'));
}

/* ************************************************************************** */ 
/* Funzion per caricamento parte header con meta ID di translate              */
/* ************************************************************************** */ 

function sz_google_module_translate_meta() {
	echo sz_google_module_translate_get_meta();
}

add_action('wp_head','sz_google_module_translate_meta');

/* ************************************************************************** */ 
/* Funzione generale per il caricamento e la messa in coerenza delle opzioni  */
/* ************************************************************************** */ 

function sz_google_module_translate_options()
{
	// Caricamento delle opzioni per modulo google translate

	$options = get_option('sz_google_options_translate');

	// Controllo delle opzioni in caso di valori non validi

	if (!isset($options['translate_meta']))         $options['translate_meta']         = SZ_PLUGIN_GOOGLE_VALUE_NULL;
	if (!isset($options['translate_mode']))         $options['translate_mode']         = 'I1';
	if (!isset($options['translate_language']))     $options['translate_language']     = SZ_PLUGIN_GOOGLE_VALUE_LANG;
	if (!isset($options['translate_to']))           $options['translate_to']           = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['translate_widget']))       $options['translate_widget']       = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['translate_shortcode']))    $options['translate_shortcode']    = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['translate_automatic']))    $options['translate_automatic']    = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['translate_multiple']))     $options['translate_multiple']     = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['translate_analytics']))    $options['translate_analytics']    = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['translate_analytics_ua'])) $options['translate_analytics_ua'] = SZ_PLUGIN_GOOGLE_VALUE_NULL;

	// Controllo delle opzioni in caso di valori non validi

	if (trim($options['translate_language']) == SZ_PLUGIN_GOOGLE_VALUE_NULL) 
		$options['translate_language'] = SZ_PLUGIN_GOOGLE_VALUE_LANG;

	// Controllo opzione di codice GA-UA nel caso debba pendere il valore
	// specificato nel modulo corrispondente se risulta attivo.

	if (function_exists('sz_google_module_analytics_options') and $options['translate_analytics_ua'] == SZ_PLUGIN_GOOGLE_VALUE_NULL) 
	{
		$options_ga = sz_google_module_analytics_options();
		$options['translate_analytics_ua'] = $options_ga['ga_uacode'];   
	}

	return $options;
}

/* ************************************************************************** */ 
/* Funzione per la generazione di codice legato a google translate            */
/* ************************************************************************** */ 

function sz_google_module_translate_get_meta_ID() 
{
	$options = sz_google_module_translate_options();
	return trim($options['translate_meta']);
}

/* ************************************************************************** */ 
/* Funzione per la generazione di codice legato a google translate            */
/* ************************************************************************** */ 

function sz_google_module_translate_get_meta()
{
	if (sz_google_module_translate_get_meta_ID() <> SZ_PLUGIN_GOOGLE_VALUE_NULL) {
		$HTML  = '<meta name="google-translate-customization" ';
		$HTML .= 'content="'.sz_google_module_translate_get_meta_ID().'">';
		$HTML .= '</meta>';
	}   

	if (isset($HTML)) return $HTML; else return '';
}

/* ************************************************************************** */ 
/* Funzione per la generazione di codice legato a google translate            */
/* ************************************************************************** */ 

function sz_google_module_translate_get_code($atts=array())
{
	$options = sz_google_module_translate_options();

	// Estrazione dei valori specificati nello shortcode, i valori ritornati
	// sono contenuti nei nomi di variabili corrispondenti alla chiave

	if (!is_array($atts)) $atts = array();

	extract(shortcode_atts(array(
		'language'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'mode'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'automatic' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'multiple'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'analytics' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'uacode'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts));

	// Elimino spazi aggiunti di troppo ed esegui la trasformazione in
	// stringa minuscolo per il controllo di valori speciali come "auto"

	$uacode    = trim($uacode);
	$language  = strtolower(trim($language));
	$mode      = strtolower(trim($mode));
	$automatic = strtolower(trim($automatic));
	$multiple  = strtolower(trim($multiple));
	$analytics = strtolower(trim($analytics));

	// Se non sono riuscito ad assegnare nessun valore con le istruzioni
	// precedenti metto dei default assoluti che possono essere cambiati

	if ($language  == SZ_PLUGIN_GOOGLE_VALUE_NULL) $language  = $options['translate_language'];
	if ($mode      == SZ_PLUGIN_GOOGLE_VALUE_NULL) $mode      = $options['translate_mode'];
	if ($automatic == SZ_PLUGIN_GOOGLE_VALUE_NULL) $automatic = $options['translate_automatic'];
	if ($multiple  == SZ_PLUGIN_GOOGLE_VALUE_NULL) $multiple  = $options['translate_multiple'];
	if ($analytics == SZ_PLUGIN_GOOGLE_VALUE_NULL) $analytics = $options['translate_analytics'];
	if ($uacode    == SZ_PLUGIN_GOOGLE_VALUE_NULL) $uacode    = $options['translate_analytics_ua'];


	if ($options['translate_language'] == SZ_PLUGIN_GOOGLE_VALUE_LANG) $language = substr(get_bloginfo('language'),0,2);	
		else $language = trim($options['translate_language']);

	// Creazione codice HTML per inserimento javascript di google 

	$HTML  = '<div id="google_translate_element"></div>';
	$HTML .= '<script type="text/javascript">';
	$HTML .= 'function googleTranslateElementInit() {';
	$HTML .= 'new google.translate.TranslateElement({';
	$HTML .= "pageLanguage:'".$language."'";

	if ($options['translate_mode']         == 'I2') $HTML .= ",layout:google.translate.TranslateElement.InlineLayout.HORIZONTAL";
	if ($options['translate_mode']         == 'I3') $HTML .= ",layout:google.translate.TranslateElement.InlineLayout.SIMPLE";

	if ($automatic   <> SZ_PLUGIN_GOOGLE_VALUE_YES ) $HTML .= ",autoDisplay:false";
	if ($multiple    == SZ_PLUGIN_GOOGLE_VALUE_YES ) $HTML .= ",multilanguagePage:true";
	if ($analytics   == SZ_PLUGIN_GOOGLE_VALUE_YES ) $HTML .= ",gaTrack:true";

	if ($options['translate_analytics_ua'] <> ''  ) $HTML .= ",gaID:'".$options['translate_analytics_ua']."'";

	$HTML .= "},'google_translate_element');}";
	$HTML .= '</script>';
	$HTML .= '<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>';

	return $HTML;
}

/* ************************************************************************** */
/* Funzione shortcode per inserimento G+ BADGE su PAGE                        */
/* ************************************************************************** */

function sz_google_shortcodes_translate_widget($atts,$content=null) 
{
	// Estrazione dei valori specificati nello shortcode, i valori ritornati
	// sono contenuti nei nomi di variabili corrispondenti alla chiave

	extract(shortcode_atts(array(
		'language'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'mode'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'automatic' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'multiple'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'analytics' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'uacode'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts));

	// Preparazione codice HTML dello shortcode tramite la funzione
	// standard di preparazione codice sia per shortcode che widgets

	$HTML  = sz_google_module_translate_get_code(array(
		'language'  => trim($language),
		'mode'      => trim($mode),
		'automatic' => trim($automatic),
		'multiple'  => trim($multiple),
		'analytics' => trim($analytics),
		'uacode'    => trim($uacode),
	));

	return $HTML;
}

/* ************************************************************************** */ 
/* SZ_Widget_Google_Profile - Inserimento profilo sulla sidebar come widget   */ 
/* ************************************************************************** */ 

class SZ_Widget_Google_Translate extends WP_Widget_SZ_Google
{
	// Costruttore principale della classe widget, definizione 
	// delle opzioni legate al widget e al controllo dello stesso

	function __construct() 
	{
		parent::__construct('SZ-Google-Translate',__('SZ-Google - Translate','szgoogleadmin'),array(
			'classname'   => 'sz-widget-google sz-widget-translate sz-widget-translate-widget', 
			'description' => ucfirst(__('widget for google translate','szgoogleadmin'))
		));
	}

	// Funzione per la visualizzazione del widget con lettura parametri
	// di configurazione e preparazione codice HTML da usare nella sidebar

	function widget($args,$instance) 
	{
		extract($args);

		// Costruzione del titolo del widget

		if (empty($instance['title'])) $title = '';
			else $title = trim($instance['title']);

		$title = apply_filters('widget_title',$title,$instance,$this->id_base);

		if (!isset($before_title)) $before_title = '';
		if (!isset($after_title))  $after_title = '';

		if ($title and $title <> '') {
			$title = $before_title.$title.$after_title;
		}

		// Creazione del codice per widget google translate

		$HTML = sz_google_module_translate_get_code();
      
		// Output del codice HTML legato al widget da visualizzare		 

		$output  = '';
		$output .= $before_widget;
		$output .= $title;
		$output .= $HTML;
		$output .= $after_widget;

		echo $output;

	}

	// Funzione per modifica parametri collegati al widget con 
	// memorizzazione dei valori direttamente nel database wordpress

	function update($new_instance,$old_instance) 
	{
		$instance = $old_instance;

		$instance['title']    = trim(strip_tags($new_instance['title']));

		return $instance;
	}

	// Funzione per la visualizzazione del form presente sulle 
	// sidebar nel pannello di amministrazione di wordpress
	
	function form($instance) 
	{
		// Creazione array per elenco campi da recuperare su FORM

		$array = array(
			'title'    => '',
		);

		// Creazione array per elenco campi da recuperare su FORM

		$instance = wp_parse_args((array) $instance,$array);
		$title    = trim(strip_tags($instance['title']));

		// Campo di selezione parametro badge per TITOLO

		echo '<p><label for="'.$this->get_field_id('title').'">'.ucfirst(__('title','szgoogleadmin')).':</label>';
		echo '<input class="widefat" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.esc_attr($title).'"/></p>';
	}
}
