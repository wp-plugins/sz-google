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
$IMAGE1 = SZ_PLUGIN_GOOGLE_PATH_ADMIN_IMAGES.'others/sz-google-youtube-link.jpg';

/**
 * Definizione variabile HTML per la preparazione della stringa
 * che contiene la documentazione di questa funzionalità
 */
$HTML = <<<EOD

<p>With this option, you can insert in a web page link to a youtube channel in different ways. For example, you can insert a 
simple text link or an image, a more elaborate button or an entire badge. All components provide a parameter or an action to 
subscribe to the channel automatically and the presentation of a pop-up window.</p>

<p>To add this module you have to use the available <b>shortcodes</b>, but if you want to use it in a sidebar then you have to use 
the widget developed for this function in menu appearance -> widgets. For the most demanding there is also another possibility, 
in fact just use some PHP function provided by the plugin <b>sz-google</b>. Look at the example at the bottom.</p>

<h2>Shortcode</h2>

<ul>
<li>[sz-ytlink] - Simple text link.</li>
<li>[sz-ytbutton] - Subscribe button.</li>
<li>[sz-ytbadge] - Channel badge.</li>
</ul>

<h2>PHP functions</h2>

<ul>
<li>szgoogle_youtube_get_code_link()</li>
<li>szgoogle_youtube_get_code_button()</li>
<li>szgoogle_youtube_get_code_badge()</li>
</ul>

<h2>Customization</h2>

<p>The component can be customized in many ways, just use the parameters listed in the table provided below. Regarding the widget 
parameters are obtained directly from the GUI, but if you use the shortcode or PHP function you must specify them manually in the 
format option = "value". If you would like additional information you can visit the official page 
<a target="_blank" href="https://developers.google.com/youtube/youtube_subscribe_button">YouTube Subscribe Button</a>.</p>

<h2>Parameters and options</h2>

<table>

	<tr><th>LINK</th>         <th>Description</th>        <th>Allowed values</th> <th>Default</th></tr>
	<tr><td>channel</td>      <td>channel name or ID</td> <td>string</td>         <td>configuration</td></tr>
	<tr><td>subscription</td> <td>subscription</td>       <td>y=yes,n=no</td>     <td>y=yes</td></tr>
	<tr><td>text</td>         <td>text</td>               <td>string</td>         <td>configuration</td></tr>

	<tr class="space"><td colspan="4">&nbsp;</td></tr>

	<tr><th>BUTTON</th>       <th>Description</th>        <th>Allowed values</th> <th>Default</th></tr>
	<tr><td>channel</td>      <td>channel name or ID</td> <td>string</td>         <td>configuration</td></tr>
	<tr><td>layout</td>       <td>layout</td>             <td>default,full</td>   <td>default</td></tr>
	<tr><td>theme</td>        <td>theme</td>              <td>default,full</td>   <td>default</td></tr>

	<tr class="space"><td colspan="4">&nbsp;</td></tr>

	<tr><th>BADGE</th>        <th>Description</th>        <th>Allowed values</th> <th>Default</th></tr>
	<tr><td>channel</td>      <td>channel name or ID</td> <td>string</td>         <td>configuration</td></tr>
	<tr><td>width</td>        <td>width</td>              <td>value</td>          <td>300</td></tr>
	<tr><td>height</td>       <td>height</td>             <td>value</td>          <td>150</td></tr>
	<tr><td>widthunit</td>    <td>width unit</td>         <td>px,em,%</td>        <td>px</td></tr>
	<tr><td>heightunit</td>   <td>height unit</td>        <td>px,em,%</td>        <td>px</td></tr>

</table>

<h2>Shortcode example</h2>

<p>The shortcodes are macros that are inserted in to post requires some additional processing that have been made ​​available by plugins,
themes, or directly from the core. The plugin <b>SZ-Google</b> provides several shortcode beings that can be used in the classical 
form and with the customization options allowed. To insert a shortcode in our post we have to use the code in this form:</p>

<pre>
[sz-ytlink   text="iscriviti al mio canale youtube"/]
[sz-ytbutton layout="full" theme="default"/]
[sz-ytbadge  channel="TuttosuYTChannel" width="100" widthunit="%"/]
</pre>

<h2>PHP code example</h2>

<p>If you want to use PHP functions of the plugin you need to be sure that the specific module is active, when you have verified this,
include the functions in your theme and specifies the various options through an array. It is advisable to use before the function 
check if this exists, in this way you will not have PHP errors when plugin disabled or uninstalled.</p>

<pre>
\$options = array(
  'channel'   => 'TuttosuYTChannel',
  'width'     => 'yes',
  'widthunit' => '%',
);

if (function_exists('szgoogle_youtube_get_code_badge')) {
  echo szgoogle_youtube_get_code_badge(\$options);
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
$this->moduleCommonFormHelp(__('youtube link','szgoogleadmin'),NULL,NULL,false,$HTML,basename(__FILE__));