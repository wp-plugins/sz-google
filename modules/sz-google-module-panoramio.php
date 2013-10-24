<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_MODULE') or !SZ_PLUGIN_GOOGLE_MODULE) die();

/* ************************************************************************** */ 
/* Controllo le opzioni per sapere quali componenti risultano attivati        */ 
/* ************************************************************************** */ 

$options = sz_google_module_panoramio_options();

// Impostazioni variabili per attivazione dei controlli

$SZ_PANORAMIO_ENABLE_SHORTC = $options['panoramio_shortcode'];
$SZ_PANORAMIO_ENABLE_WIDGET = $options['panoramio_widget'];

// Impostazioni variabili per attivazione dei shortcodes

if ($SZ_PANORAMIO_ENABLE_SHORTC == SZ_PLUGIN_GOOGLE_VALUE_YES) add_shortcode('sz-panoramio','sz_google_module_panoramio_shortcode');
if ($SZ_PANORAMIO_ENABLE_WIDGET == SZ_PLUGIN_GOOGLE_VALUE_YES) sz_google_module_widget_create('sz_google_module_panoramio_widget');

/* ************************************************************************** */ 
/* Funzione generale per il caricamento e la messa in coerenza delle opzioni  */
/* ************************************************************************** */ 

function sz_google_module_panoramio_options()
{
	$options = get_option('sz_google_options_panoramio');

	// Controllo delle opzioni in caso di valori non esistenti
	// richiamo della funzione per il controllo isset()

	$options = sz_google_module_check_values_isset($options,array(
		'panoramio_widget'        => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'panoramio_shortcode'     => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'panoramio_s_template'    => SZ_PLUGIN_GOOGLE_PANORAMIO_S_TEMPLATE,
		'panoramio_s_width'       => SZ_PLUGIN_GOOGLE_PANORAMIO_S_WIDTH,
		'panoramio_s_height'      => SZ_PLUGIN_GOOGLE_PANORAMIO_S_HEIGHT,
		'panoramio_s_orientation' => SZ_PLUGIN_GOOGLE_PANORAMIO_S_ORIENTATION,
		'panoramio_s_list_size'   => SZ_PLUGIN_GOOGLE_PANORAMIO_S_LIST_SIZE,
		'panoramio_s_position'    => SZ_PLUGIN_GOOGLE_PANORAMIO_S_POSITION,
		'panoramio_s_paragraph'   => SZ_PLUGIN_GOOGLE_PANORAMIO_S_PARAGRAPH,
		'panoramio_s_delay'       => SZ_PLUGIN_GOOGLE_PANORAMIO_S_DELAY,
		'panoramio_w_template'    => SZ_PLUGIN_GOOGLE_PANORAMIO_W_TEMPLATE,
		'panoramio_w_width'       => SZ_PLUGIN_GOOGLE_PANORAMIO_W_WIDTH,
		'panoramio_w_height'      => SZ_PLUGIN_GOOGLE_PANORAMIO_W_HEIGHT,
		'panoramio_w_orientation' => SZ_PLUGIN_GOOGLE_PANORAMIO_W_ORIENTATION,
		'panoramio_w_list_size'   => SZ_PLUGIN_GOOGLE_PANORAMIO_W_LIST_SIZE,
		'panoramio_w_position'    => SZ_PLUGIN_GOOGLE_PANORAMIO_W_POSITION,
		'panoramio_w_paragraph'   => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'panoramio_w_delay'       => SZ_PLUGIN_GOOGLE_PANORAMIO_W_DELAY,
	));

	// Controllo delle opzioni in caso di valori non conformi
	// richiamo della funzione per il controllo isnull()

	$options = sz_google_module_check_values_isnull($options,array(
		'panoramio_s_template'    => SZ_PLUGIN_GOOGLE_PANORAMIO_S_TEMPLATE,
		'panoramio_s_width'       => SZ_PLUGIN_GOOGLE_PANORAMIO_S_WIDTH,
		'panoramio_s_height'      => SZ_PLUGIN_GOOGLE_PANORAMIO_S_HEIGHT,
		'panoramio_s_orientation' => SZ_PLUGIN_GOOGLE_PANORAMIO_S_ORIENTATION,
		'panoramio_s_list_size'   => SZ_PLUGIN_GOOGLE_PANORAMIO_S_LIST_SIZE,
		'panoramio_s_position'    => SZ_PLUGIN_GOOGLE_PANORAMIO_S_POSITION,
		'panoramio_s_paragraph'   => SZ_PLUGIN_GOOGLE_PANORAMIO_S_PARAGRAPH,
		'panoramio_s_delay'       => SZ_PLUGIN_GOOGLE_PANORAMIO_S_DELAY,
		'panoramio_w_template'    => SZ_PLUGIN_GOOGLE_PANORAMIO_W_TEMPLATE,
		'panoramio_w_width'       => SZ_PLUGIN_GOOGLE_PANORAMIO_W_WIDTH,
		'panoramio_w_height'      => SZ_PLUGIN_GOOGLE_PANORAMIO_W_HEIGHT,
		'panoramio_w_orientation' => SZ_PLUGIN_GOOGLE_PANORAMIO_W_ORIENTATION,
		'panoramio_w_list_size'   => SZ_PLUGIN_GOOGLE_PANORAMIO_W_LIST_SIZE,
		'panoramio_w_position'    => SZ_PLUGIN_GOOGLE_PANORAMIO_W_POSITION,
		'panoramio_w_paragraph'   => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'panoramio_w_delay'       => SZ_PLUGIN_GOOGLE_PANORAMIO_W_DELAY,
	));

	// Chiamata alla funzione comune per controllare le variabili che devono avere
	// un valore di YES o NO e nel caso non fosse possibile forzare il valore (NO)

	$options = sz_google_module_check_values_yesno($options,array(
		'panoramio_widget'      => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'panoramio_shortcode'   => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'panoramio_s_paragraph' => SZ_PLUGIN_GOOGLE_VALUE_NO,
		'panoramio_w_paragraph' => SZ_PLUGIN_GOOGLE_VALUE_NO,
	));

	return $options;
}

