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
/* Controllo le opzioni generali per saper i moduli che devo essere caricati  */
/* ************************************************************************** */ 

if ($options['plus_shortcode_pr_enable'] == SZ_PLUGIN_GOOGLE_VALUE_YES) {
	add_shortcode('sz-gplus-profile','sz_google_shortcodes_plus_profile');
}

if ($options['plus_shortcode_pa_enable'] == SZ_PLUGIN_GOOGLE_VALUE_YES) {
	add_shortcode('sz-gplus-page','sz_google_shortcodes_plus_page');
}

if ($options['plus_shortcode_co_enable'] == SZ_PLUGIN_GOOGLE_VALUE_YES) {
	add_shortcode('sz-gplus-community','sz_google_shortcodes_plus_community');
}

if ($options['plus_button_enable_plusone'] == SZ_PLUGIN_GOOGLE_VALUE_YES) {
	add_shortcode('sz-gplus-one','sz_google_shortcodes_plus_plusone');
}

if ($options['plus_button_enable_sharing'] == SZ_PLUGIN_GOOGLE_VALUE_YES) {
	add_shortcode('sz-gplus-share','sz_google_shortcodes_plus_sharing');
}

if ($options['plus_button_enable_follow'] == SZ_PLUGIN_GOOGLE_VALUE_YES) {
	add_shortcode('sz-gplus-follow','sz_google_shortcodes_plus_follow');
}

if ($options['plus_comments_sh_enable'] == SZ_PLUGIN_GOOGLE_VALUE_YES) {
	add_shortcode('sz-gplus-comments','sz_google_shortcodes_plus_comments');
}

if ($options['plus_post_enable_shortcode'] == SZ_PLUGIN_GOOGLE_VALUE_YES) {
	add_shortcode('sz-gplus-post','sz_google_shortcodes_plus_post');
}

/* ************************************************************************** */ 
/* Controllo le opzioni generali per saper i moduli che devo essere caricati  */
/* ************************************************************************** */ 

if ($options['plus_widget_pr_enable'] == SZ_PLUGIN_GOOGLE_VALUE_YES) { 
	add_action('widgets_init',create_function('','return register_widget("SZ_Widget_Google_Profile");'));
}

if ($options['plus_widget_pa_enable'] == SZ_PLUGIN_GOOGLE_VALUE_YES) { 
	add_action('widgets_init',create_function('','return register_widget("SZ_Widget_Google_Page");'));
}

if ($options['plus_widget_co_enable'] == SZ_PLUGIN_GOOGLE_VALUE_YES) { 
	add_action('widgets_init', create_function('', 'return register_widget("SZ_Widget_Google_Community");'));
}

