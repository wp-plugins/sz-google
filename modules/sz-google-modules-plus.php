<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_MODULES') or !SZ_PLUGIN_GOOGLE_MODULES) die();

/* ************************************************************************** */ 
/* Controllo le opzioni generali per i moduli che devo essere caricati        */
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

if ($options['plus_shortcode_fl_enable'] == SZ_PLUGIN_GOOGLE_VALUE_YES) {
	add_shortcode('sz-gplus-followers','sz_google_shortcodes_plus_followers');
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

if ($options['plus_widget_fl_enable'] == SZ_PLUGIN_GOOGLE_VALUE_YES) { 
	add_action('widgets_init', create_function('', 'return register_widget("SZ_Widget_Google_Followers");'));
}

if ($options['plus_button_enable_widget_plusone'] == SZ_PLUGIN_GOOGLE_VALUE_YES) {
	add_action('widgets_init',create_function('','return register_widget("sz_widget_google_plus_one");'));
}

if ($options['plus_button_enable_widget_sharing'] == SZ_PLUGIN_GOOGLE_VALUE_YES) {
	add_action('widgets_init',create_function('','return register_widget("sz_widget_google_plus_sharing");'));
}

if ($options['plus_button_enable_widget_follow'] == SZ_PLUGIN_GOOGLE_VALUE_YES) {
	add_action('widgets_init',create_function('','return register_widget("sz_widget_google_plus_follow");'));
}

if ($options['plus_comments_wd_enable'] == SZ_PLUGIN_GOOGLE_VALUE_YES) { 
	add_action('widgets_init',create_function('','return register_widget("SZ_Widget_Google_Comments");'));
}

if ($options['plus_post_enable_widget'] == SZ_PLUGIN_GOOGLE_VALUE_YES) {
	add_action('widgets_init',create_function('','return register_widget("SZ_Widget_Google_Post");'));
}

/* ************************************************************************** */ 
/* Funzione generale per il caricamento e la messa in coerenza delle opzioni  */
/* ************************************************************************** */ 

function sz_google_modules_plus_options()
{
	// Caricamento delle opzioni per modulo google plus

	$options = get_option('sz_google_options_plus');

	// Controllo delle opzioni in caso di valori non validi

	if (!isset($options['plus_profile']))                      $options['plus_profile']                      = SZ_PLUGIN_GOOGLE_VALUE_NULL;   
	if (!isset($options['plus_page']))                         $options['plus_page']                         = SZ_PLUGIN_GOOGLE_VALUE_NULL;
	if (!isset($options['plus_community']))                    $options['plus_community']                    = SZ_PLUGIN_GOOGLE_VALUE_NULL;
	if (!isset($options['plus_language']))                     $options['plus_language']                     = SZ_PLUGIN_GOOGLE_VALUE_LANG;   
	if (!isset($options['plus_widget_pr_enable']))             $options['plus_widget_pr_enable']             = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_widget_pa_enable']))             $options['plus_widget_pa_enable']             = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_widget_co_enable']))             $options['plus_widget_co_enable']             = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_widget_fl_enable']))             $options['plus_widget_fl_enable']             = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_widget_size_portrait']))         $options['plus_widget_size_portrait']         = SZ_PLUGIN_GOOGLE_VALUE_NULL;
	if (!isset($options['plus_widget_size_landscape']))        $options['plus_widget_size_landscape']        = SZ_PLUGIN_GOOGLE_VALUE_NULL;
	if (!isset($options['plus_shortcode_pr_enable']))          $options['plus_shortcode_pr_enable']          = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_shortcode_pa_enable']))          $options['plus_shortcode_pa_enable']          = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_shortcode_co_enable']))          $options['plus_shortcode_co_enable']          = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_shortcode_fl_enable']))          $options['plus_shortcode_fl_enable']          = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_shortcode_size_portrait']))      $options['plus_shortcode_size_portrait']      = SZ_PLUGIN_GOOGLE_VALUE_NULL;
	if (!isset($options['plus_shortcode_size_landscape']))     $options['plus_shortcode_size_landscape']     = SZ_PLUGIN_GOOGLE_VALUE_NULL;
	if (!isset($options['plus_button_enable_plusone']))        $options['plus_button_enable_plusone']        = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_button_enable_sharing']))        $options['plus_button_enable_sharing']        = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_button_enable_follow']))         $options['plus_button_enable_follow']         = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_button_enable_widget_plusone'])) $options['plus_button_enable_widget_plusone'] = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_button_enable_widget_sharing'])) $options['plus_button_enable_widget_sharing'] = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_button_enable_widget_follow']))  $options['plus_button_enable_widget_follow']  = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_comments_sh_enable']))           $options['plus_comments_sh_enable']           = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_comments_gp_enable']))           $options['plus_comments_gp_enable']           = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_comments_gp_enable']))           $options['plus_comments_gp_enable']           = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_comments_wp_enable']))           $options['plus_comments_wp_enable']           = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_comments_ac_enable']))           $options['plus_comments_ac_enable']           = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_comments_aw_enable']))           $options['plus_comments_aw_enable']           = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_comments_dt_enable']))           $options['plus_comments_dt_enable']           = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_comments_dt_day']))              $options['plus_comments_dt_day']              = '01';  
	if (!isset($options['plus_comments_dt_month']))            $options['plus_comments_dt_month']            = '01';
	if (!isset($options['plus_comments_dt_year']))             $options['plus_comments_dt_year']             = '2000';
	if (!isset($options['plus_comments_fixed_size']))          $options['plus_comments_fixed_size']          = SZ_PLUGIN_GOOGLE_VALUE_NULL;
	if (!isset($options['plus_comments_title']))               $options['plus_comments_title']               = SZ_PLUGIN_GOOGLE_VALUE_NULL;
	if (!isset($options['plus_comments_css_class_1']))         $options['plus_comments_css_class_1']         = SZ_PLUGIN_GOOGLE_VALUE_NULL;
	if (!isset($options['plus_comments_css_class_2']))         $options['plus_comments_css_class_2']         = SZ_PLUGIN_GOOGLE_VALUE_NULL;
	if (!isset($options['plus_redirect_sign']))                $options['plus_redirect_sign']                = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_redirect_plus']))                $options['plus_redirect_plus']                = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_redirect_curl']))                $options['plus_redirect_curl']                = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_redirect_curl_dir']))            $options['plus_redirect_curl_dir']            = SZ_PLUGIN_GOOGLE_VALUE_NULL;
	if (!isset($options['plus_redirect_curl_url']))            $options['plus_redirect_curl_url']            = SZ_PLUGIN_GOOGLE_VALUE_NULL;
	if (!isset($options['plus_redirect_flush']))               $options['plus_redirect_flush']               = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_system_javascript']))            $options['plus_system_javascript']            = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_post_enable_widget']))           $options['plus_post_enable_widget']           = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['plus_post_enable_shortcode']))        $options['plus_post_enable_shortcode']        = SZ_PLUGIN_GOOGLE_VALUE_NO;

	// Controllo delle opzioni in caso di valori non validi

	if (trim($options['plus_language'])                 == SZ_PLUGIN_GOOGLE_VALUE_NULL) $options['plus_language']                 = SZ_PLUGIN_GOOGLE_VALUE_LANG;   
	if (trim($options['plus_widget_size_portrait'])     == SZ_PLUGIN_GOOGLE_VALUE_NULL) $options['plus_widget_size_portrait']     = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_SIZE_PORTRAIT;
	if (trim($options['plus_widget_size_landscape'])    == SZ_PLUGIN_GOOGLE_VALUE_NULL) $options['plus_widget_size_landscape']    = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_SIZE_LANDSCAPE;
	if (trim($options['plus_shortcode_size_portrait'])  == SZ_PLUGIN_GOOGLE_VALUE_NULL) $options['plus_shortcode_size_portrait']  = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_SIZE_PORTRAIT;
	if (trim($options['plus_shortcode_size_landscape']) == SZ_PLUGIN_GOOGLE_VALUE_NULL) $options['plus_shortcode_size_landscape'] = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_SIZE_LANDSCAPE;
	if (trim($options['plus_comments_fixed_size'])      == SZ_PLUGIN_GOOGLE_VALUE_ZERO) $options['plus_comments_fixed_size']      = SZ_PLUGIN_GOOGLE_VALUE_NULL;

	// Se trovo un valore non riconosciuto imposto dei valori predefiniti validi

	$selects = array(SZ_PLUGIN_GOOGLE_VALUE_NO,SZ_PLUGIN_GOOGLE_VALUE_YES);

	if (!in_array($options['plus_widget_pr_enable'],            $selects)) $options['plus_widget_pr_enable']             = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_widget_pa_enable'],            $selects)) $options['plus_widget_pa_enable']             = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_widget_co_enable'],            $selects)) $options['plus_widget_co_enable']             = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_widget_fl_enable'],            $selects)) $options['plus_widget_fl_enable']             = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_shortcode_pr_enable'],         $selects)) $options['plus_shortcode_pr_enable']          = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_shortcode_pa_enable'],         $selects)) $options['plus_shortcode_pa_enable']          = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_shortcode_co_enable'],         $selects)) $options['plus_shortcode_co_enable']          = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_shortcode_fl_enable'],         $selects)) $options['plus_shortcode_fl_enable']          = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_button_enable_plusone'],       $selects)) $options['plus_button_enable_plusone']        = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_button_enable_sharing'],       $selects)) $options['plus_button_enable_sharing']        = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_button_enable_follow'],        $selects)) $options['plus_button_enable_follow']         = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_button_enable_widget_plusone'],$selects)) $options['plus_button_enable_widget_plusone'] = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_button_enable_widget_sharing'],$selects)) $options['plus_button_enable_widget_sharing'] = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_button_enable_widget_follow'], $selects)) $options['plus_button_enable_widget_follow']  = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_comments_sh_enable'],          $selects)) $options['plus_comments_sh_enable']           = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_comments_gp_enable'],          $selects)) $options['plus_comments_gp_enable']           = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_comments_gp_enable'],          $selects)) $options['plus_comments_gp_enable']           = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_comments_wp_enable'],          $selects)) $options['plus_comments_wp_enable']           = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_comments_ac_enable'],          $selects)) $options['plus_comments_ac_enable']           = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_comments_aw_enable'],          $selects)) $options['plus_comments_aw_enable']           = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_comments_dt_enable'],          $selects)) $options['plus_comments_dt_enable']           = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_redirect_sign'],               $selects)) $options['plus_redirect_sign']                = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_redirect_plus'],               $selects)) $options['plus_redirect_plus']                = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_redirect_curl'],               $selects)) $options['plus_redirect_curl']                = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_redirect_flush'],              $selects)) $options['plus_redirect_flush']               = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_system_javascript'],           $selects)) $options['plus_system_javascript']            = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_post_enable_widget'],          $selects)) $options['plus_post_enable_widget']           = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['plus_post_enable_shortcode'],       $selects)) $options['plus_post_enable_shortcode']        = SZ_PLUGIN_GOOGLE_VALUE_NO;

	return $options;
}

/* ************************************************************************** */
/* PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PL */
/* PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PL */
/* PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PL */
/* PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PL */
/* PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PL */
/* ************************************************************************** */

function sz_google_modules_plus_get_code_plusone($atts=array(),$content=null)
{
	// Estrazione dei valori specificati nello shortcode, i valori ritornati
	// sono contenuti nei nomi di variabili corrispondenti alla chiave

	if (!is_array($atts)) $atts = array();

	$DEFAULT_SIZE       = 'standard';
	$DEFAULT_ANNOTATION = 'none';
	$DEFAULT_ALIGN      = 'none';
	$DEFAULT_POSITION   = 'outside';

	extract(shortcode_atts(array(
		'url'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'size'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'width'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'annotation'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'align'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'text'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'img'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'position'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'margintop'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginright'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginbottom' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginleft'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginunit'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts));

	// Elimino spazi aggiunti di troppo ed esegui la trasformazione in
	// stringa minuscolo per il controllo di valori speciali come "auto"

	$url          = trim($url);
	$text         = trim($text);
	$img          = trim($img);

	$width        = strtolower(trim($width));
	$size         = strtolower(trim($size));
	$annotation   = strtolower(trim($annotation));
	$align        = strtolower(trim($align));
	$position     = strtolower(trim($position));
	$margintop    = strtolower(trim($margintop));
	$marginright  = strtolower(trim($marginright));
	$marginbottom = strtolower(trim($marginbottom));
	$marginleft   = strtolower(trim($marginleft));
	$marginunit   = strtolower(trim($marginunit));

	// Imposto i valori di default nel caso siano specificati dei valori
	// che non appartengono al range dei valori accettati

	if (!in_array($size,array('small','medium','standard','tail'))) $size = $DEFAULT_SIZE;
	if (!in_array($annotation,array('inline','bubble','none'))) $annotation = $DEFAULT_ANNOTATION; 
	if (!in_array($align,array('none','left','right','center'))) $align = $DEFAULT_ALIGN; 
	if (!in_array($position,array('top','center','bottom','outside'))) $position = $DEFAULT_POSITION; 

	// Se non specifico un URL fisso imposto il permalink attuale

	if ($url == SZ_PLUGIN_GOOGLE_VALUE_NULL) $url = get_permalink();

	// Creazione codice HTML per embed code da inserire nella pagina wordpress

	$HTML  = '<div class="g-plusone"';

	if ($width != SZ_PLUGIN_GOOGLE_VALUE_NULL) $HTML .= ' data-width="'.$width.'"';
	if ($align == 'right') $HTML .= ' data-align="right"';

	$HTML .= ' data-href="'      .$url       .'"';
	$HTML .= ' data-size="'      .$size      .'"';
	$HTML .= ' data-annotation="'.$annotation.'"';
	$HTML .= '></div>';

	$HTML = sz_google_modules_plus_get_code_button_wrap(array(
		'html'         => $HTML,
		'text'         => $text,
		'image'        => $img,
		'content'      => $content,
		'align'        => $align,
		'position'     => $position,
		'margintop'    => $margintop,
		'marginright'  => $marginright,
		'marginbottom' => $marginbottom,
		'marginleft'   => $marginleft,
		'marginunit'   => $marginunit,
		'class'        => 'sz-google-plusone',
	));

	// Aggiunta del codice javascript per il rendering dei widget, questo codice		 
	// viene aggiungo anche dalla sidebar però viene inserito una sola volta

	add_action('wp_footer','sz_google_modules_plus_add_script_footer');

	// Ritorno per la funzione con tutta la stringa contenente
	// il codice HTML per l'inserimento del codice nella pagina

	return $HTML;
}

/* ************************************************************************** */
/* GOOGLE+ PLUS ONE funzione per elaborazione shortcode (sz-gplus-plusone)    */
/* ************************************************************************** */

function sz_google_shortcodes_plus_plusone($atts,$content=null) 
{
	extract(shortcode_atts(array(
		'url'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'size'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'width'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'annotation'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'align'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'text'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'img'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'position'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'margintop'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginright'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginbottom' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginleft'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginunit'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts));

	// Preparazione codice HTML dello shortcode tramite la funzione
	// standard di preparazione codice sia per shortcode che widgets

	$HTML = sz_google_modules_plus_get_code_plusone(array(
		'url'          => trim($url),
		'size'         => trim($size),
		'width'        => trim($width),
		'annotation'   => trim($annotation),
		'align'        => trim($align),
		'text'         => trim($text),
		'img'          => trim($img),
		'position'     => trim($position),
		'margintop'    => trim($margintop),
		'marginright'  => trim($marginright),
		'marginbottom' => trim($marginbottom),
		'marginleft'   => trim($marginleft),
		'marginunit'   => trim($marginunit),
	),$content);

	// Ritorno per la funzione con tutta la stringa contenente
	// il codice HTML per l'inserimento del codice nella pagina

	return $HTML;
}

/* ************************************************************************** */ 
/* GOOGLE+ PLUS ONE definizione ed elaborazione del widget su sidebar         */ 
/* ************************************************************************** */ 

class sz_widget_google_plus_one extends WP_Widget
{
	// Costruttore principale della classe widget, definizione 
	// delle opzioni legate al widget e al controllo dello stesso

	function sz_widget_google_plus_one() 
	{
		$widget_ops  = array(
			'classname'   => 'sz-widget-google sz-widget-google-plus sz-widget-google-plus-one', 
			'description' => ucfirst(__('widget for google+ button +1','szgoogleadmin'))
		);

		$this->WP_Widget('SZ-GOOGLE-PLUS-ONE',
			__('SZ-Google - G+ Plus one','szgoogleadmin'),$widget_ops);
	}

	// Funzione per la visualizzazione del widget con lettura parametri
	// di configurazione e preparazione codice HTML da usare nella sidebar

	function widget($args,$instance) 
	{
		extract($args);

		// Costruzione del titolo del widget tramite la funzione
		// di uso comune a tutti i widgets del plugin sz-google

		$title = sz_google_modules_widget_title($args,$instance);

		// Controllo se esistono le variabili che servono durante l'elaborazione
		// dello script e assegno dei valori di default nel caso non fossero specificati

		if (empty($instance['url']))        $instance['url']        = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['urltype']))    $instance['urltype']    = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['badge']))      $instance['badge']      = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['img']))        $instance['img']        = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['text']))       $instance['text']       = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['align']))      $instance['align']      = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['position']))   $instance['position']   = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['size']))       $instance['size']       = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['annotation'])) $instance['annotation'] = SZ_PLUGIN_GOOGLE_VALUE_NULL;

		// Se sul widget ho escluso il badge dal pulsante azzero anche
		// le variabili del badge eventualmente impostate e memorizzate 

		if ($instance['badge'] != SZ_PLUGIN_GOOGLE_VALUE_YES) 
		{
			$instance['img']      = SZ_PLUGIN_GOOGLE_VALUE_NULL;
			$instance['text']     = SZ_PLUGIN_GOOGLE_VALUE_NULL;
			$instance['position'] = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		}

		// Se sul widget ho selezionato di calcolare l'indirizzo dal 
		// post corrente annullo la variabile con eventuale indirizzo 

		if ($instance['urltype'] != SZ_PLUGIN_GOOGLE_VALUE_YES) {
			$instance['url'] = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		}

		// Dopo il controllo di esistenza per tutte le opzioni necessarie
		// eseguo il trim e la conversione in minuscolo per le opzioni 

		$url        = trim($instance['url']);
		$text       = trim($instance['text']);
		$img        = trim($instance['img']);

		$align      = strtolower(trim($instance['align']));
		$position   = strtolower(trim($instance['position']));
		$size       = strtolower(trim($instance['size']));
		$annotation = strtolower(trim($instance['annotation']));

		// Creazione codice HTML per inserimento widget post		 

		$HTML = sz_google_modules_plus_get_code_plusone(array(
			'url'          => trim($url),
			'filename'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'sitename'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'text'         => trim($text),
			'img'          => trim($img),
			'position'     => trim($position),
			'align'        => trim($align),
			'size'         => trim($size),
			'annotation'   => trim($annotation),
			'margintop'    => SZ_PLUGIN_GOOGLE_VALUE_NONE,
			'marginright'  => SZ_PLUGIN_GOOGLE_VALUE_NONE,
			'marginbottom' => SZ_PLUGIN_GOOGLE_VALUE_NONE,
			'marginleft'   => SZ_PLUGIN_GOOGLE_VALUE_NONE,
			'marginunit'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		));

		// Output del codice HTML legato al widget da visualizzare		 

		$output  = $before_widget;
		$output .= $title;
		$output .= $HTML;
		$output .= $after_widget;

		echo $output;
	}

	// Funzione per modifica parametri collegati al widget con 
	// memorizzazione dei valori direttamente nel database wordpress

	function update($new_instance,$old_instance) 
	{
		$instance = $old_instance;

		if (!isset($new_instance['title']))      $new_instance['title']      = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['badge']))      $new_instance['badge']      = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['url']))        $new_instance['url']        = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['urltype']))    $new_instance['urltype']    = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['text']))       $new_instance['text']       = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['img']))        $new_instance['img']        = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['align']))      $new_instance['align']      = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['position']))   $new_instance['position']   = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['size']))       $new_instance['size']       = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['annotation'])) $new_instance['annotation'] = SZ_PLUGIN_GOOGLE_VALUE_NULL; 

		$instance['url']        = trim($new_instance['url']);
		$instance['text']       = trim($new_instance['text']);
		$instance['img']        = trim($new_instance['img']);

		$instance['urltype']    = trim(strip_tags($new_instance['urltype']));
		$instance['title']      = trim(strip_tags($new_instance['title']));
		$instance['badge']      = trim(strip_tags($new_instance['badge']));
		$instance['align']      = trim(strip_tags($new_instance['align']));
		$instance['position']   = trim(strip_tags($new_instance['position']));
		$instance['size']       = trim(strip_tags($new_instance['size']));
		$instance['annotation'] = trim(strip_tags($new_instance['annotation']));

		return $instance;
	}

	// Funzione per la visualizzazione del form presente sulle 
	// sidebar nel pannello di amministrazione di wordpress
	
	function form($instance) 
	{
		$array = array(
			'title'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'badge'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'url'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'urltype'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'text'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'img'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'align'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'position'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'size'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'annotation' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		);

		// Creazione array per elenco campi da recuperare su FORM

		$instance = wp_parse_args((array) $instance,$array);

		$url        = trim($instance['url']);
		$text       = trim($instance['text']);
		$img        = trim($instance['img']);

		$urltype    = trim(strip_tags($instance['urltype']));
		$badge      = trim(strip_tags($instance['badge']));
		$title      = trim(strip_tags($instance['title']));
		$align      = trim(strip_tags($instance['align']));
		$position   = trim(strip_tags($instance['position']));
		$size       = trim(strip_tags($instance['size']));
		$annotation = trim(strip_tags($instance['annotation']));

		// Campo di selezione parametro badge per TITOLO

		echo '<table style="width:100%">';

		echo '<tr>';
		echo '<td colspan="2">';
		echo '<label for="'.$this->get_field_id('title').'">'.ucfirst(__('title','szgoogleadmin')).':</label>';
		echo '<input class="widefat" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.esc_attr($title).'"/>';
		echo '</td>';
		echo '</tr>';

		echo '<tr>';
		echo '<td colspan="2"><select class="sz-google-switch-hidden widefat" id="'.$this->get_field_id('urltype').'" name="'.$this->get_field_name('urltype').'" onchange="szgoogle_switch_hidden(this);" data-switch="sz-google-switch-url">';
		echo '<option value="0" '; selected("0",$urltype); echo '>'.__('current post address','szgoogleadmin').'</option>';
		echo '<option value="1" '; selected("1",$urltype); echo '>'.__('specific url address','szgoogleadmin').'</option>';
		echo '</select></td>';
		echo '</tr>';

		// Campo di selezione parametro URL del file che deve essere memorizzato su drive

		echo '<tr class="sz-google-switch-url">';
		echo '<td colspan="2"><input class="sz-upload-image-url widefat" id="'.$this->get_field_id('url').'" name="'.$this->get_field_name('url').'" type="text" value="'.$url.'" placeholder="'.__('insert source URL','szgoogleadmin').'"/></td>';
		echo '</tr>';

		// Campo di selezione parametro per scegliere se visualizzare il badge insieme al bottone

		echo '<tr>';
		echo '<td colspan="2"><select class="sz-google-switch-hidden widefat" id="'.$this->get_field_id('badge').'" name="'.$this->get_field_name('badge').'" onchange="szgoogle_switch_hidden(this);" data-switch="sz-google-switch-display">';
		echo '<option value="0" '; selected("0",$badge); echo '>'.__('button without badge','szgoogleadmin').'</option>';
		echo '<option value="1" '; selected("1",$badge); echo '>'.__('button with badge','szgoogleadmin').'</option>';
		echo '</select></td>';
		echo '</tr>';

		// Campo di selezione parametro testo da utilizzare come badge del pulsante

		echo '<tr class="sz-google-switch-display">';
		echo '<td colspan="2"><textarea class="widefat" rows="3" cols="20" id="'.$this->get_field_id('text').'" name="'.$this->get_field_name('text').'" placeholder="'.__('insert text for badge','szgoogleadmin').'">'.esc_attr($text).'</textarea></td>';
		echo '</tr>';

		// Campo di selezione parametro IMG del file che deve essere memorizzato su drive

		echo '<tr class="sz-google-switch-display">';
		echo '<td><input class="sz-upload-image-url-2 widefat" id="'.$this->get_field_id('img').'" name="'.$this->get_field_name('img').'" type="text" value="'.$img.'" placeholder="'.__('choose image for badge','szgoogleadmin').'"/></td>';
		echo '<td><input class="sz-upload-image-button button" type="button" value="'.ucfirst(__('select file','szgoogleadmin')).'" data-field-url="sz-upload-image-url-2" data-title="'.ucfirst(__('select or upload a file','szgoogleadmin')).'" data-button-text="'.ucfirst(__('confirm selection','szgoogleadmin')).'"/></td>';
		echo '</tr>';

		// Campo di selezione parametro badge per POSITION

		echo '<tr class="sz-google-switch-display">';
		echo '<td colspan="2"><select class="widefat" id="'.$this->get_field_id('position').'" name="'.$this->get_field_name('position').'">';
		echo '<option value="outside" '; selected("outside",$position); echo '>'.__('button position outside','szgoogleadmin').'</option>';
		echo '<option value="top" ';     selected("top"    ,$position); echo '>'.__('button position top','szgoogleadmin').'</option>';
		echo '<option value="center" ';  selected("center" ,$position); echo '>'.__('button position center','szgoogleadmin').'</option>';
		echo '<option value="bottom" ';  selected("bottom" ,$position); echo '>'.__('button position bottom','szgoogleadmin').'</option>';
		echo '</select></td>';
		echo '</tr>';

		// Campo di selezione parametro badge per ALIGN

		echo '<tr>';
		echo '<td colspan="2"><select class="widefat" id="'.$this->get_field_id('align').'" name="'.$this->get_field_name('align').'">';
		echo '<option value="none" '  ; selected("none"  ,$align); echo '>'.__('button alignment none','szgoogleadmin').'</option>';
		echo '<option value="left" '  ; selected("left"  ,$align); echo '>'.__('button alignment left','szgoogleadmin').'</option>';
		echo '<option value="center" '; selected("center",$align); echo '>'.__('button alignment center','szgoogleadmin').'</option>';
		echo '<option value="right" ' ; selected("right" ,$align); echo '>'.__('button alignment right','szgoogleadmin').'</option>';
		echo '</select></td>';
		echo '</tr>';

		// Campo di selezione parametro per button size

		echo '<tr>';
		echo '<td colspan="2"><select class="widefat" id="'.$this->get_field_id('size').'" name="'.$this->get_field_name('size').'">';
		echo '<option value="standard" ' ; selected("standard",$size); echo '>'.__('size standard','szgoogleadmin').'</option>';
		echo '<option value="small" '    ; selected("small"   ,$size); echo '>'.__('size small','szgoogleadmin').'</option>';
		echo '<option value="medium" '   ; selected("medium"  ,$size); echo '>'.__('size medium','szgoogleadmin').'</option>';
		echo '<option value="tail" '     ; selected("tail"    ,$size); echo '>'.__('size tail','szgoogleadmin').'</option>';
		echo '</select></td>';
		echo '</tr>';

		// Campo di selezione parametro per button annotation

		echo '<tr>';
		echo '<td colspan="2"><select class="widefat" id="'.$this->get_field_id('annotation').'" name="'.$this->get_field_name('annotation').'">';
		echo '<option value="none" '  ; selected("none"  ,$annotation); echo '>'.__('annotation none','szgoogleadmin').'</option>';
		echo '<option value="inline" '; selected("inline",$annotation); echo '>'.__('annotation inline','szgoogleadmin').'</option>';
		echo '<option value="bubble" '; selected("bubble",$annotation); echo '>'.__('annotation bubble','szgoogleadmin').'</option>';
		echo '</select></td>';
		echo '</tr>';

		echo '</table>';

		// Codice javascript per abilitare/disabilitare le funzioni dei campi, attenzione che 
		// la definizione document.ready viene specificata qui perchè sul file iniziale non funziona

		echo '<script type="text/javascript">';
			echo 'jQuery(document).ready(function(){';
				echo 'szgoogle_switch_hidden_ready();';
				echo 'szgoogle_media_uploader();';
			echo '});';
		echo '</script>';
	}
}

