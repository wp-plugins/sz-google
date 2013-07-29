<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_WIDGETS') or !SZ_PLUGIN_GOOGLE_WIDGETS) die();

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
/* Registrazione di tutti i widget precedentemente definiti                   */
/* ************************************************************************** */ 

add_action('widgets_init',create_function('','return register_widget("SZ_Widget_Google_Page");'));