/* ************************************************************************** */ 
/* Funzione per la generazione di codice legato a google panoramio            */
/* ************************************************************************** */ 

function sz_google_module_panoramio_get_code($atts=array())
{
	// Estrazione dei valori specificati nello shortcode, i valori ritornati
	// sono contenuti nei nomi di variabili corrispondenti alla chiave

	if (!is_array($atts)) $atts = array();

	extract(shortcode_atts(array(
		'template'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'user'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'group'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'tag'            => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'set'            => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'width'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'height'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'bgcolor'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'delay'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'columns'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'rows'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'orientation'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'listsize'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'position'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'paragraph'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'default'        => SZ_PLUGIN_GOOGLE_VALUE_TEXT_SHORTCODE,
	),$atts));

	// Controllo le variabili che devono avere obbligatorio il valore 
	// di true o false, in caso diverso prendo il valore di default specificato 

	$user      = trim($user);
	$group     = trim($group);
	$tag       = trim($tag);
	$set       = strtolower(trim($set));
	$template  = strtolower(trim($template));
	$width     = strtolower(trim($width));
	$height    = strtolower(trim($height));
	$bgcolor   = strtolower(trim($bgcolor));
	$delay     = strtolower(trim($delay));
	$columns   = strtolower(trim($columns));
	$rows      = strtolower(trim($rows));
	$listsize  = strtolower(trim($listsize));
	$position  = strtolower(trim($position));
	$paragraph = strtolower(trim($paragraph));
	$default   = strtolower(trim($default));

	// Lettura delle opzioni per la definzione di parametri che non hanno
	// specificato nessun valore e che saranno sostituiti con quelli di default

	$options = sz_google_module_panoramio_options();

	if ($default == SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET) 
	{
		$DEFAULT_TEMPLATE    = $options['panoramio_w_template'];
		$DEFAULT_WIDTH       = $options['panoramio_w_width'];
		$DEFAULT_HEIGHT      = $options['panoramio_w_height'];
		$DEFAULT_LIST_SIZE   = $options['panoramio_w_list_size'];
		$DEFAULT_POSITION    = $options['panoramio_w_position'];
		$DEFAULT_ORIENTATION = $options['panoramio_w_orientation'];
		$DEFAULT_PARAGRAPH   = $options['panoramio_w_paragraph'];
		$DEFAULT_DELAY       = $options['panoramio_w_delay'];

	} else {

		$DEFAULT_TEMPLATE    = $options['panoramio_s_template'];
		$DEFAULT_WIDTH       = $options['panoramio_s_width'];
		$DEFAULT_HEIGHT      = $options['panoramio_s_height'];
		$DEFAULT_LIST_SIZE   = $options['panoramio_s_list_size'];
		$DEFAULT_POSITION    = $options['panoramio_s_position'];
		$DEFAULT_ORIENTATION = $options['panoramio_s_orientation'];
		$DEFAULT_PARAGRAPH   = $options['panoramio_s_paragraph'];
		$DEFAULT_DELAY       = $options['panoramio_s_delay'];
	}

	// Controllo la variabile che controlla il paragrafo vuoto da aggiungere
	// dopo il blocco di codice (shortocde) per compatibilità al post di wordpress

	if ($paragraph == 'true')  $paragraph = SZ_PLUGIN_GOOGLE_VALUE_YES;
	if ($paragraph == 'false') $paragraph = SZ_PLUGIN_GOOGLE_VALUE_NO;

	if (!in_array($paragraph,array(SZ_PLUGIN_GOOGLE_VALUE_YES,SZ_PLUGIN_GOOGLE_VALUE_NO))) $paragraph = $DEFAULT_PARAGRAPH;

	// Controllo la coerenza delle opzioni di elaborazione modulo e 
	// sostituzione con valori di default quando presentano dei problemi

	if (!in_array($template,   array('photo','slideshow','list','photo_list'))) $template    = $DEFAULT_TEMPLATE;
	if (!in_array($orientation,array('horizontal','vertical')))                 $orientation = $DEFAULT_ORIENTATION;
	if (!in_array($position,   array('left','top','right','bottom')))           $position    = $DEFAULT_POSITION;

 	if (!ctype_xdigit(str_replace("#","",$bgcolor))) $bgcolor = SZ_PLUGIN_GOOGLE_VALUE_NULL;
	if (!is_numeric($delay) or $delay < 0) $delay = $DEFAULT_DELAY; 

	if (!ctype_digit($columns))  $columns  = "4"; 
	if (!ctype_digit($rows))     $rows     = "1"; 
	if (!ctype_digit($listsize)) $listsize = $DEFAULT_LIST_SIZE; 

	// Controllo i valori passati in array che specificano la dimensione del widget
	// in caso contrario imposto il valore su quello specificato nelle opzioni

	if (!is_numeric($width)  and $width  != SZ_PLUGIN_GOOGLE_VALUE_AUTO) $width  = $DEFAULT_WIDTH;
	if (!is_numeric($height) and $height != SZ_PLUGIN_GOOGLE_VALUE_AUTO) $height = $DEFAULT_HEIGHT;

	// Controllo la dimensione del widget e controllo formale dei valori numerici
	// se trovo qualche incongruenza applico i valori di default prestabiliti

	if ($width  == SZ_PLUGIN_GOOGLE_VALUE_AUTO) $width  = "'+w+'";
	if ($width  == SZ_PLUGIN_GOOGLE_VALUE_NULL) $width  = "'+w+'";

	if ($height == SZ_PLUGIN_GOOGLE_VALUE_AUTO) $height = $DEFAULT_HEIGHT;
	if ($height == SZ_PLUGIN_GOOGLE_VALUE_NULL) $height = $DEFAULT_HEIGHT;

	// Creazione identificativo univoco per riconoscere il codice embed 
	// nel caso la funzioine venga richiamata più volte nella stessa pagina

	$unique = md5(uniqid(),false);
	$keyIDs = 'sz-google-panoramio-'.$unique;

	// Creazione codice HTML per inserimento javascript di google 

	$HTML  = '<div class="sz-google-panoramio">';
	$HTML .= '<div class="sz-google-panoramio-wrap">';
	$HTML .= '<div class="sz-google-panoramio-iframe" id="'.$keyIDs.'"></div>';

	$HTML .= '<script type="text/javascript">';
	$HTML .= "var w=document.getElementById('".$keyIDs."').offsetWidth;";
	$HTML .= "document.write('";

	$HTML .= '<iframe src="https://ssl.panoramio.com/wapi/template/'.$template.'.html?';
	$HTML .= 'width='       .$width;
	$HTML .= '&height='     .$height;
	$HTML .= '&bgcolor='    .rawurlencode($bgcolor);
	$HTML .= '&delay='      .rawurlencode($delay);
	$HTML .= '&columns='    .rawurlencode($columns);
	$HTML .= '&rows='       .rawurlencode($rows);
	$HTML .= '&orientation='.rawurlencode($orientation);
	$HTML .= '&list_size='  .rawurlencode($listsize);
	$HTML .= '&position='   .rawurlencode($position);

	if ($user  != SZ_PLUGIN_GOOGLE_VALUE_NULL) $HTML .= '&user=' .rawurlencode($user);
	if ($group != SZ_PLUGIN_GOOGLE_VALUE_NULL) $HTML .= '&group='.rawurlencode($group);
	if ($tag   != SZ_PLUGIN_GOOGLE_VALUE_NULL) $HTML .= '&tag='  .rawurlencode($tag);
	if ($set   != SZ_PLUGIN_GOOGLE_VALUE_NULL) $HTML .= '&set='  .rawurlencode($set);

	$HTML .= '" ';
	$HTML .= 'scrolling="no" frameborder="0" marginwidth="0" marginheight="0" ';
 	$HTML .= 'width="'.$width.'" ';
	$HTML .= 'height="'.$height.'"';
	$HTML .= '></iframe>'."');";
	$HTML .= '</script>';

	$HTML .= '</div>';
	$HTML .= '</div>';

	if ($default != SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET and $paragraph == SZ_PLUGIN_GOOGLE_VALUE_YES) {
		$HTML .= '<p></p>';
	}

	// Ritorno per la funzione con tutta la stringa contenente
	// il codice HTML per l'inserimento del codice nella pagina

	return $HTML;
}

