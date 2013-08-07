<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_MODULES') or !SZ_PLUGIN_GOOGLE_MODULES) die();

/* ************************************************************************** */ 
/* Controllo le opzioni per sapere quali componenti risultano attivati        */ 
/* ************************************************************************** */ 

$options = sz_google_modules_groups_options();

if ($options['groups_shortcode'] == '1') { 
	add_shortcode('sz-ggroups','sz_google_shortcodes_groups');
}

/* ************************************************************************** */ 
/* Funzione generale per il caricamento e la messa in coerenza delle opzioni  */
/* ************************************************************************** */ 

function sz_google_modules_groups_options()
{
	$options = get_option('sz_google_options_groups');

	if (!isset($options['groups_widget']))       $options['groups_widget']      = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['groups_shortcode']))    $options['groups_shortcode']   = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['groups_language']))     $options['groups_language']    = SZ_PLUGIN_GOOGLE_VALUE_LANG;
	if (!isset($options['groups_name']))         $options['groups_name']        = SZ_PLUGIN_GOOGLE_GROUPS_NAME;
	if (!isset($options['groups_showsearch']))   $options['groups_showsearch']  = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['groups_showtabs']))     $options['groups_showtabs']    = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['groups_hidetitle']))    $options['groups_hidetitle']   = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['groups_hidesubject']))  $options['groups_hidesubject'] = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['groups_width']))        $options['groups_width']       = SZ_PLUGIN_GOOGLE_GROUPS_WIDTH;
	if (!isset($options['groups_height']))       $options['groups_height']      = SZ_PLUGIN_GOOGLE_GROUPS_HEIGHT;

	// Se codice lingua non specificato assegno il valore di default

	if (trim($options['groups_language']) == '') $options['groups_language']    = SZ_PLUGIN_GOOGLE_VALUE_LANG;
	if (trim($options['groups_width'])    == '') $options['groups_width']       = SZ_PLUGIN_GOOGLE_GROUPS_WIDTH;
	if (trim($options['groups_height'])   == '') $options['groups_height']      = SZ_PLUGIN_GOOGLE_GROUPS_HEIGHT;

	// Se trovo un valore non riconosciuto imposto dei valori predefiniti validi

	$selects = array(SZ_PLUGIN_GOOGLE_VALUE_NO,SZ_PLUGIN_GOOGLE_VALUE_YES);

	if (!in_array($options['groups_widget'],$selects))      $options['groups_widget']      = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['groups_shortcode'],$selects))   $options['groups_shortcode']   = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['groups_showsearch'],$selects))  $options['groups_showsearch']  = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['groups_showtabs'],$selects))    $options['groups_showtabs']    = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['groups_hidetitle'],$selects))   $options['groups_hidetitle']   = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['groups_hidesubject'],$selects)) $options['groups_hidesubject'] = SZ_PLUGIN_GOOGLE_VALUE_NO;

	return $options;
}

/* ************************************************************************** */ 
/* Funzione per la generazione di codice legato a google groups               */
/* ************************************************************************** */ 

function sz_google_modules_groups_get_code($atts=array())
{
	$options = sz_google_modules_groups_options();

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

	// Creazione codice HTML per inserimento javascript di google 

	$HTML  = '<iframe id="forum_embed" src="javascript:void(0)" scrolling="no" frameborder="0" ';
 	$HTML .= 'width="'.$width.'" ';
	$HTML .= 'height="'.$height.'"';
	$HTML .= '></iframe>';

	$HTML .= '<script type="text/javascript">';
	$HTML .= 'document.getElementById("forum_embed").src = "https://groups.google.com/forum/embed/?place=forum/'.$name.'" + ';

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

function sz_google_shortcodes_groups($atts,$content=null) 
{
	// Estrazione dei valori specificati nello shortcode, i valori ritornati
	// sono contenuti nei nomi di variabili corrispondenti alla chiave

	extract(shortcode_atts(array(
		'name'           => '',
		'width'          => '',
		'height'         => '',
		'showsearch'     => '',
		'showtabs'       => '',
		'hideforumtitle' => '',
		'hidesubject'    => '',
		'hl'             => '',
	),$atts));

	// Preparazione codice HTML dello shortcode tramite la funzione
	// standard di preparazione codice sia per shortcode che widgets

	$HTML  = sz_google_modules_groups_get_code(array(
		'name'           => trim($name),
		'width'          => trim($width),
		'height'         => trim($height),
		'showsearch'     => trim($showsearch),
		'showtabs'       => trim($showtabs),
		'hideforumtitle' => trim($hideforumtitle),
		'hidesubject'    => trim($hidesubject),
		'hl'             => trim($hl),
	));

	return $HTML;
}