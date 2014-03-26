<?php
/**
 * Controllo se il file viene richiamato direttamente senza
 * essere incluso dalla procedura standard del plugin.
 *
 * @package SZGoogle
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die(); 

$IMAGE1 = SZ_PLUGIN_GOOGLE_PATH_ADMIN_IMAGES.'others/sz-google-hangout-start.jpg';

/**
 * Definizione variabile HTML per la preparazione della stringa
 * che contiene la documentazione di questa funzionalità
 */
$HTML = <<<EOD

<p>Tramite questa funzione presente nel plugin <b>SZ-Google</b> è possibile inserire in un post di wordpress o su una sidebar il 
bottone per avviare una sessione video con Hangout e la possibilità di lanciare un'applicazione determinata. Questa funzione può
essere molto utile a chi vuole sviluppare un'applicazione su Hangout ed invitare gli utenti all'utilizzo.</p>

<p>To add this module you have to use the shortcode <b>[sz-hangouts-start]</b>, but if you want to use it in a sidebar then you have to use 
the widget developed for this function in menu appearance -> widgets. For the most demanding there is also another possibility, 
in fact just use a PHP function provided by the plugin <b>szgoogle_get_hangouts_code_start(\$options)</b>.</p>

<h2>Customization</h2>

<p>The component can be customized in many ways, just use the parameters listed in the table provided below. Regarding the widget 
parameters are obtained directly from the GUI, but if you use the shortcode or PHP function you must specify them manually in the 
format option = "value". If you would like additional information you can visit the official page 
<a target="_blank" href="https://developers.google.com/+/hangouts/button?hl=it">Hangouts with the button</a>.</p>

<h2>Parameters and options</h2>

<table>
	<tr><th>Parameter</th>    <th>Description</th>        <th>Allowed values</th>               <th>Default</th></tr>
	<tr><td>type</td>         <td>tipo</td>               <td>normal,onair,party,moderated</td> <td>normal</td></tr>
	<tr><td>topic</td>        <td>argomento</td>          <td>stringa</td>                      <td>null</td></tr>
	<tr><td>width</td>        <td>larghezza</td>          <td>valore,auto</td>                  <td>auto</td></tr>
	<tr><td>float</td>        <td>float</td>              <td>left,right,none</td>              <td>none</td></tr>
	<tr><td>align</td>        <td>allineamento</td>       <td>left,center,right,none</td>       <td>none</td></tr>
	<tr><td>text</td>         <td>testo</td>              <td>stringa</td>                      <td>null</td></tr>
	<tr><td>img</td>          <td>immagine</td>           <td>stringa</td>                      <td>null</td></tr>
	<tr><td>position</td>     <td>posizione</td>          <td>top,center,bottom,outside</td>    <td>outside</td></tr>
	<tr><td>margintop</td>    <td>margine alto</td>       <td>valore,none</td>                  <td>none</td></tr>
	<tr><td>marginrigh</td>   <td>margine destro</td>     <td>valore,none</td>                  <td>none</td></tr>
	<tr><td>marginbottom</td> <td>margine basso</td>      <td>valore,none</td>                  <td>1</td></tr>
	<tr><td>marginleft</td>   <td>margine sinistro</td>   <td>valore,none</td>                  <td>none</td></tr>
	<tr><td>marginunit</td>   <td>misura per margine</td> <td>em,pt,px</td>                     <td>em</td></tr>
</table>

<h2>Button wrapper</h2>

<p>Il comportamento standard del bottone di google è quello di disegnare solo il bottone e collegare ad esso le azioni interattive 
permesse. Il plugin <b>SZ-Google</b> ha cercato di migliorare questo comportamento ed ha aggiunto dei parametri per permettere 
il disegno di un contenitore su cui il bottone può essere positionato. Ad esempio possiamo specificare un'immagine e posizionare il
bottone all'interno di essa in overlay e nella posizione che vogliamo. Qui di seguito un'esempio per chiarire:</p>

<pre>[sz-hangouts-start img="http://domain.com/image.jpg" position="bottom"/]</pre>

<h2>Shortcode example</h2>

<p>The shortcodes are macros that are inserted in to post requires some additional processing that have been made ​​available by plugins,
themes, or directly from the core. The plugin <b>SZ-Google</b> provides several shortcode beings that can be used in the classical 
form and with the customization options allowed. To insert a shortcode in our post we have to use the code in this form:</p>

<pre>[sz-hangouts-start type="normal"/]</pre>

<h2>PHP code example</h2>

<p>If you want to use PHP functions provided by the plugin you must make sure that the corresponding module is active, once verified 
inserted in the desired location of your theme code similar to the following example, then prepared an array with the options you want 
and call up the required function. It is advisable to use before the function check if this exists, in this way you will not have 
PHP errors when plugin disabled or uninstalled.</p>

<pre>
\$options = array(
  'type'  => 'normal',
  'align' => 'center',
);

if (function_exists('szgoogle_get_hangouts_code_start')) {
  echo szgoogle_get_hangouts_code_start(\$options);
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
$prev = array('title'=>__('widget groups'   ,'szgoogleadmin'),'slug'=>'sz-google-help-groups.php');
$next = array('title'=>__('widget panoramio','szgoogleadmin'),'slug'=>'sz-google-help-panoramio.php');

$HTML .= $this->moduleAddHelpNavs($prev,$next);

/**
 * Richiamo della funzione per la creazione della pagina di 
 * documentazione standard in base al contenuto della variabile HTML
 */
$this->moduleCommonForm(__('hangout start button','szgoogleadmin'),NULL,NULL,false,$HTML);