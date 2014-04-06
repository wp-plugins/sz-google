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
$IMAGE1 = SZ_PLUGIN_GOOGLE_PATH_ADMIN_IMAGES.'others/sz-google-plus-comments.jpg';

/**
 * Definizione variabile HTML per la preparazione della stringa
 * che contiene la documentazione di questa funzionalità
 */
$HTML = <<<EOD

<h2>Documentation</h2>

<p>In addition to badges and buttons Google+ offers a widget to manage a complete comment system linked to a web page URL. Once you 
got your widget on line it will look as simple as a traditional comment system, except for the necessary login to a Google+ profile 
in order to comment a post. When in use this widget automatically links the URL of the page your visitors are navigating, anyway 
it is possible to change this feature using the url=”URL” option.</p>

<p>To add this button you have to use the shortcode <b>[sz-gplus-comments]</b>, but if you want to use it in a sidebar then you have to use 
the widget developed for this function in menu appearance -> widgets. For the most demanding there is also another possibility, 
in fact just use a PHP function provided by the plugin <b>szgoogle_gplus_get_comments(\$options)</b>.</p>

<h2>Comments configuration</h2>

<p>Google+ comments can also be published automatically by the plugin, using wordpress standard position and overriding the standard 
comments at all. On the SZ-Google plugin configuration menu, look for the “Google+” panel, inside which you can find a “Comments” 
section where you can set up various options according to your needs. For example you can activate / deactivate the automatic 
standard comments override feature, choosing to completely substitute standard comments or to have Google+ comments in addition. You 
can choose to put Google+ comments right after the post content or after the standard wordpress comments. You can insert a starting 
date after which Google+ comment system will be activated, useful if you need to keep alive older posts’ standard comments and you 
want to start using Google+ comments from a precise date on.</p>

<h2>Parameters and options</h2>

<table>
	<tr><th>Parameter</th> <th>Description</th>          <th>Allowed values</th>          <th>Default</th></tr>
	<tr><td>url</td>       <td>complete address URL</td> <td>string</td>                  <td>current post</td></tr>
	<tr><td>width</td>     <td>width</td>                <td>value,auto</td>              <td>auto</td></tr>
	<tr><td>align</td>     <td>alignment</td>            <td>left,center,right,none</td>  <td>none</td></tr>
</table>

<h2>Widget size</h2>

<p>The Plugin <b>SZ-Google</b> may place the widget comments with a fixed size or use the technique of responsive design automatically 
adapts to the size of the overall container. If you want a fixed size that you just used the value width="width", but if you specify 
width="auto" the plugin will use the method responsive.</p>

<h2>Shortcode example</h2>

<p>The shortcodes are macros that are inserted in to post requires some additional processing that have been made ​​available by plugins,
themes, or directly from the core. The plugin <b>SZ-Google</b> provides several shortcode beings that can be used in the classical 
form and with the customization options allowed. To insert a shortcode in our post we have to use the code in this form:</p>

<pre>[sz-gplus-comments url="http://domain.com/post.html"]</pre>

<h2>PHP code example</h2>

<p>If you want to use PHP functions of the plugin you need to be sure that the specific module is active, when you have verified this,
include the functions in your theme and specifies the various options through an array. It is advisable to use before the function 
check if this exists, in this way you will not have PHP errors when plugin disabled or uninstalled.</p>

<pre>
\$options = array(
  'url'   => 'http://domain.com/post.html',
  'width' => 'auto',
  'align' => 'center',
);

if (function_exists('szgoogle_gplus_get_comments')) {
  echo szgoogle_gplus_get_comments(\$options);
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
$this->moduleCommonFormHelp(__('google+ widget comments','szgoogleadmin'),NULL,NULL,false,$HTML,basename(__FILE__));