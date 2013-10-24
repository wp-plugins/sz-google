<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_MODULE') or !SZ_PLUGIN_GOOGLE_MODULE) die();

/* ************************************************************************** */ 
/* Controllo le opzioni per sapere quali componenti risultano attivati        */ 
/* ************************************************************************** */ 

$options = sz_google_module_groups_options();

// Impostazioni variabili per attivazione dei controlli

$SZ_GROUPS_ENABLE_SHORTC_IFRAME = $options['groups_shortcode'];
$SZ_GROUPS_ENABLE_WIDGET_IFRAME = $options['groups_widget'];

// Impostazioni variabili per attivazione dei shortcodes

if ($SZ_GROUPS_ENABLE_SHORTC_IFRAME == SZ_PLUGIN_GOOGLE_VALUE_YES) add_shortcode('sz-ggroups','sz_google_module_groups_shortcode_iframe');
if ($SZ_GROUPS_ENABLE_WIDGET_IFRAME == SZ_PLUGIN_GOOGLE_VALUE_YES) sz_google_module_widget_create('sz_google_module_groups_widget_iframe');

/* ************************************************************************** */ 
/* Funzione generale per il caricamento e la messa in coerenza delle opzioni  */
/* ************************************************************************** */ 

function sz_google_module_groups_options()
{
	$options = get_option('sz_google_options_groups');

	// Controllo delle opzioni in caso di valori non esistenti
	// richiamo della funzione per il controllo isset()

	$options = sz_google_module_check_values_isset($options,array(
		'groups_widget'      => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'groups_shortcode'   => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'groups_language'    => SZ_PLUGIN_GOOGLE_VALUE_LANG,
		'groups_name'        => SZ_PLUGIN_GOOGLE_GROUPS_NAME,
		'groups_showsearch'  => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'groups_showtabs'    => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'groups_hidetitle'   => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'groups_hidesubject' => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'groups_width'       => SZ_PLUGIN_GOOGLE_GROUPS_WIDTH,
		'groups_height'      => SZ_PLUGIN_GOOGLE_GROUPS_HEIGHT,
	));

	// Controllo delle opzioni in caso di valori non conformi
	// richiamo della funzione per il controllo isnull()

	$options = sz_google_module_check_values_isnull($options,array(
		'groups_language'    => SZ_PLUGIN_GOOGLE_VALUE_LANG,
		'groups_width'       => SZ_PLUGIN_GOOGLE_GROUPS_WIDTH,
		'groups_height'      => SZ_PLUGIN_GOOGLE_GROUPS_HEIGHT,
	));

	// Chiamata alla funzione comune per controllare le variabili che devono avere
	// un valore di YES o NO e nel caso non fosse possibile forzare il valore (NO)

	$options = sz_google_module_check_values_yesno($options,array(
		'groups_widget'      => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'groups_shortcode'   => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'groups_showsearch'  => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'groups_showtabs'    => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'groups_hidetitle'   => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'groups_hidesubject' => SZ_PLUGIN_GOOGLE_VALUE_NO,
	));

	return $options;
}

/* ************************************************************************** */ 
/* Funzione per la generazione di codice legato a google groups               */
/* ************************************************************************** */ 