/* ************************************************************************** */
/* SHARING SHARING SHARING SHARING SHARING SHARING SHARING SHARING SHARING SH */
/* SHARING SHARING SHARING SHARING SHARING SHARING SHARING SHARING SHARING SH */
/* SHARING SHARING SHARING SHARING SHARING SHARING SHARING SHARING SHARING SH */
/* SHARING SHARING SHARING SHARING SHARING SHARING SHARING SHARING SHARING SH */
/* SHARING SHARING SHARING SHARING SHARING SHARING SHARING SHARING SHARING SH */
/* ************************************************************************** */

function sz_google_modules_plus_get_code_sharing($atts=array(),$content=null)
{
	// Estrazione dei valori specificati nello shortcode, i valori ritornati
	// sono contenuti nei nomi di variabili corrispondenti alla chiave

	if (!is_array($atts)) $atts = array();

	$DEFAULT_SIZE       = 'medium';
	$DEFAULT_ANNOTATION = 'inline';
	$DEFAULT_ALIGN      = 'none';
	$DEFAULT_POSITION   = 'outside';

	extract(shortcode_atts(array(
		'url'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'size'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'width'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'annotation'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'align'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'text'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'img'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'position'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'margintop'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginright'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginbottom' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginleft'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginunit'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts));

	// Elimino spazi aggiunti di troppo ed esegui la trasformazione in
	// stringa minuscolo per il controllo di valori speciali come "auto"

	$url          = trim($url);
	$text         = trim($text);
	$img          = trim($img);

	$width        = strtolower(trim($width));
	$size         = strtolower(trim($size));
	$annotation   = strtolower(trim($annotation));
	$align        = strtolower(trim($align));
	$position     = strtolower(trim($position));
	$margintop    = strtolower(trim($margintop));
	$marginright  = strtolower(trim($marginright));
	$marginbottom = strtolower(trim($marginbottom));
	$marginleft   = strtolower(trim($marginleft));
	$marginunit   = strtolower(trim($marginunit));

	// Imposto i valori di default nel caso siano specificati dei valori
	// che non appartengono al range dei valori accettati

	if (!in_array($size,array('small','medium','large'))) $size = $DEFAULT_SIZE;
	if (!in_array($annotation,array('inline','bubble','vertical-bubble','none'))) $annotation = $DEFAULT_ANNOTATION; 
	if (!in_array($align,array('none','left','right','center'))) $align = $DEFAULT_ALIGN; 
	if (!in_array($position,array('top','center','bottom','outside'))) $position = $DEFAULT_POSITION; 

	// Se non specifico un URL fisso imposto il permalink attuale

	if ($url == SZ_PLUGIN_GOOGLE_VALUE_NULL) $url = get_permalink();

	// Preparazione codice HTML per il badge di google plus

	$HTML  = '<div class="g-plus"';
	$HTML .= ' data-action="share"';	
	$HTML .= ' data-href="'      .$url       .'"';
	$HTML .= ' data-annotation="'.$annotation.'"';

	if ($size  == 'small')  $HTML .= ' data-height="15"';
	if ($size  == 'medium') $HTML .= ' data-height="20"';
	if ($size  == 'large')  $HTML .= ' data-height="24"';
	if ($width != '')       $HTML .= ' data-width="'.$width.'"';
	if ($align == 'right')  $HTML .= ' data-align="right"';

	$HTML .= '></div>';

	$HTML = sz_google_modules_plus_get_code_button_wrap(array(
		'html'         => $HTML,
		'text'         => $text,
		'image'        => $img,
		'content'      => $content,
		'align'        => $align,
		'position'     => $position,
		'margintop'    => $margintop,
		'marginright'  => $marginright,
		'marginbottom' => $marginbottom,
		'marginleft'   => $marginleft,
		'marginunit'   => $marginunit,
		'class'        => 'sz-google-sharing',
	));

	// Aggiunta del codice javascript per il rendering dei widget, questo codice		 
	// viene aggiungo anche dalla sidebar però viene inserito una sola volta

	add_action('wp_footer','sz_google_modules_plus_add_script_footer');

	// Ritorno per la funzione con tutta la stringa contenente
	// il codice HTML per l'inserimento del codice nella pagina

	return $HTML;
}

/* ************************************************************************** */
/* GOOGLE+ SHARING funzione per elaborazione shortcode (sz-gplus-share)       */
/* ************************************************************************** */

function sz_google_shortcodes_plus_sharing($atts,$content=null) 
{
	extract(shortcode_atts(array(
		'url'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'size'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'width'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'annotation'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'align'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'text'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'img'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'position'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'margintop'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginright'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginbottom' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginleft'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginunit'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts));

	// Preparazione codice HTML dello shortcode tramite la funzione
	// standard di preparazione codice sia per shortcode che widgets

	$HTML = sz_google_modules_plus_get_code_sharing(array(
		'url'          => trim($url),
		'size'         => trim($size),
		'width'        => trim($width),
		'annotation'   => trim($annotation),
		'align'        => trim($align),
		'text'         => trim($text),
		'img'          => trim($img),
		'position'     => trim($position),
		'margintop'    => trim($margintop),
		'marginright'  => trim($marginright),
		'marginbottom' => trim($marginbottom),
		'marginleft'   => trim($marginleft),
		'marginunit'   => trim($marginunit),
	),$content);

	// Ritorno per la funzione con tutta la stringa contenente
	// il codice HTML per l'inserimento del codice nella pagina

	return $HTML;
}

/* ************************************************************************** */ 
/* GOOGLE+ SHARING definizione ed elaborazione del widget su sidebar          */ 
/* ************************************************************************** */ 

class sz_widget_google_plus_sharing extends WP_Widget
{
	// Costruttore principale della classe widget, definizione 
	// delle opzioni legate al widget e al controllo dello stesso

	function sz_widget_google_plus_sharing() 
	{
		$widget_ops  = array(
			'classname'   => 'sz-widget-google sz-widget-google-plus sz-widget-google-plus-sharing', 
			'description' => ucfirst(__('widget for google+ sharing','szgoogleadmin'))
		);

		$this->WP_Widget('SZ-GOOGLE-PLUS-SHARING',
			__('SZ-Google - G+ Sharing','szgoogleadmin'),$widget_ops);
	}

	// Funzione per la visualizzazione del widget con lettura parametri
	// di configurazione e preparazione codice HTML da usare nella sidebar

	function widget($args,$instance) 
	{
		extract($args);

		// Costruzione del titolo del widget tramite la funzione
		// di uso comune a tutti i widgets del plugin sz-google

		$title = sz_google_modules_widget_title($args,$instance);

		// Controllo se esistono le variabili che servono durante l'elaborazione
		// dello script e assegno dei valori di default nel caso non fossero specificati

		if (empty($instance['url']))        $instance['url']        = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['urltype']))    $instance['urltype']    = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['badge']))      $instance['badge']      = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['img']))        $instance['img']        = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['text']))       $instance['text']       = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['align']))      $instance['align']      = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['position']))   $instance['position']   = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['size']))       $instance['size']       = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['annotation'])) $instance['annotation'] = SZ_PLUGIN_GOOGLE_VALUE_NULL;

		// Se sul widget ho escluso il badge dal pulsante azzero anche
		// le variabili del badge eventualmente impostate e memorizzate 

		if ($instance['badge'] != SZ_PLUGIN_GOOGLE_VALUE_YES) 
		{
			$instance['img']      = SZ_PLUGIN_GOOGLE_VALUE_NULL;
			$instance['text']     = SZ_PLUGIN_GOOGLE_VALUE_NULL;
			$instance['position'] = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		}

		// Se sul widget ho selezionato di calcolare l'indirizzo dal 
		// post corrente annullo la variabile con eventuale indirizzo 

		if ($instance['urltype'] != SZ_PLUGIN_GOOGLE_VALUE_YES) {
			$instance['url'] = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		}

		// Dopo il controllo di esistenza per tutte le opzioni necessarie
		// eseguo il trim e la conversione in minuscolo per le opzioni 

		$url        = trim($instance['url']);
		$text       = trim($instance['text']);
		$img        = trim($instance['img']);

		$align      = strtolower(trim($instance['align']));
		$position   = strtolower(trim($instance['position']));
		$size       = strtolower(trim($instance['size']));
		$annotation = strtolower(trim($instance['annotation']));

		// Creazione codice HTML per inserimento widget post		 

		$HTML = sz_google_modules_plus_get_code_sharing(array(
			'url'          => trim($url),
			'filename'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'sitename'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'text'         => trim($text),
			'img'          => trim($img),
			'position'     => trim($position),
			'align'        => trim($align),
			'size'         => trim($size),
			'annotation'   => trim($annotation),
			'margintop'    => SZ_PLUGIN_GOOGLE_VALUE_NONE,
			'marginright'  => SZ_PLUGIN_GOOGLE_VALUE_NONE,
			'marginbottom' => SZ_PLUGIN_GOOGLE_VALUE_NONE,
			'marginleft'   => SZ_PLUGIN_GOOGLE_VALUE_NONE,
			'marginunit'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		));

		// Output del codice HTML legato al widget da visualizzare		 

		$output  = $before_widget;
		$output .= $title;
		$output .= $HTML;
		$output .= $after_widget;

		echo $output;
	}

	// Funzione per modifica parametri collegati al widget con 
	// memorizzazione dei valori direttamente nel database wordpress

	function update($new_instance,$old_instance) 
	{
		$instance = $old_instance;

		if (!isset($new_instance['title']))      $new_instance['title']      = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['badge']))      $new_instance['badge']      = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['url']))        $new_instance['url']        = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['urltype']))    $new_instance['urltype']    = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['text']))       $new_instance['text']       = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['img']))        $new_instance['img']        = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['align']))      $new_instance['align']      = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['position']))   $new_instance['position']   = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['size']))       $new_instance['size']       = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['annotation'])) $new_instance['annotation'] = SZ_PLUGIN_GOOGLE_VALUE_NULL; 

		$instance['url']        = trim($new_instance['url']);
		$instance['text']       = trim($new_instance['text']);
		$instance['img']        = trim($new_instance['img']);

		$instance['urltype']    = trim(strip_tags($new_instance['urltype']));
		$instance['title']      = trim(strip_tags($new_instance['title']));
		$instance['badge']      = trim(strip_tags($new_instance['badge']));
		$instance['align']      = trim(strip_tags($new_instance['align']));
		$instance['position']   = trim(strip_tags($new_instance['position']));
		$instance['size']       = trim(strip_tags($new_instance['size']));
		$instance['annotation'] = trim(strip_tags($new_instance['annotation']));

		return $instance;
	}

	// Funzione per la visualizzazione del form presente sulle 
	// sidebar nel pannello di amministrazione di wordpress
	
	function form($instance) 
	{
		$array = array(
			'title'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'badge'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'url'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'urltype'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'text'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'img'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'align'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'position'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'size'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'annotation' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		);

		// Creazione array per elenco campi da recuperare su FORM

		$instance = wp_parse_args((array) $instance,$array);

		$url        = trim($instance['url']);
		$text       = trim($instance['text']);
		$img        = trim($instance['img']);

		$urltype    = trim(strip_tags($instance['urltype']));
		$badge      = trim(strip_tags($instance['badge']));
		$title      = trim(strip_tags($instance['title']));
		$align      = trim(strip_tags($instance['align']));
		$position   = trim(strip_tags($instance['position']));
		$size       = trim(strip_tags($instance['size']));
		$annotation = trim(strip_tags($instance['annotation']));

		// Campo di selezione parametro badge per TITOLO

		echo '<table style="width:100%">';

		echo '<tr>';
		echo '<td colspan="2">';
		echo '<label for="'.$this->get_field_id('title').'">'.ucfirst(__('title','szgoogleadmin')).':</label>';
		echo '<input class="widefat" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.esc_attr($title).'"/>';
		echo '</td>';
		echo '</tr>';

		echo '<tr>';
		echo '<td colspan="2"><select class="sz-google-switch-hidden widefat" id="'.$this->get_field_id('urltype').'" name="'.$this->get_field_name('urltype').'" onchange="szgoogle_switch_hidden(this);" data-switch="sz-google-switch-url">';
		echo '<option value="0" '; selected("0",$urltype); echo '>'.__('current post address','szgoogleadmin').'</option>';
		echo '<option value="1" '; selected("1",$urltype); echo '>'.__('specific url address','szgoogleadmin').'</option>';
		echo '</select></td>';
		echo '</tr>';

		// Campo di selezione parametro URL del file che deve essere memorizzato su drive

		echo '<tr class="sz-google-switch-url">';
		echo '<td colspan="2"><input class="sz-upload-image-url widefat" id="'.$this->get_field_id('url').'" name="'.$this->get_field_name('url').'" type="text" value="'.$url.'" placeholder="'.__('insert source URL','szgoogleadmin').'"/></td>';
		echo '</tr>';

		// Campo di selezione parametro per scegliere se visualizzare il badge insieme al bottone

		echo '<tr>';
		echo '<td colspan="2"><select class="sz-google-switch-hidden widefat" id="'.$this->get_field_id('badge').'" name="'.$this->get_field_name('badge').'" onchange="szgoogle_switch_hidden(this);" data-switch="sz-google-switch-display">';
		echo '<option value="0" '; selected("0",$badge); echo '>'.__('button without badge','szgoogleadmin').'</option>';
		echo '<option value="1" '; selected("1",$badge); echo '>'.__('button with badge','szgoogleadmin').'</option>';
		echo '</select></td>';
		echo '</tr>';

		// Campo di selezione parametro testo da utilizzare come badge del pulsante

		echo '<tr class="sz-google-switch-display">';
		echo '<td colspan="2"><textarea class="widefat" rows="3" cols="20" id="'.$this->get_field_id('text').'" name="'.$this->get_field_name('text').'" placeholder="'.__('insert text for badge','szgoogleadmin').'">'.esc_attr($text).'</textarea></td>';
		echo '</tr>';

		// Campo di selezione parametro IMG del file che deve essere memorizzato su drive

		echo '<tr class="sz-google-switch-display">';
		echo '<td><input class="sz-upload-image-url-2 widefat" id="'.$this->get_field_id('img').'" name="'.$this->get_field_name('img').'" type="text" value="'.$img.'" placeholder="'.__('choose image for badge','szgoogleadmin').'"/></td>';
		echo '<td><input class="sz-upload-image-button button" type="button" value="'.ucfirst(__('select file','szgoogleadmin')).'" data-field-url="sz-upload-image-url-2" data-title="'.ucfirst(__('select or upload a file','szgoogleadmin')).'" data-button-text="'.ucfirst(__('confirm selection','szgoogleadmin')).'"/></td>';
		echo '</tr>';

		// Campo di selezione parametro badge per POSITION

		echo '<tr class="sz-google-switch-display">';
		echo '<td colspan="2"><select class="widefat" id="'.$this->get_field_id('position').'" name="'.$this->get_field_name('position').'">';
		echo '<option value="outside" '; selected("outside",$position); echo '>'.__('button position outside','szgoogleadmin').'</option>';
		echo '<option value="top" ';     selected("top"    ,$position); echo '>'.__('button position top','szgoogleadmin').'</option>';
		echo '<option value="center" ';  selected("center" ,$position); echo '>'.__('button position center','szgoogleadmin').'</option>';
		echo '<option value="bottom" ';  selected("bottom" ,$position); echo '>'.__('button position bottom','szgoogleadmin').'</option>';
		echo '</select></td>';
		echo '</tr>';

		// Campo di selezione parametro badge per ALIGN

		echo '<tr>';
		echo '<td colspan="2"><select class="widefat" id="'.$this->get_field_id('align').'" name="'.$this->get_field_name('align').'">';
		echo '<option value="none" '  ; selected("none"  ,$align); echo '>'.__('button alignment none','szgoogleadmin').'</option>';
		echo '<option value="left" '  ; selected("left"  ,$align); echo '>'.__('button alignment left','szgoogleadmin').'</option>';
		echo '<option value="center" '; selected("center",$align); echo '>'.__('button alignment center','szgoogleadmin').'</option>';
		echo '<option value="right" ' ; selected("right" ,$align); echo '>'.__('button alignment right','szgoogleadmin').'</option>';
		echo '</select></td>';
		echo '</tr>';

		// Campo di selezione parametro per button size

		echo '<tr>';
		echo '<td colspan="2"><select class="widefat" id="'.$this->get_field_id('size').'" name="'.$this->get_field_name('size').'">';
		echo '<option value="medium" '   ; selected("medium"  ,$size); echo '>'.__('size medium','szgoogleadmin').'</option>';
		echo '<option value="small" '    ; selected("small"   ,$size); echo '>'.__('size small','szgoogleadmin').'</option>';
		echo '<option value="large" '    ; selected("large"   ,$size); echo '>'.__('size large','szgoogleadmin').'</option>';
		echo '</select></td>';
		echo '</tr>';

		// Campo di selezione parametro per button annotation

		echo '<tr>';
		echo '<td colspan="2"><select class="widefat" id="'.$this->get_field_id('annotation').'" name="'.$this->get_field_name('annotation').'">';
		echo '<option value="none" '  ; selected("none"  ,$annotation); echo '>'.__('annotation none','szgoogleadmin').'</option>';
		echo '<option value="inline" '; selected("inline",$annotation); echo '>'.__('annotation inline','szgoogleadmin').'</option>';
		echo '<option value="bubble" '; selected("bubble",$annotation); echo '>'.__('annotation bubble','szgoogleadmin').'</option>';
		echo '</select></td>';
		echo '</tr>';

		echo '</table>';

		// Codice javascript per abilitare/disabilitare le funzioni dei campi, attenzione che 
		// la definizione document.ready viene specificata qui perchè sul file iniziale non funziona

		echo '<script type="text/javascript">';
			echo 'jQuery(document).ready(function(){';
				echo 'szgoogle_switch_hidden_ready();';
				echo 'szgoogle_media_uploader();';
			echo '});';
		echo '</script>';
	}
}

