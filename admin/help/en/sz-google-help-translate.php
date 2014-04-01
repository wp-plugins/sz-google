<?php
/**
 * Controllo se il file viene richiamato direttamente senza
 * essere incluso dalla procedura standard del plugin.
 *
 * @package SZGoogle
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die(); 

/**
 * Definizione variabili per calcolare percorsi, immagini
 * e qualsiasi risorsa che debba essere specificata in EOD
 */
$IMAGE1 = SZ_PLUGIN_GOOGLE_PATH_ADMIN_IMAGES.'others/sz-google-translate.jpg';

/**
 * Definizione variabile HTML per la preparazione della stringa
 * che contiene la documentazione di questa funzionalità
 */
$HTML = <<<EOD

<p>With this option we can put on our website a language selector that performs the automatic translation of the page without 
leaving the site. Obviously, we can not expect a quality translation such as those performed manually. It is still a useful 
tool for those who publish articles and do not have the time to translate them. Surely it is better than nothing ...</p>

<p>To add this module you have to use the shortcode <b>[sz-gtranslate]</b>, but if you want to use it in a sidebar then you have to use 
the widget developed for this function in menu appearance -> widgets. For the most demanding there is also another possibility, 
in fact just use a PHP function provided by the plugin <b>szgoogle_translate_get_code(\$options)</b>.</p>

<h2>Configuration</h2>

<p>Before using the module google translate you need to register the site on your google account using the steps that are on
official page <a target="_blank" href="https://translate.google.com/manager‎">Google Translate Tool</a>. 
Once you have configured your site perform the action "get code" and copy the specified "meta".
Take care to only enter the numeric code and not all of the HTML code.</p>

<h2>Customization</h2>

<p>The component can be customized in many ways, just use the parameters listed in the table provided below. Regarding the widget 
parameters are obtained directly from the GUI, but if you use the shortcode or PHP function you must specify them manually in the 
format option = "value". If you would like additional information you can visit the official page 
<a target="_blank" href="https://translate.google.com/manager‎">Google Translate Manager</a>.</p>

<h2>Parameters and options</h2>

<table>
	<tr><th>Parameter</th>  <th>Description</th>             <th>Allowed values</th> <th>Default</th></tr>
	<tr><td>language</td>   <td>language of the widget</td>  <td>string</td>         <td>configuration</td></tr>
	<tr><td>mode</td>       <td>display mode</td>            <td>V,H,D</td>          <td>configuration</td></tr>
	<tr><td>automatic</td>  <td>automatic banner</td>        <td>y=yes,n=no</td>     <td>configuration</td></tr>
	<tr><td>analytics</td>  <td>google analytics</td>        <td>y=yes,n=no</td>     <td>configuration</td></tr>
	<tr><td>uacode</td>     <td>google analytics UA</td>     <td>string</td>         <td>configuration</td></tr>
</table>

<h2>Shortcode example</h2>

<p>The shortcodes are macros that are inserted in to post requires some additional processing that have been made ​​available by plugins,
themes, or directly from the core. The plugin <b>SZ-Google</b> provides several shortcode beings that can be used in the classical 
form and with the customization options allowed. To insert a shortcode in our post we have to use the code in this form:</p>

<pre>[sz-gtranslate mode="V" language="it_IT" automatic="yes"/]</pre>

<h2>PHP code example</h2>

<p>If you want to use PHP functions of the plugin you need to be sure that the specific module is active, when you have verified this,
include the functions in your theme and specifies the various options through an array. It is advisable to use before the function 
check if this exists, in this way you will not have PHP errors when plugin disabled or uninstalled.</p>

<pre>
\$options = array(
  'language'  => 'it_IT',
  'mode'      => 'V',
  'automatic' => 'yes',
);

if (function_exists('szgoogle_translate_get_code')) {
  echo szgoogle_translate_get_code(\$options);
}
</pre>

<h2>Screenshot</h2>

<p>In this picture you can see the component was added to a post wordpress, size, and some options related to the appearance can be 
changed with the configuration parameters. The most suitable area to the publication of this information is the sidebar, but it can 
sometimes be useful to include them in an article to sponsor a particular resource.</p>

<img class="screen" src="$IMAGE1" alt=""/>

<h2>Warnings</h2>

<p>The plugin <b>SZ-Google</b> has been developed with a technique of loading individual modules to optimize overall performance, 
so before you use a shortcode, a widget, or a PHP function you should check that the module general and the specific option appears 
enabled via the field dedicated option that you find in the admin panel.</p>

EOD;

/**
 * Richiamo della funzione per la creazione della pagina di 
 * documentazione standard in base al contenuto della variabile HTML
 */
$this->moduleCommonFormHelp(__('translate setup','szgoogleadmin'),NULL,NULL,false,$HTML,basename(__FILE__));