<?php
/**
 * Modulo GOOGLE GROUPS per la definizione delle funzioni che riguardano
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
if (!class_exists('SZGoogleAdminGroups'))
{
	class SZGoogleAdminGroups extends SZGoogleAdmin
	{
		/**
		 * Creazione del menu sul pannello di amministrazione usando
		 * come valori di configurazione le variabili object
		 *
		 * @return void
		 */
		function moduleAddMenu()
		{
			$this->menuslug   = 'sz-google-admin-groups.php';
			$this->pagetitle  = ucwords(__('google groups','szgoogleadmin'));
			$this->menutitle  = ucwords(__('google groups','szgoogleadmin'));

			// Definizione delle sezioni che devono essere composte in HTML
			// le sezioni devono essere passate come un array con nome => titolo

			$this->sections = array(
				'sz-google-admin-groups-enable.php'   => ucwords(__('activation components','szgoogleadmin')),
				'sz-google-admin-groups-language.php' => ucwords(__('language setting','szgoogleadmin')),
				'sz-google-admin-groups-display.php'  => ucwords(__('display setting','szgoogleadmin')),
			);

			$this->sectionstitle   = $this->menutitle;
			$this->sectionsoptions = 'sz_google_options_groups';

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

			// Definizione sezione per configurazione GOOGLE GROUPS ACTIVATED

			add_settings_section('sz_google_groups_active','',$this->callbacksection,'sz-google-admin-groups-enable.php');
			add_settings_field('groups_widget',ucwords(__('enable widget','szgoogleadmin')),array($this,'get_groups_widget'),'sz-google-admin-groups-enable.php','sz_google_groups_active');
			add_settings_field('groups_shortcode',ucwords(__('enable shortcode','szgoogleadmin')),array($this,'get_groups_shortcode'),'sz-google-admin-groups-enable.php','sz_google_groups_active');

			// Definizione sezione per configurazione GOOGLE GROUPS LANGUAGE

			add_settings_section('sz_google_groups_language','',$this->callbacksection,'sz-google-admin-groups-language.php');
			add_settings_field('groups_language',ucfirst(__('default language','szgoogleadmin')),array($this,'get_groups_language'),'sz-google-admin-groups-language.php','sz_google_groups_language');

			// Definizione sezione per configurazione GOOGLE GROUPS DISPLAY

			add_settings_section('sz_google_groups_display','',$this->callbacksection,'sz-google-admin-groups-display.php');
			add_settings_field('groups_name',ucfirst(__('default group name','szgoogleadmin')),array($this,'get_groups_name'),'sz-google-admin-groups-display.php','sz_google_groups_display');
			add_settings_field('groups_showsearch',ucfirst(__('show search','szgoogleadmin')),array($this,'get_groups_showsearch'),'sz-google-admin-groups-display.php','sz_google_groups_display');
			add_settings_field('groups_showtabs',ucfirst(__('show tabs','szgoogleadmin')),array($this,'get_groups_showtabs'),'sz-google-admin-groups-display.php','sz_google_groups_display');
			add_settings_field('groups_hidetitle',ucfirst(__('hide title','szgoogleadmin')),array($this,'get_groups_hidetitle'),'sz-google-admin-groups-display.php','sz_google_groups_display');
			add_settings_field('groups_hidesubject',ucfirst(__('hide subject','szgoogleadmin')),array($this,'get_groups_hidesubject'),'sz-google-admin-groups-display.php','sz_google_groups_display');
			add_settings_field('groups_width',ucfirst(__('default width','szgoogleadmin')),array($this,'get_groups_width'),'sz-google-admin-groups-display.php','sz_google_groups_display');
			add_settings_field('groups_height',ucfirst(__('default height','szgoogleadmin')),array($this,'get_groups_height'),'sz-google-admin-groups-display.php','sz_google_groups_display');
		}

		/**
		 * Definizione delle funzioni per la creazione delle singole opzioni che vanno
		 * inserite nel form generale di configurazione e salvate sul database di wordpress
		 */
		function get_groups_widget() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_groups','groups_widget');
			$this->moduleCommonFormDescription(__('if you enable this option you will find the widget required in the administration menu of your widget and you can plug it into any sidebar defined in your theme. If you disable this option, remember not to leave the widget connected to existing sidebar.','szgoogleadmin'));
		}

		function get_groups_shortcode() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_groups','groups_shortcode');
			$this->moduleCommonFormDescription(__('if you enable this option you can use the shortcode [sz-ggroups] and enter the corresponding component directly in your article or page. Normally shortcodes can be specified in the options, to control parameters given read the official documentation.','szgoogleadmin'));
		}

		function get_groups_language() 
		{
			$values = SZGooglePluginCommon::getLanguages();
			$this->moduleCommonFormSelect('sz_google_options_groups','groups_language',$values,'medium','');
			$this->moduleCommonFormDescription(__('specify the language associated with your website, if you do not specify any value will be called the get_bloginfo(\'language\') and set the same language related to the theme of wordpress. Supported languages ​​http://translate.google.com/about/.','szgoogleadmin'));
		}

		function get_groups_name() 
		{
			$this->moduleCommonFormText('sz_google_options_groups','groups_name','medium',__('insert default name','szgoogleadmin'));
			$this->moduleCommonFormDescription(__('in this area specify a group name that will be used in all those conditions in which you do not specify any value for the parameter "name". In any case, you can specify any name that is on the shortcode on the widget module google groups.','szgoogleadmin'));
		}

		function get_groups_showsearch() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_groups','groups_showsearch');
			$this->moduleCommonFormDescription(__('select value "yes" if you want to show a search box, "no" if you don\'t want the box to show. This field is used as default value, but you can change this by specifying a specific value via the shortcode or php function. See official documentation.','szgoogleadmin'));
		}

		function get_groups_showtabs() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_groups','groups_showtabs');
			$this->moduleCommonFormDescription(__('select value "yes" if you want to show the view selector tabs, "no" if you don\'t want to show tabs. This field is used as default value, but you can change this by specifying a specific value via the shortcode or php function. See official documentation.','szgoogleadmin'));
		}

		function get_groups_hidetitle() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_groups','groups_hidetitle');
			$this->moduleCommonFormDescription(__('select value "yes" if you want to hide the forum title and description, "no" if you don\'t want to leave the title or description. This field is used as default value, but you can change this by specifying a specific value in shortcode or php function.','szgoogleadmin'));
		}

		function get_groups_hidesubject() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_groups','groups_hidesubject');
			$this->moduleCommonFormDescription(__('select value "yes" if you want to hide the subject of the last post in My Forums view, "no" if you want to leave the subject visible. This field is used as default value, but you can change this by specifying a specific value in shortcode or php function.','szgoogleadmin'));
		}

		function get_groups_width() 
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_groups','groups_width','medium',0);
			$this->moduleCommonFormDescription(__('with this field you can set the width of the container iframe that will be used by defaul, when not specified as a parameter of the widget or the shortcode, if you see a value equal to zero, the default size will be 100% and will occupy the entire space.','szgoogleadmin'));
		}

		function get_groups_height() 
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_groups','groups_height','medium',700);
			$this->moduleCommonFormDescription(__('with this field you can set the height in pixels of the container iframe that will be used by defaul, when not specified as a parameter of the widget or the shortcode, if you see a value equal to zero, the default size will be 700 pixels.','szgoogleadmin'));
		}
	}
}