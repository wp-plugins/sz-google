<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_SHORTCODES') or !SZ_PLUGIN_GOOGLE_SHORTCODES) die();

/* ************************************************************************** */
/* Funzione shortcode per inserimento G+ BADGE su COMMUNITY                   */
/* ************************************************************************** */

function sz_google_shortcodes_plus_comments($atts,$content=null) 
{
	/* Estrazione del valore URL dal codice shortcode */

	extract(shortcode_atts(array(
		'url'    => '',
		'width'  => '',
	),$atts));

	// Esecuzione trim su valori specificati su shortcode

	$url    = trim($url);
	$width  = strtolower(trim($width));

	// Imposto i valori di default nel caso siano specificati dei valori
	// che non appartengono al range dei valori accettati

	if ($url == '') $url = get_permalink();

	// Creazione codice univoco per l'inserimento del box commenti		 

	$uniqueID = 'sz-google-comments-'.md5(uniqid(),false);

	// Creazione codice HTML per inserimento widget commenti		 
	
	if (!is_numeric($width) or $width == '') 
	{ 
		$HTML  = '<div id="'.$uniqueID.'" class="sz-google-comments-wrap">';
		$HTML .= '<script type="text/javascript">';
		$HTML .= "var w=document.getElementById('".$uniqueID."').offsetWidth;";
		$HTML .= "document.write('".'<div class="g-comments" data-href="'.$url.'" data-width="'."'+w+'".'" data-height="50" data-first_party_property="BLOGGER" data-view_type="FILTERED_POSTMOD"></div>'."');";
		$HTML .= '</script>';
		$HTML .= '</div>';

	} else {

		$HTML  = '<div id="'.$uniqueID.'" class="sz-google-comments-wrap">';
		$HTML .= '<script type="text/javascript">';
		$HTML .= "var w=document.getElementById('".$uniqueID."').offsetWidth;";
		$HTML .= "document.write('".'<div class="g-comments" data-href="'.$url.'" data-width="'.$width.'" data-height="50" data-first_party_property="BLOGGER" data-view_type="FILTERED_POSTMOD"></div>'."');";
		$HTML .= '</script>';
		$HTML .= '</div>';
	}

	// Aggiunta del codice javascript per il rendering dei widget		 
	// Questo codice viene aggiungo anche dalla sidebar però viene inserito una sola volta

	add_action('wp_footer','sz_google_modules_plus_add_script_footer');

	// Ritorno il codice HTML generato dalla funzione		 

	return $HTML;
}

/* ************************************************************************** */
/* Aggiungo codice per esecuzione dello shortcode appena definito             */
/* ************************************************************************** */

add_shortcode('sz-gplus-comments','sz_google_shortcodes_plus_comments');
