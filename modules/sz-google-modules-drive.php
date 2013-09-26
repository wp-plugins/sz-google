<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_MODULES') or !SZ_PLUGIN_GOOGLE_MODULES) die();

/* ************************************************************************** */ 
/* Controllo le opzioni per sapere quali componenti risultano attivati        */ 
/* ************************************************************************** */ 

$options = sz_google_modules_drive_options();

if ($options['drive_savebutton_shortcode'] == SZ_PLUGIN_GOOGLE_VALUE_YES) { 
	add_shortcode('sz-drive-save','sz_google_shortcodes_drive_savebutton');
}

if ($options['drive_savebutton_widget'] == SZ_PLUGIN_GOOGLE_VALUE_YES) { 
	add_action('widgets_init',create_function('','return register_widget("SZ_Widget_Google_Drive_Save_Button");'));
}

/* ************************************************************************** */ 
/* Funzione generale per il caricamento e la messa in coerenza delle opzioni  */
/* ************************************************************************** */ 

function sz_google_modules_drive_options()
{
	// Caricamento delle opzioni per modulo google translate

	$options = get_option('sz_google_options_drive');

	// Controllo delle opzioni in caso di valori non validi

	if (!isset($options['drive_sitename']))             $options['drive_sitename']             = SZ_PLUGIN_GOOGLE_VALUE_NULL;
	if (!isset($options['drive_savebutton_widget']))    $options['drive_savebutton_widget']    = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!isset($options['drive_savebutton_shortcode'])) $options['drive_savebutton_shortcode'] = SZ_PLUGIN_GOOGLE_VALUE_NO;

	// Se trovo un valore non riconosciuto imposto dei valori predefiniti validi

	$YESNO = array(SZ_PLUGIN_GOOGLE_VALUE_NO,SZ_PLUGIN_GOOGLE_VALUE_YES);
 
	if (!in_array($options['drive_savebutton_widget'],   $YESNO)) $options['drive_savebutton_widget']    = SZ_PLUGIN_GOOGLE_VALUE_NO;
	if (!in_array($options['drive_savebutton_shortcode'],$YESNO)) $options['drive_savebutton_shortcode'] = SZ_PLUGIN_GOOGLE_VALUE_NO;

	return $options;
}

/* ************************************************************************** */
/* SAVE BUTTON SAVE BUTTON SAVE BUTTON SAVE BUTTON SAVE BUTTON SAVE BUTTON SA */
/* SAVE BUTTON SAVE BUTTON SAVE BUTTON SAVE BUTTON SAVE BUTTON SAVE BUTTON SA */
/* SAVE BUTTON SAVE BUTTON SAVE BUTTON SAVE BUTTON SAVE BUTTON SAVE BUTTON SA */
/* SAVE BUTTON SAVE BUTTON SAVE BUTTON SAVE BUTTON SAVE BUTTON SAVE BUTTON SA */
/* SAVE BUTTON SAVE BUTTON SAVE BUTTON SAVE BUTTON SAVE BUTTON SAVE BUTTON SA */
/* ************************************************************************** */

