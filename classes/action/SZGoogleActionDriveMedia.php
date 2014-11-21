<?php

/**
 * Definizione di una classe che identifica un'azione richiamata dal
 * modulo principale in base alle opzioni che sono state attivate
 * nel pannello di amministrazione o nella configurazione del plugin
 *
 * @package SZGoogle
 * @subpackage SZGoogleActions
 */

if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Prima di eseguire il caricamento della classe controllo
// se per caso esiste già una definizione con lo stesso nome

if (!class_exists('SZGoogleActionDriveMedia'))
{
	/**
	 * Definizione della classe principale da utilizzare per questa
	 * azione. La classe deve essere una extends di SZGoogleAction
	 */
	class SZGoogleActionDriveMedia extends SZGoogleAction
	{
		/**
		 * Definizione della funzione che viene normalmente richiamata
		 * dagli hook presenti in add_action e add_filter di wordpress
		 */
		function action() {

			add_filter('media_upload_tabs',    array($this,'addMediaUploadTabName'));
			add_action('media_upload_flickr_uploads',array($this,'addMediaUploadTabContent'));
//add_filter( 'media_view_strings', array($this,'custom_media_uploader' ));

		}

		/**
		 * Creazione codice HTML per il componente richiamato che
		 * deve essere usato in comune sia per widget che shortcode
		 *
		 * @return string
		 */
		function addMediaUploadTabName($tabs)
		{
 			$tabs['flickr_uploads'] = "Flickr Uploads";
    		return $tabs;
		}

		function addMediaUploadTabContent()
		{
			$errors= false;
			return wp_iframe(array($this,'addMediaUploadTabContentWP'), 'media', $errors );
		}

		function addMediaUploadTabContentWP() {			
			echo "Ciao MAssimo";
		}
	}
}