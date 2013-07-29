<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

/* ************************************************************************** */
/* Definizione costanti che devo essere comuni a tutti i file admin           */
/* ************************************************************************** */

define('SZ_PLUGIN_GOOGLE_SHORTCODES',true);
define('SZ_PLUGIN_GOOGLE_SHORTCODES_BASENAME',basename(__FILE__));

/* ************************************************************************** */ 
/* Controllo le opzioni generali per saper i moduli che devo essere caricati  */
/* ************************************************************************** */ 

$options_shortcodes = sz_google_modules_options();

if ($options_shortcodes['plus'] == '1') {
	@require_once(dirname(__FILE__).'/sz-google-shortcodes-plus.php');
}

if ($options_shortcodes['translate'] == '1') {
	@require_once(dirname(__FILE__).'/sz-google-shortcodes-translate.php');
}
