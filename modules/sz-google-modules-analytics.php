<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_MODULES') or !SZ_PLUGIN_GOOGLE_MODULES) die();

/* ************************************************************************** */ 
/* Controllo le opzioni generali per saper i moduli che devo essere caricati  */
/* ************************************************************************** */ 

$jactive = true;
$options = sz_google_modules_analytics_options();

// Controllo se sono loggato come amministratore o utente registrato
// e disattivo il caricamento del codice se le opzioni sono disattivate 

if (current_user_can('manage_options')) {
	if ($options['ga_enable_administrator'] == '0') $jactive = false;
} else {
	if (is_user_logged_in() and $options['ga_enable_logged'] == '0') $jactive = false;   
}
 
// Se sono sul front end aggiungo azione header o footer in
// base a quello che è stato specificato nell'opzione di configurazione 

if (!is_admin() and $jactive)
{
	if ($options['ga_position'] == 'H') add_action('wp_head'  ,'sz_google_modules_analytics_add_script');
	if ($options['ga_position'] == 'F') add_action('wp_footer','sz_google_modules_analytics_add_script');
}

/* ************************************************************************** */ 
/* Funzione generale per il caricamento e la messa in coerenza delle opzioni  */
/* ************************************************************************** */ 

function sz_google_modules_analytics_options()
{
	// Caricamento delle opzioni per modulo google analytics 

	$options = get_option('sz_google_options_ga');

	// Controllo delle opzioni in caso di valori non validi

	if (!isset($options['ga_uacode']))               $options['ga_uacode']               = '';   
	if (!isset($options['ga_position']))             $options['ga_position']             = 'H';   
	if (!isset($options['ga_enable_admin']))         $options['ga_enable_admin']         = '0';   
	if (!isset($options['ga_enable_administrator'])) $options['ga_enable_administrator'] = '0';   
	if (!isset($options['ga_enable_logged']))        $options['ga_enable_logged']        = '0';   

	return $options;
}

/* ************************************************************************** */ 
/* Scrittura del codice javascript necessario alla visualizzazione widgets    */
/* ************************************************************************** */ 

function sz_google_modules_analytics_add_script()
{
	// Caricamento delle opzioni per modulo google analytics 

	$options = sz_google_modules_analytics_options();
	$uacode  = trim($options['ga_uacode']);   
	
	// Creazione codice di google analytics da inserire su pagina HTML 

	if (strlen($uacode) > 0) 
	{
		$HTML  = '<script type="text/javascript">//<![CDATA['."\n";
		$HTML .= "// SZ-Google V".SZ_PLUGIN_GOOGLE_VERSION." module for Google Analytics => ".SZ_PLUGIN_GOOGLE_REPOSITORY."\n";
		$HTML .= "var _gaq = _gaq || [];"."\n";
		$HTML .= "_gaq.push(['_setAccount','".$uacode."']);"."\n";
		$HTML .= "_gaq.push(['_trackPageview']);"."\n";
		$HTML .= "(function () {"."\n";
		$HTML .= "var ga = document.createElement('script');"."\n";
		$HTML .= "ga.type = 'text/javascript';"."\n";
		$HTML .= "ga.async = true;"."\n";
		$HTML .= "ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';"."\n";
		$HTML .= "var s = document.getElementsByTagName('script')[0];"."\n";
		$HTML .= "s.parentNode.insertBefore(ga, s);"."\n";
		$HTML .= "})();"."\n";
		$HTML .= "//]]></script>"."\n";
	
		echo $HTML;
	}
}
