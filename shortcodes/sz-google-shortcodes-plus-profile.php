<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_SHORTCODES') or !SZ_PLUGIN_GOOGLE_SHORTCODES) die();

/* ************************************************************************** */
/* Funzione shortcode per inserimento G+ BADGE su PROFILO                     */
/* ************************************************************************** */

function sz_google_shortcodes_plus_profile($atts,$content=null) 
{
	/* Estrazione del valore URL dal codice shortcode */

	extract(shortcode_atts(array(
		'id'      => SZ_PLUGIN_GOOGLE_PLUS_ID_PROFILE,
		'width'   => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_WIDTH,
		'layout'  => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_LAYOUT,
		'theme'   => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_THEME,
		'cover'   => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_COVER,
		'tagline' => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_TAGLINE,
		'author'  => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_AUTHOR,
	),$atts));

	// Esecuzione trim su valori specificati su shortcode

	$id      = trim($id);
	$width   = strtolower(trim($width));
	$layout  = strtolower(trim($layout));
	$theme   = strtolower(trim($theme));
	$cover   = strtolower(trim($cover));
	$tagline = strtolower(trim($tagline));
	$author  = strtolower(trim($author));

	// Lettura opzioni generali per impostazione dei dati di default

	$options = sz_google_modules_plus_options();

	// Imposto i valori di default nel caso siano specificati dei valori
	// che non appartengono al range dei valori accettati

	if ($id == '') { 
		$id = SZ_PLUGIN_GOOGLE_PLUS_ID_PROFILE; $author = 'false'; 
	}

	if ($layout <> 'portrait' and $layout <> 'landscape') { 
		$layout = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_LAYOUT; 
	} 

	if ($theme <> 'light' and $theme <> 'dark') { 
		$theme = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_THEME; 
	} 

	if ($cover   <> 'true' and $cover   <> 'false') { $cover   = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_COVER; } 
	if ($tagline <> 'true' and $tagline <> 'false') { $tagline = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_TAGLINE; } 
	if ($author  <> 'true' and $author  <> 'false') { $author  = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_AUTHOR; } 

	// Controllo il valore per dimensione widget

	if (!is_numeric($width) or $width == '') { 
		if ($layout == 'portrait') $width = $options['plus_shortcode_size_portrait'];
			else $width = $options['plus_shortcode_size_landscape']; 
	}

	// Preparazione codice HTML per il badge di google plus

	$HTML  = '<div class="g-person"';
	$HTML .= ' data-href="https://plus.google.com/'.$id.'"';
	$HTML .= ' data-width="'         .$width  .'"';
	$HTML .= ' data-layout="'        .$layout .'"';
	$HTML .= ' data-theme="'         .$theme  .'"';
	$HTML .= ' data-showcoverphoto="'.$cover  .'"';
	$HTML .= ' data-showtagline="'   .$tagline.'"';

	if ($author == 'true') {		
		$HTML .= ' data-rel="author"';
	}

	$HTML .= '></div>';

	// Aggiunta del codice javascript per il rendering dei widget		 

	add_action('wp_footer','sz_google_modules_plus_add_script_footer');

	// Ritorno il codice HTML generato dalla funzione		 

	return $HTML;
}

/* ************************************************************************** */
/* Aggiungo codice per esecuzione dello shortcode appena definito             */
/* ************************************************************************** */

add_shortcode('sz-gplus-profile','sz_google_shortcodes_plus_profile');
