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
$IMAGE1 = SZ_PLUGIN_GOOGLE_PATH_ADMIN_IMAGES.'others/sz-google-drive-viewer.jpg';

/**
 * Definizione variabile HTML per la preparazione della stringa
 * che contiene la documentazione di questa funzionalità
 */
$HTML = <<<EOD

<p>Google Drive Viewer is a universal document viewer that can be embedded in a web page in wordpress, with this component, 
we can view many file formats without having to install special plugins or flash. The use of the component is very simple,
just use the dedicated shortcode and specify the file URL. The file can be stored locally or remotely.</p>

<p>To add this module you have to use the shortcode <b>[sz-drive-viewer]</b>, but if you want to use it in a sidebar then you have 
to use the widget developed for this function in menu appearance -> widgets. For the most demanding there is also another possibility, 
in fact just use a PHP function provided by the plugin <b>szgoogle_drive_get_viewer(\$options)</b>.</p>

<h2>Customization</h2>

<p>The component can be customized in many ways, just use the parameters listed in the table provided below. Regarding the widget 
parameters are obtained directly from the GUI, but if you use the shortcode or PHP function you must specify them manually in the 
format option = "value". If you would like additional information you can visit the official page 
<a target="_blank" href="https://docs.google.com/viewer">Drive Viewer</a>.</p>

<h2>Parameters and options</h2>

<table>
	<tr><th>Parameter</th>     <th>Description</th>      <th>Allowed values</th>    <th>Default</th></tr>
	<tr><td>url</td>           <td>file URL address</td> <td>string</td>            <td>null</td></tr>
	<tr><td>title</td>         <td>title</td>            <td>string</td>            <td>null</td></tr>
	<tr><td>titleposition</td> <td>title position</td>   <td>top,bottom</td>        <td>configuration</td></tr>
	<tr><td>titlealign</td>    <td>title alignment</td>  <td>left,right,center</td> <td>configuration</td></tr>
	<tr><td>margintop</td>     <td>margin top</td>       <td>value,none</td>        <td>none</td></tr>
	<tr><td>marginrigh</td>    <td>margin right</td>     <td>value,none</td>        <td>none</td></tr>
	<tr><td>marginbottom</td>  <td>margin bottom</td>    <td>value,none</td>        <td>1</td></tr>
	<tr><td>marginleft</td>    <td>margin left</td>      <td>value,none</td>        <td>none</td></tr>
	<tr><td>marginunit</td>    <td>margin unit</td>      <td>em,pt,px</td>          <td>em</td></tr>
</table>

<h2>Supported formats</h2>

<p>File types supported by google are many and are always added new, at this time those that are displayed are as follows. For more 
information on the formats supported by google go to the page
<a target="_blank" href="https://support.google.com/drive/answer/2423485?p=docs_viewer&rd=1">official support</a>.</p>

<ul>
	<li>Adobe Acrobat (PDF)</li>
	<li>Adobe Illustrator (AI)</li>
	<li>Adobe Photoshop (PSD)</li>
	<li>Apple Pages (PAGES)</li>
	<li>Archive Files (ZIP/RAR)</li>
	<li>Autodesk AutoCad (DXF)</li>
	<li>Microsoft Word (DOC/DOCX*)</li>
	<li>Microsoft PowerPoint (PPT/PPTX*)</li>
	<li>Microsoft Excel (XLS/XLSX*)</li>
	<li>OpenType/TrueType Fonts (OTF, TTF)</li>
	<li>PostScript (EPS/PS)</li>
	<li>Scalable Vector Graphics (SVG)</li>
	<li>TIFF Images (TIF, TIFF)</li>
	<li>XML Paper Specification (XPS)</li>
</ul>

<h2>Shortcode example</h2>

<p>The shortcodes are macros that are inserted in to post requires some additional processing that have been made ​​available by plugins,
themes, or directly from the core. The plugin <b>SZ-Google</b> provides several shortcode beings that can be used in the classical 
form and with the customization options allowed. To insert a shortcode in our post we have to use the code in this form:</p>

<pre>[sz-drive-viewer url="http://domain.com/filename.pdf" title="titolo"/]</pre>

<h2>PHP code example</h2>

<p>If you want to use PHP functions of the plugin you need to be sure that the specific module is active, when you have verified this,
include the functions in your theme and specifies the various options through an array. It is advisable to use before the function 
check if this exists, in this way you will not have PHP errors when plugin disabled or uninstalled.</p>

<pre>
\$options = array(
  'url'        => 'http://domain.com/filename.pdf',
  'title'      => 'titolo di prova',
  'titlealign' => 'center',
);

if (function_exists('szgoogle_drive_get_viewer')) {
  echo szgoogle_drive_get_viewer(\$options);
}
</pre>

<h2>Screenshot</h2>

<p>In this picture you can see the result of this feature. Is presented with a PDF document containing an example of financial data 
on Euribor 2013. As you can see there are also some navigation functions.</p>

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
$this->moduleCommonFormHelp(__('drive viewer','szgoogleadmin'),NULL,NULL,false,$HTML,basename(__FILE__));