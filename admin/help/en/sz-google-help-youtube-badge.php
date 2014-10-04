<?php 
/**
 * Controllo se il file viene richiamato direttamente senza
 * essere incluso dalla procedura standard del plugin.
 *
 * @package SZGoogle
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die(); 

/**
 * Definizione variabile HTML per la preparazione della stringa
 * che contiene la documentazione di questa funzionalità
 */
$HTML = <<<EOD

<h2>Description</h2>

<p>With this component you can place a badge linked to your youtube channel and perform the action of entry directly from the component 
without going in this official page on youtube. You can enter the name of the channel or the channel ID , when you specify the size you 
can use the special value "auto" and get an automatic sizing of the container.</p>

<p>To add this module you have to use the shortcode <b>[sz-ytbadge]</b>, but if you want to use it in a sidebar then you have to use 
the widget developed for this function in menu appearance -> widgets. For the most demanding there is also another possibility, 
in fact just use a PHP function provided by the plugin <b>szgoogle_youtube_get_code_badge(\$options)</b>.</p>

<h2>Customization</h2>

<p>The component can be customized in many ways, just use the parameters listed in the table provided below. Regarding the widget 
parameters are obtained directly from the GUI, but if you use the shortcode or PHP function you must specify option = "value".</p>

<h2>Parameters and options</h2>

<table>
	<tr><th>BADGE</th>        <th>Description</th>        <th>Allowed values</th> <th>Default</th></tr>
	<tr><td>channel</td>      <td>channel name or ID</td> <td>string</td>         <td>configuration</td></tr>
	<tr><td>width</td>        <td>size pixel</td>         <td>value,auto</td>     <td>300</td></tr>
	<tr><td>height</td>       <td>size pixel</td>         <td>value,auto</td>     <td>150</td></tr>
	<tr><td>widthunit</td>    <td>size unit</td>          <td>px,em,%</td>        <td>px</td></tr>
	<tr><td>heightunit</td>   <td>size unit</td>          <td>px,em,%</td>        <td>px</td></tr>
</table>

<h2>Shortcode example</h2>

<p>The shortcodes are macros that are inserted in to post requires some additional processing that have been made ​​available by plugins,
themes, or directly from the core. The plugin <b>SZ-Google</b> provides several shortcode beings that can be used in the classical 
form and with the customization options allowed. To insert a shortcode in our post we have to use the code:</p>

<pre>[sz-ytbadge channel="TuttosuYTChannel" width="100" widthunit="%"/]</pre>

<h2>PHP code example</h2>

<p>If you want to use PHP functions of the plugin you need to be sure that the specific module is active, when you have verified this,
include the functions in your theme and specifies the various options through an array. It is advisable to use before the function 
check if this exists, in this way you will not have PHP errors when plugin disabled or uninstalled.</p>

<pre>
\$options = array(
  'channel'   => 'TuttosuYTChannel',
  'width'     => 'yes',
  'widthunit' => '%',
);

if (function_exists('szgoogle_youtube_get_code_badge')) {
  echo szgoogle_youtube_get_code_badge(\$options);
}
</pre>

<h2>Warnings</h2>

<p>The plugin <b>SZ-Google</b> has been developed with a technique of loading individual modules to optimize overall performance, 
so before you use a shortcode, a widget, or a PHP function you should check that the module general and the specific option appears 
enabled via the field dedicated option that you find in the admin panel.</p>

EOD;

/**
 * Richiamo della funzione per la creazione della pagina di 
 * documentazione standard in base al contenuto della variabile HTML
 */
$this->moduleCommonFormHelp(__('youtube badge','szgoogleadmin'),NULL,NULL,false,$HTML,basename(__FILE__));