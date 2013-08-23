<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_MODULES') or !SZ_PLUGIN_GOOGLE_MODULES) die();

/* ************************************************************************** */ 
/* Controllo le opzioni generali per saper i moduli che devo essere caricati  */
/* ************************************************************************** */ 

$options = sz_google_modules_plus_options();

if ($options['plus_comments_gp_enable'] == SZ_PLUGIN_GOOGLE_VALUE_YES) {
	add_action('init','sz_google_modules_comments_system_enable');
}

if (	$options['plus_redirect_sign']  == SZ_PLUGIN_GOOGLE_VALUE_YES or
		$options['plus_redirect_plus']  == SZ_PLUGIN_GOOGLE_VALUE_YES or
		$options['plus_redirect_curl']  == SZ_PLUGIN_GOOGLE_VALUE_YES or 
		$options['plus_redirect_flush'] == SZ_PLUGIN_GOOGLE_VALUE_NO) 
{
		add_action('init','sz_google_modules_plus_rewrite_rules');
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

	// Se trovo un valore non riconosciuto imposto dei valori predefiniti validi

	$selects = array(SZ_PLUGIN_GOOGLE_VALUE_NO,SZ_PLUGIN_GOOGLE_VALUE_YES);

	if (!in_array($options['plus_widget_pr_enable'],$selects))      $options['plus_widget_pr_enable']      = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_widget_pa_enable'],$selects))      $options['plus_widget_pa_enable']      = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_widget_co_enable'],$selects))      $options['plus_widget_co_enable']      = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_shortcode_pr_enable'],$selects))   $options['plus_shortcode_pr_enable']   = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_shortcode_pa_enable'],$selects))   $options['plus_shortcode_pa_enable']   = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_shortcode_co_enable'],$selects))   $options['plus_shortcode_co_enable']   = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_button_enable_plusone'],$selects)) $options['plus_button_enable_plusone'] = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_button_enable_sharing'],$selects)) $options['plus_button_enable_sharing'] = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_button_enable_follow'],$selects))  $options['plus_button_enable_follow']  = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_comments_sh_enable'],$selects))    $options['plus_comments_sh_enable']    = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_comments_gp_enable'],$selects))    $options['plus_comments_gp_enable']    = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_comments_gp_enable'],$selects))    $options['plus_comments_gp_enable']    = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_comments_wp_enable'],$selects))    $options['plus_comments_wp_enable']    = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_comments_ac_enable'],$selects))    $options['plus_comments_ac_enable']    = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_comments_aw_enable'],$selects))    $options['plus_comments_aw_enable']    = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_comments_dt_enable'],$selects))    $options['plus_comments_dt_enable']    = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_redirect_sign'],$selects))         $options['plus_redirect_sign']         = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_redirect_plus'],$selects))         $options['plus_redirect_plus']         = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_redirect_curl'],$selects))         $options['plus_redirect_curl']         = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_redirect_flush'],$selects))        $options['plus_redirect_flush']        = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_system_javascript'],$selects))     $options['plus_system_javascript']     = SZ_PLUGIN_GOOGLE_VALUE_NO;

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

/* ************************************************************************** */
/* Abilitazione del sistema di commenti g+ con o senza quello di default      */
/* ************************************************************************** */

function sz_google_modules_comments_system_enable() 
{
	// Calcolo opzioni di configurazione generale

	$options = sz_google_modules_plus_options();

	// Se è specificata opzione dopo il contenuto applico il filtro a the_content
	// altrimenti applico il filtro alla funzione di comment_template

	if ($options['plus_comments_ac_enable']=='1') add_filter('the_content','sz_google_modules_comments_content');
		else add_filter('comments_template','sz_google_modules_comments_system');
}

/* ************************************************************************** */
/* Funzione per rendering del sistema di commenti legato a google plus        */
/* ************************************************************************** */

function sz_google_modules_comments_system($include) 
{
	global $post,$comments;

	if (!(is_singular() && (have_comments() || 'open' == $post->comment_status))) { return; }

	// Aggiornamento delle variabili che contengono le opzioni		 
	// di eleborazione commenti e loro posizione nella pagina

	$checkdt = '00000000';
	$checkid	= get_the_date('Ymd');
	$options = sz_google_modules_plus_options();

	// Calcolo la data di confronto per la funzione dei commenti

	if ($options['plus_comments_dt_enable'] == SZ_PLUGIN_GOOGLE_VALUE_YES) 
	{
		$checkdt  = sprintf('%04d',$options['plus_comments_dt_year']);
		$checkdt .= sprintf('%02d',$options['plus_comments_dt_month']);
		$checkdt .= sprintf('%02d',$options['plus_comments_dt_day']);

		// Se devo controllare la data e non rientra nel range giusto non eseguo
		// l'elaborazione del sistema commenti e rimando a quello originale

		if ($checkid <= $checkdt) {
			return $include;
		}
	}

	// Controllo se devo mantenere i commenti standard di wordpress		 
	// in caso affermativo eseguo il file prima dei commenti di google plus

	if ($options['plus_comments_wp_enable'] == SZ_PLUGIN_GOOGLE_VALUE_YES and $options['plus_comments_aw_enable'] == SZ_PLUGIN_GOOGLE_VALUE_YES) {   
		if (file_exists($include)) @require($include);
		echo '<div id="sz-google-comments-margin" style="margin-bottom:1em"></div>';
	}

	// Creazione codice HTML per inserimento widget commenti		 

	echo '<div id="sz-google-comments" class="sz-google-comments-wrap">';
	echo '<script type="text/javascript">';
	echo "var w=document.getElementById('sz-google-comments').offsetWidth;";
	echo "document.write('".'<div class="g-comments" data-href="'.get_permalink().'" data-width="'."'+w+'".'" data-height="50" data-first_party_property="BLOGGER" data-view_type="FILTERED_POSTMOD"></div>'."');";
	echo '</script>';
	echo '</div>';

	// Aggiunta del codice javascript per il rendering dei widget		 
	// Questo codice viene aggiungo anche dalla sidebar però viene inserito una sola volta

	add_action('wp_footer','sz_google_modules_plus_add_script_footer');

	// Ritorno stesso template passato alla funzione nel caso in cui
	// devo mantenere i commenti standard dopo quelli di google plus
	
	if ($options['plus_comments_wp_enable'] == SZ_PLUGIN_GOOGLE_VALUE_YES and $options['plus_comments_aw_enable'] == SZ_PLUGIN_GOOGLE_VALUE_NO) {   
		return $include;
	}

	// Ritorno template di commenti dummy con nessuna azione HTML
	
	return plugin_dir_path( __FILE__ ).'sz-google-modules-plus-comments-dummy.php';
}

