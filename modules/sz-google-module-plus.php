<?php
/**
 * Modulo GOOGLE PLUS per la definizione delle funzioni che riguardano
 * sia i widget che i shortcode ma anche filtri e azioni che il modulo
 * può integrare durante l'aggiunta di funzionalità a wordpress.
 *
 * @package SZGoogle
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

/**
 * Definizione della classe principale da utilizzare per questo
 * modulo. La classe deve essere una extends di SZGoogleModule
 * dove bisogna ridefinire il metodo per il calcolo delle opzioni.
 */
class SZGoogleModulePlus extends SZGoogleModule
{
	function __construct()
	{
		parent::__construct();

		$this->moduleShortcodes = array(
			'plus_shortcode_pr_enable'          => array('sz-gplus-profile'  ,'sz_google_module_plus_shortcodes_profile'),
			'plus_shortcode_pa_enable'          => array('sz-gplus-page'     ,'sz_google_module_plus_shortcodes_page'),
			'plus_shortcode_co_enable'          => array('sz-gplus-community','sz_google_module_plus_shortcodes_community'),
			'plus_shortcode_fl_enable'          => array('sz-gplus-followers','sz_google_module_plus_shortcodes_followers'),
			'plus_button_enable_plusone'        => array('sz-gplus-one'      ,'sz_google_module_plus_shortcodes_plusone'),
			'plus_button_enable_sharing'        => array('sz-gplus-share'    ,'sz_google_module_plus_shortcodes_share'),
			'plus_button_enable_follow'         => array('sz-gplus-follow'   ,'sz_google_module_plus_shortcodes_follow'),
			'plus_comments_sh_enable'           => array('sz-gplus-comments' ,'sz_google_module_plus_shortcodes_comments'),
			'plus_post_enable_shortcode'        => array('sz-gplus-post'     ,'sz_google_module_plus_shortcodes_post'),
		);

		$this->moduleWidgets = array(
			'plus_widget_pr_enable'             => 'sz_google_module_plus_widget_profile',
			'plus_widget_pa_enable'             => 'sz_google_module_plus_widget_page',
			'plus_widget_co_enable'             => 'sz_google_module_plus_widget_community',
			'plus_widget_fl_enable'             => 'sz_google_module_plus_widget_followers',
			'plus_button_enable_widget_plusone' => 'sz_google_module_plus_widget_plusone',
			'plus_button_enable_widget_sharing' => 'sz_google_module_plus_widget_share',
			'plus_button_enable_widget_follow'  => 'sz_google_module_plus_widget_follow',
			'plus_comments_wd_enable'           => 'sz_google_module_plus_widget_comments',
			'plus_post_enable_widget'           => 'sz_google_module_plus_widget_post',
		);
	}

	/**
	 * Calcolo le opzioni legate al modulo con esecuzione dei 
	 * controlli formali di coerenza e impostazione dei default
	 *
	 * @return array
	 */
	function getOptions()
	{
		$options = get_option('sz_google_options_plus');

		// Controllo delle opzioni in caso di valori non esistenti
		// richiamo della funzione per il controllo isset()

		$options = $this->checkOptionIsSet($options,array(
			'plus_profile'                      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'plus_page'                         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'plus_community'                    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'plus_language'                     => SZ_PLUGIN_GOOGLE_VALUE_LANG,
			'plus_widget_pr_enable'             => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_widget_pa_enable'             => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_widget_co_enable'             => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_widget_fl_enable'             => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_widget_size_portrait'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'plus_widget_size_landscape'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'plus_shortcode_pr_enable'          => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_shortcode_pa_enable'          => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_shortcode_co_enable'          => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_shortcode_fl_enable'          => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_shortcode_size_portrait'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'plus_shortcode_size_landscape'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'plus_button_enable_plusone'        => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_button_enable_sharing'        => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_button_enable_follow'         => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_button_enable_widget_plusone' => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_button_enable_widget_sharing' => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_button_enable_widget_follow'  => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_comments_sh_enable'           => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_comments_gp_enable'           => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_comments_gp_enable'           => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_comments_wp_enable'           => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_comments_ac_enable'           => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_comments_aw_enable'           => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_comments_dt_enable'           => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_comments_dt_day'              => SZ_PLUGIN_GOOGLE_VALUE_OLD_DAY,
			'plus_comments_dt_month'            => SZ_PLUGIN_GOOGLE_VALUE_OLD_MONTH,
			'plus_comments_dt_year'             => SZ_PLUGIN_GOOGLE_VALUE_OLD_YEAR,
			'plus_comments_fixed_size'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'plus_comments_title'               => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'plus_comments_css_class_1'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'plus_comments_css_class_2'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'plus_redirect_sign'                => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_redirect_plus'                => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_redirect_curl'                => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_redirect_curl_dir'            => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'plus_redirect_curl_url'            => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'plus_redirect_flush'               => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_system_javascript'            => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_post_enable_widget'           => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_post_enable_shortcode'        => SZ_PLUGIN_GOOGLE_VALUE_NO,
		));

		// Controllo delle opzioni in caso di valori non conformi
		// richiamo della funzione per il controllo isnull()

		$options = $this->checkOptionIsNull($options,array(
			'plus_language'                    => SZ_PLUGIN_GOOGLE_VALUE_LANG,
			'plus_widget_size_portrait'        => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_SIZE_PORTRAIT,
			'plus_widget_size_landscape'       => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_SIZE_LANDSCAPE,
			'plus_shortcode_size_portrait'     => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_SIZE_PORTRAIT,
			'plus_shortcode_size_landscape'    => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_SIZE_LANDSCAPE,
		));

		// Controllo delle opzioni in caso di valori non conformi
		// richiamo della funzione per il controllo iszero()

		$options = $this->checkOptionIsZero($options,array(
			'plus_comments_fixed_size'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		));

		// Chiamata alla funzione comune per controllare le variabili che devono avere
		// un valore di YES o NO e nel caso non fosse possibile forzare il valore (NO)

		$options = $this->checkOptionIsYesNo($options,array(
			'plus_widget_pr_enable'             => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_widget_pa_enable'             => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_widget_co_enable'             => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_widget_fl_enable'             => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_shortcode_pr_enable'          => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_shortcode_pa_enable'          => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_shortcode_co_enable'          => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_shortcode_fl_enable'          => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_button_enable_plusone'        => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_button_enable_sharing'        => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_button_enable_follow'         => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_button_enable_widget_plusone' => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_button_enable_widget_sharing' => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_button_enable_widget_follow'  => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_comments_sh_enable'           => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_comments_gp_enable'           => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_comments_gp_enable'           => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_comments_wp_enable'           => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_comments_ac_enable'           => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_comments_aw_enable'           => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_comments_dt_enable'           => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_redirect_sign'                => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_redirect_plus'                => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_redirect_curl'                => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_redirect_flush'               => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_system_javascript'            => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'plus_post_enable_widget'           => SZ_PLUGIN_GOOGLE_VALUE_NO,
		));

		// Ritorno indietro il gruppo di opzioni corretto dai
		// controlli formali della funzione di reperimento opzioni

		return $options;
	}

