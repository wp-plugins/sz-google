<?php
/**
 * Modulo GOOGLE YOUTUBE per la definizione delle funzioni che riguardano
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
if (!class_exists('SZGoogleAdminYoutube'))
{
	class SZGoogleAdminYoutube extends SZGoogleAdmin
	{
		/**
		 * Creazione del menu sul pannello di amministrazione usando
		 * come valori di configurazione le variabili object
		 *
		 * @return void
		 */
		function moduleAddMenu()
		{
			$this->menuslug   = 'sz-google-admin-youtube.php';
			$this->pagetitle  = ucwords(__('google youtube','szgoogleadmin'));
			$this->menutitle  = ucwords(__('google youtube','szgoogleadmin'));

			// Definizione delle sezioni che devono essere composte in HTML
			// le sezioni devono essere passate come un array con nome => titolo

			$this->sections = array(
				'sz-google-admin-youtube-config.php'   => ucwords(__('general setting','szgoogleadmin')),
				'sz-google-admin-youtube-enable-w.php' => ucwords(__('activation widgets','szgoogleadmin')),
				'sz-google-admin-youtube-enable-s.php' => ucwords(__('activation shortcodes','szgoogleadmin')),
				'sz-google-admin-youtube-display.php'  => ucwords(__('video display setting','szgoogleadmin')),
				'sz-google-admin-youtube-margins.php'  => ucwords(__('video setting default margins','szgoogleadmin')),
				'sz-google-admin-youtube-advanced.php' => ucwords(__('video advanced setting','szgoogleadmin')),
			);

			$this->sectionstitle   = ucfirst(__('google youtube configuration','szgoogleadmin'));
			$this->sectionsoptions = 'sz_google_options_youtube';

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

			// Definizione sezione per configurazione GOOGLE YOUTUBE CONFIG

			add_settings_section('sz_google_youtube_config','',$this->callbacksection,'sz-google-admin-youtube-config.php');
			add_settings_field('youtube_channel',ucfirst(__('channel name or ID','szgoogleadmin')),array($this,'get_youtube_channel'),'sz-google-admin-youtube-config.php','sz_google_youtube_config');

			// Definizione sezione per configurazione GOOGLE YOUTUBE ACTIVATED

			add_settings_section('sz_google_youtube_active_w','',$this->callbacksection,'sz-google-admin-youtube-enable-w.php');
			add_settings_field('youtube_widget',ucwords(__('enable widget video','szgoogleadmin')),array($this,'get_youtube_widget'),'sz-google-admin-youtube-enable-w.php','sz_google_youtube_active_w');
			add_settings_field('youtube_widget_badge',ucwords(__('enable widget badge','szgoogleadmin')),array($this,'get_youtube_widget_badge'),'sz-google-admin-youtube-enable-w.php','sz_google_youtube_active_w');
			add_settings_field('youtube_widget_playlist',ucwords(__('enable widget playlist','szgoogleadmin')),array($this,'get_youtube_widget_playlist'),'sz-google-admin-youtube-enable-w.php','sz_google_youtube_active_w');

			// Definizione sezione per configurazione GOOGLE YOUTUBE ACTIVATED

			add_settings_section('sz_google_youtube_active_s','',$this->callbacksection,'sz-google-admin-youtube-enable-s.php');
			add_settings_field('youtube_shortcode',ucwords(__('enable shortcode video','szgoogleadmin')),array($this,'get_youtube_shortcode'),'sz-google-admin-youtube-enable-s.php','sz_google_youtube_active_s');
			add_settings_field('youtube_shortcode_badge',ucwords(__('enable shortcode badge','szgoogleadmin')),array($this,'get_youtube_shortcode_badge'),'sz-google-admin-youtube-enable-s.php','sz_google_youtube_active_s');
			add_settings_field('youtube_shortcode_button',ucwords(__('enable shortcode button','szgoogleadmin')),array($this,'get_youtube_shortcode_button'),'sz-google-admin-youtube-enable-s.php','sz_google_youtube_active_s');
			add_settings_field('youtube_shortcode_link',ucwords(__('enable shortcode link','szgoogleadmin')),array($this,'get_youtube_shortcode_link'),'sz-google-admin-youtube-enable-s.php','sz_google_youtube_active_s');
			add_settings_field('youtube_shortcode_playlist',ucwords(__('enable shortcode playlist','szgoogleadmin')),array($this,'get_youtube_shortcode_playlist'),'sz-google-admin-youtube-enable-s.php','sz_google_youtube_active_s');

			// Definizione sezione per configurazione GOOGLE YOUTUBE DISPLAY

			add_settings_section('sz_google_youtube_display','',$this->callbacksection,'sz-google-admin-youtube-display.php');
			add_settings_field('youtube_responsive',ucfirst(__('responsive mode','szgoogleadmin')),array($this,'get_youtube_responsive'),'sz-google-admin-youtube-display.php','sz_google_youtube_display');
			add_settings_field('youtube_width',ucfirst(__('default width','szgoogleadmin')),array($this,'get_youtube_width'),'sz-google-admin-youtube-display.php','sz_google_youtube_display');
			add_settings_field('youtube_height',ucfirst(__('default height','szgoogleadmin')),array($this,'get_youtube_height'),'sz-google-admin-youtube-display.php','sz_google_youtube_display');
			add_settings_field('youtube_autoplay',ucfirst(__('video autoplay','szgoogleadmin')),array($this,'get_youtube_autoplay'),'sz-google-admin-youtube-display.php','sz_google_youtube_display');
			add_settings_field('youtube_loop',ucfirst(__('video loop','szgoogleadmin')),array($this,'get_youtube_loop'),'sz-google-admin-youtube-display.php','sz_google_youtube_display');
			add_settings_field('youtube_theme',ucfirst(__('theme','szgoogleadmin')),array($this,'get_youtube_theme'),'sz-google-admin-youtube-display.php','sz_google_youtube_display');
			add_settings_field('youtube_cover',ucfirst(__('cover','szgoogleadmin')),array($this,'get_youtube_cover'),'sz-google-admin-youtube-display.php','sz_google_youtube_display');
			add_settings_field('youtube_schemaorg',ucfirst(__('schema.org','szgoogleadmin')),array($this,'get_youtube_schemaorg'),'sz-google-admin-youtube-display.php','sz_google_youtube_display');

			// Definizione sezione per configurazione GOOGLE YOUTUBE MARGINS

			add_settings_section('sz_google_youtube_margins','',$this->callbacksection,'sz-google-admin-youtube-margins.php');
			add_settings_field('youtube_margin_top',ucfirst(__('margin top','szgoogleadmin')),array($this,'get_youtube_margin_top'),'sz-google-admin-youtube-margins.php','sz_google_youtube_margins');
			add_settings_field('youtube_margin_right',ucfirst(__('margin right','szgoogleadmin')),array($this,'get_youtube_margin_right'),'sz-google-admin-youtube-margins.php','sz_google_youtube_margins');
			add_settings_field('youtube_margin_bottom',ucfirst(__('margin bottom','szgoogleadmin')),array($this,'get_youtube_margin_bottom'),'sz-google-admin-youtube-margins.php','sz_google_youtube_margins');
			add_settings_field('youtube_margin_left',ucfirst(__('margin left','szgoogleadmin')),array($this,'get_youtube_margin_left'),'sz-google-admin-youtube-margins.php','sz_google_youtube_margins');
			add_settings_field('youtube_margin_unit',ucfirst(__('margin unit','szgoogleadmin')),array($this,'get_youtube_margin_unit'),'sz-google-admin-youtube-margins.php','sz_google_youtube_margins');

			// Definizione sezione per configurazione GOOGLE YOUTUBE ADVANCED

			add_settings_section('sz_google_youtube_advanced','',$this->callbacksection,'sz-google-admin-youtube-advanced.php');
			add_settings_field('youtube_force_ssl',ucfirst(__('force SSL','szgoogleadmin')),array($this,'get_youtube_force_ssl'),'sz-google-admin-youtube-advanced.php','sz_google_youtube_advanced');
			add_settings_field('youtube_fullscreen',ucfirst(__('enable fullscreen','szgoogleadmin')),array($this,'get_youtube_fullscreen'),'sz-google-admin-youtube-advanced.php','sz_google_youtube_advanced');
			add_settings_field('youtube_disablekeyboard',ucfirst(__('disable keyboard','szgoogleadmin')),array($this,'get_youtube_disablekeyboard'),'sz-google-admin-youtube-advanced.php','sz_google_youtube_advanced');
			add_settings_field('youtube_disableiframe',ucfirst(__('disable IFRAME and use API','szgoogleadmin')),array($this,'get_youtube_disableiframe'),'sz-google-admin-youtube-advanced.php','sz_google_youtube_advanced');
			add_settings_field('youtube_analytics',ucwords(__('google analytics','szgoogleadmin')),array($this,'get_youtube_analytics'),'sz-google-admin-youtube-advanced.php','sz_google_youtube_advanced');
			add_settings_field('youtube_delayed',ucwords(__('delayed loading','szgoogleadmin')),array($this,'get_youtube_delayed'),'sz-google-admin-youtube-advanced.php','sz_google_youtube_advanced');
			add_settings_field('youtube_disablerelated',ucwords(__('disable related','szgoogleadmin')),array($this,'get_youtube_disablerelated'),'sz-google-admin-youtube-advanced.php','sz_google_youtube_advanced');
		}

		/**
		 * Definizione delle funzioni per la creazione delle singole opzioni che vanno
		 * inserite nel form generale di configurazione e salvate sul database di wordpress
		 */
		function get_youtube_channel()
		{
			$this->moduleCommonFormText('sz_google_options_youtube','youtube_channel','large',__('insert your channel name or ID','szgoogleadmin'));
			$this->moduleCommonFormDescription(__('enter in this field the default name of your youtube channel. You can change the channel name using the shortcode or functions. if you do not specify anything the default channel will be "startbyzero". The channel\'s name is located in the your string URL.','szgoogleadmin'));
		}

		function get_youtube_widget()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_youtube','youtube_widget');
			$this->moduleCommonFormDescription(__('if you enable this option you will find the widget required in the administration menu of your widget and you can plug it into any sidebar defined in your theme. If you disable this option, remember not to leave the widget connected to existing sidebar.','szgoogleadmin'));
		}

		function get_youtube_widget_badge()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_youtube','youtube_widget_badge');
			$this->moduleCommonFormDescription(__('if you enable this option you will find the widget required in the administration menu of your widget and you can plug it into any sidebar defined in your theme. If you disable this option, remember not to leave the widget connected to existing sidebar.','szgoogleadmin'));
		}

		function get_youtube_widget_playlist()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_youtube','youtube_widget_playlist');
			$this->moduleCommonFormDescription(__('if you enable this option you will find the widget required in the administration menu of your widget and you can plug it into any sidebar defined in your theme. If you disable this option, remember not to leave the widget connected to existing sidebar.','szgoogleadmin'));
		}

		function get_youtube_shortcode() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_youtube','youtube_shortcode');
			$this->moduleCommonFormDescription(__('if you enable this option you can use the shortcode [sz-ytvideo] and enter the corresponding component directly in your article or page. Normally shortcodes can be specified in the options, to control parameters given read the official documentation.','szgoogleadmin'));
		}

		function get_youtube_shortcode_badge() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_youtube','youtube_shortcode_badge');
			$this->moduleCommonFormDescription(__('if you enable this option you can use the shortcode [sz-ytbadge] and enter the corresponding component directly in your article or page. Normally shortcodes can be specified in the options, to control parameters given read the official documentation.','szgoogleadmin'));
		}

		function get_youtube_shortcode_button() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_youtube','youtube_shortcode_button');
			$this->moduleCommonFormDescription(__('if you enable this option you can use the shortcode [sz-ytbutton] and enter the corresponding component directly in your article or page. Normally shortcodes can be specified in the options, to control parameters given read the official documentation.','szgoogleadmin'));
		}

		function get_youtube_shortcode_link() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_youtube','youtube_shortcode_link');
			$this->moduleCommonFormDescription(__('if you enable this option you can use the shortcode [sz-ytlink] and enter the corresponding component directly in your article or page. Normally shortcodes can be specified in the options, to control parameters given read the official documentation.','szgoogleadmin'));
		}

		function get_youtube_shortcode_playlist() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_youtube','youtube_shortcode_playlist');
			$this->moduleCommonFormDescription(__('if you enable this option you can use the shortcode [sz-ytplaylist] and enter the corresponding component directly in your article or page. Normally shortcodes can be specified in the options, to control parameters given read the official documentation.','szgoogleadmin'));
		}

		function get_youtube_responsive()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_youtube','youtube_responsive');
			$this->moduleCommonFormDescription(__('activating this value, the size of the video will be managed with the technique of responsive design, so the size is automatically adjusted to the size of the window, for more information see the documentation on Wikipedia Responsive Web Design.','szgoogleadmin'));
		}

		function get_youtube_width()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_youtube','youtube_width','medium',SZ_PLUGIN_GOOGLE_YOUTUBE_WIDTH);
			$this->moduleCommonFormDescription(__('enter the default size of the video, if you do not specify a value in this field, the default size will be 600px. If you specified a value of "0" or is activated the responsive mode will be used the special value 100% which will occupy the entire space of the container.','szgoogleadmin'));
		}

		function get_youtube_height()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_youtube','youtube_height','medium',SZ_PLUGIN_GOOGLE_YOUTUBE_HEIGHT);
			$this->moduleCommonFormDescription(__('Enter the default size of the video, if you do not specify a value in this field, the default size will be 400px. In the responsive version this value will be ignored, in fact the height will change automatically according to the width of the parent container.','szgoogleadmin'));
		}

		function get_youtube_autoplay()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_youtube','youtube_autoplay');
			$this->moduleCommonFormDescription(__('enabling this option, the video will start automatically inserted when viewing the page without waiting for the user to press the play button. This behavior you can manage it even with the option of shortcode called "autoplay".','szgoogleadmin'));
		}

		function get_youtube_loop()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_youtube','youtube_loop');
			$this->moduleCommonFormDescription(__('this option allows you to reinitiate the video after it was finished. The same function, you can obtain it using the special value [loop] in the shortcode without changing the default behavior. See official documentation Developer Youtube.','szgoogleadmin'));
		}

		function get_youtube_theme()
		{
			$values = array(
				'dark'  => __('dark','szgoogleadmin'),
				'light' => __('light','szgoogleadmin'),
			);

			$this->moduleCommonFormSelect('sz_google_options_youtube','youtube_theme',$values,'medium','');
			$this->moduleCommonFormDescription(__('in this field specify the default theme to apply the player. At this time you can choose between "light" and "dark". To see if they added some additional theme controls the official documentation Developer Youtube.','szgoogleadmin'));
		}

		function get_youtube_cover()
		{
			$values = array(
				'local'   => __('local','szgoogleadmin'),
				'youtube' => __('youtube','szgoogleadmin'),
			);

			$this->moduleCommonFormSelect('sz_google_options_youtube','youtube_cover',$values,'medium','');
			$this->moduleCommonFormDescription(__('in this field you must specify the type of cover for your video clip when you do not specify a custom value. If you specify "local" will be used to cover stored in the plugin, if you use the value "youtube" will be used to cover defaults on youtube.','szgoogleadmin'));
		}

		function get_youtube_schemaorg()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_youtube','youtube_schemaorg');
			$this->moduleCommonFormDescription(__('enabling this option will be enabled meta commands relating to the resources of schema.org video. The values ​​of "meta" must be specified on shortcode or PHP function. For more information read the official documentation.','szgoogleadmin'));
		}

		function get_youtube_margin_top()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_youtube','youtube_margin_top','medium',0);
			$this->moduleCommonFormDescription(__('enter the value of the margin to be applied to the container that will contain the iframe youtube video to display. If you do not specify any value will be used the value 0. This parameter indicates the top margin from the previous text.','szgoogleadmin'));
		}

		function get_youtube_margin_right()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_youtube','youtube_margin_right','medium',SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_AUTO);
			$this->moduleCommonFormDescription(__('enter the value of the margin to be applied to the container that will contain the iframe youtube video to display. If you do not specify any value for this field will be used the special value "auto". If you use responsive mode this value will be ignored.','szgoogleadmin'));
		}

		function get_youtube_margin_bottom()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_youtube','youtube_margin_bottom','medium',0);
			$this->moduleCommonFormDescription(__('enter the value of the margin to be applied to the container that will contain the iframe youtube video to display. If you do not specify any value will be used the value 0. This parameter indicates the bottom margin from the text.','szgoogleadmin'));
		}

		function get_youtube_margin_left()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_youtube','youtube_margin_left','medium',SZ_PLUGIN_GOOGLE_YOUTUBE_MARGIN_AUTO);
			$this->moduleCommonFormDescription(__('enter the value of the margin to be applied to the container that will contain the iframe youtube video to display. If you do not specify any value for this field will be used the special value "auto". If you use responsive mode this value will be ignored.','szgoogleadmin'));
		}

		function get_youtube_margin_unit()
		{
			$values = array(
				'em' => __('em','szgoogleadmin'),
				'px' => __('px','szgoogleadmin'),
			);

			$this->moduleCommonFormSelect('sz_google_options_youtube','youtube_margin_unit',$values,'medium','');
			$this->moduleCommonFormDescription(__('this field is used to specify the unit of measure that must be applied to numeric values ​​that relate to the margins of the video container, the values ​​that can be specified are em = relative size or px = pixel size.','szgoogleadmin'));
		}

		function get_youtube_force_ssl()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_youtube','youtube_force_ssl');
			$this->moduleCommonFormDescription(__('if this function is enabled the embed code to generate the video link is forced with the SSL protocol even if the URL string is specified otherwise. Enabling recommended if the web pages of the site are set by default with SSL.','szgoogleadmin'));
		}

		function get_youtube_fullscreen()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_youtube','youtube_fullscreen');
			$this->moduleCommonFormDescription(__('enable this option to enter in the control bar of the video player icon that allows you to view fullscreen. More information can be found in the official documentation. This behavior you can manage it even with the option of shortcode called "fullscreen".','szgoogleadmin'));
		}

		function get_youtube_disablekeyboard()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_youtube','youtube_disablekeyboard');
			$this->moduleCommonFormDescription(__('will disable the player keyboard controls. Keyboard controls are as follows: Spacebar: Play/Pause - Arrow Left: Jump back 10% in the current video - Arrow Right: Jump ahead 10% in the current video - Arrow Up: Volume up - Arrow Down: Volume Down.','szgoogleadmin'));
		}

		function get_youtube_disableiframe()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_youtube','youtube_disableiframe');
			$this->moduleCommonFormDescription(__('normally to insert a youtube video on a webpage uses the iframe technique, use this parameter to change this way and use the JavaScript API provided by google. If you activate the option of google analytics for youtube this value will be ignored.','szgoogleadmin'));
		}

		function get_youtube_analytics() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_youtube','youtube_analytics');
			$this->moduleCommonFormDescription(__('if you enable this option, you can check the requirements and the translation statistics directly to your google analytics account. Remember that to run this option you must specify the code assigned to your profile analytics.','szgoogleadmin'));
		}

		function get_youtube_delayed() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_youtube','youtube_delayed');
			$this->moduleCommonFormDescription(__('by default the iframe code is loaded immediately, there may be cases where this can be poorly performing, or even when we want to customize the cover image, it would be better to load the code after the user executes the play button.','szgoogleadmin'));
		}

		function get_youtube_disablerelated() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_youtube','youtube_disablerelated');
			$this->moduleCommonFormDescription(__('enabling this option disables the related videos that are presented to the player at the end of the video. activating this option in the final video should be made the cover of the video. Read the official documentation to Developer Guide.','szgoogleadmin'));
		}
	}
}