/* ************************************************************************** */
/* GOOGLE PANORAMIO definizione ed elaborazione dello shortcode               */ 
/* ************************************************************************** */

function sz_google_module_panoramio_shortcode($atts,$content=null) 
{
	// Preparazione codice HTML dello shortcode tramite la funzione
	// standard di preparazione codice sia per shortcode che widgets

	return sz_google_module_panoramio_get_code(shortcode_atts(array(
		'template'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'user'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'group'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'tag'            => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'set'            => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'width'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'height'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'bgcolor'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'delay'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'columns'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'rows'           => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'orientation'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'listsize'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'position'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'paragraph'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'default'        => SZ_PLUGIN_GOOGLE_VALUE_TEXT_SHORTCODE,
	),$atts),$content);
}

/* ************************************************************************** */ 
/* GOOGLE PANORAMIO definizione ed elaborazione del widget su sidebar         */ 
/* ************************************************************************** */ 

class sz_google_module_panoramio_widget extends WP_Widget_SZ_Google
{
	// Costruttore principale della classe widget, definizione 
	// delle opzioni legate al widget e al controllo dello stesso

	function __construct() 
	{
		parent::__construct('sz-google-panoramio',__('SZ-Google - Panoramio','szgoogle'),array(
			'classname'   => 'sz-widget-google sz-widget-google-panoramio sz-widget-google-panoramio-iframe', 
			'description' => ucfirst(__('widget for photos in panoramio','szgoogle'))
		));
	}

