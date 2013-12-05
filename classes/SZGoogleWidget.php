<?php
/**
 * Classe SZGoogleWidget per la definizione di uno widget standard
 * da utilizzare nel plugin. Tutti gli widget definiti dovranno 
 * essere specificati come extended di questa classe, in questa maniera
 * si ottiene meno spreco di risorse e delle performance migliori.
 *
 * @package SZGoogle
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

/**
 * Prima della definizione della classe controllo se esiste
 * una definizione con lo stesso nome o già definita la stessa.
 */




if (!class_exists('SZGoogleWidget'))
{

class SZGoogleWidget extends WP_Widget
{
	// Costruzione del titolo del widget da utilizzare per tutti i 
	// widgets collegati al modulo attivato con questa pagina PHP

	function common_title($args,$instance)
	{
		extract($args);

		if (empty($instance['title'])) $title = SZ_PLUGIN_GOOGLE_VALUE_NULL;
			else $title = trim($instance['title']);

		if (!isset($before_title)) $before_title = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (!isset($after_title))  $after_title  = SZ_PLUGIN_GOOGLE_VALUE_NULL;

		if ($title and $title <> SZ_PLUGIN_GOOGLE_VALUE_NULL) {
			$title = $before_title.$title.$after_title;
		}

		// Ritorno al widget il titolo calcolato tramite i parametri di 
		// configurazione legati al tema applicato attualmente in wordpress	 

		return $title;
	}

	// Funzione per il controllo di variabili vuote all'interno
	// array widget contenente i nomi delle opzioni specificate

	function common_empty($names,$instance) 
	{
		foreach ($names as $key=>$value) {
			if (empty($instance[$key])) $instance[$key] = trim($value);
				else $instance[$key] = trim($instance[$key]);
		}

		return $instance;
	}

	// Funzione per emissione codie HTML con calcolo del titolo
	// e codice predefinito prima e dopo il widgets su sidebar

	function common_widget($args,$instance,$HTML) 
	{
		extract($args);

		// Calcolo del titolo legato al widget passato tramite la 
		// variabile presente nella instanza dei parametri memorizzata

		if (empty($instance['title'])) $title = SZ_PLUGIN_GOOGLE_VALUE_NULL;
			else $title = trim($instance['title']);

		if (!isset($before_title)) $before_title = SZ_PLUGIN_GOOGLE_VALUE_NULL;
		if (!isset($after_title))  $after_title  = SZ_PLUGIN_GOOGLE_VALUE_NULL;

		if ($title and $title <> SZ_PLUGIN_GOOGLE_VALUE_NULL) {
			$title = $before_title.$title.$after_title;
		}

		// Calcolo del codice HTML definitivo facendo il wrap
		// con la variabile HTML generata dal widget specifico

		$output  = $before_widget;
		$output .= $title;
		$output .= $HTML;
		$output .= $after_widget;

		return $output;
	}

	// Funzione per modifica parametri collegati al widget con 
	// memorizzazione dei valori direttamente nel database wordpress

	function common_update($names,$new_instance,$old_instance) 
	{
		$instance = $old_instance;

		foreach ($names as $key=>$value) 
		{
			if (!isset($new_instance[$key])) $instance[$key] = SZ_PLUGIN_GOOGLE_VALUE_NULL; 
				else $instance[$key] = trim($new_instance[$key]);

			if ($value == SZ_PLUGIN_GOOGLE_VALUE_YES) {
				$instance[$key] = strip_tags($instance[$key]);
			}
		}

		// Ritorno al widget array con le opzioni di update corrette e
		// gli eventuali elementi nuovi che sul vecchio widget era mancanti

		return $instance;
	}
}

}
