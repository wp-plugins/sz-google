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
$IMAGE1 = SZ_PLUGIN_GOOGLE_PATH_ADMIN_IMAGES.'others/sz-google-plus-badge-followers.png';

/**
 * Definizione variabile HTML per la preparazione della stringa
 * che contiene la documentazione di questa funzionalità
 */
$HTML = <<<EOD

<p>With this feature you can put a badge on a web page containing the list of followers attached to a page or a profile on this 
google+. The badge will display the thumbnails of the profiles that follow the resource on google+ and is also added a button to add 
your profile page or directly to a circle. At this time the badge issued by google is not responsive, however, the plugin adds a 
parameter width="auto" means that javascript will try to calculate the width of the container and pass it to the code of google+.</p>

<p>To add this button you have to use the shortcode <b>[sz-gplus-followers]</b>, but if you want to use it in a sidebar then you have to use 
the widget developed for this function in menu appearance -> widgets. For the most demanding there is also another possibility, 
in fact just use a PHP function provided by the plugin <b>szgoogle_get_gplus_badge_followers(\$options)</b>.</p>

<h2>Parameters and options</h2>

<table>
	<tr><th>Parameter</th> <th>Description</th>     <th>Allowed values</th>         <th>Default</th></tr>
	<tr><td>id</td>        <td>page or profile</td> <td>string</td>                 <td>configuration</td></tr>
	<tr><td>align</td>     <td>alignment</td>       <td>left,center,right,none</td> <td>none</td></tr>
	<tr><td>width</td>     <td>width</td>           <td>value,auto</td>             <td>configuration</td></tr>
	<tr><td>height</td>    <td>height</td>          <td>value,auto</td>             <td>configuration</td></tr>
</table>

<h2>Shortcode example</h2>

<p>The shortcodes are macros that are inserted in to post requires some additional processing that have been made ​​available by plugins,
themes, or directly from the core. The plugin <b>SZ-Google</b> provides several shortcode beings that can be used in the classical 
form and with the customization options allowed. To insert a shortcode in our post we have to use the code in this form:</p>

<pre>[sz-gplus-followers url="https://plus.google.com/+wpitalyplus"/]</pre>

<h2>PHP code example</h2>

<p>If you want to use PHP functions provided by the plugin you must make sure that the corresponding module is active, once verified 
inserted in the desired location of your theme code similar to the following example, then prepared an array with the options you want 
and call up the required function. It is advisable to use before the function check if this exists, in this way you will not have 
PHP errors when plugin disabled or uninstalled.</p>

<pre>
\$options = array(
  'url'    => 'https://plus.google.com/+wpitalyplus',
  'width'  => 'auto',
  'height' => 'auto',
);

if (function_exists('szgoogle_get_gplus_badge_followers')) {
  echo szgoogle_get_gplus_badge_followers(\$options);
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
$prev = array('title'=>__('google+ embedded post'     ,'szgoogleadmin'),'slug'=>'sz-google-help-plus-post.php');
$next = array('title'=>__('google+ author & publisher','szgoogleadmin'),'slug'=>'sz-google-help-plus-author-publisher.php');

$HTML .= $this->moduleAddHelpNavs($prev,$next);

/**
 * Richiamo della funzione per la creazione della pagina di 
 * documentazione standard in base al contenuto della variabile HTML
 */
$this->moduleCommonForm(__('google+ badge followers','szgoogleadmin'),NULL,NULL,false,$HTML);