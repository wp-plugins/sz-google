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
$IMAGE1 = SZ_PLUGIN_GOOGLE_PATH_ADMIN_IMAGES.'others/sz-google-groups-embed.png';

/**
 * Definizione variabile HTML per la preparazione della stringa
 * che contiene la documentazione di questa funzionalità
 */
$HTML = <<<EOD

<p>Tramite questa funzione presente nel plugin <b>SZ-Google</b> è possibile inserire in un post di wordpress o su una sidebar il 
widget dei gruppi presenti su google. Per ottenere ulteriori informazioni sui gruppi leggi la pagina ufficiale su <a target="_blank" href="https://groups.google.com">https://groups.google.com</a>.</p>

<p>To add this module you have to use the shortcode <b>[sz-ggroups]</b>, but if you want to use it in a sidebar then you have to use 
the widget developed for this function in menu appearance -> widgets. For the most demanding there is also another possibility, 
in fact just use a PHP function provided by the plugin <b>szgoogle_get_groups_code(\$options)</b>.</p>

<h2>Customization</h2>

<p>The component can be customized in many ways, just use the parameters listed in the table provided below. Regarding the widget 
parameters are obtained directly from the GUI, but if you use the shortcode or PHP function you must specify them manually in the 
format option = "value". If you would like additional information you can visit the official page 
<a target="_blank" href="https://support.google.com/groups/answer/1191206?hl=it">Insert a forum into a webpage</a>.</p>

<h2>Parameters and options</h2>

<table>
	<tr><th>Parameter</th>      <th>Description</th>          <th>Allowed values</th> <th>Default</th></tr>
	<tr><td>name</td>           <td>nome del gruppo</td>      <td>stringa</td>        <td>configurazione</td></tr>
	<tr><td>width</td>          <td>larghezza</td>            <td>valore</td>         <td>configurazione</td></tr>
	<tr><td>height</td>         <td>altezza</td>              <td>valore</td>         <td>configurazione</td></tr>
	<tr><td>showsearch</td>     <td>visualizzare ricerca</td> <td>true,false</td>     <td>configurazione</td></tr>
	<tr><td>showtabs</td>       <td>visualizzare tabs</td>    <td>true,false</td>     <td>configurazione</td></tr>
	<tr><td>hideforumtitle</td> <td>nascondi titolo</td>      <td>true,false</td>     <td>configurazione</td></tr>
	<tr><td>hidesubject</td>    <td>nascondi soggetto</td>    <td>true,false</td>     <td>configurazione</td></tr>
	<tr><td>hl</td>             <td>linguaggio</td>           <td>codice lingua</td>  <td>configurazione</td></tr>
</table>

<h2>Shortcode example</h2>

<p>The shortcodes are macros that are inserted in to post requires some additional processing that have been made ​​available by plugins,
themes, or directly from the core. The plugin <b>SZ-Google</b> provides several shortcode beings that can be used in the classical 
form and with the customization options allowed. To insert a shortcode in our post we have to use the code in this form:</p>

<pre>[sz-ggroups height="1200"/]</pre>

<h2>PHP code example</h2>

<p>If you want to use PHP functions provided by the plugin you must make sure that the corresponding module is active, once verified 
inserted in the desired location of your theme code similar to the following example, then prepared an array with the options you want 
and call up the required function. It is advisable to use before the function check if this exists, in this way you will not have 
PHP errors when plugin disabled or uninstalled.</p>

<pre>
\$options = array(
  'name'    => 'comp.sys.ibm.as400.misc',
  'height'  => '1200',
  'showtabs'=> 'true',
);

if (function_exists('szgoogle_get_groups_code')) {
  echo szgoogle_get_groups_code(\$options);
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
 * Definizione array per la creazione del navigatore di fondo
 * con i link seguenti e precedenti della documentazione
 */
$prev = array('title'=>__('drive save button'   ,'szgoogleadmin'),'slug'=>'sz-google-help-drive-save.php');
$next = array('title'=>__('hangout start button','szgoogleadmin'),'slug'=>'sz-google-help-hangout-start.php');

$HTML .= $this->moduleAddHelpNavs($prev,$next);

/**
 * Richiamo della funzione per la creazione della pagina di 
 * documentazione standard in base al contenuto della variabile HTML
 */
$this->moduleCommonForm(__('google groups','szgoogleadmin'),NULL,NULL,false,$HTML);