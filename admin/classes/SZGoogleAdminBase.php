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
if (!class_exists('SZGoogleAdminBase'))
{
	class SZGoogleAdminBase extends SZGoogleAdmin
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


			// Aggiungo il link di setting nella descrizione di plugin presente
			// sul pannello di amministrazione dopo attivazione e disattivazione

			if (is_admin()) {
				add_filter("plugin_action_links_".plugin_basename(SZ_PLUGIN_GOOGLE_MAIN),array($this,'AddPluginSetting'));
			}

			// Aggiungere il foglio stile e gli script javsscript nelle 
			// pagine di amministrazione che servono al plugin stesso

			add_action('admin_enqueue_scripts',array($this,'moduleAdminAddStyles'));
			add_action('admin_enqueue_scripts',array($this,'moduleAdminAddScripts'));

			// Controllo le opzioni dei moduli da caricare e richiamo
			// il file di amministrazione necessario se risulta attivo

			$object  = new SZGoogleModule();
			$options = $object->getOptionsSet('sz_google_options_base');

			if ($options['plus']          == '1') new SZGoogleAdminPlus();
			if ($options['analytics']     == '1') new SZGoogleAdminAnalytics();
			if ($options['authenticator'] == '1') new SZGoogleAdminAuthenticator();
			if ($options['calendar']      == '1') new SZGoogleAdminCalendar();
			if ($options['drive']         == '1') new SZGoogleAdminDrive();
			if ($options['fonts']         == '1') new SZGoogleAdminFonts();
			if ($options['groups']        == '1') new SZGoogleAdminGroups();
			if ($options['hangouts']      == '1') new SZGoogleAdminHangouts();
			if ($options['panoramio']     == '1') new SZGoogleAdminPanoramio();
			if ($options['translate']     == '1') new SZGoogleAdminTranslate();
			if ($options['youtube']       == '1') new SZGoogleAdminYoutube();
			if ($options['documentation'] == '1') new SZGoogleAdminDocumentation();
 		}

		/**
		 * Creazione link aggiuntivi da inserire nello snippets del plugin
		 * presente nel pannello di amministrazione dopo active e deactive
		 *
		 * @return void
		 */
		function AddPluginSetting($links)
		{
			$links[] = '<a href="'.menu_page_url('sz-google-admin.php',false).'">'.ucfirst(__('settings','szgoogleadmin')).'</a>'; 
			return $links; 
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
				'sz-google-admin.php',array($this,'moduleCallbackStart'));

			$this->menuslug   = 'sz-google-admin.php';
			$this->pagetitle  = ucwords(__('configuration','szgoogleadmin'));
			$this->menutitle  = ucwords(__('configuration','szgoogleadmin'));

			// Definizione delle sezioni che devono essere composte in HTML
			// le sezioni devono essere passate come un array con nome => titolo

			$this->sectionstabs = array(
				'01' => array('anchor' => 'modules','description' => __('modules','szgoogleadmin')),
			);

			$this->sections = array(
				array('tab' => '01','section' => 'sz-google-admin.php','title' => ucwords(__('activation','szgoogleadmin'))),
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
			// Definizione array generale contenente elenco delle sezioni
			// Su ogni sezione bisogna definire un array per elenco campi

			$this->sectionsmenu = array(
				'01' => array('section' => 'sz_google_base_section','title' => $this->null,'callback' => $this->callbacksection,'slug' => 'sz-google-admin.php'),
			);

			// Definizione array generale contenente elenco dei campi
			// che bisogna aggiungere alle sezioni precedentemente definite

			$this->sectionsfields = array
			(
				'01' => array(
					array('field' => 'plus'         ,'title' => ucwords(__('google+'             ,'szgoogleadmin')),'callback' => array($this,'get_base_plus')),
					array('field' => 'analytics'    ,'title' => ucwords(__('google analytics'    ,'szgoogleadmin')),'callback' => array($this,'get_base_analytics')),
					array('field' => 'authenticator','title' => ucwords(__('google authenticator','szgoogleadmin')),'callback' => array($this,'get_base_authenticator')),
					array('field' => 'calendar'     ,'title' => ucwords(__('google calendar'     ,'szgoogleadmin')),'callback' => array($this,'get_base_calendar')),
					array('field' => 'drive'        ,'title' => ucwords(__('google drive'        ,'szgoogleadmin')),'callback' => array($this,'get_base_drive')),
					array('field' => 'fonts'        ,'title' => ucwords(__('google fonts'        ,'szgoogleadmin')),'callback' => array($this,'get_base_fonts')),
					array('field' => 'groups'       ,'title' => ucwords(__('google groups'       ,'szgoogleadmin')),'callback' => array($this,'get_base_groups')),
					array('field' => 'hangouts'     ,'title' => ucwords(__('google hangouts'     ,'szgoogleadmin')),'callback' => array($this,'get_base_hangouts')),
					array('field' => 'panoramio'    ,'title' => ucwords(__('google panoramio'    ,'szgoogleadmin')),'callback' => array($this,'get_base_panoramio')),
					array('field' => 'translate'    ,'title' => ucwords(__('google translate'    ,'szgoogleadmin')),'callback' => array($this,'get_base_translate')),
					array('field' => 'youtube'      ,'title' => ucwords(__('google youtube'      ,'szgoogleadmin')),'callback' => array($this,'get_base_youtube')),
					array('field' => 'documentation','title' => ucwords(__('documentation '      ,'szgoogleadmin')),'callback' => array($this,'get_base_documentation')),
				),
			);

			// Richiamo la funzione della classe padre per elaborare le
			// variabili contenenti i valori di configurazione sezione

			parent::moduleAddFields();
		}

		/**
		 * Aggiungere la registrazione dei fogli stile nelle 
		 * pagine di amministrazione che servono al plugin stesso
		 *
		 * @return void
		 */
		function moduleAdminAddStyles() 
		{
			$pagenow   = $this->moduleAdminGetPageNow();
			$adminpage = $this->moduleAdminGetAdminPage();

			// Registrazione dei file CSS e dei file javascript che devono
			// essere caricati nella pagina in base alla funzione richiesta

			$CSS = plugin_dir_url(SZ_PLUGIN_GOOGLE_MAIN).'admin/files/css/sz-google-style-admin.css';

			wp_register_style ('sz-google-style-admin',$CSS,array(),SZ_PLUGIN_GOOGLE_VERSION);

			// Controllo le zone di caricamento file in base alle necessità
			// del plugin durante la visualizzazione delle pagine di amministrazione

			if ($pagenow == 'widgets.php' or $pagenow == 'customize.php') 
				$widgets = true; else $widgets = false;

			if ($pagenow == 'admin.php' && preg_match('#^sz-google#',$adminpage) === 1) 
				$optionpage = true; else $optionpage = false;

			// Controllo in che pagina di amministrazione mi trovo per 
			// caricare i componenti CSS e javascript solamente quando servono

			if ($widgets or $optionpage) {
				wp_enqueue_style('sz-google-style-admin');
			}
		}

		/**
		 * Aggiungere la registrazione degli script javascript nelle 
		 * pagine di amministrazione che servono al plugin stesso
		 *
		 * @return void
		 */
		function moduleAdminAddScripts() 
		{
			$pagenow   = $this->moduleAdminGetPageNow();
			$adminpage = $this->moduleAdminGetAdminPage();

			// Registrazione dei file CSS e dei file javascript che devono
			// essere caricati nella pagina in base alla funzione richiesta

			$JS1 = plugin_dir_url(SZ_PLUGIN_GOOGLE_MAIN).'admin/files/js/jquery.szgoogle.widgets.js';
			$JS2 = plugin_dir_url(SZ_PLUGIN_GOOGLE_MAIN).'admin/files/js/jquery.szgoogle.pages.js';

			wp_register_script('sz-google-javascript-widgets',$JS1);
			wp_register_script('sz-google-javascript-pages',$JS2);

			// Controllo le zone di caricamento file in base alle necessità
			// del plugin durante la visualizzazione delle pagine di amministrazione

			if ($pagenow == 'widgets.php' or $pagenow == 'customize.php') 
				$widgets = true; else $widgets = false;

			if ($pagenow == 'admin.php' && preg_match('#^sz-google#',$adminpage) === 1) 
				$optionpage = true; else $optionpage = false;

			// Controllo in che pagina di amministrazione mi trovo per 
			// caricare i componenti CSS e javascript solamente quando servono

			if ($widgets) {
				if (!did_action('wp_enqueue_media')) wp_enqueue_media();
				wp_enqueue_script('sz-google-javascript-widgets');
			}

			if ($optionpage) {
				wp_enqueue_script('sz-google-javascript-pages');
			}
		}

		/**
		 * Calcolo il nome della pagina di amministrazione attuale
		 * che può essere utile per il caricamento di moduli specifici
		 *
		 * @return string
		 */
		function moduleAdminGetPageNow() {
			global $pagenow;
			return $pagenow;
		}

		/**
		 * Calcolo il nome della pagina di amministrazione attuale
		 * che può essere utile per il caricamento di moduli specifici
		 *
		 * @return string
		 */
		function moduleAdminGetAdminPage() {
			if (isset($_GET['page'])) return $_GET['page']; 
				else return '';
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

		function get_base_authenticator() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_base','authenticator');
			$this->moduleCommonFormDescription(__('with this module you can enable two-factor authentication to be added to the standard wordpress. Before starting this option carefully read the documentation. Each authorized user must synchronize the code with a mobile device.','szgoogleadmin'));
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
}