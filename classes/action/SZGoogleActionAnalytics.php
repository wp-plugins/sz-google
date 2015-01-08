<?php

/**
 * Define a class that identifies an action called by the
 * main module based on the options that have been activated
 *
 * @package SZGoogle
 * @subpackage Actions
 * @author Massimo Della Rovere
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Before the definition of the class, check if there is a definition 
// with the same name or the same as previously defined in other script.

if (!class_exists('SZGoogleActionAnalytics'))
{
	class SZGoogleActionAnalytics extends SZGoogleAction
	{
		/**
		 * The function that is normally invoked by hook
		 * presents in add_action e add_filter in wordpress
		 */

		function action() {
			echo $this->getMonitorCode(array());
		}

		/**
		 * The function that is normally invoked by hook
		 * presents in add_action e add_filter in wordpress
		 */

		function getMonitorCode($atts=array())
		{
			if (!is_array($atts)) $atts = array();

			// Loading options for the configuration variables 
			// containing the default values ​​for shortcodes and widgets
			
			$options = (object) $this->getModuleOptions('SZGoogleModuleAnalytics');

			// Extraction of the values ​​specified in shortcode, returned values
			// ​​are contained in the variable names corresponding to the key

			extract(shortcode_atts(array(
				'ga_type'                 => $options->ga_type,
				'ga_uacode'               => $options->ga_uacode,
				'ga_position'             => $options->ga_position,
				'ga_enable_front'         => $options->ga_enable_front,
				'ga_enable_admin'         => $options->ga_enable_admin,
				'ga_enable_administrator' => $options->ga_enable_administrator,
				'ga_enable_logged'        => $options->ga_enable_logged,
				'ga_enable_subdomain'     => $options->ga_enable_subdomain,
				'ga_enable_multiple'      => $options->ga_enable_multiple,
				'ga_enable_advertiser'    => $options->ga_enable_advertiser,
				'ga_enable_features'      => $options->ga_enable_features,
			),$atts));

			// I delete spaces added and execute the transformation in string
			// lowercase for the control of special values ​​such as "auto"

			$ga_uacode               = trim($ga_uacode);
			$ga_type                 = strtolower(trim($ga_type));
			$ga_position             = strtoupper(trim($ga_position));
			$ga_enable_front         = strtolower(trim($ga_enable_front));
			$ga_enable_admin         = strtolower(trim($ga_enable_admin));
			$ga_enable_administrator = strtolower(trim($ga_enable_administrator));
			$ga_enable_logged        = strtolower(trim($ga_enable_logged));
			$ga_enable_subdomain     = strtolower(trim($ga_enable_subdomain));
			$ga_enable_multiple      = strtolower(trim($ga_enable_multiple));
			$ga_enable_advertiser    = strtolower(trim($ga_enable_advertiser));
			$ga_enable_features      = strtolower(trim($ga_enable_features));

			// Conversion of the values ​​specified directly covered in the
			// parameters with the values ​​used for storing the default values

			if ($ga_enable_front         == 'yes' or $ga_enable_front         == 'y') $ga_enable_front         = '1';
			if ($ga_enable_admin         == 'yes' or $ga_enable_admin         == 'y') $ga_enable_admin         = '1';
			if ($ga_enable_administrator == 'yes' or $ga_enable_administrator == 'y') $ga_enable_administrator = '1';
			if ($ga_enable_logged        == 'yes' or $ga_enable_logged        == 'y') $ga_enable_logged        = '1';
			if ($ga_enable_subdomain     == 'yes' or $ga_enable_subdomain     == 'y') $ga_enable_subdomain     = '1';
			if ($ga_enable_multiple      == 'yes' or $ga_enable_multiple      == 'y') $ga_enable_multiple      = '1';
			if ($ga_enable_advertiser    == 'yes' or $ga_enable_advertiser    == 'y') $ga_enable_advertiser    = '1';
			if ($ga_enable_features      == 'yes' or $ga_enable_features      == 'y') $ga_enable_features      = '1';

			if ($ga_enable_front         == 'no'  or $ga_enable_front         == 'n') $ga_enable_front         = '1';
			if ($ga_enable_admin         == 'no'  or $ga_enable_admin         == 'n') $ga_enable_admin         = '1';
			if ($ga_enable_administrator == 'no'  or $ga_enable_administrator == 'n') $ga_enable_administrator = '1';
			if ($ga_enable_logged        == 'no'  or $ga_enable_logged        == 'n') $ga_enable_logged        = '1';
			if ($ga_enable_subdomain     == 'no'  or $ga_enable_subdomain     == 'n') $ga_enable_subdomain     = '1';
			if ($ga_enable_multiple      == 'no'  or $ga_enable_multiple      == 'n') $ga_enable_multiple      = '1';
			if ($ga_enable_advertiser    == 'no'  or $ga_enable_advertiser    == 'n') $ga_enable_advertiser    = '1';
			if ($ga_enable_features      == 'no'  or $ga_enable_features      == 'n') $ga_enable_features      = '1';

			// Check if they are logged in as an administrator or registered
			// user and off loading the code if the options are disabled

			$useract = true;

			if (current_user_can('manage_options')) {
				if ($ga_enable_administrator == '0') $useract = false;
			} else {
				if (is_user_logged_in() and $ga_enable_logged == '0') $useract = false;   
			}

			// Check if they are in the backend or frontend and I enable code execution
			// only if the corresponding options have been activated in the configuration

			if ( is_admin() and $ga_enable_admin == '0') $useract = false;
			if (!is_admin() and $ga_enable_front == '0') $useract = false;

			// If the code does not have to be activated based on the options passed
			// return a value of false and not elaborate the creation of monitoring

			if (!$useract or strlen($ga_uacode) <= 0) {
				return false;
			}

			// Conversion of the values ​​specified directly covered in the
			// parameters with the values ​​used for storing the default values

			if ($ga_position == '') $ga_position = 'H';
			if ($ga_uacode   == '') $ga_uacode   = $this->getGAId();   

			if (!in_array($ga_type,array('classic','universal'))) $ga_type = 'classic';

			// Creating code for comments to be blocked 
			// if proves active code generation GA

			$HTML = '';

			if ($ga_position != 'F' and ($ga_type == 'universal' or $ga_type == 'classic')) {
				$HTML .= "\n";
				$HTML .= "<!-- GA tracking code with SZ-Google ".SZ_PLUGIN_GOOGLE_VERSION." : activated mode ".strtoupper($ga_type)."      -->\n";
				$HTML .= "<!-- ===================================================================== -->\n";
			}

			// Creating code google analytics UNIVERSAL be inserted on HTML page
			// which can be different according to google analytics classic or universal

			if ($ga_type == 'universal') 
			{
				$HTML .= '<script>'."\n";
				$HTML .= "  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){"."\n";
				$HTML .= "  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),"."\n";
				$HTML .= "  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)"."\n";
				$HTML .= "  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');"."\n";
				$HTML .= "  ga('create','".trim($ga_uacode)."','".trim(SZGoogleCommon::getCurrentDomain())."');"."\n";

				// Displayfeature control option to add to the 
				// code of google analytics universal standard

				if ($ga_enable_features == '1') {
					$HTML .= "  ga('require','displayfeatures');"."\n";
				}

				$HTML .= "  ga('send','pageview');"."\n";
				$HTML .= "</script>"."\n";
			}

			// Creating code google analytics CLASSIC be inserted on HTML page which
			// can be different according to google analytics classic or universal

			if ($ga_type == 'classic') 
			{
				$HTML .= '<script type="text/javascript">//<![CDATA['."\n";
				$HTML .= "var _gaq = _gaq || [];"."\n";
				$HTML .= "_gaq.push(['_setAccount','".$ga_uacode."']);"."\n";

				// If option is activated multiple subdomains or add a new row
				// code containing the current displayed _setDomainName domino

				if ($ga_enable_subdomain == '1' or $ga_enable_multiple  == '1') {
					$HTML .= "_gaq.push(['_setDomainName','".trim(SZGoogleCommon::getCurrentDomain())."']);"."\n";
				}

				// If multiple option is enabled add a new row with the code
				// javascript for google analytics with setup for _setAllowLinker

				if ($ga_enable_multiple == '1') {
					$HTML .= "_gaq.push(['_setAllowLinker',true]);"."\n";
				}

				$HTML .= "_gaq.push(['_trackPageview']);"."\n";

				$HTML .= "(function () {"."\n";
				$HTML .= "var ga = document.createElement('script');"."\n";
				$HTML .= "ga.type = 'text/javascript';"."\n";
				$HTML .= "ga.async = true;"."\n";

				if ($ga_enable_advertiser == '1') $HTML .= "ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';"."\n";
					else $HTML .= "ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';"."\n";

				$HTML .= "var s = document.getElementsByTagName('script')[0];"."\n";
				$HTML .= "s.parentNode.insertBefore(ga, s);"."\n";
				$HTML .= "})();"."\n";
				$HTML .= "//]]></script>"."\n";
			}

			// Creating code for comments to be blocked 
			// if proves active code generation GA

			if ($ga_position != 'F' and ($ga_type == 'universal' or $ga_type == 'classic')) {
				$HTML .= "<!-- ===================================================================== -->\n\n";
			}

			return $HTML;
		}
	}
}
