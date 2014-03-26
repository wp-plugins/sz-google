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
$IMAGE1 = SZ_PLUGIN_GOOGLE_PATH_ADMIN_IMAGES.'others/sz-google-drive-save-button.jpg';

/**
 * Definizione variabile HTML per la preparazione della stringa
 * che contiene la documentazione di questa funzionalità
 */
$HTML = <<<EOD

<p>Using this function in the Google plugin you can insert into a wordpress post or a sidebar button to save a static resource 
in our website on Google Drive. For example, we can publish a link for a PDF manual and ask you if you want to save space on your 
Google Drive or we could see a picture and give you the opportunity to store it in Drive in different high-resolution formats.</p>

<p>To add this module you have to use the shortcode <b>[sz-drive-save]</b>, but if you want to use it in a sidebar then you have to use 
the widget developed for this function in menu appearance -> widgets. For the most demanding there is also another possibility, 
in fact just use a PHP function provided by the plugin <b>szgoogle_get_drive_savebutton(\$options)</b>.</p>

<h2>Customization</h2>

<p>The component can be customized in many ways, just use the parameters listed in the table provided below. Regarding the widget 
parameters are obtained directly from the GUI, but if you use the shortcode or PHP function you must specify them manually in the 
format option = "value". If you would like additional information you can visit the official page 
<a target="_blank" href="https://developers.google.com/drive/web/savetodrive?hl=it">Save to Drive Button</a>.</p>

<h2>Parameters and options</h2>

<table>
	<tr><th>Parameter</th>    <th>Description</th>      <th>Allowed values</th>             <th>Default</th></tr>
	<tr><td>url</td>          <td>file URL address</td> <td>string</td>                     <td>current post</td></tr>
	<tr><td>filename</td>     <td>file name</td>        <td>small,medium,standard,tail</td> <td>standard</td></tr>
	<tr><td>sitename</td>     <td>site name</td>        <td>value</td>                      <td>null</td></tr>
	<tr><td>text</td>         <td>text</td>             <td>string</td>                     <td>null</td></tr>
	<tr><td>img</td>          <td>image</td>            <td>string</td>                     <td>null</td></tr>
	<tr><td>position</td>     <td>position</td>         <td>top,center,bottom,outside</td>  <td>outside</td></tr>
	<tr><td>align</td>        <td>align</td>            <td>left,center,right,none</td>     <td>none</td></tr>
	<tr><td>margintop</td>    <td>margin top</td>       <td>value,none</td>                 <td>none</td></tr>
	<tr><td>marginrigh</td>   <td>margin right</td>     <td>value,none</td>                 <td>none</td></tr>
	<tr><td>marginbottom</td> <td>margin bottom</td>    <td>value,none</td>                 <td>1</td></tr>
	<tr><td>marginleft</td>   <td>margin left</td>      <td>value,none</td>                 <td>none</td></tr>
	<tr><td>marginunit</td>   <td>margin unit</td>      <td>em,pt,px</td>                   <td>em</td></tr>
</table>

<h2>Button wrapper</h2>

<p>The default behavior of the button of google is to draw only the button and connect it to the interactive actions allowed. 
The plugin <b>SZ-Google</b> has tried to improve this behavior, and added parameters to allow the design of a container on which the 
button can be face down. For example, we can specify an image and place it inside the button overlay and in the position we want.</p>

<pre>[sz-drive-save url="URL" img="http://domain.com/image.jpg" position="bottom"/]</pre>

<h2>Shortcode example</h2>

<p>The shortcodes are macros that are inserted in to post requires some additional processing that have been made ​​available by plugins,
themes, or directly from the core. The plugin <b>SZ-Google</b> provides several shortcode beings that can be used in the classical 
form and with the customization options allowed. To insert a shortcode in our post we have to use the code in this form:</p>

<pre>[sz-drive-save filename="aws-web-application.pdf" url="URL_TO_PDF"/]</pre>

<h2>PHP code example</h2>

<p>If you want to use PHP functions provided by the plugin you must make sure that the corresponding module is active, once verified 
inserted in the desired location of your theme code similar to the following example, then prepared an array with the options you want 
and call up the required function. It is advisable to use before the function check if this exists, in this way you will not have 
PHP errors when plugin disabled or uninstalled.</p>

<pre>
\$options = array(
  'url'      => 'http:/domain.com/filetosave.pdf',
  'filename' => 'medium',
  'align'    => 'center',
);

if (function_exists('szgoogle_get_drive_savebutton')) {
  echo szgoogle_get_drive_savebutton(\$options);
}
</pre>

<h2>Screenshot</h2>

<p>In this picture you can see the end result of this feature. You see a photo with a medium resolution are added underneath the 
buttons on the drive to store the high-definition files that take up a lot of space. You can use this technique for any type of 
files such as ZIP, PDF, DOC ect. Remember that the file should still be available on a URL that belongs to the same site.</p>

<img class="screen" src="$IMAGE1" alt=""/>

<h2>Warnings</h2>

<p>The plugin <b>SZ-Google</b> has been developed with a technique of loading individual modules to optimize overall performance, 
so before you use a shortcode, a widget, or a PHP function you should check that the module general and the specific option appears 
enabled via the field dedicated option that you find in the admin panel.</p>

EOD;

/**
 * Definizione array per la creazione del navigatore di fondo
 * con i link seguenti e precedenti della documentazione
 */
$prev = array('title'=>__('widget calendar','szgoogleadmin'),'slug'=>'sz-google-help-calendar.php');
$next = array('title'=>__('widget groups'  ,'szgoogleadmin'),'slug'=>'sz-google-help-groups.php');

$HTML .= $this->moduleAddHelpNavs($prev,$next);

/**
 * Richiamo della funzione per la creazione della pagina di 
 * documentazione standard in base al contenuto della variabile HTML
 */
$this->moduleCommonForm(__('drive save button','szgoogleadmin'),NULL,NULL,false,$HTML);