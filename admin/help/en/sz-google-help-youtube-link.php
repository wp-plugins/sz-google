<?php 


	$shortcode = array(
	); 

	// Definizione elenco delle funzioni presenti nella documentazione 
	// di questo modulo, il nome verrà visualizzato accanto al titolo

	$functions = array(
		'03' => 'szgoogle_get_youtube_code_badge()',
		'04' => 'szgoogle_get_youtube_code_button()',
		'05' => 'szgoogle_get_youtube_code_link()',
	); 
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
$IMAGE1 = SZ_PLUGIN_GOOGLE_PATH_ADMIN_IMAGES.'others/sz-google-youtube-link.png';

/**
 * Definizione variabile HTML per la preparazione della stringa
 * che contiene la documentazione di questa funzionalità
 */
$HTML = <<<EOD

<p>Con questa opzione potete inserire in una pagina web dei link ad un <b>canale youtube</b> in diverse maniere. Ad esempio potete inserire un 
link di testo semplice o un'immagine, un bottone più elaborato o un'intero badge. Tutti i componenti prevedono un parametro o un'azione
per effettuare la sottoscrizione al canale automaticamente o con la presentazione di un pop-up.</p>

<p>Per inserire questi componenti dovete usare gli <b>shortcode</b> disponibili, se invece desiderate utilizzare i componenti in una sidebar 
allora dovete utilizzare i widget specifici che trovate nel menu aspetto -> widgets. Per i più esigenti esiste anche un'altra possibilità, 
infatti basta utilizzare delle funzioni PHP messe a disposizione direttamente dal plugin. 

<h2>Shortcode</h2>

<ul>
<li>[sz-ytlink] - Link di testo semplice.</li>
<li>[sz-ytbutton] - Bottone con sottoscrizione.</li>
<li>[sz-ytbadge] - Badge del canale.</li>
</ul>

<h2>PHP functions</h2>

<ul>
<li>szgoogle_get_youtube_code_link()</li>
<li>szgoogle_get_youtube_code_button()</li>
<li>szgoogle_get_youtube_code_badge()</li>
</ul>

<h2>Customization</h2>

<p>The component can be customized in many ways, just use the parameters listed in the table provided below. Regarding the widget 
parameters are obtained directly from the GUI, but if you use the shortcode or PHP function you must specify them manually in the 
format option = "value". If you would like additional information you can visit the official page 
<a target="_blank" href="https://developers.google.com/youtube/youtube_subscribe_button">YouTube Subscribe Button</a>.</p>

<h2>Parameters and options</h2>

<table>

	<tr><th>LINK</th>         <th>Description</th>          <th>Allowed values</th> <th>Default</th></tr>
	<tr><td>channel</td>      <td>nome del canale o ID</td> <td>stringa</td>        <td>configurazione</td></tr>
	<tr><td>subscription</td> <td>sottoscrizione</td>       <td>y=yes,n=no</td>     <td>y=yes</td></tr>
	<tr><td>text</td>         <td>testo per il link</td>    <td>stringa</td>        <td>configurazione</td></tr>

	<tr class="space"><td colspan="4">&nbsp;</td></tr>

	<tr><th>BOTTONE</th>      <th>Description</th>          <th>Allowed values</th> <th>Default</th></tr>
	<tr><td>channel</td>      <td>nome del canale o ID</td> <td>stringa</td>        <td>configurazione</td></tr>
	<tr><td>layout</td>       <td>tipo layout</td>          <td>default,full</td>   <td>default</td></tr>
	<tr><td>theme</td>        <td>tema del bottone</td>     <td>default,full</td>   <td>default</td></tr>

	<tr class="space"><td colspan="4">&nbsp;</td></tr>

	<tr><th>BADGE</th>        <th>Description</th>          <th>Allowed values</th> <th>Default</th></tr>
	<tr><td>channel</td>      <td>nome del canale o ID</td> <td>stringa</td>        <td>configurazione</td></tr>
	<tr><td>width</td>        <td>dimensione pixel</td>     <td>valore</td>         <td>300</td></tr>
	<tr><td>height</td>       <td>dimensione pixel</td>     <td>valore</td>         <td>150</td></tr>
	<tr><td>widthunit</td>    <td>unità dimensione</td>     <td>px,em,%</td>        <td>px</td></tr>
	<tr><td>heightunit</td>   <td>unità dimensione</td>     <td>px,em,%</td>        <td>px</td></tr>
</table>

<h2>Shortcode example</h2>

<p>The shortcodes are macros that are inserted in to post requires some additional processing that have been made ​​available by plugins,
themes, or directly from the core. The plugin <b>SZ-Google</b> provides several shortcode beings that can be used in the classical 
form and with the customization options allowed. To insert a shortcode in our post we have to use the code in this form:</p>

<pre>
[sz-ytlink   text="iscriviti al mio canale youtube"/]
[sz-ytbutton layout="full" theme="default"/]
[sz-ytbadge  channel="TuttosuYTChannel" width="100" widthunit="%"/]
</pre>

<h2>PHP code example</h2>

<p>If you want to use PHP functions provided by the plugin you must make sure that the corresponding module is active, once verified 
inserted in the desired location of your theme code similar to the following example, then prepared an array with the options you want 
and call up the required function. It is advisable to use before the function check if this exists, in this way you will not have 
PHP errors when plugin disabled or uninstalled.</p>

<pre>
\$options = array(
  'channel'   => 'TuttosuYTChannel',
  'width'     => 'yes',
  'widthunit' => '%',
);

if (function_exists('szgoogle_get_youtube_code_badge')) {
  echo szgoogle_get_youtube_code_badge(\$options);
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
$prev = array('title'=>__('youtube playlist'       ,'szgoogleadmin'),'slug'=>'sz-google-help-youtube-playlist.php');
$next = NULL;

$HTML .= $this->moduleAddHelpNavs($prev,$next);

/**
 * Richiamo della funzione per la creazione della pagina di 
 * documentazione standard in base al contenuto della variabile HTML
 */
$this->moduleCommonForm(__('youtube link','szgoogleadmin'),NULL,NULL,false,$HTML);