<?php

/**
 * This file contains information related to a help section 
 * of the plugin. Each directory is a specific language
 *
 * @package SZGoogle
 * @subpackage Admin
 * @author Massimo Della Rovere
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die(); 

// Variable definition HTML for the preparation of the
// string which contains the documentation of this feature

$HTML = <<<EOD

<h2>Description</h2>

<p>The plugin provides functions to automatically insert the tracking code into your theme, but if you want to use for a particular 
need to manually insert the code on your website but continuing to use the admin panel for the parameters related to a account, you 
can use PHP functions available to the plugin and implement them with your code. The available functions are:</p>

<ul>
<li><b>szgoogle_analytics_get_ID()</b></li>
<li><b>szgoogle_analytics_get_code()</b></li>
</ul>

<p>For example if we wanted to enter the code into our theme and take only the options that relate to the account we could use a PHP 
code similar to the following, where the function is used <b>szgoogle_analytics_get_ID()</b>.</p>

<pre>
&lt;script&gt;

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create',&lt;?php echo szgoogle_analytics_get_ID() ?&gt;,'dominio.com');
  ga('send','pageview');

&lt;/script&gt;
</pre>

<p>If you want to insert the code automatically generated by the plugin but in a well-defined position of our theme we can use the 
PHP function PHP <b>szgoogle_analytics_get_code</b> and insert it into the precise point that we wish to.</p>

<pre>
&lt;head&gt;
  if (function_exists('szgoogle_analytics_get_code')) {
    echo szgoogle_analytics_get_code;
  }
&lt;/head&gt;
</pre>

<h2>Warnings</h2>

<p>The plugin <b>SZ-Google</b> has been developed with a technique of loading individual modules to optimize overall performance, 
so before you use a shortcode, a widget, or a PHP function you should check that the module general and the specific option appears 
enabled via the field dedicated option that you find in the admin panel.</p>

EOD;

// Call function for creating the page of standard
// documentation based on the contents of the HTML variable

$this->moduleCommonFormHelp(__('analytics PHP functions','szgoogleadmin'),NULL,NULL,false,$HTML,basename(__FILE__));