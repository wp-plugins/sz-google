<?php

/**
 * Module to the definition of the functions that relate to both the
 * widgets that shortcode, but also filters and actions that the module
 * can integrating with adding functionality into wordpress.
 *
 * @package SZGoogle
 * @subpackage Admin
 * @author Eugenio Petullà
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Before the definition of the class, check if there is a definition 
// with the same name or the same as previously defined in other script.

if (!class_exists('SZGoogleAdminCalendar'))
{
	class SZGoogleAdminCalendar extends SZGoogleAdmin
	{
		/**
		 * Creating the menu on the admin panel using values ​​
		 * such as configuration variables object (parent function)
		 */

		function moduleAddMenu()
		{
			// Definition of general values ​​for the creation of a menu associated 
			// with the module options. Example slug, page title and menu title

			$this->menuslug   = 'sz-google-admin-calendar.php';
			$this->pagetitle  = ucwords(__('google calendar','szgoogleadmin'));
			$this->menutitle  = ucwords(__('google calendar','szgoogleadmin'));

			// Definition of sections that need to be made ​​in HTML
			// sections must be passed as an array of name = > title

			$this->sectionstabs = array(
				'01' => array('anchor' => 'general'    ,'description' => __('general'   ,'szgoogleadmin')),
				'02' => array('anchor' => 'shortcodes' ,'description' => __('shortcodes','szgoogleadmin')),
				'03' => array('anchor' => 'widgets'    ,'description' => __('widgets'   ,'szgoogleadmin')),
			);

			$this->sections = array(
				array('tab' => '01','section' => 'sz-google-admin-calendar-general.php'  ,'title' => ucwords(__('settings','szgoogleadmin'))),
				array('tab' => '02','section' => 'sz-google-admin-calendar-s-enable.php' ,'title' => ucwords(__('activation','szgoogleadmin'))),
				array('tab' => '02','section' => 'sz-google-admin-calendar-s-options.php','title' => ucwords(__('options','szgoogleadmin'))),
				array('tab' => '03','section' => 'sz-google-admin-calendar-w-enable.php' ,'title' => ucwords(__('activation','szgoogleadmin'))),
				array('tab' => '03','section' => 'sz-google-admin-calendar-w-options.php','title' => ucwords(__('options','szgoogleadmin'))),
			);

			$this->sectionstitle   = $this->menutitle;
			$this->sectionsoptions = array('sz_google_options_calendar');

			// Calling up the function of the parent class to process the 
			// variables that contain the values ​​of configuration section

			parent::moduleAddMenu();
 		}

		/**
		 * Function to add sections and the corresponding options in the configuration
		 * page, each option belongs to a section, which is linked to a general tab 
		 */

		function moduleAddFields()
		{
			// General definition array containing a list of sections
			// On every section you have to define an array to list fields

			$this->sectionsmenu = array(
				'01' => array('section' => 'sz_google_calendar_general'  ,'title' => $this->null,'callback' => $this->callbacksection,'slug' => 'sz-google-admin-calendar-general.php'),
				'02' => array('section' => 'sz_google_calendar_s_active' ,'title' => $this->null,'callback' => $this->callbacksection,'slug' => 'sz-google-admin-calendar-s-enable.php'),
				'03' => array('section' => 'sz_google_calendar_s_options','title' => $this->null,'callback' => $this->callbacksection,'slug' => 'sz-google-admin-calendar-s-options.php'),
				'04' => array('section' => 'sz_google_calendar_w_active' ,'title' => $this->null,'callback' => $this->callbacksection,'slug' => 'sz-google-admin-calendar-w-enable.php'),
				'05' => array('section' => 'sz_google_calendar_w_options','title' => $this->null,'callback' => $this->callbacksection,'slug' => 'sz-google-admin-calendar-w-options.php'),
			);

			// General definition array containing a list of fields
			// All fields are added to the previously defined sections

			$this->sectionsfields = array(
				'01' => array(array('field' => 'calendar_o_calendars'     ,'title' => ucfirst(__('default calendars' ,'szgoogleadmin')),'callback' => array($this,'callback_calendar_o_calendars')),
				              array('field' => 'calendar_o_title'         ,'title' => ucfirst(__('default title'     ,'szgoogleadmin')),'callback' => array($this,'callback_calendar_o_title')),
				              array('field' => 'calendar_o_mode'          ,'title' => ucfirst(__('default mode'      ,'szgoogleadmin')),'callback' => array($this,'callback_calendar_o_mode')),
				              array('field' => 'calendar_o_weekstart'     ,'title' => ucfirst(__('default week start','szgoogleadmin')),'callback' => array($this,'callback_calendar_o_weekstart')),
				              array('field' => 'calendar_o_language'      ,'title' => ucfirst(__('select language'   ,'szgoogleadmin')),'callback' => array($this,'callback_calendar_o_language')),
				              array('field' => 'calendar_o_timezone'      ,'title' => ucfirst(__('select time zone'  ,'szgoogleadmin')),'callback' => array($this,'callback_calendar_o_timezone')),),
				'02' => array(array('field' => 'calendar_s_enable'        ,'title' => ucfirst(__('shortcode'         ,'szgoogleadmin')),'callback' => array($this,'callback_calendar_s_enable')),),
				'03' => array(array('field' => 'calendar_s_calendars'     ,'title' => ucfirst(__('default calendars' ,'szgoogleadmin')),'callback' => array($this,'callback_calendar_s_calendars')),
				              array('field' => 'calendar_s_title'         ,'title' => ucfirst(__('default title'     ,'szgoogleadmin')),'callback' => array($this,'callback_calendar_s_title')),
				              array('field' => 'calendar_s_width'         ,'title' => ucfirst(__('default width'     ,'szgoogleadmin')),'callback' => array($this,'callback_calendar_s_width')),
				              array('field' => 'calendar_s_height'        ,'title' => ucfirst(__('default height'    ,'szgoogleadmin')),'callback' => array($this,'callback_calendar_s_height')),
				              array('field' => 'calendar_s_show_title'    ,'title' => ucfirst(__('show title'        ,'szgoogleadmin')),'callback' => array($this,'callback_calendar_s_show_title')),
				              array('field' => 'calendar_s_show_navs'     ,'title' => ucfirst(__('show navigation'   ,'szgoogleadmin')),'callback' => array($this,'callback_calendar_s_show_navs')),
				              array('field' => 'calendar_s_show_date'     ,'title' => ucfirst(__('show date'         ,'szgoogleadmin')),'callback' => array($this,'callback_calendar_s_show_date')),
				              array('field' => 'calendar_s_show_print'    ,'title' => ucfirst(__('show print icon'   ,'szgoogleadmin')),'callback' => array($this,'callback_calendar_s_show_print')),
				              array('field' => 'calendar_s_show_tabs'     ,'title' => ucfirst(__('show tabs'         ,'szgoogleadmin')),'callback' => array($this,'callback_calendar_s_show_tabs')),
				              array('field' => 'calendar_s_show_calendars','title' => ucfirst(__('show calendars'    ,'szgoogleadmin')),'callback' => array($this,'callback_calendar_s_show_calendars')),
				              array('field' => 'calendar_s_show_timezone' ,'title' => ucfirst(__('show time zone'    ,'szgoogleadmin')),'callback' => array($this,'callback_calendar_s_show_timezone')),),
				'04' => array(array('field' => 'calendar_w_enable'        ,'title' => ucfirst(__('widget'            ,'szgoogleadmin')),'callback' => array($this,'callback_calendar_w_enable')),),
				'05' => array(array('field' => 'calendar_w_calendars'     ,'title' => ucfirst(__('default calendars' ,'szgoogleadmin')),'callback' => array($this,'callback_calendar_w_calendars')),
				              array('field' => 'calendar_w_title'         ,'title' => ucfirst(__('default title'     ,'szgoogleadmin')),'callback' => array($this,'callback_calendar_w_title')),
				              array('field' => 'calendar_w_width'         ,'title' => ucfirst(__('default width'     ,'szgoogleadmin')),'callback' => array($this,'callback_calendar_w_width')),
				              array('field' => 'calendar_w_height'        ,'title' => ucfirst(__('default height'    ,'szgoogleadmin')),'callback' => array($this,'callback_calendar_w_height')),
				              array('field' => 'calendar_w_show_title'    ,'title' => ucfirst(__('show title'        ,'szgoogleadmin')),'callback' => array($this,'callback_calendar_w_show_title')),
				              array('field' => 'calendar_w_show_navs'     ,'title' => ucfirst(__('show navigation'   ,'szgoogleadmin')),'callback' => array($this,'callback_calendar_w_show_navs')),
				              array('field' => 'calendar_w_show_date'     ,'title' => ucfirst(__('show date'         ,'szgoogleadmin')),'callback' => array($this,'callback_calendar_w_show_date')),
				              array('field' => 'calendar_w_show_print'    ,'title' => ucfirst(__('show print icon'   ,'szgoogleadmin')),'callback' => array($this,'callback_calendar_w_show_print')),
				              array('field' => 'calendar_w_show_tabs'     ,'title' => ucfirst(__('show tabs'         ,'szgoogleadmin')),'callback' => array($this,'callback_calendar_w_show_tabs')),
				              array('field' => 'calendar_w_show_calendars','title' => ucfirst(__('show calendars'    ,'szgoogleadmin')),'callback' => array($this,'callback_calendar_w_show_calendars')),
				              array('field' => 'calendar_w_show_timezone' ,'title' => ucfirst(__('show time zone'    ,'szgoogleadmin')),'callback' => array($this,'callback_calendar_w_show_timezone')),),
			);

			// Calling up the function of the parent class to process the 
			// variables that contain the values ​​of configuration section

			parent::moduleAddFields();
		}

		/**
		 * Definition functions for the creation of the various options that should be included 
		 * in the general form of configuration and saved on a database of wordpress (options)		
		 */

		function callback_calendar_o_calendars()
		{
			$this->moduleCommonFormText('sz_google_options_calendar','calendar_o_calendars','medium',__('default calendars','szgoogleadmin'));
			$this->moduleCommonFormDescription(__('Enter the default calendar used when you do not specify any value. You can specify multiple calendars separated by commas. This value will be used in all fields that require the calendar that are left empty, such as widgets and shortcodes.','szgoogleadmin'));
		}

		function callback_calendar_o_title()
		{
			$this->moduleCommonFormText('sz_google_options_calendar','calendar_o_title','medium',__('default title','szgoogleadmin'));
			$this->moduleCommonFormDescription(__('insert the title string to be used if no value is specified during the processing of the function. If you do not enter any value in this field will be used the original "calendar name" specified in google configuration.','szgoogleadmin'));
		}

		function callback_calendar_o_mode()
		{
			$values = array('MONTH'=>__('monthly','szgoogleadmin'),'WEEK'=>__('weekly','szgoogleadmin'),'AGENDA'=>__('agenda','szgoogleadmin'));
			$this->moduleCommonFormSelect('sz_google_options_calendar','calendar_o_mode',$values,'medium','');
			$this->moduleCommonFormDescription(__('with this option, you can choose the type of view of the calendar that will be inserted into your wordpress site. You can choose between agenda, monthly and weekly. This value is used when it is not otherwise specified by the shortcode or widget.','szgoogleadmin'));
		}

		function callback_calendar_o_weekstart()
		{
			$values = array('1'=>__('sunday','szgoogleadmin'),'2'=>__('monday','szgoogleadmin'),'7'=>__('saturday','szgoogleadmin'));
			$this->moduleCommonFormSelect('sz_google_options_calendar','calendar_o_weekstart',$values,'medium','');
			$this->moduleCommonFormDescription(__('this value represents the starting day of the week used by default in the calendar view that will be inserted into the page wordpress. Choose from sunday, monday and saturday.','szgoogleadmin'));
		}

		function callback_calendar_o_language()
		{
			$values = SZGoogleCommon::getLanguages();
			$this->moduleCommonFormSelect('sz_google_options_calendar','calendar_o_language',$values,'medium','');
			$this->moduleCommonFormDescription(__('specify the language code associated with your website, if you do not specify any value will be called the get_bloginfo(\'language\') and set the same language related to the theme of wordpress.','szgoogleadmin'));
		}

		function callback_calendar_o_timezone()
		{
			$values = SZGoogleCommon::getTimeZone();
			$this->moduleCommonFormSelect('sz_google_options_calendar','calendar_o_timezone',$values,'medium','');
			$this->moduleCommonFormDescription(__('this field specifies the time zone to be used by default by the calendar that will be inserted into the page wordpress. If you do not specify any value, google will automatically calculate the time zone based on its configuration.','szgoogleadmin'));
		}

		/**
		 * Definition functions for the creation of the various options that should be included 
		 * in the general form of configuration and saved on a database of wordpress (options)		
		 */

		function callback_calendar_s_enable()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_calendar','calendar_s_enable');
			$this->moduleCommonFormDescription(sprintf(__('if you enable this option you can use the shortcode %s and enter the corresponding component directly in your article or page. Normally in the shortcodes can be specified the options for customizations.','szgoogleadmin'),'[sz-calendar]'));
		}

		function callback_calendar_s_calendars()
		{
			$this->moduleCommonFormText('sz_google_options_calendar','calendar_s_calendars','medium',__('default calendars','szgoogleadmin'));
			$this->moduleCommonFormDescription(__('enter the default calendar used when you do not specify any value. You can specify multiple calendars separated by commas. If you do not specify anything in this value and nothing in the function will not be processed any embed code.','szgoogleadmin'));
		}

		function callback_calendar_s_title()
		{
			$this->moduleCommonFormText('sz_google_options_calendar','calendar_s_title','medium',__('default title','szgoogleadmin'));
			$this->moduleCommonFormDescription(__('insert the title string to be used if no value is specified during the processing of the function. If you do not enter any value in this field will be used the original "calendar name" specified in google configuration.','szgoogleadmin'));
		}

		function callback_calendar_s_width()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_calendar','calendar_s_width','medium','auto');
			$this->moduleCommonFormDescription(__('with this field you can set the width of the container iframe that will be used by defaul, when not specified as a parameter of the shortcode, if you see a value equal "auto", the default size will be 100% and will occupy the entire space of parent container.','szgoogleadmin'));
		}

		function callback_calendar_s_height()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_calendar','calendar_s_height','medium','auto');
			$this->moduleCommonFormDescription(__('with this field you can set the height in pixels of the container iframe that will be used by defaul, when not specified as a parameter of the shortcode, if you see a value equal "auto", will be used the default size of the plugin.','szgoogleadmin'));
		}

		function callback_calendar_s_show_title()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_calendar','calendar_s_show_title');
			$this->moduleCommonFormDescription(__('enable this option to display the field in the embedded code of google calendar. This is the default value that will be used if you do not specify a specific value corresponding. See the documentation of the plugin for more information.','szgoogleadmin'));
		}

		function callback_calendar_s_show_navs()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_calendar','calendar_s_show_navs');
			$this->moduleCommonFormDescription(__('enable this option to display the field in the embedded code of google calendar. This is the default value that will be used if you do not specify a specific value corresponding. See the documentation of the plugin for more information.','szgoogleadmin'));
		}

		function callback_calendar_s_show_date()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_calendar','calendar_s_show_date');
			$this->moduleCommonFormDescription(__('enable this option to display the field in the embedded code of google calendar. This is the default value that will be used if you do not specify a specific value corresponding. See the documentation of the plugin for more information.','szgoogleadmin'));
		}

		function callback_calendar_s_show_print()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_calendar','calendar_s_show_print');
			$this->moduleCommonFormDescription(__('enable this option to display the field in the embedded code of google calendar. This is the default value that will be used if you do not specify a specific value corresponding. See the documentation of the plugin for more information.','szgoogleadmin'));
		}

		function callback_calendar_s_show_tabs()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_calendar','calendar_s_show_tabs');
			$this->moduleCommonFormDescription(__('enable this option to display the field in the embedded code of google calendar. This is the default value that will be used if you do not specify a specific value corresponding. See the documentation of the plugin for more information.','szgoogleadmin'));
		}

		function callback_calendar_s_show_calendars()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_calendar','calendar_s_show_calendars');
			$this->moduleCommonFormDescription(__('enable this option to display the field in the embedded code of google calendar. This is the default value that will be used if you do not specify a specific value corresponding. See the documentation of the plugin for more information.','szgoogleadmin'));
		}

		function callback_calendar_s_show_timezone()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_calendar','calendar_s_show_timezone');
			$this->moduleCommonFormDescription(__('enable this option to display the field in the embedded code of google calendar. This is the default value that will be used if you do not specify a specific value corresponding. See the documentation of the plugin for more information.','szgoogleadmin'));
		}

		/**
		 * Definition functions for the creation of the various options that should be included 
		 * in the general form of configuration and saved on a database of wordpress (options)		
		 */

		function callback_calendar_w_enable()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_calendar','calendar_w_enable');
			$this->moduleCommonFormDescription(__('if you enable this option you will find the widget required in the administration menu of your widget and you can plug it into any sidebar defined in your theme. If you disable this option, remember not to leave the widget connected to existing sidebar.','szgoogleadmin'));
		}

		function callback_calendar_w_calendars()
		{
			$this->moduleCommonFormText('sz_google_options_calendar','calendar_w_calendars','medium',__('default calendars','szgoogleadmin'));
			$this->moduleCommonFormDescription(__('enter the default calendar used when you do not specify any value. You can specify multiple calendars separated by commas. If you do not specify anything in this value and nothing in the function will not be processed any embed code.','szgoogleadmin'));
		}

		function callback_calendar_w_title()
		{
			$this->moduleCommonFormText('sz_google_options_calendar','calendar_w_title','medium',__('default title','szgoogleadmin'));
			$this->moduleCommonFormDescription(__('insert the title string to be used if no value is specified during the processing of the function. If you do not enter any value in this field will be used the original "calendar name" specified in google configuration.','szgoogleadmin'));
		}

		function callback_calendar_w_width()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_calendar','calendar_w_width','medium','auto');
			$this->moduleCommonFormDescription(__('with this field you can set the width of the container iframe that will be used by defaul, when not specified as a parameter of the shortcode, if you see a value equal "auto", the default size will be 100% and will occupy the entire space of parent container.','szgoogleadmin'));
		}

		function callback_calendar_w_height()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_calendar','calendar_w_height','medium','auto');
			$this->moduleCommonFormDescription(__('with this field you can set the height in pixels of the container iframe that will be used by defaul, when not specified as a parameter of the shortcode, if you see a value equal "auto", will be used the default size of the plugin.','szgoogleadmin'));
		}

		function callback_calendar_w_show_title()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_calendar','calendar_w_show_title');
			$this->moduleCommonFormDescription(__('enable this option to display the field in the embedded code of google calendar. This is the default value that will be used if you do not specify a specific value corresponding. See the documentation of the plugin for more information.','szgoogleadmin'));
		}

		function callback_calendar_w_show_navs()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_calendar','calendar_w_show_navs');
			$this->moduleCommonFormDescription(__('enable this option to display the field in the embedded code of google calendar. This is the default value that will be used if you do not specify a specific value corresponding. See the documentation of the plugin for more information.','szgoogleadmin'));
		}

		function callback_calendar_w_show_date()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_calendar','calendar_w_show_date');
			$this->moduleCommonFormDescription(__('enable this option to display the field in the embedded code of google calendar. This is the default value that will be used if you do not specify a specific value corresponding. See the documentation of the plugin for more information.','szgoogleadmin'));
		}

		function callback_calendar_w_show_print()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_calendar','calendar_w_show_print');
			$this->moduleCommonFormDescription(__('enable this option to display the field in the embedded code of google calendar. This is the default value that will be used if you do not specify a specific value corresponding. See the documentation of the plugin for more information.','szgoogleadmin'));
		}

		function callback_calendar_w_show_tabs()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_calendar','calendar_w_show_tabs');
			$this->moduleCommonFormDescription(__('enable this option to display the field in the embedded code of google calendar. This is the default value that will be used if you do not specify a specific value corresponding. See the documentation of the plugin for more information.','szgoogleadmin'));
		}

		function callback_calendar_w_show_calendars()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_calendar','calendar_w_show_calendars');
			$this->moduleCommonFormDescription(__('enable this option to display the field in the embedded code of google calendar. This is the default value that will be used if you do not specify a specific value corresponding. See the documentation of the plugin for more information.','szgoogleadmin'));
		}

		function callback_calendar_w_show_timezone()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_calendar','calendar_w_show_timezone');
			$this->moduleCommonFormDescription(__('enable this option to display the field in the embedded code of google calendar. This is the default value that will be used if you do not specify a specific value corresponding. See the documentation of the plugin for more information.','szgoogleadmin'));
		}
	}
}