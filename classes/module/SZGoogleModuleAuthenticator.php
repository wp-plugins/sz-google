<?php

/**
 * Modulo GOOGLE AUTHENTICATOR per la definizione delle funzioni che riguardano
 * sia i widget che i shortcode ma anche i filtri e le azioni che il modulo
 * può integrare durante l'aggiunta di funzionalità particolari a wordpress
 *
 * @package SZGoogle
 * @subpackage SZGoogleModule
 */

if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Prima di eseguire il caricamento della classe controllo
// se per caso esiste già una definizione con lo stesso nome

if (!class_exists('SZGoogleModuleAuthenticator'))
{
	/**
	 * Definizione della classe principale da utilizzare per questo
	 * modulo. La classe deve essere una extends di SZGoogleModule
	 */
	class SZGoogleModuleAuthenticator extends SZGoogleModule
	{
		/**
		 * Definizione delle variabili iniziali su array che servono
		 * ad indentificare il modulo e le opzioni ad esso collegate
		 */
		function moduleAddSetup()
		{
			$this->moduleSetClassName(__CLASS__);
			$this->moduleSetOptionSet('sz_google_options_authenticator');
		}

		/**
		 * Aggiungo le azioni del modulo corrente, questa funzione deve essere
		 * implementata nel caso di una personalizzazione non standard tramite array
		 *
		 * @return void
		 */
		function moduleAddActions()
		{
			$options = $this->getOptions();

			// Controllo se opzione autenticazione di login risulta attiva.
			// In questo caso aggiungo filtri e azioni su fase di login.

			if ($options['authenticator_login_enable']) {
				if (!$this->checkEmergencyFile()) new SZGoogleActionAuthenticatorLogin();
					else if (is_admin()) add_action('admin_notices',array($this,'addAdminAuthenticatorNotices'));
			}

			// Aggiungo le opzioni al profilo che vengono viste solo se user=current nelle
			// opzioni verranno inseriti i bottone per creare una configurazione di sincronizzazione

			new SZGoogleActionAuthenticatorProfile();
		}

		/**
		 * Funzione per indicare il messaggio di sospensione modulo
		 * sulla bacheca principale del pannello di amministrazione.
		 *
		 * @return void
		 */
		function addAdminAuthenticatorNotices() 
		{
			echo '<div class="error"><p>(<b>sz-google</b>) - ';
			echo __('Google Authenticator is suspended because it was found the file of emergency in the root directory.','szgoogleadmin');
			echo '</p></div>';
		}

		/**
		 * Funzione per il controllo del file di emergenza, se viene
		 * trovato questo file il processo viene temporaneamente sospeso.
		 *
		 * @return void
		 */
		function checkEmergencyFile() 
		{
			$options = $this->getOptions();

			// Se opzione di emergenza risulta non attiva esco dalla funzione
			// altrimenti controllo esistenza del file in directory root

			if (!isset($options['authenticator_emergency']) or $options['authenticator_emergency'] != '1') {
				return false;
			} 

			// Calcolo il nome del file da controllare prendendo il valore di default o
			// il valore specificato nella configurazione generale di google authenticator

			if (trim($options['authenticator_emergency_file']) == '') $filename = ABSPATH.'google-authenticator-disable.php';
				else $filename = ABSPATH.trim($options['authenticator_emergency_file']);

			// Controllo esistenza del file google-authenticator-emergency.php

			if (file_exists($filename)) return true;
				else return false;
		}
	}

	/**
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 * DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE - DEVELOPER PHP CODE
	 */

	@require_once(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/functions/SZGoogleFunctionsAuthenticator.php');
}