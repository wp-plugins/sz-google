<?php
/**
 * Modulo GOOGLE CALENDAR per la definizione delle funzioni che riguardano
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
if (!class_exists('SZGoogleAdminCalendar'))
{
	class SZGoogleAdminCalendar extends SZGoogleAdmin
	{
		/**
		 * Creazione del menu sul pannello di amministrazione usando
		 * come valori di configurazione le variabili object
		 *
		 * @return void
		 */
		function moduleAddMenu()
		{
			$this->menuslug   = 'sz-google-admin-calendar.php';
			$this->pagetitle  = ucwords(__('google calendar','szgoogleadmin'));
			$this->menutitle  = ucwords(__('google calendar','szgoogleadmin'));

			// Definizione delle sezioni che devono essere composte in HTML
			// le sezioni devono essere passate come un array con nome => titolo

			$this->sections = array(
				'sz-google-admin-calendar-general.php'   => ucwords(__('general configuration','szgoogleadmin')),
				'sz-google-admin-calendar-enable.php'    => ucwords(__('activation components','szgoogleadmin')),
				'sz-google-admin-calendar-s-options.php' => ucwords(__('default options for shortcode','szgoogleadmin')),
				'sz-google-admin-calendar-w-options.php' => ucwords(__('default options for widget','szgoogleadmin')),
			);

			$this->sectionstitle   = $this->menutitle;
			$this->sectionsoptions = 'sz_google_options_calendar';

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

			// Definizione sezione per configurazione GOOGLE CALENDAR GENERAL
		
			add_settings_section('sz_google_calendar_general','',$this->callbacksection,'sz-google-admin-calendar-general.php');
			add_settings_field('calendar_o_calendars',ucfirst(__('default calendars','szgoogleadmin')),array($this,'get_calendar_o_calendars'),'sz-google-admin-calendar-general.php','sz_google_calendar_general');
			add_settings_field('calendar_o_title',ucfirst(__('default title','szgoogleadmin')),array($this,'get_calendar_o_title'),'sz-google-admin-calendar-general.php','sz_google_calendar_general');
			add_settings_field('calendar_o_mode',ucfirst(__('default mode','szgoogleadmin')),array($this,'get_calendar_o_mode'),'sz-google-admin-calendar-general.php','sz_google_calendar_general');
			add_settings_field('calendar_o_weekstart',ucfirst(__('default week start','szgoogleadmin')),array($this,'get_calendar_o_weekstart'),'sz-google-admin-calendar-general.php','sz_google_calendar_general');
			add_settings_field('calendar_o_language',ucfirst(__('select language','szgoogleadmin')),array($this,'get_calendar_o_language'),'sz-google-admin-calendar-general.php','sz_google_calendar_general');
			add_settings_field('calendar_o_timezone',ucfirst(__('select time zone','szgoogleadmin')),array($this,'get_calendar_o_timezone'),'sz-google-admin-calendar-general.php','sz_google_calendar_general');

			// Definizione sezione per configurazione GOOGLE CALENDAR ACTIVATED
		
			add_settings_section('sz_google_calendar_active','',$this->callbacksection,'sz-google-admin-calendar-enable.php');
			add_settings_field('calendar_s_enable',ucwords(__('enable shortcode','szgoogleadmin')),array($this,'get_calendar_s_enable'),'sz-google-admin-calendar-enable.php','sz_google_calendar_active');
			add_settings_field('calendar_w_enable',ucwords(__('enable widget','szgoogleadmin')),array($this,'get_calendar_w_enable'),'sz-google-admin-calendar-enable.php','sz_google_calendar_active');

			// Definizione sezione per configurazione GOOGLE CALENDAR SHORTCODE

			add_settings_section('sz_google_calendar_s_options','',$this->callbacksection,'sz-google-admin-calendar-s-options.php');
			add_settings_field('calendar_s_calendars',ucfirst(__('default calendars','szgoogleadmin')),array($this,'get_calendar_s_calendars'),'sz-google-admin-calendar-s-options.php','sz_google_calendar_s_options');
			add_settings_field('calendar_s_title',ucfirst(__('default title','szgoogleadmin')),array($this,'get_calendar_s_title'),'sz-google-admin-calendar-s-options.php','sz_google_calendar_s_options');
			add_settings_field('calendar_s_width',ucfirst(__('default width','szgoogleadmin')),array($this,'get_calendar_s_width'),'sz-google-admin-calendar-s-options.php','sz_google_calendar_s_options');
			add_settings_field('calendar_s_height',ucfirst(__('default height','szgoogleadmin')),array($this,'get_calendar_s_height'),'sz-google-admin-calendar-s-options.php','sz_google_calendar_s_options');
			add_settings_field('calendar_s_show_title',ucfirst(__('show title','szgoogleadmin')),array($this,'get_calendar_s_show_title'),'sz-google-admin-calendar-s-options.php','sz_google_calendar_s_options');
			add_settings_field('calendar_s_show_navs',ucfirst(__('show navigation','szgoogleadmin')),array($this,'get_calendar_s_show_navs'),'sz-google-admin-calendar-s-options.php','sz_google_calendar_s_options');
			add_settings_field('calendar_s_show_date',ucfirst(__('show date','szgoogleadmin')),array($this,'get_calendar_s_show_date'),'sz-google-admin-calendar-s-options.php','sz_google_calendar_s_options');
			add_settings_field('calendar_s_show_print',ucfirst(__('show print icon','szgoogleadmin')),array($this,'get_calendar_s_show_print'),'sz-google-admin-calendar-s-options.php','sz_google_calendar_s_options');
			add_settings_field('calendar_s_show_tabs',ucfirst(__('show tabs','szgoogleadmin')),array($this,'get_calendar_s_show_tabs'),'sz-google-admin-calendar-s-options.php','sz_google_calendar_s_options');
			add_settings_field('calendar_s_show_calendars',ucfirst(__('show calendars','szgoogleadmin')),array($this,'get_calendar_s_show_calendars'),'sz-google-admin-calendar-s-options.php','sz_google_calendar_s_options');
			add_settings_field('calendar_s_show_timezone',ucfirst(__('show time zone','szgoogleadmin')),array($this,'get_calendar_s_show_timezone'),'sz-google-admin-calendar-s-options.php','sz_google_calendar_s_options');

			// Definizione sezione per configurazione GOOGLE CALENDAR WIDGET

			add_settings_section('sz_google_calendar_w_options','',$this->callbacksection,'sz-google-admin-calendar-w-options.php');
			add_settings_field('calendar_w_calendars',ucfirst(__('default calendars','szgoogleadmin')),array($this,'get_calendar_w_calendars'),'sz-google-admin-calendar-w-options.php','sz_google_calendar_w_options');
			add_settings_field('calendar_w_title',ucfirst(__('default title','szgoogleadmin')),array($this,'get_calendar_w_title'),'sz-google-admin-calendar-w-options.php','sz_google_calendar_w_options');
			add_settings_field('calendar_w_width',ucfirst(__('default width','szgoogleadmin')),array($this,'get_calendar_w_width'),'sz-google-admin-calendar-w-options.php','sz_google_calendar_w_options');
			add_settings_field('calendar_w_height',ucfirst(__('default height','szgoogleadmin')),array($this,'get_calendar_w_height'),'sz-google-admin-calendar-w-options.php','sz_google_calendar_w_options');
			add_settings_field('calendar_w_show_title',ucfirst(__('show title','szgoogleadmin')),array($this,'get_calendar_w_show_title'),'sz-google-admin-calendar-w-options.php','sz_google_calendar_w_options');
			add_settings_field('calendar_w_show_navs',ucfirst(__('show navigation','szgoogleadmin')),array($this,'get_calendar_w_show_navs'),'sz-google-admin-calendar-w-options.php','sz_google_calendar_w_options');
			add_settings_field('calendar_w_show_date',ucfirst(__('show date','szgoogleadmin')),array($this,'get_calendar_w_show_date'),'sz-google-admin-calendar-w-options.php','sz_google_calendar_w_options');
			add_settings_field('calendar_w_show_print',ucfirst(__('show print icon','szgoogleadmin')),array($this,'get_calendar_w_show_print'),'sz-google-admin-calendar-w-options.php','sz_google_calendar_w_options');
			add_settings_field('calendar_w_show_tabs',ucfirst(__('show tabs','szgoogleadmin')),array($this,'get_calendar_w_show_tabs'),'sz-google-admin-calendar-w-options.php','sz_google_calendar_w_options');
			add_settings_field('calendar_w_show_calendars',ucfirst(__('show calendars','szgoogleadmin')),array($this,'get_calendar_w_show_calendars'),'sz-google-admin-calendar-w-options.php','sz_google_calendar_w_options');
			add_settings_field('calendar_w_show_timezone',ucfirst(__('show time zone','szgoogleadmin')),array($this,'get_calendar_w_show_timezone'),'sz-google-admin-calendar-w-options.php','sz_google_calendar_w_options');
		}

		/**
		 * Definizione delle funzioni per la creazione delle singole opzioni che vanno
		 * inserite nel form generale di configurazione e salvate sul database di wordpress
		 */
		function get_calendar_o_calendars()
		{
			$this->moduleCommonFormText('sz_google_options_calendar','calendar_o_calendars','medium',__('default calendars','szgoogleadmin'));
			$this->moduleCommonFormDescription(__('Enter the default calendar used when you do not specify any value. You can specify multiple calendars separated by commas. This value will be used in all fields that require the calendar that are left empty, such as widgets and shortcodes.','szgoogleadmin'));
		}

		function get_calendar_o_title()
		{
			$this->moduleCommonFormText('sz_google_options_calendar','calendar_o_title','medium',__('default title','szgoogleadmin'));
			$this->moduleCommonFormDescription(__('insert the title string to be used if no value is specified during the processing of the function. If you do not enter any value in this field will be used the original "calendar name" specified in google configuration.','szgoogleadmin'));
		}

		function get_calendar_o_mode()
		{
			$values = array('MONTH'=>'monthly','WEEK'=>'weekly','AGENDA'=>'agenda'); 
			$this->moduleCommonFormSelect('sz_google_options_calendar','calendar_o_mode',$values,'medium','');
			$this->moduleCommonFormDescription(__('with this option, you can choose the type of view of the calendar that will be inserted into your wordpress site. You can choose between agenda, monthly and weekly. This value is used when it is not otherwise specified by the shortcode or widget.','szgoogleadmin'));
		}

		function get_calendar_o_weekstart()
		{
			$values = array('1'=>'sunday','2'=>'monday','7'=>'saturday');
			$this->moduleCommonFormSelect('sz_google_options_calendar','calendar_o_weekstart',$values,'medium','');
			$this->moduleCommonFormDescription(__('this value represents the starting day of the week used by default in the calendar view that will be inserted into the page wordpress. Choose from sunday, monday and saturday.','szgoogleadmin'));
		}

		function get_calendar_o_language()
		{
			$values = SZGooglePluginCommon::getLanguages();
			$this->moduleCommonFormSelect('sz_google_options_calendar','calendar_o_language',$values,'medium','');
			$this->moduleCommonFormDescription(__('specify the language code associated with your website, if you do not specify any value will be called the get_bloginfo(\'language\') and set the same language related to the theme of wordpress.','szgoogleadmin'));
		}

		function get_calendar_o_timezone()
		{
			$values = SZGooglePluginCommon::getTimeZone();
			$this->moduleCommonFormSelect('sz_google_options_calendar','calendar_o_timezone',$values,'medium','');
			$this->moduleCommonFormDescription(__('this field specifies the time zone to be used by default by the calendar that will be inserted into the page wordpress. If you do not specify any value, google will automatically calculate the time zone based on its configuration.','szgoogleadmin'));
		}

		function get_calendar_s_enable()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_calendar','calendar_s_enable');
			$this->moduleCommonFormDescription(sprintf(__('if you enable this option you can use the shortcode %s and enter the corresponding component directly in your article or page. Normally in the shortcodes can be specified the options for customizations.','szgoogleadmin'),'[sz-calendar]'));
		}

		function get_calendar_s_calendars()
		{
			$this->moduleCommonFormText('sz_google_options_calendar','calendar_s_calendars','medium',__('default calendars','szgoogleadmin'));
			$this->moduleCommonFormDescription(__('enter the default calendar used when you do not specify any value. You can specify multiple calendars separated by commas. If you do not specify anything in this value and nothing in the function will not be processed any embed code.','szgoogleadmin'));
		}

		function get_calendar_s_title()
		{
			$this->moduleCommonFormText('sz_google_options_calendar','calendar_s_title','medium',__('default title','szgoogleadmin'));
			$this->moduleCommonFormDescription(__('insert the title string to be used if no value is specified during the processing of the function. If you do not enter any value in this field will be used the original "calendar name" specified in google configuration.','szgoogleadmin'));
		}

		function get_calendar_s_width()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_calendar','calendar_s_width','medium',SZ_PLUGIN_GOOGLE_CALENDAR_S_WIDTH);
			$this->moduleCommonFormDescription(__('with this field you can set the width of the container iframe that will be used by defaul, when not specified as a parameter of the shortcode, if you see a value equal "auto", the default size will be 100% and will occupy the entire space of parent container.','szgoogleadmin'));
		}

		function get_calendar_s_height()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_calendar','calendar_s_height','medium',SZ_PLUGIN_GOOGLE_CALENDAR_S_HEIGHT);
			$this->moduleCommonFormDescription(__('with this field you can set the height in pixels of the container iframe that will be used by defaul, when not specified as a parameter of the shortcode, if you see a value equal "auto", will be used the default size of the plugin.','szgoogleadmin'));
		}

		function get_calendar_s_show_title()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_calendar','calendar_s_show_title');
			$this->moduleCommonFormDescription(__('enable this option to display the field in the embedded code of google calendar. This is the default value that will be used if you do not specify a specific value corresponding. See the documentation of the plugin for more information.','szgoogleadmin'));
		}

		function get_calendar_s_show_navs()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_calendar','calendar_s_show_navs');
			$this->moduleCommonFormDescription(__('enable this option to display the field in the embedded code of google calendar. This is the default value that will be used if you do not specify a specific value corresponding. See the documentation of the plugin for more information.','szgoogleadmin'));
		}

		function get_calendar_s_show_date()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_calendar','calendar_s_show_date');
			$this->moduleCommonFormDescription(__('enable this option to display the field in the embedded code of google calendar. This is the default value that will be used if you do not specify a specific value corresponding. See the documentation of the plugin for more information.','szgoogleadmin'));
		}

		function get_calendar_s_show_print()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_calendar','calendar_s_show_print');
			$this->moduleCommonFormDescription(__('enable this option to display the field in the embedded code of google calendar. This is the default value that will be used if you do not specify a specific value corresponding. See the documentation of the plugin for more information.','szgoogleadmin'));
		}

		function get_calendar_s_show_tabs()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_calendar','calendar_s_show_tabs');
			$this->moduleCommonFormDescription(__('enable this option to display the field in the embedded code of google calendar. This is the default value that will be used if you do not specify a specific value corresponding. See the documentation of the plugin for more information.','szgoogleadmin'));
		}

		function get_calendar_s_show_calendars()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_calendar','calendar_s_show_calendars');
			$this->moduleCommonFormDescription(__('enable this option to display the field in the embedded code of google calendar. This is the default value that will be used if you do not specify a specific value corresponding. See the documentation of the plugin for more information.','szgoogleadmin'));
		}

		function get_calendar_s_show_timezone()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_calendar','calendar_s_show_timezone');
			$this->moduleCommonFormDescription(__('enable this option to display the field in the embedded code of google calendar. This is the default value that will be used if you do not specify a specific value corresponding. See the documentation of the plugin for more information.','szgoogleadmin'));
		}

		function get_calendar_w_enable()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_calendar','calendar_w_enable');
			$this->moduleCommonFormDescription(__('if you enable this option you will find the widget required in the administration menu of your widget and you can plug it into any sidebar defined in your theme. If you disable this option, remember not to leave the widget connected to existing sidebar.','szgoogleadmin'));
		}

		function get_calendar_w_calendars()
		{
			$this->moduleCommonFormText('sz_google_options_calendar','calendar_w_calendars','medium',__('default calendars','szgoogleadmin'));
			$this->moduleCommonFormDescription(__('enter the default calendar used when you do not specify any value. You can specify multiple calendars separated by commas. If you do not specify anything in this value and nothing in the function will not be processed any embed code.','szgoogleadmin'));
		}

		function get_calendar_w_title()
		{
			$this->moduleCommonFormText('sz_google_options_calendar','calendar_w_title','medium',__('default title','szgoogleadmin'));
			$this->moduleCommonFormDescription(__('insert the title string to be used if no value is specified during the processing of the function. If you do not enter any value in this field will be used the original "calendar name" specified in google configuration.','szgoogleadmin'));
		}

		function get_calendar_w_width()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_calendar','calendar_w_width','medium',SZ_PLUGIN_GOOGLE_CALENDAR_W_WIDTH);
			$this->moduleCommonFormDescription(__('with this field you can set the width of the container iframe that will be used by defaul, when not specified as a parameter of the shortcode, if you see a value equal "auto", the default size will be 100% and will occupy the entire space of parent container.','szgoogleadmin'));
		}

		function get_calendar_w_height()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_calendar','calendar_w_height','medium',SZ_PLUGIN_GOOGLE_CALENDAR_W_HEIGHT);
			$this->moduleCommonFormDescription(__('with this field you can set the height in pixels of the container iframe that will be used by defaul, when not specified as a parameter of the shortcode, if you see a value equal "auto", will be used the default size of the plugin.','szgoogleadmin'));
		}

		function get_calendar_w_show_title()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_calendar','calendar_w_show_title');
			$this->moduleCommonFormDescription(__('enable this option to display the field in the embedded code of google calendar. This is the default value that will be used if you do not specify a specific value corresponding. See the documentation of the plugin for more information.','szgoogleadmin'));
		}

		function get_calendar_w_show_navs()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_calendar','calendar_w_show_navs');
			$this->moduleCommonFormDescription(__('enable this option to display the field in the embedded code of google calendar. This is the default value that will be used if you do not specify a specific value corresponding. See the documentation of the plugin for more information.','szgoogleadmin'));
		}

		function get_calendar_w_show_date()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_calendar','calendar_w_show_date');
			$this->moduleCommonFormDescription(__('enable this option to display the field in the embedded code of google calendar. This is the default value that will be used if you do not specify a specific value corresponding. See the documentation of the plugin for more information.','szgoogleadmin'));
		}

		function get_calendar_w_show_print()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_calendar','calendar_w_show_print');
			$this->moduleCommonFormDescription(__('enable this option to display the field in the embedded code of google calendar. This is the default value that will be used if you do not specify a specific value corresponding. See the documentation of the plugin for more information.','szgoogleadmin'));
		}

		function get_calendar_w_show_tabs()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_calendar','calendar_w_show_tabs');
			$this->moduleCommonFormDescription(__('enable this option to display the field in the embedded code of google calendar. This is the default value that will be used if you do not specify a specific value corresponding. See the documentation of the plugin for more information.','szgoogleadmin'));
		}

		function get_calendar_w_show_calendars()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_calendar','calendar_w_show_calendars');
			$this->moduleCommonFormDescription(__('enable this option to display the field in the embedded code of google calendar. This is the default value that will be used if you do not specify a specific value corresponding. See the documentation of the plugin for more information.','szgoogleadmin'));
		}

		function get_calendar_w_show_timezone()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_calendar','calendar_w_show_timezone');
			$this->moduleCommonFormDescription(__('enable this option to display the field in the embedded code of google calendar. This is the default value that will be used if you do not specify a specific value corresponding. See the documentation of the plugin for more information.','szgoogleadmin'));
		}
	}
}