if ($options['plus_comments_wd_enable'] == SZ_PLUGIN_GOOGLE_VALUE_YES) { 
	add_action('widgets_init',create_function('','return register_widget("SZ_Widget_Google_Comments");'));
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
	if (!isset($options['plus_post_enable_widget']))       $options['plus_post_enable_widget']       = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_post_enable_shortcode']))    $options['plus_post_enable_shortcode']    = SZ_PLUGIN_GOOGLE_VALUE_NO;

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
	if (!in_array($options['plus_post_enable_widget'],$selects))    $options['plus_post_enable_widget']    = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_post_enable_shortcode'],$selects)) $options['plus_post_enable_shortcode'] = SZ_PLUGIN_GOOGLE_VALUE_NO;

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

/* ************************************************************************** */
/* Funzione shortcode per inserimento G+ COMMENTS                             */
/* ************************************************************************** */

function sz_google_shortcodes_plus_comments($atts,$content=null) 
{
	/* Estrazione del valore URL dal codice shortcode */

	extract(shortcode_atts(array(
		'url'    => '',
		'width'  => '',
	),$atts));

	// Esecuzione trim su valori specificati su shortcode

	$url    = trim($url);
	$width  = strtolower(trim($width));

	// Imposto i valori di default nel caso siano specificati dei valori
	// che non appartengono al range dei valori accettati

	if ($url == '') $url = get_permalink();

	// Creazione codice univoco per l'inserimento del box commenti		 

	$uniqueID = 'sz-google-comments-'.md5(uniqid(),false);

	// Creazione codice HTML per inserimento widget commenti		 
	
	if (!is_numeric($width) or $width == '') 
	{ 
		$HTML  = '<div id="'.$uniqueID.'" class="sz-google-comments-wrap">';
		$HTML .= '<script type="text/javascript">';
		$HTML .= "var w=document.getElementById('".$uniqueID."').offsetWidth;";
		$HTML .= "document.write('".'<div class="g-comments" data-href="'.$url.'" data-width="'."'+w+'".'" data-height="50" data-first_party_property="BLOGGER" data-view_type="FILTERED_POSTMOD"></div>'."');";
		$HTML .= '</script>';
		$HTML .= '</div>';

	} else {

		$HTML  = '<div id="'.$uniqueID.'" class="sz-google-comments-wrap">';
		$HTML .= '<script type="text/javascript">';
		$HTML .= "var w=document.getElementById('".$uniqueID."').offsetWidth;";
		$HTML .= "document.write('".'<div class="g-comments" data-href="'.$url.'" data-width="'.$width.'" data-height="50" data-first_party_property="BLOGGER" data-view_type="FILTERED_POSTMOD"></div>'."');";
		$HTML .= '</script>';
		$HTML .= '</div>';
	}

	// Aggiunta del codice javascript per il rendering dei widget		 
	// Questo codice viene aggiungo anche dalla sidebar però viene inserito una sola volta

	add_action('wp_footer','sz_google_modules_plus_add_script_footer');

	// Ritorno il codice HTML generato dalla funzione		 

	return $HTML;
}

/* ************************************************************************** */
/* Funzione shortcode per inserimento G+ BADGE su COMMUNITY                   */
/* ************************************************************************** */

function sz_google_shortcodes_plus_community($atts,$content=null) 
{
	/* Estrazione del valore URL dal codice shortcode */

	extract(shortcode_atts(array(
		'id'     => SZ_PLUGIN_GOOGLE_PLUS_ID_COMMUNITY,
		'width'  => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_WIDTH,
		'layout' => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_LAYOUT,
		'theme'  => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_THEME,
		'photo'  => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_PHOTO,
		'owner'  => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_OWNER,
	),$atts));

	// Esecuzione trim su valori specificati su shortcode

	$id     = trim($id);
	$width  = strtolower(trim($width));
	$layout = strtolower(trim($layout));
	$theme  = strtolower(trim($theme));
	$photo  = strtolower(trim($photo));
	$owner  = strtolower(trim($owner));

	// Lettura opzioni generali per impostazione dei dati di default

	$options = sz_google_modules_plus_options();

	// Imposto i valori di default nel caso siano specificati dei valori
	// che non appartengono al range dei valori accettati

	if ($id == '') { 
		$id = SZ_PLUGIN_GOOGLE_PLUS_ID_COMMUNITY; 
	}

	if ($layout <> 'portrait' and $layout <> 'landscape') { 
		$layout = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_LAYOUT; 
	} 

	if ($theme <> 'light' and $theme <> 'dark') { 
		$theme = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_THEME; 
	} 

	if ($photo <> 'true' and $photo <> 'false') { $photo = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_PHOTO; } 
	if ($owner <> 'true' and $owner <> 'false') { $owner = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_OWNER; } 

	// Controllo il valore per dimensione widget

	if (!is_numeric($width) or $width == '') { 
		if ($layout == 'portrait') $width = $options['plus_shortcode_size_portrait'];
			else $width = $options['plus_shortcode_size_landscape']; 
	}

	// Preparazione codice HTML per il badge di google plus

	$HTML  = '<div class="g-community"';
	$HTML .= ' data-href="https://plus.google.com/communities/'.$id.'"';
	$HTML .= ' data-width="'     .$width  .'"';
	$HTML .= ' data-layout="'    .$layout.'"';
	$HTML .= ' data-theme="'     .$theme .'"';
	$HTML .= ' data-showphoto="' .$photo .'"';
	$HTML .= ' data-showowners="'.$owner .'"';
	$HTML .= '></div>';

	// Aggiunta del codice javascript per il rendering dei widget		 

	add_action('wp_footer','sz_google_modules_plus_add_script_footer');

	// Ritorno il codice HTML generato dalla funzione		 

	return $HTML;
}

/* ************************************************************************** */
/* Funzione shortcode per inserimento G+ BUTTON FOLLOW                        */
/* ************************************************************************** */

function sz_google_shortcodes_plus_follow($atts,$content=null) 
{
	$DEFAULT_URL        = '';
	$DEFAULT_WIDTH      = ''; 
	$DEFAULT_RELATION   = '';
	$DEFAULT_SIZE       = 'medium';
	$DEFAULT_ANNOTATION = 'bubble';

	/* Estrazione del valore URL dal codice shortcode */

	extract(shortcode_atts(array(
		'url'        => $DEFAULT_URL,
		'size'       => $DEFAULT_SIZE,
		'width'      => $DEFAULT_WIDTH,
		'annotation' => $DEFAULT_ANNOTATION,
		'rel'        => $DEFAULT_RELATION,
	),$atts));

	// Esecuzione trim su valori specificati su shortcode

	$url        = trim($url);
	$width      = strtolower(trim($width));
	$size       = strtolower(trim($size));
	$annotation = strtolower(trim($annotation));
	$rel        = strtolower(trim($rel));

	// Imposto i valori di default nel caso siano specificati dei valori
	// che non appartengono al range dei valori accettati

	if ($width == '' or !is_numeric($width)) { 
		$width = $DEFAULT_WIDTH; 
	} 

	if (!in_array($size,array('small','medium','large',))) { 
		$size = $DEFAULT_SIZE; 
	} 

	if (!in_array($annotation,array('bubble','vertical-bubble','none'))) { 
		$annotation = $DEFAULT_ANNOTATION; 
	} 

	if (!in_array($rel,array('author','publishe'))) { 
		$rel = $DEFAULT_RELATION; 
	} 

	// Se non specifico un URL fisso imposto il permalink attuale

	if ($url == '') $url = get_permalink();

	// Preparazione codice HTML per il badge di google plus

	$HTML  = '<div class="g-follow"';
	$HTML .= ' data-href="'      .$url       .'"';
	$HTML .= ' data-annotation="'.$annotation.'"';

	if ($size  == 'small')  $HTML .= ' data-height="15"';
	if ($size  == 'medium') $HTML .= ' data-height="20"';
	if ($size  == 'large')  $HTML .= ' data-height="24"';
	if ($width <> '')       $HTML .= ' data-width="'.$width.'"';
	if ($rel   <> '')       $HTML .= ' data-rel="'.$rel.'"';

	$HTML .= '></div>';

	// Aggiunta del codice javascript per il rendering dei widget		 

	add_action('wp_footer','sz_google_modules_plus_add_script_footer');

	// Ritorno il codice HTML generato dalla funzione		 

	return $HTML;
}
/* ************************************************************************** */
/* Funzione shortcode per inserimento G+ BADGE su PAGE                        */
/* ************************************************************************** */

function sz_google_shortcodes_plus_page($atts,$content=null) 
{
	/* Estrazione del valore URL dal codice shortcode */

	extract(shortcode_atts(array(
		'id'        => SZ_PLUGIN_GOOGLE_PLUS_ID_PAGE,
		'width'     => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_WIDTH,
		'layout'    => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_LAYOUT,
		'theme'     => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_THEME,
		'cover'     => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_COVER,
		'tagline'   => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_TAGLINE,
		'publisher' => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_PUBLISHER,
	),$atts));

	// Esecuzione trim su valori specificati su shortcode

	$id        = trim($id);
	$width     = strtolower(trim($width));
	$layout    = strtolower(trim($layout));
	$theme     = strtolower(trim($theme));
	$cover     = strtolower(trim($cover));
	$tagline   = strtolower(trim($tagline));
	$publisher = strtolower(trim($publisher));

	// Lettura opzioni generali per impostazione dei dati di default

	$options = sz_google_modules_plus_options();

	// Imposto i valori di default nel caso siano specificati dei valori
	// che non appartengono al range dei valori accettati

	if ($id == '') { 
		$id = SZ_PLUGIN_GOOGLE_PLUS_ID_PAGE; $publisher = 'false'; 
	}

	if ($layout <> 'portrait' and $layout <> 'landscape') { 
		$layout = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_LAYOUT; 
	} 

	if ($theme <> 'light' and $theme <> 'dark') { 
		$theme = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_THEME; 
	} 

	if ($cover     <> 'true' and $cover     <> 'false') { $cover     = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_COVER; } 
	if ($tagline   <> 'true' and $tagline   <> 'false') { $tagline   = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_TAGLINE; } 
	if ($publisher <> 'true' and $publisher <> 'false') { $publisher = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_PUBLISHER; } 

	// Controllo il valore per dimensione widget

	if (!is_numeric($width) or $width == '') { 
		if ($layout == 'portrait') $width = $options['plus_shortcode_size_portrait'];
			else $width = $options['plus_shortcode_size_landscape']; 
	}

	// Preparazione codice HTML per il badge di google plus

	$HTML  = '<div class="g-page"';
	$HTML .= ' data-href="https://plus.google.com/'.$id.'"';
	$HTML .= ' data-width="'         .$width  .'"';
	$HTML .= ' data-layout="'        .$layout .'"';
	$HTML .= ' data-theme="'         .$theme  .'"';
	$HTML .= ' data-showcoverphoto="'.$cover  .'"';
	$HTML .= ' data-showtagline="'   .$tagline.'"';

	if ($publisher == 'true') {		
		$HTML .= ' data-rel="publisher"';
	}

	$HTML .= '></div>';

	// Aggiunta del codice javascript per il rendering dei widget		 

	add_action('wp_footer','sz_google_modules_plus_add_script_footer');

	// Ritorno il codice HTML generato dalla funzione		 

	return $HTML;
}

/* ************************************************************************** */
/* Funzione shortcode per inserimento G+ BOTTON PLUS ONE                      */
/* ************************************************************************** */

function sz_google_shortcodes_plus_plusone($atts,$content=null) 
{
	$DEFAULT_URL        = '';
	$DEFAULT_SIZE       = 'standard';
	$DEFAULT_WIDTH      = '300'; 
	$DEFAULT_ANNOTATION = 'inline';

	/* Estrazione del valore URL dal codice shortcode */

	extract(shortcode_atts(array(
		'url'        => $DEFAULT_URL,
		'size'       => $DEFAULT_SIZE,
		'width'      => $DEFAULT_WIDTH,
		'annotation' => $DEFAULT_ANNOTATION,
	),$atts));

	// Esecuzione trim su valori specificati su shortcode

	$url        = trim($url);
	$width      = strtolower(trim($width));
	$size       = strtolower(trim($size));
	$annotation = strtolower(trim($annotation));

	// Imposto i valori di default nel caso siano specificati dei valori
	// che non appartengono al range dei valori accettati

	if ($width == '' or !is_numeric($width)) { 
		$width = $DEFAULT_WIDTH; 
	} 

	if (!in_array($size,array('small','medium','standard','tail'))) { 
		$size = $DEFAULT_SIZE; 
	} 

	if (!in_array($annotation,array('inline','bubble','none'))) { 
		$annotation = $DEFAULT_ANNOTATION; 
	} 

	// Se non specifico un URL fisso imposto il permalink attuale

	if ($url == '') $url = get_permalink();

	// Preparazione codice HTML per il badge di google plus

	$HTML  = '<div class="g-plusone"';
	$HTML .= ' data-href="'      .$url       .'"';
	$HTML .= ' data-size="'      .$size      .'"';
	$HTML .= ' data-width="'     .$width     .'"';
	$HTML .= ' data-annotation="'.$annotation.'"';
	$HTML .= '></div>';

	// Aggiunta del codice javascript per il rendering dei widget		 

	add_action('wp_footer','sz_google_modules_plus_add_script_footer');

	// Ritorno il codice HTML generato dalla funzione		 

	return $HTML;	
}

/* ************************************************************************** */
/* Funzione shortcode per inserimento G+ BADGE su PROFILO                     */
/* ************************************************************************** */

function sz_google_shortcodes_plus_profile($atts,$content=null) 
{
	/* Estrazione del valore URL dal codice shortcode */

	extract(shortcode_atts(array(
		'id'      => SZ_PLUGIN_GOOGLE_PLUS_ID_PROFILE,
		'width'   => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_WIDTH,
		'layout'  => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_LAYOUT,
		'theme'   => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_THEME,
		'cover'   => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_COVER,
		'tagline' => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_TAGLINE,
		'author'  => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_AUTHOR,
	),$atts));

	// Esecuzione trim su valori specificati su shortcode

	$id      = trim($id);
	$width   = strtolower(trim($width));
	$layout  = strtolower(trim($layout));
	$theme   = strtolower(trim($theme));
	$cover   = strtolower(trim($cover));
	$tagline = strtolower(trim($tagline));
	$author  = strtolower(trim($author));

	// Lettura opzioni generali per impostazione dei dati di default

	$options = sz_google_modules_plus_options();

	// Imposto i valori di default nel caso siano specificati dei valori
	// che non appartengono al range dei valori accettati

	if ($id == '') { 
		$id = SZ_PLUGIN_GOOGLE_PLUS_ID_PROFILE; $author = 'false'; 
	}

	if ($layout <> 'portrait' and $layout <> 'landscape') { 
		$layout = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_LAYOUT; 
	} 

	if ($theme <> 'light' and $theme <> 'dark') { 
		$theme = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_THEME; 
	} 

	if ($cover   <> 'true' and $cover   <> 'false') { $cover   = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_COVER; } 
	if ($tagline <> 'true' and $tagline <> 'false') { $tagline = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_TAGLINE; } 
	if ($author  <> 'true' and $author  <> 'false') { $author  = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_AUTHOR; } 

	// Controllo il valore per dimensione widget

	if (!is_numeric($width) or $width == '') { 
		if ($layout == 'portrait') $width = $options['plus_shortcode_size_portrait'];
			else $width = $options['plus_shortcode_size_landscape']; 
	}

	// Preparazione codice HTML per il badge di google plus

	$HTML  = '<div class="g-person"';
	$HTML .= ' data-href="https://plus.google.com/'.$id.'"';
	$HTML .= ' data-width="'         .$width  .'"';
	$HTML .= ' data-layout="'        .$layout .'"';
	$HTML .= ' data-theme="'         .$theme  .'"';
	$HTML .= ' data-showcoverphoto="'.$cover  .'"';
	$HTML .= ' data-showtagline="'   .$tagline.'"';

	if ($author == 'true') {		
		$HTML .= ' data-rel="author"';
	}

	$HTML .= '></div>';

	// Aggiunta del codice javascript per il rendering dei widget		 

	add_action('wp_footer','sz_google_modules_plus_add_script_footer');

	// Ritorno il codice HTML generato dalla funzione		 

	return $HTML;
}

/* ************************************************************************** */
/* Funzione shortcode per inserimento G+ BUTTON SHARING                       */
/* ************************************************************************** */

function sz_google_shortcodes_plus_sharing($atts,$content=null) 
{
	$DEFAULT_URL        = '';
	$DEFAULT_SIZE       = 'medium';
	$DEFAULT_WIDTH      = ''; 
	$DEFAULT_ANNOTATION = 'inline';

	/* Estrazione del valore URL dal codice shortcode */

	extract(shortcode_atts(array(
		'url'        => $DEFAULT_URL,
		'size'       => $DEFAULT_SIZE,
		'width'      => $DEFAULT_WIDTH,
		'annotation' => $DEFAULT_ANNOTATION,
	),$atts));

	// Esecuzione trim su valori specificati su shortcode

	$url        = trim($url);
	$width      = strtolower(trim($width));
	$size       = strtolower(trim($size));
	$annotation = strtolower(trim($annotation));

	// Imposto i valori di default nel caso siano specificati dei valori
	// che non appartengono al range dei valori accettati

	if ($width == '' or !is_numeric($width)) { 
		$width = $DEFAULT_WIDTH; 
	} 

	if (!in_array($size,array('small','medium','large',))) { 
		$size = $DEFAULT_SIZE; 
	} 

	if (!in_array($annotation,array('inline','bubble','vertical-bubble','none'))) { 
		$annotation = $DEFAULT_ANNOTATION; 
	} 

	// Se non specifico un URL fisso imposto il permalink attuale

	if ($url == '') $url = get_permalink();

	// Preparazione codice HTML per il badge di google plus

	$HTML  = '<div class="g-plus"';
	$HTML .= ' data-action="share"';	
	$HTML .= ' data-href="'      .$url       .'"';
	$HTML .= ' data-annotation="'.$annotation.'"';

	if ($size  == 'small')  $HTML .= ' data-height="15"';
	if ($size  == 'medium') $HTML .= ' data-height="20"';
	if ($size  == 'large')  $HTML .= ' data-height="24"';
	if ($width <> '')       $HTML .= ' data-width="'.$width.'"';

	$HTML .= '></div>';

	// Aggiunta del codice javascript per il rendering dei widget, questo codice		 
	// viene aggiungo anche dalla sidebar però viene inserito una sola volta

	add_action('wp_footer','sz_google_modules_plus_add_script_footer');

	// Ritorno il codice HTML generato dalla funzione		 

	return $HTML;
}

/* ************************************************************************** */
/* Funzione shortcode per inserimento G+ EMBEDDED POST                        */
/* ************************************************************************** */

function sz_google_shortcodes_plus_post($atts,$content=null) 
{
	// Estrazione dei valori specificati nello shortcode, i valori ritornati
	// sono contenuti nei nomi di variabili corrispondenti alla chiave

	extract(shortcode_atts(array(
		'url' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts));

	// Preparazione codice HTML dello shortcode tramite la funzione
	// standard di preparazione codice sia per shortcode che widgets

	$HTML = sz_google_modules_plus_get_code_post(array(
		'url' => trim($url),
	));

	return $HTML;
}

/* ************************************************************************** */
/* Funzione shortcode per generazione codice G+ EMBEDDED POST                 */
/* ************************************************************************** */

function sz_google_modules_plus_get_code_post($atts=array())
{
	// Estrazione dei valori specificati nello shortcode, i valori ritornati
	// sono contenuti nei nomi di variabili corrispondenti alla chiave

	if (!is_array($atts)) $atts = array();

	extract(shortcode_atts(array(
		'url' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts));

	// Elimino spazi aggiunti di troppo ed esegui la trasformazione in
	// stringa minuscolo per il controllo di valori speciali come "auto"

	$url = trim($url);

	// Creazione codice HTML per embed code da inserire nella pagina wordpress

	$HTML  = '<div class="g-post" ';
	$HTML .= 'data-href="'.$url.'"';
	$HTML .= '></div>';

	// Aggiunta del codice javascript per il rendering dei widget, questo codice		 
	// viene aggiungo anche dalla sidebar però viene inserito una sola volta

	add_action('wp_footer','sz_google_modules_plus_add_script_footer');

	// Ritorno per la funzione con tutta la stringa contenente
	// il codice HTML per l'inserimento di un video youtube 

	return $HTML;
}

/* ************************************************************************** */ 
/* SZ_Widget_Google_Profile - Inserimento profilo sulla sidebar come widget   */ 
/* ************************************************************************** */ 

class SZ_Widget_Google_Profile extends WP_Widget
{
	// Costruttore principale della classe widget, definizione 
	// delle opzioni legate al widget e al controllo dello stesso

	function SZ_Widget_Google_Profile() {
		$widget_ops  = array(
			'classname'   => 'widget-sz-google', 
			'description' => ucfirst(__('widget for google+ profile','szgoogleadmin'))
		);
		$this->WP_Widget('SZ-Google-Profile',__('SZ-Google - G+ Profile','szgoogleadmin'),$widget_ops);
	}

	// Funzione per la visualizzazione del widget con lettura parametri
	// di configurazione e preparazione codice HTML da usare nella sidebar

	function widget($args,$instance) 
	{
		extract($args);

		// Costruzione del titolo del widget

		if (empty($instance['title'])) $title = '';
			else $title = trim($instance['title']);

		$title = apply_filters('widget_title',$title,$instance,$this->id_base);

		if (!isset($before_title)) $before_title = '';
		if (!isset($after_title))  $after_title = '';

		if ($title and $title <> '') {
			$title = $before_title.$title.$after_title;
		}

		// Controllo se esistono le variabili di opzione

		if (empty($instance['method']))   $instance['method']   = '1';
		if (empty($instance['specific'])) $instance['specific'] = '';
		if (empty($instance['width']))    $instance['width']    = '';
		if (empty($instance['dfsize']))   $instance['dfsize']   = '';
		if (empty($instance['layout']))   $instance['layout']   = 'portrait';
		if (empty($instance['theme']))    $instance['theme']    = 'light';
		if (empty($instance['photo']))    $instance['photo']    = 'true';
		if (empty($instance['tagline']))  $instance['tagline']  = 'true';
		if (empty($instance['author']))   $instance['author']   = 'true';

		$method   = trim($instance['method']);
		$specific = trim($instance['specific']);
		$width    = trim($instance['width']);
		$dfsize   = trim($instance['dfsize']);
		$layout   = trim($instance['layout']);
		$theme    = trim($instance['theme']);
		$photo    = trim($instance['photo']);
		$tagline  = trim($instance['tagline']);
		$author   = trim($instance['author']);

		// Caricamento delle opzioni per elaborazione
		
		$options = sz_google_modules_plus_options();

		// Correzione del valore di dimensione in caso di default
		// che può essere diverso tra portrait e landscape

		if ($width == '') {
			if ($layout == 'portrait' ) $width = SZ_PLUGIN_GOOGLE_WIDGET_SIZE_PORTRAIT;
			if ($layout == 'landscape') $width = SZ_PLUGIN_GOOGLE_WIDGET_SIZE_LANDSCAPE;
		}

		if ($dfsize == '1') {
			if ($layout == 'portrait' ) $width = $options['plus_widget_size_portrait'];
			if ($layout == 'landscape') $width = $options['plus_widget_size_landscape'];
		}

		// Calcolo del valore ID per la composizione del badge

		if ($method == '1') $profile = $options['plus_profile']; 
		if ($method == '2') $profile = $specific;

		// Se il profilo g+ non esiste visualizzo default

		if (!isset($profile) or trim($profile)=='') { 
			$profile = SZ_PLUGIN_GOOGLE_PLUS_ID_PROFILE; 
			$author  = 'false'; 
		}

		// Creazione del codice per il badge di google+
		 
		$HTML  = '<div class="g-person"';
		$HTML .= ' data-href="https://plus.google.com/'.$profile.'"';
		$HTML .= ' data-width="'         .$width  .'"';
		$HTML .= ' data-layout="'        .$layout .'"';
		$HTML .= ' data-theme="'         .$theme  .'"';
		$HTML .= ' data-showcoverphoto="'.$photo  .'"';
		$HTML .= ' data-showtagline="'   .$tagline.'"';

		if ($author == 'true') {		
			$HTML .= ' data-rel="author"';
		}

		$HTML .= '></div>';

		// Output del codice HTML legato al widget da visualizzare		 

		$output  = '';
		$output .= $before_widget;
		$output .= $title;
		$output .= $HTML;
		$output .= $after_widget;

		echo $output;

		// Aggiunta del codice javascript per il rendering dei widget		 

		add_action('wp_footer','sz_google_modules_plus_add_script_footer');
	}

	// Funzione per modifica parametri collegati al widget con 
	// memorizzazione dei valori direttamente nel database wordpress

	function update($new_instance,$old_instance) 
	{
		$instance = $old_instance;

		$instance['title']    = trim(strip_tags($new_instance['title']));
		$instance['method']   = trim(strip_tags($new_instance['method']));
		$instance['specific'] = trim(strip_tags($new_instance['specific']));
		$instance['width']    = trim(strip_tags($new_instance['width']));
		$instance['layout']   = trim(strip_tags($new_instance['layout']));
		$instance['theme']    = trim(strip_tags($new_instance['theme']));
		$instance['photo']    = trim(strip_tags($new_instance['photo']));
		$instance['tagline']  = trim(strip_tags($new_instance['tagline']));
		$instance['author']   = trim(strip_tags($new_instance['author']));

		if (!isset($new_instance['dfsize'])) $instance['dfsize'] = ''; 
			else $instance['dfsize'] = trim(strip_tags($new_instance['dfsize']));

		return $instance;
	}

	// Funzione per la visualizzazione del form presente sulle 
	// sidebar nel pannello di amministrazione di wordpress
	
	function form($instance) 
	{
		// Creazione array per elenco campi da recuperare su FORM

		$array = array(
			'title'    => '',
			'method'   => '1',
			'specific' => '',
			'width'    => SZ_PLUGIN_GOOGLE_WIDGET_SIZE_PORTRAIT,
			'dfsize'   => '1',
			'layout'   => 'portrait',
			'theme'    => 'light',
			'photo'    => 'true',
			'tagline'  => 'true',
			'author'   => 'true',
		);

		// Creazione array per elenco campi da recuperare su FORM

		$instance = wp_parse_args((array) $instance,$array);
		$title    = trim(strip_tags($instance['title']));
		$method   = trim(strip_tags($instance['method']));
		$specific = trim(strip_tags($instance['specific']));
		$width    = trim(strip_tags($instance['width']));
		$dfsize   = trim(strip_tags($instance['dfsize']));
		$layout   = trim(strip_tags($instance['layout']));
		$theme    = trim(strip_tags($instance['theme']));
		$photo    = trim(strip_tags($instance['photo']));
		$tagline  = trim(strip_tags($instance['tagline']));
		$author   = trim(strip_tags($instance['author']));

		// Campo di selezione parametro badge per TITOLO

		echo '<p><label for="'.$this->get_field_id('title').'">'.ucfirst(__('title','szgoogleadmin')).':</label>';
		echo '<input class="widefat" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.esc_attr($title).'"/></p>';

		// Campo di selezione parametro badge per ID con metodo

		echo '<p><select class="widefat" id="'.$this->get_field_id('method').'" name="'.$this->get_field_name('method').'">';
		echo '<option value="1" '; selected("1",$method); echo '>'.ucfirst(__('configuration ID','szgoogleadmin')).'</option>';
		echo '<option value="2" '; selected("2",$method); echo '>'.ucfirst(__('specific ID','szgoogleadmin')).'</option>';
		echo '</select></p>';

		// Campo di selezione parametro badge per ID specifico

		echo '<p id="'.$this->get_field_id('fieldj').'">';
		echo '<input class="widefat" id="'.$this->get_field_id('specific').'" name="'.$this->get_field_name('specific').'" type="text" value="'.$specific.'" placeholder="'.__('insert specific ID','szgoogleadmin').'"/></p>';

		// Codice javascript per abilitare/disabilitare il campo ID specifico

		echo '<script type="text/javascript">';
			echo 'jQuery(document).ready(function(){';
				echo 'if (jQuery("#'.$this->get_field_id('method').'").val() == "1"){';
					echo 'jQuery("#'.$this->get_field_id('fieldj').'").hide();';
				echo '}';
				echo 'jQuery("#'.$this->get_field_id('method').'").change(function(){';          
					echo "if (this.value == '1') {";
						echo 'jQuery("#'.$this->get_field_id('fieldj').'").slideUp();';
				   echo "} else {";
						echo 'jQuery("#'.$this->get_field_id('fieldj').'").slideDown();';
					echo '}';
				echo '});';
			echo '});';
		echo '</script>';

		// Codice javascript per abilitare/disabilitare il campo WIDTH

		echo '<script type="text/javascript">';
			echo 'jQuery(document).ready(function(){';
				echo 'if (jQuery("#'.$this->get_field_id('dfsize').'").is(":checked")) {';
					echo 'jQuery("#'.$this->get_field_id('width').'").prop("readonly",true);';
				echo '}';
				echo 'jQuery("#'.$this->get_field_id('dfsize').'").click(function(){';          
					echo 'if (jQuery("#'.$this->get_field_id('dfsize').'").is(":checked")) {';
						echo 'jQuery("#'.$this->get_field_id('width').'").prop("readonly",true);';
				   echo "} else {";
						echo 'jQuery("#'.$this->get_field_id('width').'").prop("readonly",false);';
					echo '}';
				echo '});';
			echo '});';
		echo '</script>';

		// Campo di selezione parametro badge per WIDTH

		echo '<table style="width:100%"><tr>';
		echo '<td><label for="'.$this->get_field_id('width').'">'.ucfirst(__('width','szgoogleadmin')).':</label></td>';
		echo '<td><input id="'.$this->get_field_id('width').'" name="'.$this->get_field_name('width').'" type="number" size="5" step="1" min="180" max="450" value="'.$width.'"/></td>';
		echo '<td><input class="checkbox" type="checkbox" id="'.$this->get_field_id('dfsize').'" name="'.$this->get_field_name('dfsize').'" value="1" '; checked($dfsize); echo '>&nbsp;'.ucfirst(__('default','szgoogleadmin')).'</td>';
		echo '</tr>';

		echo '<tr><td colspan="3"><hr></td></tr>';

		// Campo di selezione parametro badge per LAYOUT

		if ($layout == 'portrait')  { $check1=' checked'; $check2=''; }
			else { $check1=''; $check2=' checked'; }
		
		echo '<tr>';
		echo '<td><label for="'.$this->get_field_id('layout').'">'.ucfirst(__('layout','szgoogleadmin')).':</label></td>';
		echo '<td><input type="radio" name="'.$this->get_field_name('layout').'" value="portrait"' .$check1.'>&nbsp;'.ucfirst(__('portrait','szgoogleadmin')).'</td>';
		echo '<td><input type="radio" name="'.$this->get_field_name('layout').'" value="landscape"'.$check2.'>&nbsp;'.ucfirst(__('landscape','szgoogleadmin')).'</td>';
		echo '</tr>';

		// Campo di selezione parametro badge per THEME

		if ($theme == 'light')  { $check1=' checked'; $check2=''; }
			else { $check1=''; $check2=' checked'; }
		
		echo '<tr>';
		echo '<td><label for="'.$this->get_field_id('theme').'">'.ucfirst(__('theme','szgoogleadmin')).':</label></td>';
		echo '<td><input type="radio" name="'.$this->get_field_name('theme').'" value="light"'.$check1.'>&nbsp;'.ucfirst(__('light','szgoogleadmin')).'</td>';
		echo '<td><input type="radio" name="'.$this->get_field_name('theme').'" value="dark"' .$check2.'>&nbsp;'.ucfirst(__('dark','szgoogleadmin')).'</td>';
		echo '</tr>';

		// Campo di selezione parametro badge per PHOTO

		if ($photo == 'true')  { $check1=' checked'; $check2=''; }
			else { $check1=''; $check2=' checked'; }
		
		echo '<td><label for="'.$this->get_field_id('photo').'">'.ucfirst(__('cover','szgoogleadmin')).':</label></td>';
		echo '<td><input type="radio" name="'.$this->get_field_name('photo').'" value="true"' .$check1.'>&nbsp;'.ucfirst(__('enabled','szgoogleadmin')).'</td>';
		echo '<td><input type="radio" name="'.$this->get_field_name('photo').'" value="false"'.$check2.'>&nbsp;'.ucfirst(__('disabled','szgoogleadmin')).'</td>';
		echo '</tr>';

		// Campo di selezione parametro badge per TAGLINE

		if ($tagline == 'true')  { $check1=' checked'; $check2=''; }
			else { $check1=''; $check2=' checked'; }
		
		echo '<tr>';
		echo '<td><label for="'.$this->get_field_id('tagline').'">'.ucfirst(__('tagline','szgoogleadmin')).':</label></td>';
		echo '<td><input type="radio" name="'.$this->get_field_name('tagline').'" value="true"' .$check1.'>&nbsp;'.ucfirst(__('enabled','szgoogleadmin')).'</td>';
		echo '<td><input type="radio" name="'.$this->get_field_name('tagline').'" value="false"'.$check2.'>&nbsp;'.ucfirst(__('disabled','szgoogleadmin')).'</td>';
		echo '</tr>';

		// Campo di selezione parametro badge per AUTHOR

		if ($author == 'true')  { $check1=' checked'; $check2=''; }
			else { $check1=''; $check2=' checked'; }
		
		echo '<tr>';
		echo '<td><label for="'.$this->get_field_id('author').'">'.ucfirst(__('author','szgoogleadmin')).':</label></td>';
		echo '<td><input type="radio" name="'.$this->get_field_name('author').'" value="true"' .$check1.'>&nbsp;'.ucfirst(__('enabled','szgoogleadmin')).'</td>';
		echo '<td><input type="radio" name="'.$this->get_field_name('author').'" value="false"'.$check2.'>&nbsp;'.ucfirst(__('disabled','szgoogleadmin')).'</td>';
		echo '</tr>';
		echo '</table>';
	}

}

/* ************************************************************************** */ 
/* SZ_Widget_Google_Page - Inserimento pagina sulla sidebar come widget       */ 
/* ************************************************************************** */ 

class SZ_Widget_Google_Page extends WP_Widget 
{
	// Costruttore principale della classe widget, definizione 
	// delle opzioni legate al widget e al controllo dello stesso

	function SZ_Widget_Google_Page() {
		$widget_ops  = array(
			'classname'   => 'widget-sz-google', 
			'description' => ucfirst(__('widget for google+ page','szgoogleadmin'))
		);
		$this->WP_Widget('SZ-Google-Page',__('SZ-Google - G+ Page','szgoogleadmin'),$widget_ops);
	}

	// Funzione per la visualizzazione del widget con lettura parametri
	// di configurazione e preparazione codice HTML da usare nella sidebar

	function widget($args,$instance) 
	{
		extract($args);

		// Costruzione del titolo del widget

		if (empty($instance['title'])) $title = '';
			else $title = trim($instance['title']);

		$title = apply_filters('widget_title',$title,$instance,$this->id_base);

		if (!isset($before_title)) $before_title = '';
		if (!isset($after_title))  $after_title = '';

		if ($title and $title <> '') {
			$title = $before_title.$title.$after_title;
		}

		// Controllo se esistono le variabili di opzione

		if (empty($instance['method']))    $instance['method']    = '1';
		if (empty($instance['specific']))  $instance['specific']  = '';
		if (empty($instance['width']))     $instance['width']     = '';
		if (empty($instance['dfsize']))    $instance['dfsize']    = '';
		if (empty($instance['layout']))    $instance['layout']    = 'portrait';
		if (empty($instance['theme']))     $instance['theme']     = 'light';
		if (empty($instance['photo']))     $instance['photo']     = 'true';
		if (empty($instance['tagline']))   $instance['tagline']   = 'true';
		if (empty($instance['publisher'])) $instance['publisher'] = 'true';

		$method    = trim($instance['method']);
		$specific  = trim($instance['specific']);
		$width     = trim($instance['width']);
		$dfsize    = trim($instance['dfsize']);
		$layout    = trim($instance['layout']);
		$theme     = trim($instance['theme']);
		$photo     = trim($instance['photo']);
		$tagline   = trim($instance['tagline']);
		$publisher = trim($instance['publisher']);

		// Caricamento delle opzioni per elaborazione
		
		$options = sz_google_modules_plus_options();

		// Correzione del valore di dimensione in caso di default
		// che può essere diverso tra portrait e landscape

		if ($width == '') {
			if ($layout == 'portrait' ) $width = SZ_PLUGIN_GOOGLE_WIDGET_SIZE_PORTRAIT;
			if ($layout == 'landscape') $width = SZ_PLUGIN_GOOGLE_WIDGET_SIZE_LANDSCAPE;
		}

		if ($dfsize == '1') {
			if ($layout == 'portrait' ) $width = $options['plus_widget_size_portrait'];
			if ($layout == 'landscape') $width = $options['plus_widget_size_landscape'];
		}

		// Calcolo del valore ID per la composizione del badge

		if ($method == '1') $page = $options['plus_page']; 
		if ($method == '2') $page = $specific;

		// Se la business page non esiste visualizzo la default

		if (!isset($page) or trim($page)=='') 
		{ 
			$page = SZ_PLUGIN_GOOGLE_PLUS_ID_PAGE; 
			$publisher = 'false'; 
		}

		// Creazione del codice per il badge di google+
		 
		$HTML  = '<div class="g-page"';
		$HTML .= ' data-href="https://plus.google.com/'.$page.'"';
		$HTML .= ' data-width="'         .$width  .'"';
		$HTML .= ' data-layout="'        .$layout .'"';
		$HTML .= ' data-theme="'         .$theme  .'"';
		$HTML .= ' data-showcoverphoto="'.$photo  .'"';
		$HTML .= ' data-showtagline="'   .$tagline.'"';

		if ($publisher == 'true') {		
			$HTML .= ' data-rel="publisher"';
		}

		$HTML .= '></div>';

		// Output del codice HTML legato al widget da visualizzare		 

		$output  = '';
		$output .= $before_widget;
		$output .= $title;
		$output .= $HTML;
		$output .= $after_widget;

		echo $output;

		// Aggiunta del codice javascript per il rendering dei widget		 

		add_action('wp_footer','sz_google_modules_plus_add_script_footer');
	}

	// Funzione per modifica parametri collegati al widget con 
	// memorizzazione dei valori direttamente nel database wordpress

	function update($new_instance,$old_instance) 
	{
		$instance = $old_instance;

		$instance['title']     = trim(strip_tags($new_instance['title']));
		$instance['method']    = trim(strip_tags($new_instance['method']));
		$instance['specific']  = trim(strip_tags($new_instance['specific']));
		$instance['width']     = trim(strip_tags($new_instance['width']));
		$instance['layout']    = trim(strip_tags($new_instance['layout']));
		$instance['theme']     = trim(strip_tags($new_instance['theme']));
		$instance['photo']     = trim(strip_tags($new_instance['photo']));
		$instance['tagline']   = trim(strip_tags($new_instance['tagline']));
		$instance['publisher'] = trim(strip_tags($new_instance['publisher']));

		if (!isset($new_instance['dfsize'])) $instance['dfsize'] = ''; 
			else $instance['dfsize'] = trim(strip_tags($new_instance['dfsize']));

		return $instance;
	}

	// Funzione per la visualizzazione del form presente sulle 
	// sidebar nel pannello di amministrazione di wordpress

	function form($instance) 
	{
		// Creazione array per elenco campi da recuperare su FORM

		$array = array(
			'title'     => '',
			'method'    => '1',
			'specific'  => '',
			'width'     => SZ_PLUGIN_GOOGLE_WIDGET_SIZE_PORTRAIT,
			'dfsize'    => '1',
			'layout'    => 'portrait',
			'theme'     => 'light',
			'photo'     => 'true',
			'tagline'   => 'true',
			'publisher' => 'true',
		);

		// Creazione array per elenco campi da recuperare su FORM

		$instance  = wp_parse_args((array) $instance,$array);
		$title     = trim(strip_tags($instance['title']));
		$method    = trim(strip_tags($instance['method']));
		$specific  = trim(strip_tags($instance['specific']));
		$width     = trim(strip_tags($instance['width']));
		$dfsize    = trim(strip_tags($instance['dfsize']));
		$layout    = trim(strip_tags($instance['layout']));
		$theme     = trim(strip_tags($instance['theme']));
		$photo     = trim(strip_tags($instance['photo']));
		$tagline   = trim(strip_tags($instance['tagline']));
		$publisher = trim(strip_tags($instance['publisher']));

		// Campo di selezione parametro badge per TITOLO

		echo '<p><label for="'.$this->get_field_id('title').'">'.ucfirst(__('title','szgoogleadmin')).':</label>';
		echo '<input class="widefat" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.esc_attr($title).'"/></p>';

		// Campo di selezione parametro badge per ID con metodo

		echo '<p><select class="widefat" id="'.$this->get_field_id('method').'" name="'.$this->get_field_name('method').'">';
		echo '<option value="1" '; selected("1",$method); echo '>'.ucfirst(__('configuration ID','szgoogleadmin')).'</option>';
		echo '<option value="2" '; selected("2",$method); echo '>'.ucfirst(__('specific ID','szgoogleadmin')).'</option>';
		echo '</select></p>';

		// Campo di selezione parametro badge per ID specifico

		echo '<p id="'.$this->get_field_id('fieldj').'">';
		echo '<input class="widefat" id="'.$this->get_field_id('specific').'" name="'.$this->get_field_name('specific').'" type="text" value="'.$specific.'" placeholder="'.__('insert specific ID','szgoogleadmin').'"/></p>';

		// Codice javascript per abilitare/disabilitare il campo ID specifico

		echo '<script type="text/javascript">';
			echo 'jQuery(document).ready(function(){';
				echo 'if (jQuery("#'.$this->get_field_id('method').'").val() == "1"){';
					echo 'jQuery("#'.$this->get_field_id('fieldj').'").hide();';
				echo '}';
				echo 'jQuery("#'.$this->get_field_id('method').'").change(function(){';          
					echo "if (this.value == '1') {";
						echo 'jQuery("#'.$this->get_field_id('fieldj').'").slideUp();';
				   echo "} else {";
						echo 'jQuery("#'.$this->get_field_id('fieldj').'").slideDown();';
					echo '}';
				echo '});';
			echo '});';
		echo '</script>';

		// Codice javascript per abilitare/disabilitare il campo WIDTH

		echo '<script type="text/javascript">';
			echo 'jQuery(document).ready(function(){';
				echo 'if (jQuery("#'.$this->get_field_id('dfsize').'").is(":checked")) {';
					echo 'jQuery("#'.$this->get_field_id('width').'").prop("readonly",true);';
				echo '}';
				echo 'jQuery("#'.$this->get_field_id('dfsize').'").click(function(){';          
					echo 'if (jQuery("#'.$this->get_field_id('dfsize').'").is(":checked")) {';
						echo 'jQuery("#'.$this->get_field_id('width').'").prop("readonly",true);';
				   echo "} else {";
						echo 'jQuery("#'.$this->get_field_id('width').'").prop("readonly",false);';
					echo '}';
				echo '});';
			echo '});';
		echo '</script>';

		// Campo di selezione parametro badge per WIDTH

		echo '<table style="width:100%"><tr>';
		echo '<td><label for="'.$this->get_field_id('width').'">'.ucfirst(__('width','szgoogleadmin')).':</label></td>';
		echo '<td><input id="'.$this->get_field_id('width').'" name="'.$this->get_field_name('width').'" type="number" size="5" step="1" min="180" max="450" value="'.$width.'"/></td>';
		echo '<td><input class="checkbox" type="checkbox" id="'.$this->get_field_id('dfsize').'" name="'.$this->get_field_name('dfsize').'" value="1" '; checked($dfsize); echo '>&nbsp;'.ucfirst(__('default','szgoogleadmin')).'</td>';
		echo '</tr>';

		echo '<tr><td colspan="3"><hr></td></tr>';

		// Campo di selezione parametro badge per LAYOUT

		if ($layout == 'portrait')  { $check1=' checked'; $check2=''; }
			else { $check1=''; $check2=' checked'; }
		
		echo '<tr>';
		echo '<td><label for="'.$this->get_field_id('layout').'">'.ucfirst(__('layout','szgoogleadmin')).':</label></td>';
		echo '<td><input type="radio" name="'.$this->get_field_name('layout').'" value="portrait"' .$check1.'>&nbsp;'.ucfirst(__('portrait','szgoogleadmin')).'</td>';
		echo '<td><input type="radio" name="'.$this->get_field_name('layout').'" value="landscape"'.$check2.'>&nbsp;'.ucfirst(__('landscape','szgoogleadmin')).'</td>';
		echo '</tr>';

		// Campo di selezione parametro badge per THEME

		if ($theme == 'light')  { $check1=' checked'; $check2=''; }
			else { $check1=''; $check2=' checked'; }
		
		echo '<tr>';
		echo '<td><label for="'.$this->get_field_id('theme').'">'.ucfirst(__('theme','szgoogleadmin')).':</label></td>';
		echo '<td><input type="radio" name="'.$this->get_field_name('theme').'" value="light"'.$check1.'>&nbsp;'.ucfirst(__('light','szgoogleadmin')).'</td>';
		echo '<td><input type="radio" name="'.$this->get_field_name('theme').'" value="dark"' .$check2.'>&nbsp;'.ucfirst(__('dark','szgoogleadmin')).'</td>';
		echo '</tr>';

		// Campo di selezione parametro badge per PHOTO

		if ($photo == 'true')  { $check1=' checked'; $check2=''; }
			else { $check1=''; $check2=' checked'; }
		
		echo '<td><label for="'.$this->get_field_id('photo').'">'.ucfirst(__('cover','szgoogleadmin')).':</label></td>';
		echo '<td><input type="radio" name="'.$this->get_field_name('photo').'" value="true"' .$check1.'>&nbsp;'.ucfirst(__('enabled','szgoogleadmin')).'</td>';
		echo '<td><input type="radio" name="'.$this->get_field_name('photo').'" value="false"'.$check2.'>&nbsp;'.ucfirst(__('disabled','szgoogleadmin')).'</td>';
		echo '</tr>';

		// Campo di selezione parametro badge per TAGLINE

		if ($tagline == 'true')  { $check1=' checked'; $check2=''; }
			else { $check1=''; $check2=' checked'; }
		
		echo '<tr>';
		echo '<td><label for="'.$this->get_field_id('tagline').'">'.ucfirst(__('tagline','szgoogleadmin')).':</label></td>';
		echo '<td><input type="radio" name="'.$this->get_field_name('tagline').'" value="true"' .$check1.'>&nbsp;'.ucfirst(__('enabled','szgoogleadmin')).'</td>';
		echo '<td><input type="radio" name="'.$this->get_field_name('tagline').'" value="false"'.$check2.'>&nbsp;'.ucfirst(__('disabled','szgoogleadmin')).'</td>';
		echo '</tr>';

		// Campo di selezione parametro badge per PUBLISHER

		if ($publisher == 'true')  { $check1=' checked'; $check2=''; }
			else { $check1=''; $check2=' checked'; }
		
		echo '<tr>';
		echo '<td><label for="'.$this->get_field_id('publisher').'">'.ucfirst(__('publisher','szgoogleadmin')).':</label></td>';
		echo '<td><input type="radio" name="'.$this->get_field_name('publisher').'" value="true"' .$check1.'>&nbsp;'.ucfirst(__('enabled','szgoogleadmin')).'</td>';
		echo '<td><input type="radio" name="'.$this->get_field_name('publisher').'" value="false"'.$check2.'>&nbsp;'.ucfirst(__('disabled','szgoogleadmin')).'</td>';
		echo '</tr>';
		echo '</table>';
	}

}

/* ************************************************************************** */ 
/* SZ_Widget_Google_Community - Inserimento sulla sidebar come widget         */ 
/* ************************************************************************** */ 

class SZ_Widget_Google_Community extends WP_Widget 
{
	// Costruttore principale della classe widget, definizione 
	// delle opzioni legate al widget e al controllo dello stesso

	function SZ_Widget_Google_Community() {
		$widget_ops  = array(
			'classname'   => 'widget-sz-google', 
			'description' => ucfirst(__('widget for google+ community','szgoogleadmin'))
		);
		$this->WP_Widget('SZ-Google-Community',__('SZ-Google - G+ Community','szgoogleadmin'),$widget_ops);
	}

	// Funzione per la visualizzazione del widget con lettura parametri
	// di configurazione e preparazione codice HTML da usare nella sidebar

	function widget($args,$instance) 
	{
		extract($args);

		// Costruzione del titolo del widget

		if (empty($instance['title'])) $title = '';
			else $title = trim($instance['title']);

		$title = apply_filters('widget_title',$title,$instance,$this->id_base);

		if (!isset($before_title)) $before_title = '';
		if (!isset($after_title))  $after_title = '';

		if ($title and $title <> '') {
			$title = $before_title.$title.$after_title;
		}

		// Controllo se esistono le variabili di opzione

		if (empty($instance['method']))   $instance['method']   = '1';
		if (empty($instance['specific'])) $instance['specific'] = '';
		if (empty($instance['width']))    $instance['width']    = '';
		if (empty($instance['dfsize']))   $instance['dfsize']   = '';
		if (empty($instance['layout']))   $instance['layout']   = 'portrait';
		if (empty($instance['theme']))    $instance['theme']    = 'light';
		if (empty($instance['photo']))    $instance['photo']    = 'true';
		if (empty($instance['owner']))    $instance['owner']    = 'false';

		$method   = trim($instance['method']);
		$specific = trim($instance['specific']);
		$width    = trim($instance['width']);
		$dfsize   = trim($instance['dfsize']);
		$layout   = trim($instance['layout']);
		$theme    = trim($instance['theme']);
		$photo    = trim($instance['photo']);
		$owner    = trim($instance['owner']);

		// Caricamento delle opzioni per elaborazione

		$options = sz_google_modules_plus_options();

		// Correzione del valore di dimensione in caso di default
		// che può essere diverso tra portrait e landscape

		if ($width == '') {
			if ($layout == 'portrait' ) $width = SZ_PLUGIN_GOOGLE_WIDGET_SIZE_PORTRAIT;
			if ($layout == 'landscape') $width = SZ_PLUGIN_GOOGLE_WIDGET_SIZE_LANDSCAPE;
		}

		if ($dfsize == '1') {
			if ($layout == 'portrait' ) $width = $options['plus_widget_size_portrait'];
			if ($layout == 'landscape') $width = $options['plus_widget_size_landscape'];
		}

		// Calcolo del valore ID per la composizione del badge

		if ($method == '1') $community = $options['plus_community'];
		if ($method == '2') $community = $specific;

		// Se la community non esiste visualizzo la default

		if (!isset($community) or trim($community)=='') { 
			$community = SZ_PLUGIN_GOOGLE_PLUS_ID_COMMUNITY; 
		}

		// Creazione del codice per il badge di google+
		 
		$HTML  = '<div class="g-community"';
		$HTML .= ' data-href="https://plus.google.com/communities/'.$community.'"';
		$HTML .= ' data-width="'     .$width  .'"';
		$HTML .= ' data-layout="'    .$layout.'"';
		$HTML .= ' data-theme="'     .$theme .'"';
		$HTML .= ' data-showphoto="' .$photo .'"';
		$HTML .= ' data-showowners="'.$owner .'"';
		$HTML .= '></div>';

		// Output del codice HTML legato al widget da visualizzare		 

		$output  = '';
		$output .= $before_widget;
		$output .= $title;
		$output .= $HTML;
		$output .= $after_widget;

		echo $output;

		// Aggiunta del codice javascript per il rendering dei widget		 

		add_action('wp_footer','sz_google_modules_plus_add_script_footer');
	}

	// Funzione per modifica parametri collegati al widget con 
	// memorizzazione dei valori direttamente nel database wordpress

	function update($new_instance,$old_instance) 
	{
		$instance = $old_instance;

		$instance['title']    = trim(strip_tags($new_instance['title']));
		$instance['method']   = trim(strip_tags($new_instance['method']));
		$instance['specific'] = trim(strip_tags($new_instance['specific']));
		$instance['width']    = trim(strip_tags($new_instance['width']));
		$instance['layout']   = trim(strip_tags($new_instance['layout']));
		$instance['theme']    = trim(strip_tags($new_instance['theme']));
		$instance['photo']    = trim(strip_tags($new_instance['photo']));
		$instance['owner']    = trim(strip_tags($new_instance['owner']));

		if (!isset($new_instance['dfsize'])) $instance['dfsize'] = ''; 
			else $instance['dfsize'] = trim(strip_tags($new_instance['dfsize']));

		return $instance;
	}

	// Funzione per la visualizzazione del form presente sulle 
	// sidebar nel pannello di amministrazione di wordpress
	
	function form($instance) 
	{
		// Creazione array per elenco campi da recuperare su FORM

		$array = array(
			'title'    => '',
			'method'   => '1',
			'specific' => '',
			'width'    => SZ_PLUGIN_GOOGLE_WIDGET_SIZE_PORTRAIT,
			'dfsize'   => '1',
			'layout'   => 'portrait',
			'theme'    => 'light',
			'photo'    => 'true',
			'owner'    => 'false',
		);

		// Creazione array per elenco campi da recuperare su FORM

		$instance = wp_parse_args((array) $instance,$array);
		$title    = trim(strip_tags($instance['title']));
		$method   = trim(strip_tags($instance['method']));
		$specific = trim(strip_tags($instance['specific']));
		$width    = trim(strip_tags($instance['width']));
		$dfsize   = trim(strip_tags($instance['dfsize']));
		$layout   = trim(strip_tags($instance['layout']));
		$theme    = trim(strip_tags($instance['theme']));
		$photo    = trim(strip_tags($instance['photo']));
		$owner    = trim(strip_tags($instance['owner']));

		// Campo di selezione parametro badge per TITOLO

		echo '<p><label for="'.$this->get_field_id('title').'">'.ucfirst(__('title','szgoogleadmin')).':</label>';
		echo '<input class="widefat" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.esc_attr($title).'"/></p>';

		// Campo di selezione parametro badge per ID con metodo

		echo '<p><select class="widefat" id="'.$this->get_field_id('method').'" name="'.$this->get_field_name('method').'">';
		echo '<option value="1" '; selected("1",$method); echo '>'.ucfirst(__('configuration ID','szgoogleadmin')).'</option>';
		echo '<option value="2" '; selected("2",$method); echo '>'.ucfirst(__('specific ID','szgoogleadmin')).'</option>';
		echo '</select></p>';

		// Campo di selezione parametro badge per ID specifico

		echo '<p id="'.$this->get_field_id('fieldj').'">';
		echo '<input class="widefat" id="'.$this->get_field_id('specific').'" name="'.$this->get_field_name('specific').'" type="text" value="'.$specific.'" placeholder="'.__('insert specific ID','szgoogleadmin').'"/></p>';

		// Codice javascript per abilitare/disabilitare il campo ID specifico

		echo '<script type="text/javascript">';
			echo 'jQuery(document).ready(function(){';
				echo 'if (jQuery("#'.$this->get_field_id('method').'").val() == "1"){';
					echo 'jQuery("#'.$this->get_field_id('fieldj').'").hide();';
				echo '}';
				echo 'jQuery("#'.$this->get_field_id('method').'").change(function(){';          
					echo "if (this.value == '1') {";
						echo 'jQuery("#'.$this->get_field_id('fieldj').'").slideUp();';
				   echo "} else {";
						echo 'jQuery("#'.$this->get_field_id('fieldj').'").slideDown();';
					echo '}';
				echo '});';
			echo '});';
		echo '</script>';

		// Codice javascript per abilitare/disabilitare il campo WIDTH

		echo '<script type="text/javascript">';
			echo 'jQuery(document).ready(function(){';
				echo 'if (jQuery("#'.$this->get_field_id('dfsize').'").is(":checked")) {';
					echo 'jQuery("#'.$this->get_field_id('width').'").prop("readonly",true);';
				echo '}';
				echo 'jQuery("#'.$this->get_field_id('dfsize').'").click(function(){';          
					echo 'if (jQuery("#'.$this->get_field_id('dfsize').'").is(":checked")) {';
						echo 'jQuery("#'.$this->get_field_id('width').'").prop("readonly",true);';
				   echo "} else {";
						echo 'jQuery("#'.$this->get_field_id('width').'").prop("readonly",false);';
					echo '}';
				echo '});';
			echo '});';
		echo '</script>';

		// Campo di selezione parametro badge per WIDTH

		echo '<table style="width:100%"><tr>';
		echo '<td><label for="'.$this->get_field_id('width').'">'.ucfirst(__('width','szgoogleadmin')).':</label></td>';
		echo '<td><input id="'.$this->get_field_id('width').'" name="'.$this->get_field_name('width').'" type="number" size="5" step="1" min="180" max="450" value="'.$width.'"/></td>';
		echo '<td><input class="checkbox" type="checkbox" id="'.$this->get_field_id('dfsize').'" name="'.$this->get_field_name('dfsize').'" value="1" '; checked($dfsize); echo '>&nbsp;'.ucfirst(__('default','szgoogleadmin')).'</td>';
		echo '</tr>';

		echo '<tr><td colspan="3"><hr></td></tr>';

		// Campo di selezione parametro badge per LAYOUT

		if ($layout == 'portrait')  { $check1=' checked'; $check2=''; }
			else { $check1=''; $check2=' checked'; }
		
		echo '<tr>';
		echo '<td><label for="'.$this->get_field_id('layout').'">'.ucfirst(__('layout','szgoogleadmin')).':</label></td>';
		echo '<td><input type="radio" name="'.$this->get_field_name('layout').'" value="portrait"' .$check1.'>&nbsp;'.ucfirst(__('portrait','szgoogleadmin')).'</td>';
		echo '<td><input type="radio" name="'.$this->get_field_name('layout').'" value="landscape"'.$check2.'>&nbsp;'.ucfirst(__('landscape','szgoogleadmin')).'</td>';
		echo '</tr>';

		// Campo di selezione parametro badge per THEME

		if ($theme == 'light')  { $check1=' checked'; $check2=''; }
			else { $check1=''; $check2=' checked'; }
		
		echo '<tr>';
		echo '<td><label for="'.$this->get_field_id('theme').'">'.ucfirst(__('theme','szgoogleadmin')).':</label></td>';
		echo '<td><input type="radio" name="'.$this->get_field_name('theme').'" value="light"'.$check1.'>&nbsp;'.ucfirst(__('light','szgoogleadmin')).'</td>';
		echo '<td><input type="radio" name="'.$this->get_field_name('theme').'" value="dark"' .$check2.'>&nbsp;'.ucfirst(__('dark','szgoogleadmin')).'</td>';
		echo '</tr>';

		// Campo di selezione parametro badge per PHOTO

		if ($photo == 'true')  { $check1=' checked'; $check2=''; }
			else { $check1=''; $check2=' checked'; }
		
		echo '<td><label for="'.$this->get_field_id('photo').'">'.ucfirst(__('cover','szgoogleadmin')).':</label></td>';
		echo '<td><input type="radio" name="'.$this->get_field_name('photo').'" value="true"' .$check1.'>&nbsp;'.ucfirst(__('enabled','szgoogleadmin')).'</td>';
		echo '<td><input type="radio" name="'.$this->get_field_name('photo').'" value="false"'.$check2.'>&nbsp;'.ucfirst(__('disabled','szgoogleadmin')).'</td>';
		echo '</tr>';

		// Campo di selezione parametro badge per OWNER

		if ($owner == 'true')  { $check1=' checked'; $check2=''; }
			else { $check1=''; $check2=' checked'; }
		
		echo '<tr>';
		echo '<td><label for="'.$this->get_field_id('owner').'">'.ucfirst(__('owner','szgoogleadmin')).':</label></td>';
		echo '<td><input type="radio" name="'.$this->get_field_name('owner').'" value="true"' .$check1.'>&nbsp;'.ucfirst(__('enabled','szgoogleadmin')).'</td>';
		echo '<td><input type="radio" name="'.$this->get_field_name('owner').'" value="false"'.$check2.'>&nbsp;'.ucfirst(__('disabled','szgoogleadmin')).'</td>';
		echo '</tr>';
		echo '</table>';
	}

}

/* ************************************************************************** */ 
/* SZ_Widget_Google_Profile - Inserimento profilo sulla sidebar come widget   */ 
/* ************************************************************************** */ 

class SZ_Widget_Google_Comments extends WP_Widget
{
	// Costruttore principale della classe widget, definizione 
	// delle opzioni legate al widget e al controllo dello stesso

	function SZ_Widget_Google_Comments() {
		$widget_ops  = array(
			'classname'   => 'widget-sz-google', 
			'description' => ucfirst(__('widget for google+ comments','szgoogleadmin'))
		);
		$this->WP_Widget('SZ-Google-Comments',__('SZ-Google - G+ Comments','szgoogleadmin'),$widget_ops);
	}

	// Funzione per la visualizzazione del widget con lettura parametri
	// di configurazione e preparazione codice HTML da usare nella sidebar

	function widget($args,$instance) 
	{
		extract($args);

		// Costruzione del titolo del widget

		if (empty($instance['title'])) $title = '';
			else $title = trim($instance['title']);

		$title = apply_filters('widget_title',$title,$instance,$this->id_base);

		if (!isset($before_title)) $before_title = '';
		if (!isset($after_title))  $after_title = '';

		if ($title and $title <> '') {
			$title = $before_title.$title.$after_title;
		}

		// Controllo se esistono le variabili di opzione

		if (empty($instance['url']))        $instance['url']        = '';
		if (empty($instance['width']))      $instance['width']      = '';
		if (empty($instance['responsive'])) $instance['responsive'] = '1';

		$url        = trim($instance['url']);
		$width      = trim($instance['width']);
		$responsive = trim($instance['responsive']);

		// Imposto i valori di default nel caso siano specificati dei valori
		// che non appartengono al range dei valori accettati

		if ($url == '') $url = get_permalink();

		// Creazione codice univoco per l'inserimento del box commenti		 

		$uniqueID = 'sz-google-comments-'.md5(uniqid(),false);

		// Creazione codice HTML per inserimento widget commenti		 
	
		if ($responsive == '1' or !is_numeric($width) or $width == '' or $width == '0') 
		{ 
			$HTML  = '<div id="'.$uniqueID.'" class="sz-comments-shortcode">';
			$HTML .= '<script type="text/javascript">';
			$HTML .= "var w=document.getElementById('".$uniqueID."').offsetWidth;";
			$HTML .= "document.write('".'<div class="g-comments" data-href="'.$url.'" data-width="'."'+w+'".'" data-height="50" data-first_party_property="BLOGGER" data-view_type="FILTERED_POSTMOD"></div>'."');";
			$HTML .= '</script>';
			$HTML .= '</div>';

		} else {

			$HTML  = '<div id="'.$uniqueID.'" class="sz-comments-shortcode">';
			$HTML .= '<script type="text/javascript">';
			$HTML .= "var w=document.getElementById('".$uniqueID."').offsetWidth;";
			$HTML .= "document.write('".'<div class="g-comments" data-href="'.$url.'" data-width="'.$width.'" data-height="50" data-first_party_property="BLOGGER" data-view_type="FILTERED_POSTMOD"></div>'."');";
			$HTML .= '</script>';
			$HTML .= '</div>';
		}
		 
		// Output del codice HTML legato al widget da visualizzare		 

		$output  = '';
		$output .= $before_widget;
		$output .= $title;
		$output .= $HTML;
		$output .= $after_widget;

		echo $output;

		// Aggiunta del codice javascript per il rendering dei widget		 

		add_action('wp_footer','sz_google_modules_plus_add_script_footer');
	}

	// Funzione per modifica parametri collegati al widget con 
	// memorizzazione dei valori direttamente nel database wordpress

	function update($new_instance,$old_instance) 
	{
		$instance = $old_instance;

		$instance['url']        = trim($new_instance['url']);
		$instance['width']      = trim(strip_tags($new_instance['width']));
		$instance['responsive'] = trim(strip_tags($new_instance['responsive']));

		return $instance;
	}

	// Funzione per la visualizzazione del form presente sulle 
	// sidebar nel pannello di amministrazione di wordpress
	
	function form($instance) 
	{
		// Creazione array per elenco campi da recuperare su FORM

		$array = array(
			'url'        => '',
			'width'      => '',
			'responsive' => '1',
		);

		// Creazione array per elenco campi da recuperare su FORM

		$instance   = wp_parse_args((array) $instance,$array);
		$url        = trim($instance['url']);
		$width      = trim(strip_tags($instance['width']));
		$responsive = trim(strip_tags($instance['responsive']));

		// Campo di selezione parametro badge per TITOLO

		echo '<p><label for="'.$this->get_field_id('url').'">'.ucfirst(__('url','szgoogleadmin')).':</label>';
		echo '<input class="widefat" id="'.$this->get_field_id('url').'" name="'.$this->get_field_name('url').'" type="text" value="'.$url.'"/></p>';

		// Campo di selezione parametro badge per WIDTH

		echo '<table style="width:100%"><tr>';
		echo '<td><label for="'.$this->get_field_id('width').'">'.ucfirst(__('width','szgoogleadmin')).':</label></td>';
		echo '<td><input id="'.$this->get_field_id('width').'" name="'.$this->get_field_name('width').'" type="number" size="5" step="1" min="180" max="450" value="'.$width.'"/></td>';
		echo '<td><input class="checkbox" type="checkbox" id="'.$this->get_field_id('responsive').'" name="'.$this->get_field_name('responsive').'" value="1" '; checked($responsive); echo '>&nbsp;'.ucfirst(__('responsive','szgoogleadmin')).'</td>';
		echo '</tr>';
		echo '</table>';
	}

}