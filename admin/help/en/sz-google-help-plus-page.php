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
$IMAGE1 = plugin_dir_url(SZ_PLUGIN_GOOGLE_MAIN).'admin/files/images/others/sz-google-plus-badge-page.jpg';

/**
 * Definizione variabile HTML per la preparazione della stringa
 * che contiene la documentazione di questa funzionalità
 */
$HTML = <<<EOD

<h2>Documentation</h2>

<p>If you have a Google+ page and your goal is to fully integrate it in your website, this is the rigth tool. Badge page could
be embedded in two different ways. You can use the <b>[sz-gplus-page]</b> shortcode in order to place the badge into your 
articles or pages. Use the specific widget, located into the widgets menu, in order to make it appear into your sidebars. 
For the themes and plugin makers, we developed a specific function to recall the badge directly 
from PHP: <b>szgoogle_gplus_get_badge_page(\$options)</b>.</p>

<h2>Customization</h2>

<p>The component can be customized in many ways, just use the parameters listed in the table provided below. Regarding the widget 
parameters are obtained directly from the GUI, but if you use the shortcode or PHP function you must specify them manually in the 
format option = "value". If you would like additional information you can visit the official page 
<a target="_blank" href="https://developers.google.com/+/web/badge/?hl=it">Google+ Badge</a>.</p>

<h2>Publisher</h2>

<p>This badge can also be used to activate the publisher. Just use the parameter id="page" and publisher="true" in the badge and 
put it in the pages of the site. Remember to certify that this function must be included in its Google+ page the name of the 
website with your own domain. Once all the necessary passages can try the procedure involved going to the page
<a target="_blank" href="http://www.google.com/webmasters/tools/richsnippets">Structured Data Testing Tool</a>.</p>

<h2>Parameters and options</h2>

<table>
	<tr><th>Parameter</th> <th>Description</th>           <th>Allowed values</th>         <th>Default</th></tr>
	<tr><td>id</td>        <td>page</td>                  <td>string</td>                 <td>configuration</td></tr>
	<tr><td>type</td>      <td>mode</td>                  <td>standard,popup</td>         <td>standard</td></tr>
	<tr><td>width</td>     <td>width</td>                 <td>value,auto</td>             <td>configuration</td></tr>
	<tr><td>align</td>     <td>alignment</td>             <td>left,center,right,none</td> <td>none</td></tr>
	<tr><td>layout</td>    <td>layout</td>                <td>portrait,landscape</td>     <td>portrait</td></tr>
	<tr><td>theme</td>     <td>theme</td>                 <td>light,dark</td>             <td>light</td></tr>
	<tr><td>cover</td>     <td>cover</td>                 <td>true,false</td>             <td>true</td></tr>
	<tr><td>tagline</td>   <td>tagline</td>               <td>true,false</td>             <td>true</td></tr>
	<tr><td>publisher</td> <td>rel=publisher in HTML</td> <td>true,false</td>             <td>false</td></tr>
	<tr><td>text</td>      <td>pop-up text</td>           <td>string</td>                 <td>null</td></tr>
	<tr><td>image</td>     <td>pop-up URL image</td>      <td>string</td>                 <td>null</td></tr>
</table>

<h2>Standard or popup</h2>

<p>As you can see from the table of options is called a <b>type</b> parameter with which you can choose to display the badge in a 
standard way and then immediately draw the badge in the HTML page or request a viewing mode only popup by passing the cursor over a 
<b>text</b> or <b>image</b>. In this case you have to specify the parameters that are dedicated to the function pop-up text and image.</p>

<h2>Shortcode example</h2>

<p>The shortcodes are macros that are inserted in to post requires some additional processing that have been made ​​available by plugins,
themes, or directly from the core. The plugin <b>SZ-Google</b> provides several shortcode beings that can be used in the classical 
form and with the customization options allowed. To insert a shortcode in our post we have to use the code in this form:</p>
<pre>[sz-gplus-page id="117259631219963935481" type="standard" width="auto"/]</pre>

<h2>PHP code example</h2>

<p>If you want to use PHP functions of the plugin you need to be sure that the specific module is active, when you have verified this,
include the functions in your theme and specifies the various options through an array. It is advisable to use before the function 
check if this exists, in this way you will not have PHP errors when plugin disabled or uninstalled.</p>

<pre>
\$options = array(
  'id'     => '117259631219963935481',
  'type'   => 'standard',
  'width'  => 'auto',
  'theme'  => 'dark',
  'layout' => 'portrait'
);

if (function_exists('szgoogle_gplus_get_badge_page')) {
  echo szgoogle_gplus_get_badge_page(\$options);
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
$this->moduleCommonFormHelp(__('google+ badge page','szgoogleadmin'),NULL,NULL,false,$HTML,basename(__FILE__));