	// Funzione per la visualizzazione del widget con lettura parametri
	// di configurazione e preparazione codice HTML da usare nella sidebar

	function widget($args,$instance) 
	{
		// Controllo se esistono le variabili che servono durante l'elaborazione
		// dello script e assegno dei valori di default nel caso non fossero specificati

		$options = $this->common_empty(array(
			'template'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'default'    => SZ_PLUGIN_GOOGLE_VALUE_TEXT_WIDGET,
			'width'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'height'     => SZ_PLUGIN_GOOGLE_PANORAMIO_W_HEIGHT,
			'user'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'group'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'tag'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		),$instance);

		// Definizione delle variabili di controllo del widget, questi valori non
		// interessano le opzioni della funzione base ma incidono su alcuni aspetti

		$controls = $this->common_empty(array(
			'width_auto' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		),$instance);

		// Correzione del valore di dimensione nel caso venga
		// specificata la maniera automatica e quindi usare javascript

		if ($controls['width_auto'] == SZ_PLUGIN_GOOGLE_VALUE_YES) $options['width'] = SZ_PLUGIN_GOOGLE_VALUE_AUTO;

		// Creazione del codice HTML per il widget attuale richiamando la
		// funzione base che viene richiamata anche dallo shortcode corrispondente

		$HTML = sz_google_module_panoramio_get_code($options);

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
			'template'   => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'width'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'width_auto' => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'height'     => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'user'       => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'group'      => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'tag'        => SZ_PLUGIN_GOOGLE_VALUE_YES,
		),$new_instance,$old_instance);
	}

	// Funzione per la visualizzazione del form presente sulle 
	// sidebar nel pannello di amministrazione di wordpress
	
	function form($instance) 
	{
		$array = array(
			'title'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'template'   => SZ_PLUGIN_GOOGLE_PANORAMIO_W_TEMPLATE,
			'width'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'width_auto' => SZ_PLUGIN_GOOGLE_VALUE_YES,
			'height'     => SZ_PLUGIN_GOOGLE_PANORAMIO_W_HEIGHT,
			'user'       => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'group'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'tag'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		);

		// Creazione array per elenco campi da recuperare su FORM

		$instance = wp_parse_args((array) $instance,$array);

		$title      = trim(strip_tags($instance['title']));
		$template   = trim(strip_tags($instance['template']));
		$width      = trim(strip_tags($instance['width']));
		$width_auto = trim(strip_tags($instance['width_auto']));
		$height     = trim(strip_tags($instance['height']));
		$user       = trim(strip_tags($instance['user']));
		$group      = trim(strip_tags($instance['group']));
		$tag        = trim(strip_tags($instance['tag']));

		// Richiamo il template per la visualizzazione della
		// parte che riguarda il pannello di amministrazione

		@require(SZ_PLUGIN_GOOGLE_BASENAME_ADMIN_WIDGETS.
			'sz-google-widget-panoramio.php');
	}
}