/* ************************************************************************** */
/* FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLL */
/* FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLL */
/* FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLL */
/* FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLL */
/* FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLL */
/* ************************************************************************** */

function sz_google_modules_plus_get_code_follow($atts=array(),$content=null)
{
	// Estrazione dei valori specificati nello shortcode, i valori ritornati
	// sono contenuti nei nomi di variabili corrispondenti alla chiave

	if (!is_array($atts)) $atts = array();

	$DEFAULT_SIZE       = 'medium';
	$DEFAULT_ANNOTATION = 'bubble';
	$DEFAULT_REL        = 'none';
	$DEFAULT_ALIGN      = 'none';
	$DEFAULT_POSITION   = 'outside';

	extract(shortcode_atts(array(
		'url'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'size'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'width'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'annotation'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'align'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'text'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'img'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'rel'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'position'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'margintop'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginright'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginbottom' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginleft'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginunit'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts));

	// Elimino spazi aggiunti di troppo ed esegui la trasformazione in
	// stringa minuscolo per il controllo di valori speciali come "auto"

	$url          = trim($url);
	$text         = trim($text);
	$img          = trim($img);

	$width        = strtolower(trim($width));
	$size         = strtolower(trim($size));
	$annotation   = strtolower(trim($annotation));
	$align        = strtolower(trim($align));
	$rel          = strtolower(trim($rel));
	$position     = strtolower(trim($position));
	$margintop    = strtolower(trim($margintop));
	$marginright  = strtolower(trim($marginright));
	$marginbottom = strtolower(trim($marginbottom));
	$marginleft   = strtolower(trim($marginleft));
	$marginunit   = strtolower(trim($marginunit));

	// Imposto i valori di default nel caso siano specificati dei valori
	// che non appartengono al range dei valori accettati

	if (!in_array($size,array('small','medium','large'))) $size = $DEFAULT_SIZE;
	if (!in_array($annotation,array('inline','bubble','vertical-bubble','none'))) $annotation = $DEFAULT_ANNOTATION; 
	if (!in_array($align,array('none','left','right','center'))) $align = $DEFAULT_ALIGN; 
	if (!in_array($rel,array('author','publisher'))) $rel = $DEFAULT_REL; 
	if (!in_array($position,array('top','center','bottom','outside'))) $position = $DEFAULT_POSITION; 

	// Lettura opzioni generali per impostazione dei dati di default

	$options = sz_google_modules_plus_options();

	// Imposto i valori di default nel caso siano specificati dei valori
	// che non appartengono al range dei valori accettati

	if ($url == SZ_PLUGIN_GOOGLE_VALUE_NULL) { $url = 'https://plus.google.com/'.$options['plus_page']; }
	if ($url == SZ_PLUGIN_GOOGLE_VALUE_NULL) { $url = 'https://plus.google.com/'.$options['plus_profile']; }

	if ($url == SZ_PLUGIN_GOOGLE_VALUE_NULL) { $url = 'https://plus.google.com/'.SZ_PLUGIN_GOOGLE_PLUS_ID_PAGE;    $rel = SZ_PLUGIN_GOOGLE_VALUE_NULL; }
	if ($url == SZ_PLUGIN_GOOGLE_VALUE_NULL) { $url = 'https://plus.google.com/'.SZ_PLUGIN_GOOGLE_PLUS_ID_PROFILE; $rel = SZ_PLUGIN_GOOGLE_VALUE_NULL; }

	// Elimino dal path i riferimenti aggiunti ai link di navigazione e 
	// riporto il link originale di google plus, senza /u/0/b etc etc

	$url = sz_google_modules_plus_get_canonical_url($url);

	// Preparazione codice HTML per il badge di google plus

	$HTML  = '<div class="g-follow"';
	$HTML .= ' data-href="'      .$url       .'"';
	$HTML .= ' data-annotation="'.$annotation.'"';

	if ($size  == 'small')     $HTML .= ' data-height="15"';
	if ($size  == 'medium')    $HTML .= ' data-height="20"';
	if ($size  == 'large')     $HTML .= ' data-height="24"';
	if ($width != '')          $HTML .= ' data-width="'.$width.'"';
	if ($align == 'right')     $HTML .= ' data-align="right"';
	if ($rel   == 'author')    $HTML .= ' data-rel="author"';
	if ($rel   == 'publisher') $HTML .= ' data-rel="publisher"';

	$HTML .= '></div>';

	$HTML = sz_google_modules_plus_get_code_button_wrap(array(
		'html'         => $HTML,
		'text'         => $text,
		'image'        => $img,
		'content'      => $content,
		'align'        => $align,
		'position'     => $position,
		'margintop'    => $margintop,
		'marginright'  => $marginright,
		'marginbottom' => $marginbottom,
		'marginleft'   => $marginleft,
		'marginunit'   => $marginunit,
		'class'        => 'sz-google-follow',
	));

	// Aggiunta del codice javascript per il rendering dei widget, questo codice		 
	// viene aggiungo anche dalla sidebar però viene inserito una sola volta

	add_action('wp_footer','sz_google_modules_plus_add_script_footer');

	// Ritorno per la funzione con tutta la stringa contenente
	// il codice HTML per l'inserimento del codice nella pagina

	return $HTML;
}

/* ************************************************************************** */
/* GOOGLE+ FOLLOW funzione per elaborazione shortcode (sz-gplus-follow)       */
/* ************************************************************************** */

function sz_google_shortcodes_plus_follow($atts,$content=null) 
{
	extract(shortcode_atts(array(
		'url'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'size'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'width'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'annotation'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'align'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'text'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'img'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'rel'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'position'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'margintop'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginright'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginbottom' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginleft'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginunit'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts));

	// Preparazione codice HTML dello shortcode tramite la funzione
	// standard di preparazione codice sia per shortcode che widgets

	$HTML = sz_google_modules_plus_get_code_follow(array(
		'url'          => trim($url),
		'size'         => trim($size),
		'width'        => trim($width),
		'annotation'   => trim($annotation),
		'align'        => trim($align),
		'text'         => trim($text),
		'img'          => trim($img),
		'rel'          => trim($rel),
		'position'     => trim($position),
		'margintop'    => trim($margintop),
		'marginright'  => trim($marginright),
		'marginbottom' => trim($marginbottom),
		'marginleft'   => trim($marginleft),
		'marginunit'   => trim($marginunit),
	),$content);

	// Ritorno per la funzione con tutta la stringa contenente
	// il codice HTML per l'inserimento del codice nella pagina

	return $HTML;
}

/* ************************************************************************** */ 
/* GOOGLE+ FOLLOW definizione ed elaborazione del widget su sidebar           */ 
/* ************************************************************************** */ 

class sz_widget_google_plus_follow extends WP_Widget
{
	// Costruttore principale della classe widget, definizione 
	// delle opzioni legate al widget e al controllo dello stesso

	function sz_widget_google_plus_follow() 
	{
		$widget_ops  = array(
			'classname'   => 'sz-widget-google sz-widget-google-plus sz-widget-google-plus-follow', 
			'description' => ucfirst(__('widget for google+ follow','szgoogleadmin'))
		);

		$this->WP_Widget('SZ-GOOGLE-PLUS-FOLLOW',
			__('SZ-Google - G+ Follow','szgoogleadmin'),$widget_ops);
	}

	// Funzione per la visualizzazione del widget con lettura parametri
	// di configurazione e preparazione codice HTML da usare nella sidebar

	function widget($args,$instance) 
	{
		extract($args);

		// Costruzione del titolo del widget tramite la funzione
		// di uso comune a tutti i widgets del plugin sz-google

		$title = sz_google_modules_widget_title($args,$instance);

		// Controllo se esistono le variabili che servono durante l'elaborazione
		// dello script e assegno dei valori di default nel caso non fossero specificati

		if (empty($instance['url']))        $instance['url']        = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['urltype']))    $instance['urltype']    = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['badge']))      $instance['badge']      = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['img']))        $instance['img']        = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['text']))       $instance['text']       = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['align']))      $instance['align']      = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['position']))   $instance['position']   = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['size']))       $instance['size']       = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['annotation'])) $instance['annotation'] = SZ_PLUGIN_GOOGLE_VALUE_NULL;

		// Se sul widget ho escluso il badge dal pulsante azzero anche
		// le variabili del badge eventualmente impostate e memorizzate 

		if ($instance['badge'] != SZ_PLUGIN_GOOGLE_VALUE_YES) 
		{
			$instance['img']      = SZ_PLUGIN_GOOGLE_VALUE_NULL;
			$instance['text']     = SZ_PLUGIN_GOOGLE_VALUE_NULL;
			$instance['position'] = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		}

		// Se sul widget ho selezionato di calcolare l'indirizzo dal 
		// post corrente annullo la variabile con eventuale indirizzo 

		if ($instance['urltype'] != SZ_PLUGIN_GOOGLE_VALUE_YES) {
			$instance['url'] = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		}

		// Lettura opzioni generali per impostazione dei dati di default

		$options = sz_google_modules_plus_options();

		// Imposto i valori di default nel caso siano specificati dei valori
		// che non appartengono al range dei valori accettati

		if ($instance['urltype'] == '0') {
			if ($url == SZ_PLUGIN_GOOGLE_VALUE_NULL) $url = 'https://plus.google.com/'.$options['plus_page'];
			if ($url == SZ_PLUGIN_GOOGLE_VALUE_NULL) $url = 'https://plus.google.com/'.SZ_PLUGIN_GOOGLE_PLUS_ID_PAGE;
		}

		if ($instance['urltype'] == '2') {
			if ($url == SZ_PLUGIN_GOOGLE_VALUE_NULL) $url = 'https://plus.google.com/'.$options['plus_profile'];
			if ($url == SZ_PLUGIN_GOOGLE_VALUE_NULL) $url = 'https://plus.google.com/'.SZ_PLUGIN_GOOGLE_PLUS_ID_PROFILE;
		}

		// Dopo il controllo di esistenza per tutte le opzioni necessarie
		// eseguo il trim e la conversione in minuscolo per le opzioni 

		$url        = trim($instance['url']);
		$text       = trim($instance['text']);
		$img        = trim($instance['img']);

		$align      = strtolower(trim($instance['align']));
		$position   = strtolower(trim($instance['position']));
		$size       = strtolower(trim($instance['size']));
		$annotation = strtolower(trim($instance['annotation']));

		// Creazione codice HTML per inserimento widget post		 

		$HTML = sz_google_modules_plus_get_code_follow(array(
			'url'          => trim($url),
			'filename'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'sitename'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'text'         => trim($text),
			'img'          => trim($img),
			'position'     => trim($position),
			'align'        => trim($align),
			'size'         => trim($size),
			'annotation'   => trim($annotation),
			'rel'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'margintop'    => SZ_PLUGIN_GOOGLE_VALUE_NONE,
			'marginright'  => SZ_PLUGIN_GOOGLE_VALUE_NONE,
			'marginbottom' => SZ_PLUGIN_GOOGLE_VALUE_NONE,
			'marginleft'   => SZ_PLUGIN_GOOGLE_VALUE_NONE,
			'marginunit'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		));

		// Output del codice HTML legato al widget da visualizzare		 

		$output  = $before_widget;
		$output .= $title;
		$output .= $HTML;
		$output .= $after_widget;

		echo $output;
	}

	// Funzione per modifica parametri collegati al widget con 
	// memorizzazione dei valori direttamente nel database wordpress

	function update($new_instance,$old_instance) 
	{
		$instance = $old_instance;

		if (!isset($new_instance['title']))      $new_instance['title']      = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['badge']))      $new_instance['badge']      = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['url']))        $new_instance['url']        = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['urltype']))    $new_instance['urltype']    = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['text']))       $new_instance['text']       = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['img']))        $new_instance['img']        = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['align']))      $new_instance['align']      = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['position']))   $new_instance['position']   = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['size']))       $new_instance['size']       = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['annotation'])) $new_instance['annotation'] = SZ_PLUGIN_GOOGLE_VALUE_NULL; 

		$instance['url']        = trim($new_instance['url']);
		$instance['text']       = trim($new_instance['text']);
		$instance['img']        = trim($new_instance['img']);

		$instance['urltype']    = trim(strip_tags($new_instance['urltype']));
		$instance['title']      = trim(strip_tags($new_instance['title']));
		$instance['badge']      = trim(strip_tags($new_instance['badge']));
		$instance['align']      = trim(strip_tags($new_instance['align']));
		$instance['position']   = trim(strip_tags($new_instance['position']));
		$instance['size']       = trim(strip_tags($new_instance['size']));
		$instance['annotation'] = trim(strip_tags($new_instance['annotation']));

		return $instance;
	}

	// Funzione per la visualizzazione del form presente sulle 
	// sidebar nel pannello di amministrazione di wordpress
	
	function form($instance) 
	{
		$array = array(
			'title'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'badge'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'url'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'urltype'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'text'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'img'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'align'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'position'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'size'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'annotation' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		);

		// Creazione array per elenco campi da recuperare su FORM

		$instance = wp_parse_args((array) $instance,$array);

		$url        = trim($instance['url']);
		$text       = trim($instance['text']);
		$img        = trim($instance['img']);

		$urltype    = trim(strip_tags($instance['urltype']));
		$badge      = trim(strip_tags($instance['badge']));
		$title      = trim(strip_tags($instance['title']));
		$align      = trim(strip_tags($instance['align']));
		$position   = trim(strip_tags($instance['position']));
		$size       = trim(strip_tags($instance['size']));
		$annotation = trim(strip_tags($instance['annotation']));

		// Campo di selezione parametro badge per TITOLO

		echo '<table style="width:100%">';

		echo '<tr>';
		echo '<td colspan="2">';
		echo '<label for="'.$this->get_field_id('title').'">'.ucfirst(__('title','szgoogleadmin')).':</label>';
		echo '<input class="widefat" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.esc_attr($title).'"/>';
		echo '</td>';
		echo '</tr>';

		echo '<tr>';
		echo '<td colspan="2"><select class="sz-google-switch-hidden widefat" id="'.$this->get_field_id('urltype').'" name="'.$this->get_field_name('urltype').'" onchange="szgoogle_switch_hidden(this);" data-switch="sz-google-switch-url">';
		echo '<option value="0" '; selected("0",$urltype); echo '>'.__('default URL for page','szgoogleadmin').'</option>';
		echo '<option value="2" '; selected("2",$urltype); echo '>'.__('default URL for profile','szgoogleadmin').'</option>';
		echo '<option value="1" '; selected("1",$urltype); echo '>'.__('specific URL page or profile','szgoogleadmin').'</option>';
		echo '</select></td>';
		echo '</tr>';

		// Campo di selezione parametro URL del file che deve essere memorizzato su drive

		echo '<tr class="sz-google-switch-url">';
		echo '<td colspan="2"><input class="sz-upload-image-url widefat" id="'.$this->get_field_id('url').'" name="'.$this->get_field_name('url').'" type="text" value="'.$url.'" placeholder="'.__('insert URL for page or profile','szgoogleadmin').'"/></td>';
		echo '</tr>';

		// Campo di selezione parametro per scegliere se visualizzare il badge insieme al bottone

		echo '<tr>';
		echo '<td colspan="2"><select class="sz-google-switch-hidden widefat" id="'.$this->get_field_id('badge').'" name="'.$this->get_field_name('badge').'" onchange="szgoogle_switch_hidden(this);" data-switch="sz-google-switch-display">';
		echo '<option value="0" '; selected("0",$badge); echo '>'.__('button without badge','szgoogleadmin').'</option>';
		echo '<option value="1" '; selected("1",$badge); echo '>'.__('button with badge','szgoogleadmin').'</option>';
		echo '</select></td>';
		echo '</tr>';

		// Campo di selezione parametro testo da utilizzare come badge del pulsante

		echo '<tr class="sz-google-switch-display">';
		echo '<td colspan="2"><textarea class="widefat" rows="3" cols="20" id="'.$this->get_field_id('text').'" name="'.$this->get_field_name('text').'" placeholder="'.__('insert text for badge','szgoogleadmin').'">'.esc_attr($text).'</textarea></td>';
		echo '</tr>';

		// Campo di selezione parametro IMG del file che deve essere memorizzato su drive

		echo '<tr class="sz-google-switch-display">';
		echo '<td><input class="sz-upload-image-url-2 widefat" id="'.$this->get_field_id('img').'" name="'.$this->get_field_name('img').'" type="text" value="'.$img.'" placeholder="'.__('choose image for badge','szgoogleadmin').'"/></td>';
		echo '<td><input class="sz-upload-image-button button" type="button" value="'.ucfirst(__('select file','szgoogleadmin')).'" data-field-url="sz-upload-image-url-2" data-title="'.ucfirst(__('select or upload a file','szgoogleadmin')).'" data-button-text="'.ucfirst(__('confirm selection','szgoogleadmin')).'"/></td>';
		echo '</tr>';

		// Campo di selezione parametro badge per POSITION

		echo '<tr class="sz-google-switch-display">';
		echo '<td colspan="2"><select class="widefat" id="'.$this->get_field_id('position').'" name="'.$this->get_field_name('position').'">';
		echo '<option value="outside" '; selected("outside",$position); echo '>'.__('button position outside','szgoogleadmin').'</option>';
		echo '<option value="top" ';     selected("top"    ,$position); echo '>'.__('button position top','szgoogleadmin').'</option>';
		echo '<option value="center" ';  selected("center" ,$position); echo '>'.__('button position center','szgoogleadmin').'</option>';
		echo '<option value="bottom" ';  selected("bottom" ,$position); echo '>'.__('button position bottom','szgoogleadmin').'</option>';
		echo '</select></td>';
		echo '</tr>';

		// Campo di selezione parametro badge per ALIGN

		echo '<tr>';
		echo '<td colspan="2"><select class="widefat" id="'.$this->get_field_id('align').'" name="'.$this->get_field_name('align').'">';
		echo '<option value="none" '  ; selected("none"  ,$align); echo '>'.__('button alignment none','szgoogleadmin').'</option>';
		echo '<option value="left" '  ; selected("left"  ,$align); echo '>'.__('button alignment left','szgoogleadmin').'</option>';
		echo '<option value="center" '; selected("center",$align); echo '>'.__('button alignment center','szgoogleadmin').'</option>';
		echo '<option value="right" ' ; selected("right" ,$align); echo '>'.__('button alignment right','szgoogleadmin').'</option>';
		echo '</select></td>';
		echo '</tr>';

		// Campo di selezione parametro per button size

		echo '<tr>';
		echo '<td colspan="2"><select class="widefat" id="'.$this->get_field_id('size').'" name="'.$this->get_field_name('size').'">';
		echo '<option value="medium" '   ; selected("medium"  ,$size); echo '>'.__('size medium','szgoogleadmin').'</option>';
		echo '<option value="small" '    ; selected("small"   ,$size); echo '>'.__('size small','szgoogleadmin').'</option>';
		echo '<option value="large" '    ; selected("large"   ,$size); echo '>'.__('size large','szgoogleadmin').'</option>';
		echo '</select></td>';
		echo '</tr>';

		// Campo di selezione parametro per button annotation

		echo '<tr>';
		echo '<td colspan="2"><select class="widefat" id="'.$this->get_field_id('annotation').'" name="'.$this->get_field_name('annotation').'">';
		echo '<option value="none" '  ; selected("none"  ,$annotation); echo '>'.__('annotation none','szgoogleadmin').'</option>';
		echo '<option value="inline" '; selected("inline",$annotation); echo '>'.__('annotation inline','szgoogleadmin').'</option>';
		echo '<option value="bubble" '; selected("bubble",$annotation); echo '>'.__('annotation bubble','szgoogleadmin').'</option>';
		echo '</select></td>';
		echo '</tr>';

		echo '</table>';

		// Codice javascript per abilitare/disabilitare le funzioni dei campi, attenzione che 
		// la definizione document.ready viene specificata qui perchè sul file iniziale non funziona

		echo '<script type="text/javascript">';
			echo 'jQuery(document).ready(function(){';
				echo 'szgoogle_switch_hidden_ready();';
				echo 'szgoogle_media_uploader();';
			echo '});';
		echo '</script>';
	}
}

