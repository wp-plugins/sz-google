<?php
/**
 * Modulo GOOGLE ANALYTICS per la definizione delle funzioni che riguardano
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
if (!class_exists('SZGoogleAdminAnalytics'))
{
	class SZGoogleAdminAnalytics extends SZGoogleAdmin
	{
		/**
		 * Definizione della funzione costruttore che viene richiamata
		 * nel momento della creazione di un'istanza con questa classe
		 */
		function __construct()
		{
			// Controllo se devo inserire il codice di monitoraggio
			// di google analytics nel pannello di amministrazione

			$SZ_ANALYTICS_OBJECT_ADMIN = new SZGoogleModuleAnalytics();
			$SZ_ANALYTICS_OPTION_ADMIN = $SZ_ANALYTICS_OBJECT_ADMIN->getOptions();

			// Se sono sul pannello di amministrazione devo controllare se è stata
			// attivata l'opzione per abilitare il modulo su amministrazione 

			if (is_admin() and $SZ_ANALYTICS_OPTION_ADMIN['ga_enable_admin'] == '1') 
			{
				if ($SZ_ANALYTICS_OPTION_ADMIN['ga_position'] == 'H') 
					add_action('admin_head'  ,array($SZ_ANALYTICS_OBJECT_ADMIN,'moduleMonitorCode'));

				if ($SZ_ANALYTICS_OPTION_ADMIN['ga_position'] == 'F') 
					add_action('admin_footer',array($SZ_ANALYTICS_OBJECT_ADMIN,'moduleMonitorCode'));
			}

			// Richiamo la funzione della classe padre per elaborare le
			// variabili contenenti i valori di configurazione sezione

			parent::__construct();
 		}

		/**
		 * Creazione del menu sul pannello di amministrazione usando
		 * come valori di configurazione le variabili object
		 *
		 * @return void
		 */
		function moduleAddMenu()
		{
			$this->menuslug   = 'sz-google-admin-analytics.php';
			$this->pagetitle  = ucwords(__('google analytics','szgoogleadmin'));
			$this->menutitle  = ucwords(__('google analytics','szgoogleadmin'));

			// Definizione delle sezioni che devono essere composte in HTML
			// le sezioni devono essere passate come un array con nome => titolo

			$this->sectionstabs = array(
				'01' => array('anchor' => 'general','description' => __('general','szgoogleadmin')),
				'02' => array('anchor' => 'classic','description' => __('classic','szgoogleadmin')),
			);

			$this->sections = array(
				array('tab' => '01','section' => 'sz-google-admin-analytics.php'         ,'title' => ucwords(__('general settings','szgoogleadmin'))),
				array('tab' => '01','section' => 'sz-google-admin-analytics-enabled.php' ,'title' => ucwords(__('activation tracking code','szgoogleadmin'))),
				array('tab' => '02','section' => 'sz-google-admin-analytics-classic.php' ,'title' => ucwords(__('options for classic analytics','szgoogleadmin'))),
			);

			$this->sectionstitle   = $this->menutitle;
			$this->sectionsoptions = 'sz_google_options_ga';

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

			// Definizione sezione per configurazione GOOGLE ANALYTICS ID

			add_settings_section('sz_google_analytics_section','',$this->callbacksection,'sz-google-admin-analytics.php');
			add_settings_field('ga_uacode',ucfirst(__('UA code','szgoogleadmin')),array($this,'get_analytics_uacode'),'sz-google-admin-analytics.php','sz_google_analytics_section');
			add_settings_field('ga_position',ucfirst(__('position','szgoogleadmin')),array($this,'get_analytics_position'),'sz-google-admin-analytics.php','sz_google_analytics_section');
			add_settings_field('ga_type',ucfirst(__('type code analytics','szgoogleadmin')),array($this,'get_analytics_type'),'sz-google-admin-analytics.php','sz_google_analytics_section');

			// Definizione sezione per configurazione GOOGLE ANALYTICS ENABLED

			add_settings_section('sz_google_analytics_enabled','',$this->callbacksection,'sz-google-admin-analytics-enabled.php');
			add_settings_field('ga_enable_front',ucfirst(__('enable frontend','szgoogleadmin')),array($this,'get_analytics_enable_front'),'sz-google-admin-analytics-enabled.php','sz_google_analytics_enabled');
			add_settings_field('ga_enable_admin',ucfirst(__('enable admin panel','szgoogleadmin')),array($this,'get_analytics_enable_admin'),'sz-google-admin-analytics-enabled.php','sz_google_analytics_enabled');
			add_settings_field('ga_enable_admin_administrator',ucfirst(__('enable administrator','szgoogleadmin')),array($this,'get_analytics_enable_administrator'),'sz-google-admin-analytics-enabled.php','sz_google_analytics_enabled');
			add_settings_field('ga_enable_admin_logged',ucfirst(__('enable user logged','szgoogleadmin')),array($this,'get_analytics_enable_logged'),'sz-google-admin-analytics-enabled.php','sz_google_analytics_enabled');

			// Definizione sezione per configurazione GOOGLE ANALYTICS CLASSIC

			add_settings_section('sz_google_analytics_classic','',$this->callbacksection,'sz-google-admin-analytics-classic.php');
			add_settings_field('ga_enable_subdomains',ucfirst(__('enable tracking subdomains','szgoogleadmin')),array($this,'get_analytics_enable_subdomains'),'sz-google-admin-analytics-classic.php','sz_google_analytics_classic');
			add_settings_field('ga_enable_multiple',ucfirst(__('enable multiple top domains','szgoogleadmin')),array($this,'get_analytics_enable_multiple'),'sz-google-admin-analytics-classic.php','sz_google_analytics_classic');
			add_settings_field('ga_enable_advertiser',ucfirst(__('enable advertiser','szgoogleadmin')),array($this,'get_analytics_enable_advertiser'),'sz-google-admin-analytics-classic.php','sz_google_analytics_classic');
		}

		/**
		 * Definizione delle funzioni per la creazione delle singole opzioni che vanno
		 * inserite nel form generale di configurazione e salvate sul database di wordpress
		 */
		function get_analytics_uacode() 
		{
			$this->moduleCommonFormText('sz_google_options_ga','ga_uacode','medium',__('insert your UA code','szgoogleadmin'));
			$this->moduleCommonFormDescription(__('specify the code assigned to the profile of google analytics, to find enough to enter the admin panel google analytics and see the code assigned such as UA-12345-12. If this code is not specified will not be generated the tracking code for google analytics.','szgoogleadmin'));
		}

		function get_analytics_position() 
		{
			$values = array(
				'H' => __('header (default)','szgoogleadmin'),
				'F' => __('footer','szgoogleadmin'),
				'M' => __('insert manually','szgoogleadmin'),
			);

			$this->moduleCommonFormSelect('sz_google_options_ga','ga_position',$values,'medium','');
			$this->moduleCommonFormDescription(__('specifies the location of the tracking code in the page HTML. The recommended position is the header that does not allow the loss of access statistics. If you specify the manual mode you have to use szgoogle_analytics_get_code().','szgoogleadmin'));
		}

		function get_analytics_type() 
		{
			$values = array(
				'classic'   => __('google analytics classic','szgoogleadmin'),
				'universal' => __('google analytics universal','szgoogleadmin'),
			); 

			$this->moduleCommonFormSelect('sz_google_options_ga','ga_type',$values,'medium','');
			$this->moduleCommonFormDescription(__('universal Analytics introduces a set of features that change the way data is collected and organized in your Google Analytics account, so you can get a better understanding of how visitors interact with your online content.','szgoogleadmin'));
		}

		function get_analytics_enable_front() 
		{ 
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_ga','ga_enable_front');
			$this->moduleCommonFormDescription(__('enable this option to activate the tracking code to the public pages of your website. This option can also be used to disable the code without disabling the module. To check the tracking code on the basis of connected users use others options.','szgoogleadmin'));
		}

		function get_analytics_enable_admin() 
		{ 
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_ga','ga_enable_admin');
			$this->moduleCommonFormDescription(__('this option allows you to insert the tracking code in the admin pages. Useful function for some tests but not recommended during normal operation. Do not confuse this option with the administrator user which controls the type of user logged.','szgoogleadmin'));
		}

		function get_analytics_enable_administrator() 
		{ 
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_ga','ga_enable_administrator');
			$this->moduleCommonFormDescription(__('this option allows you to enter the tracking code when you browse the website as an administrator user. It is recommended to leave this option off as not to affect access statistics. This option is used for both the frontend and backend environment.','szgoogleadmin'));
		}

		function get_analytics_enable_logged() 
		{ 
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_ga','ga_enable_logged');
			$this->moduleCommonFormDescription(__('with this option, you can check the tracking code for users who are connected to the website. The behavior of this option is similar to option regarding the administrator user. This option is used for both the frontend and backend environment.','szgoogleadmin'));
		}

		function get_analytics_enable_subdomains() 
		{ 
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_ga','ga_enable_subdomains');
			$this->moduleCommonFormDescription(__('turn this option for track your subdomains. This option adds the _setDomainName function to your code. Use this function if you manage multiple domains as example www.domain.com, apps.domain.com and store.domain.com','szgoogleadmin'));
		}

		function get_analytics_enable_multiple() 
		{ 
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_ga','ga_enable_multiple');
			$this->moduleCommonFormDescription(__('turn this option on to track across multiple top-level domains. This option adds the _setDomainName and _setAllowLinker to tracking code. Use this function if you manage multiple domains as example domain.uk, domain.cn and domain.fr','szgoogleadmin'));
		}

		function get_analytics_enable_advertiser() 
		{ 
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_ga','ga_enable_advertiser');
			$this->moduleCommonFormDescription(__('turn this option for enable display advertiser support. This change is compatible with both the synchronous and asynchronous versions of the tracking code. This modification does not impact any customizations you have previously made to your code.','szgoogleadmin'));
		}
	}
}