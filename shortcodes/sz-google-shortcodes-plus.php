<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_SHORTCODES') or !SZ_PLUGIN_GOOGLE_SHORTCODES) die();

/* ************************************************************************** */ 
/* Controllo le opzioni per sapere quali widgets risultano attivati           */ 
/* ************************************************************************** */ 

$options_shortcode = sz_google_modules_plus_options();

// Attivazione shortcode per GOOGLE PLUS 

if ($options_shortcode['plus_shortcode_pr_enable']   =='1') @require_once(dirname(__FILE__).'/sz-google-shortcodes-plus-profile.php');
if ($options_shortcode['plus_shortcode_pa_enable']   =='1') @require_once(dirname(__FILE__).'/sz-google-shortcodes-plus-page.php');
if ($options_shortcode['plus_shortcode_co_enable']   =='1') @require_once(dirname(__FILE__).'/sz-google-shortcodes-plus-community.php');
if ($options_shortcode['plus_button_enable_plusone'] =='1') @require_once(dirname(__FILE__).'/sz-google-shortcodes-plus-plusone.php');
if ($options_shortcode['plus_button_enable_sharing'] =='1') @require_once(dirname(__FILE__).'/sz-google-shortcodes-plus-sharing.php');
if ($options_shortcode['plus_button_enable_follow']  =='1') @require_once(dirname(__FILE__).'/sz-google-shortcodes-plus-follow.php');
if ($options_shortcode['plus_comments_sh_enable']    =='1') @require_once(dirname(__FILE__).'/sz-google-shortcodes-plus-comments.php');