/* ************************************************************************** */
/* POST POST POST POST POST POST POST POST POST POST POST POST POST POST POST */
/* POST POST POST POST POST POST POST POST POST POST POST POST POST POST POST */
/* POST POST POST POST POST POST POST POST POST POST POST POST POST POST POST */
/* POST POST POST POST POST POST POST POST POST POST POST POST POST POST POST */
/* POST POST POST POST POST POST POST POST POST POST POST POST POST POST POST */
/* ************************************************************************** */

function sz_google_modules_plus_get_code_post($atts=array())
{
	// Estrazione dei valori specificati nello shortcode, i valori ritornati
	// sono contenuti nei nomi di variabili corrispondenti alla chiave

	if (!is_array($atts)) $atts = array();

	extract(shortcode_atts(array(
		'url'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'align' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts));

	// Elimino spazi aggiunti di troppo ed esegui la trasformazione in
	// stringa minuscolo per il controllo di valori speciali come "auto"

	$url   = trim($url);
	$align = strtolower(trim($align));

	// Se non specifico un URL valido per la creazione del bottone
	// esco dalla funzione e ritorno una stringa vuota

	if (empty($url)) { return SZ_PLUGIN_GOOGLE_VALUE_NULL; }

	// Elimino dal path i riferimenti aggiunti ai link di navigazione e 
	// riporto il link originale di google plus, senza /u/0/b etc etc

	$url = sz_google_modules_plus_get_canonical_url($url);

	// Creazione codice HTML per embed code da inserire nella pagina wordpress

	$HTML  = '<div class="sz-google-post">';
	$HTML .= '<div class="sz-google-post-wrap"';
	$HTML .= ' style="display:block;';

	if ($align == 'left')   $HTML .= 'text-align:left;';
	if ($align == 'center') $HTML .= 'text-align:center;';
	if ($align == 'right')  $HTML .= 'text-align:right;';

	$HTML .= '">';

	$HTML .= '<div class="g-post" ';
	$HTML .= 'data-href="'.$url.'"';
	$HTML .= '></div>';

	$HTML .= '</div>';
	$HTML .= '</div>';

	// Aggiunta del codice javascript per il rendering dei widget, questo codice		 
	// viene aggiungo anche dalla sidebar però viene inserito una sola volta

	add_action('wp_footer','sz_google_modules_plus_add_script_footer');

	// Ritorno per la funzione con tutta la stringa contenente
	// il codice HTML per l'inserimento del codice nella pagina

	return $HTML;
}

/* ************************************************************************** */
/* GOOGLE+ POST funzione per elaborazione shortcode (sz-gplus-post)           */
/* ************************************************************************** */

function sz_google_shortcodes_plus_post($atts,$content=null) 
{
	extract(shortcode_atts(array(
		'url'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'align' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts));

	// Preparazione codice HTML dello shortcode tramite la funzione
	// standard di preparazione codice sia per shortcode che widgets

	$HTML = sz_google_modules_plus_get_code_post(array(
		'url'   => trim($url),
		'align' => trim($align),
	));

	// Ritorno per la funzione con tutta la stringa contenente
	// il codice HTML per l'inserimento del codice nella pagina

	return $HTML;
}

/* ************************************************************************** */ 
/* GOOGLE+ POST definizione ed elaborazione del widget su sidebar             */ 
/* ************************************************************************** */ 

class SZ_Widget_Google_Post extends WP_Widget
{
	// Costruttore principale della classe widget, definizione 
	// delle opzioni legate al widget e al controllo dello stesso

	function SZ_Widget_Google_Post() 
	{
		$widget_ops  = array(
			'classname'   => 'sz-widget-google sz-widget-google-plus sz-widget-google-plus-post', 
			'description' => ucfirst(__('widget for google+ post','szgoogleadmin'))
		);

		$this->WP_Widget('SZ-Google-Post',
			__('SZ-Google - G+ Post','szgoogleadmin'),$widget_ops);
	}

	// Funzione per la visualizzazione del widget con lettura parametri
	// di configurazione e preparazione codice HTML da usare nella sidebar

	function widget($args,$instance) 
	{
		extract($args);

		// Costruzione del titolo del widget tramite la funzione
		// di uso comune a tutti i widgets del plugin sz-google

		$title = sz_google_modules_widget_title($args,$instance);

		// Controllo se esistono le variabili che servono durante l'elaborazione
		// dello script e assegno dei valori di default nel caso non fossero specificati

		if (empty($instance['url']))   $instance['url']   = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['align'])) $instance['align'] = SZ_PLUGIN_GOOGLE_VALUE_NULL;

		$url   = trim($instance['url']);
		$align = strtolower(trim($instance['align']));

		// Creazione codice HTML per inserimento widget post		 

		$HTML = sz_google_modules_plus_get_code_post(array(
			'url'   => trim($url),
			'align' => trim($align),
		));

		// Output del codice HTML legato al widget da visualizzare		 

		$output  = $before_widget;
		$output .= $title;
		$output .= $HTML;
		$output .= $after_widget;

		echo $output;
	}

	// Funzione per modifica parametri collegati al widget con 
	// memorizzazione dei valori direttamente nel database wordpress

	function update($new_instance,$old_instance) 
	{
		$instance = $old_instance;

		if (!isset($new_instance['title'])) $new_instance['title'] = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['url']))   $new_instance['url']   = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['align'])) $new_instance['align'] = SZ_PLUGIN_GOOGLE_VALUE_NULL; 

		$instance['url']   = trim($new_instance['url']);
		$instance['title'] = trim(strip_tags($new_instance['title']));
		$instance['align'] = trim(strip_tags($new_instance['align']));

		return $instance;
	}

	// Funzione per la visualizzazione del form presente sulle 
	// sidebar nel pannello di amministrazione di wordpress
	
	function form($instance) 
	{
		$array = array(
			'title' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'url'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'align' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		);

		// Creazione array per elenco campi da recuperare su FORM

		$instance = wp_parse_args((array) $instance,$array);

		$url   = trim($instance['url']);
		$title = trim(strip_tags($instance['title']));
		$align = trim(strip_tags($instance['align']));

		// Campo di selezione parametro badge per TITOLO

		echo '<p><label for="'.$this->get_field_id('title').'">'.ucfirst(__('title','szgoogleadmin')).':</label>';
		echo '<input class="widefat" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.esc_attr($title).'"/></p>';

		// Campo di selezione parametro badge per URL specifico

		echo '<p id="'.$this->get_field_id('fieldj').'">';
		echo '<input class="widefat" id="'.$this->get_field_id('url').'" name="'.$this->get_field_name('url').'" type="text" value="'.$url.'" placeholder="'.__('insert google+ post URL','szgoogleadmin').'"/></p>';

		echo '<table style="width:100%">';

		echo '<tr><td colspan="3"><hr></td></tr>';

		// Campo di selezione parametro badge per ALIGN

		echo '<tr>';
		echo '<td><label for="'.$this->get_field_id('align').'">'.ucfirst(__('align','szgoogleadmin')).':</label></td>';
		echo '<td colspan="2"><select class="widefat" id="'.$this->get_field_id('align').'" name="'.$this->get_field_name('align').'">';
		echo '<option value="none" '  ; selected("none"  ,$align); echo '>'.__('none','szgoogleadmin').'</option>';
		echo '<option value="left" '  ; selected("left"  ,$align); echo '>'.__('left','szgoogleadmin').'</option>';
		echo '<option value="center" '; selected("center",$align); echo '>'.__('center','szgoogleadmin').'</option>';
		echo '<option value="right" ' ; selected("right" ,$align); echo '>'.__('right','szgoogleadmin').'</option>';
		echo '</select></td>';
		echo '</tr>';

		echo '</table>';
	}
}

/* ************************************************************************** */
/* PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PR  */
/* PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PR  */
/* PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PR  */
/* PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PR  */
/* PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PR  */
/* ************************************************************************** */

function sz_google_modules_plus_get_code_profile($atts,$content=null) 
{
	// Estrazione dei valori specificati nello shortcode, i valori ritornati
	// sono contenuti nei nomi di variabili corrispondenti alla chiave

	if (!is_array($atts)) $atts = array();

	extract(shortcode_atts(array(
		'id'      => SZ_PLUGIN_GOOGLE_PLUS_ID_PROFILE,
		'type'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'width'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'align'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'layout'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'theme'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'cover'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'tagline' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'author'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'action'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'text'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'image'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts));

	// Esecuzione del trim sui valori specificati nello shortcode

	$id      = trim($id);
	$text    = trim($text);
	$image   = trim($image);

	$type    = strtolower(trim($type));
	$width   = strtolower(trim($width));
	$align   = strtolower(trim($align));
	$layout  = strtolower(trim($layout));
	$theme   = strtolower(trim($theme));
	$cover   = strtolower(trim($cover));
	$tagline = strtolower(trim($tagline));
	$author  = strtolower(trim($author));
	$action  = strtolower(trim($action));

	// Lettura opzioni generali per impostazione dei dati di default

	$options = sz_google_modules_plus_options();

	// Imposto i valori di default nel caso siano specificati dei valori
	// che non appartengono al range dei valori accettati

	if ($id == SZ_PLUGIN_GOOGLE_VALUE_NULL) { $id = $options['plus_profile']; }
	if ($id == SZ_PLUGIN_GOOGLE_VALUE_NULL) { $id = SZ_PLUGIN_GOOGLE_PLUS_ID_PROFILE; $author = 'false'; }

	// Controllo se azione di richiesta non è un widget posso conrollare i valori
	// di default legati allo shortcode che sono gli stessi per la funzione PHP diretta

	if ($action != SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET) 
	{
		if ($layout  != 'portrait' and $layout  != 'landscape') $layout  = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_LAYOUT; 
		if ($theme   != 'light'    and $theme   != 'dark')      $theme   = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_THEME; 
		if ($cover   != 'true'     and $cover   != 'false')     $cover   = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_COVER; 
		if ($tagline != 'true'     and $tagline != 'false')     $tagline = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_TAGLINE; 
		if ($author  != 'true'     and $author  != 'false')     $author  = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_AUTHOR; 

	} else {

		if ($layout  != 'portrait' and $layout  != 'landscape') $layout  = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_LAYOUT; 
		if ($theme   != 'light'    and $theme   != 'dark')      $theme   = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_THEME; 
		if ($cover   != 'true'     and $cover   != 'false')     $cover   = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_COVER; 
		if ($tagline != 'true'     and $tagline != 'false')     $tagline = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_TAGLINE; 
		if ($author  != 'true'     and $author  != 'false')     $author  = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_AUTHOR; 
	}

	// Controllo la dimensione del widget se non specificata applico i valori
	// di default specificati nel pannello di amministrazione o nelle costanti

	if (!is_numeric($width) and $width != SZ_PLUGIN_GOOGLE_VALUE_AUTO) $width = SZ_PLUGIN_GOOGLE_VALUE_NULL;

	if ($action != SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET) 
	{
		if ($layout == 'portrait') {
			if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = $options['plus_shortcode_size_portrait'];
			if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_SIZE_PORTRAIT;
		} else {
			if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = $options['plus_shortcode_size_landscape'];
			if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_SIZE_LANDSCAPE;
		}

	} else {

		if ($layout == 'portrait') {
			if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = $options['plus_widget_size_portrait'];
			if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_SIZE_PORTRAIT;
		} else {
			if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = $options['plus_widget_size_landscape'];
			if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_SIZE_LANDSCAPE;
		}
	}

	if (!is_numeric($width) and $width != SZ_PLUGIN_GOOGLE_VALUE_AUTO) $width = SZ_PLUGIN_GOOGLE_VALUE_NULL;

	// Controllo la dimensione del widget e controllo formale dei valori numerici
	// se trovo qualche incongruenza applico i valori di default prestabiliti

	if ($width == SZ_PLUGIN_GOOGLE_VALUE_AUTO) $width = "'+w+'";
	if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = "'+w+'";

	$uniqueID = 'sz-google-profile-'.md5(uniqid(),false);

	// Preparazione codice HTML per il badge di google plus
	// con modalità pop-up con la generazione di un link semplice

	if ($type == 'popup') 
	{
		$HTML  = '<span class="sz-google-profile">';
		$HTML .= '<a class="g-profile" href="https://plus.google.com/'.$id.'">';

		if (!empty($text))    $HTML .= $text;
		if (!empty($image))   $HTML .= '<img src="'.$image.'" alt=""/>';

		$HTML .= '</a>';
		$HTML .= '</span>';

	// Preparazione codice HTML per il badge di google plus
	// con modalità standard tramite la creazione di un iframe

	} else {

		// Apertura delle divisioni che rappresentano il wrapper
		// comune per eventuali personalizzazioni di visualizzazione

		$HTML  = '<div class="sz-google-badge">';
		$HTML .= '<div class="sz-google-profile">';
		$HTML .= '<div class="sz-google-profile-wrap">';

		// Blocco principale della divisione con codice javascript
		// per il calcolo della dimensione automatica e contenitore

		$HTML .= '<div id="'.$uniqueID.'" style="display:block;';

		if ($align == 'left')   $HTML .= 'text-align:left;';
		if ($align == 'center') $HTML .= 'text-align:center;';
		if ($align == 'right')  $HTML .= 'text-align:right;';

		$HTML .= '">';

		$HTML .= '<script type="text/javascript">';
		$HTML .= "var w=document.getElementById('".$uniqueID."').offsetWidth;";
		$HTML .= "document.write('";
		$HTML .= '<div class="g-person"';
		$HTML .= ' data-href="https://plus.google.com/'.$id.'"';
		$HTML .= ' data-width="'         .$width  .'"';
		$HTML .= ' data-layout="'        .$layout .'"';
		$HTML .= ' data-theme="'         .$theme  .'"';
		$HTML .= ' data-showcoverphoto="'.$cover  .'"';
		$HTML .= ' data-showtagline="'   .$tagline.'"';

		if ($author == 'true') $HTML .= ' data-rel="author"';

		$HTML .= '></div>'."');";
		$HTML .= '</script>';

		$HTML .= '</div>';

		// Chiusura delle divisioni che rappresentano il wrapper

		$HTML .= '</div>';
		$HTML .= '</div>';
		$HTML .= '</div>';
	}

	// Aggiunta del codice javascript per il rendering dei widget, questo codice		 
	// viene aggiungo anche dalla sidebar però viene inserito una sola volta

	add_action('wp_footer','sz_google_modules_plus_add_script_footer');

	// Ritorno per la funzione con tutta la stringa contenente
	// il codice HTML per l'inserimento del codice nella pagina

	return $HTML;
}

/* ************************************************************************** */
/* GOOGLE+ PROFILE funzione per elaborazione shortcode (sz-gplus-profile)     */
/* ************************************************************************** */

function sz_google_shortcodes_plus_profile($atts,$content=null) 
{
	extract(shortcode_atts(array(
		'id'      => SZ_PLUGIN_GOOGLE_PLUS_ID_PROFILE,
		'type'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'width'   => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_WIDTH,
		'align'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'layout'  => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_LAYOUT,
		'theme'   => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_THEME,
		'cover'   => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_COVER,
		'tagline' => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_TAGLINE,
		'author'  => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_AUTHOR,
		'text'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'image'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts));

	// Preparazione codice HTML dello shortcode tramite la funzione
	// standard di preparazione codice sia per shortcode che widgets

	$HTML = sz_google_modules_plus_get_code_profile(array(
		'id'      => trim($id),
		'type'    => trim($type),
		'width'   => trim($width),
		'align'   => trim($align),
		'layout'  => trim($layout),
		'theme'   => trim($theme),
		'cover'   => trim($cover),
		'tagline' => trim($tagline),
		'author'  => trim($author),
		'text'    => trim($text),
		'image'   => trim($image),
		'action'  => SZ_PLUGIN_GOOGLE_VALUE_TEXT_SHORTCODE,
	),$content);

	// Ritorno per la funzione con tutta la stringa contenente
	// il codice HTML per l'inserimento del codice nella pagina

	return $HTML;
}

/* ************************************************************************** */ 
/* GOOGLE+ PROFILE definizione ed elaborazione del widget su sidebar          */ 
/* ************************************************************************** */ 

class SZ_Widget_Google_Profile extends WP_Widget
{
	// Costruttore principale della classe widget, definizione 
	// delle opzioni legate al widget e al controllo dello stesso

	function SZ_Widget_Google_Profile() 
	{
		$widget_ops  = array(
			'classname'   => 'sz-widget-google sz-widget-google-plus sz-widget-google-plus-profile', 
			'description' => ucfirst(__('widget for google+ profile','szgoogleadmin'))
		);

		$this->WP_Widget('SZ-Google-Profile',
			__('SZ-Google - G+ Profile','szgoogleadmin'),$widget_ops);
	}

	// Funzione per la visualizzazione del widget con lettura parametri
	// di configurazione e preparazione codice HTML da usare nella sidebar

	function widget($args,$instance) 
	{
		extract($args);

		// Costruzione del titolo del widget tramite la funzione
		// di uso comune a tutti i widgets del plugin sz-google

		$title = sz_google_modules_widget_title($args,$instance);

		// Controllo se esistono le variabili che servono durante l'elaborazione
		// dello script e assegno dei valori di default nel caso non fossero specificati

		if (empty($instance['method']))     $instance['method']     = SZ_PLUGIN_GOOGLE_VALUE_YES;
		if (empty($instance['specific']))   $instance['specific']   = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['width']))      $instance['width']      = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['width_auto'])) $instance['width_auto'] = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['align']))      $instance['align']      = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['layout']))     $instance['layout']     = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_LAYOUT;
		if (empty($instance['theme']))      $instance['theme']      = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_THEME;
		if (empty($instance['photo']))      $instance['photo']      = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_PHOTO;
		if (empty($instance['tagline']))    $instance['tagline']    = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_TAGLINE;
		if (empty($instance['author']))     $instance['author']     = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_AUTHOR;

		$method     = trim($instance['method']);
		$specific   = trim($instance['specific']);
		$width      = trim($instance['width']);
		$width_auto = trim($instance['width_auto']);
		$align      = trim($instance['align']);
		$layout     = trim($instance['layout']);
		$theme      = trim($instance['theme']);
		$photo      = trim($instance['photo']);
		$tagline    = trim($instance['tagline']);
		$author     = trim($instance['author']);

		// Correzione del valore di dimensione nel caso venga
		// specificata la maniera automatica e quindi usare javascript

		if ($width_auto == SZ_PLUGIN_GOOGLE_VALUE_YES) $width = SZ_PLUGIN_GOOGLE_VALUE_AUTO;

		// Calcolo del valore ID per la composizione del badge

		if ($method == SZ_PLUGIN_GOOGLE_VALUE_YES) $profile = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
			else $profile = $specific;

		// Creazione del codice per il badge di google+

		$HTML = sz_google_modules_plus_get_code_profile(array(
			'id'      => trim($profile),
			'width'   => trim($width),
			'align'   => trim($align),
			'layout'  => trim($layout),
			'theme'   => trim($theme),
			'cover'   => trim($photo),
			'tagline' => trim($tagline),
			'author'  => trim($author),
			'action'  => SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET,
		));
		 
		// Output del codice HTML legato al widget da visualizzare		 

		$output  = $before_widget;
		$output .= $title;
		$output .= $HTML;
		$output .= $after_widget;

		echo $output;
	}

	// Funzione per modifica parametri collegati al widget con 
	// memorizzazione dei valori direttamente nel database wordpress

	function update($new_instance,$old_instance) 
	{
		$instance = $old_instance;

		if (!isset($new_instance['title']))      $new_instance['title']      = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['method']))     $new_instance['method']     = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['specific']))   $new_instance['specific']   = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['width']))      $new_instance['width']      = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['width_auto'])) $new_instance['width_auto'] = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['align']))      $new_instance['align']      = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['layout']))     $new_instance['layout']     = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['theme']))      $new_instance['theme']      = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['photo']))      $new_instance['photo']      = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['tagline']))    $new_instance['tagline']    = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['author']))     $new_instance['author']     = SZ_PLUGIN_GOOGLE_VALUE_NULL; 

		$instance['title']      = trim(strip_tags($new_instance['title']));
		$instance['method']     = trim(strip_tags($new_instance['method']));
		$instance['specific']   = trim(strip_tags($new_instance['specific']));
		$instance['width']      = trim(strip_tags($new_instance['width']));
		$instance['width_auto'] = trim(strip_tags($new_instance['width_auto']));
		$instance['align']      = trim(strip_tags($new_instance['align']));
		$instance['layout']     = trim(strip_tags($new_instance['layout']));
		$instance['theme']      = trim(strip_tags($new_instance['theme']));
		$instance['photo']      = trim(strip_tags($new_instance['photo']));
		$instance['tagline']    = trim(strip_tags($new_instance['tagline']));
		$instance['author']     = trim(strip_tags($new_instance['author']));

		return $instance;
	}

	// Funzione per la visualizzazione del form presente sulle 
	// sidebar nel pannello di amministrazione di wordpress
	
	function form($instance) 
	{
		$array = array(
			'title'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'method'     => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'specific'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'width'      => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_SIZE_PORTRAIT,
			'width_auto' => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'align'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'layout'     => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_LAYOUT,
			'theme'      => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_THEME,
			'photo'      => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_PHOTO,
			'tagline'    => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_TAGLINE,
			'author'     => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_AUTHOR,
		);

		// Creazione array per elenco campi da recuperare su FORM

		$instance = wp_parse_args((array) $instance,$array);

		$title      = trim(strip_tags($instance['title']));
		$method     = trim(strip_tags($instance['method']));
		$specific   = trim(strip_tags($instance['specific']));
		$width      = trim(strip_tags($instance['width']));
		$width_auto = trim(strip_tags($instance['width_auto']));
		$align      = trim(strip_tags($instance['align']));
		$layout     = trim(strip_tags($instance['layout']));
		$theme      = trim(strip_tags($instance['theme']));
		$photo      = trim(strip_tags($instance['photo']));
		$tagline    = trim(strip_tags($instance['tagline']));
		$author     = trim(strip_tags($instance['author']));

		$KEY_method = 'sz-key-1-'.md5(uniqid(),false);
		$KEY_fieldj = 'sz-key-2-'.md5(uniqid(),false);
		$KEY_widths = 'sz-key-3-'.md5(uniqid(),false);
		$KEY_widtha = 'sz-key-4-'.md5(uniqid(),false);

		// Campo di selezione parametro badge per TITOLO

		echo '<p><label for="'.$this->get_field_id('title').'">'.ucfirst(__('title','szgoogleadmin')).':</label>';
		echo '<input class="widefat" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.esc_attr($title).'"/></p>';

		// Campo di selezione parametro badge per ID con metodo

		echo '<p><select class="widefat" id="'.$this->get_field_id('method').'" name="'.$this->get_field_name('method').'" data-sz-key="'.$KEY_method.'">';
		echo '<option value="1" '; selected("1",$method); echo '>'.ucfirst(__('configuration ID','szgoogleadmin')).'</option>';
		echo '<option value="2" '; selected("2",$method); echo '>'.ucfirst(__('specific ID','szgoogleadmin')).'</option>';
		echo '</select></p>';

		// Campo di selezione parametro badge per ID specifico

		echo '<p id="'.$this->get_field_id('fieldj').'" data-sz-key="'.$KEY_fieldj.'">';
		echo '<input class="widefat" id="'.$this->get_field_id('specific').'" name="'.$this->get_field_name('specific').'" type="text" value="'.$specific.'" placeholder="'.__('insert specific ID','szgoogleadmin').'"/></p>';

		echo '<table style="width:100%">';

		// Campo di selezione parametro badge per WIDTH

		echo '<tr>';
		echo '<td><label for="'.$this->get_field_id('width').'">'.ucfirst(__('width','szgoogleadmin')).':</label></td>';
		echo '<td><input data-sz-key="'.$KEY_widths.'" id="'.$this->get_field_id('width').'" name="'.$this->get_field_name('width').'" type="number" size="5" step="1" min="180" max="450" value="'.$width.'"/></td>';
		echo '<td><input data-sz-key="'.$KEY_widtha.'" id="'.$this->get_field_id('width_auto').'" name="'.$this->get_field_name('width_auto').'" class="checkbox" type="checkbox" value="1" '; checked($width_auto); echo '>&nbsp;'.ucfirst(__('auto','szgoogleadmin')).'</td>';
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

		echo '<tr><td colspan="3"><hr></td></tr>';

		// Campo di selezione parametro badge per ALIGN

		echo '<tr>';
		echo '<td><label for="'.$this->get_field_id('align').'">'.ucfirst(__('align','szgoogleadmin')).':</label></td>';
		echo '<td colspan="2"><select class="widefat" id="'.$this->get_field_id('align').'" name="'.$this->get_field_name('align').'">';
		echo '<option value="none" '  ; selected("none"  ,$align); echo '>'.__('none','szgoogleadmin').'</option>';
		echo '<option value="left" '  ; selected("left"  ,$align); echo '>'.__('left','szgoogleadmin').'</option>';
		echo '<option value="center" '; selected("center",$align); echo '>'.__('center','szgoogleadmin').'</option>';
		echo '<option value="right" ' ; selected("right" ,$align); echo '>'.__('right','szgoogleadmin').'</option>';
		echo '</select></td>';
		echo '</tr>';

		echo '</table>';

		// Codice javascript per abilitare/disabilitare il campo ID specifico

		echo '<script type="text/javascript">';
			echo 'jQuery(document).ready(function(){';

				echo 'if (jQuery("#widgets-right [data-sz-key=\''.$KEY_method.'\']").val() == "1"){';
					echo  'jQuery("#widgets-right [data-sz-key=\''.$KEY_fieldj.'\']").hide();';
				echo '}';

				echo 'jQuery("[data-sz-key=\''.$KEY_method.'\']").change(function(){';          
					echo "if (this.value == '1') {";
						echo 'jQuery(this).parents("form:first").find("[data-sz-key=\''.$KEY_fieldj.'\']").slideUp();';
				   echo "} else {";
						echo 'jQuery(this).parents("form:first").find("[data-sz-key=\''.$KEY_fieldj.'\']").slideDown();';
					echo '}';
				echo '});';

				// Codice javascript per abilitare/disabilitare il campo WIDTH

				echo 'if (jQuery("#widgets-right [data-sz-key=\''.$KEY_widtha.'\']").is(":checked")) {';
					echo  'jQuery("#widgets-right [data-sz-key=\''.$KEY_widths.'\']").prop("readonly",true);';
				echo '}';

				echo 'jQuery("[data-sz-key=\''.$KEY_widtha.'\']").change(function(){';          
					echo 'if (jQuery(this).is(":checked")) {';
						echo ' jQuery(this).parents("form:first").find("[data-sz-key=\''.$KEY_widths.'\']").prop("readonly",true);';
				   echo "} else {";
						echo ' jQuery(this).parents("form:first").find("[data-sz-key=\''.$KEY_widths.'\']").prop("readonly",false);';
					echo '}';
				echo '});';

			echo '});';
		echo '</script>';
	}
}

