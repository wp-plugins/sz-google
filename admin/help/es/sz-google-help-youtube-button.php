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

<p>With this function you can insert a button connected to the youtube channel by which you can sign up without leaving the web page. 
Use this component to add a badge to a sidebar or content of an article specifically.</p>

<p>To add this module you have to use the shortcode <b>[sz-ytbutton]</b>, but if you want to use it in a sidebar then you have to use 
the widget developed for this function in menu appearance -> widgets. For the most demanding there is also another possibility, 
in fact just use a PHP function provided by the plugin <b>szgoogle_youtube_get_code_button(\$options)</b>.</p>

<h2>Customization</h2>

<p>The component can be customized in many ways, just use the parameters listed in the table provided below. Regarding the widget 
parameters are obtained directly from the GUI, but if you use the shortcode or PHP function you must specify option = "value".</p>

<h2>Parámetros y opciones</h2>

<table>
	<tr><th>Parámetro</th>    <th>Descripción</th>        <th>Valores</th>                <th>Defecto</th></tr>
	<tr><td>channel</td>      <td>channel name or ID</td> <td>cadena</td>                 <td>configuración</td></tr>
	<tr><td>layout</td>       <td>layout type</td>        <td>default,full</td>           <td>default</td></tr>
	<tr><td>theme</td>        <td>theme</td>              <td>default,dark</td>           <td>default</td></tr>
	<tr><td>subscriber</td>   <td>subscriber</td>         <td>y=yes,n=no</td>             <td>default</td></tr>
	<tr><td>align</td>        <td>align</td>              <td>none,left,center,right</td> <td>none</td></tr>
</table>

<h2>Ejemplo de Shortcode</h2>

<p>Los shortcodes son códigos de macro que se insertan en un artículo de wordpress. Son procesados ​​por los plugins,
temas o incluso el núcleo. El plugin de SZ-Google tiene una gama de shortcodes que se pueden utilizar para las 
funciones previstas. Cada shortcode tiene varias opciones de configuración para las personalizaciones.</p>

<pre>[sz-ytbutton layout="full" theme="default"/]</pre>

<h2>Ejemplo de código PHP</h2>

<p>Si desea utilizar las funciones de PHP del plugin, asegurarse de que el módulo específico está activo, cuando se ha 
verificado esto, incluir las funciones en su tema y especifica las distintas opciones a través de una matriz. Es recomendable
comprobar si hay la función, de esta manera no tendrá errores de PHP cuando el Plugin es deshabilitado o desinstalado.</p>

<pre>
\$options = array(
  'channel' => 'TuttosuYTChannel',
  'layout'  => 'full',
  'theme'   => 'dark',
);

if (function_exists('szgoogle_youtube_get_code_button')) {
  echo szgoogle_youtube_get_code_button(\$options);
}
</pre>

<h2>Advertencias</h2>

<p>El plugin <b>SZ-Google</b> se ha desarrollado con una técnica de módulos de carga individuales para optimizar el rendimiento general,
así que antes de utilizar un shortcode, un widget o una función PHP debe comprobar que aparece el módulo general y la opción específica
permitido a través de la opción que se encuentra en el panel de administración.</p>

EOD;

// Call function for creating the page of standard
// documentation based on the contents of the HTML variable

$this->moduleCommonFormHelp(__('youtube button','szgoogleadmin'),NULL,NULL,false,$HTML,basename(__FILE__));