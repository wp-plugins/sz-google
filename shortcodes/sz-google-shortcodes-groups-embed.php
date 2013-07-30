<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_SHORTCODES') or !SZ_PLUGIN_GOOGLE_SHORTCODES) die();

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

/* ************************************************************************** */
/* Aggiungo codice per esecuzione dello shortcode appena definito             */
/* ************************************************************************** */

add_shortcode('sz-ggroups','sz_google_shortcodes_groups');