/* ************************************************************************** */
/* PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE */
/* PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE */
/* PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE */
/* PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE */
/* PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE */
/* ************************************************************************** */

function sz_google_modules_plus_get_code_page($atts,$content=null) 
{
	// Estrazione dei valori specificati nello shortcode, i valori ritornati
	// sono contenuti nei nomi di variabili corrispondenti alla chiave

	if (!is_array($atts)) $atts = array();

	extract(shortcode_atts(array(
		'id'        => SZ_PLUGIN_GOOGLE_PLUS_ID_PAGE,
		'type'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'width'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'align'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'layout'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'theme'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'cover'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'tagline'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'publisher' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'action'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'text'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'image'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts));

	// Esecuzione trim su valori specificati su shortcode

	$id        = trim($id);
	$text      = trim($text);
	$image     = trim($image);

	$type      = strtolower(trim($type));
	$width     = strtolower(trim($width));
	$align     = strtolower(trim($align));
	$layout    = strtolower(trim($layout));
	$theme     = strtolower(trim($theme));
	$cover     = strtolower(trim($cover));
	$tagline   = strtolower(trim($tagline));
	$publisher = strtolower(trim($publisher));
	$action    = strtolower(trim($action));

	// Lettura opzioni generali per impostazione dei dati di default

	$options = sz_google_modules_plus_options();

	// Imposto i valori di default nel caso siano specificati dei valori
	// che non appartengono al range dei valori accettati

	if ($id == SZ_PLUGIN_GOOGLE_VALUE_NULL) { $id = $options['plus_page']; }
	if ($id == SZ_PLUGIN_GOOGLE_VALUE_NULL) { $id = SZ_PLUGIN_GOOGLE_PLUS_ID_PAGE; $publisher = 'false'; }

	// Controllo se azione di richiesta non è un widget posso conrollare i valori
	// di default legati allo shortcode che sono gli stessi per la funzione PHP diretta

	if ($action != SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET) 
	{
		if ($layout    != 'portrait' and $layout    != 'landscape') $layout    = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_LAYOUT; 
		if ($theme     != 'light'    and $theme     != 'dark')      $theme     = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_THEME; 
		if ($cover     != 'true'     and $cover     != 'false')     $cover     = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_COVER; 
		if ($tagline   != 'true'     and $tagline   != 'false')     $tagline   = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_TAGLINE; 
		if ($publisher != 'true'     and $publisher != 'false')     $publisher = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_PUBLISHER; 

	} else {

		if ($layout    != 'portrait' and $layout    != 'landscape') $layout    = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_LAYOUT; 
		if ($theme     != 'light'    and $theme     != 'dark')      $theme     = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_THEME; 
		if ($cover     != 'true'     and $cover     != 'false')     $cover     = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_COVER; 
		if ($tagline   != 'true'     and $tagline   != 'false')     $tagline   = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_TAGLINE; 
		if ($publisher != 'true'     and $publisher != 'false')     $publisher = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_PUBLISHER; 
	}

	// Controllo la dimensione del widget se non specificata applico i valori
	// di default specificati nel pannello di amministrazione o nelle costanti

	if (!is_numeric($width) and $width != SZ_PLUGIN_GOOGLE_VALUE_AUTO) $width = SZ_PLUGIN_GOOGLE_VALUE_NULL;

	if ($action != SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET) 
	{
		if ($layout == 'portrait') {
			if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = $options['plus_shortcode_size_portrait'];
			if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_SIZE_PORTRAIT;
		} else {
			if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = $options['plus_shortcode_size_landscape'];
			if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_SIZE_LANDSCAPE;
		}

	} else {

		if ($layout == 'portrait') {
			if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = $options['plus_widget_size_portrait'];
			if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_SIZE_PORTRAIT;
		} else {
			if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = $options['plus_widget_size_landscape'];
			if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_SIZE_LANDSCAPE;
		}
	}

	if (!is_numeric($width) and $width != SZ_PLUGIN_GOOGLE_VALUE_AUTO) $width = SZ_PLUGIN_GOOGLE_VALUE_NULL;

	// Controllo la dimensione del widget e controllo formale dei valori numerici
	// se trovo qualche incongruenza applico i valori di default prestabiliti

	if ($width == SZ_PLUGIN_GOOGLE_VALUE_AUTO) $width = "'+w+'";
	if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = "'+w+'";

	$uniqueID = 'sz-google-page-'.md5(uniqid(),false);

	// Preparazione codice HTML per il badge di google plus
	// con modalità pop-up con la generazione di un link semplice

	if ($type == 'popup') 
	{
		$HTML  = '<span class="sz-google-profile">';
		$HTML .= '<a class="g-profile" href="https://plus.google.com/'.$id.'">';

		if (!empty($text))    $HTML .= $text;
		if (!empty($image))   $HTML .= '<img src="'.$image.'" alt=""/>';

		$HTML .= '</a>';
		$HTML .= '</span>';

	// Preparazione codice HTML per il badge di google plus
	// con modalità standard tramite la creazione di un iframe

	} else {

		// Apertura delle divisioni che rappresentano il wrapper
		// comune per eventuali personalizzazioni di visualizzazione

		$HTML  = '<div class="sz-google-badge">';
		$HTML .= '<div class="sz-google-page">';
		$HTML .= '<div class="sz-google-page-wrap">';

		$HTML .= '<div id="'.$uniqueID.'" style="display:block;';

		if ($align == 'left')   $HTML .= 'text-align:left;';
		if ($align == 'center') $HTML .= 'text-align:center;';
		if ($align == 'right')  $HTML .= 'text-align:right;';

		$HTML .= '">';
		$HTML .= '<div class="massimo"></div>';

		$HTML .= '<script type="text/javascript">';
		$HTML .= "var w=document.getElementById('".$uniqueID."').offsetWidth;";
		$HTML .= "document.write('";
		$HTML .= '<div class="g-page"';
		$HTML .= ' data-href="https://plus.google.com/'.$id.'"';
		$HTML .= ' data-width="'         .$width  .'"';
		$HTML .= ' data-layout="'        .$layout .'"';
		$HTML .= ' data-theme="'         .$theme  .'"';
		$HTML .= ' data-showcoverphoto="'.$cover  .'"';
		$HTML .= ' data-showtagline="'   .$tagline.'"';

		if ($publisher == 'true') $HTML .= ' data-rel="publisher"';

		$HTML .= '></div>'."');";
		$HTML .= '</script>';

		$HTML .= '</div>';

		// Chiusura delle divisioni che rappresentano il wrapper

		$HTML .= '</div>';
		$HTML .= '</div>';
		$HTML .= '</div>';
	}

	// Aggiunta del codice javascript per il rendering dei widget, questo codice		 
	// viene aggiungo anche dalla sidebar però viene inserito una sola volta

	add_action('wp_footer','sz_google_modules_plus_add_script_footer');

	// Ritorno per la funzione con tutta la stringa contenente
	// il codice HTML per l'inserimento del codice nella pagina

	return $HTML;
}

/* ************************************************************************** */
/* GOOGLE+ PAGE funzione per elaborazione shortcode (sz-gplus-page)           */
/* ************************************************************************** */

function sz_google_shortcodes_plus_page($atts,$content=null) 
{
	extract(shortcode_atts(array(
		'id'        => SZ_PLUGIN_GOOGLE_PLUS_ID_PAGE,
		'type'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'width'     => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_WIDTH,
		'align'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'layout'    => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_LAYOUT,
		'theme'     => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_THEME,
		'cover'     => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_COVER,
		'tagline'   => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_TAGLINE,
		'publisher' => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_PUBLISHER,
		'text'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'image'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts));

	// Preparazione codice HTML dello shortcode tramite la funzione
	// standard di preparazione codice sia per shortcode che widgets

	$HTML = sz_google_modules_plus_get_code_page(array(
		'id'        => trim($id),
		'type'      => trim($type),
		'width'     => trim($width),
		'align'     => trim($align),
		'layout'    => trim($layout),
		'theme'     => trim($theme),
		'cover'     => trim($cover),
		'tagline'   => trim($tagline),
		'publisher' => trim($publisher),
		'text'      => trim($text),
		'image'     => trim($image),
		'action'    => SZ_PLUGIN_GOOGLE_VALUE_TEXT_SHORTCODE,
	),$content);

	// Ritorno per la funzione con tutta la stringa contenente
	// il codice HTML per l'inserimento del codice nella pagina

	return $HTML;
}

/* ************************************************************************** */ 
/* GOOGLE+ PAGE definizione ed elaborazione del widget su sidebar             */ 
/* ************************************************************************** */ 

class SZ_Widget_Google_Page extends WP_Widget 
{
	// Costruttore principale della classe widget, definizione 
	// delle opzioni legate al widget e al controllo dello stesso

	function SZ_Widget_Google_Page() 
	{
		$widget_ops  = array(
			'classname'   => 'sz-widget-google sz-widget-google-plus sz-widget-google-plus-page', 
			'description' => ucfirst(__('widget for google+ page','szgoogleadmin'))
		);
	
		$this->WP_Widget('SZ-Google-Page',
			__('SZ-Google - G+ Page','szgoogleadmin'),$widget_ops);
	}

	// Funzione per la visualizzazione del widget con lettura parametri
	// di configurazione e preparazione codice HTML da usare nella sidebar

	function widget($args,$instance) 
	{
		extract($args);

		// Costruzione del titolo del widget tramite la funzione
		// di uso comune a tutti i widgets del plugin sz-google

		$title = sz_google_modules_widget_title($args,$instance);

		// Controllo se esistono le variabili che servono durante l'elaborazione
		// dello script e assegno dei valori di default nel caso non fossero specificati

		if (empty($instance['method']))     $instance['method']     = SZ_PLUGIN_GOOGLE_VALUE_YES;
		if (empty($instance['specific']))   $instance['specific']   = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['width']))      $instance['width']      = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['width_auto'])) $instance['width_auto'] = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['align']))      $instance['align']      = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['layout']))     $instance['layout']     = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_LAYOUT;
		if (empty($instance['theme']))      $instance['theme']      = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_THEME;
		if (empty($instance['photo']))      $instance['photo']      = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_PHOTO;
		if (empty($instance['tagline']))    $instance['tagline']    = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_TAGLINE;
		if (empty($instance['publisher']))  $instance['publisher']  = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_PUBLISHER;

		$method     = trim($instance['method']);
		$specific   = trim($instance['specific']);
		$width      = trim($instance['width']);
		$width_auto = trim($instance['width_auto']);
		$align      = trim($instance['align']);
		$layout     = trim($instance['layout']);
		$theme      = trim($instance['theme']);
		$photo      = trim($instance['photo']);
		$tagline    = trim($instance['tagline']);
		$publisher  = trim($instance['publisher']);

		// Correzione del valore di dimensione nel caso venga
		// specificata la maniera automatica e quindi usare javascript

		if ($width_auto == SZ_PLUGIN_GOOGLE_VALUE_YES) $width = SZ_PLUGIN_GOOGLE_VALUE_AUTO;

		// Calcolo del valore ID per la composizione del badge

		if ($method == SZ_PLUGIN_GOOGLE_VALUE_YES) $page = SZ_PLUGIN_GOOGLE_VALUE_NULL;
			else $page = $specific;

		// Creazione del codice per il badge di google+
		 
		$HTML = sz_google_modules_plus_get_code_page(array(
			'id'        => trim($page),
			'width'     => trim($width),
			'align'     => trim($align),
			'layout'    => trim($layout),
			'theme'     => trim($theme),
			'cover'     => trim($photo),
			'tagline'   => trim($tagline),
			'publisher' => trim($publisher),
			'action'    => SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET,
		));

		// Output del codice HTML legato al widget da visualizzare		 

		$output  = $before_widget;
		$output .= $title;
		$output .= $HTML;
		$output .= $after_widget;

		echo $output;
	}

	// Funzione per modifica parametri collegati al widget con 
	// memorizzazione dei valori direttamente nel database wordpress

	function update($new_instance,$old_instance) 
	{
		$instance = $old_instance;

		if (!isset($new_instance['title']))      $new_instance['title']      = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['method']))     $new_instance['method']     = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['specific']))   $new_instance['specific']   = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['width']))      $new_instance['width']      = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['width_auto'])) $new_instance['width_auto'] = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['align']))      $new_instance['align']      = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['layout']))     $new_instance['layout']     = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['theme']))      $new_instance['theme']      = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['photo']))      $new_instance['photo']      = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['tagline']))    $new_instance['tagline']    = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['publisher']))  $new_instance['publisher']  = SZ_PLUGIN_GOOGLE_VALUE_NULL; 

		$instance['title']      = trim(strip_tags($new_instance['title']));
		$instance['method']     = trim(strip_tags($new_instance['method']));
		$instance['specific']   = trim(strip_tags($new_instance['specific']));
		$instance['width']      = trim(strip_tags($new_instance['width']));
		$instance['width_auto'] = trim(strip_tags($new_instance['width_auto']));
		$instance['align']      = trim(strip_tags($new_instance['align']));
		$instance['layout']     = trim(strip_tags($new_instance['layout']));
		$instance['theme']      = trim(strip_tags($new_instance['theme']));
		$instance['photo']      = trim(strip_tags($new_instance['photo']));
		$instance['tagline']    = trim(strip_tags($new_instance['tagline']));
		$instance['publisher']  = trim(strip_tags($new_instance['publisher']));

		return $instance;
	}

	// Funzione per la visualizzazione del form presente sulle 
	// sidebar nel pannello di amministrazione di wordpress

	function form($instance) 
	{
		$array = array(
			'title'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'method'     => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'specific'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'width'      => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_SIZE_PORTRAIT,
			'width_auto' => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'align'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'layout'     => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_LAYOUT,
			'theme'      => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_THEME,
			'photo'      => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_PHOTO,
			'tagline'    => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_TAGLINE,
			'publisher'  => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_PUBLISHER,
		);

		// Creazione array per elenco campi da recuperare su FORM

		$instance = wp_parse_args((array) $instance,$array);

		$title      = trim(strip_tags($instance['title']));
		$method     = trim(strip_tags($instance['method']));
		$specific   = trim(strip_tags($instance['specific']));
		$width      = trim(strip_tags($instance['width']));
		$width_auto = trim(strip_tags($instance['width_auto']));
		$align      = trim(strip_tags($instance['align']));
		$layout     = trim(strip_tags($instance['layout']));
		$theme      = trim(strip_tags($instance['theme']));
		$photo      = trim(strip_tags($instance['photo']));
		$tagline    = trim(strip_tags($instance['tagline']));
		$publisher  = trim(strip_tags($instance['publisher']));

		$KEY_method = 'sz-key-1-'.md5(uniqid(),false);
		$KEY_fieldj = 'sz-key-2-'.md5(uniqid(),false);
		$KEY_widths = 'sz-key-3-'.md5(uniqid(),false);
		$KEY_widtha = 'sz-key-4-'.md5(uniqid(),false);

		// Campo di selezione parametro badge per TITOLO

		echo '<p><label for="'.$this->get_field_id('title').'">'.ucfirst(__('title','szgoogleadmin')).':</label>';
		echo '<input class="widefat" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.esc_attr($title).'"/></p>';

		// Campo di selezione parametro badge per ID con metodo

		echo '<p><select class="widefat" id="'.$this->get_field_id('method').'" name="'.$this->get_field_name('method').'" data-sz-key="'.$KEY_method.'">';
		echo '<option value="1" '; selected("1",$method); echo '>'.ucfirst(__('configuration ID','szgoogleadmin')).'</option>';
		echo '<option value="2" '; selected("2",$method); echo '>'.ucfirst(__('specific ID','szgoogleadmin')).'</option>';
		echo '</select></p>';

		// Campo di selezione parametro badge per ID specifico

		echo '<p id="'.$this->get_field_id('fieldj').'" data-sz-key="'.$KEY_fieldj.'">';
		echo '<input class="widefat" id="'.$this->get_field_id('specific').'" name="'.$this->get_field_name('specific').'" type="text" value="'.$specific.'" placeholder="'.__('insert specific ID','szgoogleadmin').'"/></p>';

		echo '<table style="width:100%">';

		// Campo di selezione parametro badge per WIDTH

		echo '<tr>';
		echo '<td><label for="'.$this->get_field_id('width').'">'.ucfirst(__('width','szgoogleadmin')).':</label></td>';
		echo '<td><input data-sz-key="'.$KEY_widths.'" id="'.$this->get_field_id('width').'" name="'.$this->get_field_name('width').'" type="number" size="5" step="1" min="180" max="450" value="'.$width.'"/></td>';
		echo '<td><input data-sz-key="'.$KEY_widtha.'" id="'.$this->get_field_id('width_auto').'" name="'.$this->get_field_name('width_auto').'" class="checkbox" type="checkbox" value="1" '; checked($width_auto); echo '>&nbsp;'.ucfirst(__('auto','szgoogleadmin')).'</td>';
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

		echo '<tr><td colspan="3"><hr></td></tr>';

		// Campo di selezione parametro badge per ALIGN

		echo '<tr>';
		echo '<td><label for="'.$this->get_field_id('align').'">'.ucfirst(__('align','szgoogleadmin')).':</label></td>';
		echo '<td colspan="2"><select class="widefat" id="'.$this->get_field_id('align').'" name="'.$this->get_field_name('align').'">';
		echo '<option value="none" '  ; selected("none"  ,$align); echo '>'.__('none','szgoogleadmin').'</option>';
		echo '<option value="left" '  ; selected("left"  ,$align); echo '>'.__('left','szgoogleadmin').'</option>';
		echo '<option value="center" '; selected("center",$align); echo '>'.__('center','szgoogleadmin').'</option>';
		echo '<option value="right" ' ; selected("right" ,$align); echo '>'.__('right','szgoogleadmin').'</option>';
		echo '</select></td>';
		echo '</tr>';

		echo '</table>';

		// Codice javascript per abilitare/disabilitare il campo ID specifico

		echo '<script type="text/javascript">';
			echo 'jQuery(document).ready(function(){';

				echo 'if (jQuery("#widgets-right [data-sz-key=\''.$KEY_method.'\']").val() == "1"){';
					echo  'jQuery("#widgets-right [data-sz-key=\''.$KEY_fieldj.'\']").hide();';
				echo '}';

				echo 'jQuery("[data-sz-key=\''.$KEY_method.'\']").change(function(){';          
					echo "if (this.value == '1') {";
						echo 'jQuery(this).parents("form:first").find("[data-sz-key=\''.$KEY_fieldj.'\']").slideUp();';
				   echo "} else {";
						echo 'jQuery(this).parents("form:first").find("[data-sz-key=\''.$KEY_fieldj.'\']").slideDown();';
					echo '}';
				echo '});';

				// Codice javascript per abilitare/disabilitare il campo WIDTH

				echo 'if (jQuery("#widgets-right [data-sz-key=\''.$KEY_widtha.'\']").is(":checked")) {';
					echo  'jQuery("#widgets-right [data-sz-key=\''.$KEY_widths.'\']").prop("readonly",true);';
				echo '}';

				echo 'jQuery("[data-sz-key=\''.$KEY_widtha.'\']").change(function(){';          
					echo 'if (jQuery(this).is(":checked")) {';
						echo ' jQuery(this).parents("form:first").find("[data-sz-key=\''.$KEY_widths.'\']").prop("readonly",true);';
				   echo "} else {";
						echo ' jQuery(this).parents("form:first").find("[data-sz-key=\''.$KEY_widths.'\']").prop("readonly",false);';
					echo '}';
				echo '});';

			echo '});';
		echo '</script>';
	}
}

