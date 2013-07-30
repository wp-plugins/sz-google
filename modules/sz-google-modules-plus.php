<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_MODULES') or !SZ_PLUGIN_GOOGLE_MODULES) die();

/* ************************************************************************** */ 
/* Controllo le opzioni generali per saper i moduli che devo essere caricati  */
/* ************************************************************************** */ 

$options = sz_google_modules_plus_options();

// Caricamento delle funzioni per G+ COMMENTS

if ($options['plus_comments_gp_enable'] == SZ_PLUGIN_GOOGLE_VALUE_YES) {
	@require_once(dirname(__FILE__).'/sz-google-modules-plus-comments.php');
}

// Caricamento delle funzioni per G+ REDIRECT

if (	$options['plus_redirect_sign']  == SZ_PLUGIN_GOOGLE_VALUE_YES or
		$options['plus_redirect_plus']  == SZ_PLUGIN_GOOGLE_VALUE_YES or
		$options['plus_redirect_curl']  == SZ_PLUGIN_GOOGLE_VALUE_YES or 
		$options['plus_redirect_flush'] == SZ_PLUGIN_GOOGLE_VALUE_NO) 
{
	@require_once(dirname(__FILE__).'/sz-google-modules-plus-redirect.php');
}

/* ************************************************************************** */ 
/* Funzione generale per il caricamento e la messa in coerenza delle opzioni  */
/* ************************************************************************** */ 

function sz_google_modules_plus_options()
{
	// Caricamento delle opzioni per modulo google plus

	$options = get_option('sz_google_options_plus');

	// Controllo delle opzioni in caso di valori non validi

	if (!isset($options['plus_profile']))                  $options['plus_profile']                  = SZ_PLUGIN_GOOGLE_VALUE_NULL;   
	if (!isset($options['plus_page']))                     $options['plus_page']                     = SZ_PLUGIN_GOOGLE_VALUE_NULL;
	if (!isset($options['plus_community']))                $options['plus_community']                = SZ_PLUGIN_GOOGLE_VALUE_NULL;
	if (!isset($options['plus_language']))                 $options['plus_language']                 = SZ_PLUGIN_GOOGLE_VALUE_LANG;   

	if (!isset($options['plus_widget_pr_enable']))         $options['plus_widget_pr_enable']         = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_widget_pa_enable']))         $options['plus_widget_pa_enable']         = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_widget_co_enable']))         $options['plus_widget_co_enable']         = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_widget_size_portrait']))     $options['plus_widget_size_portrait']     = SZ_PLUGIN_GOOGLE_VALUE_NULL;
	if (!isset($options['plus_widget_size_landscape']))    $options['plus_widget_size_landscape']    = SZ_PLUGIN_GOOGLE_VALUE_NULL;

	if (!isset($options['plus_shortcode_pr_enable']))      $options['plus_shortcode_pr_enable']      = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_shortcode_pa_enable']))      $options['plus_shortcode_pa_enable']      = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_shortcode_co_enable']))      $options['plus_shortcode_co_enable']      = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_shortcode_size_portrait']))  $options['plus_shortcode_size_portrait']  = SZ_PLUGIN_GOOGLE_VALUE_NULL;
	if (!isset($options['plus_shortcode_size_landscape'])) $options['plus_shortcode_size_landscape'] = SZ_PLUGIN_GOOGLE_VALUE_NULL;

	if (!isset($options['plus_button_enable_plusone']))    $options['plus_button_enable_plusone']    = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_button_enable_sharing']))    $options['plus_button_enable_sharing']    = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_button_enable_follow']))     $options['plus_button_enable_follow']     = SZ_PLUGIN_GOOGLE_VALUE_NO;

	if (!isset($options['plus_comments_sh_enable']))       $options['plus_comments_sh_enable']       = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_comments_gp_enable']))       $options['plus_comments_gp_enable']       = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_comments_gp_enable']))       $options['plus_comments_gp_enable']       = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_comments_wp_enable']))       $options['plus_comments_wp_enable']       = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_comments_ac_enable']))       $options['plus_comments_ac_enable']       = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_comments_aw_enable']))       $options['plus_comments_aw_enable']       = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_comments_dt_enable']))       $options['plus_comments_dt_enable']       = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_comments_dt_day']))          $options['plus_comments_dt_day']          = '01';  
	if (!isset($options['plus_comments_dt_month']))        $options['plus_comments_dt_month']        = '01';
	if (!isset($options['plus_comments_dt_year']))         $options['plus_comments_dt_year']         = '2000';

	if (!isset($options['plus_redirect_sign']))            $options['plus_redirect_sign']            = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_redirect_plus']))            $options['plus_redirect_plus']            = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_redirect_curl']))            $options['plus_redirect_curl']            = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_redirect_curl_dir']))        $options['plus_redirect_curl_dir']        = SZ_PLUGIN_GOOGLE_VALUE_NULL;
	if (!isset($options['plus_redirect_curl_url']))        $options['plus_redirect_curl_url']        = SZ_PLUGIN_GOOGLE_VALUE_NULL;
	if (!isset($options['plus_redirect_flush']))           $options['plus_redirect_flush']           = SZ_PLUGIN_GOOGLE_VALUE_NO;

	if (!isset($options['plus_system_javascript']))        $options['plus_system_javascript']        = SZ_PLUGIN_GOOGLE_VALUE_NO;

	// Controllo delle opzioni in caso di valori non validi

	if (trim($options['plus_language'])                 == SZ_PLUGIN_GOOGLE_VALUE_NULL) $options['plus_language']                 = SZ_PLUGIN_GOOGLE_VALUE_LANG;   
	if (trim($options['plus_widget_size_portrait'])     == SZ_PLUGIN_GOOGLE_VALUE_NULL) $options['plus_widget_size_portrait']     = SZ_PLUGIN_GOOGLE_WIDGET_SIZE_PORTRAIT;
	if (trim($options['plus_widget_size_landscape'])    == SZ_PLUGIN_GOOGLE_VALUE_NULL) $options['plus_widget_size_landscape']    = SZ_PLUGIN_GOOGLE_WIDGET_SIZE_LANDSCAPE;
	if (trim($options['plus_shortcode_size_portrait'])  == SZ_PLUGIN_GOOGLE_VALUE_NULL) $options['plus_shortcode_size_portrait']  = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_SIZE_PORTRAIT;
	if (trim($options['plus_shortcode_size_landscape']) == SZ_PLUGIN_GOOGLE_VALUE_NULL) $options['plus_shortcode_size_landscape'] = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_SIZE_LANDSCAPE;

	return $options;
}