	/**
	 * Aggiungo le azioni del modulo corrente, questa funzione deve
	 * essere implementate per ogni modulo in maniera personalizzata
	 * non è possibile creare una funzione di standardizzazione
	 *
	 * @return void
	 */
	function moduleAddActions()
	{
		$options = $this->getOptions();

		// Controllo se devo attivare il sistema dei commenti per google plus
		// e aggiungo la funzione specifica al contesto (init)

		if ($options['plus_comments_gp_enable'] == SZ_PLUGIN_GOOGLE_VALUE_YES) 
		{
			if (SZ_PLUGIN_GOOGLE_DEBUG) {
				SZGoogleDebug::log('execute exec-mods point register comment system');
			}
			add_action('init','sz_google_module_plus_comments_system_enable');
		}

		// Controllo se devo eseguire delle funzioni di redirect
		// e aggiungo la funzione specifica al contesto (init)

		if ($options['plus_redirect_sign']  == SZ_PLUGIN_GOOGLE_VALUE_YES or
			$options['plus_redirect_plus']  == SZ_PLUGIN_GOOGLE_VALUE_YES or
			$options['plus_redirect_curl']  == SZ_PLUGIN_GOOGLE_VALUE_YES or 
			$options['plus_redirect_flush'] == SZ_PLUGIN_GOOGLE_VALUE_NO) 
		{
			if (SZ_PLUGIN_GOOGLE_DEBUG) {
				SZGoogleDebug::log('execute exec-mods point register rewrite rules');
			}
			add_action('init','sz_google_module_plus_rewrite_rules');
		}
	}
}


global $SZ_PLUS_OBJECT;

$SZ_PLUS_OBJECT = new SZGoogleModulePlus();
$SZ_PLUS_OBJECT->moduleAddActions();
$SZ_PLUS_OBJECT->moduleAddWidgets();
$SZ_PLUS_OBJECT->moduleAddShortcodes();

/* ************************************************************************** */
/* PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PR */
/* PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PR */
/* PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PR */
/* PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PR */
/* PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PROFILE PR */
/* ************************************************************************** */