/* ************************************************************************** */
/* COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMM */
/* COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMM */
/* COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMM */
/* COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMM */
/* COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMM */
/* ************************************************************************** */

function sz_google_modules_plus_get_code_community($atts,$content=null) 
{
	// Estrazione dei valori specificati nello shortcode, i valori ritornati
	// sono contenuti nei nomi di variabili corrispondenti alla chiave

	if (!is_array($atts)) $atts = array();

	extract(shortcode_atts(array(
		'id'     => SZ_PLUGIN_GOOGLE_PLUS_ID_COMMUNITY,
		'width'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'align'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'layout' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'theme'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'photo'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'owner'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'action' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts));

	// Esecuzione trim su valori specificati su shortcode

	$id     = trim($id);
	$width  = strtolower(trim($width));
	$align  = strtolower(trim($align));
	$layout = strtolower(trim($layout));
	$theme  = strtolower(trim($theme));
	$photo  = strtolower(trim($photo));
	$owner  = strtolower(trim($owner));
	$action = strtolower(trim($action));

	// Lettura opzioni generali per impostazione dei dati di default

	$options = sz_google_modules_plus_options();

	// Imposto i valori di default nel caso siano specificati dei valori
	// che non appartengono al range dei valori accettati

	if ($id == SZ_PLUGIN_GOOGLE_VALUE_NULL) { $id = $options['plus_community']; }
	if ($id == SZ_PLUGIN_GOOGLE_VALUE_NULL) { $id = SZ_PLUGIN_GOOGLE_PLUS_ID_COMMUNITY; }

	// Controllo se azione di richiesta non è un widget posso conrollare i valori
	// di default legati allo shortcode che sono gli stessi per la funzione PHP diretta

	if ($action != SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET) 
	{
		if ($layout != 'portrait' and $layout != 'landscape') $layout = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_LAYOUT; 
		if ($theme  != 'light'    and $theme  != 'dark')      $theme  = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_THEME; 
		if ($photo  != 'true'     and $photo  != 'false')     $photo  = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_PHOTO; 
		if ($owner  != 'true'     and $owner  != 'false')     $owner  = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_OWNER; 

	} else {

		if ($layout != 'portrait' and $layout != 'landscape') $layout = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_LAYOUT; 
		if ($theme  != 'light'    and $theme  != 'dark')      $theme  = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_THEME; 
		if ($photo  != 'true'     and $photo  != 'false')     $cover  = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_PHOTO; 
		if ($owner  != 'true'     and $owner  != 'false')     $owner  = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_OWNER; 
	}

	// Controllo la dimensione del widget se non specificata applico i valori
	// di default specificati nel pannello di amministrazione o nelle costanti

	if (!is_numeric($width) and $width != SZ_PLUGIN_GOOGLE_VALUE_AUTO) $width = SZ_PLUGIN_GOOGLE_VALUE_NULL;

	if ($action != SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET) 
	{
		if ($layout == 'portrait') {
			if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = $options['plus_shortcode_size_portrait'];
			if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_SIZE_PORTRAIT;
		} else {
			if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = $options['plus_shortcode_size_landscape'];
			if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_SIZE_LANDSCAPE;
		}

	} else {

		if ($layout == 'portrait') {
			if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = $options['plus_widget_size_portrait'];
			if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_SIZE_PORTRAIT;
		} else {
			if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = $options['plus_widget_size_landscape'];
			if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_SIZE_LANDSCAPE;
		}
	}

	if (!is_numeric($width) and $width != SZ_PLUGIN_GOOGLE_VALUE_AUTO) $width = SZ_PLUGIN_GOOGLE_VALUE_NULL;

	// Controllo la dimensione del widget e controllo formale dei valori numerici
	// se trovo qualche incongruenza applico i valori di default prestabiliti

	if ($width == SZ_PLUGIN_GOOGLE_VALUE_AUTO) $width = "'+w+'";
	if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = "'+w+'";

	$uniqueID = 'sz-google-community-'.md5(uniqid(),false);

	// Apertura delle divisioni che rappresentano il wrapper
	// comune per eventuali personalizzazioni di visualizzazione

	$HTML  = '<div class="sz-google-badge">';
	$HTML .= '<div class="sz-google-community">';
	$HTML .= '<div class="sz-google-community-wrap">';

	$HTML .= '<div id="'.$uniqueID.'" style="display:block;';

	if ($align == 'left')   $HTML .= 'text-align:left;';
	if ($align == 'center') $HTML .= 'text-align:center;';
	if ($align == 'right')  $HTML .= 'text-align:right;';

	$HTML .= '">';

	$HTML .= '<script type="text/javascript">';
	$HTML .= "var w=document.getElementById('".$uniqueID."').offsetWidth;";
	$HTML .= "document.write('";
	$HTML .= '<div class="g-community"';
	$HTML .= ' data-href="https://plus.google.com/communities/'.$id.'"';
	$HTML .= ' data-width="'     .$width .'"';
	$HTML .= ' data-layout="'    .$layout.'"';
	$HTML .= ' data-theme="'     .$theme .'"';
	$HTML .= ' data-showphoto="' .$photo .'"';
	$HTML .= ' data-showowners="'.$owner .'"';
	$HTML .= '></div>'."');";
	$HTML .= '</script>';

	$HTML .= '</div>';

	// Chiusura delle divisioni che rappresentano il wrapper

	$HTML .= '</div>';
	$HTML .= '</div>';
	$HTML .= '</div>';

	// Aggiunta del codice javascript per il rendering dei widget, questo codice		 
	// viene aggiungo anche dalla sidebar però viene inserito una sola volta

	add_action('wp_footer','sz_google_modules_plus_add_script_footer');

	// Ritorno per la funzione con tutta la stringa contenente
	// il codice HTML per l'inserimento del codice nella pagina

	return $HTML;
}

/* ************************************************************************** */
/* GOOGLE+ COMMUNITY funzione per elaborazione shortcode (sz-gplus-community) */
/* ************************************************************************** */

function sz_google_shortcodes_plus_community($atts,$content=null) 
{
	extract(shortcode_atts(array(
		'id'     => SZ_PLUGIN_GOOGLE_PLUS_ID_COMMUNITY,
		'width'  => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_WIDTH,
		'align'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'layout' => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_LAYOUT,
		'theme'  => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_THEME,
		'photo'  => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_PHOTO,
		'owner'  => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_OWNER,
	),$atts));

	// Preparazione codice HTML dello shortcode tramite la funzione
	// standard di preparazione codice sia per shortcode che widgets

	$HTML = sz_google_modules_plus_get_code_community(array(
		'id'     => trim($id),
		'width'  => trim($width),
		'align'  => trim($align),
		'layout' => trim($layout),
		'theme'  => trim($theme),
		'photo'  => trim($photo),
		'owner'  => trim($owner),
		'action' => SZ_PLUGIN_GOOGLE_VALUE_TEXT_SHORTCODE,
	),$content);

	// Ritorno per la funzione con tutta la stringa contenente
	// il codice HTML per l'inserimento del codice nella pagina

	return $HTML;
}

/* ************************************************************************** */ 
/* GOOGLE+ COMMUNITY definizione ed elaborazione del widget su sidebar        */ 
/* ************************************************************************** */ 

class SZ_Widget_Google_Community extends WP_Widget 
{
	// Costruttore principale della classe widget, definizione 
	// delle opzioni legate al widget e al controllo dello stesso

	function SZ_Widget_Google_Community() 
	{
		$widget_ops  = array(
			'classname'   => 'sz-widget-google sz-widget-google-plus sz-widget-google-plus-community', 
			'description' => ucfirst(__('widget for google+ community','szgoogleadmin'))
		);

		$this->WP_Widget('SZ-Google-Community',
			__('SZ-Google - G+ Community','szgoogleadmin'),$widget_ops);
	}

	// Funzione per la visualizzazione del widget con lettura parametri
	// di configurazione e preparazione codice HTML da usare nella sidebar

	function widget($args,$instance) 
	{
		extract($args);

		// Costruzione del titolo del widget tramite la funzione
		// di uso comune a tutti i widgets del plugin sz-google

		$title = sz_google_modules_widget_title($args,$instance);

		// Controllo se esistono le variabili che servono durante l'elaborazione
		// dello script e assegno dei valori di default nel caso non fossero specificati

		if (empty($instance['method']))     $instance['method']     = SZ_PLUGIN_GOOGLE_VALUE_YES;
		if (empty($instance['specific']))   $instance['specific']   = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['width']))      $instance['width']      = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['width_auto'])) $instance['width_auto'] = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['align']))      $instance['align']      = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['layout']))     $instance['layout']     = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_LAYOUT;
		if (empty($instance['theme']))      $instance['theme']      = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_THEME;
		if (empty($instance['photo']))      $instance['photo']      = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_PHOTO;
		if (empty($instance['owner']))      $instance['owner']      = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_OWNER;

		$method     = trim($instance['method']);
		$specific   = trim($instance['specific']);
		$width      = trim($instance['width']);
		$width_auto = trim($instance['width_auto']);
		$align      = trim($instance['align']);
		$layout     = trim($instance['layout']);
		$theme      = trim($instance['theme']);
		$photo      = trim($instance['photo']);
		$owner      = trim($instance['owner']);

		// Correzione del valore di dimensione nel caso venga
		// specificata la maniera automatica e quindi usare javascript

		if ($width_auto == SZ_PLUGIN_GOOGLE_VALUE_YES) $width = SZ_PLUGIN_GOOGLE_VALUE_AUTO;

		// Calcolo del valore ID per la composizione del badge

		if ($method == SZ_PLUGIN_GOOGLE_VALUE_YES) $community = SZ_PLUGIN_GOOGLE_VALUE_NULL;
			else $community = $specific;

		// Creazione del codice per il badge di google+

		$HTML = sz_google_modules_plus_get_code_community(array(
			'id'     => trim($community),
			'width'  => trim($width),
			'align'  => trim($align),
			'layout' => trim($layout),
			'theme'  => trim($theme),
			'photo'  => trim($photo),
			'owner'  => trim($owner),
			'action' => SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET,
		));
	 
		// Output del codice HTML legato al widget da visualizzare		 

		$output  = $before_widget;
		$output .= $title;
		$output .= $HTML;
		$output .= $after_widget;

		echo $output;
	}

	// Funzione per modifica parametri collegati al widget con 
	// memorizzazione dei valori direttamente nel database wordpress

	function update($new_instance,$old_instance) 
	{
		$instance = $old_instance;

		if (!isset($new_instance['title']))      $new_instance['title']      = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['method']))     $new_instance['method']     = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['specific']))   $new_instance['specific']   = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['width']))      $new_instance['width']      = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['width_auto'])) $new_instance['width_auto'] = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['align']))      $new_instance['align']      = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['layout']))     $new_instance['layout']     = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['photo']))      $new_instance['photo']      = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['owner']))      $new_instance['owner']      = SZ_PLUGIN_GOOGLE_VALUE_NULL; 

		$instance['title']      = trim(strip_tags($new_instance['title']));
		$instance['method']     = trim(strip_tags($new_instance['method']));
		$instance['specific']   = trim(strip_tags($new_instance['specific']));
		$instance['width']      = trim(strip_tags($new_instance['width']));
		$instance['width_auto'] = trim(strip_tags($new_instance['width_auto']));
		$instance['align']      = trim(strip_tags($new_instance['align']));
		$instance['layout']     = trim(strip_tags($new_instance['layout']));
		$instance['theme']      = trim(strip_tags($new_instance['theme']));
		$instance['photo']      = trim(strip_tags($new_instance['photo']));
		$instance['owner']      = trim(strip_tags($new_instance['owner']));

		return $instance;
	}

	// Funzione per la visualizzazione del form presente sulle 
	// sidebar nel pannello di amministrazione di wordpress
	
	function form($instance) 
	{
		$array = array(
			'title'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'method'     => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'specific'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'width'      => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_SIZE_PORTRAIT,
			'width_auto' => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'align'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'layout'     => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_LAYOUT,
			'theme'      => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_THEME,
			'photo'      => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_PHOTO,
			'owner'      => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_OWNER,
		);

		// Creazione array per elenco campi da recuperare su FORM

		$instance = wp_parse_args((array) $instance,$array);

		$title      = trim(strip_tags($instance['title']));
		$method     = trim(strip_tags($instance['method']));
		$specific   = trim(strip_tags($instance['specific']));
		$width      = trim(strip_tags($instance['width']));
		$width_auto = trim(strip_tags($instance['width_auto']));
		$align      = trim(strip_tags($instance['align']));
		$layout     = trim(strip_tags($instance['layout']));
		$theme      = trim(strip_tags($instance['theme']));
		$photo      = trim(strip_tags($instance['photo']));
		$owner      = trim(strip_tags($instance['owner']));

		$KEY_method = 'sz-key-1-'.md5(uniqid(),false);
		$KEY_fieldj = 'sz-key-2-'.md5(uniqid(),false);
		$KEY_widths = 'sz-key-3-'.md5(uniqid(),false);
		$KEY_widtha = 'sz-key-4-'.md5(uniqid(),false);

		// Campo di selezione parametro badge per TITOLO

		echo '<p><label for="'.$this->get_field_id('title').'">'.ucfirst(__('title','szgoogleadmin')).':</label>';
		echo '<input class="widefat" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.esc_attr($title).'"/></p>';

		// Campo di selezione parametro badge per ID con metodo

		echo '<p><select class="widefat" id="'.$this->get_field_id('method').'" name="'.$this->get_field_name('method').'" data-sz-key="'.$KEY_method.'">';
		echo '<option value="1" '; selected("1",$method); echo '>'.ucfirst(__('configuration ID','szgoogleadmin')).'</option>';
		echo '<option value="2" '; selected("2",$method); echo '>'.ucfirst(__('specific ID','szgoogleadmin')).'</option>';
		echo '</select></p>';

		// Campo di selezione parametro badge per ID specifico

		echo '<p id="'.$this->get_field_id('fieldj').'" data-sz-key="'.$KEY_fieldj.'">';
		echo '<input class="widefat" id="'.$this->get_field_id('specific').'" name="'.$this->get_field_name('specific').'" type="text" value="'.$specific.'" placeholder="'.__('insert specific ID','szgoogleadmin').'"/></p>';

		echo '<table style="width:100%">';

		// Campo di selezione parametro badge per WIDTH

		echo '<tr>';
		echo '<td><label for="'.$this->get_field_id('width').'">'.ucfirst(__('width','szgoogleadmin')).':</label></td>';
		echo '<td><input data-sz-key="'.$KEY_widths.'" id="'.$this->get_field_id('width').'" name="'.$this->get_field_name('width').'" type="number" size="5" step="1" min="180" max="450" value="'.$width.'"/></td>';
		echo '<td><input data-sz-key="'.$KEY_widtha.'" id="'.$this->get_field_id('width_auto').'" name="'.$this->get_field_name('width_auto').'" class="checkbox" type="checkbox" value="1" '; checked($width_auto); echo '>&nbsp;'.ucfirst(__('auto','szgoogleadmin')).'</td>';
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

		echo '<tr><td colspan="3"><hr></td></tr>';

		// Campo di selezione parametro badge per ALIGN

		echo '<tr>';
		echo '<td><label for="'.$this->get_field_id('align').'">'.ucfirst(__('align','szgoogleadmin')).':</label></td>';
		echo '<td colspan="2"><select class="widefat" id="'.$this->get_field_id('align').'" name="'.$this->get_field_name('align').'">';
		echo '<option value="none" '  ; selected("none"  ,$align); echo '>'.__('none','szgoogleadmin').'</option>';
		echo '<option value="left" '  ; selected("left"  ,$align); echo '>'.__('left','szgoogleadmin').'</option>';
		echo '<option value="center" '; selected("center",$align); echo '>'.__('center','szgoogleadmin').'</option>';
		echo '<option value="right" ' ; selected("right" ,$align); echo '>'.__('right','szgoogleadmin').'</option>';
		echo '</select></td>';
		echo '</tr>';

		echo '</table>';

		// Codice javascript per abilitare/disabilitare il campo ID specifico

		echo '<script type="text/javascript">';
			echo 'jQuery(document).ready(function(){';

				echo 'if (jQuery("#widgets-right [data-sz-key=\''.$KEY_method.'\']").val() == "1"){';
					echo  'jQuery("#widgets-right [data-sz-key=\''.$KEY_fieldj.'\']").hide();';
				echo '}';

				echo 'jQuery("[data-sz-key=\''.$KEY_method.'\']").change(function(){';          
					echo "if (this.value == '1') {";
						echo 'jQuery(this).parents("form:first").find("[data-sz-key=\''.$KEY_fieldj.'\']").slideUp();';
				   echo "} else {";
						echo 'jQuery(this).parents("form:first").find("[data-sz-key=\''.$KEY_fieldj.'\']").slideDown();';
					echo '}';
				echo '});';

				// Codice javascript per abilitare/disabilitare il campo WIDTH

				echo 'if (jQuery("#widgets-right [data-sz-key=\''.$KEY_widtha.'\']").is(":checked")) {';
					echo  'jQuery("#widgets-right [data-sz-key=\''.$KEY_widths.'\']").prop("readonly",true);';
				echo '}';

				echo 'jQuery("[data-sz-key=\''.$KEY_widtha.'\']").change(function(){';          
					echo 'if (jQuery(this).is(":checked")) {';
						echo ' jQuery(this).parents("form:first").find("[data-sz-key=\''.$KEY_widths.'\']").prop("readonly",true);';
				   echo "} else {";
						echo ' jQuery(this).parents("form:first").find("[data-sz-key=\''.$KEY_widths.'\']").prop("readonly",false);';
					echo '}';
				echo '});';

			echo '});';
		echo '</script>';
	}
}

