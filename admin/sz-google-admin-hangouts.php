<?php
/**
 * Modulo GOOGLE HANGOUTS per la definizione delle funzioni che riguardano
 * sia i widget che i shortcode ma anche filtri e azioni che il modulo
 * può integrare durante l'aggiunta di funzionalità a wordpress.
 *
 * @package SZGoogle
 */
if (!defined('SZ_PLUGIN_GOOGLE_ADMIN') or !SZ_PLUGIN_GOOGLE_ADMIN) die();

/**
 * Prima della definizione della classe controllo se esiste
 * una definizione con lo stesso nome o già definita la stessa.
 */
if (!class_exists('SZGoogleModuleAdminHangouts'))
{
	/**
	 * Definizione della classe principale da utilizzare per questo
	 * modulo. La classe deve essere una extends di SZGoogleAdminModule
	 * dove bisogna ridefinire il metodo per il calcolo delle opzioni.
	 */
	class SZGoogleModuleAdminHangouts extends SZGoogleModuleAdmin
	{
		/**
		 * Creazione del menu sul pannello di amministrazione usando
		 * come valori di configurazione le variabili object
		 *
		 * @return void
		 */
		function moduleAddMenu()
		{
			$this->menuslug   = 'sz-google-admin-hangouts.php';
			$this->pagetitle  = ucwords(__('google hangouts','szgoogleadmin'));
			$this->menutitle  = ucwords(__('google hangouts','szgoogleadmin'));

			// Definizione delle sezioni che devono essere composte in HTML
			// le sezioni devono essere passate come un array con nome => titolo

			$this->sections = array(
				'sz-google-admin-hangouts-start.php' => ucwords(__('hangouts start button','szgoogleadmin')),
			);

			$this->sectionstitle   = ucfirst(__('google hangouts configuration','szgoogleadmin'));
			$this->sectionsoptions = 'sz_google_options_hangouts';

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
			register_setting($this->sectionsoptions,$this->sectionsoptions,$this->validate);

			// Definizione sezione per configurazione GOOGLE HANGOUTS

			add_settings_section('sz_google_hangouts_start','',$this->callbacksection,'sz-google-admin-hangouts-start.php');
			add_settings_field('hangouts_start_widget',ucwords(__('enable widget','szgoogleadmin')),array($this,'get_hangouts_start_widget'),'sz-google-admin-hangouts-start.php','sz_google_hangouts_start');
			add_settings_field('hangouts_start_shortcode',ucwords(__('enable shortcode','szgoogleadmin')),array($this,'get_hangouts_start_shortcode'),'sz-google-admin-hangouts-start.php','sz_google_hangouts_start');
		}

		/**
		 * Definizione delle funzioni per la creazione delle singole opzioni che vanno
		 * inserite nel form generale di configurazione e salvate sul database di wordpress
		 */
		function get_hangouts_start_widget()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_hangouts','hangouts_start_widget');
			$this->moduleCommonFormDescription(__('if you enable this option you will find the widget required in the administration menu of your widget and you can plug it into any sidebar defined in your theme. If you disable this option, remember not to leave the widget connected to existing sidebar.','szgoogleadmin'));
		}

		function get_hangouts_start_shortcode()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_hangouts','hangouts_start_shortcode');
			$this->moduleCommonFormDescription(__('if you enable this option you can use this shortcode and enter the corresponding components directly in your article or page. Normally in the shortcodes can be specified the options for customizations. See the documentation section.','szgoogleadmin'));
		}
	}

	/**
	 * Creazione oggetto principale per creazione ed elaborazione del
	 * modulo richiesto con azioni iniziali specificate nel costruttore
	 */
	$SZ_GOOGLE_ADMIN_HANGOUTS = new SZGoogleModuleAdminHangouts();
}