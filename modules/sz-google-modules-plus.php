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

if ($options['plus_comments_gp_enable']=='1') {
	@require_once(dirname(__FILE__).'/sz-google-modules-plus-comments.php');
}

// Caricamento delle funzioni per G+ REDIRECT

if (	$options['plus_redirect_sign']  == '1' or
		$options['plus_redirect_plus']  == '1' or
		$options['plus_redirect_curl']  == '1' or 
		$options['plus_redirect_flush'] == '0') 
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

	if (!isset($options['plus_profile']))                  $options['plus_profile']               = '';   
	if (!isset($options['plus_page']))                     $options['plus_page']                  = '';   
	if (!isset($options['plus_community']))                $options['plus_community']             = '';   
	if (!isset($options['plus_language']))                 $options['plus_language']              = '99';   

	if (!isset($options['plus_widget_pr_enable']))         $options['plus_widget_pr_enable']      = '0';
	if (!isset($options['plus_widget_pa_enable']))         $options['plus_widget_pa_enable']      = '0';
	if (!isset($options['plus_widget_co_enable']))         $options['plus_widget_co_enable']      = '0';
	if (!isset($options['plus_widget_size_portrait']))     $options['plus_widget_size_portrait']  = '';
	if (!isset($options['plus_widget_size_landscape']))    $options['plus_widget_size_landscape'] = '';

	if (!isset($options['plus_shortcode_pr_enable']))      $options['plus_shortcode_pr_enable']      = '0';
	if (!isset($options['plus_shortcode_pa_enable']))      $options['plus_shortcode_pa_enable']      = '0';
	if (!isset($options['plus_shortcode_co_enable']))      $options['plus_shortcode_co_enable']      = '0';
	if (!isset($options['plus_shortcode_size_portrait']))  $options['plus_shortcode_size_portrait']  = '';
	if (!isset($options['plus_shortcode_size_landscape'])) $options['plus_shortcode_size_landscape'] = '';

	if (!isset($options['plus_button_enable_plusone']))    $options['plus_button_enable_plusone'] = '0';
	if (!isset($options['plus_button_enable_sharing']))    $options['plus_button_enable_sharing'] = '0';
	if (!isset($options['plus_button_enable_follow']))     $options['plus_button_enable_follow']  = '0';

	if (!isset($options['plus_comments_sh_enable']))       $options['plus_comments_sh_enable'] = '0';
	if (!isset($options['plus_comments_gp_enable']))       $options['plus_comments_gp_enable'] = '0';   
	if (!isset($options['plus_comments_gp_enable']))       $options['plus_comments_gp_enable'] = '0';   
	if (!isset($options['plus_comments_wp_enable']))       $options['plus_comments_wp_enable'] = '0';   
	if (!isset($options['plus_comments_ac_enable']))       $options['plus_comments_ac_enable'] = '0';   
	if (!isset($options['plus_comments_aw_enable']))       $options['plus_comments_aw_enable'] = '0';   
	if (!isset($options['plus_comments_dt_enable']))       $options['plus_comments_dt_enable'] = '0';   
	if (!isset($options['plus_comments_dt_day']))          $options['plus_comments_dt_day']    = '01';   
	if (!isset($options['plus_comments_dt_month']))        $options['plus_comments_dt_month']  = '01';   
	if (!isset($options['plus_comments_dt_year']))         $options['plus_comments_dt_year']   = '2000';   

	if (!isset($options['plus_redirect_sign']))            $options['plus_redirect_sign']      = '0';   
	if (!isset($options['plus_redirect_plus']))            $options['plus_redirect_plus']      = '0';   
	if (!isset($options['plus_redirect_curl']))            $options['plus_redirect_curl']      = '0';    
	if (!isset($options['plus_redirect_curl_dir']))        $options['plus_redirect_curl_dir']  = '';    
	if (!isset($options['plus_redirect_curl_url']))        $options['plus_redirect_curl_url']  = '';    
	if (!isset($options['plus_redirect_flush']))           $options['plus_redirect_flush']     = '0';    

	// Controllo delle opzioni in caso di valori non validi

	if (trim($options['plus_language']) == '') 
		$options['plus_language'] = '99';   

	if (trim($options['plus_widget_size_portrait']) =='') 
		$options['plus_widget_size_portrait'] = SZ_PLUGIN_GOOGLE_WIDGET_SIZE_PORTRAIT;

	if (trim($options['plus_widget_size_landscape'])=='') 
		$options['plus_widget_size_landscape'] = SZ_PLUGIN_GOOGLE_WIDGET_SIZE_LANDSCAPE;

	if (trim($options['plus_shortcode_size_portrait']) == '')      
		$options['plus_shortcode_size_portrait'] = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_SIZE_PORTRAIT;

	if (trim($options['plus_shortcode_size_landscape']) == '')     
		$options['plus_shortcode_size_landscape'] = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_SIZE_LANDSCAPE;

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

	$options = sz_google_modules_plus_options();

	if ($options['plus_language']=='99') $language = substr(get_bloginfo('language'),0,2);	
		else $language = trim($options['plus_language']);

	// Codice javascript per il rendering dei componenti google plus
	
	$javascript  = '<script type="text/javascript">';
  	$javascript .= "window.___gcfg = {lang:'".trim($language)."'};";
	$javascript .= "(function() {";
	$javascript .= "var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;";
	$javascript .= "po.src = 'https://apis.google.com/js/plusone.js';";
	$javascript .=  "var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);";
	$javascript .=  "})();";
	$javascript .=	"</script>";
	
	echo $javascript;

	// Definizione costante per segnare che la funzione è stata eseguita
	
	define('SZ_GOOGLE_MODULES_PLUS_ADD_SCRIPT_FOOTER',true);
}