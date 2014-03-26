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
$IMAGE1 = SZ_PLUGIN_GOOGLE_PATH_ADMIN_IMAGES.'others/sz-google-youtube-playlist.jpg';

/**
 * Definizione variabile HTML per la preparazione della stringa
 * che contiene la documentazione di questa funzionalità
 */
$HTML = <<<EOD

<p>Questa funzione permette l'inserimento di una <b>playlist youtube</b> su una pagina web. Il modulo youtube ha molti parametri che 
servono per aggiungere funzionalità o personalizzare alcuni aspetti che riguardano la modalità di inserimento, ad esempio possiamo 
decidere tra una dimensione fissa del player o una di tipo responsive design, è possibile scegliere tra un tema “dark” e uno “light”, 
agganciare automaticamente il codice di google analytics per tracciare le operazioni che vengono eseguite sul video, 
impostare alcuni parametri come fullscreen, disablekeyboard, autoplay e loop e molto altro ancora.</p>

<p>To add this module you have to use the shortcode <b>[sz-ytplaylist]</b>, but if you want to use it in a sidebar then you have to use 
the widget developed for this function in menu appearance -> widgets. For the most demanding there is also another possibility, 
in fact just use a PHP function provided by the plugin <b>szgoogle_get_youtube_code_playlist(\$options)</b>.</p>

<h2>Customization</h2>

<p>The component can be customized in many ways, just use the parameters listed in the table provided below. Regarding the widget 
parameters are obtained directly from the GUI, but if you use the shortcode or PHP function you must specify them manually in the 
format option = "value". If you would like additional information you can visit the official page 
<a target="_blank" href="https://support.google.com/youtube/answer/171780?hl=it">Embed videos and playlists</a>.</p>

<h2>Parameters and options</h2>

<table>
	<tr><th>Parameter</th>    <th>Description</th>         <th>Allowed values</th>  <th>default</th></tr>
	<tr><td>id</td>           <td>youtube playlist ID</td> <td>stringa</td>         <td>null</td></tr>
	<tr><td>width</td>        <td>larghezza in pixel</td>  <td>valore,auto</td>     <td>configurazione</td></tr>
	<tr><td>height</td>       <td>altezza in pixel</td>    <td>valore,auto</td>     <td>configurazione</td></tr>
	<tr><td>margintop</td>    <td>margine alto</td>        <td>valore</td>          <td>configurazione</td></tr>
	<tr><td>marginright</td>  <td>margine destro</td>      <td>valore</td>          <td>configurazione</td></tr>
	<tr><td>marginbottom</td> <td>margine basso</td>       <td>valore</td>          <td>configurazione</td></tr>
	<tr><td>marginleft</td>   <td>margine sinistro</td>    <td>valore</td>          <td>configurazione</td></tr>
	<tr><td>marginunit</td>   <td>misura per margine</td>  <td>px,em</td>           <td>configurazione</td></tr>
</table>

<h2>Shortcode example</h2>

<p>The shortcodes are macros that are inserted in to post requires some additional processing that have been made ​​available by plugins,
themes, or directly from the core. The plugin <b>SZ-Google</b> provides several shortcode beings that can be used in the classical 
form and with the customization options allowed. To insert a shortcode in our post we have to use the code in this form:</p>

<pre>[sz-ytplaylist id="PL1wZKxf9cUnICoU0usAWMbyURT40rJD71"/]</pre>

<h2>PHP code example</h2>

<p>If you want to use PHP functions provided by the plugin you must make sure that the corresponding module is active, once verified 
inserted in the desired location of your theme code similar to the following example, then prepared an array with the options you want 
and call up the required function. It is advisable to use before the function check if this exists, in this way you will not have 
PHP errors when plugin disabled or uninstalled.</p>

<pre>
\$options = array(
  'id'     => 'PL1wZKxf9cUnICoU0usAWMbyURT40rJD71',
  'width'  => 'auto',
  'height' => 'auto',
);

if (function_exists('szgoogle_get_youtube_code_playlist')) {
  echo szgoogle_get_youtube_code_playlist(\$options);
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
$prev = array('title'=>__('youtube video','szgoogleadmin'),'slug'=>'sz-google-help-youtube-video.php');
$next = array('title'=>__('youtube link' ,'szgoogleadmin'),'slug'=>'sz-google-help-youtube-link.php');

$HTML .= $this->moduleAddHelpNavs($prev,$next);

/**
 * Richiamo della funzione per la creazione della pagina di 
 * documentazione standard in base al contenuto della variabile HTML
 */
$this->moduleCommonForm(__('youtube playlist','szgoogleadmin'),NULL,NULL,false,$HTML);