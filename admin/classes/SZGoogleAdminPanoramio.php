<?php
/**
 * Modulo GOOGLE PANORAMIO per la definizione delle funzioni che riguardano
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
if (!class_exists('SZGoogleAdminPanoramio'))
{
	class SZGoogleAdminPanoramio extends SZGoogleAdmin
	{
		/**
		 * Creazione del menu sul pannello di amministrazione usando
		 * come valori di configurazione le variabili object
		 *
		 * @return void
		 */
		function moduleAddMenu()
		{
			$this->menuslug   = 'sz-google-admin-panoramio.php';
			$this->pagetitle  = ucwords(__('google panoramio','szgoogleadmin'));
			$this->menutitle  = ucwords(__('google panoramio','szgoogleadmin'));

			// Definizione delle sezioni che devono essere composte in HTML
			// le sezioni devono essere passate come un array con nome => titolo

			$this->sections = array(
				'sz-google-admin-panoramio-enable.php'    => ucwords(__('activation components','szgoogleadmin')),
				'sz-google-admin-panoramio-s-options.php' => ucwords(__('default options for shortcode','szgoogleadmin')),
				'sz-google-admin-panoramio-w-options.php' => ucwords(__('default options for widget','szgoogleadmin')),
			);

			$this->sectionstitle   = ucfirst(__('google panoramio configuration','szgoogleadmin'));
			$this->sectionsoptions = 'sz_google_options_panoramio';

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

			// Definizione sezione per configurazione GOOGLE PANORAMIO ACTIVATED
		
			add_settings_section('sz_google_panoramio_active','',$this->callbacksection,'sz-google-admin-panoramio-enable.php');
			add_settings_field('panoramio_shortcode',ucwords(__('enable shortcode','szgoogleadmin')),array($this,'get_panoramio_shortcode'),'sz-google-admin-panoramio-enable.php','sz_google_panoramio_active');
			add_settings_field('panoramio_widget',ucwords(__('enable widget','szgoogleadmin')),array($this,'get_panoramio_widget'),'sz-google-admin-panoramio-enable.php','sz_google_panoramio_active');

			// Definizione sezione per configurazione GOOGLE PANORAMIO SHORTCODE

			add_settings_section('sz_google_panoramio_s_options','',$this->callbacksection,'sz-google-admin-panoramio-s-options.php');
			add_settings_field('panoramio_s_template',ucfirst(__('default template','szgoogleadmin')),array($this,'get_panoramio_s_template'),'sz-google-admin-panoramio-s-options.php','sz_google_panoramio_s_options');
			add_settings_field('panoramio_s_width',ucfirst(__('default width','szgoogleadmin')),array($this,'get_panoramio_s_width'),'sz-google-admin-panoramio-s-options.php','sz_google_panoramio_s_options');
			add_settings_field('panoramio_s_height',ucfirst(__('default height','szgoogleadmin')),array($this,'get_panoramio_s_height'),'sz-google-admin-panoramio-s-options.php','sz_google_panoramio_s_options');
			add_settings_field('panoramio_s_orientation',ucfirst(__('default orientation','szgoogleadmin')),array($this,'get_panoramio_s_orientation'),'sz-google-admin-panoramio-s-options.php','sz_google_panoramio_s_options');
			add_settings_field('panoramio_s_list_size',ucfirst(__('default list size','szgoogleadmin')),array($this,'get_panoramio_s_list_size'),'sz-google-admin-panoramio-s-options.php','sz_google_panoramio_s_options');
			add_settings_field('panoramio_s_position',ucfirst(__('default position','szgoogleadmin')),array($this,'get_panoramio_s_position'),'sz-google-admin-panoramio-s-options.php','sz_google_panoramio_s_options');
			add_settings_field('panoramio_s_paragraph',ucfirst(__('enable paragraph','szgoogleadmin')),array($this,'get_panoramio_s_paragraph'),'sz-google-admin-panoramio-s-options.php','sz_google_panoramio_s_options');

			// Definizione sezione per configurazione GOOGLE PANORAMIO WIDGET

			add_settings_section('sz_google_panoramio_w_options','',$this->callbacksection,'sz-google-admin-panoramio-w-options.php');
			add_settings_field('panoramio_w_template',ucfirst(__('default template','szgoogleadmin')),array($this,'get_panoramio_w_template'),'sz-google-admin-panoramio-w-options.php','sz_google_panoramio_w_options');
			add_settings_field('panoramio_w_width',ucfirst(__('default width','szgoogleadmin')),array($this,'get_panoramio_w_width'),'sz-google-admin-panoramio-w-options.php','sz_google_panoramio_w_options');
			add_settings_field('panoramio_w_height',ucfirst(__('default height','szgoogleadmin')),array($this,'get_panoramio_w_height'),'sz-google-admin-panoramio-w-options.php','sz_google_panoramio_w_options');
			add_settings_field('panoramio_w_orientation',ucfirst(__('default orientation','szgoogleadmin')),array($this,'get_panoramio_w_orientation'),'sz-google-admin-panoramio-w-options.php','sz_google_panoramio_w_options');
			add_settings_field('panoramio_w_list_size',ucfirst(__('default list size','szgoogleadmin')),array($this,'get_panoramio_w_list_size'),'sz-google-admin-panoramio-w-options.php','sz_google_panoramio_w_options');
			add_settings_field('panoramio_w_position',ucfirst(__('default position','szgoogleadmin')),array($this,'get_panoramio_w_position'),'sz-google-admin-panoramio-w-options.php','sz_google_panoramio_w_options');
		}

		/**
		 * Definizione delle funzioni per la creazione delle singole opzioni che vanno
		 * inserite nel form generale di configurazione e salvate sul database di wordpress
		 */
		function get_panoramio_shortcode()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_panoramio','panoramio_shortcode');
			$this->moduleCommonFormDescription(__('if you enable this option you can use the shortcode [sz-panoramio] and enter the corresponding component directly in your article or page. Normally shortcodes can be specified in the options, to control parameters given read the official documentation.','szgoogleadmin'));
		}

		function get_panoramio_widget()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_panoramio','panoramio_widget');
			$this->moduleCommonFormDescription(__('if you enable this option you will find the widget required in the administration menu of your widget and you can plug it into any sidebar defined in your theme. If you disable this option, remember not to leave the widget connected to existing sidebar.','szgoogleadmin'));
		}

		function get_panoramio_s_template() 
		{
			$values = array('photo'=>'photo','slideshow'=>'slideshow','list'=>'list','photo_list'=>'photo_list'); 
			$this->moduleCommonFormSelect('sz_google_options_panoramio','panoramio_s_template',$values,'medium','');
			$this->moduleCommonFormDescription(__('photo for a single-photo widget - slideshow for a single-photo widget with a play/pause button that automatically advances to the next photo - list for a photo-list widget - photo_list for a combination of a single-photo widget and a photo-list widget.','szgoogleadmin'));
		}

		function get_panoramio_s_width()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_panoramio','panoramio_s_width','medium',SZ_PLUGIN_GOOGLE_PANORAMIO_S_WIDTH);
			$this->moduleCommonFormDescription(__('with this field you can set the width of the container iframe that will be used by defaul, when not specified as a parameter of the shortcode, if you see a value equal "auto", the default size will be 100% and will occupy the entire space of parent container.','szgoogleadmin'));
		}

		function get_panoramio_s_height()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_panoramio','panoramio_s_height','medium',SZ_PLUGIN_GOOGLE_PANORAMIO_S_HEIGHT);
			$this->moduleCommonFormDescription(__('with this field you can set the height in pixels of the container iframe that will be used by defaul, when not specified as a parameter of the shortcode, if you see a value equal "auto", the default size will be 300 pixels.','szgoogleadmin'));
		}

		function get_panoramio_s_orientation() 
		{
			$values = array('horizontal'=>'horizontal','vertical'=>'vertical'); 
			$this->moduleCommonFormSelect('sz_google_options_panoramio','panoramio_s_orientation',$values,'medium','');
			$this->moduleCommonFormDescription(__('the orientation of the list. Valid values are horizontal and vertical. This controls the position of the arrows, the scrolling direction, and how the photos are sorted. The shape of the list, grid is controlled by the rows and columns options.','szgoogleadmin'));
		}

		function get_panoramio_s_list_size()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_panoramio','panoramio_s_list_size','medium',SZ_PLUGIN_GOOGLE_PANORAMIO_S_LIST_SIZE);
			$this->moduleCommonFormDescription(__('How many photos to show in the list. This option can only be specified with the template photo_list, for the other template, the option will be ignored. The list can be positioned in different ways, set the parameter "position" to the required value.','szgoogleadmin'));
		}

		function get_panoramio_s_position() 
		{
			$values = array('bottom'=>__('position bottom','szgoogleadmin'),'top'=>__('position top','szgoogleadmin'),'left'=>__('position left','szgoogleadmin'),'right'=>__('position right','szgoogleadmin')); 
			$this->moduleCommonFormSelect('sz_google_options_panoramio','panoramio_s_position',$values,'medium','');
			$this->moduleCommonFormDescription(__('Position of the photo list relative to the single-photo widget. Valid values are left, top, right and bottom. This option is valid only with the template photo_list, for the other template, the option will be ignored. The default value if not specified is "bottom".','szgoogleadmin'));
		}

		function get_panoramio_s_paragraph() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_panoramio','panoramio_s_paragraph');
			$this->moduleCommonFormDescription(__('if you enable this option will add a paragraph at the end of the widget, this to be compatible with the theme and use the same features css defined for the block section. If you do not want spacing paragraph disable this option.','szgoogleadmin'));
		}

		function get_panoramio_w_template() 
		{
			$values = array('photo'=>'photo','slideshow'=>'slideshow','list'=>'list','photo_list'=>'photo_list'); 
			$this->moduleCommonFormSelect('sz_google_options_panoramio','panoramio_w_template',$values,'medium','');
			$this->moduleCommonFormDescription(__('photo for a single-photo widget - slideshow for a single-photo widget with a play/pause button that automatically advances to the next photo - list for a photo-list widget - photo_list for a combination of a single-photo widget and a photo-list widget.','szgoogleadmin'));
		}

		function get_panoramio_w_width()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_panoramio','panoramio_w_width','medium',SZ_PLUGIN_GOOGLE_PANORAMIO_W_WIDTH);
			$this->moduleCommonFormDescription(__('with this field you can set the width of the container iframe that will be used by defaul, when not specified as a parameter of the widget, if you see a value equal "auto", the default size will be 100% and will occupy the entire space of parent container.','szgoogleadmin'));
		}

		function get_panoramio_w_height()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_panoramio','panoramio_w_height','medium',SZ_PLUGIN_GOOGLE_PANORAMIO_W_HEIGHT);
			$this->moduleCommonFormDescription(__('with this field you can set the height in pixels of the container iframe that will be used by defaul, when not specified as a parameter of the widget, if you see a value equal "auto", the default size will be 300 pixels.','szgoogleadmin'));
		}

		function get_panoramio_w_orientation() 
		{
			$values = array('horizontal'=>'horizontal','vertical'=>'vertical'); 
			$this->moduleCommonFormSelect('sz_google_options_panoramio','panoramio_w_orientation',$values,'medium','');
			$this->moduleCommonFormDescription(__('the orientation of the list. Valid values are horizontal and vertical. This controls the position of the arrows, the scrolling direction, and how the photos are sorted. The shape of the list, grid is controlled by the rows and columns options.','szgoogleadmin'));
		}

		function get_panoramio_w_list_size()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_panoramio','panoramio_w_list_size','medium',SZ_PLUGIN_GOOGLE_PANORAMIO_W_LIST_SIZE);
			$this->moduleCommonFormDescription(__('How many photos to show in the list. This option can only be specified with the template photo_list, for the other template, the option will be ignored. The list can be positioned in different ways, set the parameter "position" to the required value.','szgoogleadmin'));
		}

		function get_panoramio_w_position() 
		{
			$values = array('bottom'=>__('position bottom','szgoogleadmin'),'top'=>__('position top','szgoogleadmin'),'left'=>__('position left','szgoogleadmin'),'right'=>__('position right','szgoogleadmin')); 
			$this->moduleCommonFormSelect('sz_google_options_panoramio','panoramio_w_position',$values,'medium','');
			$this->moduleCommonFormDescription(__('Position of the photo list relative to the single-photo widget. Valid values are left, top, right and bottom. This option is valid only with the template photo_list, for the other template, the option will be ignored. The default value if not specified is "bottom".','szgoogleadmin'));
		}
	}
}