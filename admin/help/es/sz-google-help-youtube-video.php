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

<p>This function allows you to insert a <b>youtube video</b> on a web page. The module youtube has many parameters that are used to add 
functionality or customize some aspects concerning the insertion mode, for example, we can choose between a fixed size of the player 
or a type of responsive design, you can choose between a "dark" theme and a "light", generate code for google analytics 
to track the operations on the video, set some parameters such as fullscreen, disablekeyboard, autoplay and loop.</p>

<p>To add this module you have to use the shortcode <b>[sz-ytvideo]</b>, but if you want to use it in a sidebar then you have to use 
the widget developed for this function in menu appearance -> widgets. For the most demanding there is also another possibility, 
in fact just use a PHP function provided by the plugin <b>szgoogle_youtube_get_code_video(\$options)</b>.</p>

<h2>Customization</h2>

<p>The component can be customized in many ways, just use the parameters listed in the table provided below. Regarding the widget 
parameters are obtained directly from the GUI, but if you use the shortcode or PHP function you must specify them manually in the 
format option = "value". If you would like additional information you can visit 
<a target="_blank" href="https://developers.google.com/youtube/player_parameters">YouTube Embedded Players</a>.</p>

<h2>Parámetros y opciones</h2>

<table>
	<tr><th>Parámetro</th>       <th>Descripción</th>            <th>Valores</th>              <th>Defecto</th></tr>
	<tr><td>url</td>             <td>address URL youtube</td>    <td>cadena</td>               <td>null</td></tr>
	<tr><td>responsive</td>      <td>responsive mode</td>        <td>y=yes,n=no</td>           <td>configuración</td></tr>
	<tr><td>width</td>           <td>width</td>                  <td>valor</td>                <td>configuración</td></tr>
	<tr><td>height</td>          <td>height</td>                 <td>valor</td>                <td>configuración</td></tr>
	<tr><td>margintop</td>       <td>margin top</td>             <td>valor</td>                <td>configuración</td></tr>
	<tr><td>marginright</td>     <td>margin right</td>           <td>valor</td>                <td>configuración</td></tr>
	<tr><td>marginbottom</td>    <td>margin bottom</td>          <td>valor</td>                <td>configuración</td></tr>
	<tr><td>marginleft</td>      <td>margin left</td>            <td>valor</td>                <td>configuración</td></tr>
	<tr><td>marginunit</td>      <td>margin unit</td>            <td>px,em</td>                <td>configuración</td></tr>
	<tr><td>autoplay</td>        <td>enable autoplay</td>        <td>y=yes,n=no</td>           <td>configuración</td></tr>
	<tr><td>loop</td>            <td>enable loop</td>            <td>y=yes,n=no</td>           <td>configuración</td></tr>
	<tr><td>fullscreen</td>      <td>full screen</td>            <td>y=yes,n=no</td>           <td>configuración</td></tr>
	<tr><td>disablekeyboard</td> <td>disable keyboard</td>       <td>y=yes,n=no</td>           <td>configuración</td></tr>
	<tr><td>theme</td>           <td>theme</td>                  <td>dark,light</td>           <td>configuración</td></tr>
	<tr><td>cover</td>           <td>cover image</td>            <td>local,youtube,URL,ID</td> <td>configuración</td></tr>
	<tr><td>title</td>           <td>video title</td>            <td>cadena</td>               <td>configuración</td></tr>
	<tr><td>disableiframe</td>   <td>disable iframe</td>         <td>y=yes,n=no</td>           <td>configuración</td></tr>
	<tr><td>analytics</td>       <td>google analytics</td>       <td>y=yes,n=no</td>           <td>configuración</td></tr>
	<tr><td>delayed</td>         <td>delayed</td>                <td>y=yes,n=no</td>           <td>configuración</td></tr>
	<tr><td>start</td>           <td>time start</td>             <td>seconds</td>              <td>null</td></tr>
	<tr><td>end</td>             <td>time end</td>               <td>seconds</td>              <td>null</td></tr>
	<tr><td>disablerelated</td>  <td>disable related video</td>  <td>y=yes,n=no</td>           <td>configuración</td></tr>
	<tr><td>schemaorg</td>       <td>schema.org enable</td>      <td>y=yes,n=no</td>           <td>configuración</td></tr>
	<tr><td>name</td>            <td>schema.org name</td>        <td>cadena</td>               <td>youtube video</td></tr>
	<tr><td>description</td>     <td>schema.org description</td> <td>cadena</td>               <td>título</td></tr>
	<tr><td>duration</td>        <td>schema.org duration</td>    <td><a target="_blank" href="http://it.wikipedia.org/wiki/ISO_8601">format ISO 8601</a></td><td>null</td></tr>
</table>

<h2>Ejemplo de Shortcode</h2>

<p>Los shortcodes son códigos de macro que se insertan en un artículo de wordpress. Son procesados ​​por los plugins,
temas o incluso el núcleo. El plugin de SZ-Google tiene una gama de shortcodes que se pueden utilizar para las 
funciones previstas. Cada shortcode tiene varias opciones de configuración para las personalizaciones.</p>

<pre>[sz-ytvideo url="http://www.youtube.com/watch?v=gUdKmGASz3g"/]</pre>

<h2>Ejemplo de código PHP</h2>

<p>Si desea utilizar las funciones de PHP del plugin, asegurarse de que el módulo específico está activo, cuando se ha 
verificado esto, incluir las funciones en su tema y especifica las distintas opciones a través de una matriz. Es recomendable
comprobar si hay la función, de esta manera no tendrá errores de PHP cuando el Plugin es deshabilitado o desinstalado.</p>

<pre>
\$options = array(
  'url'        => 'http://www.youtube.com/watch?v=gUdKmGASz3g',
  'responsive' => 'yes',
  'delayed'    => 'yes',
  'schemaorg'  => 'yes',
);

if (function_exists('szgoogle_youtube_get_code_video')) {
  echo szgoogle_youtube_get_code_video(\$options);
}
</pre>

<h2>Advertencias</h2>

<p>El plugin <b>SZ-Google</b> se ha desarrollado con una técnica de módulos de carga individuales para optimizar el rendimiento general,
así que antes de utilizar un shortcode, un widget o una función PHP debe comprobar que aparece el módulo general y la opción específica
permitido a través de la opción que se encuentra en el panel de administración.</p>

EOD;

// Call function for creating the page of standard
// documentation based on the contents of the HTML variable

$this->moduleCommonFormHelp(__('youtube video','szgoogleadmin'),NULL,NULL,false,$HTML,basename(__FILE__));