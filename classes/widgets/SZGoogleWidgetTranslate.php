<?php
/**
 * Classe SZGoogleWidget per la definizione di uno widget standard
 * da utilizzare nel plugin. Tutti gli widget definiti dovranno 
 * essere specificati come extended di questa classe.
 *
 * @package SZGoogle
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

/**
 * Creazione WIDGET per il modulo del plugin richiesto.
 * Creazione della classe con riferimento a quella generica.
 */
if (!class_exists('SZGoogleWidgetTranslate'))
{
	class SZGoogleWidgetTranslate extends SZGoogleWidget
	{
		// Costruttore principale della classe widget, definizione 
		// delle opzioni legate al widget e al controllo dello stesso

		function __construct() 
		{
			parent::__construct('SZ-Google-Translate',__('SZ-Google - Translate','szgoogleadmin'),array(
				'classname'   => 'sz-widget-google sz-widget-translate sz-widget-translate-widget', 
				'description' => ucfirst(__('google translate.','szgoogleadmin'))
			));
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

			// Creazione del codice per widget google translate

			$HTML = sz_google_module_translate_get_code();
      
			// Output del codice HTML legato al widget da visualizzare		 

			$output  = '';
			$output .= $before_widget;
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
			$instance['title'] = trim(strip_tags($new_instance['title']));

			return $instance;
		}

		// Funzione per la visualizzazione del form presente sulle 
		// sidebar nel pannello di amministrazione di wordpress
	
		function form($instance) 
		{
			// Creazione array per elenco campi da recuperare su FORM

			$array = array(
				'title'    => '',
			);

			// Creazione array per elenco campi da recuperare su FORM

			$instance = wp_parse_args((array) $instance,$array);
			$title    = trim(strip_tags($instance['title']));

			// Campo di selezione parametro badge per TITOLO

			echo '<p><label for="'.$this->get_field_id('title').'">'.ucfirst(__('title','szgoogleadmin')).':</label>';
			echo '<input class="widefat" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.esc_attr($title).'"/></p>';
		}
	}
}