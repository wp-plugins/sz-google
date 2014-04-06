<?php
/**
 * Modulo GOOGLE DRIVE per la definizione delle funzioni che riguardano
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
if (!class_exists('SZGoogleAdminDrive'))
{
	class SZGoogleAdminDrive extends SZGoogleAdmin
	{
		/**
		 * Creazione del menu sul pannello di amministrazione usando
		 * come valori di configurazione le variabili object
		 *
		 * @return void
		 */
		function moduleAddMenu()
		{
			$this->menuslug   = 'sz-google-admin-drive.php';
			$this->pagetitle  = ucwords(__('google drive','szgoogleadmin'));
			$this->menutitle  = ucwords(__('google drive','szgoogleadmin'));

			// Definizione delle sezioni che devono essere composte in HTML
			// le sezioni devono essere passate come un array con nome => titolo

			$this->sectionstabs = array(
				'01' => array('anchor' => 'general' ,'description' => __('general','szgoogleadmin')),
				'02' => array('anchor' => 'embed'   ,'description' => __('embed'  ,'szgoogleadmin')),
				'03' => array('anchor' => 'viewer'  ,'description' => __('viewer' ,'szgoogleadmin')),
			);

			$this->sections = array(
				array('tab' => '01','section' => 'sz-google-admin-drive.php'                  ,'title' => ucwords(__('general setting','szgoogleadmin'))),
				array('tab' => '01','section' => 'sz-google-admin-drive-savebutton-enable.php','title' => ucwords(__('save to drive button','szgoogleadmin'))),
				array('tab' => '02','section' => 'sz-google-admin-drive-embed-enable-s.php'   ,'title' => ucwords(__('drive embed shortcode','szgoogleadmin'))),
				array('tab' => '02','section' => 'sz-google-admin-drive-embed-enable-w.php'   ,'title' => ucwords(__('drive embed widget','szgoogleadmin'))),
				array('tab' => '03','section' => 'sz-google-admin-drive-viewer-enable-s.php'  ,'title' => ucwords(__('drive viewer shortcode','szgoogleadmin'))),
				array('tab' => '03','section' => 'sz-google-admin-drive-viewer-enable-w.php'  ,'title' => ucwords(__('drive viewer widget','szgoogleadmin'))),
			);

			$this->sectionstitle   = $this->menutitle;
			$this->sectionsoptions = 'sz_google_options_drive';

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

			// Definizione sezione per configurazione GOOGLE DRIVE

			add_settings_section('sz_google_drive_section','',$this->callbacksection,'sz-google-admin-drive.php');
			add_settings_field('drive_sitename',ucfirst(__('site name','szgoogleadmin')),array($this,'get_drive_sitename'),'sz-google-admin-drive.php','sz_google_drive_section');

			// Definizione sezione per configurazione GOOGLE DRIVE EMBED

			add_settings_section('sz_google_drive_embed_s','',$this->callbacksection,'sz-google-admin-drive-embed-enable-s.php');
			add_settings_field('drive_embed_shortcode',ucwords(__('enable shortcode','szgoogleadmin')),array($this,'get_drive_embed_shortcode'),'sz-google-admin-drive-embed-enable-s.php','sz_google_drive_embed_s');
			add_settings_field('drive_embed_s_width',ucfirst(__('default width','szgoogleadmin')),array($this,'get_drive_embed_s_width'),'sz-google-admin-drive-embed-enable-s.php','sz_google_drive_embed_s');
			add_settings_field('drive_embed_s_height',ucfirst(__('default height','szgoogleadmin')),array($this,'get_drive_embed_s_height'),'sz-google-admin-drive-embed-enable-s.php','sz_google_drive_embed_s');
			add_settings_field('drive_embed_s_height_p',ucfirst(__('presentation height','szgoogleadmin')),array($this,'get_drive_embed_s_height_p'),'sz-google-admin-drive-embed-enable-s.php','sz_google_drive_embed_s');
			add_settings_field('drive_embed_s_height_v',ucfirst(__('video height','szgoogleadmin')),array($this,'get_drive_embed_s_height_v'),'sz-google-admin-drive-embed-enable-s.php','sz_google_drive_embed_s');

			// Definizione sezione per configurazione GOOGLE DRIVE EMBED

			add_settings_section('sz_google_drive_embed_w','',$this->callbacksection,'sz-google-admin-drive-embed-enable-w.php');
			add_settings_field('drive_embed_widget',ucwords(__('enable widget','szgoogleadmin')),array($this,'get_drive_embed_widget'),'sz-google-admin-drive-embed-enable-w.php','sz_google_drive_embed_w');
			add_settings_field('drive_embed_w_width',ucfirst(__('default width','szgoogleadmin')),array($this,'get_drive_embed_w_width'),'sz-google-admin-drive-embed-enable-w.php','sz_google_drive_embed_w');
			add_settings_field('drive_embed_w_height',ucfirst(__('default height','szgoogleadmin')),array($this,'get_drive_embed_w_height'),'sz-google-admin-drive-embed-enable-w.php','sz_google_drive_embed_w');
			add_settings_field('drive_embed_w_height_p',ucfirst(__('presentation height','szgoogleadmin')),array($this,'get_drive_embed_w_height_p'),'sz-google-admin-drive-embed-enable-w.php','sz_google_drive_embed_w');
			add_settings_field('drive_embed_w_height_v',ucfirst(__('video height','szgoogleadmin')),array($this,'get_drive_embed_w_height_v'),'sz-google-admin-drive-embed-enable-w.php','sz_google_drive_embed_w');

			// Definizione sezione per configurazione GOOGLE DRIVE VIEWER

			add_settings_section('sz_google_drive_viewer_s','',$this->callbacksection,'sz-google-admin-drive-viewer-enable-s.php');
			add_settings_field('drive_viewer_shortcode',ucwords(__('enable shortcode','szgoogleadmin')),array($this,'get_drive_viewer_shortcode'),'sz-google-admin-drive-viewer-enable-s.php','sz_google_drive_viewer_s');
			add_settings_field('drive_viewer_s_width',ucfirst(__('default width','szgoogleadmin')),array($this,'get_drive_viewer_s_width'),'sz-google-admin-drive-viewer-enable-s.php','sz_google_drive_viewer_s');
			add_settings_field('drive_viewer_s_height',ucfirst(__('default height','szgoogleadmin')),array($this,'get_drive_viewer_s_height'),'sz-google-admin-drive-viewer-enable-s.php','sz_google_drive_viewer_s');
			add_settings_field('drive_viewer_s_t_position',ucfirst(__('title position','szgoogleadmin')),array($this,'get_drive_viewer_s_t_position'),'sz-google-admin-drive-viewer-enable-s.php','sz_google_drive_viewer_s');
			add_settings_field('drive_viewer_s_t_align',ucfirst(__('title alignment','szgoogleadmin')),array($this,'get_drive_viewer_s_t_align'),'sz-google-admin-drive-viewer-enable-s.php','sz_google_drive_viewer_s');

			// Definizione sezione per configurazione GOOGLE DRIVE VIEWER

			add_settings_section('sz_google_drive_viewer_w','',$this->callbacksection,'sz-google-admin-drive-viewer-enable-w.php');
			add_settings_field('drive_viewer_widget',ucwords(__('enable widget','szgoogleadmin')),array($this,'get_drive_viewer_widget'),'sz-google-admin-drive-viewer-enable-w.php','sz_google_drive_viewer_w');
			add_settings_field('drive_viewer_w_width',ucfirst(__('default width','szgoogleadmin')),array($this,'get_drive_viewer_w_width'),'sz-google-admin-drive-viewer-enable-w.php','sz_google_drive_viewer_w');
			add_settings_field('drive_viewer_w_height',ucfirst(__('default height','szgoogleadmin')),array($this,'get_drive_viewer_w_height'),'sz-google-admin-drive-viewer-enable-w.php','sz_google_drive_viewer_w');
			add_settings_field('drive_viewer_w_t_position',ucfirst(__('title position','szgoogleadmin')),array($this,'get_drive_viewer_w_t_position'),'sz-google-admin-drive-viewer-enable-w.php','sz_google_drive_viewer_w');
			add_settings_field('drive_viewer_w_t_align',ucfirst(__('title alignment','szgoogleadmin')),array($this,'get_drive_viewer_w_t_align'),'sz-google-admin-drive-viewer-enable-w.php','sz_google_drive_viewer_w');

			// Definizione sezione per configurazione GOOGLE DRIVE SAVE BUTTON

			add_settings_section('sz_google_drive_savebutton','',$this->callbacksection,'sz-google-admin-drive-savebutton-enable.php');
			add_settings_field('drive_savebutton_shortcode',ucwords(__('enable shortcode','szgoogleadmin')),array($this,'get_drive_savebutton_shortcode'),'sz-google-admin-drive-savebutton-enable.php','sz_google_drive_savebutton');
			add_settings_field('drive_savebutton_widget',ucwords(__('enable widget','szgoogleadmin')),array($this,'get_drive_savebutton_widget'),'sz-google-admin-drive-savebutton-enable.php','sz_google_drive_savebutton');
		}

		/**
		 * Definizione delle funzioni per la creazione delle singole opzioni che vanno
		 * inserite nel form generale di configurazione e salvate sul database di wordpress
		 */
		function get_drive_sitename() 
		{
			$this->moduleCommonFormText('sz_google_options_drive','drive_sitename','large',__('insert your site name','szgoogleadmin'));
			$this->moduleCommonFormDescription(__('some functions google drive require the information of the name of the site where the operation took place, you can use this field to customize the name, otherwise it will use the default value in wordpress. See general setting in wordpress admin panel.','szgoogleadmin'));
		}

		function get_drive_embed_shortcode() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_drive','drive_embed_shortcode');
			$this->moduleCommonFormDescription(sprintf(__('if you enable this option you can use the shortcode %s and enter the corresponding component directly in your article or page. Normally in the shortcodes can be specified the options for customizations.','szgoogleadmin'),'[sz-drive-embed]'));
		}

		function get_drive_embed_s_width()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_drive','drive_embed_s_width','medium',SZ_PLUGIN_GOOGLE_DRIVE_EMBED_S_WIDTH);
			$this->moduleCommonFormDescription(__('with this field you can set the width of the container iframe that will be used by defaul, when not specified as a parameter of the shortcode, if you see a value equal "auto", the default size will be 100% and will occupy the entire space of parent container.','szgoogleadmin'));
		}

		function get_drive_embed_s_height()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_drive','drive_embed_s_height','medium',SZ_PLUGIN_GOOGLE_DRIVE_EMBED_S_HEIGHT);
			$this->moduleCommonFormDescription(__('with this field you can set the height in pixels of the container iframe that will be used by defaul, when not specified as a parameter of the shortcode, if you see a value equal "auto", will be used the default size of the plugin.','szgoogleadmin'));
		}

		function get_drive_embed_s_height_p()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_drive','drive_embed_s_height_p','medium',SZ_PLUGIN_GOOGLE_DRIVE_EMBED_S_HEIGHT);
			$this->moduleCommonFormDescription(__('with this field you can set the height in pixels of the container iframe that will be used by defaul, when not specified as a parameter of the shortcode, if you see a value equal "auto", will be used the default size of the plugin.','szgoogleadmin'));
		}

		function get_drive_embed_s_height_v()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_drive','drive_embed_s_height_v','medium',SZ_PLUGIN_GOOGLE_DRIVE_EMBED_S_HEIGHT);
			$this->moduleCommonFormDescription(__('with this field you can set the height in pixels of the container iframe that will be used by defaul, when not specified as a parameter of the shortcode, if you see a value equal "auto", will be used the default size of the plugin.','szgoogleadmin'));
		}

		function get_drive_embed_widget() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_drive','drive_embed_widget');
			$this->moduleCommonFormDescription(__('if you enable this option you will find the widget required in the administration menu of your widget and you can plug it into any sidebar defined in your theme. If you disable this option, remember not to leave the widget connected to existing sidebar.','szgoogleadmin'));
		}

		function get_drive_embed_w_width()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_drive','drive_embed_w_width','medium',SZ_PLUGIN_GOOGLE_DRIVE_EMBED_W_WIDTH);
			$this->moduleCommonFormDescription(__('with this field you can set the width of the container iframe that will be used by defaul, when not specified as a parameter of the shortcode, if you see a value equal "auto", the default size will be 100% and will occupy the entire space of parent container.','szgoogleadmin'));
		}

		function get_drive_embed_w_height()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_drive','drive_embed_w_height','medium',SZ_PLUGIN_GOOGLE_DRIVE_EMBED_W_HEIGHT);
			$this->moduleCommonFormDescription(__('with this field you can set the height in pixels of the container iframe that will be used by defaul, when not specified as a parameter of the shortcode, if you see a value equal "auto", will be used the default size of the plugin.','szgoogleadmin'));
		}

		function get_drive_embed_w_height_p()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_drive','drive_embed_w_height_p','medium',SZ_PLUGIN_GOOGLE_DRIVE_EMBED_W_HEIGHT);
			$this->moduleCommonFormDescription(__('with this field you can set the height in pixels of the container iframe that will be used by defaul, when not specified as a parameter of the shortcode, if you see a value equal "auto", will be used the default size of the plugin.','szgoogleadmin'));
		}

		function get_drive_embed_w_height_v()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_drive','drive_embed_w_height_w','medium',SZ_PLUGIN_GOOGLE_DRIVE_EMBED_W_HEIGHT);
			$this->moduleCommonFormDescription(__('with this field you can set the height in pixels of the container iframe that will be used by defaul, when not specified as a parameter of the shortcode, if you see a value equal "auto", will be used the default size of the plugin.','szgoogleadmin'));
		}

		function get_drive_viewer_shortcode() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_drive','drive_viewer_shortcode');
			$this->moduleCommonFormDescription(sprintf(__('if you enable this option you can use the shortcode %s and enter the corresponding component directly in your article or page. Normally in the shortcodes can be specified the options for customizations.','szgoogleadmin'),'[sz-drive-viewer]'));
		}

		function get_drive_viewer_s_width()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_drive','drive_viewer_s_width','medium',SZ_PLUGIN_GOOGLE_DRIVE_VIEWER_S_WIDTH);
			$this->moduleCommonFormDescription(__('with this field you can set the width of the container iframe that will be used by defaul, when not specified as a parameter of the shortcode, if you see a value equal "auto", the default size will be 100% and will occupy the entire space of parent container.','szgoogleadmin'));
		}

		function get_drive_viewer_s_height()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_drive','drive_viewer_s_height','medium',SZ_PLUGIN_GOOGLE_DRIVE_VIEWER_S_HEIGHT);
			$this->moduleCommonFormDescription(__('with this field you can set the height in pixels of the container iframe that will be used by defaul, when not specified as a parameter of the shortcode, if you see a value equal "auto", will be used the default size of the plugin.','szgoogleadmin'));
		}

		function get_drive_viewer_s_t_position()
		{
			$values = array('top'=>__('top','szgoogleadmin'),'bottom'=>__('bottom','szgoogleadmin'));
			$this->moduleCommonFormSelect('sz_google_options_drive','drive_viewer_s_t_position',$values,'medium','');
			$this->moduleCommonFormDescription(__('this option indicates the position of the title, just in case this option is specified as "title". We can enter the title of the widget display before or soon after. To use a customized CSS class specified in the wrapper.','szgoogleadmin'));
		}

		function get_drive_viewer_s_t_align()
		{
			$values = array(
				'none'  =>__('none'  ,'szgoogleadmin'),
				'left'  =>__('left'  ,'szgoogleadmin'),
				'center'=>__('center','szgoogleadmin'),
				'right' =>__('right' ,'szgoogleadmin'),
			);

			$this->moduleCommonFormSelect('sz_google_options_drive','drive_viewer_s_t_align',$values,'medium','');
			$this->moduleCommonFormDescription(__('this option indicates the type of alignment to apply to the title, is used only when the "title" attribute is specified, you can specify the following special values​​: "none", "left", "center" and "right". Use this value together with that of position.','szgoogleadmin'));
		}

		function get_drive_viewer_widget() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_drive','drive_viewer_widget');
			$this->moduleCommonFormDescription(__('if you enable this option you will find the widget required in the administration menu of your widget and you can plug it into any sidebar defined in your theme. If you disable this option, remember not to leave the widget connected to existing sidebar.','szgoogleadmin'));
		}

		function get_drive_viewer_w_width()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_drive','drive_viewer_w_width','medium',SZ_PLUGIN_GOOGLE_DRIVE_VIEWER_W_WIDTH);
			$this->moduleCommonFormDescription(__('with this field you can set the width of the container iframe that will be used by defaul, when not specified as a parameter of the shortcode, if you see a value equal "auto", the default size will be 100% and will occupy the entire space of parent container.','szgoogleadmin'));
		}

		function get_drive_viewer_w_height()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_drive','drive_viewer_w_height','medium',SZ_PLUGIN_GOOGLE_DRIVE_VIEWER_W_HEIGHT);
			$this->moduleCommonFormDescription(__('with this field you can set the height in pixels of the container iframe that will be used by defaul, when not specified as a parameter of the shortcode, if you see a value equal "auto", will be used the default size of the plugin.','szgoogleadmin'));
		}

		function get_drive_viewer_w_t_position()
		{
			$values = array('top'=>__('top','szgoogleadmin'),'bottom'=>__('bottom','szgoogleadmin'));
			$this->moduleCommonFormSelect('sz_google_options_drive','drive_viewer_w_t_position',$values,'medium','');
			$this->moduleCommonFormDescription(__('this option indicates the position of the title, just in case this option is specified as "title". We can enter the title of the widget display before or soon after. To use a customized CSS class specified in the wrapper.','szgoogleadmin'));
		}

		function get_drive_viewer_w_t_align()
		{
			$values = array(
				'none'  =>__('none'  ,'szgoogleadmin'),
				'left'  =>__('left'  ,'szgoogleadmin'),
				'center'=>__('center','szgoogleadmin'),
				'right' =>__('right' ,'szgoogleadmin'),
			);

			$this->moduleCommonFormSelect('sz_google_options_drive','drive_viewer_w_t_align',$values,'medium','');
			$this->moduleCommonFormDescription(__('this option indicates the type of alignment to apply to the title, is used only when the "title" attribute is specified, you can specify the following special values​​: "none", "left", "center" and "right". Use this value together with that of position.','szgoogleadmin'));
		}

		function get_drive_savebutton_shortcode() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_drive','drive_savebutton_shortcode');
			$this->moduleCommonFormDescription(sprintf(__('if you enable this option you can use the shortcode %s and enter the corresponding component directly in your article or page. Normally in the shortcodes can be specified the options for customizations.','szgoogleadmin'),'[sz-drive-save]'));
		}

		function get_drive_savebutton_widget() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_drive','drive_savebutton_widget');
			$this->moduleCommonFormDescription(__('if you enable this option you will find the widget required in the administration menu of your widget and you can plug it into any sidebar defined in your theme. If you disable this option, remember not to leave the widget connected to existing sidebar.','szgoogleadmin'));
		}
	}
}