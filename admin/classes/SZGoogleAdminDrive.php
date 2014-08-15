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
				array('tab' => '01','section' => 'sz-google-admin-drive.php'                  ,'title' => ucwords(__('settings'        ,'szgoogleadmin'))),
				array('tab' => '01','section' => 'sz-google-admin-drive-savebutton-enable.php','title' => ucwords(__('save to drive'   ,'szgoogleadmin'))),
				array('tab' => '02','section' => 'sz-google-admin-drive-embed-enable-s.php'   ,'title' => ucwords(__('embed shortcode' ,'szgoogleadmin'))),
				array('tab' => '02','section' => 'sz-google-admin-drive-embed-enable-w.php'   ,'title' => ucwords(__('embed widget'    ,'szgoogleadmin'))),
				array('tab' => '03','section' => 'sz-google-admin-drive-viewer-enable-s.php'  ,'title' => ucwords(__('viewer shortcode','szgoogleadmin'))),
				array('tab' => '03','section' => 'sz-google-admin-drive-viewer-enable-w.php'  ,'title' => ucwords(__('viewer widget'   ,'szgoogleadmin'))),
			);

			$this->sectionstitle   = $this->menutitle;
			$this->sectionsoptions = array('sz_google_options_drive');

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
				'01' => array('section' => 'sz_google_drive_section'   ,'title' => $this->null,'callback' => $this->callbacksection,'slug' => 'sz-google-admin-drive.php'),
				'02' => array('section' => 'sz_google_drive_savebutton','title' => $this->null,'callback' => $this->callbacksection,'slug' => 'sz-google-admin-drive-savebutton-enable.php'),
				'03' => array('section' => 'sz_google_drive_embed_s'   ,'title' => $this->null,'callback' => $this->callbacksection,'slug' => 'sz-google-admin-drive-embed-enable-s.php'),
				'04' => array('section' => 'sz_google_drive_embed_w'   ,'title' => $this->null,'callback' => $this->callbacksection,'slug' => 'sz-google-admin-drive-embed-enable-w.php'),
				'05' => array('section' => 'sz_google_drive_viewer_s'  ,'title' => $this->null,'callback' => $this->callbacksection,'slug' => 'sz-google-admin-drive-viewer-enable-s.php'),
				'06' => array('section' => 'sz_google_drive_viewer_w'  ,'title' => $this->null,'callback' => $this->callbacksection,'slug' => 'sz-google-admin-drive-viewer-enable-w.php'),
			);

			// Definizione array generale contenente elenco dei campi
			// che bisogna aggiungere alle sezioni precedentemente definite

			$this->sectionsfields = array
			(
				// Definizione sezione per configurazione GOOGLE DRIVE

				'01' => array(
					array('field' => 'drive_sitename'            ,'title' => ucfirst(__('site name'          ,'szgoogleadmin')),'callback' => array($this,'get_drive_sitename')),
				),

				// Definizione sezione per configurazione GOOGLE DRIVE SAVE BUTTON

				'02' => array(
					array('field' => 'drive_savebutton_shortcode','title' => ucfirst(__('shortcode'          ,'szgoogleadmin')),'callback' => array($this,'get_drive_savebutton_shortcode')),
					array('field' => 'drive_savebutton_widget'   ,'title' => ucfirst(__('widget'             ,'szgoogleadmin')),'callback' => array($this,'get_drive_savebutton_widget')),
				),

				// Definizione sezione per configurazione GOOGLE DRIVE EMBED

				'03' => array(
					array('field' => 'drive_embed_shortcode'     ,'title' => ucfirst(__('shortcode'          ,'szgoogleadmin')),'callback' => array($this,'get_drive_embed_shortcode')),
					array('field' => 'drive_embed_s_width'       ,'title' => ucfirst(__('default width'      ,'szgoogleadmin')),'callback' => array($this,'get_drive_embed_s_width')),
					array('field' => 'drive_embed_s_height'      ,'title' => ucfirst(__('default height'     ,'szgoogleadmin')),'callback' => array($this,'get_drive_embed_s_height')),
					array('field' => 'drive_embed_s_height_p'    ,'title' => ucfirst(__('presentation height','szgoogleadmin')),'callback' => array($this,'get_drive_embed_s_height_p')),
					array('field' => 'drive_embed_s_height_v'    ,'title' => ucfirst(__('video height'       ,'szgoogleadmin')),'callback' => array($this,'get_drive_embed_s_height_v')),
				),

				// Definizione sezione per configurazione GOOGLE DRIVE EMBED

				'04' => array(
					array('field' => 'drive_embed_widget'        ,'title' => ucfirst(__('widget'             ,'szgoogleadmin')),'callback' => array($this,'get_drive_embed_widget')),
					array('field' => 'drive_embed_w_width'       ,'title' => ucfirst(__('default width'      ,'szgoogleadmin')),'callback' => array($this,'get_drive_embed_w_width')),
					array('field' => 'drive_embed_w_height'      ,'title' => ucfirst(__('default height'     ,'szgoogleadmin')),'callback' => array($this,'get_drive_embed_w_height')),
					array('field' => 'drive_embed_w_height_p'    ,'title' => ucfirst(__('presentation height','szgoogleadmin')),'callback' => array($this,'get_drive_embed_w_height_p')),
					array('field' => 'drive_embed_w_height_v'    ,'title' => ucfirst(__('video height'       ,'szgoogleadmin')),'callback' => array($this,'get_drive_embed_w_height_v')),
				),

				// Definizione sezione per configurazione GOOGLE DRIVE VIEWER

				'05' => array(
					array('field' => 'drive_viewer_shortcode'    ,'title' => ucfirst(__('shortcode'          ,'szgoogleadmin')),'callback' => array($this,'get_drive_viewer_shortcode')),
					array('field' => 'drive_viewer_s_width'      ,'title' => ucfirst(__('default width'      ,'szgoogleadmin')),'callback' => array($this,'get_drive_viewer_s_width')),
					array('field' => 'drive_viewer_s_height'     ,'title' => ucfirst(__('default height'     ,'szgoogleadmin')),'callback' => array($this,'get_drive_viewer_s_height')),
					array('field' => 'drive_viewer_s_t_position' ,'title' => ucfirst(__('title position'     ,'szgoogleadmin')),'callback' => array($this,'get_drive_viewer_s_t_position')),
					array('field' => 'drive_viewer_s_t_align'    ,'title' => ucfirst(__('title alignment'    ,'szgoogleadmin')),'callback' => array($this,'get_drive_viewer_s_t_align')),
				),

				// Definizione sezione per configurazione GOOGLE DRIVE VIEWER

				'06' => array(
					array('field' => 'drive_viewer_widget'       ,'title' => ucfirst(__('widget'             ,'szgoogleadmin')),'callback' => array($this,'get_drive_viewer_widget')),
					array('field' => 'drive_viewer_w_width'      ,'title' => ucfirst(__('default width'      ,'szgoogleadmin')),'callback' => array($this,'get_drive_viewer_w_width')),
					array('field' => 'drive_viewer_w_height'     ,'title' => ucfirst(__('default height'     ,'szgoogleadmin')),'callback' => array($this,'get_drive_viewer_w_height')),
					array('field' => 'drive_viewer_w_t_position' ,'title' => ucfirst(__('title position'     ,'szgoogleadmin')),'callback' => array($this,'get_drive_viewer_w_t_position')),
					array('field' => 'drive_viewer_w_t_align'    ,'title' => ucfirst(__('title alignment'    ,'szgoogleadmin')),'callback' => array($this,'get_drive_viewer_w_t_align')),
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
			$this->moduleCommonFormNumberStep1('sz_google_options_drive','drive_embed_s_width','medium','auto');
			$this->moduleCommonFormDescription(__('with this field you can set the width of the container iframe that will be used by defaul, when not specified as a parameter of the shortcode, if you see a value equal "auto", the default size will be 100% and will occupy the entire space of parent container.','szgoogleadmin'));
		}

		function get_drive_embed_s_height()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_drive','drive_embed_s_height','medium','auto');
			$this->moduleCommonFormDescription(__('with this field you can set the height in pixels of the container iframe that will be used by defaul, when not specified as a parameter of the shortcode, if you see a value equal "auto", will be used the default size of the plugin.','szgoogleadmin'));
		}

		function get_drive_embed_s_height_p()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_drive','drive_embed_s_height_p','medium','auto');
			$this->moduleCommonFormDescription(__('with this field you can set the height in pixels of the container iframe that will be used by defaul, when not specified as a parameter of the shortcode, if you see a value equal "auto", will be used the default size of the plugin.','szgoogleadmin'));
		}

		function get_drive_embed_s_height_v()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_drive','drive_embed_s_height_v','medium','auto');
			$this->moduleCommonFormDescription(__('with this field you can set the height in pixels of the container iframe that will be used by defaul, when not specified as a parameter of the shortcode, if you see a value equal "auto", will be used the default size of the plugin.','szgoogleadmin'));
		}

		function get_drive_embed_widget() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_drive','drive_embed_widget');
			$this->moduleCommonFormDescription(__('if you enable this option you will find the widget required in the administration menu of your widget and you can plug it into any sidebar defined in your theme. If you disable this option, remember not to leave the widget connected to existing sidebar.','szgoogleadmin'));
		}

		function get_drive_embed_w_width()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_drive','drive_embed_w_width','medium','auto');
			$this->moduleCommonFormDescription(__('with this field you can set the width of the container iframe that will be used by defaul, when not specified as a parameter of the shortcode, if you see a value equal "auto", the default size will be 100% and will occupy the entire space of parent container.','szgoogleadmin'));
		}

		function get_drive_embed_w_height()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_drive','drive_embed_w_height','medium','auto');
			$this->moduleCommonFormDescription(__('with this field you can set the height in pixels of the container iframe that will be used by defaul, when not specified as a parameter of the shortcode, if you see a value equal "auto", will be used the default size of the plugin.','szgoogleadmin'));
		}

		function get_drive_embed_w_height_p()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_drive','drive_embed_w_height_p','medium','auto');
			$this->moduleCommonFormDescription(__('with this field you can set the height in pixels of the container iframe that will be used by defaul, when not specified as a parameter of the shortcode, if you see a value equal "auto", will be used the default size of the plugin.','szgoogleadmin'));
		}

		function get_drive_embed_w_height_v()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_drive','drive_embed_w_height_w','medium','auto');
			$this->moduleCommonFormDescription(__('with this field you can set the height in pixels of the container iframe that will be used by defaul, when not specified as a parameter of the shortcode, if you see a value equal "auto", will be used the default size of the plugin.','szgoogleadmin'));
		}

		function get_drive_viewer_shortcode() 
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_drive','drive_viewer_shortcode');
			$this->moduleCommonFormDescription(sprintf(__('if you enable this option you can use the shortcode %s and enter the corresponding component directly in your article or page. Normally in the shortcodes can be specified the options for customizations.','szgoogleadmin'),'[sz-drive-viewer]'));
		}

		function get_drive_viewer_s_width()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_drive','drive_viewer_s_width','medium','auto');
			$this->moduleCommonFormDescription(__('with this field you can set the width of the container iframe that will be used by defaul, when not specified as a parameter of the shortcode, if you see a value equal "auto", the default size will be 100% and will occupy the entire space of parent container.','szgoogleadmin'));
		}

		function get_drive_viewer_s_height()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_drive','drive_viewer_s_height','medium','auto');
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
			$this->moduleCommonFormNumberStep1('sz_google_options_drive','drive_viewer_w_width','medium','auto');
			$this->moduleCommonFormDescription(__('with this field you can set the width of the container iframe that will be used by defaul, when not specified as a parameter of the shortcode, if you see a value equal "auto", the default size will be 100% and will occupy the entire space of parent container.','szgoogleadmin'));
		}

		function get_drive_viewer_w_height()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_drive','drive_viewer_w_height','medium','auto');
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