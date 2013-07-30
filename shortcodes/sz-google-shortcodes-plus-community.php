<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_SHORTCODES') or !SZ_PLUGIN_GOOGLE_SHORTCODES) die();

/* ************************************************************************** */
/* Funzione shortcode per inserimento G+ BADGE su COMMUNITY                   */
/* ************************************************************************** */

function sz_google_shortcodes_plus_community($atts,$content=null) 
{
	/* Estrazione del valore URL dal codice shortcode */

	extract(shortcode_atts(array(
		'id'     => SZ_PLUGIN_GOOGLE_PLUS_ID_COMMUNITY,
		'width'  => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_WIDTH,
		'layout' => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_LAYOUT,
		'theme'  => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_THEME,
		'photo'  => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_PHOTO,
		'owner'  => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_OWNER,
	),$atts));

	// Esecuzione trim su valori specificati su shortcode

	$id     = trim($id);
	$width  = strtolower(trim($width));
	$layout = strtolower(trim($layout));
	$theme  = strtolower(trim($theme));
	$photo  = strtolower(trim($photo));
	$owner  = strtolower(trim($owner));

	// Lettura opzioni generali per impostazione dei dati di default

	$options = sz_google_modules_plus_options();

	// Imposto i valori di default nel caso siano specificati dei valori
	// che non appartengono al range dei valori accettati

	if ($id == '') { 
		$id = SZ_PLUGIN_GOOGLE_PLUS_ID_COMMUNITY; 
	}

	if ($layout <> 'portrait' and $layout <> 'landscape') { 
		$layout = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_LAYOUT; 
	} 

	if ($theme <> 'light' and $theme <> 'dark') { 
		$theme = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_THEME; 
	} 

	if ($photo <> 'true' and $photo <> 'false') { $photo = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_PHOTO; } 
	if ($owner <> 'true' and $owner <> 'false') { $owner = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_OWNER; } 

	// Controllo il valore per dimensione widget

	if (!is_numeric($width) or $width == '') { 
		if ($layout == 'portrait') $width = $options['plus_shortcode_size_portrait'];
			else $width = $options['plus_shortcode_size_landscape']; 
	}

	// Preparazione codice HTML per il badge di google plus

	$HTML  = '<div class="g-community"';
	$HTML .= ' data-href="https://plus.google.com/communities/'.$id.'"';
	$HTML .= ' data-width="'     .$width  .'"';
	$HTML .= ' data-layout="'    .$layout.'"';
	$HTML .= ' data-theme="'     .$theme .'"';
	$HTML .= ' data-showphoto="' .$photo .'"';
	$HTML .= ' data-showowners="'.$owner .'"';
	$HTML .= '></div>';

	// Aggiunta del codice javascript per il rendering dei widget		 

	add_action('wp_footer','sz_google_modules_plus_add_script_footer');

	// Ritorno il codice HTML generato dalla funzione		 

	return $HTML;
}

/* ************************************************************************** */
/* Aggiungo codice per esecuzione dello shortcode appena definito             */
/* ************************************************************************** */

add_shortcode('sz-gplus-community','sz_google_shortcodes_plus_community');
