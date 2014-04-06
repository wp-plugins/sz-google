<?php
/**
 * Modulo GOOGLE PLUS per la definizione delle funzioni che riguardano
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
if (!class_exists('SZGoogleAdminPlus'))
{
	class SZGoogleAdminPlus extends SZGoogleAdmin
	{
		/**
		 * Definizione della funzione costruttore che viene richiamata
		 * nel momento della creazione di un'istanza con questa classe
		 */
		function __construct()
		{
			// Controllo le opzioni del modulo che riguardano i campi
			// da aggiungere sul profilo utente standard di wordpress

			if ($options = $this->getOptions()) {
				if ($options['plus_usercontact_page']      == SZ_PLUGIN_GOOGLE_VALUE_YES) $contacts = true;
				if ($options['plus_usercontact_community'] == SZ_PLUGIN_GOOGLE_VALUE_YES) $contacts = true;
				if ($options['plus_usercontact_bestpost']  == SZ_PLUGIN_GOOGLE_VALUE_YES) $contacts = true;
			}

			// Aggiungo il filtro su user contacts per modificare array
			// contenente i campi predefiniti di wordpress presenti sul profilo

			if (isset($contacts) && $contacts == true) {
				add_filter('user_contactmethods',array($this,'AddContactMethods'),90,1);
			}
			
			// Richiamo la funzione della classe padre per elaborare le
			// variabili contenenti i valori di configurazione sezione

			parent::__construct();
 		}

		/**
		 * Creazione menu nel pannello di amministrazione usando
		 * come valori di configurazione le variabili object
		 *
		 * @return void
		 */
		function moduleAddMenu()
		{
			$this->menuslug   = 'sz-google-admin-plus.php';
			$this->pagetitle  = ucwords(__('google+','szgoogleadmin'));
			$this->menutitle  = ucwords(__('google+','szgoogleadmin'));

			// Definizione delle sezioni che devono essere composte in HTML
			// le sezioni devono essere passate come un array con nome => titolo

			$this->sectionstabs = array(
				'01' => array('anchor' => 'general' ,'description' => __('general' ,'szgoogleadmin')),
				'02' => array('anchor' => 'badges'  ,'description' => __('badges'  ,'szgoogleadmin')),
				'03' => array('anchor' => 'buttons' ,'description' => __('buttons' ,'szgoogleadmin')),
				'04' => array('anchor' => 'comments','description' => __('comments','szgoogleadmin')),
				'05' => array('anchor' => 'author'  ,'description' => __('author'  ,'szgoogleadmin')),
				'06' => array('anchor' => 'redirect','description' => __('redirect','szgoogleadmin')),
			);

			$this->sections = array(
				array('tab' => '01','section' => 'sz-google-admin-plus.php'                ,'title' => ucwords(__('google+ ID'               ,'szgoogleadmin'))),
				array('tab' => '01','section' => 'sz-google-admin-plus-language.php'       ,'title' => ucwords(__('google+ language'         ,'szgoogleadmin'))),
				array('tab' => '01','section' => 'sz-google-admin-plus-post.php'           ,'title' => ucwords(__('google+ embedded post'    ,'szgoogleadmin'))), 
				array('tab' => '01','section' => 'sz-google-admin-plus-system.php'         ,'title' => ucwords(__('google+ system'           ,'szgoogleadmin'))),
				array('tab' => '02','section' => 'sz-google-admin-plus-shortcodes.php'     ,'title' => ucwords(__('google+ badge shortcodes' ,'szgoogleadmin'))),
				array('tab' => '02','section' => 'sz-google-admin-plus-widgets.php'        ,'title' => ucwords(__('google+ badge widget'     ,'szgoogleadmin'))),
				array('tab' => '03','section' => 'sz-google-admin-plus-buttons.php'        ,'title' => ucwords(__('google+ button shortcodes','szgoogleadmin'))), 
				array('tab' => '03','section' => 'sz-google-admin-plus-widgets-buttons.php','title' => ucwords(__('google+ button widgets'   ,'szgoogleadmin'))), 
				array('tab' => '04','section' => 'sz-google-admin-plus-comments.php'       ,'title' => ucwords(__('google+ comment system'   ,'szgoogleadmin'))), 
				array('tab' => '05','section' => 'sz-google-admin-plus-head.php'           ,'title' => ucwords(__('google+ HEAD'             ,'szgoogleadmin'))),
				array('tab' => '05','section' => 'sz-google-admin-plus-contacts.php'       ,'title' => ucwords(__('wordpress profile'        ,'szgoogleadmin'))),
				array('tab' => '06','section' => 'sz-google-admin-plus-redirect.php'       ,'title' => ucwords(__('google+ custom URL'       ,'szgoogleadmin'))),
			);

			$this->sectionstitle   = $this->menutitle;
			$this->sectionsoptions = 'sz_google_options_plus';

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

			// Definizione sezione per configurazione GOOGLE+

			add_settings_section('sz_google_plus_section','',$this->callbacksection,'sz-google-admin-plus.php');
			add_settings_field('plus_profile',ucwords(__('google+ Profile','szgoogleadmin')),array($this,'get_plus_profile'),'sz-google-admin-plus.php','sz_google_plus_section');
			add_settings_field('plus_page',ucwords(__('google+ Page','szgoogleadmin')),array($this,'get_plus_page'),'sz-google-admin-plus.php','sz_google_plus_section');
			add_settings_field('plus_community',ucwords(__('google+ Community','szgoogledmin')),array($this,'get_plus_community'),'sz-google-admin-plus.php','sz_google_plus_section');

			// Definizione sezione per configurazione GOOGLE+ LANGUAGE

			add_settings_section('sz_google_plus_language','',$this->callbacksection,'sz-google-admin-plus-language.php');
			add_settings_field('plus_language',ucfirst(__('select language','szgoogleadmin')),array($this,'get_plus_language'),'sz-google-admin-plus-language.php','sz_google_plus_language');

			// Definizione sezione per configurazione GOOGLE+ EMBEDDED POST

			add_settings_section('sz_google_plus_post','',$this->callbacksection,'sz-google-admin-plus-post.php');
			add_settings_field('plus_post_enable_widget'   ,ucwords(__('g+ post widget','szgoogleadmin')),array($this,'get_plus_post_widget'),'sz-google-admin-plus-post.php','sz_google_plus_post');
			add_settings_field('plus_post_enable_shortcode',ucwords(__('g+ post shortcode','szgoogleadmin')),array($this,'get_plus_post_shortcode'),'sz-google-admin-plus-post.php','sz_google_plus_post');

			// Definizione sezione per configurazione GOOGLE+ SYSTEM

			add_settings_section('sz_google_plus_system','',$this->callbacksection,'sz-google-admin-plus-system.php');
			add_settings_field('plus_enable_recommendations',ucwords(__('recommendations for mobile','szgoogleadmin')),array($this,'get_plus_enable_recommendations'),'sz-google-admin-plus-system.php','sz_google_plus_system');
			add_settings_field('plus_system_javascript'     ,ucwords(__('disable file javascript','szgoogleadmin')),array($this,'get_plus_system_javascript'),'sz-google-admin-plus-system.php','sz_google_plus_system');

			// Definizione sezione per configurazione GOOGLE+ BADGE WIDGETS

			add_settings_section('sz_google_plus_widgets','',$this->callbacksection,'sz-google-admin-plus-widgets.php');
			add_settings_field('plus_widget_pr_enable'     ,ucwords(__('widget G+ profile','szgoogleadmin')),array($this,'get_plus_widget_profile'),'sz-google-admin-plus-widgets.php','sz_google_plus_widgets');
			add_settings_field('plus_widget_pa_enable'     ,ucwords(__('widget G+ page','szgoogleadmin')),array($this,'get_plus_widget_page'),'sz-google-admin-plus-widgets.php','sz_google_plus_widgets');
			add_settings_field('plus_widget_co_enable'     ,ucwords(__('widget G+ community','szgoogleadmin')),array($this,'get_plus_widget_community'),'sz-google-admin-plus-widgets.php','sz_google_plus_widgets');
			add_settings_field('plus_widget_fl_enable'     ,ucwords(__('widget G+ followers','szgoogleadmin')),array($this,'get_plus_widget_followers'),'sz-google-admin-plus-widgets.php','sz_google_plus_widgets');
			add_settings_field('plus_widget_size_portrait' ,ucwords(__('widget width portrait','szgoogleadmin')),array($this,'get_plus_widget_size_portrait'),'sz-google-admin-plus-widgets.php','sz_google_plus_widgets');
			add_settings_field('plus_widget_size_landscape',ucwords(__('widget width landscape','szgoogleadmin')),array($this,'get_plus_widget_size_landscape'),'sz-google-admin-plus-widgets.php','sz_google_plus_widgets');

			// Definizione sezione per configurazione GOOGLE+ BADGE SHORTCODE

			add_settings_section('sz_google_plus_shortcodes','',$this->callbacksection,'sz-google-admin-plus-shortcodes.php');
			add_settings_field('plus_shortcode_pr_enable'     ,ucwords(__('shortcode G+ profile','szgoogleadmin')),array($this,'get_plus_shortcode_profile'),'sz-google-admin-plus-shortcodes.php','sz_google_plus_shortcodes');
			add_settings_field('plus_shortcode_pa_enable'     ,ucwords(__('shortcode G+ page','szgoogleadmin')),array($this,'get_plus_shortcode_page'),'sz-google-admin-plus-shortcodes.php','sz_google_plus_shortcodes');
			add_settings_field('plus_shortcode_co_enable'     ,ucwords(__('shortcode G+ community','szgoogleadmin')),array($this,'get_plus_shortcode_community'),'sz-google-admin-plus-shortcodes.php','sz_google_plus_shortcodes');
			add_settings_field('plus_shortcode_fl_enable'     ,ucwords(__('shortcode G+ followers','szgoogleadmin')),array($this,'get_plus_shortcode_followers'),'sz-google-admin-plus-shortcodes.php','sz_google_plus_shortcodes');
			add_settings_field('plus_shortcode_size_portrait' ,ucwords(__('shortcode width portrait','szgoogleadmin')),array($this,'get_plus_shortcode_size_portrait'),'sz-google-admin-plus-shortcodes.php','sz_google_plus_shortcodes');
			add_settings_field('plus_shortcode_size_landscape',ucwords(__('shortcode width landscape','szgoogleadmin')),array($this,'get_plus_shortcode_size_landscape'),'sz-google-admin-plus-shortcodes.php','sz_google_plus_shortcodes');

			// Definizione sezione per configurazione GOOGLE+ BUTTON WIDGETS

			add_settings_section('sz_google_plus_widgets_buttons','',$this->callbacksection,'sz-google-admin-plus-widgets-buttons.php');
			add_settings_field('plus_button_enable_widget_plusone',ucwords(__('widget g+ plusone','szgoogleadmin')),array($this,'get_plus_widget_button_plusone'),'sz-google-admin-plus-widgets-buttons.php','sz_google_plus_widgets_buttons');
			add_settings_field('plus_button_enable_widget_sharing',ucwords(__('widget g+ sharing','szgoogleadmin')),array($this,'get_plus_widget_button_sharing'),'sz-google-admin-plus-widgets-buttons.php','sz_google_plus_widgets_buttons');
			add_settings_field('plus_button_enable_widget_follow' ,ucwords(__('widget g+ follow' ,'szgoogleadmin')),array($this,'get_plus_widget_button_follow') ,'sz-google-admin-plus-widgets-buttons.php','sz_google_plus_widgets_buttons');

			// Definizione sezione per configurazione GOOGLE+ BUTTON SHORTCODE

			add_settings_section('sz_google_plus_buttons','',$this->callbacksection,'sz-google-admin-plus-buttons.php');
			add_settings_field('plus_button_enable_plusone',ucwords(__('shortcode g+ plusone','szgoogleadmin')),array($this,'get_plus_button_plusone'),'sz-google-admin-plus-buttons.php','sz_google_plus_buttons');
			add_settings_field('plus_button_enable_sharing',ucwords(__('shortcode g+ sharing','szgoogleadmin')),array($this,'get_plus_button_sharing'),'sz-google-admin-plus-buttons.php','sz_google_plus_buttons');
			add_settings_field('plus_button_enable_follow' ,ucwords(__('shortcode g+ follow' ,'szgoogleadmin')),array($this,'get_plus_button_follow') ,'sz-google-admin-plus-buttons.php','sz_google_plus_buttons');

			// Definizione sezione per configurazione GOOGLE+ COMMENTS

			add_settings_section('sz_google_plus_comments','',$this->callbacksection,'sz-google-admin-plus-comments.php');
			add_settings_field('plus_comments_gp_enable'   ,ucwords(__('enable G+ comments','szgoogleadmin')),      array($this,'get_plus_comments_gp'),         'sz-google-admin-plus-comments.php','sz_google_plus_comments');
			add_settings_field('plus_comments_wp_enable'   ,ucwords(__('enable WP comments','szgoogleadmin')),      array($this,'get_plus_comments_wp'),         'sz-google-admin-plus-comments.php','sz_google_plus_comments');
			add_settings_field('plus_comments_ac_enable'   ,ucwords(__('comments after content','szgoogleadmin')),  array($this,'get_plus_comments_ac'),         'sz-google-admin-plus-comments.php','sz_google_plus_comments');
			add_settings_field('plus_comments_aw_enable'   ,ucwords(__('comments after WP system','szgoogleadmin')),array($this,'get_plus_comments_aw'),         'sz-google-admin-plus-comments.php','sz_google_plus_comments');
			add_settings_field('plus_comments_wd_enable'   ,ucwords(__('comments widget','szgoogleadmin')),         array($this,'get_plus_comments_wd'),         'sz-google-admin-plus-comments.php','sz_google_plus_comments');
			add_settings_field('plus_comments_sh_enable'   ,ucwords(__('comments shortcode','szgoogleadmin')),      array($this,'get_plus_comments_sh'),         'sz-google-admin-plus-comments.php','sz_google_plus_comments');
			add_settings_field('plus_comments_dt_enable'   ,ucwords(__('comments date switch','szgoogleadmin')),    array($this,'get_plus_comments_dt'),         'sz-google-admin-plus-comments.php','sz_google_plus_comments');
			add_settings_field('plus_comments_fixed_size'  ,ucwords(__('comments fixed size','szgoogleadmin')),     array($this,'get_plus_comments_fixed_size'), 'sz-google-admin-plus-comments.php','sz_google_plus_comments');
			add_settings_field('plus_comments_title'       ,ucwords(__('comments title','szgoogleadmin')),          array($this,'get_plus_comments_title'),      'sz-google-admin-plus-comments.php','sz_google_plus_comments');
			add_settings_field('plus_comments_css_class_1' ,ucwords(__('comments CSS class 1','szgoogleadmin')),    array($this,'get_plus_comments_css_class_1'),'sz-google-admin-plus-comments.php','sz_google_plus_comments');
			add_settings_field('plus_comments_css_class_2' ,ucwords(__('comments CSS class 2','szgoogleadmin')),    array($this,'get_plus_comments_css_class_2'),'sz-google-admin-plus-comments.php','sz_google_plus_comments');

			// Definizione sezione per configurazione GOOGLE+ HEAD

			add_settings_section('sz_google_plus_head','',$this->callbacksection,'sz-google-admin-plus-head.php');
			add_settings_field('plus_enable_author'        ,ucwords(__('enable HEAD Author','szgoogleadmin')),array($this,'get_plus_enable_author'),'sz-google-admin-plus-head.php','sz_google_plus_head');
			add_settings_field('plus_enable_publisher'     ,ucwords(__('enable HEAD Publisher','szgoogleadmin')),array($this,'get_plus_enable_publisher'),'sz-google-admin-plus-head.php','sz_google_plus_head');

			// Definizione sezione per configurazione GOOGLE+ CONTACTS

			add_settings_section('sz_google_plus_contacts','',$this->callbacksection,'sz-google-admin-plus-contacts.php');
			add_settings_field('plus_usercontact_page'     ,ucwords(__('add field G+ page'     ,'szgoogleadmin')),array($this,'get_plus_usercontact_page')     ,'sz-google-admin-plus-contacts.php','sz_google_plus_contacts');
			add_settings_field('plus_usercontact_community',ucwords(__('add field G+ community','szgoogleadmin')),array($this,'get_plus_usercontact_community'),'sz-google-admin-plus-contacts.php','sz_google_plus_contacts');
			add_settings_field('plus_usercontact_bestpost' ,ucwords(__('add field G+ best post','szgoogleadmin')),array($this,'get_plus_usercontact_bestpost') ,'sz-google-admin-plus-contacts.php','sz_google_plus_contacts');

			// Definizione sezione per configurazione GOOGLE+ REDIRECT

			add_settings_section('sz_google_plus_redirect','',$this->callbacksection,'sz-google-admin-plus-redirect.php');
			add_settings_field('plus_redirect_sign'        ,ucwords(__('enable redirect /+','szgoogleadmin')),array($this,'get_plus_redirect_sign'),'sz-google-admin-plus-redirect.php','sz_google_plus_redirect');
			add_settings_field('plus_redirect_sign_url'    ,ucwords(__('enable redirect /+ URL','szgoogleadmin')),array($this,'get_plus_redirect_sign_url'),'sz-google-admin-plus-redirect.php','sz_google_plus_redirect');
			add_settings_field('plus_redirect_plus'        ,ucwords(__('enable redirect /plus','szgoogleadmin')),array($this,'get_plus_redirect_plus'),'sz-google-admin-plus-redirect.php','sz_google_plus_redirect');
			add_settings_field('plus_redirect_plus_url'    ,ucwords(__('enable redirect /plus URL','szgoogleadmin')),array($this,'get_plus_redirect_plus_url'),'sz-google-admin-plus-redirect.php','sz_google_plus_redirect');
			add_settings_field('plus_redirect_curl'        ,ucwords(__('enable redirect URL','szgoogleadmin')),array($this,'get_plus_redirect_curl'),'sz-google-admin-plus-redirect.php','sz_google_plus_redirect');
			add_settings_field('plus_redirect_curl_source' ,ucwords(__('enable redirect URL source','szgoogleadmin')),array($this,'get_plus_redirect_curl_source'),'sz-google-admin-plus-redirect.php','sz_google_plus_redirect');
			add_settings_field('plus_redirect_curl_target' ,ucwords(__('enable redirect URL target','szgoogleadmin')),array($this,'get_plus_redirect_curl_target'),'sz-google-admin-plus-redirect.php','sz_google_plus_redirect');
		}

		/**
		 * Funzione wrapper per prendere le opzioni di configurazione
		 * inserite nel pannello di amministrazione che riguarda il modulo
		 *
		 * @return array
		 */
		function getOptions() {
			if (!is_a(SZGoogleModule::$SZGoogleModulePlus,'SZGoogleModulePlus')) return false;
				else return SZGoogleModule::$SZGoogleModulePlus->getOptions();			
		}

		/**
		 * Funzione che legge array dei contatti standard ed aggiunge i nuovi
		 * presenti nel plugin dopo aver trovato quello standard chiamato "googleplus"
		 *
		 * @return array
		 */
		function AddContactMethods($usercontacts)
		{
			// Creazione nuovo array per riempirlo con i dati che 
			// trovo in array originale più quelli presenti nel plugin

			$newcontacts = array();

			// Leggo sequenzialmente la variabile array dei contati originali e
			// come trovo quello standard di G+ aggiungo sotto quelli personalizzati

			foreach ($usercontacts as $key => $value) {
				$newcontacts[$key] = $value;
				if ($key == 'googleplus') $newcontacts = $this->AddContactMethodsPlus($newcontacts);
			}	

			// Richiamo la funzione per una seconda volta in quanto potrebbe esistere
			// il caso che qualche plugin abbia rimosso il campo standard di G+

			return $this->AddContactMethodsPlus($newcontacts);
		}

		/**
		 * Funzione che legge array dei contatti standard ed aggiunge i nuovi
		 * presenti nel plugin dopo aver trovato quello standard chiamato "googleplus"
		 *
		 * @return array
		 */
		function AddContactMethodsPlus($usercontacts) 
		{
			if ($options = $this->getOptions()) {
				if (!isset($usercontacts['googlepluspage'])      && $options['plus_usercontact_page']      == SZ_PLUGIN_GOOGLE_VALUE_YES) $usercontacts['googlepluspage']      = __('Google+ Page','szgoogleadmin');
				if (!isset($usercontacts['googlepluscommunity']) && $options['plus_usercontact_community'] == SZ_PLUGIN_GOOGLE_VALUE_YES) $usercontacts['googlepluscommunity'] = __('Google+ Community','szgoogleadmin');
				if (!isset($usercontacts['googleplusbestpost'])  && $options['plus_usercontact_bestpost']  == SZ_PLUGIN_GOOGLE_VALUE_YES) $usercontacts['googleplusbestpost']  = __('Google+ Best post','szgoogleadmin');
			}

			return $usercontacts;
		}

		/**
		 * Definizione delle funzioni per la creazione delle singole opzioni che vanno
		 * inserite nel form generale di configurazione e salvate sul database di wordpress
		 */
		function get_plus_profile()
		{
			$this->moduleCommonFormText('sz_google_options_plus','plus_profile','medium',__('insert ID your profile','szgoogleadmin'));
			$this->moduleCommonFormDescription(__('enter the code that identifies the profile on google+, get to know the code of a profile just look at the profile link and copy the 21 digit number located on the URL string. For example a profile ID is 106189723444098348646.','szgoogleadmin'));
		}

		function get_plus_page() 
		{
			$this->moduleCommonFormText('sz_google_options_plus','plus_page','medium',__('insert ID your page','szgoogleadmin'));
			$this->moduleCommonFormDescription(__('enter the code that identifies the page on google+, get to know the code of a profile just look at the page link and copy the 21 digit number located on the URL string. For example a page ID is 117259631219963935481.','szgoogleadmin'));
		}

		function get_plus_community() 
		{
			$this->moduleCommonFormText('sz_google_options_plus','plus_community','medium',__('insert ID your community','szgoogleadmin'));
			$this->moduleCommonFormDescription(__('enter the code that identifies the community, get to know the code of a community just look at the link and copy the 21 digit number located on the URL string. For example a community ID is 109254048492234113886.','szgoogleadmin'));
		}

		function get_plus_language() 
		{
			$values = SZGooglePluginCommon::getLanguages();
			$this->moduleCommonFormSelect('sz_google_options_plus','plus_language',$values,'medium','');
			$this->moduleCommonFormDescription(__('specify the language code associated with your website, if you do not specify any value will be called the get_bloginfo(\'language\') and set the same language related to the theme of wordpress.','szgoogleadmin'));
		}

		function get_plus_post_widget() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_plus','plus_post_enable_widget');
			$this->moduleCommonFormDescription(__('if you need to insert the component for embedded post to google+ in a sidebar you can activate this option and use the new widget that you will find in your admin panel, you specify the size or the way you use responsive design for automatic resize.','szgoogleadmin'));
		}

		function get_plus_post_shortcode() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_plus','plus_post_enable_shortcode');
			$this->moduleCommonFormDescription(__('enabling this option will allow you to use the shortcode [sz-gplus-post] that will allow you to insert a box for embedded post to google plus in any part of your post or page standard wordpress.','szgoogleadmin'));
		}

		function get_plus_enable_recommendations() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_plus','plus_enable_recommendations');
			$this->moduleCommonFormDescription(__('google+ content recommendations combines search with social data to greet mobile visitors with additional relevant recommended content on your site. You will add markup to link your web page to your Google+ Page and to load a JavaScript file.','szgoogleadmin'));
		}

		function get_plus_system_javascript() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_plus','plus_system_javascript');
			$this->moduleCommonFormDescription(__('if you use some plugin that performs functions similar to sz-google for wordpress is possible that we might create a conflict retrieving files javascript google, enabling this option will be disabled loadings code javascript from our plugin.','szgoogleadmin'));
		}

		/**
		 * Definizione delle funzioni per la creazione delle singole opzioni che vanno
		 * inserite nel form generale di configurazione e salvate sul database di wordpress
		 */
		function get_plus_widget_profile() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_plus','plus_widget_pr_enable');
			$this->moduleCommonFormDescription(__('enabling this option will be included in the admin panel a new widget that will allow the insertion of a badge for the user profiles present on google+. If you want to see the graphic result of badges provided by google read the official documentation.','szgoogleadmin'));
		}

		function get_plus_widget_page() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_plus','plus_widget_pa_enable');
			$this->moduleCommonFormDescription(__('enabling this option will be included in the admin panel a new widget that will allow the insertion of a badge for the pages present on google+. If you want to see the graphic result of badges provided by google read the official documentation</a>.','szgoogleadmin'));
		}

		function get_plus_widget_community() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_plus','plus_widget_co_enable');
			$this->moduleCommonFormDescription(__('enabling this option will be included in the admin panel a new widget that will allow the insertion of a badge for the community present on google+. If you want to see the graphic result of badges provided by google read the official documentation</a>.','szgoogleadmin'));
		}

		function get_plus_widget_followers() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_plus','plus_widget_fl_enable');
			$this->moduleCommonFormDescription(__('enabling this option will be included in the admin panel a new widget that will allow the insertion of a badge for the followers present on google+. If you want to see the graphic result of badges provided by google read the official documentation.','szgoogleadmin'));
		}

		function get_plus_widget_size_portrait()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_plus','plus_widget_size_portrait','medium',SZ_PLUGIN_GOOGLE_PLUS_WIDGET_SIZE_PORTRAIT);
			$this->moduleCommonFormDescription(__('this option is used to set a default width for use in widget when no size is set manually and is selected as the display mode portrait. If you do not specify a value for this field will be used the standard width of 180px and height will be calculated.','szgoogleadmin'));
		}

		function get_plus_widget_size_landscape() 
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_plus','plus_widget_size_landscape','medium',SZ_PLUGIN_GOOGLE_PLUS_WIDGET_SIZE_LANDSCAPE);
			$this->moduleCommonFormDescription(__('this option is used to set a default width for use in widget when no size is set manually and is selected as the display mode landscape. If you do not specify a value for this field will be used the standard width of 275px and height will be automatically.','szgoogleadmin'));
		}

		function get_plus_shortcode_profile() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_plus','plus_shortcode_pr_enable');
			$this->moduleCommonFormDescription(__('enabling this option will be included in the admin panel a new shortcode that will allow the insertion of a badge for the user profiles present on google+. If you want to see the graphic result of badges provided by google read the official documentation.','szgoogleadmin'));
		}

		function get_plus_shortcode_page() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_plus','plus_shortcode_pa_enable');
			$this->moduleCommonFormDescription(__('enabling this option will be included in the admin panel a new shortcode that will allow the insertion of a badge for the pages present on google+. If you want to see the graphic result of badges provided by google read the official documentation.','szgoogleadmin'));
		}

		function get_plus_shortcode_community() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_plus','plus_shortcode_co_enable');
			$this->moduleCommonFormDescription(__('enabling this option will be included in the admin panel a new shortcode that will allow the insertion of a badge for the community present on google+. If you want to see the graphic result of badges provided by google read the official documentation.','szgoogleadmin'));
		}

		function get_plus_shortcode_followers() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_plus','plus_shortcode_fl_enable');
			$this->moduleCommonFormDescription(__('enabling this option will be included in the admin panel a new shortcode that will allow the insertion of a badge for the followers present on google+. If you want to see the graphic result of badges provided by google read the official documentation.','szgoogleadmin'));
		}

		function get_plus_shortcode_size_portrait() 
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_plus','plus_shortcode_size_portrait','medium',SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_SIZE_PORTRAIT);
			$this->moduleCommonFormDescription(__('this option is used to set a default width for use in widget when no size is set manually and is selected as the display mode portrait. If you do not specify a value for this field will be used the standard width of 350px and height will be calculated.','szgoogleadmin'));
		}

		function get_plus_shortcode_size_landscape() 
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_plus','plus_shortcode_size_landscape','medium',SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_SIZE_LANDSCAPE);
			$this->moduleCommonFormDescription(__('this option is used to set a default width for use in widget when no size is set manually and is selected as the display mode landscape. If you do not specify a value for this field will be used the standard width of 350px and height will be calculated.','szgoogleadmin'));
		}

		/**
		 * Definizione delle funzioni per la creazione delle singole opzioni che vanno
		 * inserite nel form generale di configurazione e salvate sul database di wordpress
		 */
		function get_plus_widget_button_plusone() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_plus','plus_button_enable_widget_plusone');
			$this->moduleCommonFormDescription(__('with this option is activated widget that allows the insertion of a +1 button in our article or web page. The +1 button has the same function as the button like this on facebook. If you want to customize the position in the theme use the function PHP.','szgoogleadmin'));
		}

		function get_plus_widget_button_sharing() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_plus','plus_button_enable_widget_sharing');
			$this->moduleCommonFormDescription(__('this option allows the activation of widget for sharing a link on social network google+. Using this function you can insert the button in an article or a page wordpress. If you want to customize the position in the theme use the function PHP.','szgoogleadmin'));
		}

		function get_plus_widget_button_follow() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_plus','plus_button_enable_widget_follow');
			$this->moduleCommonFormDescription(__('this option allows the activation of widget for follow on social network google+. Using this function you can insert the button in an article or a page wordpress. If you want to customize the position in the theme use the function PHP.','szgoogleadmin'));
		}

		function get_plus_button_plusone() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_plus','plus_button_enable_plusone');
			$this->moduleCommonFormDescription(__('with this option is activated shortcode that allows the insertion of a +1 button in our article or web page. The +1 button has the same function as the button like this on facebook. If you want to customize the position in the theme use the function PHP.','szgoogleadmin'));
		}

		function get_plus_button_sharing() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_plus','plus_button_enable_sharing');
			$this->moduleCommonFormDescription(__('this option allows the activation of shortcode for sharing a link on social network google+. Using this function you can insert the button in an article or a page wordpress. If you want to customize the position in the theme use the function PHP.','szgoogleadmin'));
		}

		function get_plus_button_follow() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_plus','plus_button_enable_follow');
			$this->moduleCommonFormDescription(__('this option allows the activation of shortcode for follow on social network google+. Using this function you can insert the button in an article or a page wordpress. If you want to customize the position in the theme use the function PHP.','szgoogleadmin'));
		}

		/**
		 * Definizione delle funzioni per la creazione delle singole opzioni che vanno
		 * inserite nel form generale di configurazione e salvate sul database di wordpress
		 */
		function get_plus_comments_gp() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_plus','plus_comments_gp_enable');
			$this->moduleCommonFormDescription(__('if you enable this feature will be added to the new commenting system made ​​available on the social network google+. The widget will be placed in the standard location for comments to wordpress. For customizations use the function PHP.','szgoogleadmin'));
		}

		function get_plus_comments_wp() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_plus','plus_comments_wp_enable');
			$this->moduleCommonFormDescription(__('activating this option you can activate the system\'s comments Wodpress same time as those of google+. To decide the position of the comments you have to set the fields to follow. You can choose whether to place comments after the content or last.','szgoogleadmin'));
		}

		function get_plus_comments_ac() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_plus','plus_comments_ac_enable');
			$this->moduleCommonFormDescription(__('enabling this option, the comment system is generated immediately after the post content or web page, otherwise it is inserted at the point that the standard function is called of the comments of wordpress in the file of the active theme.','szgoogleadmin'));
		}

		function get_plus_comments_aw() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_plus','plus_comments_aw_enable');
			$this->moduleCommonFormDescription(__('enabling this option, the comment system is generated immediately after standard comments, otherwise it is inserted at the point that the standard function is called of the comments of wordpress in the file of the active theme.','szgoogleadmin'));
		}

		function get_plus_comments_wd() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_plus','plus_comments_wd_enable');
			$this->moduleCommonFormDescription(__('if you need to insert the component for comments to google+ in a sidebar you can activate this option and use the new widget that you will find in your admin panel, you specify the size or the way you use responsive design for automatic resize.','szgoogleadmin'));
		}

		function get_plus_comments_sh() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_plus','plus_comments_sh_enable');
			$this->moduleCommonFormDescription(__('enabling this option will allow you to use the shortcode [sz-gplus-comments] that will allow you to insert a box for comments to google plus in any part of your post or page standard wordpress. For greater customization uses function PHP.','szgoogleadmin'));
		}

		function get_plus_comments_fixed_size()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_plus','plus_comments_fixed_size','medium',__('responsive design','szgoogleadmin'));
			$this->moduleCommonFormDescription(__('if you do not specify a value for this option, the size of the container of the comments will be performed in responsive mode, otherwise it is applied to a fixed size specified in this field. Use this option on wordpress themes with fixed size.','szgoogleadmin'));
		}

		function get_plus_comments_title()
		{
			$this->moduleCommonFormText('sz_google_options_plus','plus_comments_title','large',__('<h3>{title}</h3>','szgoogleadmin'));
			$this->moduleCommonFormDescription(__('Set this field to a string that identifies the creation of a first title of the widget for comments to google+. You can use html code and insert the variable with the name of {title}. If not given the title value for this field will be ignored and not printed.','szgoogleadmin'));
		}

		function get_plus_comments_css_class_1()
		{
			$this->moduleCommonFormText('sz_google_options_plus','plus_comments_css_class_1','large',__('name for CSS class (1)','szgoogleadmin'));
			$this->moduleCommonFormDescription(__('the widget comments has two wraps, each of these we can define the CSS style class that allow us to adapt the graphics of the comments to that of wordpress theme installed. Leave blank to not add any classes to the container of the comments.','szgoogleadmin'));
		}

		function get_plus_comments_css_class_2()
		{
			$this->moduleCommonFormText('sz_google_options_plus','plus_comments_css_class_2','large',__('name for CSS class (2)','szgoogleadmin'));
			$this->moduleCommonFormDescription(__('the widget comments has two wraps, each of these we can define the CSS style class that allow us to adapt the graphics of the comments to that of wordpress theme installed. Leave blank to not add any classes to the container of the comments.','szgoogleadmin'));
		}

		function get_plus_comments_dt() 
		{
			$this->moduleCommonFormCheckboxYesNo(
				'sz_google_options_plus','plus_comments_dt_enable'
			);

			// Creazione delle select per l'indicazione della data
	
			$date_format = __('MDA','szgoogleadmin');

			// Creazione delle select per l'indicazione della data

			if ($date_format == 'MDA') {
				$this->get_plus_comments_dt_month(); 
				$this->get_plus_comments_dt_day(); 
				$this->get_plus_comments_dt_year(); 
				echo '<span class="fieldtext">'.__('(month / day / year)','szgoogleadmin').'</span>';
			}

			if ($date_format == 'DMA') {
				$this->get_plus_comments_dt_day(); 
				$this->get_plus_comments_dt_month(); 
				$this->get_plus_comments_dt_year(); 
				echo '<span class="fieldtext">'.__('(day / month / year)','szgoogleadmin').'</span>';
			}

			if ($date_format == 'AMD') {
				$this->get_plus_comments_dt_year(); 
				$this->get_plus_comments_dt_month(); 
				$this->get_plus_comments_dt_day(); 
				echo '<span class="fieldtext">'.__('(year / month / day)','szgoogleadmin').'</span>';
			}

			$this->moduleCommonFormDescription(__('enabling this option you can activate the commenting system only posts that are inserted after a certain date. This function is useful for managing two different systems of comments in reference to a period of time.','szgoogleadmin'));
		}

		function get_plus_comments_dt_day() 
		{
			$options = get_option('sz_google_options_plus');

			if (!isset($options['plus_comments_dt_day']))   $options['plus_comments_dt_day']   = sprintf('%02d',date('d'));
			if (!isset($options['plus_comments_dt_month'])) $options['plus_comments_dt_month'] = sprintf('%02d',date('m')); 
			if (!isset($options['plus_comments_dt_year']))  $options['plus_comments_dt_year']  = sprintf('%04d',date('Y')); 

			// Creazione campo per giorno di selezione
	
			echo '<select name="sz_google_options_plus[plus_comments_dt_day]">';

			foreach (range(1,31) as $key) {
				$selected = ($options['plus_comments_dt_day'] == sprintf('%02d',$key)) ? ' selected = "selected"' : '';
				echo '<option value="'.sprintf('%02d',$key).'"'.$selected.'>'.sprintf('%02d',$key).'</option>';
			}

			echo '</select>';
		}

		function get_plus_comments_dt_month() 
		{
			$options = get_option('sz_google_options_plus');

			if (!isset($options['plus_comments_dt_day']))   $options['plus_comments_dt_day']   = sprintf('%02d',date('d'));
			if (!isset($options['plus_comments_dt_month'])) $options['plus_comments_dt_month'] = sprintf('%02d',date('m')); 
			if (!isset($options['plus_comments_dt_year']))  $options['plus_comments_dt_year']  = sprintf('%04d',date('Y')); 

			// Creazione campo per mese di selezione

			echo '<select name="sz_google_options_plus[plus_comments_dt_month]">';

			foreach (range(1,12) as $key) {
				$selected = ($options['plus_comments_dt_month'] == sprintf('%02d',$key)) ? ' selected = "selected"' : '';
				echo '<option value="'.sprintf('%02d',$key).'"'.$selected.'>'.sprintf('%02d',$key).'</option>';
			}

			echo '</select>';
		}

		function get_plus_comments_dt_year() 
		{
			$options = get_option('sz_google_options_plus');

			if (!isset($options['plus_comments_dt_day']))   $options['plus_comments_dt_day']   = sprintf('%02d',date('d'));
			if (!isset($options['plus_comments_dt_month'])) $options['plus_comments_dt_month'] = sprintf('%02d',date('m')); 
			if (!isset($options['plus_comments_dt_year']))  $options['plus_comments_dt_year']  = sprintf('%04d',date('Y')); 

			// Creazione campo per anno di selezione
	
			echo '<select name="sz_google_options_plus[plus_comments_dt_year]">';

			foreach (array_reverse(range(2000,date('Y')+1)) as $key) {
				$selected = ($options['plus_comments_dt_year'] == sprintf('%04d',$key)) ? ' selected = "selected"' : '';
				echo '<option value="'.sprintf('%04d',$key).'"'.$selected.'>'.sprintf('%04d',$key).'</option>';
			}

			echo '</select>';
		}

		/**
		 * Definizione delle funzioni per la creazione delle singole opzioni che vanno
		 * inserite nel form generale di configurazione e salvate sul database di wordpress
		 */
		function get_plus_enable_author() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_plus','plus_enable_author');
			$this->moduleCommonFormDescription(__('enabling this option will be placed in the HEAD section of the code necessary indication of the author connected to the current website and is generated string rel=author with the attribute href=author address.','szgoogleadmin'));
		}

		function get_plus_enable_publisher() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_plus','plus_enable_publisher');
			$this->moduleCommonFormDescription(__('enabling this option will be placed in the HEAD section of the code necessary indication of the publisher connected to the current website and is generated string rel=publisher with the attribute href=publisher address.','szgoogleadmin'));
		}

		function get_plus_usercontact_page() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_plus','plus_usercontact_page');
			$this->moduleCommonFormDescription(__('in the standard user profile wordpress is already a field that identifies the URL of your Google+ profile. By enabling this option you can add additional information that relates to Google+ and use it in your badges author present in your current theme.','szgoogleadmin'));
		}

		function get_plus_usercontact_community() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_plus','plus_usercontact_community');
			$this->moduleCommonFormDescription(__('in the standard user profile wordpress is already a field that identifies the URL of your Google+ profile. By enabling this option you can add additional information that relates to Google+ and use it in your badges author present in your current theme.','szgoogleadmin'));
		}

		function get_plus_usercontact_bestpost() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_plus','plus_usercontact_bestpost');
			$this->moduleCommonFormDescription(__('in the standard user profile wordpress is already a field that identifies the URL of your Google+ profile. By enabling this option you can add additional information that relates to Google+ and use it in your badges author present in your current theme.','szgoogleadmin'));
		}

		/**
		 * Definizione delle funzioni per la creazione delle singole opzioni che vanno
		 * inserite nel form generale di configurazione e salvate sul database di wordpress
		 */
		function get_plus_redirect_sign() {
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_plus','plus_redirect_sign');
			$this->moduleCommonFormDescription(__('with this option you can enable a rewrite rules that allows you to get a web address personalized pointing to the corresponding page on google plus such as mydomain.com/+. Activate this option and enter the complete link of the destination.','szgoogleadmin'));
		} 

		function get_plus_redirect_sign_url() 
		{
			$this->moduleCommonFormText('sz_google_options_plus','plus_redirect_sign_url','large',__('destination URL','szgoogleadmin'));
			$this->moduleCommonFormDescription(__('in this field you must enter the full URL for the landing page that describes the connection on google plus. In fact you can enter any URL even if the rewrite is designed for integration with google plus. Please make use of the most useful for your needs.','szgoogleadmin'));
		} 

		function get_plus_redirect_plus() {
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_plus','plus_redirect_plus');
			$this->moduleCommonFormDescription(__('with this option you can enable a rewrite rules that allows you to get a web address personalized pointing to the corresponding page on google plus such as mydomain.com/plus. Activate this option and enter the complete link of the destination.','szgoogleadmin'));
		} 

		function get_plus_redirect_plus_url() 
		{
			$this->moduleCommonFormText('sz_google_options_plus','plus_redirect_plus_url','large',__('destination URL','szgoogleadmin'));
			$this->moduleCommonFormDescription(__('in this field you must enter the full URL for the landing page that describes the connection on google plus. In fact you can enter any URL even if the rewrite is designed for integration with google plus. Please make use of the most useful for your needs.','szgoogleadmin'));
		} 

		function get_plus_redirect_curl() {
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_plus','plus_redirect_curl');
			$this->moduleCommonFormDescription(__('with this option you can enable a rewrite rules that allows you to get a web address personalized pointing to the corresponding page on google plus such as mydomain.com/origin. Activate this option and enter source and destination page.','szgoogleadmin'));
		} 

		function get_plus_redirect_curl_source() 
		{
			$this->moduleCommonFormText('sz_google_options_plus','plus_redirect_curl_dir','large',__('source path URL for redirect','szgoogleadmin'));
			$this->moduleCommonFormDescription(__('in this field you must enter the source partial URL of your domain on which to perform the rewrite rule. For example you can use as a value source URL string community/+ and associate the destination on a community present on google+.','szgoogleadmin'));
		}

		function get_plus_redirect_curl_target() 
		{
			$this->moduleCommonFormText('sz_google_options_plus','plus_redirect_curl_url','large',__('destination URL','szgoogleadmin'));
			$this->moduleCommonFormDescription(__('in this field you must enter the full URL for the landing page that describes the connection on google plus. In fact you can enter any URL even if the rewrite is designed for integration with google plus. Please make use of the most useful for your needs.','szgoogleadmin'));
		}
	}
}