function sz_google_modules_drive_get_code_savebutton($atts=array(),$content=null)
{
	// Estrazione dei valori specificati nello shortcode, i valori ritornati
	// sono contenuti nei nomi di variabili corrispondenti alla chiave

	if (!is_array($atts)) $atts = array();

	$DEFAULT_ALIGN      = 'none';
	$DEFAULT_POSITION   = 'outside';

	extract(shortcode_atts(array(
		'url'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'filename'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'sitename'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'text'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'img'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'position'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'align'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'margintop'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginright'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginbottom' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginleft'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginunit'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts));

	// Elimino spazi aggiunti di troppo ed esegui la trasformazione in
	// stringa minuscolo per il controllo di valori speciali come "auto"

	$url          = trim($url);
	$filename     = trim($filename);
	$sitename     = trim($sitename);
	$text         = trim($text);
	$img          = trim($img);

	$position     = strtolower(trim($position));
	$align        = strtolower(trim($align));
	$margintop    = strtolower(trim($margintop));
	$marginright  = strtolower(trim($marginright));
	$marginbottom = strtolower(trim($marginbottom));
	$marginleft   = strtolower(trim($marginleft));
	$marginunit   = strtolower(trim($marginunit));

	// Se non specifico un URL valido per la creazione del bottone
	// esco dalla funzione e ritorno una stringa vuota

	if (empty($url)) { return SZ_PLUGIN_GOOGLE_VALUE_NULL; }

	// Imposto i valori di default nel caso siano specificati dei valori
	// che non appartengono al range dei valori accettati

	if (!in_array($align,array('none','left','right','center'))) $align = $DEFAULT_ALIGN; 
	if (!in_array($position,array('top','center','bottom','outside'))) $position = $DEFAULT_POSITION; 

	if (empty($sitename)) $sitename = get_bloginfo('name'); 
	if (empty($sitename)) $sitename = SZ_PLUGIN_GOOGLE_DRIVE_SITENAME; 
	if (empty($filename)) $filename = basename($url);

	// Calcolo il nome host attuale di wordpress in maniera da preparare
	// la stringa per la sostituzione sonlo se link è sullo stesso dominio

	$URLBlog = home_url('/');
	$URLBlog = parse_url($URLBlog);

	if(isset($URLBlog['host'])) {
		$url = preg_replace('#^https?://'.$URLBlog['host'].'#','', $url);
	}

	// Creazione codice HTML per embed code da inserire nella pagina wordpress

	$HTML  = '<div class="g-savetodrive"';
	$HTML .= ' data-src="'     .$url     .'"';
	$HTML .= ' data-filename="'.$filename.'"';
	$HTML .= ' data-sitename="'.$sitename.'"';
	$HTML .= '></div>';

	$HTML = sz_google_modules_drive_get_code_button_wrap(array(
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
		'class'        => 'sz-google-savetodrive',
	));

	// Aggiunta del codice javascript per il rendering dei widget, questo codice		 
	// viene aggiungo anche dalla sidebar però viene inserito una sola volta

	add_action('wp_footer','sz_google_modules_plus_add_script_footer');

	// Ritorno per la funzione con tutta la stringa contenente
	// il codice HTML per l'inserimento del codice nella pagina

	return $HTML;
}

/* ************************************************************************** */
/* DRIVE SAVE BUTTON funzione per elaborazione shortcode (sz-drive-save)      */
/* ************************************************************************** */

function sz_google_shortcodes_drive_savebutton($atts,$content=null) 
{
	extract(shortcode_atts(array(
		'url'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'filename'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'sitename'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'text'         => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'img'          => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'position'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'align'        => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'margintop'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginright'  => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginbottom' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginleft'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		'marginunit'   => SZ_PLUGIN_GOOGLE_VALUE_NULL,
	),$atts));

	// Preparazione codice HTML dello shortcode tramite la funzione
	// standard di preparazione codice sia per shortcode che widgets

	$HTML = sz_google_modules_drive_get_code_savebutton(array(
		'url'          => trim($url),
		'filename'     => trim($filename),
		'sitename'     => trim($sitename),
		'text'         => trim($text),
		'img'          => trim($img),
		'position'     => trim($position),
		'align'        => trim($align),
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
/* DRIVE SAVE BUTTON definizione ed elaborazione del widget su sidebar        */ 
/* ************************************************************************** */ 

class SZ_Widget_Google_Drive_Save_Button extends WP_Widget
{
	// Costruttore principale della classe widget, definizione 
	// delle opzioni legate al widget e al controllo dello stesso

	function SZ_Widget_Google_Drive_Save_Button() 
	{
		$widget_ops  = array(
			'classname'   => 'sz-widget-google sz-widget-google-drive sz-widget-google-drive-save-button', 
			'description' => ucfirst(__('widget for google drive save button','szgoogleadmin'))
		);

		$this->WP_Widget('SZ-Google-Drive-Save-Button',
			__('SZ-Google - Drive Save Button','szgoogleadmin'),$widget_ops);
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

		if (empty($instance['url']))      $instance['url']      = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['badge']))    $instance['badge']    = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['img']))      $instance['img']      = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['text']))     $instance['text']     = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['align']))    $instance['align']    = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (empty($instance['position'])) $instance['position'] = SZ_PLUGIN_GOOGLE_VALUE_NULL;

		// Se sul widget ho escluso il badeg dal pulsante azzero anche
		// le variabili del badge eventualmente impostate e memorizzate 

		if ($instance['badge'] != SZ_PLUGIN_GOOGLE_VALUE_YES) 
		{
			$instance['img']      = SZ_PLUGIN_GOOGLE_VALUE_NULL;
			$instance['text']     = SZ_PLUGIN_GOOGLE_VALUE_NULL;
			$instance['position'] = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		}

		// Dopo il controllo di esistenza per tutte le opzioni necessarie
		// eseguo il trim e la conversione in minuscolo per le opzioni 

		$url      = trim($instance['url']);
		$text     = trim($instance['text']);
		$img      = trim($instance['img']);

		$align    = strtolower(trim($instance['align']));
		$position = strtolower(trim($instance['position']));

		// Creazione codice HTML per inserimento widget post		 

		$HTML = sz_google_modules_drive_get_code_savebutton(array(
			'url'          => trim($url),
			'filename'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'sitename'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'text'         => trim($text),
			'img'          => trim($img),
			'position'     => trim($position),
			'align'        => trim($align),
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

		if (!isset($new_instance['title']))    $new_instance['title']    = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['badge']))    $new_instance['badge']    = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['url']))      $new_instance['url']      = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['text']))     $new_instance['text']     = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['img']))      $new_instance['img']      = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['align']))    $new_instance['align']    = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
		if (!isset($new_instance['position'])) $new_instance['position'] = SZ_PLUGIN_GOOGLE_VALUE_NULL; 

		$instance['url']      = trim($new_instance['url']);
		$instance['text']     = trim($new_instance['text']);
		$instance['img']      = trim($new_instance['img']);

		$instance['title']    = trim(strip_tags($new_instance['title']));
		$instance['badge']    = trim(strip_tags($new_instance['badge']));
		$instance['align']    = trim(strip_tags($new_instance['align']));
		$instance['position'] = trim(strip_tags($new_instance['position']));

		return $instance;
	}

	// Funzione per la visualizzazione del form presente sulle 
	// sidebar nel pannello di amministrazione di wordpress
	
	function form($instance) 
	{
		$array = array(
			'title'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'badge'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'url'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'text'     => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'img'      => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'align'    => SZ_PLUGIN_GOOGLE_VALUE_NULL,
			'position' => SZ_PLUGIN_GOOGLE_VALUE_NULL,
		);

		// Creazione array per elenco campi da recuperare su FORM

		$instance = wp_parse_args((array) $instance,$array);

		$url      = trim($instance['url']);
		$text     = trim($instance['text']);
		$img      = trim($instance['img']);

		$badge    = trim(strip_tags($instance['badge']));
		$title    = trim(strip_tags($instance['title']));
		$align    = trim(strip_tags($instance['align']));
		$position = trim(strip_tags($instance['position']));

		// Campo di selezione parametro badge per TITOLO

		echo '<table style="width:100%">';

		echo '<tr>';
		echo '<td colspan="2">';
		echo '<label for="'.$this->get_field_id('title').'">'.ucfirst(__('title','szgoogleadmin')).':</label>';
		echo '<input class="widefat" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.esc_attr($title).'"/>';
		echo '</td>';
		echo '</tr>';

		// Campo di selezione parametro URL del file che deve essere memorizzato su drive

		echo '<tr>';
		echo '<td><input class="sz-upload-image-url widefat" id="'.$this->get_field_id('url').'" name="'.$this->get_field_name('url').'" type="text" value="'.$url.'" placeholder="'.__('insert URL file to save','szgoogleadmin').'"/></td>';
		echo '<td><input class="sz-upload-image-button button" type="button" value="'.ucfirst(__('select file','szgoogleadmin')).'" data-field-url="sz-upload-image-url" data-title="'.ucfirst(__('select or upload a file','szgoogleadmin')).'" data-button-text="'.ucfirst(__('confirm selection','szgoogleadmin')).'"/></td>';
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
/* DRIVE codice per disegnare il wrap dei bottoni di google plus              */
/* ************************************************************************** */

function sz_google_modules_drive_get_code_button_wrap($atts) {
	return sz_google_modules_get_code_button_wrap($atts);
}