<?php

/**
 * Class for the definition of a widget that is
 * called by the class of the main module
 *
 * @package SZGoogle
 * @subpackage Widgets
 * @author Massimo Della Rovere
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Before the definition of the class, check if there is a definition
// with the same name or the same as previously defined in other script

if (!class_exists('SZGoogleWidgetYoutubeLink'))
{
	class SZGoogleWidgetYoutubeLink extends SZGoogleWidget
	{
		/**
		 * Definition the constructor function, which is called
		 * at the time of the creation of an instance of this class
		 */

		function __construct() 
		{
			parent::__construct('SZ-Google-Youtube-Link',__('SZ-Google - Youtube link','szgoogleadmin'),array(
				'classname'   => 'sz-widget-google sz-widget-google-youtube sz-widget-google-youtube-link', 
				'description' => ucfirst(__('youtube link.','szgoogleadmin'))
			));
		}

		/**
		 * Generation of the HTML code of the widget
		 * for the full display in the sidebar associated
		 */

		function widget($args,$instance) 
		{
			// Checking whether there are the variables that are used during the processing
			// the script and check the default values ​​in case they were not specified

			$options = $this->common_empty(array(
				'channel'      => '', // default value
				'subscription' => '', // default value
				'text'         => '', // default value
				'image'        => '', // default value
				'newtab'       => '', // default value
			),$instance);

			// Definition of the control variables of the widget, these values​
			// do not affect the items of basic but affect some aspects

			$controls = $this->common_empty(array(
				'method'      => '', // default value
			),$instance);

			// If the widget I selected to calculate the address from
			// the current post cancel the variable with any address

			if ($controls['method'] == '1') $options['channel'] = '';

			// Create the HTML code for the current widget recalling the basic
			// function which is also invoked by the corresponding shortcode

			$OBJC = new SZGoogleActionYoutubeLink();
			$HTML = $OBJC->getHTMLCode($options);

			// Output HTML code linked to the widget to
			// display call to the general standard for wrap

			echo $this->common_widget($args,$instance,$HTML);
		}

		/**
		 * Changing parameters related to the widget FORM 
		 * with storing the values ​​directly in the database
		 */

		function update($new_instance,$old_instance) 
		{
			// Esecuzione operazioni aggiuntive sui campi presenti
			// nel form widget prima della memorizzazione database

			return $this->common_update(array(
				'title'        => '0', // strip_tags
				'method'       => '1', // strip_tags
				'channel'      => '1', // strip_tags
				'subscription' => '1', // strip_tags
				'text'         => '1', // strip_tags
				'image'        => '1', // strip_tags
				'newtab'       => '1', // strip_tags
			),$new_instance,$old_instance);
		}

		/**
		 * FORM display the widget in the management of 
		 * sidebar in the administration panel of wordpress
		 */

		function form($instance) 
		{
			// Creating arrays for list fields that must be
			// present in the form before calling wp_parse_args()

			$array = array(
				'title'        => '', // default value
				'method'       => '', // default value
				'channel'      => '', // default value
				'subscription' => '', // default value
				'text'         => '', // default value
				'image'        => '', // default value
				'newtab'       => '', // default value
			);

			// Creating arrays for list of fields to be retrieved FORM
			// and loading the file with the HTML template to display

			extract(wp_parse_args($instance,$array),EXTR_OVERWRITE);

			// Setting any of the default parameters for the
			// fields that contain invalid values ​​or inconsistent

			if (!ctype_digit($method) or $method == 0) { $method = '1'; }

			// Calling the template for displaying the part 
			// that concerns the administration panel (admin)

			@include(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/admin/widgets/SZGoogleWidget.php');
			@include(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/admin/widgets/' .__CLASS__.'.php');
		}
	}
}