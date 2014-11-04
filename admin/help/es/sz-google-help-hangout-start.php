<?php

/**
 * This file contains information related to a help section 
 * of the plugin. Each directory is a specific language
 *
 * @package SZGoogle
 * @subpackage SZGoogleAdmin
 * @author Massimo Della Rovere
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die(); 

// Variable definition HTML for the preparation of the
// string which contains the documentation of this feature

$HTML = <<<EOD

<h2>Descripción</h2>

<p>Using this function in the <b>SZ-Google</b> plugin you can place button start hangout inside a wordpress post or in a sidebar.
This button is used to start a video session with google hangout and the ability to launch a specific application. This feature can be 
very useful to develop an application on hangout and invite users to use.</p>

<p>To add this module you have to use the shortcode <b>[sz-hangouts-start]</b>, but if you want to use it in a sidebar then you have to use 
the widget developed for this function in menu appearance -> widgets. For the most demanding there is also another possibility, 
in fact just use a PHP function provided by the plugin <b>szgoogle_hangouts_get_code_start(\$options)</b>.</p>

<h2>Customization</h2>

<p>The component can be customized in many ways, just use the parameters listed in the table provided below. Regarding the widget 
parameters are obtained directly from the GUI, but if you use the shortcode or PHP function you must specify them manually in the 
format option = "value". If you would like additional information you can visit 
<a target="_blank" href="https://developers.google.com/+/hangouts/button?hl=it">Hangouts with the button</a>.</p>

<h2>Parámetros y opciones</h2>

<table>
	<tr><th>Parámetro</th>    <th>Descripción</th>   <th>Valores</th>                      <th>Defecto</th></tr>
	<tr><td>type</td>         <td>type</td>          <td>normal,onair,party,moderated</td> <td>normal</td></tr>
	<tr><td>topic</td>        <td>topic</td>         <td>cadena</td>                       <td>null</td></tr>
	<tr><td>width</td>        <td>width</td>         <td>valor,auto</td>                   <td>auto</td></tr>
	<tr><td>float</td>        <td>float</td>         <td>left,right,none</td>              <td>none</td></tr>
	<tr><td>align</td>        <td>alignment</td>     <td>left,center,right,none</td>       <td>none</td></tr>
	<tr><td>text</td>         <td>text</td>          <td>cadena</td>                       <td>null</td></tr>
	<tr><td>img</td>          <td>image</td>         <td>cadena</td>                       <td>null</td></tr>
	<tr><td>position</td>     <td>position</td>      <td>top,center,bottom,outside</td>    <td>outside</td></tr>
	<tr><td>margintop</td>    <td>margin top</td>    <td>valor,none</td>                   <td>none</td></tr>
	<tr><td>marginrigh</td>   <td>margin righ</td>   <td>valor,none</td>                   <td>none</td></tr>
	<tr><td>marginbottom</td> <td>margin bottom</td> <td>valor,none</td>                   <td>1</td></tr>
	<tr><td>marginleft</td>   <td>margin left</td>   <td>valor,none</td>                   <td>none</td></tr>
	<tr><td>marginunit</td>   <td>margin unit</td>   <td>em,pt,px</td>                     <td>em</td></tr>
</table>

<h2>Button wrapper</h2>

<p>The behavior of the button of google is to draw the component and connect it to the permitted actions. The <b>SZ-Google</b>
plugin has improved this feature and added parameters to allow the drawing of a container on which the button can be placed. For 
example, we can specify an image and place the button within it and specifying the position.</p>

<pre>[sz-hangouts-start img="http://domain.com/image.jpg" position="bottom"/]</pre>

<h2>Ejemplo de Shortcode</h2>

<p>Los shortcodes son códigos de macro que se insertan en un artículo de wordpress. Son procesados ​​por los plugins,
temas o incluso el núcleo. El plugin de SZ-Google tiene una gama de shortcodes que se pueden utilizar para las 
funciones previstas. Cada shortcode tiene varias opciones de configuración para las personalizaciones.</p>

<pre>[sz-hangouts-start type="normal"/]</pre>

<h2>Ejemplo de código PHP</h2>

<p>Si desea utilizar las funciones de PHP del plugin, asegurarse de que el módulo específico está activo, cuando se ha 
verificado esto, incluir las funciones en su tema y especifica las distintas opciones a través de una matriz. Es recomendable
comprobar si hay la función, de esta manera no tendrá errores de PHP cuando el Plugin es deshabilitado o desinstalado.</p>

<pre>
\$options = array(
  'type'  => 'normal',
  'align' => 'center',
);

if (function_exists('szgoogle_hangouts_get_code_start')) {
  echo szgoogle_hangouts_get_code_start(\$options);
}
</pre>

<h2>Advertencias</h2>

<p>El plugin <b>SZ-Google</b> se ha desarrollado con una técnica de módulos de carga individuales para optimizar el rendimiento general,
así que antes de utilizar un shortcode, un widget o una función PHP debe comprobar que aparece el módulo general y la opción específica
permitido a través de la opción que se encuentra en el panel de administración.</p>

EOD;

// Call function for creating the page of standard
// documentation based on the contents of the HTML variable

$this->moduleCommonFormHelp(__('hangout start button','szgoogleadmin'),NULL,NULL,false,$HTML,basename(__FILE__));