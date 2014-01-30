<?php
/**
 * Modulo GOOGLE TRANSLATE per la definizione delle funzioni che riguardano
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
if (!class_exists('SZGoogleModuleAdminTranslate'))
{
	/**
	 * Definizione della classe principale da utilizzare per questo
	 * modulo. La classe deve essere una extends di SZGoogleAdminModule
	 * dove bisogna ridefinire il metodo per il calcolo delle opzioni.
	 */
	class SZGoogleModuleAdminTranslate extends SZGoogleModuleAdmin
	{
		/**
		 * Creazione del menu sul pannello di amministrazione usando
		 * come valori di configurazione le variabili object
		 *
		 * @return void
		 */
		function moduleAddMenu()
		{
			$this->menuslug   = 'sz-google-admin-translate.php';
			$this->pagetitle  = ucwords(__('google translate','szgoogleadmin'));
			$this->menutitle  = ucwords(__('google translate','szgoogleadmin'));

			// Definizione delle sezioni che devono essere composte in HTML
			// le sezioni devono essere passate come un array con nome => titolo

			$this->sections = array(
				'sz-google-admin-translate.php'          => ucwords(__('general setting','szgoogleadmin')),
				'sz-google-admin-translate-language.php' => ucwords(__('language setting','szgoogleadmin')),
				'sz-google-admin-translate-enable.php'   => ucwords(__('activation components','szgoogleadmin')),
				'sz-google-admin-translate-advanced.php' => ucwords(__('advanced setting','szgoogleadmin')),
			);

			$this->sectionstitle   = ucfirst(__('google translate configuration','szgoogleadmin'));
			$this->sectionsoptions = 'sz_google_options_translate';

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

			// Definizione sezione per configurazione GOOGLE TRANSLATE ID

			add_settings_section('sz_google_translate_section','',$this->callbacksection,'sz-google-admin-translate.php');
			add_settings_field('translate_meta',ucfirst(__('code for META','szgoogleadmin')),array($this,'get_translate_meta'),'sz-google-admin-translate.php','sz_google_translate_section');
			add_settings_field('translate_mode',ucfirst(__('display mode','szgoogleadmin')),array($this,'get_translate_mode'),'sz-google-admin-translate.php','sz_google_translate_section');

			// Definizione sezione per configurazione GOOGLE TRANSLATE LANGUAGE

			add_settings_section('sz_google_translate_language','',$this->callbacksection,'sz-google-admin-translate-language.php');
			add_settings_field('translate_language',ucfirst(__('website language','szgoogleadmin')),array($this,'get_translate_language'),'sz-google-admin-translate-language.php','sz_google_translate_language');

			// Definizione sezione per configurazione GOOGLE TRANSLATE ACTIVATED

			add_settings_section('sz_google_translate_active','',$this->callbacksection,'sz-google-admin-translate-enable.php');
			add_settings_field('translate_widget',ucwords(__('enable widget','szgoogleadmin')),array($this,'get_translate_widget'),'sz-google-admin-translate-enable.php','sz_google_translate_active');
			add_settings_field('translate_shortcode',ucwords(__('enable shortcode','szgoogleadmin')),array($this,'get_translate_shortcode'),'sz-google-admin-translate-enable.php','sz_google_translate_active');

			// Definizione sezione per configurazione GOOGLE TRANSLATE ADVANCED

			add_settings_section('sz_google_translate_advanced','',$this->callbacksection,'sz-google-admin-translate-advanced.php');
			add_settings_field('translate_automatic',ucfirst(__('automatic banner','szgoogleadmin')),array($this,'get_translate_automatic'),'sz-google-admin-translate-advanced.php','sz_google_translate_advanced');
			add_settings_field('translate_multiple',ucfirst(__('multiple language','szgoogleadmin')),array($this,'get_translate_multiple'),'sz-google-admin-translate-advanced.php','sz_google_translate_advanced');
			add_settings_field('translate_analytics',ucwords(__('google analytics','szgoogleadmin')),array($this,'get_translate_analytics'),'sz-google-admin-translate-advanced.php','sz_google_translate_advanced');
			add_settings_field('translate_analytics_ua',ucwords(__('google analytics UA','szgoogleadmin')),array($this,'get_translate_analytics_ua'),'sz-google-admin-translate-advanced.php','sz_google_translate_advanced');
		}

		/**
		 * Definizione delle funzioni per la creazione delle singole opzioni che vanno
		 * inserite nel form generale di configurazione e salvate sul database di wordpress
		 */
		function get_translate_meta() 
		{
			$this->moduleCommonFormText('sz_google_options_translate','translate_meta','large',__('insert your META code','szgoogleadmin'));
			$this->moduleCommonFormDescription(__('before you use the google translate module must register the site in google account using Google Translate Tools. Once inserit your site to perform the action "get code", display meta code and insert this in the field.','szgoogleadmin'));
		}

		function get_translate_mode() 
		{
			$values = array(
				'I1' => __('inline vertical','szgoogleadmin'),
				'I2' => __('inline horizontal','szgoogleadmin'),
				'I3' => __('inline dropdown','szgoogleadmin'),
			); 

			$this->moduleCommonFormSelect('sz_google_options_translate','translate_mode',$values,'medium','');
			$this->moduleCommonFormDescription(__('with this parameter you can set the type of view you want to use for the widget to translate the language selection, you can choose for example vertical, horizontal or simple. If you want to use a custom positioning can use the function PHP.','szgoogleadmin'));
		}

		function get_translate_language() 
		{
			$values = SZGoogleCommon::getLanguages();
			$this->moduleCommonFormSelect('sz_google_options_translate','translate_language',$values,'medium','');
			$this->moduleCommonFormDescription(__('specify the language associated with your website, if you do not specify any value will be called get_bloginfo(\'language\') and set the same language related to the theme of wordpress. Supported languages ​​http://translate.google.com/about/.','szgoogleadmin'));
		}

		function get_translate_widget() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_translate','translate_widget');
			$this->moduleCommonFormDescription(__('if you enable this option you will find the widget required in the administration menu of your widget and you can plug it into any sidebar defined in your theme. If you disable this option, remember not to leave the widget connected to existing sidebar.','szgoogleadmin'));
		}

		function get_translate_shortcode() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_translate','translate_shortcode');
			$this->moduleCommonFormDescription(__('if you enable this option you can use the shortcode [sz-gtranslate] and enter the corresponding component directly in your article or page. Normally shortcodes can be specified in the options, to control parameters given read the official documentation.','szgoogleadmin'));
		}

		function get_translate_automatic() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_translate','translate_automatic');
			$this->moduleCommonFormDescription(__('automatically display translation banner to users speaking languages other than the language of your page. If the language set on the visitor\'s browser is different from that of the website page displays the banner of translation.','szgoogleadmin'));
		}

		function get_translate_multiple() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_translate','translate_multiple');
			$this->moduleCommonFormDescription(__('your page contains content in multiple languages. Enable this option only if your pages contain content in different languages, in this case Google will use an algorithm of analysis other than the standard. For details read the official documentation.','szgoogleadmin'));
		}

		function get_translate_analytics() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_translate','translate_analytics');
			$this->moduleCommonFormDescription(__('if you enable this option, you can check the requirements and the translation statistics directly to your google analytics account. Remember that to run this option you must specify the code assigned to your profile analytics.','szgoogleadmin'));
		}

		function get_translate_analytics_ua() 
		{
			$this->moduleCommonFormText('sz_google_options_translate','translate_analytics_ua','medium',__('google analytics UA','szgoogleadmin'));
			$this->moduleCommonFormDescription(__('enter the code assigned to the profile of google analytics on which to collect statistical data relating to requests for translation. If you have the google analytics module of the plugin is automatically taken into the UA code of module.','szgoogleadmin'));
		}
	}

	/**
	 * Creazione oggetto principale per creazione ed elaborazione del
	 * modulo richiesto con azioni iniziali specificate nel costruttore
	 */
	$SZ_GOOGLE_ADMIN_TRANSLATE = new SZGoogleModuleAdminTranslate();
}