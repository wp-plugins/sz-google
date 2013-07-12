<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_MODULES') or !SZ_PLUGIN_GOOGLE_MODULES) die();

/* ************************************************************************** */
/* Aggiungo le regole di rewrite per il modulo di google plus                 */
/* ************************************************************************** */

function sz_google_modules_plus_rewrite_rules() 
{
	global $wp; 
	$options = sz_google_modules_plus_options();

	// Controllo REDIRECT per url con la stringa "+"

	if ($options['plus_redirect_sign'] == '1') {
		add_rewrite_rule('^\+$','index.php?szgoogleplusredirectsign=1','top');		
		$wp->add_query_var('szgoogleplusredirectsign');
	}   

	// Controllo REDIRECT per url con la stringa "plus"

	if ($options['plus_redirect_plus'] == '1') {
		add_rewrite_rule('^plus$','index.php?szgoogleplusredirectplus=1','top');		
		$wp->add_query_var('szgoogleplusredirectplus');
	}   

	// Controllo REDIRECT per url con la stringa "URL"

	if ($options['plus_redirect_curl'] == '1') {
		if (trim($options['plus_redirect_curl_dir']) <> '' and trim($options['plus_redirect_curl_url']) <> '') {
			add_rewrite_rule('^'. preg_quote(trim($options['plus_redirect_curl_dir'])).'$','index.php?szgoogleplusredirectcurl=1','top');		
			$wp->add_query_var('szgoogleplusredirectcurl');
		}
	}   

	// Se opzione di flush è disattivata eseguo il flush_rules ed eseguo
	// la modifica dell'opzione al valore "1" per non ripetere l'operazione

	if ($options['plus_redirect_flush'] == '0') 
	{
		$options['plus_redirect_flush'] = '1';    
		update_option('sz_google_options_plus',$options);
		add_action('wp_loaded','sz_google_modules_flush_rules');
	}

	// Aggiungo variabile QUERY URL e controllo personalizzato di redirect
	
	add_action('parse_request','sz_google_modules_plus_parse_query');
}

add_action('init','sz_google_modules_plus_rewrite_rules');

/* ************************************************************************** */
/* Controllo le variabili su URL ed eseguo redirect se necessario             */
/* ************************************************************************** */

function sz_google_modules_plus_parse_query(&$wp)
{
	$options = sz_google_modules_plus_options();

	// Controllo REDIRECT per url con la stringa "+"

	if (array_key_exists('szgoogleplusredirectsign',$wp->query_vars)) {
		if (trim($options['plus_redirect_sign_url']) <> '') {   
			header("location:".trim($options['plus_redirect_sign_url'])); exit();
		}
	}

	// Controllo REDIRECT per url con la stringa "plus"
	
	if (array_key_exists('szgoogleplusredirectplus',$wp->query_vars)) {
		if (trim($options['plus_redirect_plus_url']) <> '') {   
			header("location:".trim($options['plus_redirect_plus_url'])); exit();
		}
	}

	// Controllo REDIRECT per url con la stringa "URL"
	
	if (array_key_exists('szgoogleplusredirectcurl',$wp->query_vars)) {
		if (trim($options['plus_redirect_curl_url']) <> '') {   
			header("location:".trim($options['plus_redirect_curl_url'])); exit();
		}
	}

}
