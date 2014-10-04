<?php
/**
 * Modulo GOOGLE AJAX per la definizione delle funzioni che riguardano
 * sia i widget che i shortcode ma anche i filtri e le azioni che il modulo
 * può integrare durante l'aggiunta di funzionalità particolari a wordpress
 *
 * @package SZGoogle
 * @subpackage SZGoogleModule
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Prima di eseguire il caricamento della classe controllo
// se per caso esiste già una definizione con lo stesso nome

if (!class_exists('SZGoogleModuleAjax'))
{
	/**
	 * Definizione della classe principale da utilizzare per questo
	 * modulo. La classe deve essere una extends di SZGoogleModule
	 */
	class SZGoogleModuleAjax extends SZGoogleModule
	{
		/**
		 * Definizione delle variabili iniziali su array che servono
		 * ad indentificare il modulo e le opzioni ad esso collegate
		 */
		function moduleAddSetup()
		{
			$this->moduleSetClassName(__CLASS__);

			add_action('wp_ajax_sz_google_shortcodes',array($this,'moduleAddAjaxShortcodes'));
		}
		
		/**
		 * Funzione per la chiamata Ajax che riguarda la chiamata
		 * dei template sui shortcodes corrispondenti 
		 *
		 * @return void
		 */
		function moduleAddAjaxShortcodes() 
		{
			// Se la chiamata contiene i parametri che la chiamata
			// si attende di ricevere dal form con il metodo POST

			if (!isset($_GET['action']))    return null;
			if (!isset($_GET['shortcode'])) return null;
			if (!isset($_GET['title']))     return null;

			// Controllo esistenza shortcode specificato e
			// caricamento template che riguarda lo shortcode

			$shortcode  = $_GET['shortcode'];
			$shortcodes = $this->moduleGetAjaxShortcodes();

			define('SZGOOGLE_AJAX_NAME',$shortcodes[$shortcode]);

			if (isset($shortcodes[$shortcode])) {
				$filename = dirname(SZ_PLUGIN_GOOGLE_MAIN).'/admin/mce/shortcodes/'.$shortcodes[$shortcode].'.php';
				if (is_file($filename)) @include($filename);
			}

			// La chiamata AJAX deve essere chiusa correttamente con
			// l'istruzione exit() o die() il processo non deve continuare

			die();
		}

		// Definizione array per contenere le stringhe di traduzione da 
		// utilizzare nel plugin definito nel file js collegato

		function moduleGetAjaxShortcodes() 
		{
			return array(
				'sz-gplus-profile'   => 'SZGooglePlusProfile',
				'sz-gplus-page'      => 'SZGooglePlusPage',
				'sz-gplus-community' => 'SZGooglePlusCommunity',
				'sz-gplus-followers' => 'SZGooglePlusFollowers',
				'sz-gplus-one'       => 'SZGooglePlusPlusone',
				'sz-gplus-share'     => 'SZGooglePlusShare',
				'sz-gplus-follow'    => 'SZGooglePlusFollow',
				'sz-gplus-comments'  => 'SZGooglePlusComments',
				'sz-gplus-post'      => 'SZGooglePlusPost',
				'sz-calendar'        => 'SZGoogleCalendar',
				'sz-drive-embed'     => 'SZGoogleDriveEmbed',
				'sz-drive-viewer'    => 'SZGoogleDriveViewer',
				'sz-drive-save'      => 'SZGoogleDriveSaveButton',
				'sz-ggroups'         => 'SZGoogleGroups',
				'sz-hangouts-start'  => 'SZGoogleHangoutsStart',
				'sz-panoramio'       => 'SZGooglePanoramio',
				'sz-gtranslate'      => '',
				'sz-ytvideo'         => 'SZGoogleYoutubeVideo',
				'sz-ytplaylist'      => 'SZGoogleYoutubePlaylist',
				'sz-ytbadge'         => 'SZGoogleYoutubeBadge',
				'sz-ytlink'          => 'SZGoogleYoutubeLink',
				'sz-ytbutton'        => 'SZGoogleYoutubeButton',
			);
		}
	}
}