/* ************************************************************************** */
/* Funzione per rendering del sistema di commenti legato a google plus        */
/* ************************************************************************** */

function sz_google_modules_comments_content($content) 
{
	global $post,$comments;

	if (!(is_singular() && (have_comments() || 'open' == $post->comment_status))) { return $content; }

	// Creazione codice HTML per inserimento widget commenti		 

	$codice  = '<div id="sz-google-comments" class="sz-google-comments-wrap">';
	$codice .= '<script type="text/javascript">';
	$codice .= "var w=document.getElementById('sz-google-comments').offsetWidth;";
	$codice .= "document.write('".'<div class="g-comments" data-href="'.get_permalink().'" data-width="'."'+w+'".'" data-height="50" data-first_party_property="BLOGGER" data-view_type="FILTERED_POSTMOD"></div>'."');";
	$codice .= '</script>';
	$codice .= '</div>';

	// Aggiunta del codice javascript per il rendering dei widget		 
	// Questo codice viene aggiungo anche dalla sidebar però viene inserito una sola volta

	add_action('wp_footer','sz_google_modules_plus_add_script_footer');

	return $content.$codice;
}

/* ************************************************************************** */
/* Aggiungo le regole di rewrite per il modulo di google plus                 */
/* ************************************************************************** */

function sz_google_modules_plus_rewrite_rules() 
{
	global $wp; 
	$options = sz_google_modules_plus_options();

	// Controllo REDIRECT per url con la stringa "+"

	if ($options['plus_redirect_sign'] == SZ_PLUGIN_GOOGLE_VALUE_YES) {
		add_rewrite_rule('^\+$','index.php?szgoogleplusredirectsign=1','top');		
		$wp->add_query_var('szgoogleplusredirectsign');
	}   

	// Controllo REDIRECT per url con la stringa "plus"

	if ($options['plus_redirect_plus'] == SZ_PLUGIN_GOOGLE_VALUE_YES) {
		add_rewrite_rule('^plus$','index.php?szgoogleplusredirectplus=1','top');		
		$wp->add_query_var('szgoogleplusredirectplus');
	}   

	// Controllo REDIRECT per url con la stringa "URL"

	if ($options['plus_redirect_curl'] == SZ_PLUGIN_GOOGLE_VALUE_YES) {
		if (trim($options['plus_redirect_curl_dir']) <> SZ_PLUGIN_GOOGLE_VALUE_NULL and trim($options['plus_redirect_curl_url']) <> SZ_PLUGIN_GOOGLE_VALUE_NULL) {
			add_rewrite_rule('^'. preg_quote(trim($options['plus_redirect_curl_dir'])).'$','index.php?szgoogleplusredirectcurl=1','top');		
			$wp->add_query_var('szgoogleplusredirectcurl');
		}
	}   

	// Se opzione di flush è disattivata eseguo il flush_rules ed eseguo
	// la modifica dell'opzione al valore "1" per non ripetere l'operazione

	if ($options['plus_redirect_flush'] == SZ_PLUGIN_GOOGLE_VALUE_NO) 
	{
		$options['plus_redirect_flush'] = SZ_PLUGIN_GOOGLE_VALUE_YES;
		update_option('sz_google_options_plus',$options);
		add_action('wp_loaded','sz_google_modules_flush_rules');
	}

	// Aggiungo variabile QUERY URL e controllo personalizzato di redirect
	
	add_action('parse_request','sz_google_modules_plus_parse_query');
}

/* ************************************************************************** */
/* Controllo le variabili su URL ed eseguo redirect se necessario             */
/* ************************************************************************** */

function sz_google_modules_plus_parse_query(&$wp)
{
	$options = sz_google_modules_plus_options();

	// Controllo REDIRECT per url con la stringa "+"

	if (array_key_exists('szgoogleplusredirectsign',$wp->query_vars)) {
		if (trim($options['plus_redirect_sign_url']) <> SZ_PLUGIN_GOOGLE_VALUE_NULL) {   
			header("location:".trim($options['plus_redirect_sign_url'])); exit();
		}
	}

	// Controllo REDIRECT per url con la stringa "plus"
	
	if (array_key_exists('szgoogleplusredirectplus',$wp->query_vars)) {
		if (trim($options['plus_redirect_plus_url']) <> SZ_PLUGIN_GOOGLE_VALUE_NULL) {   
			header("location:".trim($options['plus_redirect_plus_url'])); exit();
		}
	}

	// Controllo REDIRECT per url con la stringa "URL"
	
	if (array_key_exists('szgoogleplusredirectcurl',$wp->query_vars)) {
		if (trim($options['plus_redirect_curl_url']) <> SZ_PLUGIN_GOOGLE_VALUE_NULL) {   
			header("location:".trim($options['plus_redirect_curl_url'])); exit();
		}
	}
}