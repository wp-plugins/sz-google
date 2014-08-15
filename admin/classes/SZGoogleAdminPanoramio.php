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

			$this->sectionstabs = array(
				'01' => array('anchor' => 'shortcodes' ,'description' => __('shortcodes','szgoogleadmin')),
				'02' => array('anchor' => 'widgets'    ,'description' => __('widgets'   ,'szgoogleadmin')),
			);

			$this->sections = array(
				array('tab' => '01','section' => 'sz-google-admin-panoramio-s-enable.php' ,'title' => ucwords(__('activation','szgoogleadmin'))),
				array('tab' => '01','section' => 'sz-google-admin-panoramio-s-options.php','title' => ucwords(__('options','szgoogleadmin'))),
				array('tab' => '02','section' => 'sz-google-admin-panoramio-w-enable.php' ,'title' => ucwords(__('activation','szgoogleadmin'))),
				array('tab' => '02','section' => 'sz-google-admin-panoramio-w-options.php','title' => ucwords(__('options','szgoogleadmin'))),
			);

			$this->sectionstitle   = $this->menutitle;
			$this->sectionsoptions = array('sz_google_options_panoramio');

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
				'01' => array('section' => 'sz_google_panoramio_s_active' ,'title' => $this->null,'callback' => $this->callbacksection,'slug' => 'sz-google-admin-panoramio-s-enable.php'),
				'02' => array('section' => 'sz_google_panoramio_s_options','title' => $this->null,'callback' => $this->callbacksection,'slug' => 'sz-google-admin-panoramio-s-options.php'),
				'03' => array('section' => 'sz_google_panoramio_w_active' ,'title' => $this->null,'callback' => $this->callbacksection,'slug' => 'sz-google-admin-panoramio-w-enable.php'),
				'04' => array('section' => 'sz_google_panoramio_w_options','title' => $this->null,'callback' => $this->callbacksection,'slug' => 'sz-google-admin-panoramio-w-options.php'),
			);

			// Definizione array generale contenente elenco dei campi
			// che bisogna aggiungere alle sezioni precedentemente definite

			$this->sectionsfields = array
			(
				// Definizione sezione per configurazione GOOGLE PANORAMIO ACTIVATED

				'01' => array(
					array('field' => 'panoramio_shortcode'    ,'title' => ucfirst(__('shortcode'          ,'szgoogleadmin')),'callback' => array($this,'get_panoramio_shortcode')),
				),

				// Definizione sezione per configurazione GOOGLE PANORAMIO SHORTCODE

				'02' => array(
					array('field' => 'panoramio_s_template'   ,'title' => ucfirst(__('default template'   ,'szgoogleadmin')),'callback' => array($this,'get_panoramio_s_template')),
					array('field' => 'panoramio_s_width'      ,'title' => ucfirst(__('default width'      ,'szgoogleadmin')),'callback' => array($this,'get_panoramio_s_width')),
					array('field' => 'panoramio_s_height'     ,'title' => ucfirst(__('default height'     ,'szgoogleadmin')),'callback' => array($this,'get_panoramio_s_height')),
					array('field' => 'panoramio_s_orientation','title' => ucfirst(__('default orientation','szgoogleadmin')),'callback' => array($this,'get_panoramio_s_orientation')),
					array('field' => 'panoramio_s_list_size'  ,'title' => ucfirst(__('default list size'  ,'szgoogleadmin')),'callback' => array($this,'get_panoramio_s_list_size')),
					array('field' => 'panoramio_s_position'   ,'title' => ucfirst(__('default position'   ,'szgoogleadmin')),'callback' => array($this,'get_panoramio_s_position')),
					array('field' => 'panoramio_s_paragraph'  ,'title' => ucfirst(__('enable paragraph'   ,'szgoogleadmin')),'callback' => array($this,'get_panoramio_s_paragraph')),
				),

				// Definizione sezione per configurazione GOOGLE PANORAMIO ACTIVATED

				'03' => array(
					array('field' => 'panoramio_widget'       ,'title' => ucfirst(__('widget'             ,'szgoogleadmin')),'callback' => array($this,'get_panoramio_widget')),
				),


				// Definizione sezione per configurazione GOOGLE PANORAMIO WIDGET

				'04' => array(
					array('field' => 'panoramio_w_template'   ,'title' => ucfirst(__('default template'   ,'szgoogleadmin')),'callback' => array($this,'get_panoramio_w_template')),
					array('field' => 'panoramio_w_width'      ,'title' => ucfirst(__('default width'      ,'szgoogleadmin')),'callback' => array($this,'get_panoramio_w_width')),
					array('field' => 'panoramio_w_height'     ,'title' => ucfirst(__('default height'     ,'szgoogleadmin')),'callback' => array($this,'get_panoramio_w_height')),
					array('field' => 'panoramio_w_orientation','title' => ucfirst(__('default orientation','szgoogleadmin')),'callback' => array($this,'get_panoramio_w_orientation')),
					array('field' => 'panoramio_w_list_size'  ,'title' => ucfirst(__('default list size'  ,'szgoogleadmin')),'callback' => array($this,'get_panoramio_w_list_size')),
					array('field' => 'panoramio_w_position'   ,'title' => ucfirst(__('default position'   ,'szgoogleadmin')),'callback' => array($this,'get_panoramio_w_position')),
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
		function get_panoramio_shortcode()
		{
			$this->moduleCommonFormCheckboxYesNo('sz_google_options_panoramio','panoramio_shortcode');
			$this->moduleCommonFormDescription(sprintf(__('if you enable this option you can use the shortcode %s and enter the corresponding component directly in your article or page. Normally in the shortcodes can be specified the options for customizations.','szgoogleadmin'),'[sz-panoramio]'));
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
			$this->moduleCommonFormNumberStep1('sz_google_options_panoramio','panoramio_s_width','medium','auto');
			$this->moduleCommonFormDescription(__('with this field you can set the width of the container iframe that will be used by defaul, when not specified as a parameter of the shortcode, if you see a value equal "auto", the default size will be 100% and will occupy the entire space of parent container.','szgoogleadmin'));
		}

		function get_panoramio_s_height()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_panoramio','panoramio_s_height','medium','auto');
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
			$this->moduleCommonFormNumberStep1('sz_google_options_panoramio','panoramio_s_list_size','medium','6');
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
			$this->moduleCommonFormNumberStep1('sz_google_options_panoramio','panoramio_w_width','medium','auto');
			$this->moduleCommonFormDescription(__('with this field you can set the width of the container iframe that will be used by defaul, when not specified as a parameter of the widget, if you see a value equal "auto", the default size will be 100% and will occupy the entire space of parent container.','szgoogleadmin'));
		}

		function get_panoramio_w_height()
		{
			$this->moduleCommonFormNumberStep1('sz_google_options_panoramio','panoramio_w_height','medium','auto');
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
			$this->moduleCommonFormNumberStep1('sz_google_options_panoramio','panoramio_w_list_size','medium','6');
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