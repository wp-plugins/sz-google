<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_SHORTCODES') or !SZ_PLUGIN_GOOGLE_SHORTCODES) die();

/* ************************************************************************** */ 
/* Controllo le opzioni per sapere quali widgets risultano attivati           */ 
/* ************************************************************************** */ 

$options = sz_google_modules_plus_options();

// Attivazione shortcode per G+ BADGE PROFILO 

if ($options['plus_shortcode_pr_enable']=='1') { 
	@require_once(dirname(__FILE__).'/sz-google-shortcodes-plus-profile.php');
}

// Attivazione shortcode per G+ BADGE PAGINA 

if ($options['plus_shortcode_pa_enable']=='1') { 
	@require_once(dirname(__FILE__).'/sz-google-shortcodes-plus-page.php');
}

// Attivazione shortcode per G+ BADGE COMMUNITY 

if ($options['plus_shortcode_co_enable']=='1') { 
	@require_once(dirname(__FILE__).'/sz-google-shortcodes-plus-community.php');
}

// Attivazione shortcode per bottone +1

if ($options['plus_button_enable_plusone']=='1') { 
	@require_once(dirname(__FILE__).'/sz-google-shortcodes-plus-plusone.php');
}

// Attivazione shortcode per bottone G+ CONDIVISIONE 

if ($options['plus_button_enable_sharing']=='1') { 
	@require_once(dirname(__FILE__).'/sz-google-shortcodes-plus-sharing.php');
}

// Attivazione shortcode per bottone G+ FOLLOW 

if ($options['plus_button_enable_follow']=='1') { 
	@require_once(dirname(__FILE__).'/sz-google-shortcodes-plus-follow.php');
}

// Attivazione shortcode per G+ COMMENTI 

if ($options['plus_comments_sh_enable']=='1') { 
	@require_once(dirname(__FILE__).'/sz-google-shortcodes-plus-comments.php');
}
