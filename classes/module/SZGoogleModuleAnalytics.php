<?php
/**
 * Modulo GOOGLE ANALYTICS per la definizione delle funzioni che riguardano
 * sia i widget che i shortcode ma anche i filtri e le azioni che il modulo
 * può integrare durante l'aggiunta di funzionalità particolari a wordpress
 *
 * @package SZGoogle
 * @subpackage SZGoogleModule
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Prima di eseguire il caricamento della classe controllo
// se per caso esiste già una definizione con lo stesso nome

if (!class_exists('SZGoogleModuleAnalytics'))
{
	/**
	 * Definizione della classe principale da utilizzare per questo
	 * modulo. La classe deve essere una extends di SZGoogleModule
	 */
	class SZGoogleModuleAnalytics extends SZGoogleModule
	{
		/**
		 * Definizione delle variabili iniziali su array che servono
		 * ad indentificare il modulo e le opzioni ad esso collegate
		 */
		function moduleAddSetup()
		{
			$this->moduleSetClassName(__CLASS__);
			$this->moduleSetOptionSet('sz_google_options_ga');
		}

		/**
		 * Aggiungo le azioni del modulo corrente, questa funzione deve essere
		 * implementata nel caso di una personalizzazione non standard tramite array
		 *
		 * @return void
		 */
		function moduleAddActions()
		{
			$options = (object) $this->getOptions();

			// Se sono sul frontend aggiungo azione header o footer in
			// base a quello che è stato specificato in configurazione 

			if (!is_admin() and $options->ga_enable_front == '1') {
				if ($options->ga_position == 'H') add_action('wp_head',array(new SZGoogleActionAnalytics($this),'action'));
				if ($options->ga_position == 'F') add_action('SZ_FOOT',array(new SZGoogleActionAnalytics($this),'action'));
			}
		}

		/**
		 * Funzione per calcolare il codice di Google Analytics
		 * da utilizzare nel codice di monitoraggio inserito manualmente.
		 *
		 * @return string
		 */
		function getGAId($atts=array()) {
			$options = $this->getOptions();
			return trim($options['ga_uacode']);   
		}
	}

	/**
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 */

	@require_once(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/functions/SZGoogleFunctionsAnalytics.php');
}