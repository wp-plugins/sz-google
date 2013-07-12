<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_WIDGETS') or !SZ_PLUGIN_GOOGLE_WIDGETS) die();

/* ************************************************************************** */ 
/* Controllo le opzioni per sapere quali widgets risultano attivati           */ 
/* ************************************************************************** */ 

$options = sz_google_modules_plus_options();

// Attivazione Widget per G+ BADGE PROFILE

if ($options['plus_widget_pr_enable']=='1') { 
	@require_once(dirname(__FILE__).'/sz-google-widgets-plus-profile.php');
}

// Attivazione Widget per G+ BADGE PAGINA

if ($options['plus_widget_pa_enable']=='1') { 
	@require_once(dirname(__FILE__).'/sz-google-widgets-plus-page.php');
}

// Attivazione Widget per G+ BADGE COMMUNITY

if ($options['plus_widget_co_enable']=='1') { 
	@require_once(dirname(__FILE__).'/sz-google-widgets-plus-community.php');
}

// Attivazione Widget per G+ BADGE COMMENTS

if ($options['plus_comments_wd_enable']=='1') { 
	@require_once(dirname(__FILE__).'/sz-google-widgets-plus-comments.php');
}
