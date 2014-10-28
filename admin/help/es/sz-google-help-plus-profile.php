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

<p>If you have an account on Google+ and want to add it on your website or integrate it with your badge author then this is
the right tool. The badge of the profile can be inserted in different ways and through different custom
options put at our disposal by the plugin itself. The badge is inserted through an iframe with all features defined by google.</p>

<p>To add this component you have to use the shortcode <b>[sz-gplus-profile]</b>, but if you want to use it in a sidebar then you have to use 
the widget developed for this function in menu appearance -> widgets. For the most demanding there is also another possibility, 
in fact just use a PHP function provided by the plugin <b>szgoogle_gplus_get_badge_profile(\$options)</b>.</p>

<h2>Customization</h2>

<p>The component can be customized in many ways, just use the parameters listed in the table provided below. Regarding the widget 
parameters are obtained directly from the GUI, but if you use the shortcode or PHP function you must specify them manually in the 
format option = "value". If you would like additional information you can visit the official page 
<a target="_blank" href="https://developers.google.com/+/web/badge/?hl=it">Google+ Badge</a>.</p>

<h2>Parámetros y opciones</h2>

<table>
	<tr><th>Parámetro</th> <th>Descripción</th>        <th>Valores</th>                <th>Defecto</th></tr>
	<tr><td>id</td>        <td>profile</td>            <td>cadena</td>                 <td>configuración</td></tr>
	<tr><td>type</td>      <td>mode</td>               <td>standard,popup</td>         <td>standard</td></tr>
	<tr><td>width</td>     <td>width</td>              <td>valor,auto</td>             <td>configuración</td></tr>
	<tr><td>align</td>     <td>alignment</td>          <td>left,center,right,none</td> <td>none</td></tr>
	<tr><td>layout</td>    <td>layout</td>             <td>portrait,landscape</td>     <td>portrait</td></tr>
	<tr><td>theme</td>     <td>theme</td>              <td>light,dark</td>             <td>light</td></tr>
	<tr><td>cover</td>     <td>cover</td>              <td>true,false</td>             <td>true</td></tr>
	<tr><td>tagline</td>   <td>tagline</td>            <td>true,false</td>             <td>true</td></tr>
	<tr><td>author</td>    <td>rel=author in HTML</td> <td>true,false</td>             <td>false</td></tr>
	<tr><td>text</td>      <td>pop-up text</td>        <td>cadena</td>                 <td>null</td></tr>
	<tr><td>image</td>     <td>pop-up URL image</td>   <td>cadena</td>                 <td>null</td></tr>
</table>

<h2>Standard or popup</h2>

<p>As you can see from the table of options is called a <b>type</b> parameter with which you can choose to display the badge in a 
standard way and then immediately draw the badge in the HTML page or request a viewing mode only popup by passing the cursor over a 
<b>text</b> or <b>image</b>. In this case you have to specify the parameters for function pop-up text and image.</p>

<h2>Ejemplo de Shortcode</h2>

<p>Los shortcodes son códigos de macro que se insertan en un artículo de wordpress. Son procesados ​​por los plugins,
temas o incluso el núcleo. El plugin de SZ-Google tiene una gama de shortcodes que se pueden utilizar para las 
funciones previstas. Cada shortcode tiene varias opciones de configuración para las personalizaciones.</p>

<pre>[sz-gplus-profile id="106189723444098348646" type="standard" width="auto"/]</pre>

<h2>Ejemplo de código PHP</h2>

<p>Si desea utilizar las funciones de PHP del plugin, asegurarse de que el módulo específico está activo, cuando se ha 
verificado esto, incluir las funciones en su tema y especifica las distintas opciones a través de una matriz. Es recomendable
comprobar si hay la función, de esta manera no tendrá errores de PHP cuando el Plugin es deshabilitado o desinstalado.</p>

<pre>
\$options = array(
  'id'     => '106189723444098348646',
  'type'   => 'standard',
  'width'  => 'auto',
  'theme'  => 'dark',
  'layout' => 'portrait'
);

if (function_exists('szgoogle_gplus_get_badge_profile')) {
  echo szgoogle_gplus_get_badge_profile(\$options);
}
</pre>

<h2>Advertencias</h2>

<p>El plugin <b>SZ-Google</b> se ha desarrollado con una técnica de módulos de carga individuales para optimizar el rendimiento general,
así que antes de utilizar un shortcode, un widget o una función PHP debe comprobar que aparece el módulo general y la opción específica
permitido a través de la opción que se encuentra en el panel de administración.</p>

EOD;

// Call function for creating the page of standard
// documentation based on the contents of the HTML variable

$this->moduleCommonFormHelp(__('google+ badge profile','szgoogleadmin'),NULL,NULL,false,$HTML,basename(__FILE__));