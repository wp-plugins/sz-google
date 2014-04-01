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
$IMAGE1 = SZ_PLUGIN_GOOGLE_PATH_ADMIN_IMAGES.'others/sz-google-youtube-video.jpg';

/**
 * Definizione variabile HTML per la preparazione della stringa
 * che contiene la documentazione di questa funzionalità
 */
$HTML = <<<EOD

<p>This function allows you to insert a <b>youtube video</b> on a web page. The module youtube has many parameters that are used to add 
functionality or customize some aspects concerning the insertion mode, for example, we can choose between a fixed size of the player 
or a type of responsive design, you can choose between a "dark" theme and a "light", generate code for google analytics 
to track the operations on the video, set some parameters such as fullscreen, disablekeyboard, autoplay and loop.</p>

<p>To add this module you have to use the shortcode <b>[sz-ytvideo]</b>, but if you want to use it in a sidebar then you have to use 
the widget developed for this function in menu appearance -> widgets. For the most demanding there is also another possibility, 
in fact just use a PHP function provided by the plugin <b>szgoogle_youtube_get_code_video(\$options)</b>.</p>

<h2>Customization</h2>

<p>The component can be customized in many ways, just use the parameters listed in the table provided below. Regarding the widget 
parameters are obtained directly from the GUI, but if you use the shortcode or PHP function you must specify them manually in the 
format option = "value". If you would like additional information you can visit the official page 
<a target="_blank" href="https://developers.google.com/youtube/player_parameters">YouTube Embedded Players</a>.</p>

<h2>Parameters and options</h2>

<table>
	<tr><th>Parameter</th>       <th>Description</th>            <th>Allowed values</th>       <th>Default</th></tr>
	<tr><td>url</td>             <td>address URL youtube</td>    <td>string</td>               <td>null</td></tr>
	<tr><td>responsive</td>      <td>responsive mode</td>        <td>y=yes,n=no</td>           <td>configuration</td></tr>
	<tr><td>width</td>           <td>width</td>                  <td>value</td>                <td>configuration</td></tr>
	<tr><td>height</td>          <td>height</td>                 <td>value</td>                <td>configuration</td></tr>
	<tr><td>margintop</td>       <td>margin top</td>             <td>value</td>                <td>configuration</td></tr>
	<tr><td>marginright</td>     <td>margin right</td>           <td>value</td>                <td>configuration</td></tr>
	<tr><td>marginbottom</td>    <td>margin bottom</td>          <td>value</td>                <td>configuration</td></tr>
	<tr><td>marginleft</td>      <td>margin left</td>            <td>value</td>                <td>configuration</td></tr>
	<tr><td>marginunit</td>      <td>margin unit</td>            <td>px,em</td>                <td>configuration</td></tr>
	<tr><td>autoplay</td>        <td>enable autoplay</td>        <td>y=yes,n=no</td>           <td>configuration</td></tr>
	<tr><td>loop</td>            <td>enable loop</td>            <td>y=yes,n=no</td>           <td>configuration</td></tr>
	<tr><td>fullscreen</td>      <td>full screen</td>            <td>y=yes,n=no</td>           <td>configuration</td></tr>
	<tr><td>disablekeyboard</td> <td>disablekeyboard</td>        <td>y=yes,n=no</td>           <td>configuration</td></tr>
	<tr><td>theme</td>           <td>theme</td>                  <td>dark,light</td>           <td>configuration</td></tr>
	<tr><td>cover</td>           <td>cover image</td>            <td>local,youtube,URL,ID</td> <td>configuration</td></tr>
	<tr><td>title</td>           <td>video title</td>            <td>string</td>               <td>configuration</td></tr>
	<tr><td>disableiframe</td>   <td>disable iframe</td>         <td>y=yes,n=no</td>           <td>configuration</td></tr>
	<tr><td>analytics</td>       <td>google analytics</td>       <td>y=yes,n=no</td>           <td>configuration</td></tr>
	<tr><td>delayed</td>         <td>delayed</td>                <td>y=yes,n=no</td>           <td>configuration</td></tr>
	<tr><td>start</td>           <td>time start</td>             <td>seconds</td>              <td>null</td></tr>
	<tr><td>end</td>             <td>time end</td>               <td>seconds</td>              <td>null</td></tr>
	<tr><td>disablerelated</td>  <td>disable related video</td>  <td>y=yes,n=no</td>           <td>configuration</td></tr>
	<tr><td>schemaorg</td>       <td>schema.org enable</td>      <td>y=yes,n=no</td>           <td>configuration</td></tr>
	<tr><td>name</td>            <td>schema.org name</td>        <td>string</td>               <td>youtube video</td></tr>
	<tr><td>description</td>     <td>schema.org description</td> <td>string</td>               <td>title</td></tr>
	<tr><td>duration</td>        <td>schema.org duration</td>    <td><a target="_blank" href="http://it.wikipedia.org/wiki/ISO_8601">format ISO 8601</a></td><td>null</td></tr>
</table>

<h2>Shortcode example</h2>

<p>The shortcodes are macros that are inserted in to post requires some additional processing that have been made ​​available by plugins,
themes, or directly from the core. The plugin <b>SZ-Google</b> provides several shortcode beings that can be used in the classical 
form and with the customization options allowed. To insert a shortcode in our post we have to use the code in this form:</p>

<pre>[sz-ytvideo url="http://www.youtube.com/watch?v=gUdKmGASz3g"/]</pre>

<h2>PHP code example</h2>

<p>If you want to use PHP functions of the plugin you need to be sure that the specific module is active, when you have verified this,
include the functions in your theme and specifies the various options through an array. It is advisable to use before the function 
check if this exists, in this way you will not have PHP errors when plugin disabled or uninstalled.</p>

<pre>
\$options = array(
  'url'        => 'http://www.youtube.com/watch?v=gUdKmGASz3g',
  'responsive' => 'yes',
  'delayed'    => 'yes',
  'schemaorg'  => 'yes',
);

if (function_exists('szgoogle_youtube_get_code_video')) {
  echo szgoogle_youtube_get_code_video(\$options);
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
$this->moduleCommonFormHelp(__('youtube video','szgoogleadmin'),NULL,NULL,false,$HTML,basename(__FILE__));