function sz_google_module_groups_get_code_iframe($atts=array())
{
	$options = sz_google_module_groups_options();

	if ($options['groups_showsearch']  == SZ_PLUGIN_GOOGLE_VALUE_YES) $options['groups_showsearch']  = 'true'; else $options['groups_showsearch']  = 'false';  
	if ($options['groups_showtabs']    == SZ_PLUGIN_GOOGLE_VALUE_YES) $options['groups_showtabs']    = 'true'; else $options['groups_showtabs']    = 'false';  
	if ($options['groups_hidetitle']   == SZ_PLUGIN_GOOGLE_VALUE_YES) $options['groups_hidetitle']   = 'true'; else $options['groups_hidetitle']   = 'false';  
	if ($options['groups_hidesubject'] == SZ_PLUGIN_GOOGLE_VALUE_YES) $options['groups_hidesubject'] = 'true'; else $options['groups_hidesubject'] = 'false';  

	// Se non è specificvata nessuna lingua o quella del tema richiamo
	// la funzione nativa di wordpress per calcolare la lingua di sistema

	if ($options['groups_language'] == SZ_PLUGIN_GOOGLE_VALUE_LANG) $language = substr(get_bloginfo('language'),0,2);	
		else $language = trim($options['groups_language']);

	// Estrazione dei valori specificati nello shortcode, i valori ritornati
	// sono contenuti nei nomi di variabili corrispondenti alla chiave

	if (!is_array($atts)) $atts = array();

	extract(shortcode_atts(array(
		'name'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'width'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'height'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'showsearch'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'showtabs'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'hideforumtitle' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'hidesubject'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'hl'             => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts));

	// Controllo le variabili che devono avere obbligatorio il valore 
	// di true o false, in caso diverso prendo il valore di default specificato 

	$hl             = trim($hl);
	$name           = trim($name);
	$showsearch     = strtolower(trim($showsearch));
	$showtabs       = strtolower(trim($showtabs));
	$hideforumtitle = strtolower(trim($hideforumtitle));
	$hidesubject    = strtolower(trim($hidesubject));

	if (!in_array($showsearch,    array('true','false'))) $showsearch     = $options['groups_showsearch']; 
	if (!in_array($showtabs,      array('true','false'))) $showtabs       = $options['groups_showtabs']; 
	if (!in_array($hideforumtitle,array('true','false'))) $hideforumtitle = $options['groups_hidetitle']; 
	if (!in_array($hidesubject,   array('true','false'))) $hidesubject    = $options['groups_hidesubject']; 

	// Se non sono riuscito ad assegnare nessun valore con le istruzioni
	// precedenti metto dei default assoluti che possono essere cambiati

	if ($name == SZ_PLUGIN_GOOGLE_VALUE_NULL) $name = $options['groups_name'];
	if ($name == SZ_PLUGIN_GOOGLE_VALUE_NULL) $name = SZ_PLUGIN_GOOGLE_GROUPS_NAME;

	// Se non sono riuscito ad assegnare nessun valore con le istruzioni
	// precedenti metto dei default assoluti che possono essere cambiati

	if ($width  == SZ_PLUGIN_GOOGLE_VALUE_NULL or $width  == SZ_PLUGIN_GOOGLE_VALUE_NO or !is_numeric($width))  $width  = $options['groups_width'];
	if ($height == SZ_PLUGIN_GOOGLE_VALUE_NULL or $height == SZ_PLUGIN_GOOGLE_VALUE_NO or !is_numeric($height)) $height = $options['groups_height'];

	if ($width  == SZ_PLUGIN_GOOGLE_VALUE_NULL or $width  == SZ_PLUGIN_GOOGLE_VALUE_NO or !is_numeric($width))  $width  = '100%';
	if ($height == SZ_PLUGIN_GOOGLE_VALUE_NULL or $height == SZ_PLUGIN_GOOGLE_VALUE_NO or !is_numeric($height)) $height = SZ_PLUGIN_GOOGLE_GROUPS_HEIGHT;

	// Creazione identificativo univoco per riconoscere il codice embed 
	// nel caso la funzioine venga richiamata più volte nella stessa pagina

	$unique = md5(uniqid(),false);
	$keyIDs = 'sz-google-groups-'.$unique;

	// Creazione codice HTML per inserimento javascript di google 

	$HTML  = '<iframe id="'.$keyIDs.'" src="javascript:void(0)" scrolling="no" frameborder="0" ';
 	$HTML .= 'width="'.$width.'" ';
	$HTML .= 'height="'.$height.'"';
	$HTML .= '></iframe>';

	$HTML .= '<script type="text/javascript">';
	$HTML .= 'document.getElementById("'.$keyIDs.'").src = "https://groups.google.com/forum/embed/?place=forum/'.$name.'" + ';

	$HTML .=	'"&hl='.$hl.'" + ';
	$HTML .=	'"&showsearch='.$showsearch.'" + ';
	$HTML .=	'"&showtabs='.$showtabs.'" + ';
	$HTML .=	'"&hideforumtitle='.$hideforumtitle.'" + ';
	$HTML .=	'"&hidesubject='.$hidesubject.'" + ';

	$HTML .= '"&showpopout=true" + ';
	$HTML .= '"&parenturl=" + encodeURIComponent(window.location.href);';
	$HTML .= '</script>';

	return $HTML;
}

/* ************************************************************************** */
/* Funzione shortcode per inserimento GOOGLE GROUPS                           */
/* ************************************************************************** */

function sz_google_module_groups_shortcode_iframe($atts,$content=null) 
{
	// Preparazione codice HTML dello shortcode tramite la funzione
	// standard di preparazione codice sia per shortcode che widgets

	return sz_google_module_groups_get_code_iframe(shortcode_atts(array(
		'name'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'width'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'height'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'showsearch'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'showtabs'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'hideforumtitle' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'hidesubject'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'hl'             => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts),$content);
}

/* ************************************************************************** */ 
/* GOOGLE GROUPS IFRAME definizione ed elaborazione del widget su sidebar     */ 
/* ************************************************************************** */ 

class sz_google_module_groups_widget_iframe extends WP_Widget_SZ_Google
{
	// Costruttore principale della classe widget, definizione 
	// delle opzioni legate al widget e al controllo dello stesso

	function __construct() 
	{
		parent::__construct('sz-google-groups-iframe',__('SZ-Google - Groups iframe','szgoogle'),array(
			'classname'   => 'sz-widget-google sz-widget-google-groups sz-widget-google-groups-iframe', 
			'description' => ucfirst(__('widget for google groups iframe','szgoogle'))
		));
	}

	// Funzione per la visualizzazione del widget con lettura parametri
	// di configurazione e preparazione codice HTML da usare nella sidebar

	function widget($args,$instance) 
	{
		// Controllo se esistono le variabili che servono durante l'elaborazione
		// dello script e assegno dei valori di default nel caso non fossero specificati

		$options = $this->common_empty(array(
			'name'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'width'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'height'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'showsearch'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'showtabs'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'hideforumtitle' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'hidesubject'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'hl'             => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'action'         => SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET,
		),$instance);

		// Definizione delle variabili di controllo del widget, questi valori non
		// interessano le opzioni della funzione base ma incidono su alcuni aspetti

		$controls = $this->common_empty(array(
			'width_auto'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'height_auto' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		),$instance);

		// Correzione del valore di dimensione nel caso venga
		// specificata la maniera automatica e quindi usare javascript

		if ($controls['width_auto']  == SZ_PLUGIN_GOOGLE_VALUE_YES) $options['width']  = SZ_PLUGIN_GOOGLE_VALUE_AUTO;
		if ($controls['height_auto'] == SZ_PLUGIN_GOOGLE_VALUE_YES) $options['height'] = SZ_PLUGIN_GOOGLE_VALUE_AUTO;

		// Creazione del codice HTML per il widget attuale richiamando la
		// funzione base che viene richiamata anche dallo shortcode corrispondente

		$HTML = sz_google_module_groups_get_code_iframe($options);

		// Output del codice HTML legato al widget da visualizzare
		// chiamata alla funzione generale per wrap standard

		echo $this->common_widget($args,$instance,$HTML);
	}

	// Funzione per modifica parametri collegati al widget con 
	// memorizzazione dei valori direttamente nel database wordpress

	function update($new_instance,$old_instance) 
	{
		return $this->common_update(array(
			'title'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'name'           => SZ_PLUGIN_GOOGLE_GROUPS_NAME,
			'width'          => SZ_PLUGIN_GOOGLE_GROUPS_WIDTH,
			'width_auto'     => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'height'         => SZ_PLUGIN_GOOGLE_GROUPS_HEIGHT,
			'height_auto'    => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'showsearch'     => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'showtabs'       => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'hideforumtitle' => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'hidesubject'    => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'hl'             => SZ_PLUGIN_GOOGLE_VALUE_LANG,
		),$new_instance,$old_instance);
	}

	// Funzione per la visualizzazione del form presente sulle 
	// sidebar nel pannello di amministrazione di wordpress
	
	function form($instance) 
	{
		$array = array(
			'title'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'name'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'width'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'width_auto'     => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'height'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'height_auto'    => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'showsearch'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'showtabs'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'hideforumtitle' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'hidesubject'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'hl'             => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		);

		// Creazione array per elenco campi da recuperare su FORM

		$instance = wp_parse_args((array) $instance,$array);

		$title          = trim(strip_tags($instance['title']));
		$name           = trim(strip_tags($instance['name']));
		$width          = trim(strip_tags($instance['width']));
		$width_auto     = trim(strip_tags($instance['width_auto']));
		$height         = trim(strip_tags($instance['height']));
		$height_auto    = trim(strip_tags($instance['height_auto']));
		$showsearch     = trim(strip_tags($instance['showsearch']));
		$showtabs       = trim(strip_tags($instance['showtabs']));
		$hideforumtitle = trim(strip_tags($instance['hideforumtitle']));
		$hidesubject    = trim(strip_tags($instance['hidesubject']));
		$hl             = trim(strip_tags($instance['hl']));

		// Richiamo il template per la visualizzazione della
		// parte che riguarda il pannello di amministrazione

		@require(SZ_PLUGIN_GOOGLE_BASENAME_ADMIN_WIDGETS.
			'sz-google-widget-groups-iframe.php');
	}
}
