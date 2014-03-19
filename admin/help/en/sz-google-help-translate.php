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
$IMAGE1 = SZ_PLUGIN_GOOGLE_PATH_ADMIN_IMAGES.'others/sz-google-translate.png';

/**
 * Definizione variabile HTML per la preparazione della stringa
 * che contiene la documentazione di questa funzionalità
 */
$HTML = <<<EOD

<p>Tramite questa opzione possiamo inserire nel nostro sito un selettore di lingua che esegua la traduzione automatica della
pagina web visualizzata senza abbandonare il sito di origine. Ovviamente non possiamo pretendere una traduzione di qualità come
quelle eseguite manualmente, però è comunque uno strumento che ritorna utile a chi pubblica articoli che possono interessare
a persone che parlano altre lingue e non si ha la possibilità di eseguire delle traduzioni accurate.</p>

<p>To add this module you have to use the shortcode <b>[sz-gtranslate]</b>, but if you want to use it in a sidebar then you have to use 
the widget developed for this function in menu appearance -> widgets. For the most demanding there is also another possibility, 
in fact just use a PHP function provided by the plugin <b>szgoogle_get_translate_code(\$options)</b>.</p>

<h2>Configuration</h2>

<p>Prima di usare il modulo di google translate bisogna registrare il sito sul proprio account google utilizzando 
<a target="_blank" href="https://translate.google.com/manager‎">Google Translate Tool</a>. 
Una volta inserito il proprio sito eseguire l'azione "get code" e prendere il codice meta specificato. Mi raccomando che nel campo che
trovate nel pannello di amministrazione dovete inserire solo il codice numerico e non tutto il codice HTML.</p>

<h2>Customization</h2>

<p>The component can be customized in many ways, just use the parameters listed in the table provided below. Regarding the widget 
parameters are obtained directly from the GUI, but if you use the shortcode or PHP function you must specify them manually in the 
format option = "value". If you would like additional information you can visit the official page 
<a target="_blank" href="https://translate.google.com/manager‎">Google Translate Manager</a>.</p>

<h2>Parameters and options</h2>

<table>
	<tr><th>Parameter</th>  <th>Description</th>              <th>Allowed values</th> <th>Default</th></tr>
	<tr><td>language</td>   <td>lingua del widget</td>        <td>stringa</td>         <td>configurazione</td></tr>
	<tr><td>mode</td>       <td>Modalità visualizzazione</td> <td>V,H,D</td>           <td>configurazione</td></tr>
	<tr><td>automatic</td>  <td>banner automatico</td>        <td>y=yes,n=no</td>      <td>configurazione</td></tr>
	<tr><td>analytics</td>  <td>google analytics</td>         <td>y=yes,n=no</td>      <td>configurazione</td></tr>
	<tr><td>uacode</td>     <td>google analytics UA</td>      <td>stringa</td>         <td>configurazione</td></tr>
</table>

<h2>Shortcode example</h2>

<p>The shortcodes are macros that are inserted in to post requires some additional processing that have been made ​​available by plugins,
themes, or directly from the core. The plugin <b>SZ-Google</b> provides several shortcode beings that can be used in the classical 
form and with the customization options allowed. To insert a shortcode in our post we have to use the code in this form:</p>

<pre>[sz-gtranslate mode="V" language="it_IT" automatic="yes"/]</pre>

<h2>PHP code example</h2>

<p>If you want to use PHP functions provided by the plugin you must make sure that the corresponding module is active, once verified 
inserted in the desired location of your theme code similar to the following example, then prepared an array with the options you want 
and call up the required function. It is advisable to use before the function check if this exists, in this way you will not have 
PHP errors when plugin disabled or uninstalled.</p>

<pre>
\$options = array(
  'language'  => 'it_IT',
  'mode'      => 'V',
  'automatic' => 'yes',
);

if (function_exists('szgoogle_get_translate_code')) {
  echo szgoogle_get_translate_code(\$options);
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
$prev = array('title'=>__('widget panoramio'       ,'szgoogleadmin'),'slug'=>'sz-google-help-panoramio.php');
$next = array('title'=>__('translate PHP functions','szgoogleadmin'),'slug'=>'sz-google-help-translate-functions.php');

$HTML .= $this->moduleAddHelpNavs($prev,$next);

/**
 * Richiamo della funzione per la creazione della pagina di 
 * documentazione standard in base al contenuto della variabile HTML
 */
$this->moduleCommonForm(__('translate setup','szgoogleadmin'),NULL,NULL,false,$HTML);