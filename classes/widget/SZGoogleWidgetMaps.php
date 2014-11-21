<?php

/**
 * Classe per la definizione di uno widget che viene
 * richiamato dalla classe del modulo principale
 *
 * @package SZGoogle
 * @subpackage SZGoogleWidget 
 */

if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Prima di eseguire il caricamento della classe controllo
// se per caso esiste già una definizione con lo stesso nome

if (!class_exists('SZGoogleWidgetMaps'))
{
	/**
	 * Definizione della classe principale da utilizzare per questo
	 * modulo. La classe deve essere una extends di SZGoogleWidget
	 */
	class SZGoogleWidgetMaps extends SZGoogleWidget
	{
		/**
		 * Costruttore principale della classe widget, definizione
		 * delle opzioni legate al widget e al controllo dello stesso
		 */
		function __construct() 
		{
			parent::__construct('SZ-GOOGLE-MAPS',__('SZ-Google - Maps','szgoogleadmin'),array(
				'classname'   => 'sz-widget-google sz-widget-google-maps sz-widget-google-maps-embed', 
				'description' => ucfirst(__('google maps.','szgoogleadmin'))
			));
		}

		/**
		 * Generazione del codice HTML del widget per la 
		 * visualizzazione completa nella sidebar di appartenenza
		 */
		function widget($args,$instance)
		{
			// Controllo se esistono le variabili che servono durante l'elaborazione
			// dello script e assegno dei valori di default nel caso non fossero specificati

			$options = $this->common_empty(array(
				'title'   => '',  // valore predefinito
				'width'   => '',  // valore predefinito
				'height'  => '',  // valore predefinito
				'lat'     => '',  // default value
				'lng'     => '',  // default value
				'zoom'    => '',  // valore predefinito
				'view'    => '',  // valore predefinito
				'layer'   => '',  // valore predefinito
				'action'  => 'W', // default value
			),$instance);

			// Definizione delle variabili di controllo del widget, questi valori non
			// interessano le opzioni della funzione base ma incidono su alcuni aspetti

			$controls = $this->common_empty(array(
				'width_auto'    => '', // valore predefinito
				'height_auto'   => '', // valore predefinito
			),$instance);

			// Correzione del valore di dimensione nel caso venga
			// specificata la maniera automatica e quindi usare javascript

			if ($controls['width_auto']  == '1') $options['width']  = 'auto';
			if ($controls['height_auto'] == '1') $options['height'] = 'auto';

			// Creazione del codice HTML per il widget attuale richiamando la
			// funzione base che viene richiamata anche dallo shortcode corrispondente

			$OBJC = new SZGoogleActionMaps();
			$HTML = $OBJC->getHTMLCode($options);

			// Output del codice HTML legato al widget da visualizzare
			// chiamata alla funzione generale per wrap standard

			echo $this->common_widget($args,$instance,$HTML);
		}

		/**
		 * Modifica parametri collegati al FORM del widget con la
		 * memorizzazione dei valori direttamente nel database wordpress
		 */
		function update($new_instance,$old_instance) 
		{
			// Esecuzione operazioni aggiuntive sui campi presenti
			// nel form widget prima della memorizzazione database

			return $this->common_update(array(
				'title'       => '0', // strip_tags
				'width'       => '1', // strip_tags
				'height'      => '1', // strip_tags
				'width_auto'  => '1', // strip_tags
				'height_auto' => '1', // strip_tags
				'lat'         => '1', // strip_tags
				'lng'         => '1', // strip_tags
				'zoom'        => '1', // strip_tags
				'view'        => '1', // strip_tags
				'layer'       => '1', // strip_tags
			),$new_instance,$old_instance);
		}

		/**
		 * Visualizzazione FORM del widget presente nella gestione 
		 * delle sidebar nel pannello di amministrazione di wordpress
		 */
		function form($instance) 
		{
			// Creazione array per elenco campi che devono essere 
			// presenti nel form prima di richiamare wp_parse_args()

			$array = array(
				'title'       => '',  // default value
				'width'       => '',  // default value
				'height'      => '',  // default value
				'width_auto'  => '',  // default value
				'height_auto' => '',  // default value
				'lat'         => '',  // default value
				'lng'         => '',  // default value
				'zoom'        => '',  // default value
				'view'        => '',  // default value
				'layer'       => '',  // default value
				'action'      => 'A', // default value
			);

			// Creazione array per elenco campi da recuperare su FORM e
			// caricamento del file con il template HTML da visualizzare

			$OBJC = new SZGoogleActionMaps();
			extract((array) $OBJC->checkOptions(wp_parse_args($instance,$array),EXTR_OVERWRITE));

			// Richiamo il template per la visualizzazione della
			// parte che riguarda il pannello di amministrazione

			@include(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/admin/widgets/SZGoogleWidget.php');
			@include(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/admin/widgets/' .__CLASS__.'.php');
		}
	}
}