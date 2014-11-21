<?php

/**
 * Classe SZGoogleWidget per la definizione di uno widget standard
 * da utilizzare nel plugin. Tutti gli widget definiti dovranno 
 * essere specificati come extended di questa classe.
 *
 * @package SZGoogle
 * @subpackage SZGoogleWidget
 */

if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Prima di eseguire il caricamento della classe controllo
// se per caso esiste già una definizione con lo stesso nome

if (!class_exists('SZGoogleWidget'))
{
	/**
	 * Definizione della classe principale da utilizzare per le 
	 * tutte le altre classi dei widget appartenente al plugin 
	 */
	class SZGoogleWidget extends WP_Widget
	{
		/**
		 * Costruzione del titolo del widget da utilizzare per tutti i 
		 * widgets collegati al modulo attivato con questa pagina PHP
		 */
		function common_title($args,$instance)
		{
			extract($args);

			if (empty($instance['title'])) $title = '';
				else $title = esc_attr(trim($instance['title']));

			if (!isset($before_title)) $before_title = '';
			if (!isset($after_title))  $after_title  = '';

			if ($title and $title <> '') {
				$title = $before_title.$title.$after_title;
			}

			// Ritorno al widget il titolo calcolato tramite i parametri di 
			// configurazione legati al tema applicato attualmente in wordpress	 

			return $title;
		}

		/**
		 * Controllo di variabili vuote all'interno array
		 * widget contenente i nomi delle opzioni specificate
		 */
		function common_empty($names,$instance) 
		{
			foreach ($names as $key=>$value) {
				if (empty($instance[$key])) $instance[$key] = trim($value);
					else $instance[$key] = trim($instance[$key]);
			}

			// Aggiungo il parametro action=widget nei parametri generali in modo
			// che la funzione del codice comune può individuare il componente 

			if (!isset($instance['action'])) $instance['action'] = 'widget';

			// Ritorno array alla classe widget chiamante con tutte le
			// opzioni trimmate e impostate secondo un valore di default

			return $instance;
		}

		/**
		 * Emissione codice HTML con calcolo del titolo e
		 * codice predefinito prima e dopo il widgets su sidebar
		 */
		function common_widget($args,$instance,$HTML) 
		{
			extract($args);

			// Calcolo del titolo legato al widget passato tramite la 
			// variabile presente nella instanza dei parametri memorizzata

			$title = $this->common_title($args,$instance);

			// Calcolo del codice HTML definitivo facendo il wrap
			// con la variabile HTML generata dal widget specifico

			$output  = $before_widget;
			$output .= $title;
			$output .= $HTML;
			$output .= $after_widget;

			return $output;
		}

		/**
		 * Modifica parametri e opzioni collegate al widget con 
		 * memorizzazione dei valori direttamente nel database wordpress
		 */
		function common_update($names,$new_instance,$old_instance) 
		{
			$instance = $old_instance;

			foreach ($names as $key=>$value) 
			{
				if (!isset($new_instance[$key])) $instance[$key] = ''; 
					else $instance[$key] = trim($new_instance[$key]);

				if ($value == '1') $instance[$key] = strip_tags($instance[$key]);
			}

			// Ritorno al widget array con le opzioni di update corrette e
			// gli eventuali elementi nuovi che sul vecchio widget era mancanti

			return $instance;
		}
	}
}