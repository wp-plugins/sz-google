<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

/* ************************************************************************** */
/* Definizione costanti che devo essere comuni a tutti i file modules         */
/* ************************************************************************** */

define('SZ_PLUGIN_GOOGLE_MODULES',true);
define('SZ_PLUGIN_GOOGLE_MODULES_BASENAME',basename(__FILE__));

/* ************************************************************************** */ 
/* Controllo le opzioni generali per sapere i moduli da caricare              */
/* ************************************************************************** */ 

$options_modules = sz_google_modules_options();

if ($options_modules['plus']      == SZ_PLUGIN_GOOGLE_VALUE_YES) @require_once(dirname(__FILE__).'/sz-google-modules-plus.php');
if ($options_modules['analytics'] == SZ_PLUGIN_GOOGLE_VALUE_YES) @require_once(dirname(__FILE__).'/sz-google-modules-analytics.php');
if ($options_modules['groups']    == SZ_PLUGIN_GOOGLE_VALUE_YES) @require_once(dirname(__FILE__).'/sz-google-modules-groups.php');
if ($options_modules['translate'] == SZ_PLUGIN_GOOGLE_VALUE_YES) @require_once(dirname(__FILE__).'/sz-google-modules-translate.php');

/* ************************************************************************** */ 
/* Funzione generale per il caricamento e la messa in coerenza delle opzioni  */
/* ************************************************************************** */ 

function sz_google_modules_options()
{
	$options = get_option('sz_google_options_base');

	if (!isset($options['plus']))      $options['plus']      = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['analytics'])) $options['analytics'] = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['groups']))    $options['groups']    = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['translate'])) $options['translate'] = SZ_PLUGIN_GOOGLE_VALUE_NO;

	return $options;
}

/* ************************************************************************** */
/* Funzione per esecuzione operazione di flush_rules su regole rewrite        */
/* ************************************************************************** */

function sz_google_modules_flush_rules() {
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}