function sz_google_module_plus_get_code_profile($atts,$content=null) 
{
	// Estrazione dei valori specificati nello shortcode, i valori ritornati
	// sono contenuti nei nomi di variabili corrispondenti alla chiave

	if (!is_array($atts)) $atts = array();

	extract(shortcode_atts(array(
		'id'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
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

	global $SZ_PLUS_OBJECT;
	$options = $SZ_PLUS_OBJECT->getOptions();

	// Imposto i valori di default nel caso siano specificati dei valori
	// che non appartengono al range dei valori accettati

	if ($id == SZ_PLUGIN_GOOGLE_VALUE_NULL) { $id = trim($options['plus_profile']); }
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

	add_action('wp_footer','sz_google_module_plus_add_script_footer');

	// Ritorno per la funzione con tutta la stringa contenente
	// il codice HTML per l'inserimento del codice nella pagina

	return $HTML;
}

/* ************************************************************************** */
/* GOOGLE+ PROFILE funzione per elaborazione shortcode (sz-gplus-profile)     */
/* ************************************************************************** */

function sz_google_module_plus_shortcodes_profile($atts,$content=null) 
{
	// Preparazione codice HTML dello shortcode tramite la funzione
	// standard di preparazione codice sia per shortcode che widgets

	return sz_google_module_plus_get_code_profile(shortcode_atts(array(
		'id'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
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
		'action'  => SZ_PLUGIN_GOOGLE_VALUE_TEXT_SHORTCODE,
	),$atts),$content);
}

/* ************************************************************************** */ 
/* GOOGLE+ PROFILE definizione ed elaborazione del widget su sidebar          */ 
/* ************************************************************************** */ 

class sz_google_module_plus_widget_profile extends SZGoogleWidget
{
	// Costruttore principale della classe widget, definizione 
	// delle opzioni legate al widget e al controllo dello stesso

	function __construct() 
	{
		parent::__construct('SZ-Google-Profile',__('SZ-Google - G+ Profile','szgoogleadmin'),array(
			'classname'   => 'sz-widget-google sz-widget-google-plus sz-widget-google-plus-profile', 
			'description' => ucfirst(__('widget for google+ profile','szgoogleadmin'))
		));
	}

	// Funzione per la visualizzazione del widget con lettura parametri
	// di configurazione e preparazione codice HTML da usare nella sidebar

	function widget($args,$instance) 
	{
		// Controllo se esistono le variabili che servono durante l'elaborazione
		// dello script e assegno dei valori di default nel caso non fossero specificati

		$options = $this->common_empty(array(
			'id'      => SZ_PLUGIN_GOOGLE_PLUS_ID_PROFILE,
			'type'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'width'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'align'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'layout'  => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_LAYOUT,
			'theme'   => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_THEME,
			'cover'   => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_COVER,
			'tagline' => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_TAGLINE,
			'author'  => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_AUTHOR,
			'text'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'image'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'action'  => SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET,
		),$instance);

		// Definizione delle variabili di controllo del widget, questi valori non
		// interessano le opzioni della funzione base ma incidono su alcuni aspetti

		$controls = $this->common_empty(array(
			'method'     => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'specific'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'width_auto' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		),$instance);

		// Correzione del valore di dimensione nel caso venga
		// specificata la maniera automatica e quindi usare javascript

		if ($controls['method']     != SZ_PLUGIN_GOOGLE_VALUE_YES) $options['id']    = $controls['specific']; 
		if ($controls['method']     == SZ_PLUGIN_GOOGLE_VALUE_YES) $options['id']    = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if ($controls['width_auto'] == SZ_PLUGIN_GOOGLE_VALUE_YES) $options['width'] = SZ_PLUGIN_GOOGLE_VALUE_AUTO;

		// Creazione del codice HTML per il widget attuale richiamando la
		// funzione base che viene richiamata anche dallo shortcode corrispondente

		$HTML = sz_google_module_plus_get_code_profile($options);

		// Output del codice HTML legato al widget da visualizzare
		// chiamata alla funzione generale per wrap standard

		echo $this->common_widget($args,$instance,$HTML);
	}

	// Funzione per modifica parametri collegati al widget con 
	// memorizzazione dei valori direttamente nel database wordpress

	function update($new_instance,$old_instance) 
	{
		return $this->common_update(array(
			'title'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'method'     => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'specific'   => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'width'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'width_auto' => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'align'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'layout'     => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'theme'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'cover'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'tagline'    => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'author'     => SZ_PLUGIN_GOOGLE_VALUE_YES,
		),$new_instance,$old_instance);
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
			'cover'      => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_COVER,
			'tagline'    => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_TAGLINE,
			'author'     => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_AUTHOR,
		);

		// Creazione array per elenco campi da recuperare su FORM

		$instance = wp_parse_args((array)$instance,$array);

		$title      = trim(strip_tags($instance['title']));
		$method     = trim(strip_tags($instance['method']));
		$specific   = trim(strip_tags($instance['specific']));
		$width      = trim(strip_tags($instance['width']));
		$width_auto = trim(strip_tags($instance['width_auto']));
		$align      = trim(strip_tags($instance['align']));
		$layout     = trim(strip_tags($instance['layout']));
		$theme      = trim(strip_tags($instance['theme']));
		$cover      = trim(strip_tags($instance['cover']));
		$tagline    = trim(strip_tags($instance['tagline']));
		$author     = trim(strip_tags($instance['author']));

		// Richiamo il template per la visualizzazione della
		// parte che riguarda il pannello di amministrazione

		@require(SZ_PLUGIN_GOOGLE_BASENAME_ADMIN_WIDGETS.
			'sz-google-widget-plus-profile.php');
	}
}

/* ************************************************************************** */
/* PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE */
/* PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE */
/* PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE */
/* PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE */
/* PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE PAGE */
/* ************************************************************************** */

function sz_google_module_plus_get_code_page($atts,$content=null) 
{
	// Estrazione dei valori specificati nello shortcode, i valori ritornati
	// sono contenuti nei nomi di variabili corrispondenti alla chiave

	if (!is_array($atts)) $atts = array();

	extract(shortcode_atts(array(
		'id'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
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

	global $SZ_PLUS_OBJECT;
	$options = $SZ_PLUS_OBJECT->getOptions();

	// Imposto i valori di default nel caso siano specificati dei valori
	// che non appartengono al range dei valori accettati

	if ($id == SZ_PLUGIN_GOOGLE_VALUE_NULL) { $id = trim($options['plus_page']); }
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

	add_action('wp_footer','sz_google_module_plus_add_script_footer');

	// Ritorno per la funzione con tutta la stringa contenente
	// il codice HTML per l'inserimento del codice nella pagina

	return $HTML;
}

/* ************************************************************************** */
/* GOOGLE+ PAGE funzione per elaborazione shortcode (sz-gplus-page)           */
/* ************************************************************************** */

function sz_google_module_plus_shortcodes_page($atts,$content=null) 
{
	// Preparazione codice HTML dello shortcode tramite la funzione
	// standard di preparazione codice sia per shortcode che widgets

	return sz_google_module_plus_get_code_page(shortcode_atts(array(
		'id'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
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
		'action'    => SZ_PLUGIN_GOOGLE_VALUE_TEXT_SHORTCODE,
	),$atts),$content);
}

/* ************************************************************************** */ 
/* GOOGLE+ PAGE definizione ed elaborazione del widget su sidebar             */ 
/* ************************************************************************** */ 

class sz_google_module_plus_widget_page extends SZGoogleWidget 
{
	// Costruttore principale della classe widget, definizione 
	// delle opzioni legate al widget e al controllo dello stesso

	function __construct() 
	{
		parent::__construct('SZ-Google-Page',__('SZ-Google - G+ Page','szgoogleadmin'),array(
			'classname'   => 'sz-widget-google sz-widget-google-plus sz-widget-google-plus-page', 
			'description' => ucfirst(__('widget for google+ page','szgoogleadmin'))
		));
	}

	// Funzione per la visualizzazione del widget con lettura parametri
	// di configurazione e preparazione codice HTML da usare nella sidebar

	function widget($args,$instance) 
	{
		// Controllo se esistono le variabili che servono durante l'elaborazione
		// dello script e assegno dei valori di default nel caso non fossero specificati

		$options = $this->common_empty(array(
			'id'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'width'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'align'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'layout'    => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_LAYOUT,
			'theme'     => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_THEME,
			'cover'     => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_COVER,
			'tagline'   => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_TAGLINE,
			'publisher' => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_PUBLISHER,
			'action'    => SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET,
		),$instance);

		// Definizione delle variabili di controllo del widget, questi valori non
		// interessano le opzioni della funzione base ma incidono su alcuni aspetti

		$controls = $this->common_empty(array(
			'method'     => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'specific'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'width_auto' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		),$instance);

		// Correzione del valore di dimensione nel caso venga
		// specificata la maniera automatica e quindi usare javascript

		if ($controls['method']     != SZ_PLUGIN_GOOGLE_VALUE_YES) $options['id']    = $controls['specific']; 
		if ($controls['method']     == SZ_PLUGIN_GOOGLE_VALUE_YES) $options['id']    = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if ($controls['width_auto'] == SZ_PLUGIN_GOOGLE_VALUE_YES) $options['width'] = SZ_PLUGIN_GOOGLE_VALUE_AUTO;

		// Creazione del codice HTML per il widget attuale richiamando la
		// funzione base che viene richiamata anche dallo shortcode corrispondente

		$HTML = sz_google_module_plus_get_code_page($options);

		// Output del codice HTML legato al widget da visualizzare
		// chiamata alla funzione generale per wrap standard

		echo $this->common_widget($args,$instance,$HTML);
	}

	// Funzione per modifica parametri collegati al widget con 
	// memorizzazione dei valori direttamente nel database wordpress

	function update($new_instance,$old_instance) 
	{
		return $this->common_update(array(
			'title'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'method'     => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'specific'   => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'width'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'width_auto' => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'align'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'layout'     => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'theme'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'cover'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'tagline'    => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'publisher'  => SZ_PLUGIN_GOOGLE_VALUE_YES,
		),$new_instance,$old_instance);
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
			'cover'      => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_COVER,
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
		$cover      = trim(strip_tags($instance['cover']));
		$tagline    = trim(strip_tags($instance['tagline']));
		$publisher  = trim(strip_tags($instance['publisher']));

		// Richiamo il template per la visualizzazione della
		// parte che riguarda il pannello di amministrazione

		@require(SZ_PLUGIN_GOOGLE_BASENAME_ADMIN_WIDGETS.
			'sz-google-widget-plus-page.php');
	}
}

/* ************************************************************************** */
/* COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMM */
/* COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMM */
/* COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMM */
/* COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMM */
/* COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMMUNITY COMM */
/* ************************************************************************** */

function sz_google_module_plus_get_code_community($atts,$content=null) 
{
	// Estrazione dei valori specificati nello shortcode, i valori ritornati
	// sono contenuti nei nomi di variabili corrispondenti alla chiave

	if (!is_array($atts)) $atts = array();

	extract(shortcode_atts(array(
		'id'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
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

	global $SZ_PLUS_OBJECT;
	$options = $SZ_PLUS_OBJECT->getOptions();

	// Imposto i valori di default nel caso siano specificati dei valori
	// che non appartengono al range dei valori accettati

	if ($id == SZ_PLUGIN_GOOGLE_VALUE_NULL) { $id = trim($options['plus_community']); }
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

	add_action('wp_footer','sz_google_module_plus_add_script_footer');

	// Ritorno per la funzione con tutta la stringa contenente
	// il codice HTML per l'inserimento del codice nella pagina

	return $HTML;
}

/* ************************************************************************** */
/* GOOGLE+ COMMUNITY funzione per elaborazione shortcode (sz-gplus-community) */
/* ************************************************************************** */

function sz_google_module_plus_shortcodes_community($atts,$content=null) 
{
	// Preparazione codice HTML dello shortcode tramite la funzione
	// standard di preparazione codice sia per shortcode che widgets

	return sz_google_module_plus_get_code_community(shortcode_atts(array(
		'id'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'width'  => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_WIDTH,
		'align'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'layout' => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_LAYOUT,
		'theme'  => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_THEME,
		'photo'  => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_PHOTO,
		'owner'  => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_OWNER,
		'action' => SZ_PLUGIN_GOOGLE_VALUE_TEXT_SHORTCODE,
	),$atts),$content);
}

/* ************************************************************************** */ 
/* GOOGLE+ COMMUNITY definizione ed elaborazione del widget su sidebar        */ 
/* ************************************************************************** */ 

class sz_google_module_plus_widget_community extends SZGoogleWidget 
{
	// Costruttore principale della classe widget, definizione 
	// delle opzioni legate al widget e al controllo dello stesso

	function __construct() 
	{
		parent::__construct('SZ-Google-Community',__('SZ-Google - G+ Community','szgoogleadmin'),array(
			'classname'   => 'sz-widget-google sz-widget-google-plus sz-widget-google-plus-community', 
			'description' => ucfirst(__('widget for google+ community','szgoogleadmin'))
		));
	}

	// Funzione per la visualizzazione del widget con lettura parametri
	// di configurazione e preparazione codice HTML da usare nella sidebar

	function widget($args,$instance) 
	{
		// Controllo se esistono le variabili che servono durante l'elaborazione
		// dello script e assegno dei valori di default nel caso non fossero specificati

		$options = $this->common_empty(array(
			'id'         => SZ_PLUGIN_GOOGLE_PLUS_ID_COMMUNITY,
			'width'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'align'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'layout'     => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_LAYOUT,
			'theme'      => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_THEME,
			'photo'      => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_PHOTO,
			'owner'      => SZ_PLUGIN_GOOGLE_PLUS_WIDGET_OWNER,
			'action'     => SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET,
		),$instance);

		// Definizione delle variabili di controllo del widget, questi valori non
		// interessano le opzioni della funzione base ma incidono su alcuni aspetti

		$controls = $this->common_empty(array(
			'method'     => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'specific'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'width_auto' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		),$instance);

		// Correzione del valore di dimensione nel caso venga
		// specificata la maniera automatica e quindi usare javascript

		if ($controls['method']     != SZ_PLUGIN_GOOGLE_VALUE_YES) $options['id']    = $controls['specific']; 
		if ($controls['method']     == SZ_PLUGIN_GOOGLE_VALUE_YES) $options['id']    = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if ($controls['width_auto'] == SZ_PLUGIN_GOOGLE_VALUE_YES) $options['width'] = SZ_PLUGIN_GOOGLE_VALUE_AUTO;

		// Creazione del codice HTML per il widget attuale richiamando la
		// funzione base che viene richiamata anche dallo shortcode corrispondente

		$HTML = sz_google_module_plus_get_code_community($options);

		// Output del codice HTML legato al widget da visualizzare
		// chiamata alla funzione generale per wrap standard

		echo $this->common_widget($args,$instance,$HTML);
	}

	// Funzione per modifica parametri collegati al widget con 
	// memorizzazione dei valori direttamente nel database wordpress

	function update($new_instance,$old_instance) 
	{
		return $this->common_update(array(
			'title'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'method'     => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'specific'   => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'width'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'width_auto' => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'align'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'layout'     => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'theme'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'photo'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'owner'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
		),$new_instance,$old_instance);
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

		// Richiamo il template per la visualizzazione della
		// parte che riguarda il pannello di amministrazione

		@require(SZ_PLUGIN_GOOGLE_BASENAME_ADMIN_WIDGETS.
			'sz-google-widget-plus-community.php');
	}
}

/* ************************************************************************** */
/* FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLL */
/* FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLL */
/* FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLL */
/* FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLL */
/* FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLLOWERS FOLL */
/* ************************************************************************** */

function sz_google_module_plus_get_code_followers($atts,$content=null) 
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

	global $SZ_PLUS_OBJECT;
	$options = $SZ_PLUS_OBJECT->getOptions();

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

	add_action('wp_footer','sz_google_module_plus_add_script_footer');

	// Ritorno per la funzione con tutta la stringa contenente
	// il codice HTML per l'inserimento del codice nella pagina

	return $HTML;
}

/* ************************************************************************** */
/* GOOGLE+ FOLLOWERS funzione per elaborazione shortcode (sz-gplus-followers) */
/* ************************************************************************** */

function sz_google_module_plus_shortcodes_followers($atts,$content=null) 
{
	// Preparazione codice HTML dello shortcode tramite la funzione
	// standard di preparazione codice sia per shortcode che widgets

	return sz_google_module_plus_get_code_followers(shortcode_atts(array(
		'id'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'width'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'height' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'align'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'action' => SZ_PLUGIN_GOOGLE_VALUE_TEXT_SHORTCODE,
	),$atts),$content);
}

/* ************************************************************************** */ 
/* GOOGLE+ FOLLOWERS definizione ed elaborazione del widget su sidebar        */ 
/* ************************************************************************** */ 

class sz_google_module_plus_widget_followers extends SZGoogleWidget 
{
	// Costruttore principale della classe widget, definizione 
	// delle opzioni legate al widget e al controllo dello stesso

	function __construct() 
	{
		parent::__construct('SZ-Google-Followers',__('SZ-Google - G+ Followers','szgoogleadmin'),array(
			'classname'   => 'sz-widget-google sz-widget-google-plus sz-widget-google-plus-followers', 
			'description' => ucfirst(__('widget for google+ followers','szgoogleadmin'))
		));
	}

	// Funzione per la visualizzazione del widget con lettura parametri
	// di configurazione e preparazione codice HTML da usare nella sidebar

	function widget($args,$instance) 
	{
		// Controllo se esistono le variabili che servono durante l'elaborazione
		// dello script e assegno dei valori di default nel caso non fossero specificati

		$options = $this->common_empty(array(
			'id'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'width'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'height'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'align'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'action'      => SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET,
		),$instance);

		// Definizione delle variabili di controllo del widget, questi valori non
		// interessano le opzioni della funzione base ma incidono su alcuni aspetti

		$controls = $this->common_empty(array(
			'method'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'specific'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'width_auto'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'height_auto' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		),$instance);

		// Correzione del valore di dimensione nel caso venga
		// specificata la maniera automatica e quindi usare javascript

		if ($controls['method']      != SZ_PLUGIN_GOOGLE_VALUE_YES) $options['id']     = $controls['specific']; 
		if ($controls['method']      == SZ_PLUGIN_GOOGLE_VALUE_YES) $options['id']     = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if ($controls['width_auto']  == SZ_PLUGIN_GOOGLE_VALUE_YES) $options['width']  = SZ_PLUGIN_GOOGLE_VALUE_AUTO;
		if ($controls['height_auto'] == SZ_PLUGIN_GOOGLE_VALUE_YES) $options['height'] = SZ_PLUGIN_GOOGLE_VALUE_AUTO;

		// Creazione del codice HTML per il widget attuale richiamando la
		// funzione base che viene richiamata anche dallo shortcode corrispondente

		$HTML = sz_google_module_plus_get_code_followers($options);

		// Output del codice HTML legato al widget da visualizzare
		// chiamata alla funzione generale per wrap standard

		echo $this->common_widget($args,$instance,$HTML);
	}

	// Funzione per modifica parametri collegati al widget con 
	// memorizzazione dei valori direttamente nel database wordpress

	function update($new_instance,$old_instance) 
	{
		return $this->common_update(array(
			'title'       => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'method'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'specific'    => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'width'       => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'width_auto'  => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'height'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'height_auto' => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'align'       => SZ_PLUGIN_GOOGLE_VALUE_YES,
		),$new_instance,$old_instance);
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

		// Richiamo il template per la visualizzazione della
		// parte che riguarda il pannello di amministrazione

		@require(SZ_PLUGIN_GOOGLE_BASENAME_ADMIN_WIDGETS.
			'sz-google-widget-plus-followers.php');
	}
}

/* ************************************************************************** */
/* PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PL */
/* PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PL */
/* PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PL */
/* PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PL */
/* PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PLUS ONE PL */
/* ************************************************************************** */

function sz_google_module_plus_get_code_plusone($atts=array(),$content=null)
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

	$HTML = SZGoogleCommon::getCodeButtonWrap(array(
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

	add_action('wp_footer','sz_google_module_plus_add_script_footer');

	// Ritorno per la funzione con tutta la stringa contenente
	// il codice HTML per l'inserimento del codice nella pagina

	return $HTML;
}

/* ************************************************************************** */
/* GOOGLE+ PLUS ONE funzione per elaborazione shortcode (sz-gplus-plusone)    */
/* ************************************************************************** */

function sz_google_module_plus_shortcodes_plusone($atts,$content=null) 
{
	// Preparazione codice HTML dello shortcode tramite la funzione
	// standard di preparazione codice sia per shortcode che widgets

	return sz_google_module_plus_get_code_plusone(shortcode_atts(array(
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
		'action'       => SZ_PLUGIN_GOOGLE_VALUE_TEXT_SHORTCODE,
	),$atts),$content);
}

/* ************************************************************************** */ 
/* GOOGLE+ PLUS ONE definizione ed elaborazione del widget su sidebar         */ 
/* ************************************************************************** */ 

class sz_google_module_plus_widget_plusone extends SZGoogleWidget
{
	// Costruttore principale della classe widget, definizione 
	// delle opzioni legate al widget e al controllo dello stesso

	function __construct() 
	{
		parent::__construct('SZ-GOOGLE-PLUS-ONE',__('SZ-Google - G+ Plus one','szgoogleadmin'),array(
			'classname'   => 'sz-widget-google sz-widget-google-plus sz-widget-google-plus-one', 
			'description' => ucfirst(__('widget for google+ button +1','szgoogleadmin'))
		));
	}

	// Funzione per la visualizzazione del widget con lettura parametri
	// di configurazione e preparazione codice HTML da usare nella sidebar

	function widget($args,$instance) 
	{
		// Controllo se esistono le variabili che servono durante l'elaborazione
		// dello script e assegno dei valori di default nel caso non fossero specificati

		$options = $this->common_empty(array(
			'url'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'width'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'size'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'annotation'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'align'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'text'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'img'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'position'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'margintop'    => SZ_PLUGIN_GOOGLE_VALUE_NONE,
			'marginright'  => SZ_PLUGIN_GOOGLE_VALUE_NONE,
			'marginbottom' => SZ_PLUGIN_GOOGLE_VALUE_NONE,
			'marginleft'   => SZ_PLUGIN_GOOGLE_VALUE_NONE,
			'marginunit'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'action'       => SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET,
		),$instance);

		// Definizione delle variabili di controllo del widget, questi valori non
		// interessano le opzioni della funzione base ma incidono su alcuni aspetti

		$controls = $this->common_empty(array(
			'badge'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'urltype'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		),$instance);

		// Se sul widget ho escluso il badge dal pulsante azzero anche
		// le variabili del badge eventualmente impostate e memorizzate 

		if ($controls['badge']  != SZ_PLUGIN_GOOGLE_VALUE_YES) 
		{
			$options['img']      = SZ_PLUGIN_GOOGLE_VALUE_NULL;
			$options['text']     = SZ_PLUGIN_GOOGLE_VALUE_NULL;
			$options['position'] = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		}

		// Se sul widget ho selezionato di calcolare l'indirizzo dal 
		// post corrente annullo la variabile con eventuale indirizzo 

		if ($controls['urltype'] != SZ_PLUGIN_GOOGLE_VALUE_YES) {
			$options['url'] = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		}

		// Creazione del codice HTML per il widget attuale richiamando la
		// funzione base che viene richiamata anche dallo shortcode corrispondente

		$HTML = sz_google_module_plus_get_code_plusone($options);

		// Output del codice HTML legato al widget da visualizzare
		// chiamata alla funzione generale per wrap standard

		echo $this->common_widget($args,$instance,$HTML);
	}

	// Funzione per modifica parametri collegati al widget con 
	// memorizzazione dei valori direttamente nel database wordpress

	function update($new_instance,$old_instance) 
	{
		return $this->common_update(array(
			'title'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'badge'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'url'        => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'urltype'    => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'text'       => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'img'        => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'align'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'position'   => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'size'       => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'annotation' => SZ_PLUGIN_GOOGLE_VALUE_YES,
		),$new_instance,$old_instance);
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

		// Richiamo il template per la visualizzazione della
		// parte che riguarda il pannello di amministrazione

		@require(SZ_PLUGIN_GOOGLE_BASENAME_ADMIN_WIDGETS.
			'sz-google-widget-plus-plusone.php');
	}
}

/* ************************************************************************** */
/* SHARE SHARE SHARE SHARE SHARE SHARE SHARE SHARE SHARE SHARE SHARE SHARE SH */
/* SHARE SHARE SHARE SHARE SHARE SHARE SHARE SHARE SHARE SHARE SHARE SHARE SH */
/* SHARE SHARE SHARE SHARE SHARE SHARE SHARE SHARE SHARE SHARE SHARE SHARE SH */
/* SHARE SHARE SHARE SHARE SHARE SHARE SHARE SHARE SHARE SHARE SHARE SHARE SH */
/* SHARE SHARE SHARE SHARE SHARE SHARE SHARE SHARE SHARE SHARE SHARE SHARE SH */
/* ************************************************************************** */

function sz_google_module_plus_get_code_share($atts=array(),$content=null)
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

	$HTML = SZGoogleCommon::getCodeButtonWrap(array(
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
		'class'        => 'sz-google-share',
	));

	// Aggiunta del codice javascript per il rendering dei widget, questo codice		 
	// viene aggiungo anche dalla sidebar però viene inserito una sola volta

	add_action('wp_footer','sz_google_module_plus_add_script_footer');

	// Ritorno per la funzione con tutta la stringa contenente
	// il codice HTML per l'inserimento del codice nella pagina

	return $HTML;
}

/* ************************************************************************** */
/* GOOGLE+ SHARE funzione per elaborazione shortcode (sz-gplus-share)         */
/* ************************************************************************** */

function sz_google_module_plus_shortcodes_share($atts,$content=null) 
{
	// Preparazione codice HTML dello shortcode tramite la funzione
	// standard di preparazione codice sia per shortcode che widgets

	return sz_google_module_plus_get_code_share(shortcode_atts(array(
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
		'action'       => SZ_PLUGIN_GOOGLE_VALUE_TEXT_SHORTCODE,
	),$atts),$content);
}

/* ************************************************************************** */ 
/* GOOGLE+ SHARE definizione ed elaborazione del widget su sidebar            */ 
/* ************************************************************************** */ 

class sz_google_module_plus_widget_share extends SZGoogleWidget
{
	// Costruttore principale della classe widget, definizione 
	// delle opzioni legate al widget e al controllo dello stesso

	function __construct() 
	{
		parent::__construct('SZ-GOOGLE-PLUS-SHARING',__('SZ-Google - G+ Share','szgoogleadmin'),array(
			'classname'   => 'sz-widget-google sz-widget-google-plus sz-widget-google-plus-share', 
			'description' => ucfirst(__('widget for google+ share','szgoogleadmin'))
		));
	}

	// Funzione per la visualizzazione del widget con lettura parametri
	// di configurazione e preparazione codice HTML da usare nella sidebar

	function widget($args,$instance) 
	{
		// Controllo se esistono le variabili che servono durante l'elaborazione
		// dello script e assegno dei valori di default nel caso non fossero specificati

		$options = $this->common_empty(array(
			'url'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'size'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'width'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'annotation'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'align'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'text'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'img'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'position'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'margintop'    => SZ_PLUGIN_GOOGLE_VALUE_NONE,
			'marginright'  => SZ_PLUGIN_GOOGLE_VALUE_NONE,
			'marginbottom' => SZ_PLUGIN_GOOGLE_VALUE_NONE,
			'marginleft'   => SZ_PLUGIN_GOOGLE_VALUE_NONE,
			'marginunit'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'action'       => SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET,
		),$instance);

		// Definizione delle variabili di controllo del widget, questi valori non
		// interessano le opzioni della funzione base ma incidono su alcuni aspetti

		$controls = $this->common_empty(array(
			'badge'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'urltype'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		),$instance);

		// Se sul widget ho escluso il badge dal pulsante azzero anche
		// le variabili del badge eventualmente impostate e memorizzate 

		if ($controls['badge'] != SZ_PLUGIN_GOOGLE_VALUE_YES) 
		{
			$options['img']      = SZ_PLUGIN_GOOGLE_VALUE_NULL;
			$options['text']     = SZ_PLUGIN_GOOGLE_VALUE_NULL;
			$options['position'] = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		}

		// Se sul widget ho selezionato di calcolare l'indirizzo dal 
		// post corrente annullo la variabile con eventuale indirizzo 

		if ($controls['urltype'] != SZ_PLUGIN_GOOGLE_VALUE_YES) {
			$options['url'] = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		}

		// Creazione del codice HTML per il widget attuale richiamando la
		// funzione base che viene richiamata anche dallo shortcode corrispondente

		$HTML = sz_google_module_plus_get_code_share($options);

		// Output del codice HTML legato al widget da visualizzare
		// chiamata alla funzione generale per wrap standard

		echo $this->common_widget($args,$instance,$HTML);
	}

	// Funzione per modifica parametri collegati al widget con 
	// memorizzazione dei valori direttamente nel database wordpress

	function update($new_instance,$old_instance) 
	{
		return $this->common_update(array(
			'title'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'badge'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'url'        => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'urltype'    => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'text'       => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'img'        => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'align'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'position'   => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'size'       => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'annotation' => SZ_PLUGIN_GOOGLE_VALUE_YES,
		),$new_instance,$old_instance);
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

		// Richiamo il template per la visualizzazione della
		// parte che riguarda il pannello di amministrazione

		@require(SZ_PLUGIN_GOOGLE_BASENAME_ADMIN_WIDGETS.
			'sz-google-widget-plus-share.php');
	}
}

/* ************************************************************************** */
/* FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLL */
/* FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLL */
/* FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLL */
/* FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLL */
/* FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLLOW FOLL */
/* ************************************************************************** */

function sz_google_module_plus_get_code_follow($atts=array(),$content=null)
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

	global $SZ_PLUS_OBJECT;
	$options = $SZ_PLUS_OBJECT->getOptions();

	// Imposto i valori di default nel caso siano specificati dei valori
	// che non appartengono al range dei valori accettati

	if ($url == SZ_PLUGIN_GOOGLE_VALUE_NULL) { $url = 'https://plus.google.com/'.$options['plus_page']; }
	if ($url == SZ_PLUGIN_GOOGLE_VALUE_NULL) { $url = 'https://plus.google.com/'.$options['plus_profile']; }

	if ($url == SZ_PLUGIN_GOOGLE_VALUE_NULL) { $url = 'https://plus.google.com/'.SZ_PLUGIN_GOOGLE_PLUS_ID_PAGE;    $rel = SZ_PLUGIN_GOOGLE_VALUE_NULL; }
	if ($url == SZ_PLUGIN_GOOGLE_VALUE_NULL) { $url = 'https://plus.google.com/'.SZ_PLUGIN_GOOGLE_PLUS_ID_PROFILE; $rel = SZ_PLUGIN_GOOGLE_VALUE_NULL; }

	// Elimino dal path i riferimenti aggiunti ai link di navigazione e 
	// riporto il link originale di google plus, senza /u/0/b etc etc

	$url = sz_google_module_plus_get_canonical_url($url);

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

	$HTML = SZGoogleCommon::getCodeButtonWrap(array(
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

	add_action('wp_footer','sz_google_module_plus_add_script_footer');

	// Ritorno per la funzione con tutta la stringa contenente
	// il codice HTML per l'inserimento del codice nella pagina

	return $HTML;
}

/* ************************************************************************** */
/* GOOGLE+ FOLLOW funzione per elaborazione shortcode (sz-gplus-follow)       */
/* ************************************************************************** */

function sz_google_module_plus_shortcodes_follow($atts,$content=null) 
{
	// Preparazione codice HTML dello shortcode tramite la funzione
	// standard di preparazione codice sia per shortcode che widgets

	return sz_google_module_plus_get_code_follow(shortcode_atts(array(
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
		'action'       => SZ_PLUGIN_GOOGLE_VALUE_TEXT_SHORTCODE,
	),$atts),$content);
}

/* ************************************************************************** */ 
/* GOOGLE+ FOLLOW definizione ed elaborazione del widget su sidebar           */ 
/* ************************************************************************** */ 

class sz_google_module_plus_widget_follow extends SZGoogleWidget
{
	// Costruttore principale della classe widget, definizione 
	// delle opzioni legate al widget e al controllo dello stesso

	function __construct() 
	{
		parent::__construct('SZ-GOOGLE-PLUS-FOLLOW',__('SZ-Google - G+ Follow','szgoogleadmin'),array(
			'classname'   => 'sz-widget-google sz-widget-google-plus sz-widget-google-plus-follow', 
			'description' => ucfirst(__('widget for google+ follow','szgoogleadmin'))
		));
	}

	// Funzione per la visualizzazione del widget con lettura parametri
	// di configurazione e preparazione codice HTML da usare nella sidebar

	function widget($args,$instance) 
	{
		// Controllo se esistono le variabili che servono durante l'elaborazione
		// dello script e assegno dei valori di default nel caso non fossero specificati

		$options = $this->common_empty(array(
			'url'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'size'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'width'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'annotation'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'align'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'text'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'img'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'rel'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'position'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'margintop'    => SZ_PLUGIN_GOOGLE_VALUE_NONE,
			'marginright'  => SZ_PLUGIN_GOOGLE_VALUE_NONE,
			'marginbottom' => SZ_PLUGIN_GOOGLE_VALUE_NONE,
			'marginleft'   => SZ_PLUGIN_GOOGLE_VALUE_NONE,
			'marginunit'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'action'       => SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET,
		),$instance);

		// Definizione delle variabili di controllo del widget, questi valori non
		// interessano le opzioni della funzione base ma incidono su alcuni aspetti

		$controls = $this->common_empty(array(
			'badge'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'urltype'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		),$instance);

		// Se sul widget ho escluso il badge dal pulsante azzero anche
		// le variabili del badge eventualmente impostate e memorizzate 

		if ($controls['badge'] != SZ_PLUGIN_GOOGLE_VALUE_YES) 
		{
			$options['img']      = SZ_PLUGIN_GOOGLE_VALUE_NULL;
			$options['text']     = SZ_PLUGIN_GOOGLE_VALUE_NULL;
			$options['position'] = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		}

		// Se sul widget ho selezionato di calcolare l'indirizzo dal 
		// post corrente annullo la variabile con eventuale indirizzo 

		if ($controls['urltype'] != SZ_PLUGIN_GOOGLE_VALUE_YES) {
			$options['url'] = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		}

		// Lettura opzioni generali per impostazione dei dati di default

		global $SZ_PLUS_OBJECT;
		$general = $SZ_PLUS_OBJECT->getOptions();

		// Imposto i valori di default nel caso siano specificati dei valori
		// che non appartengono al range dei valori accettati

		if ($controls['urltype'] == '0') {
			if ($options['url'] == SZ_PLUGIN_GOOGLE_VALUE_NULL) $options['url'] = 'https://plus.google.com/'.$general['plus_page'];
			if ($options['url'] == SZ_PLUGIN_GOOGLE_VALUE_NULL) $options['url'] = 'https://plus.google.com/'.SZ_PLUGIN_GOOGLE_PLUS_ID_PAGE;
		}

		if ($controls['urltype'] == '2') {
			if ($options['url'] == SZ_PLUGIN_GOOGLE_VALUE_NULL) $options['url'] = 'https://plus.google.com/'.$general['plus_profile'];
			if ($options['url'] == SZ_PLUGIN_GOOGLE_VALUE_NULL) $options['url'] = 'https://plus.google.com/'.SZ_PLUGIN_GOOGLE_PLUS_ID_PROFILE;
		}

		// Creazione del codice HTML per il widget attuale richiamando la
		// funzione base che viene richiamata anche dallo shortcode corrispondente

		$HTML = sz_google_module_plus_get_code_follow($options);

		// Output del codice HTML legato al widget da visualizzare
		// chiamata alla funzione generale per wrap standard

		echo $this->common_widget($args,$instance,$HTML);
	}

	// Funzione per modifica parametri collegati al widget con 
	// memorizzazione dei valori direttamente nel database wordpress

	function update($new_instance,$old_instance) 
	{
		return $this->common_update(array(
			'title'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'badge'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'url'        => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'urltype'    => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'text'       => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'img'        => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'align'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'position'   => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'size'       => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'annotation' => SZ_PLUGIN_GOOGLE_VALUE_YES,
		),$new_instance,$old_instance);
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

		// Richiamo il template per la visualizzazione della
		// parte che riguarda il pannello di amministrazione

		@require(SZ_PLUGIN_GOOGLE_BASENAME_ADMIN_WIDGETS.
			'sz-google-widget-plus-follow.php');
	}
}

/* ************************************************************************** */
/* COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS CO */
/* COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS CO */
/* COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS CO */
/* COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS CO */
/* COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS CO */
/* ************************************************************************** */

function sz_google_module_plus_get_code_comments($atts,$content=null) 
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

	global $SZ_PLUS_OBJECT;
	$options = $SZ_PLUS_OBJECT->getOptions();

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

	$url = sz_google_module_plus_get_canonical_url($url);

	// Controllo i valori delle classi eventuali da ggiungere ai wrapper

	if (!empty($title))  $title  = str_ireplace('{title}',ucfirst(SZGoogleCommon::getTranslate('leave a Reply')),$title);
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

	add_action('wp_footer','sz_google_module_plus_add_script_footer');

	// Ritorno per la funzione con tutta la stringa contenente
	// il codice HTML per l'inserimento del codice nella pagina

	return $HTML;
}

/* ************************************************************************** */
/* GOOGLE+ COMMENTS funzione per elaborazione shortcode (sz-gplus-comments)   */
/* ************************************************************************** */

function sz_google_module_plus_shortcodes_comments($atts,$content=null) 
{
	// Preparazione codice HTML dello shortcode tramite la funzione
	// standard di preparazione codice sia per shortcode che widgets

	return sz_google_module_plus_get_code_comments(shortcode_atts(array(
		'url'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'width'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'align'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'title'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'class1' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'class2' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'action' => SZ_PLUGIN_GOOGLE_VALUE_TEXT_SHORTCODE,
	),$atts),$content);
}

/* ************************************************************************** */ 
/* GOOGLE+ COMMENTS definizione ed elaborazione del widget su sidebar         */ 
/* ************************************************************************** */ 

class sz_google_module_plus_widget_comments extends SZGoogleWidget
{
	// Costruttore principale della classe widget, definizione 
	// delle opzioni legate al widget e al controllo dello stesso

	function __construct() 
	{
		parent::__construct('SZ-Google-Comments',__('SZ-Google - G+ Comments','szgoogleadmin'),array(
			'classname'   => 'sz-widget-google sz-widget-google-plus sz-widget-google-plus-comments', 
			'description' => ucfirst(__('widget for google+ comments','szgoogleadmin'))
		));
	}

	// Funzione per la visualizzazione del widget con lettura parametri
	// di configurazione e preparazione codice HTML da usare nella sidebar

	function widget($args,$instance) 
	{
		// Controllo se esistono le variabili che servono durante l'elaborazione
		// dello script e assegno dei valori di default nel caso non fossero specificati

		$options = $this->common_empty(array(
			'url'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'width'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'align'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'title'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'class1'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'class2'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'action'     => SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET,
		),$instance);

		// Definizione delle variabili di controllo del widget, questi valori non
		// interessano le opzioni della funzione base ma incidono su alcuni aspetti

		$controls = $this->common_empty(array(
			'method'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'width_auto' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		),$instance);

		// Se sul widget ho escluso il badge dal pulsante azzero anche
		// le variabili del badge eventualmente impostate e memorizzate 

		if ($controls['method']     == SZ_PLUGIN_GOOGLE_VALUE_YES) $options['url']   = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if ($controls['width_auto'] == SZ_PLUGIN_GOOGLE_VALUE_YES) $options['width'] = SZ_PLUGIN_GOOGLE_VALUE_AUTO;

		// Creazione del codice HTML per il widget attuale richiamando la
		// funzione base che viene richiamata anche dallo shortcode corrispondente

		$HTML = sz_google_module_plus_get_code_comments($options);

		// Output del codice HTML legato al widget da visualizzare
		// chiamata alla funzione generale per wrap standard

		echo $this->common_widget($args,$instance,$HTML);
	}

	// Funzione per modifica parametri collegati al widget con 
	// memorizzazione dei valori direttamente nel database wordpress

	function update($new_instance,$old_instance) 
	{
		return $this->common_update(array(
			'title'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'method'     => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'url'        => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'width'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'width_auto' => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'align'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
		),$new_instance,$old_instance);
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

		// Richiamo il template per la visualizzazione della
		// parte che riguarda il pannello di amministrazione

		@require(SZ_PLUGIN_GOOGLE_BASENAME_ADMIN_WIDGETS.
			'sz-google-widget-plus-comments.php');
	}
}

/* ************************************************************************** */
/* COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS CO */
/* COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS CO */
/* COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS CO */
/* COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS CO */
/* COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS COMMENTS CO */
/* ************************************************************************** */

function sz_google_module_plus_comments_system_enable() 
{
	// Calcolo opzioni di configurazione generale

	global $SZ_PLUS_OBJECT;
	$options = $SZ_PLUS_OBJECT->getOptions();

	// Se è specificata opzione dopo il contenuto applico il filtro a the_content
	// altrimenti applico il filtro alla funzione di comment_template

	if ($options['plus_comments_ac_enable'] == SZ_PLUGIN_GOOGLE_VALUE_YES) 
	{
		add_filter('the_content','sz_google_module_plus_comments_content');

		if ($options['plus_comments_wp_enable'] != SZ_PLUGIN_GOOGLE_VALUE_YES)   
			add_filter('comments_template','sz_google_module_plus_comments_system_none');

	} else {
		add_filter('comments_template','sz_google_module_plus_comments_system');
	}
}

/* ************************************************************************** */
/* GOOGLE+ COMMENTS funzione per rendering del sistema di commenti            */
/* ************************************************************************** */

function sz_google_module_plus_comments_system($include) 
{
	global $post,$comments;

	if (!(is_singular() && (have_comments() || 'open' == $post->comment_status))) { return; }

	// Aggiornamento delle variabili che contengono le opzioni		 
	// di eleborazione commenti e loro posizione nella pagina

	$checkdt = '00000000';
	$checkid	= get_the_date('Ymd');





	global $SZ_PLUS_OBJECT;
	$options = $SZ_PLUS_OBJECT->getOptions();

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

	$HTML = sz_google_module_plus_get_code_comments(array(
		'url'    => get_permalink(),
		'width'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'title'  => trim($options['plus_comments_title']),
		'class1' => trim($options['plus_comments_css_class_1']),
		'class2' => trim($options['plus_comments_css_class_2']),
	));

	echo $HTML;

	// Aggiunta del codice javascript per il rendering dei widget		 
	// Questo codice viene aggiungo anche dalla sidebar però viene inserito una sola volta

	add_action('wp_footer','sz_google_module_plus_add_script_footer');

	// Ritorno stesso template passato alla funzione nel caso in cui
	// devo mantenere i commenti standard dopo quelli di google plus
	
	if ($options['plus_comments_wp_enable'] == SZ_PLUGIN_GOOGLE_VALUE_YES and $options['plus_comments_aw_enable'] == SZ_PLUGIN_GOOGLE_VALUE_NO) {   
		return $include;
	}

	// Ritorno template di commenti dummy con nessuna azione HTML
	
	return plugin_dir_path( __FILE__ ).'sz-google-module-plus-comments-dummy.php';
}

function sz_google_module_plus_comments_system_none($include) {
	return plugin_dir_path( __FILE__ ).'sz-google-module-plus-comments-dummy.php';
}

/* ************************************************************************** */
/* GOOGLE+ COMMENTS funzione per rendering del sistema di commenti            */
/* ************************************************************************** */

function sz_google_module_plus_comments_content($content) 
{
	global $post,$comments;

	if (!(is_singular() && (have_comments() || 'open' == $post->comment_status))) { return $content; }

	// Creazione codice HTML per inserimento widget dei commenti		 

	$HTML = sz_google_module_plus_get_code_comments(array(
		'url'    => get_permalink(),
		'width'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'title'  => '<h3>'.ucfirst(SZGoogleCommon::getTranslate('leave a Reply')).'</h3>',
		'class1' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'class2' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	));

	// Aggiunta del codice javascript per il rendering dei widget		 
	// Questo codice viene aggiungo anche dalla sidebar però viene inserito una sola volta

	add_action('wp_footer','sz_google_module_plus_add_script_footer');

	return $content.$HTML;
}

/* ************************************************************************** */
/* POST POST POST POST POST POST POST POST POST POST POST POST POST POST POST */
/* POST POST POST POST POST POST POST POST POST POST POST POST POST POST POST */
/* POST POST POST POST POST POST POST POST POST POST POST POST POST POST POST */
/* POST POST POST POST POST POST POST POST POST POST POST POST POST POST POST */
/* POST POST POST POST POST POST POST POST POST POST POST POST POST POST POST */
/* ************************************************************************** */

function sz_google_module_plus_get_code_post($atts=array())
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

	$url = sz_google_module_plus_get_canonical_url($url);

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

	add_action('wp_footer','sz_google_module_plus_add_script_footer');

	// Ritorno per la funzione con tutta la stringa contenente
	// il codice HTML per l'inserimento del codice nella pagina

	return $HTML;
}

/* ************************************************************************** */
/* GOOGLE+ POST funzione per elaborazione shortcode (sz-gplus-post)           */
/* ************************************************************************** */

function sz_google_module_plus_shortcodes_post($atts,$content=null) 
{
	// Preparazione codice HTML dello shortcode tramite la funzione
	// standard di preparazione codice sia per shortcode che widgets

	return sz_google_module_plus_get_code_post(shortcode_atts(array(
		'url'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'align'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'action' => SZ_PLUGIN_GOOGLE_VALUE_TEXT_SHORTCODE,
	),$atts),$content);
}

/* ************************************************************************** */ 
/* GOOGLE+ POST definizione ed elaborazione del widget su sidebar             */ 
/* ************************************************************************** */ 

class sz_google_module_plus_widget_post extends SZGoogleWidget
{
	// Costruttore principale della classe widget, definizione 
	// delle opzioni legate al widget e al controllo dello stesso

	function __construct() 
	{
		parent::__construct('SZ-Google-Post',__('SZ-Google - G+ Post','szgoogleadmin'),array(
			'classname'   => 'sz-widget-google sz-widget-google-plus sz-widget-google-plus-post', 
			'description' => ucfirst(__('widget for google+ post','szgoogleadmin'))
		));
	}

	// Funzione per la visualizzazione del widget con lettura parametri
	// di configurazione e preparazione codice HTML da usare nella sidebar

	function widget($args,$instance) 
	{
		// Controllo se esistono le variabili che servono durante l'elaborazione
		// dello script e assegno dei valori di default nel caso non fossero specificati

		$options = $this->common_empty(array(
			'url'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'align' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		),$instance);

		// Creazione del codice HTML per il widget attuale richiamando la
		// funzione base che viene richiamata anche dallo shortcode corrispondente

		$HTML = sz_google_module_plus_get_code_post($options);

		// Output del codice HTML legato al widget da visualizzare
		// chiamata alla funzione generale per wrap standard

		echo $this->common_widget($args,$instance,$HTML);	
	}

	// Funzione per modifica parametri collegati al widget con 
	// memorizzazione dei valori direttamente nel database wordpress

	function update($new_instance,$old_instance) 
	{
		return $this->common_update(array(
			'title' => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'url'   => SZ_PLUGIN_GOOGLE_VALUE_NO,
			'align' => SZ_PLUGIN_GOOGLE_VALUE_YES,
		),$new_instance,$old_instance);
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

		// Richiamo il template per la visualizzazione della
		// parte che riguarda il pannello di amministrazione

		@require(SZ_PLUGIN_GOOGLE_BASENAME_ADMIN_WIDGETS.
			'sz-google-widget-plus-post.php');
	}
}

/* ************************************************************************** */
/* REWRITE RULES REWRITE RULES REWRITE RULES REWRITE RULES REWRITE RULES REWR */
/* REWRITE RULES REWRITE RULES REWRITE RULES REWRITE RULES REWRITE RULES REWR */
/* REWRITE RULES REWRITE RULES REWRITE RULES REWRITE RULES REWRITE RULES REWR */
/* REWRITE RULES REWRITE RULES REWRITE RULES REWRITE RULES REWRITE RULES REWR */
/* REWRITE RULES REWRITE RULES REWRITE RULES REWRITE RULES REWRITE RULES REWR */
/* ************************************************************************** */

function sz_google_module_plus_rewrite_rules() 
{
	global $wp; 
	global $SZ_PLUS_OBJECT;
	$options = $SZ_PLUS_OBJECT->getOptions();

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

		if (SZ_PLUGIN_GOOGLE_DEBUG) {
			SZGoogleDebug::log('add action rewrite flush rules from google plus');
		}

		add_action('wp_loaded',array('SZGoogleCommon','rewriteFlushRules'));
	}

	// Aggiungo variabile QUERY URL e controllo personalizzato di redirect
	
	add_action('parse_request','sz_google_module_plus_parse_query');
}

/* ************************************************************************** */
/* Controllo le variabili su URL ed eseguo redirect se necessario             */
/* ************************************************************************** */

function sz_google_module_plus_parse_query(&$wp)
{
	global $SZ_PLUS_OBJECT;
	$options = $SZ_PLUS_OBJECT->getOptions();

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

function sz_google_module_plus_add_script_footer()
{
	// Se sono già entrato in questa funzione non eseguo niente
	
	if (defined('SZ_GOOGLE_MODULE_PLUS_ADD_SCRIPT_FOOTER')) return;
	
	// Controllo opzioni per linguaggio impostato o tema o specifico

	define('SZ_GOOGLE_MODULE_PLUS_ADD_SCRIPT_FOOTER',true);

	global $SZ_PLUS_OBJECT;
	$options = $SZ_PLUS_OBJECT->getOptions();

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
/* GOOGLE+ COMMON calcolo indirizzo URL levando i dati di navigazione         */
/* ************************************************************************** */

function sz_google_module_plus_get_canonical_url($url=null) 
{
	$url = str_ireplace('://plus.google.com/b/'    ,'://plus.google.com/',$url);
	$url = str_ireplace('://plus.google.com/u/0/b/','://plus.google.com/',$url);
	$url = str_ireplace('://plus.google.com/u/0/'  ,'://plus.google.com/',$url);

	return $url;
}
