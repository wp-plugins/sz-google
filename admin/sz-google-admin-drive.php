<?php
/**
 * Modulo GOOGLE DRIVE per la definizione delle funzioni che riguardano
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
if (!class_exists('SZGoogleModuleAdminDrive'))
{
	/**
	 * Definizione della classe principale da utilizzare per questo
	 * modulo. La classe deve essere una extends di SZGoogleAdminModule
	 * dove bisogna ridefinire il metodo per il calcolo delle opzioni.
	 */
	class SZGoogleModuleAdminDrive extends SZGoogleModuleAdmin
	{
		/**
		 * Creazione del menu sul pannello di amministrazione usando
		 * come valori di configurazione le variabili object
		 *
		 * @return void
		 */
		function moduleAddMenu()
		{
			$this->menuslug   = 'sz-google-admin-drive.php';
			$this->pagetitle  = ucwords(__('google drive','szgoogleadmin'));
			$this->menutitle  = ucwords(__('google drive','szgoogleadmin'));

			// Definizione delle sezioni che devono essere composte in HTML
			// le sezioni devono essere passate come un array con nome => titolo

			$this->sections = array(
				'sz-google-admin-drive.php'                   => ucwords(__('general setting','szgoogleadmin')),
				'sz-google-admin-drive-savebutton-enable.php' => ucwords(__('save to drive button','szgoogleadmin')),
			);

			$this->sectionstitle   = ucfirst(__('google drive configuration','szgoogleadmin'));
			$this->sectionsoptions = 'sz_google_options_drive';

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

			// Definizione sezione per configurazione GOOGLE DRIVE

			add_settings_section('sz_google_drive_section','',$this->callbacksection,'sz-google-admin-drive.php');
			add_settings_field('drive_sitename',ucfirst(__('site name','szgoogleadmin')),array($this,'get_drive_sitename'),'sz-google-admin-drive.php','sz_google_drive_section');

			// Definizione sezione per configurazione GOOGLE DRIVE SAVE BUTTON

			add_settings_section('sz_google_drive_savebutton','',$this->callbacksection,'sz-google-admin-drive-savebutton-enable.php');
			add_settings_field('drive_savebutton_widget',ucwords(__('enable widget','szgoogleadmin')),array($this,'get_drive_savebutton_widget'),'sz-google-admin-drive-savebutton-enable.php','sz_google_drive_savebutton');
			add_settings_field('drive_savebutton_shortcode',ucwords(__('enable shortcode','szgoogleadmin')),array($this,'get_drive_savebutton_shortcode'),'sz-google-admin-drive-savebutton-enable.php','sz_google_drive_savebutton');
		}

		/**
		 * Definizione delle funzioni per la creazione delle singole opzioni che vanno
		 * inserite nel form generale di configurazione e salvate sul database di wordpress
		 */
		function get_drive_sitename() 
		{
			$this->moduleCommonFormText('sz_google_options_drive','drive_sitename','large',__('insert your site name','szgoogleadmin'));
			$this->moduleCommonFormDescription(__('some functions google drive require the information of the name of the site where the operation took place, you can use this field to customize the name, otherwise it will use the default value in wordpress. See general setting in wordpress admin panel.','szgoogleadmin'));
		}

		function get_drive_savebutton_widget() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_drive','drive_savebutton_widget');
			$this->moduleCommonFormDescription(__('if you enable this option you will find the widget required in the administration menu of your widget and you can plug it into any sidebar defined in your theme. If you disable this option, remember not to leave the widget connected to existing sidebar.','szgoogleadmin'));
		}

		function get_drive_savebutton_shortcode() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_drive','drive_savebutton_shortcode');
			$this->moduleCommonFormDescription(__('if you enable this option you can use the shortcode [sz-drive-save] and enter the corresponding component directly in your article or page. Normally in the shortcodes can be specified the options for customizations.','szgoogleadmin'));
		}
	}

	/**
	 * Creazione oggetto principale per creazione ed elaborazione del
	 * modulo richiesto con azioni iniziali specificate nel costruttore
	 */
	$SZ_GOOGLE_ADMIN_DRIVE = new SZGoogleModuleAdminDrive();
}