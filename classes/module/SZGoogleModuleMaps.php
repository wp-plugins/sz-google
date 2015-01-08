<?php

/**
 * Module to the definition of the functions that relate to both the
 * widgets that shortcode, but also filters and actions that the module
 * can integrating with adding functionality into wordpress.
 *
 * @package SZGoogle
 * @subpackage Modules
 * @author Massimo Della Rovere
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Before the definition of the class, check if there is a definition 
// with the same name or the same as previously defined in other script.

if (!class_exists('SZGoogleModuleMaps'))
{
	class SZGoogleModuleMaps extends SZGoogleModule
	{
		private $setJavascriptMaps    = false;
		private $setJavascriptOptions = array();

		/**
		 * Definition of the initial variable array which are
		 * used to identify the module and options related to it
		 */

		function moduleAddSetup()
		{
			$this->moduleSetClassName(__CLASS__);
			$this->moduleSetOptionSet('sz_google_options_maps');
			
			// Definition shortcode connected to the module with an array where you
			// have to specify the name activation option with the shortcode and function

			$this->moduleSetShortcodes(array(
				'maps_s_enable' => array('sz-maps',array(new SZGoogleActionMaps(),'getShortcode')),
			));

			// Definition widgets connected to the module with an array where you
			// have to specify the name option of activating and class to be loaded

			$this->moduleSetWidgets(array(
				'maps_w_enable'    => 'SZGoogleWidgetMaps',
			));
		}

		/**
		 * Add the Javascript code in the various components
		 * of google plus footer and if control was performed
		 */

		function addCodeJavascriptFooter($options=array())
		{
			if (is_array($options) and !empty($options)) {
				$this->setJavascriptOptions[] = (object) $options;
			}

			// If you've already entered the Javascript code in the footer section
			// I leave the function otherwise set the variable and constant

			if ($this->setJavascriptMaps) return;
				else $this->setJavascriptMaps = true;

			// Loading action in the footer of the plugin to load
			// the javascript framework made available by google

			add_action('SZ_FOOT',array($this,'setJavascriptMaps'));
		}

		/**
		 * Function to add javascript code in the footer of wordpress
		 * with asynchronous loading method according to google
		 */

		function setJavascriptMaps()
		{
			// If you've already entered the Javascript code in the footer section
			// leave the partition function otherwise the variable and constant

			if (self::$JavascriptMaps) return;
				else self::$JavascriptMaps = true;

			// Definition of parameters to be passed to 
			// the javascript framework of google maps

			$parameters = 'v3=&callback=szgooglemapsinit';

			// Check if instance of google maps is active otherwise
			// insert the code without customization parameters

			if ($object = self::getObject('SZGoogleModuleMaps')) 
			{
				$options = (object) $object->getOptions();

				if ($options->maps_key    != '' ) $parameters .= '&key='.$options->maps_key;
				if ($options->maps_signin == '1') $parameters .= '&signed_in=true';
				if ($options->maps_sensor == '1') $parameters .= '&sensor=true';

				if ($options->maps_language == '99') $parameters .= '&language='.substr(get_bloginfo('language'),0,2);
					else $parameters .= '&language='.$options->maps_language;
			}

			// Correct image for google maps when img present in
			// webiste and have a CSS width max-image=100% (hack)

			$javascript  = '<style>';
			$javascript .= '.sz-google-maps img { max-width:none } ';
			$javascript .= '.sz-google-maps label { width:auto; display:inline }';
			$javascript .= '</style>'."\n";

			// Javascript code to render the component google+
			// this method is used for asynchronous loading

			$javascript .= '<script>';
			$javascript .= 'function szgooglemapsinit() {';

			// Creating Javascript code dynamically based on the number of available maps
			// For each map is created by a unique key identification to allow more maps

			if (isset($this->setJavascriptOptions) and is_array($this->setJavascriptOptions)) 
			{
				foreach ($this->setJavascriptOptions as $key => $value) 
				{
					if (is_object($value) and isset($value->idHTML)) 
					{
						$javascript .= 	'var map_opt_'.$value->unique.' = {';
						$javascript .= 	'zoom:'.$value->zoom.',';
						$javascript .= 	'panControl:true,';
						$javascript .= 	'zoomControl:true,';
						$javascript .= 	'mapTypeControl:true,';
						$javascript .= 	'scaleControl:true,';
						$javascript .= 	'streetViewControl:true,';
						$javascript .= 	'overviewMapControl:true,';
						$javascript .= 	'center:new google.maps.LatLng('.$value->lat.','.$value->lng.'),';
						$javascript .= 	'mapTypeId:google.maps.MapTypeId.'.$value->view;
						$javascript .= '};';

						$javascript .= "if(document.getElementById('".$value->idHTML."') != null && document.getElementById('".$value->idHTML."') != undefined) {";
						$javascript .= "var map_key_".$value->unique." = ";
						$javascript .= "new google.maps.Map(document.getElementById('".$value->idHTML."'),map_opt_".$value->unique.");";
						$javascript .= "}";

						// Add the layer BICYCLE/TRAFFIC/TRANSIT to the map display
						// Each map has a unique code that the layer must be associated

						if ($value->layer == 'BICYCLE') {
							$javascript .= 'var layer_bicycle_'.$value->unique.' = new google.maps.BicyclingLayer();';
							$javascript .= 'layer_bicycle_'.$value->unique.'.setMap(map_key_'.$value->unique.');';
						}

						if ($value->layer == 'TRAFFIC') {
							$javascript .= 'var layer_traffic_'.$value->unique.' = new google.maps.TrafficLayer();';
							$javascript .= 'layer_traffic_'.$value->unique.'.setMap(map_key_'.$value->unique.');';
						}

						if ($value->layer == 'TRANSIT') {
							$javascript .= 'var layer_transit_'.$value->unique.' = new google.maps.TransitLayer();';
							$javascript .= 'layer_transit_'.$value->unique.'.setMap(map_key_'.$value->unique.');';
						}
					}
				}
			}

			$javascript .= '}';
			$javascript .= '</script>'."\n";

			// Procedure Asynchronous loading of javascript code
			// and the function is called for initial operations

			$javascript .= '<script>';
			$javascript .= 'function szgooglemapsload() {';
			$javascript .= 	"var script = document.createElement('script');";
			$javascript .= 	"script.type = 'text/javascript';";
			$javascript .= 	"script.src = 'https://maps.googleapis.com/maps/api/js?".$parameters."';";
			$javascript .= 	"document.body.appendChild(script);";
			$javascript .= '}';
			$javascript .= 'szgooglemapsload();';
			$javascript .= '</script>'."\n";

			// Running echo on the footer of the javascript code generated
			// This code is added to a single block together with other functions

			echo $javascript;
		}
	}

	/**
	 * Loading function for PHP allows developers to implement modules in this plugin.
	 * The functions have the same parameters of shortcodes, see the documentation.
	 */

	@require_once(dirname(SZ_PLUGIN_GOOGLE_MAIN).'/functions/SZGoogleFunctionsMaps.php');
}