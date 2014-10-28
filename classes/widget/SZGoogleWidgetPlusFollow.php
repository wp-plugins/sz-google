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

if (!class_exists('SZGoogleWidgetPlusFollow'))
{
	/**
	 * Definizione della classe principale da utilizzare per questo
	 * modulo. La classe deve essere una extends di SZGoogleWidget
	 */
	class SZGoogleWidgetPlusFollow extends SZGoogleWidget
	{
		/**
		 * Costruttore principale della classe widget, definizione
		 * delle opzioni legate al widget e al controllo dello stesso
		 */
		function __construct() 
		{
			parent::__construct('SZ-GOOGLE-PLUS-FOLLOW',__('SZ-Google - G+ Follow','szgoogleadmin'),array(
				'classname'   => 'sz-widget-google sz-widget-google-plus sz-widget-google-plus-follow', 
				'description' => ucfirst(__('google+ follow.','szgoogleadmin'))
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
				'url'          => '', // valore predefinito
				'size'         => '', // valore predefinito
				'width'        => '', // valore predefinito
				'annotation'   => '', // valore predefinito
				'float'        => '', // valore predefinito
				'align'        => '', // valore predefinito
				'text'         => '', // valore predefinito
				'img'          => '', // valore predefinito
				'rel'          => '', // valore predefinito
				'position'     => '', // valore predefinito
				'margintop'    => '', // valore predefinito
				'marginright'  => '', // valore predefinito
				'marginbottom' => '', // valore predefinito
				'marginleft'   => '', // valore predefinito
				'marginunit'   => '', // valore predefinito
			),$instance);

			// Definizione delle variabili di controllo del widget, questi valori non
			// interessano le opzioni della funzione base ma incidono su alcuni aspetti

			$controls = $this->common_empty(array(
				'badge'        => '', // valore predefinito
				'urltype'      => '', // valore predefinito
			),$instance);

			// Se sul widget ho escluso il badge dal pulsante azzero anche
			// le variabili del badge eventualmente impostate e memorizzate 

			if ($controls['badge'] != '1') {
				$options['img']      = '';
				$options['text']     = '';
				$options['position'] = '';
			}

			// Lettura opzioni generali per impostazione dei dati di default

			if ($object = SZGoogleModule::getObject('SZGoogleModulePlus')) 
			{
				$general = $object->getOptions($options);

				// Imposto i valori di default nel caso siano specificati dei valori
				// che non appartengono al range dei valori accettati

				if ($controls['urltype'] == '2') {
					if ($general['plus_page'] == '') $options['url'] = 'https://plus.google.com/117259631219963935481';
						else $options['url'] = 'https://plus.google.com/'.$general['plus_page'];
				}

				if ($controls['urltype'] == '3') {
					if ($general['plus_profile'] == '') $options['url'] = 'https://plus.google.com/106189723444098348646';
						else $options['url'] = 'https://plus.google.com/'.$general['plus_profile'];
				}

			}

			// Creazione del codice HTML per il widget attuale richiamando la
			// funzione base che viene richiamata anche dallo shortcode corrispondente

			if ($object = SZGoogleModule::getObject('SZGoogleModulePlus')) {
				$HTML = $object->getPlusFollowShortcode($options);
			}

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
				'title'      => '0', // esecuzione strip_tags
				'badge'      => '1', // esecuzione strip_tags
				'url'        => '0', // esecuzione strip_tags
				'urltype'    => '1', // esecuzione strip_tags
				'text'       => '0', // esecuzione strip_tags
				'img'        => '0', // esecuzione strip_tags
				'align'      => '1', // esecuzione strip_tags
				'position'   => '1', // esecuzione strip_tags
				'size'       => '1', // esecuzione strip_tags
				'annotation' => '1', // esecuzione strip_tags
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
				'title'      => '', // valore predefinito
				'badge'      => '', // valore predefinito
				'url'        => '', // valore predefinito
				'urltype'    => '', // valore predefinito
				'text'       => '', // valore predefinito
				'img'        => '', // valore predefinito
				'align'      => '', // valore predefinito
				'position'   => '', // valore predefinito
				'size'       => '', // valore predefinito
				'annotation' => '', // valore predefinito
			);

			// Creazione array per elenco campi da recuperare su FORM e
			// caricamento del file con il template HTML da visualizzare

			extract(wp_parse_args($instance,$array),EXTR_OVERWRITE);

			// Richiamo il template per la visualizzazione della
			// parte che riguarda il pannello di amministrazione

			@include(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/admin/widgets/SZGoogleWidget.php');
			@include(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/admin/widgets/' .__CLASS__.'.php');
		}
	}
}