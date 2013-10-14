<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_MODULE') or !SZ_PLUGIN_GOOGLE_MODULE) die();

/* ************************************************************************** */ 
/* Controllo le opzioni generali per saper i moduli che devo essere caricati  */
/* ************************************************************************** */ 

$options = sz_google_module_analytics_options();

// Impostazioni variabili per attivazione dei controlli

$SZ_GA_ENABLE_FRONT_END = $options['ga_enable_front'];
$SZ_GA_ENABLE_POSITION  = $options['ga_position'];

// Se sono sul front end aggiungo azione header o footer in
// base a quello che è stato specificato nell'opzione di configurazione 

if (!is_admin() and $SZ_GA_ENABLE_FRONT_END == SZ_PLUGIN_GOOGLE_VALUE_YES)
{
	if ($SZ_GA_ENABLE_POSITION == SZ_PLUGIN_GOOGLE_GA_HEADER) add_action('wp_head'  ,'sz_google_module_analytics_add_script');
	if ($SZ_GA_ENABLE_POSITION == SZ_PLUGIN_GOOGLE_GA_FOOTER) add_action('wp_footer','sz_google_module_analytics_add_script');
}

/* ************************************************************************** */ 
/* Funzione generale per il caricamento e la messa in coerenza delle opzioni  */
/* ************************************************************************** */ 

function sz_google_module_analytics_options()
{
	$options = get_option('sz_google_options_ga');

	// Controllo delle opzioni in caso di valori non esistenti
	// richiamo della funzione per il controllo isset()

	$options = sz_google_module_check_values_isset($options,array(
		'ga_uacode'               => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'ga_position'             => SZ_PLUGIN_GOOGLE_GA_HEADER,
		'ga_enable_front'         => SZ_PLUGIN_GOOGLE_VALUE_YES,
		'ga_enable_admin'         => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'ga_enable_administrator' => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'ga_enable_logged'        => SZ_PLUGIN_GOOGLE_VALUE_NO,
	));

	// Chiamata alla funzione comune per controllare le variabili che devono avere
	// un valore di YES o NO e nel caso non fosse possibile forzare il valore (NO)

	$options = sz_google_module_check_values_yesno($options,array(
		'ga_enable_front'         => SZ_PLUGIN_GOOGLE_VALUE_YES,
		'ga_enable_admin'         => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'ga_enable_administrator' => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'ga_enable_logged'        => SZ_PLUGIN_GOOGLE_VALUE_NO,
	));

	return $options;
}

/* ************************************************************************** */ 
/* Scrittura del codice javascript necessario alla visualizzazione widgets    */
/* ************************************************************************** */ 

function sz_google_module_analytics_add_script() {
	echo sz_google_module_analytics_get_code();
}

/* ************************************************************************** */ 
/* Scrittura del codice javascript necessario alla visualizzazione widgets    */
/* ************************************************************************** */ 

function sz_google_module_analytics_get_ID()
{
	$options = sz_google_module_analytics_options();
	$guacode = trim($options['ga_uacode']);   

	return $guacode;
}

/* ************************************************************************** */ 
/* Scrittura del codice javascript necessario alla visualizzazione widgets    */
/* ************************************************************************** */ 

function sz_google_module_analytics_get_code()
{
	$useract = true;
	$options = sz_google_module_analytics_options();
	$guacode = sz_google_module_analytics_get_ID();   

	// Controllo se sono loggato come amministratore o utente registrato
	// e disattivo il caricamento del codice se le opzioni sono disattivate 

	if (current_user_can('manage_options')) {
		if ($options['ga_enable_administrator'] == SZ_PLUGIN_GOOGLE_VALUE_NO) $useract = false;
	} else {
		if (is_user_logged_in() and $options['ga_enable_logged'] == SZ_PLUGIN_GOOGLE_VALUE_NO) $useract = false;   
	}

	// Controllo se sono in backend o frontend e abilito l'esecuzione del codice
	// solo se le opzioni corrispondenti sono state attivate in configurazione

	if ( is_admin() and $options['ga_enable_admin'] == SZ_PLUGIN_GOOGLE_VALUE_NO) $useract = false;
	if (!is_admin() and $options['ga_enable_front'] == SZ_PLUGIN_GOOGLE_VALUE_NO) $useract = false;

	// Creazione codice di google analytics da inserire su pagina HTML 

	if ($useract and strlen($guacode) > 0)
	{
		$HTML  = '<script type="text/javascript">//<![CDATA['."\n";
		$HTML .= "// SZ-Google ".SZ_PLUGIN_GOOGLE_VERSION." module for Google Analytics => ".SZ_PLUGIN_GOOGLE_REPOSITORY."\n";
		$HTML .= "var _gaq = _gaq || [];"."\n";
		$HTML .= "_gaq.push(['_setAccount','".$guacode."']);"."\n";
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
	
		return $HTML;
	}

	return false;
}