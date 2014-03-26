<?php
/**
 * Modulo GOOGLE AUTHENTICATOR per la definizione delle funzioni che riguardano
 * sia i widget che i shortcode ma anche filtri e azioni che il modulo
 * può integrare durante l'aggiunta di funzionalità a wordpress.
 *
 * @package SZGoogle
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

/**
 * Prima della definizione della classe controllo se esiste
 * una definizione con lo stesso nome o già definita la stessa.
 */
if (!class_exists('SZGoogleAdminAuthenticator'))
{
	class SZGoogleAdminAuthenticator extends SZGoogleAdmin
	{
		/**
		 * Creazione del menu sul pannello di amministrazione usando
		 * come valori di configurazione le variabili object
		 *
		 * @return void
		 */
		function moduleAddMenu()
		{
			$this->menuslug   = 'sz-google-admin-authenticator.php';
			$this->pagetitle  = ucwords(__('google authenticator','szgoogleadmin'));
			$this->menutitle  = ucwords(__('google authenticator','szgoogleadmin'));

			// Definizione delle sezioni che devono essere composte in HTML
			// le sezioni devono essere passate come un array con nome => titolo

			$this->sections = array(
				'sz-google-admin-authenticator.php'     => ucwords(__('general settings','szgoogleadmin')),
			);

			$this->sectionstitle   = $this->menutitle;
			$this->sectionsoptions = 'sz_google_options_authenticator';

			// Richiamo la funzione della classe padre per elaborare le
			// variabili contenenti i valori di configurazione sezione

			parent::moduleAddMenu();
 		}

		/**
		 * Funzione per aggiungere i campi del form con la corrispondenza
		 * delle opzioni specificate nel modulo attualmente utilizzato
		 *
		 * @return void
		 */
		function moduleAddFields()
		{
			register_setting($this->sectionsoptions,$this->sectionsoptions);

			// Definizione sezione per configurazione GOOGLE AUTHENTICATOR

			add_settings_section('sz_google_authenticator_enabled','',$this->callbacksection,'sz-google-admin-authenticator.php');
			add_settings_field('authenticator_login_enable',ucfirst(__('enable login','szgoogleadmin')),array($this,'get_authenticator_login_enable'),'sz-google-admin-authenticator.php','sz_google_authenticator_enabled');
			add_settings_field('authenticator_discrepancy',ucfirst(__('discrepancy','szgoogleadmin')),array($this,'get_authenticator_discrepancy'),'sz-google-admin-authenticator.php','sz_google_authenticator_enabled');
		}

		/**
		 * Definizione delle funzioni per la creazione delle singole opzioni che vanno
		 * inserite nel form generale di configurazione e salvate sul database di wordpress
		 */
		function get_authenticator_login_enable() 
		{ 
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_authenticator','authenticator_login_enable');
			$this->moduleCommonFormDescription(__('enable this option to integrate the control of google authenticator in login panel. Deactivation is used to implement login with PHP functions in the case has been heavily customized. See online documentation for more details.','szgoogleadmin'));
		}

		function get_authenticator_discrepancy() 
		{ 
			$values = array(
				'1'  => __('30 seconds','szgoogleadmin'),
				'2'  => __('1 Minutes' ,'szgoogleadmin'),
				'4'  => __('2 Minutes' ,'szgoogleadmin'),
				'6'  => __('3 Minutes' ,'szgoogleadmin'),
				'8'  => __('4 Minutes' ,'szgoogleadmin'),
				'10' => __('5 Minutes' ,'szgoogleadmin')
			); 

			$this->moduleCommonFormSelect('sz_google_options_authenticator','authenticator_discrepancy',$values,'medium','');
			$this->moduleCommonFormDescription(__('indicate time of discrepancy that should be used by the plugin. This value indicates the time of tolerance that is applied to the generation of the authenticator code with respect to time auto-generation. Default value is 30 seconds.','szgoogleadmin'));
		}
	}
}