/* ************************************************************************** */
/* FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLL */
/* FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLL */
/* FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLL */
/* FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLL */
/* FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLL */
/* ************************************************************************** */

function sz_google_modules_plus_get_code_followers($atts,$content=null) 
{
	// Estrazione dei valori specificati nello shortcode, i valori ritornati
	// sono contenuti nei nomi di variabili corrispondenti alla chiave

	if (!is_array($atts)) $atts = array();

	extract(shortcode_atts(array(
		'id'     => SZ_PLUGIN_GOOGLE_PLUS_ID_PAGE,
		'width'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'height' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'align'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'action' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts));

	// Esecuzione trim su valori specificati su shortcode

	$id     = trim($id);
	$width  = strtolower(trim($width));
	$height = strtolower(trim($height));
	$align  = strtolower(trim($align));
	$action = strtolower(trim($action));

	// Lettura opzioni generali per impostazione dei dati di default

	$options = sz_google_modules_plus_options();

	// Imposto i valori di default nel caso siano specificati dei valori
	// che non appartengono al range dei valori accettati

	if ($id == SZ_PLUGIN_GOOGLE_VALUE_NULL) { $id = $options['plus_page']; }
	if ($id == SZ_PLUGIN_GOOGLE_VALUE_NULL) { $id = $options['plus_profile']; }

	if ($id == SZ_PLUGIN_GOOGLE_VALUE_NULL) { $id = SZ_PLUGIN_GOOGLE_PLUS_ID_PAGE; }
	if ($id == SZ_PLUGIN_GOOGLE_VALUE_NULL) { $id = SZ_PLUGIN_GOOGLE_PLUS_ID_PROFILE; }

	// Controllo la dimensione del widget e controllo formale dei valori numerici
	// se trovo qualche incongruenza applico i valori di default prestabiliti

	if (!is_numeric($width)  and $width  != 'auto') $width  = SZ_PLUGIN_GOOGLE_VALUE_NULL;
	if (!is_numeric($height) and $height != 'auto') $height = SZ_PLUGIN_GOOGLE_VALUE_NULL;

	if ($action != SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET) {
		if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = $options['plus_shortcode_size_portrait'];
		if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_SIZE_PORTRAIT;
	} else {
		if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = $options['plus_widget_size_portrait'];
		if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_SIZE_PORTRAIT;
	}

	if (!is_numeric($width)  and $width  != 'auto') $width  = SZ_PLUGIN_GOOGLE_VALUE_NULL;
	if (!is_numeric($height) and $height != 'auto') $height = SZ_PLUGIN_GOOGLE_VALUE_NULL;

	// Controllo la dimensione del widget e controllo formale dei valori numerici
	// se trovo qualche incongruenza applico i valori di default prestabiliti

	if ($width  == SZ_PLUGIN_GOOGLE_VALUE_AUTO) $width = "'+w+'";
	if ($width  == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = "'+w+'";

	if ($height == SZ_PLUGIN_GOOGLE_VALUE_AUTO) $height = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_HEIGHT;
	if ($height == SZ_PLUGIN_GOOGLE_VALUE_NULL) $height = SZ_PLUGIN_GOOGLE_PLUS_WIDGET_HEIGHT;

	$uniqueID = 'sz-google-followers-'.md5(uniqid(),false);

	// Preparazione codice HTML per il badge di google plus

	$HTML  = '<div class="sz-google-followers">';
	$HTML .= '<div class="sz-google-followers-wrap">';

	$HTML .= '<div id="'.$uniqueID.'" style="display:block;';

	if ($align == 'left')   $HTML .= 'text-align:left;';
	if ($align == 'center') $HTML .= 'text-align:center;';
	if ($align == 'right')  $HTML .= 'text-align:right;';

	$HTML .= '">';

	$HTML .= '<script type="text/javascript">';
	$HTML .= "var w=document.getElementById('".$uniqueID."').offsetWidth;";
	$HTML .= "document.write('";
	$HTML .= '<div class="g-plus"';
	$HTML .= ' data-action="followers"';
	$HTML .= ' data-href="https://plus.google.com/'.$id.'"';
	$HTML .= ' data-width="' .$width .'"';
	$HTML .= ' data-height="'.$height.'"';
	$HTML .= ' data-source="blogger:blog:followers"';
	$HTML .= '></div>'."');";
	$HTML .= '</script>';

	$HTML .= '</div>';
	$HTML .= '</div>';
	$HTML .= '</div>';

	// Aggiunta del codice javascript per il rendering dei widget, questo codice		 
	// viene aggiungo anche dalla sidebar però viene inserito una sola volta

	add_action('wp_footer','sz_google_modules_plus_add_script_footer');

	// Ritorno per la funzione con tutta la stringa contenente
	// il codice HTML per l'inserimento del codice nella pagina

	return $HTML;
}

/* ************************************************************************** */
/* GOOGLE+ FOLLOWERS funzione per elaborazione shortcode (sz-gplus-followers) */
/* ************************************************************************** */

function sz_google_shortcodes_plus_followers($atts,$content=null) 
{
	extract(shortcode_atts(array(
		'id'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'width'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'height' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'align'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'action' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts));

	// Preparazione codice HTML dello shortcode tramite la funzione
	// standard di preparazione codice sia per shortcode che widgets

	$HTML = sz_google_modules_plus_get_code_followers(array(
		'id'     => trim($id),
		'width'  => trim($width),
		'height' => trim($height),
		'align'  => trim($align),
		'action' => SZ_PLUGIN_GOOGLE_VALUE_TEXT_SHORTCODE,
	),$content);

	// Ritorno per la funzione con tutta la stringa contenente
	// il codice HTML per l'inserimento del codice nella pagina

	return $HTML;
}

/* ************************************************************************** */ 
/* GOOGLE+ FOLLOWERS definizione ed elaborazione del widget su sidebar        */ 
/* ************************************************************************** */ 

class SZ_Widget_Google_Followers extends WP_Widget 
{
	// Costruttore principale della classe widget, definizione 
	// delle opzioni legate al widget e al controllo dello stesso

	function SZ_Widget_Google_Followers() 
	{
		$widget_ops  = array(
			'classname'   => 'sz-widget-google sz-widget-google-plus sz-widget-google-plus-followers', 
			'description' => ucfirst(__('widget for google+ followers','szgoogleadmin'))
		);

		$this->WP_Widget('SZ-Google-Followers',
			__('SZ-Google - G+ Followers','szgoogleadmin'),$widget_ops);
	}

	// Funzione per la visualizzazione del widget con lettura parametri
	// di configurazione e preparazione codice HTML da usare nella sidebar

	function widget($args,$instance) 
	{
		extract($args);

		// Costruzione del titolo del widget tramite la funzione
		// di uso comune a tutti i widgets del plugin sz-google

		$title = sz_google_modules_widget_title($args,$instance);

		// Controllo se esistono le variabili che servono durante l'elaborazione
		// dello script e assegno dei valori di default nel caso non fossero specificati

		if (empty($instance['method']))      $instance['method']      = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['specific']))    $instance['specific']    = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['width']))       $instance['width']       = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['width_auto']))  $instance['width_auto']  = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['height']))      $instance['height']      = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['height_auto'])) $instance['height_auto'] = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['align']))       $instance['align']       = SZ_PLUGIN_GOOGLE_VALUE_NULL;

		$method      = strtolower(trim($instance['method']));
		$specific    = strtolower(trim($instance['specific']));
		$width       = strtolower(trim($instance['width']));
		$width_auto  = strtolower(trim($instance['width_auto']));
		$height      = strtolower(trim($instance['height']));
		$height_auto = strtolower(trim($instance['height_auto']));
		$align       = strtolower(trim($instance['align']));

		// Correzione del valore di dimensione nel caso venga
		// specificata la maniera automatica e quindi usare javascript

		if ($width_auto  == SZ_PLUGIN_GOOGLE_VALUE_YES) $width  = SZ_PLUGIN_GOOGLE_VALUE_AUTO;
		if ($height_auto == SZ_PLUGIN_GOOGLE_VALUE_YES) $height = SZ_PLUGIN_GOOGLE_VALUE_AUTO;

		// Calcolo del valore ID per la composizione del badge

		if ($method == SZ_PLUGIN_GOOGLE_VALUE_YES) $reference = SZ_PLUGIN_GOOGLE_VALUE_NULL;
			else $reference = trim($specific);

		// Creazione del codice per il badge di google+

		$HTML = sz_google_modules_plus_get_code_followers(array(
			'id'     => trim($reference),
			'width'  => trim($width),
			'height' => trim($height),
			'align'  => trim($align),
			'action' => SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET,
		));
	 
		// Output del codice HTML legato al widget da visualizzare		 

		$output  = $before_widget;
		$output .= $title;
		$output .= $HTML;
		$output .= $after_widget;

		echo $output;
	}

	// Funzione per modifica parametri collegati al widget con 
	// memorizzazione dei valori direttamente nel database wordpress

	function update($new_instance,$old_instance) 
	{
		$instance = $old_instance;

		if (!isset($new_instance['title']))       $new_instance['title']       = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['method']))      $new_instance['method']      = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['specific']))    $new_instance['specific']    = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['width']))       $new_instance['width']       = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['width_auto']))  $new_instance['width_auto']  = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['height']))      $new_instance['height']      = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['height_auto'])) $new_instance['height_auto'] = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['align']))       $new_instance['align']       = SZ_PLUGIN_GOOGLE_VALUE_NULL; 

		$instance['title']       = trim(strip_tags($new_instance['title']));
		$instance['method']      = trim(strip_tags($new_instance['method']));
		$instance['specific']    = trim(strip_tags($new_instance['specific']));
		$instance['width']       = trim(strip_tags($new_instance['width']));
		$instance['width_auto']  = trim(strip_tags($new_instance['width_auto']));
		$instance['height']      = trim(strip_tags($new_instance['height']));
		$instance['height_auto'] = trim(strip_tags($new_instance['height_auto']));
		$instance['align']       = trim(strip_tags($new_instance['align']));

		return $instance;
	}

	// Funzione per la visualizzazione del form presente sulle 
	// sidebar nel pannello di amministrazione di wordpress
	
	function form($instance) 
	{
		$array = array(
			'title'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'method'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'specific'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'width'       => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_SIZE_PORTRAIT,
			'width_auto'  => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'height'      => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_HEIGHT,
			'height_auto' => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'align'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		);

		// Creazione array per elenco campi da recuperare su FORM

		$instance = wp_parse_args((array) $instance,$array);

		$title       = trim(strip_tags($instance['title']));
		$method      = trim(strip_tags($instance['method']));
		$specific    = trim(strip_tags($instance['specific']));
		$width       = trim(strip_tags($instance['width']));
		$width_auto  = trim(strip_tags($instance['width_auto']));
		$height      = trim(strip_tags($instance['height']));
		$height_auto = trim(strip_tags($instance['height_auto']));
		$align       = trim(strip_tags($instance['align']));

		$KEY_method  = 'sz-key-1-'.md5(uniqid(),false);
		$KEY_fieldj  = 'sz-key-2-'.md5(uniqid(),false);
		$KEY_widths  = 'sz-key-3-'.md5(uniqid(),false);
		$KEY_widtha  = 'sz-key-4-'.md5(uniqid(),false);
		$KEY_heights = 'sz-key-5-'.md5(uniqid(),false);
		$KEY_heighta = 'sz-key-6-'.md5(uniqid(),false);

		// Campo di selezione parametro badge per TITOLO

		echo '<p><label for="'.$this->get_field_id('title').'">'.ucfirst(__('title','szgoogleadmin')).':</label>';
		echo '<input class="widefat" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.esc_attr($title).'"/></p>';

		// Campo di selezione parametro badge per ID con metodo

		echo '<p><select class="widefat" id="'.$this->get_field_id('method').'" name="'.$this->get_field_name('method').'" data-sz-key="'.$KEY_method.'">';
		echo '<option value="1" '; selected("1",$method); echo '>'.ucfirst(__('configuration ID','szgoogleadmin')).'</option>';
		echo '<option value="2" '; selected("2",$method); echo '>'.ucfirst(__('specific ID','szgoogleadmin')).'</option>';
		echo '</select></p>';

		// Campo di selezione parametro badge per ID specifico

		echo '<p id="'.$this->get_field_id('fieldj').'" data-sz-key="'.$KEY_fieldj.'">';
		echo '<input class="widefat" id="'.$this->get_field_id('specific').'" name="'.$this->get_field_name('specific').'" type="text" value="'.$specific.'" placeholder="'.__('insert specific ID','szgoogleadmin').'"/></p>';

		echo '<table style="width:100%">';

		// Campo di selezione parametro badge per WIDTH

		echo '<tr>';
		echo '<td><label for="'.$this->get_field_id('width').'">'.ucfirst(__('width','szgoogleadmin')).':</label></td>';
		echo '<td><input data-sz-key="'.$KEY_widths.'" id="'.$this->get_field_id('width').'" name="'.$this->get_field_name('width').'" type="number" size="5" step="1" min="180" max="450" value="'.$width.'"/></td>';
		echo '<td><input data-sz-key="'.$KEY_widtha.'" id="'.$this->get_field_id('width_auto').'" name="'.$this->get_field_name('width_auto').'" class="checkbox" type="checkbox" value="1" '; checked($width_auto); echo '>&nbsp;'.ucfirst(__('auto','szgoogleadmin')).'</td>';
		echo '</tr>';

		// Campo di selezione parametro badge per HEIGHT

		echo '<tr>';
		echo '<td><label for="'.$this->get_field_id('height').'">'.ucfirst(__('height','szgoogleadmin')).':</label></td>';
		echo '<td><input data-sz-key="'.$KEY_heights.'" id="'.$this->get_field_id('height').'" name="'.$this->get_field_name('height').'" type="number" size="5" step="1" min="180" max="450" value="'.$height.'"/></td>';
		echo '<td><input data-sz-key="'.$KEY_heighta.'" id="'.$this->get_field_id('height_auto').'" name="'.$this->get_field_name('height_auto').'" class="checkbox" type="checkbox" value="1" '; checked($height_auto); echo '>&nbsp;'.ucfirst(__('auto','szgoogleadmin')).'</td>';
		echo '</tr>';

		echo '<tr><td colspan="3"><hr></td></tr>';

		// Campo di selezione parametro badge per ALIGN

		echo '<tr>';
		echo '<td><label for="'.$this->get_field_id('align').'">'.ucfirst(__('align','szgoogleadmin')).':</label></td>';
		echo '<td colspan="2"><select class="widefat" id="'.$this->get_field_id('align').'" name="'.$this->get_field_name('align').'">';
		echo '<option value="none" '  ; selected("none"  ,$align); echo '>'.__('none','szgoogleadmin').'</option>';
		echo '<option value="left" '  ; selected("left"  ,$align); echo '>'.__('left','szgoogleadmin').'</option>';
		echo '<option value="center" '; selected("center",$align); echo '>'.__('center','szgoogleadmin').'</option>';
		echo '<option value="right" ' ; selected("right" ,$align); echo '>'.__('right','szgoogleadmin').'</option>';
		echo '</select></td>';
		echo '</tr>';

		echo '</table>';

		// Codice javascript per abilitare/disabilitare il campo ID specifico

		echo '<script type="text/javascript">';
			echo 'jQuery(document).ready(function(){';

				echo 'if (jQuery("#widgets-right [data-sz-key=\''.$KEY_method.'\']").val() == "1"){';
					echo  'jQuery("#widgets-right [data-sz-key=\''.$KEY_fieldj.'\']").hide();';
				echo '}';

				echo 'jQuery("[data-sz-key=\''.$KEY_method.'\']").change(function(){';          
					echo "if (this.value == '1') {";
						echo 'jQuery(this).parents("form:first").find("[data-sz-key=\''.$KEY_fieldj.'\']").slideUp();';
				   echo "} else {";
						echo 'jQuery(this).parents("form:first").find("[data-sz-key=\''.$KEY_fieldj.'\']").slideDown();';
					echo '}';
				echo '});';

				// Codice javascript per abilitare/disabilitare il campo WIDTH

				echo 'if (jQuery("#widgets-right [data-sz-key=\''.$KEY_widtha.'\']").is(":checked")) {';
					echo  'jQuery("#widgets-right [data-sz-key=\''.$KEY_widths.'\']").prop("readonly",true);';
				echo '}';

				echo 'jQuery("[data-sz-key=\''.$KEY_widtha.'\']").change(function(){';          
					echo 'if (jQuery(this).is(":checked")) {';
						echo ' jQuery(this).parents("form:first").find("[data-sz-key=\''.$KEY_widths.'\']").prop("readonly",true);';
				   echo "} else {";
						echo ' jQuery(this).parents("form:first").find("[data-sz-key=\''.$KEY_widths.'\']").prop("readonly",false);';
					echo '}';
				echo '});';

				// Codice javascript per abilitare/disabilitare il campo HEIGHT

				echo 'if (jQuery("#widgets-right [data-sz-key=\''.$KEY_heighta.'\']").is(":checked")) {';
					echo  'jQuery("#widgets-right [data-sz-key=\''.$KEY_heights.'\']").prop("readonly",true);';
				echo '}';

				echo 'jQuery("[data-sz-key=\''.$KEY_heighta.'\']").change(function(){';          
					echo 'if (jQuery(this).is(":checked")) {';
						echo ' jQuery(this).parents("form:first").find("[data-sz-key=\''.$KEY_heights.'\']").prop("readonly",true);';
				   echo "} else {";
						echo ' jQuery(this).parents("form:first").find("[data-sz-key=\''.$KEY_heights.'\']").prop("readonly",false);';
					echo '}';
				echo '});';

			echo '});';
		echo '</script>';
	}
}

