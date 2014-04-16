<?php
/**
 * Modulo GOOGLE PANORAMIO per la definizione delle funzioni che riguardano
 * sia i widget che i shortcode ma anche i filtri e le azioni che il modulo
 * può integrare durante l'aggiunta di funzionalità particolari a wordpress
 *
 * @package SZGoogle
 * @subpackage SZGoogleModule
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Prima di eseguire il caricamento della classe controllo
// se per caso esiste già una definizione con lo stesso nome

if (!class_exists('SZGoogleModulePanoramio'))
{
	/**
	 * Definizione della classe principale da utilizzare per questo
	 * modulo. La classe deve essere una extends di SZGoogleModule
	 */
	class SZGoogleModulePanoramio extends SZGoogleModule
	{
		/**
		 * Definizione delle variabili iniziali su array che servono
		 * ad indentificare il modulo e le opzioni ad esso collegate
		 */
		function moduleAddSetup()
		{
			$this->moduleSetClassName(__CLASS__);
			$this->moduleSetOptionSet('sz_google_options_panoramio');
			
			// Definizione degli shortcode collegati al modulo con un array in cui bisogna
			// specificare l'opzione di attivazione il nome dello shortcode e la funzione da eseguire

			$this->moduleSetShortcodes(array(
				'panoramio_shortcode' => array('sz-panoramio',array(new SZGoogleActionPanoramio(),'getShortcode')),
			));

			// Definizione widget collegati al modulo con un array in cui bisogna
			// specificare il nome opzione di attivazione e la classe da caricare

			$this->moduleSetWidgets(array(
				'panoramio_widget'    => 'SZGoogleWidgetPanoramio',
			));
		}
	}

	/**
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 */

	@require_once(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/functions/SZGoogleFunctionsPanoramio.php');
}