<?php
/**
 * Modulo GOOGLE TRANSLATE per la definizione delle funzioni che riguardano
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
if (!class_exists('SZGoogleAdminTranslate'))
{
	class SZGoogleAdminTranslate extends SZGoogleAdmin
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

			$this->sectionstabs = array(
				'01' => array('anchor' => 'general' ,'description' => __('general' ,'szgoogleadmin')),
				'02' => array('anchor' => 'advanced','description' => __('advanced','szgoogleadmin')),
			);

			$this->sections = array(
				array('tab' => '01','section' => 'sz-google-admin-translate.php'         ,'title' => ucwords(__('settings','szgoogleadmin'))),
				array('tab' => '01','section' => 'sz-google-admin-translate-language.php','title' => ucwords(__('language setting','szgoogleadmin'))),
				array('tab' => '01','section' => 'sz-google-admin-translate-enable.php'  ,'title' => ucwords(__('activation','szgoogleadmin'))),
				array('tab' => '02','section' => 'sz-google-admin-translate-advanced.php','title' => ucwords(__('advanced settings','szgoogleadmin'))),
			);

			$this->sectionstitle   = $this->menutitle;
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
			// Definizione array generale contenente elenco delle sezioni
			// Su ogni sezione bisogna definire un array per elenco campi

			$this->sectionsmenu = array(
				'01' => array('section' => 'sz_google_translate_section' ,'title' => $this->null,'callback' => $this->callbacksection,'slug' => 'sz-google-admin-translate.php'),
				'02' => array('section' => 'sz_google_translate_language','title' => $this->null,'callback' => $this->callbacksection,'slug' => 'sz-google-admin-translate-language.php'),
				'03' => array('section' => 'sz_google_translate_active'  ,'title' => $this->null,'callback' => $this->callbacksection,'slug' => 'sz-google-admin-translate-enable.php'),
				'04' => array('section' => 'sz_google_translate_advanced','title' => $this->null,'callback' => $this->callbacksection,'slug' => 'sz-google-admin-translate-advanced.php'),
			);

			// Definizione array generale contenente elenco dei campi
			// che bisogna aggiungere alle sezioni precedentemente definite

			$this->sectionsfields = array
			(
				// Definizione sezione per configurazione GOOGLE TRANSLATE ID

				'01' => array(
					array('field' => 'translate_meta'        ,'title' => ucfirst(__('code META'          ,'szgoogleadmin')),'callback' => array($this,'get_translate_meta')),
					array('field' => 'translate_mode'        ,'title' => ucfirst(__('display mode'       ,'szgoogleadmin')),'callback' => array($this,'get_translate_mode')),
				),

				// Definizione sezione per configurazione GOOGLE TRANSLATE LANGUAGE

				'02' => array(
					array('field' => 'translate_language'    ,'title' => ucfirst(__('website language'   ,'szgoogleadmin')),'callback' => array($this,'get_translate_language')),
				),

				// Definizione sezione per configurazione GOOGLE TRANSLATE ACTIVATED

				'03' => array(
					array('field' => 'translate_shortcode'   ,'title' => ucfirst(__('shortcode'          ,'szgoogleadmin')),'callback' => array($this,'get_translate_shortcode')),
					array('field' => 'translate_widget'      ,'title' => ucfirst(__('widget'             ,'szgoogleadmin')),'callback' => array($this,'get_translate_widget')),
				),

				// Definizione sezione per configurazione GOOGLE TRANSLATE ADVANCED

				'04' => array(
					array('field' => 'translate_automatic'   ,'title' => ucfirst(__('automatic banner'   ,'szgoogleadmin')),'callback' => array($this,'get_translate_automatic')),
					array('field' => 'translate_multiple'    ,'title' => ucfirst(__('multiple language'  ,'szgoogleadmin')),'callback' => array($this,'get_translate_multiple')),
					array('field' => 'translate_analytics'   ,'title' => ucwords(__('google analytics'   ,'szgoogleadmin')),'callback' => array($this,'get_translate_analytics')),
					array('field' => 'translate_analytics_ua','title' => ucwords(__('google analytics UA','szgoogleadmin')),'callback' => array($this,'get_translate_analytics_ua')),
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
			$this->moduleCommonFormDescription(sprintf(__('if you enable this option you can use the shortcode %s and enter the corresponding component directly in your article or page. Normally in the shortcodes can be specified the options for customizations.','szgoogleadmin'),'[sz-gtranslate]'));
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
}