/* ************************************************************************** */ 
/* Scrittura del codice javascript necessario alla visualizzazione widgets    */
/* ************************************************************************** */ 

function sz_google_modules_plus_add_script_footer()
{
	// Se sono già entrato in questa funzione non eseguo niente
	
	if (defined('SZ_GOOGLE_MODULES_PLUS_ADD_SCRIPT_FOOTER')) return;
	
	// Controllo opzioni per linguaggio impostato o tema o specifico

	define('SZ_GOOGLE_MODULES_PLUS_ADD_SCRIPT_FOOTER',true);

	$options = sz_google_modules_plus_options();

	if ($options['plus_system_javascript'] == SZ_PLUGIN_GOOGLE_VALUE_YES) return;	

	if ($options['plus_language'] == SZ_PLUGIN_GOOGLE_VALUE_LANG) $language = substr(get_bloginfo('language'),0,2);	
		else $language = trim($options['plus_language']);

	// Codice javascript per il rendering dei componenti google plus
	
	$javascript  = '<script type="text/javascript">';
  	$javascript .= "window.___gcfg = {lang:'".trim($language)."'};";
	$javascript .= "(function() {";
	$javascript .= "var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;";
	$javascript .= "po.src = 'https://apis.google.com/js/plusone.js';";
	$javascript .=  "var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);";
	$javascript .=  "})();";
	$javascript .=	"</script>"."\n";
	
	echo $javascript;
}
