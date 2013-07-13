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

$options = sz_google_modules_options();

if ($options['plus']=='1') {
	@require_once(dirname(__FILE__).'/sz-google-modules-plus.php');
}

/* ************************************************************************** */ 
/* Funzione generale per il caricamento e la messa in coerenza delle opzioni  */
/* ************************************************************************** */ 

function sz_google_modules_options()
{
	$options = get_option('sz_google_options_base');

	if (!isset($options['plus'])) $options['plus'] = '0';

	return $options;
}

/* ************************************************************************** */
/* Funzione per esecuzione operazione di flush_rules su regole rewrite        */
/* ************************************************************************** */

function sz_google_modules_flush_rules() {
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}
