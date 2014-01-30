<?php
/**
 * Modulo GOOGLE BASE per la definizione delle funzioni che riguardano
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
if (!class_exists('SZGoogleModuleAdminBase'))
{
	define('SZ_PLUGIN_GOOGLE_ADMIN',true);
	define('SZ_PLUGIN_GOOGLE_ADMIN_BASENAME',basename(__FILE__));

	/**
	 * Definizione della classe principale da utilizzare per questo
	 * modulo. La classe deve essere una extends di SZGoogleAdminModule
	 * dove bisogna ridefinire il metodo per il calcolo delle opzioni.
	 */
	class SZGoogleModuleAdminBase extends SZGoogleModuleAdmin
	{
		/**
		 * Definizione della funzione costruttore che viene richiamata
		 * nel momento della creazione di un'istanza con questa classe
		 */
		function __construct()
		{
			// Richiamo la funzione della classe padre per elaborare le
			// variabili contenenti i valori di configurazione sezione

			parent::__construct();

			// Aggiungere il foglio stile e gli script javsscript nelle 
			// pagine di amministrazione che servono al plugin stesso

			add_action('admin_init',array($this,'moduleAdminInit'));

			// Controllo le opzioni dei moduli da caricare e richiamo
			// il file di amministrazione necessario se risulta attivo

			$object  = new SZGoogleModule();
			$options = $object->getOptions();

			if ($options['plus']          == '1') @require_once(dirname(__FILE__).'/sz-google-admin-plus.php');
			if ($options['analytics']     == '1') @require_once(dirname(__FILE__).'/sz-google-admin-analytics.php');
			if ($options['calendar']      == '1') @require_once(dirname(__FILE__).'/sz-google-admin-calendar.php');
			if ($options['drive']         == '1') @require_once(dirname(__FILE__).'/sz-google-admin-drive.php');
			if ($options['fonts']         == '1') @require_once(dirname(__FILE__).'/sz-google-admin-fonts.php');
			if ($options['groups']        == '1') @require_once(dirname(__FILE__).'/sz-google-admin-groups.php');
			if ($options['hangouts']      == '1') @require_once(dirname(__FILE__).'/sz-google-admin-hangouts.php');
			if ($options['panoramio']     == '1') @require_once(dirname(__FILE__).'/sz-google-admin-panoramio.php');
			if ($options['translate']     == '1') @require_once(dirname(__FILE__).'/sz-google-admin-translate.php');
			if ($options['youtube']       == '1') @require_once(dirname(__FILE__).'/sz-google-admin-youtube.php');
			if ($options['documentation'] == '1') @require_once(dirname(__FILE__).'/sz-google-admin-documentation.php');
 		}

 		/**
		 * Creazione del menu sul pannello di amministrazione usando
		 * come valori di configurazione le variabili object
		 *
		 * @return void
		 */
		function moduleAddMenu()
		{
			// Aggiungo il menu principale dove verranno aggiunti tutti i moduli
			// del plugin aggiuntivi con la funzione add_submenu_page()
	
			add_menu_page('SZ Google','SZ Google','manage_options',
				SZ_PLUGIN_GOOGLE_ADMIN_BASENAME,array($this,'moduleCallbackStart'));

			$this->menuslug   = SZ_PLUGIN_GOOGLE_ADMIN_BASENAME;
			$this->pagetitle  = ucwords(__('configuration','szgoogleadmin'));
			$this->menutitle  = ucwords(__('configuration','szgoogleadmin'));

			// Definizione delle sezioni che devono essere composte in HTML
			// le sezioni devono essere passate come un array con nome => titolo

			$this->sections = array(
				SZ_PLUGIN_GOOGLE_ADMIN_BASENAME => ucwords(__('activation modules','szgoogleadmin')),
			);

			$this->sectionstitle   = ucfirst(__('configuration version','szgoogleadmin').'&nbsp;'.SZ_PLUGIN_GOOGLE_VERSION);
			$this->sectionsoptions = 'sz_google_options_base';

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

			// Definizione sezione per configurazione generale

			add_settings_section('sz_google_base_section','',$this->callbacksection,SZ_PLUGIN_GOOGLE_ADMIN_BASENAME);
			add_settings_field('plus',ucfirst(__('google+','szgoogleadmin')),array($this,'get_base_plus'),SZ_PLUGIN_GOOGLE_ADMIN_BASENAME,'sz_google_base_section');
			add_settings_field('analytics',ucwords(__('google analytics','szgoogleadmin')),array($this,'get_base_analytics'),SZ_PLUGIN_GOOGLE_ADMIN_BASENAME,'sz_google_base_section');
			add_settings_field('calendar',ucwords(__('google calendar','szgoogleadmin')),array($this,'get_base_calendar'),SZ_PLUGIN_GOOGLE_ADMIN_BASENAME,'sz_google_base_section');
			add_settings_field('drive',ucwords(__('google drive','szgoogleadmin')),array($this,'get_base_drive'),SZ_PLUGIN_GOOGLE_ADMIN_BASENAME,'sz_google_base_section');
			add_settings_field('fonts',ucwords(__('google fonts','szgoogleadmin')),array($this,'get_base_fonts'),SZ_PLUGIN_GOOGLE_ADMIN_BASENAME,'sz_google_base_section');
			add_settings_field('groups',ucwords(__('google groups','szgoogleadmin')),array($this,'get_base_groups'),SZ_PLUGIN_GOOGLE_ADMIN_BASENAME,'sz_google_base_section');
			add_settings_field('hangouts',ucwords(__('google hangouts','szgoogleadmin')),array($this,'get_base_hangouts'),SZ_PLUGIN_GOOGLE_ADMIN_BASENAME,'sz_google_base_section');
			add_settings_field('panoramio',ucwords(__('google panoramio','szgoogleadmin')),array($this,'get_base_panoramio'),SZ_PLUGIN_GOOGLE_ADMIN_BASENAME,'sz_google_base_section');
			add_settings_field('translate',ucwords(__('google translate','szgoogleadmin')),array($this,'get_base_translate'),SZ_PLUGIN_GOOGLE_ADMIN_BASENAME,'sz_google_base_section');
			add_settings_field('youtube',ucwords(__('google youtube','szgoogleadmin')),array($this,'get_base_youtube'),SZ_PLUGIN_GOOGLE_ADMIN_BASENAME,'sz_google_base_section');
			add_settings_field('documentation',ucwords(__('documentation','szgoogleadmin')),array($this,'get_base_documentation'),SZ_PLUGIN_GOOGLE_ADMIN_BASENAME,'sz_google_base_section');
		}

		/**
		 * Aggiungere il foglio stile e gli script javsscript nelle 
		 * pagine di amministrazione che servono al plugin stesso
		 *
		 * @return void
		 */
		function moduleAdminInit() 
		{
			wp_register_style('sz-google-style-admin',SZ_PLUGIN_GOOGLE_PATH_CSS.'sz-google-style-admin.css');
			wp_enqueue_style('sz-google-style-admin');

			// Caricamento framework javasctipt per media uploader da
			// utilizzare nelle funzioni di scelta attachment come i widgets

			global $pagenow;

			if ($pagenow == 'widgets.php') 
			{
				if (!did_action('wp_enqueue_media')) wp_enqueue_media();
				wp_register_script('sz_google_javascript',SZ_PLUGIN_GOOGLE_PATH_JS.'sz-google.js');
				wp_enqueue_script('sz_google_javascript');
			}
		}

		/**
		 * Definizione delle funzioni per la creazione delle singole opzioni che vanno
		 * inserite nel form generale di configurazione e salvate sul database di wordpress
		 */
		function get_base_plus() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_base','plus');
			$this->moduleCommonFormDescription(__('with this module you can manage some widgets in the social network google+, for example, we can insert badge of the profiles, badge of the pages, badge of the community, buttons follow, buttons share, buttons +1, comments system and much more.','szgoogleadmin'));
		}

		function get_base_analytics() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_base','analytics');
			$this->moduleCommonFormDescription(__('activating this module can handle the tracking code present in google analytics, so as to store the access statistics related to our website. Once you have entered the tracking code, you can view hundreds of statistics from the admin panel of google analytics.','szgoogleadmin'));
		}

		function get_base_calendar()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_base','calendar');
			$this->moduleCommonFormDescription(__('activating this module you can get a widget and shortcode to insert one of the components of google calendar on your wordpress. You will find several options in the configuration screen to customize your best result.','szgoogleadmin'));
		}

		function get_base_drive()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_base','drive');
			$this->moduleCommonFormDescription(__('through this module you can insert into wordpress some features of google drive, you will find widgets and shortcodes to help you with this task. Obviously many functions can only work if you login with a valid account on google.','szgoogleadmin'));
		}

		function get_base_fonts()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_base','fonts');
			$this->moduleCommonFormDescription(__('with this module you can load into your wordpress theme fonts made ​​available on Google CDN. Simply select the desired font and HTML parts concerned. The plugin will automatically add all the necessary parts of the code.','szgoogleadmin'));
		}

		function get_base_groups() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_base','groups');
			$this->moduleCommonFormDescription(__('enabling this module you get a widget and a shortcode to perform embed on google groups. Then you can insert into a wordpress page or in a sidebar content navigable for a group. You can specify various customization options.','szgoogleadmin'));
		}

		function get_base_hangouts() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_base','hangouts');
			$this->moduleCommonFormDescription(__('activating this module you can use the functions for the hangouts of google. For example, you can insert the buttons for the start of hangout directly in the page of your site. You can also create a widget to put on your sidebar.','szgoogleadmin'));
		}

		function get_base_panoramio() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_base','panoramio');
			$this->moduleCommonFormDescription(__('through this module you can insert some features of photos panoramio, you will find widgets and shortcodes to help you with this task and use the functions in your favorite theme. You can also specify parameters for selecting user, group, tag etc.','szgoogleadmin'));
		}

		function get_base_translate() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_base','translate');
			$this->moduleCommonFormDescription(__('with this module you can place the widget for automatic content translate on your website made ​​available by google translate tools. The widget can be placed in the context of a post or a sidebar defined in your theme.','szgoogleadmin'));
		}

		function get_base_youtube() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_base','youtube');
			$this->moduleCommonFormDescription(__('with this module can be inserted in wordpress a video youtube, you can also use a widget to the inclusion of video in the sidebar on your theme. Through the options in the shortcode you can configure many parameters to customize the embed code.','szgoogleadmin'));
		}

		function get_base_documentation() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_base','documentation');
			$this->moduleCommonFormDescription(__('activating this option you can see the documentation in the main menu of this plugin with the parameters to be used in [shortcodes] or PHP functions provided. There is a series of boxes in alphabetical order.','szgoogleadmin'));
		}
	}

	/**
	 * Creazione oggetto principale per creazione ed elaborazione del
	 * modulo richiesto con azioni iniziali specificate nel costruttore
	 */
	$SZ_GOOGLE_ADMIN_BASE = new SZGoogleModuleAdminBase();
}