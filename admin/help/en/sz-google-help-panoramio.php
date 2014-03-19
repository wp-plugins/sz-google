<?php
/**
 * Controllo se il file viene richiamato direttamente senza
 * essere incluso dalla procedura standard del plugin.
 *
 * @package SZGoogle
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die(); 

$IMAGE1 = SZ_PLUGIN_GOOGLE_PATH_ADMIN_IMAGES.'others/sz-google-panoramio.png';

/**
 * Definizione variabile HTML per la preparazione della stringa
 * che contiene la documentazione di questa funzionalità
 */
$HTML = <<<EOD

<p>Questo modulo del plugin <b>SZ-Google</b> permette di inserire nei propri articoli delle gallerie fotografiche presenti in panoramio, 
basta specificare il template desiderato e le opzioni richieste. Potete usare quattro template diversi, photo, list, slideshow e 
photo_list. Per ulteriori informazioni sui parametri richiesti leggete la pagina ufficiale <a href="http://www.panoramio.com/api/widget/api.html">Panoramio Widget API </a>.</p>

<p>To add this module you have to use the shortcode <b>[sz-panoramio]</b>, but if you want to use it in a sidebar then you have to use 
the widget developed for this function in menu appearance -> widgets. For the most demanding there is also another possibility, 
in fact just use a PHP function provided by the plugin <b>szgoogle_get_panoramio_code(\$options)</b>.</p>

<h2>Customization</h2>

<p>The component can be customized in many ways, just use the parameters listed in the table provided below. Regarding the widget 
parameters are obtained directly from the GUI, but if you use the shortcode or PHP function you must specify them manually in the 
format option = "value". If you would like additional information you can visit the official page 
<a target="_blank" href="http://www.panoramio.com/api/widget/api.html">Panoramio Widget API </a>.</p>

<h2>Parameters and options</h2>

<table>
	<tr><th>Parameter</th>   <th>Description</th>                   <th>Allowed values</th>                  <th>Default</th></tr>
	<tr><td>template</td>    <td>tipo di widget</td>                <td>photo,slideshow,list,photo_list</td> <td>photo</td></tr>
	<tr><td>user</td>        <td>ricerca per utente</td>            <td>stringa</td>                         <td>null</td></tr>
	<tr><td>group</td>       <td>ricerca per gruppo</td>            <td>stringa</td>                         <td>null</td></tr>
	<tr><td>tag</td>         <td>ricerca per tag</td>               <td>stringa</td>                         <td>null</td></tr>
	<tr><td>set</td>         <td>selezionare tipo</td>              <td>all,public,recent</td>               <td>all</td></tr>
	<tr><td>widht</td>       <td>larghezza per widget in pixel</td> <td>valore</td>                          <td>auto</td></tr>
	<tr><td>height</td>      <td>altezza per widget in pixel</td>   <td>valore</td>                          <td>300</td></tr>
	<tr><td>bgcolor</td>     <td>colore di sfondo</td>              <td>hexadecimal</td>                     <td>null</td></tr>
	<tr><td>columns</td>     <td>colonne per foto</td>              <td>valore</td>                          <td>4</td></tr>
	<tr><td>rows</td>        <td>righe per foto</td>                <td>valore</td>                          <td>1</td></tr>
	<tr><td>orientation</td> <td>orientamento della lista</td>      <td>horizontal,vertical</td>             <td>horizontal</td></tr>
	<tr><td>list_size</td>   <td>lista di fotografie</td>           <td>numeric</td>                         <td>6</td></tr>
	<tr><td>position</td>    <td>posizione della lista di foto</td> <td>left,top,right,bottom</td>           <td>bottom</td></tr>
	<tr><td>delay</td>       <td>attesa in secondi</td>             <td>valore</td>                          <td>2</td></tr>
	<tr><td>paragraph</td>   <td>paragrafo dummy</td>               <td>true,false</td>                      <td>true</td></tr>
</table>

<h2>Shortcode example</h2>

<p>The shortcodes are macros that are inserted in to post requires some additional processing that have been made ​​available by plugins,
themes, or directly from the core. The plugin <b>SZ-Google</b> provides several shortcode beings that can be used in the classical 
form and with the customization options allowed. To insert a shortcode in our post we have to use the code in this form:</p>

<pre>[sz-panoramio template="list" columns="6" rows="3" height="300" bgcolor="#e1e1e1"/]</pre>

<h2>PHP code example</h2>

<p>If you want to use PHP functions provided by the plugin you must make sure that the corresponding module is active, once verified 
inserted in the desired location of your theme code similar to the following example, then prepared an array with the options you want 
and call up the required function. It is advisable to use before the function check if this exists, in this way you will not have 
PHP errors when plugin disabled or uninstalled.</p>

<pre>
\$options = array(
  'template' => 'list',
  'columns'  => '6',
  'rows'     => '3',
  'height'   => '300',
  'bgcolor'  => '#e1e1e1',
);

if (function_exists('szgoogle_get_panoramio_code')) {
  echo szgoogle_get_panoramio_code(\$options);
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
$prev = array('title'=>__('hangouts start button','szgoogleadmin'),'slug'=>'sz-google-help-hangout-start.php');
$next = array('title'=>__('translate setup'      ,'szgoogleadmin'),'slug'=>'sz-google-help-translate.php');

$HTML .= $this->moduleAddHelpNavs($prev,$next);

/**
 * Richiamo della funzione per la creazione della pagina di 
 * documentazione standard in base al contenuto della variabile HTML
 */
$this->moduleCommonForm(__('widget panoramio','szgoogleadmin'),NULL,NULL,false,$HTML);