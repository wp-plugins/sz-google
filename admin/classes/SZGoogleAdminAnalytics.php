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
					add_action('admin_head',array(new SZGoogleActionAnalytics($this),'action'));

				if ($SZ_ANALYTICS_OPTION_ADMIN['ga_position'] == 'F') 
					add_action('admin_footer',array(new SZGoogleActionAnalytics($this),'action'));
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
				'01' => array('anchor' => 'general'  ,'description' => __('general'  ,'szgoogleadmin')),
				'02' => array('anchor' => 'classic'  ,'description' => __('classic'  ,'szgoogleadmin')),
				'03' => array('anchor' => 'universal','description' => __('universal','szgoogleadmin')),
			);

			$this->sections = array(
				array('tab' => '01','section' => 'sz-google-admin-analytics.php'          ,'title' => ucwords(__('settings','szgoogleadmin'))),
				array('tab' => '01','section' => 'sz-google-admin-analytics-enabled.php'  ,'title' => ucwords(__('tracking','szgoogleadmin'))),
				array('tab' => '02','section' => 'sz-google-admin-analytics-classic.php'  ,'title' => ucwords(__('classic analytics','szgoogleadmin'))),
				array('tab' => '03','section' => 'sz-google-admin-analytics-universal.php','title' => ucwords(__('universal analytics','szgoogleadmin'))),
			);

			$this->sectionstitle   = $this->menutitle;
			$this->sectionsoptions = array('sz_google_options_ga');

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
				'01' => array('section' => 'sz_google_analytics_section'  ,'title' => $this->null,'callback' => $this->callbacksection,'slug' => 'sz-google-admin-analytics.php'),
				'02' => array('section' => 'sz_google_analytics_enabled'  ,'title' => $this->null,'callback' => $this->callbacksection,'slug' => 'sz-google-admin-analytics-enabled.php'),
				'03' => array('section' => 'sz_google_analytics_classic'  ,'title' => $this->null,'callback' => $this->callbacksection,'slug' => 'sz-google-admin-analytics-classic.php'),
				'04' => array('section' => 'sz_google_analytics_universal','title' => $this->null,'callback' => $this->callbacksection,'slug' => 'sz-google-admin-analytics-universal.php'),
			);

			// Definizione array generale contenente elenco dei campi
			// che bisogna aggiungere alle sezioni precedentemente definite

			$this->sectionsfields = array
			(
				// Definizione sezione per configurazione GOOGLE ANALYTICS ID

				'01' => array(
					array('field' => 'ga_uacode'                    ,'title' => ucwords(__('UA code'             ,'szgoogleadmin')),'callback' => array($this,'get_analytics_uacode')),
					array('field' => 'ga_position'                  ,'title' => ucfirst(__('position'            ,'szgoogleadmin')),'callback' => array($this,'get_analytics_position')),
					array('field' => 'ga_type'                      ,'title' => ucfirst(__('type code'           ,'szgoogleadmin')),'callback' => array($this,'get_analytics_type')),
				),

				// Definizione sezione per configurazione GOOGLE ANALYTICS ENABLED

				'02' => array(
					array('field' => 'ga_enable_front'              ,'title' => ucfirst(__('frontend'            ,'szgoogleadmin')),'callback' => array($this,'get_analytics_enable_front')),
					array('field' => 'ga_enable_admin'              ,'title' => ucfirst(__('backend'             ,'szgoogleadmin')),'callback' => array($this,'get_analytics_enable_admin')),
					array('field' => 'ga_enable_admin_administrator','title' => ucfirst(__('administrator'       ,'szgoogleadmin')),'callback' => array($this,'get_analytics_enable_administrator')),
					array('field' => 'ga_enable_admin_logged'       ,'title' => ucfirst(__('user logged'         ,'szgoogleadmin')),'callback' => array($this,'get_analytics_enable_logged')),
				),

				// Definizione sezione per configurazione GOOGLE ANALYTICS CLASSIC

				'03' => array(
					array('field' => 'ga_enable_subdomains'         ,'title' => ucfirst(__('tracking subdomains' ,'szgoogleadmin')),'callback' => array($this,'get_analytics_enable_subdomains')),
					array('field' => 'ga_enable_multiple'           ,'title' => ucfirst(__('multiple top domains','szgoogleadmin')),'callback' => array($this,'get_analytics_enable_multiple')),
					array('field' => 'ga_enable_advertiser'         ,'title' => ucfirst(__('advertiser'          ,'szgoogleadmin')),'callback' => array($this,'get_analytics_enable_advertiser')),
				),

				// Definizione sezione per configurazione GOOGLE ANALYTICS UNIVERSAL

				'04' => array(
					array('field' => 'ga_enable_features'           ,'title' => ucfirst(__('display features'    ,'szgoogleadmin')),'callback' => array($this,'get_analytics_enable_features')),
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

		function get_analytics_enable_features() 
		{ 
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_ga','ga_enable_features');
			$this->moduleCommonFormDescription(__('Google Analytics Display Advertising is a collection of features that takes advantage of the DoubleClick cookie so you can do things like create remarketing lists, use demographic data and create segments based on demographic and interest data.','szgoogleadmin'));
		}
	}
}