/* ************************************************************************** */
/* COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS CO */
/* COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS CO */
/* COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS CO */
/* COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS CO */
/* COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS CO */
/* ************************************************************************** */

function sz_google_modules_plus_get_code_comments($atts,$content=null) 
{
	// Estrazione dei valori specificati nello shortcode, i valori ritornati
	// sono contenuti nei nomi di variabili corrispondenti alla chiave

	if (!is_array($atts)) $atts = array();

	extract(shortcode_atts(array(
		'url'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'width'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'align'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'title'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'class1' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'class2' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts));

	// Elimino spazi aggiunti di troppo ed esegui la trasformazione in
	// stringa minuscolo per il controllo di valori speciali come "auto"

	$options  = sz_google_modules_plus_options();
	$uniqueID = 'sz-google-comments-'.md5(uniqid(),false);

	$url    = trim($url);
	$title  = trim($title);
	$class1 = trim($class1);
	$class2 = trim($class2);

	$width  = strtolower(trim($width));
	$align  = strtolower(trim($align));

	// Controllo opzione per dimensione fissa da applicare se esiste 
	// un valore specificato e il parametro width non è stato specificato. 

	if (!is_numeric($width) and $width != 'auto') $width = SZ_PLUGIN_GOOGLE_VALUE_NULL;

	if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = $options['plus_comments_fixed_size'];
	if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = SZ_PLUGIN_GOOGLE_VALUE_AUTO;

	if (!is_numeric($width) and $width != 'auto') $width = SZ_PLUGIN_GOOGLE_VALUE_NULL;

	// Controllo opzione per dimensione fissa da applicare se esiste 
	// un valore specificato e il parametro width non è stato specificato. 

	if ($width == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width = "'+w+'";
	if ($width == SZ_PLUGIN_GOOGLE_VALUE_AUTO) $width = "'+w+'";

	// Se non specifico un URL fisso imposto il permalink attuale

	if ($url == SZ_PLUGIN_GOOGLE_VALUE_NULL) $url = get_permalink();

	// Elimino dal path i riferimenti aggiunti ai link di navigazione e 
	// riporto il link originale di google plus, senza /u/0/b etc etc

	$url = sz_google_modules_plus_get_canonical_url($url);

	// Controllo i valori delle classi eventuali da ggiungere ai wrapper

	if (!empty($title))  $title  = str_ireplace('{title}',ucfirst(__('leave a Reply','szgoogleadmin')),$title);
	if (!empty($class2)) $class2 = ' '.$class2;
	if (!empty($class2)) $class2 = ' '.$class2;

	// Creazione codice HTML per embed code da inserire nella pagina wordpress
	// Questo codice deve essere usato sia dallo shortcode, dal widget e dalla funzione

	$HTML  = '<div class="sz-google-comments'.$class1.'">';
	if (!empty($title)) $HTML .= $title;
	$HTML .= '<div class="sz-google-comments-wrap'.$class2.'">';

	$HTML .= '<div id="'.$uniqueID.'" style="display:block;';

	if ($align == 'left')   $HTML .= 'text-align:left;';
	if ($align == 'center') $HTML .= 'text-align:center;';
	if ($align == 'right')  $HTML .= 'text-align:right;';

	$HTML .= '">';

	$HTML .= '<script type="text/javascript">';
	$HTML .= "var w=document.getElementById('".$uniqueID."').offsetWidth;";
	$HTML .= "document.write('";
	$HTML .= '<div class="g-comments"';
	$HTML .= ' data-href="'.$url.'"';
	$HTML .= ' data-width="'.$width.'"';
	$HTML .= ' data-height="50" ';
	$HTML .= ' data-first_party_property="BLOGGER"';
	$HTML .= ' data-view_type="FILTERED_POSTMOD"';
	$HTML .= '></div>'."');";
	$HTML .= '</script>';

	$HTML .= '</div>';
	$HTML .= '</div>';
	$HTML .= '</div>';

	// Aggiunta del codice javascript per il rendering dei widget, questo codice		 
	// viene aggiungo anche dalla sidebar però viene inserito una sola volta

	add_action('wp_footer','sz_google_modules_plus_add_script_footer');

	// Ritorno per la funzione con tutta la stringa contenente
	// il codice HTML per l'inserimento del codice nella pagina

	return $HTML;
}

/* ************************************************************************** */
/* GOOGLE+ COMMENTS funzione per rendering del sistema di commenti            */
/* ************************************************************************** */

function sz_google_modules_comments_system_enable() 
{
	// Calcolo opzioni di configurazione generale

	$options = sz_google_modules_plus_options();

	// Se è specificata opzione dopo il contenuto applico il filtro a the_content
	// altrimenti applico il filtro alla funzione di comment_template

	if ($options['plus_comments_ac_enable'] == SZ_PLUGIN_GOOGLE_VALUE_YES) 
	{
		add_filter('the_content','sz_google_modules_comments_content');

		if ($options['plus_comments_wp_enable'] != SZ_PLUGIN_GOOGLE_VALUE_YES)   
			add_filter('comments_template','sz_google_modules_comments_system_none');

	} else {
		add_filter('comments_template','sz_google_modules_comments_system');
	}
}

/* ************************************************************************** */
/* GOOGLE+ COMMENTS funzione per rendering del sistema di commenti            */
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
	}

	// Creazione codice HTML per inserimento widget commenti		 

	$HTML = sz_google_modules_plus_get_code_comments(array(
		'url'    => get_permalink(),
		'width'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'title'  => trim($options['plus_comments_title']),
		'class1' => trim($options['plus_comments_css_class_1']),
		'class2' => trim($options['plus_comments_css_class_2']),
	));

	echo $HTML;

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

function sz_google_modules_comments_system_none($include) {
	return plugin_dir_path( __FILE__ ).'sz-google-modules-plus-comments-dummy.php';
}

/* ************************************************************************** */
/* GOOGLE+ COMMENTS funzione per rendering del sistema di commenti            */
/* ************************************************************************** */

function sz_google_modules_comments_content($content) 
{
	global $post,$comments;

	if (!(is_singular() && (have_comments() || 'open' == $post->comment_status))) { return $content; }

	// Creazione codice HTML per inserimento widget dei commenti		 

	$HTML = sz_google_modules_plus_get_code_comments(array(
		'url'    => get_permalink(),
		'width'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'title'  => '<h3>'.ucfirst(__('leave a Reply','szgoogleadmin')).'</h3>',
		'class1' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'class2' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	));

	// Aggiunta del codice javascript per il rendering dei widget		 
	// Questo codice viene aggiungo anche dalla sidebar però viene inserito una sola volta

	add_action('wp_footer','sz_google_modules_plus_add_script_footer');

	return $content.$HTML;
}

/* ************************************************************************** */
/* GOOGLE+ COMMENTS funzione per elaborazione shortcode (sz-gplus-comments)   */
/* ************************************************************************** */

function sz_google_shortcodes_plus_comments($atts,$content=null) 
{
	extract(shortcode_atts(array(
		'url'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'width'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'align'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'title'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'class1' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'class2' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts));

	// Preparazione codice HTML dello shortcode tramite la funzione
	// standard di preparazione codice sia per shortcode che widgets

	$HTML = sz_google_modules_plus_get_code_comments(array(
		'url'    => trim($url),
		'width'  => trim($width),
		'align'  => trim($align),
		'title'  => trim($title),
		'class1' => trim($class1),
		'class2' => trim($class2),
	),$content);

	// Ritorno per la funzione con tutta la stringa contenente
	// il codice HTML per l'inserimento del codice nella pagina

	return $HTML;
}

/* ************************************************************************** */ 
/* GOOGLE+ COMMENTS definizione ed elaborazione del widget su sidebar         */ 
/* ************************************************************************** */ 

class SZ_Widget_Google_Comments extends WP_Widget
{
	// Costruttore principale della classe widget, definizione 
	// delle opzioni legate al widget e al controllo dello stesso

	function SZ_Widget_Google_Comments() 
	{
		$widget_ops  = array(
			'classname'   => 'sz-widget-google sz-widget-google-plus sz-widget-google-plus-comments', 
			'description' => ucfirst(__('widget for google+ comments','szgoogleadmin'))
		);

		$this->WP_Widget('SZ-Google-Comments',
			__('SZ-Google - G+ Comments','szgoogleadmin'),$widget_ops);
	}

	// Funzione per la visualizzazione del widget con lettura parametri
	// di configurazione e preparazione codice HTML da usare nella sidebar

	function widget($args,$instance) 
	{
		extract($args);

		// Costruzione del titolo del widget tramite la funzione
		// di uso comune a tutti i widgets del plugin sz-google

		$title = sz_google_modules_widget_title($args,$instance);

		// Controllo se esistono le variabili che servono durante l'elaborazione
		// dello script e assegno dei valori di default nel caso non fossero specificati

		if (empty($instance['url']))        $instance['url']        = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['method']))     $instance['method']     = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['width']))      $instance['width']      = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['width_auto'])) $instance['width_auto'] = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['align']))      $instance['align']      = SZ_PLUGIN_GOOGLE_VALUE_NULL;

		$url        = trim($instance['url']);
		$method     = strtolower(trim($instance['method']));
		$width_auto = strtolower(trim($instance['width_auto']));
		$width      = strtolower(trim($instance['width']));
		$align      = strtolower(trim($instance['align']));

		if ($method     == SZ_PLUGIN_GOOGLE_VALUE_YES) $url   = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if ($width_auto == SZ_PLUGIN_GOOGLE_VALUE_YES) $width = SZ_PLUGIN_GOOGLE_VALUE_AUTO;

		// Creazione codice HTML per inserimento widget commenti		 

		$HTML = sz_google_modules_plus_get_code_comments(array(
			'url'    => trim($url),
			'width'  => trim($width),
			'align'  => trim($align),
			'title'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'class1' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'class2' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		));

		// Output del codice HTML legato al widget da visualizzare		 

		$output  = $before_widget;
		$output .= $title;
		$output .= $HTML;
		$output .= $after_widget;

		echo $output;
	}

	// Funzione per modifica parametri collegati al widget con 
	// memorizzazione dei valori direttamente nel database wordpress

	function update($new_instance,$old_instance) 
	{
		$instance = $old_instance;

		if (!isset($new_instance['title']))      $new_instance['title']      = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['method']))     $new_instance['method']     = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['url']))        $new_instance['url']        = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['width']))      $new_instance['width']      = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['width_auto'])) $new_instance['width_auto'] = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['align']))      $new_instance['align']      = SZ_PLUGIN_GOOGLE_VALUE_NULL; 

		$instance['url']        = trim($new_instance['url']);
		$instance['title']      = trim(strip_tags($new_instance['title']));
		$instance['method']     = trim(strip_tags($new_instance['method']));
		$instance['width']      = trim(strip_tags($new_instance['width']));
		$instance['width_auto'] = trim(strip_tags($new_instance['width_auto']));
		$instance['align']      = trim(strip_tags($new_instance['align']));

		return $instance;
	}

	// Funzione per la visualizzazione del form presente sulle 
	// sidebar nel pannello di amministrazione di wordpress
	
	function form($instance) 
	{
		$array = array(
			'title'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'url'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'method'     => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'width'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'width_auto' => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'align'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		);

		// Creazione array per elenco campi da recuperare su FORM

		$instance   = wp_parse_args((array) $instance,$array);

		$url        = trim($instance['url']);
		$title      = trim(strip_tags($instance['title']));
		$method     = trim(strip_tags($instance['method']));
		$width      = trim(strip_tags($instance['width']));
		$width_auto = trim(strip_tags($instance['width_auto']));
		$align      = trim(strip_tags($instance['align']));

		$KEY_method = 'sz-key-1-'.md5(uniqid(),false);
		$KEY_fieldj = 'sz-key-2-'.md5(uniqid(),false);
		$KEY_widths = 'sz-key-3-'.md5(uniqid(),false);
		$KEY_widtha = 'sz-key-4-'.md5(uniqid(),false);

		// Campo di selezione parametro badge per TITOLO

		echo '<p><label for="'.$this->get_field_id('title').'">'.ucfirst(__('title','szgoogleadmin')).':</label>';
		echo '<input class="widefat" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.esc_attr($title).'"/></p>';

		// Campo di selezione parametro badge per ID con metodo

		echo '<p><select class="widefat" id="'.$this->get_field_id('method').'" name="'.$this->get_field_name('method').'" data-sz-key="'.$KEY_method.'">';
		echo '<option value="1" '; selected("1",$method); echo '>'.ucfirst(__('current post','szgoogleadmin')).'</option>';
		echo '<option value="2" '; selected("2",$method); echo '>'.ucfirst(__('specific URL','szgoogleadmin')).'</option>';
		echo '</select></p>';

		// Campo di selezione parametro badge per URL specifico

		echo '<p id="'.$this->get_field_id('fieldj').'" data-sz-key="'.$KEY_fieldj.'">';
		echo '<input class="widefat" id="'.$this->get_field_id('url').'" name="'.$this->get_field_name('url').'" type="text" value="'.$url.'" placeholder="'.__('insert specific URL','szgoogleadmin').'"/></p>';

		echo '<table style="width:100%">';

		// Campo di selezione parametro badge per WIDTH

		echo '<tr>';
		echo '<td><label for="'.$this->get_field_id('width').'">'.ucfirst(__('width','szgoogleadmin')).':</label></td>';
		echo '<td><input data-sz-key="'.$KEY_widths.'" id="'.$this->get_field_id('width').'" name="'.$this->get_field_name('width').'" type="number" size="5" step="1" min="180" max="450" value="'.$width.'"/></td>';
		echo '<td><input data-sz-key="'.$KEY_widtha.'" id="'.$this->get_field_id('width_auto').'" name="'.$this->get_field_name('width_auto').'" class="checkbox" type="checkbox" value="1" '; checked($width_auto); echo '>&nbsp;'.ucfirst(__('auto','szgoogleadmin')).'</td>';
		echo '</tr>';

		echo '<tr><td colspan="3"><hr></td></tr>';

		// Campo di selezione parametro badge per ALIGN

		echo '<tr>';
		echo '<td><label for="'.$this->get_field_id('align').'">'.ucfirst(__('align','szgoogleadmin')).':</label></td>';
		echo '<td colspan="2"><select class="widefat" id="'.$this->get_field_id('align').'" name="'.$this->get_field_name('align').'">';
		echo '<option value="none" '  ; selected("none"  ,$align); echo '>'.__('none','szgoogleadmin').'</option>';
		echo '<option value="left" '  ; selected("left"  ,$align); echo '>'.__('left','szgoogleadmin').'</option>';
		echo '<option value="center" '; selected("center",$align); echo '>'.__('center','szgoogleadmin').'</option>';
		echo '<option value="right" ' ; selected("right" ,$align); echo '>'.__('right','szgoogleadmin').'</option>';
		echo '</select></td>';
		echo '</tr>';

		echo '</table>';

		// Codice javascript per abilitare/disabilitare il campo ID specifico

		echo '<script type="text/javascript">';
			echo 'jQuery(document).ready(function(){';

				echo 'if (jQuery("#widgets-right [data-sz-key=\''.$KEY_method.'\']").val() == "1"){';
					echo  'jQuery("#widgets-right [data-sz-key=\''.$KEY_fieldj.'\']").hide();';
				echo '}';

				echo 'jQuery("[data-sz-key=\''.$KEY_method.'\']").change(function(){';          
					echo "if (this.value == '1') {";
						echo 'jQuery(this).parents("form:first").find("[data-sz-key=\''.$KEY_fieldj.'\']").slideUp();';
				   echo "} else {";
						echo 'jQuery(this).parents("form:first").find("[data-sz-key=\''.$KEY_fieldj.'\']").slideDown();';
					echo '}';
				echo '});';

				// Codice javascript per abilitare/disabilitare il campo WIDTH

				echo 'if (jQuery("#widgets-right [data-sz-key=\''.$KEY_widtha.'\']").is(":checked")) {';
					echo  'jQuery("#widgets-right [data-sz-key=\''.$KEY_widths.'\']").prop("readonly",true);';
				echo '}';

				echo 'jQuery("[data-sz-key=\''.$KEY_widtha.'\']").change(function(){';          
					echo 'if (jQuery(this).is(":checked")) {';
						echo ' jQuery(this).parents("form:first").find("[data-sz-key=\''.$KEY_widths.'\']").prop("readonly",true);';
				   echo "} else {";
						echo ' jQuery(this).parents("form:first").find("[data-sz-key=\''.$KEY_widths.'\']").prop("readonly",false);';
					echo '}';
				echo '});';

			echo '});';
		echo '</script>';
	}
}

/* ************************************************************************** */
/* REWRITE RULES REWRITE RULES REWRITE RULES REWRITE RULES REWRITE RULES REWR */
/* REWRITE RULES REWRITE RULES REWRITE RULES REWRITE RULES REWRITE RULES REWR */
/* REWRITE RULES REWRITE RULES REWRITE RULES REWRITE RULES REWRITE RULES REWR */
/* REWRITE RULES REWRITE RULES REWRITE RULES REWRITE RULES REWRITE RULES REWR */
/* REWRITE RULES REWRITE RULES REWRITE RULES REWRITE RULES REWRITE RULES REWR */
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
		if (trim($options['plus_redirect_curl_dir']) != SZ_PLUGIN_GOOGLE_VALUE_NULL and 
			trim($options['plus_redirect_curl_url']) != SZ_PLUGIN_GOOGLE_VALUE_NULL) {
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
		if (trim($options['plus_redirect_sign_url']) != SZ_PLUGIN_GOOGLE_VALUE_NULL) {   
			header("location:".trim($options['plus_redirect_sign_url'])); exit();
		}
	}

	// Controllo REDIRECT per url con la stringa "plus"
	
	if (array_key_exists('szgoogleplusredirectplus',$wp->query_vars)) {
		if (trim($options['plus_redirect_plus_url']) != SZ_PLUGIN_GOOGLE_VALUE_NULL) {   
			header("location:".trim($options['plus_redirect_plus_url'])); exit();
		}
	}

	// Controllo REDIRECT per url con la stringa "URL"
	
	if (array_key_exists('szgoogleplusredirectcurl',$wp->query_vars)) {
		if (trim($options['plus_redirect_curl_url']) != SZ_PLUGIN_GOOGLE_VALUE_NULL) {   
			header("location:".trim($options['plus_redirect_curl_url'])); exit();
		}
	}
}

/* ************************************************************************** */
/* COMMON CODE COMMON CODE COMMON CODE COMMON CODE COMMON CODE COMMON CODE CO */
/* COMMON CODE COMMON CODE COMMON CODE COMMON CODE COMMON CODE COMMON CODE CO */
/* COMMON CODE COMMON CODE COMMON CODE COMMON CODE COMMON CODE COMMON CODE CO */
/* COMMON CODE COMMON CODE COMMON CODE COMMON CODE COMMON CODE COMMON CODE CO */
/* COMMON CODE COMMON CODE COMMON CODE COMMON CODE COMMON CODE COMMON CODE CO */
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
/* GOOGLE+ COMMON codice per disegnare il wrap dei bottoni di google plus     */
/* ************************************************************************** */

function sz_google_modules_plus_get_code_button_wrap($atts) {
	return sz_google_modules_get_code_button_wrap($atts);
}

/* ************************************************************************** */
/* GOOGLE+ COMMON calcolo indirizzo URL levando i dati di navigazione         */
/* ************************************************************************** */

function sz_google_modules_plus_get_canonical_url($url=null) 
{
	$url = str_ireplace('://plus.google.com/b/'    ,'://plus.google.com/',$url);
	$url = str_ireplace('://plus.google.com/u/0/b/','://plus.google.com/',$url);
	$url = str_ireplace('://plus.google.com/u/0/'  ,'://plus.google.com/',$url);

	return $url;
}