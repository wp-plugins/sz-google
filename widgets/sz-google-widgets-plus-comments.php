<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_WIDGETS') or !SZ_PLUGIN_GOOGLE_WIDGETS) die();

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

/* ************************************************************************** */ 
/* Registrazione di tutti i widget precedentemente definiti                   */
/* ************************************************************************** */ 

add_action('widgets_init',create_function('','return register_widget("SZ_Widget_Google_Comments");'));
