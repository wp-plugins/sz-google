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

if (!class_exists('SZGoogleWidgetHangoutsStart'))
{
	/**
	 * Definizione della classe principale da utilizzare per questo
	 * modulo. La classe deve essere una extends di SZGoogleWidget
	 */
	class SZGoogleWidgetHangoutsStart extends SZGoogleWidget
	{
		/**
		 * Costruttore principale della classe widget, definizione
		 * delle opzioni legate al widget e al controllo dello stesso
		 */
		function __construct() 
		{
			parent::__construct('SZ-GOOGLE-HANGOUTS-START',__('SZ-Google - Hangouts start','szgoogleadmin'),array(
				'classname'   => 'sz-widget-google sz-widget-google-hangouts sz-widget-google-hangouts-start', 
				'description' => ucfirst(__('hangout start button.','szgoogleadmin'))
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
				'type'         => '', // valore predefinito
				'width'        => '', // valore predefinito
				'topic'        => '', // valore predefinito
				'float'        => '', // valore predefinito
				'align'        => '', // valore predefinito
				'text'         => '', // valore predefinito
				'img'          => '', // valore predefinito
				'position'     => '', // valore predefinito
				'profile'      => '', // valore predefinito
				'email'        => '', // valore predefinito
				'logged'       => '', // valore predefinito
				'guest'        => '', // valore predefinito
				'margintop'    => '', // valore predefinito
				'marginright'  => '', // valore predefinito
				'marginbottom' => '', // valore predefinito
				'marginleft'   => '', // valore predefinito
				'marginunit'   => '', // valore predefinito
				'class'        => '', // valore predefinito
			),$instance);

			// Definizione delle variabili di controllo del widget, questi valori non
			// interessano le opzioni della funzione base ma incidono su alcuni aspetti

			$controls = $this->common_empty(array(
				'badge'        => '', // valore predefinito
				'width_auto'   => '', // valore predefinito
			),$instance);

			// Se sul widget ho escluso il badge dal pulsante azzero anche
			// le variabili del badge eventualmente impostate e memorizzate 

			if ($controls['badge'] != '1') 
			{
				$options['img']      = '';
				$options['text']     = '';
				$options['position'] = '';
			}

			// Correzione del valore di dimensione nel caso venga
			// specificata la maniera automatica e quindi usare javascript

			if ($controls['width_auto'] == '1') $options['width'] = 'auto';

			// Creazione del codice HTML per il widget attuale richiamando la
			// funzione base che viene richiamata anche dallo shortcode corrispondente

			$OBJC = new SZGoogleActionHangoutsStart();
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
				'title'      => '0', // esecuzione strip_tags
				'type'       => '1', // esecuzione strip_tags
				'topic'      => '1', // esecuzione strip_tags
				'badge'      => '1', // esecuzione strip_tags
				'text'       => '0', // esecuzione strip_tags
				'img'        => '1', // esecuzione strip_tags
				'align'      => '1', // esecuzione strip_tags
				'position'   => '1', // esecuzione strip_tags
				'profile'    => '0', // esecuzione strip_tags
				'email'      => '0', // esecuzione strip_tags
				'logged'     => '1', // esecuzione strip_tags
				'guest'      => '1', // esecuzione strip_tags
				'width'      => '1', // esecuzione strip_tags
				'width_auto' => '1', // esecuzione strip_tags
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
				'type'       => '', // valore predefinito
				'topic'      => '', // valore predefinito
				'badge'      => '', // valore predefinito
				'text'       => '', // valore predefinito
				'img'        => '', // valore predefinito
				'align'      => '', // valore predefinito
				'position'   => '', // valore predefinito
				'profile'    => '', // valore predefinito
				'email'      => '', // valore predefinito
				'logged'     => '', // valore predefinito
				'guest'      => '', // valore predefinito
				'width'      => '', // valore predefinito
				'width_auto' => '', // valore predefinito
			);

			// Creazione array per elenco campi da recuperare su FORM e
			// caricamento del file con il template HTML da visualizzare

			extract(wp_parse_args($instance,$array),EXTR_OVERWRITE);

			// Impostazione eventuale di parametri di default per i
			// campi che contengono dei valori non validi o non coerenti 

			if (!ctype_digit($width) or $width == 0) { $width = 'auto'; $width_auto = '1'; }

			// Lettura delle opzioni per il controllo dei valori di default
			// da assegnare al widget nel momento che viene inserito in sidebar

			if ($object = SZGoogleModule::getObject('SZGoogleModuleHangouts')) 
			{
				$options = (object) $object->getOptions();

				// Controllo se la stringa contiene un valore coerente con la
				// selezione del parametro sia come valore numerico che carattere

				$YESNO = array('1','0','n','y');

				if (!in_array($logged,$YESNO)) $logged = $options->hangouts_start_logged;
				if (!in_array($guest ,$YESNO)) $guest  = $options->hangouts_start_guest;
			}

			// Se i valori vengono presi dalle opzioni di default si possono creare
			// dei problemi dovuti alla differenza nella memorizzazione dello stato

			$logged = str_replace(array('0','1'),array('n','y'),$logged);
			$guest  = str_replace(array('0','1'),array('n','y'),$guest);

			// Richiamo il template per la visualizzazione della
			// parte che riguarda il pannello di amministrazione

			@include(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/admin/widgets/SZGoogleWidget.php');
			@include(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/admin/widgets/' .__CLASS__.'.php');
		}
	}
}