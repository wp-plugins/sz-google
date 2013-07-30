<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_SHORTCODES') or !SZ_PLUGIN_GOOGLE_SHORTCODES) die();

/* ************************************************************************** */ 
/* Controllo le opzioni per sapere quali widgets risultano attivati           */ 
/* ************************************************************************** */ 

$options_shortcode = sz_google_modules_groups_options();

// Attivazione shortcode per GOOGLE GROUPS SHORTCODE 

if ($options_shortcode['groups_shortcode'] == '1') { 
	@require_once(dirname(__FILE__).'/sz-google-shortcodes-groups-embed.php');
}
