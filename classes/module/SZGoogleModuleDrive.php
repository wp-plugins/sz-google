<?php

/**
 * Modulo GOOGLE DRIVE per la definizione delle funzioni che riguardano
 * sia i widget che i shortcode ma anche i filtri e le azioni che il modulo
 * può integrare durante l'aggiunta di funzionalità particolari a wordpress
 *
 * @package SZGoogle
 * @subpackage SZGoogleModule
 */

if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Prima di eseguire il caricamento della classe controllo
// se per caso esiste già una definizione con lo stesso nome

if (!class_exists('SZGoogleModuleDrive'))
{
	/**
	 * Definizione della classe principale da utilizzare per questo
	 * modulo. La classe deve essere una extends di SZGoogleModule
	 */
	class SZGoogleModuleDrive extends SZGoogleModule
	{
		private $setJavascriptPlusone = false;

		/**
		 * Definizione delle variabili iniziali su array che servono
		 * ad indentificare il modulo e le opzioni ad esso collegate
		 */
		function moduleAddSetup()
		{
			$this->moduleSetClassName(__CLASS__);
			$this->moduleSetOptionSet('sz_google_options_drive');
			
			// Definizione shortcode collegati al modulo con un array in cui bisogna
			// specificare il nome opzione di attivazione con lo shortcode e la funzione

			$this->moduleSetShortcodes(array(
				'drive_embed_shortcode'      => array('sz-drive-embed' ,array(new SZGoogleActionDriveEmbed() ,'getShortcode')),
				'drive_viewer_shortcode'     => array('sz-drive-viewer',array(new SZGoogleActionDriveViewer(),'getShortcode')),
				'drive_savebutton_shortcode' => array('sz-drive-save'  ,array(new SZGoogleActionDriveSave()  ,'getShortcode')),
			));

			// Definizione widget collegati al modulo con un array in cui bisogna
			// specificare il nome opzione di attivazione e la classe da caricare

			$this->moduleSetWidgets(array(
				'drive_embed_widget'         => 'SZGoogleWidgetDriveEmbed',
				'drive_viewer_widget'        => 'SZGoogleWidgetDriveViewer',
				'drive_savebutton_widget'    => 'SZGoogleWidgetDriveSaveButton',
			));
		}

		/**
		 * Aggiungo il codice javascript dei vari componenti di 
		 * google plus nel footer e controllo se è stata eseguita
		 *
		 * @return void
		 */
		function addCodeJavascriptFooter()
		{
			// Se ho già inserito il codice javascript nella sezione footer
			// esco dalla funzione altrimenti setto la variabile e continuo

			if ($this->setJavascriptPlusone) return;
				else $this->setJavascriptPlusone = true;

			// Caricamento azione nel footer del plugin per il caricamento
			// del framework javascript messo a disposizione da google

			add_action('SZ_FOOT',array($this,'setJavascriptPlusOne'));
		}
	}

	/**
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 */

	@require_once(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/functions/SZGoogleFunctionsDrive.php');
}