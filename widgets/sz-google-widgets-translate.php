<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_WIDGETS') or !SZ_PLUGIN_GOOGLE_WIDGETS) die();

/* ************************************************************************** */ 
/* Controllo le opzioni per sapere quali widgets risultano attivati           */ 
/* ************************************************************************** */ 

$widget_options = sz_google_modules_translate_options();

// Attivazione Widget per GOOGLE TRANSLATE

if ($widget_options['translate_widget']=='1') { 
	@require_once(dirname(__FILE__).'/sz-google-widgets-translate-selector.php');
}
