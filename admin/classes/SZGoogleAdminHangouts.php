<?php
/**
 * Modulo GOOGLE HANGOUTS per la definizione delle funzioni che riguardano
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
if (!class_exists('SZGoogleAdminHangouts'))
{
	class SZGoogleAdminHangouts extends SZGoogleAdmin
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

			$this->sectionstabs = array(
				'01' => array('anchor' => 'general','description' => __('general','szgoogleadmin')),
			);

			$this->sections = array(
				array('tab' => '01','section' => 'sz-google-admin-hangouts-start.php','title' => ucwords(__('start hangout','szgoogleadmin'))),
			);

			$this->sectionstitle   = $this->menutitle;
			$this->sectionsoptions = array('sz_google_options_hangouts');

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
			// Definizione array generale contenente elenco delle sezioni
			// Su ogni sezione bisogna definire un array per elenco campi

			$this->sectionsmenu = array(
				'01' => array('section' => 'sz_google_hangouts_start','title' => $this->null,'callback' => $this->callbacksection,'slug' => 'sz-google-admin-hangouts-start.php'),
			);

			// Definizione array generale contenente elenco dei campi
			// che bisogna aggiungere alle sezioni precedentemente definite

			$this->sectionsfields = array
			(
				'01' => array(
					array('field' => 'hangouts_start_shortcode','title' => ucfirst(__('shortcode','szgoogleadmin')),'callback' => array($this,'get_hangouts_start_shortcode')),
					array('field' => 'hangouts_start_widget'   ,'title' => ucfirst(__('widget'   ,'szgoogleadmin')),'callback' => array($this,'get_hangouts_start_widget')),
				),
			);

			// Richiamo la funzione della classe padre per elaborare le
			// variabili contenenti i valori di configurazione sezione

			parent::moduleAddFields();
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
}