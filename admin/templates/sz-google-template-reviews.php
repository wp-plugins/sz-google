<?php

/**
 * file containing the HTML structure of the templates 
 * related to some sections of the admin panel
 *
 * @package SZGoogle
 * @subpackage Admin
 * @author Massimo Della Rovere
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die(); 

// Generate array with all the internet resources where is
// mentioned or reviewed the SZ-Google plugin for WordPress

$reviewsLINK =  array(
	array('language' => ucfirst(__('chinese','szgoogleadmin')),'author'=>'Simon'               ,'authorlink'=>'http://blog.dg-space.com/author/simon'          ,'url'=>'http://goo.gl/WTk7qX'),
	array('language' => ucfirst(__('dutch'  ,'szgoogleadmin')),'author'=>'Mike Nicolaassen'    ,'authorlink'=>'https://plus.google.com/+MikeNicolaassen'       ,'url'=>'http://www.mikenicolaassen.nl/google-for-wordpress/'),
	array('language' => ucfirst(__('english','szgoogleadmin')),'author'=>'Dhiraj Das'          ,'authorlink'=>'https://plus.google.com/+DhirajDas'             ,'url'=>'http://www.indexwp.com/integrate-googles-products-wordpress/'),
	array('language' => ucfirst(__('english','szgoogleadmin')),'author'=>'Thomas Ewer'         ,'authorlink'=>'https://plus.google.com/+ThomasEwer'            ,'url'=>'https://managewp.com/free-wordpress-plugins-april-2014'),
	array('language' => ucfirst(__('english','szgoogleadmin')),'author'=>'Tomáš Cirkl'         ,'authorlink'=>'https://plus.google.com/+TomášCirkl'            ,'url'=>'http://www.cmspanda.com/best-free-google-plugins-for-wordpress-2013/'),
	array('language' => ucfirst(__('german' ,'szgoogleadmin')),'author'=>'Über Karl-Heinz Klug','authorlink'=>'http://www.blogging-inside.de/author/khk'       ,'url'=>'http://goo.gl/n3xOa9'),
	array('language' => ucfirst(__('italian','szgoogleadmin')),'author'=>'Andrea Barghigiani'  ,'authorlink'=>'https://plus.google.com/+AndreaBarghigiani'     ,'url'=>'http://wpandmore.info/sz-google-collegare-wordpress-servizi-google/'),
	array('language' => ucfirst(__('italian','szgoogleadmin')),'author'=>'Andrea Lupi'         ,'authorlink'=>'https://plus.google.com/+AndreaLupi'            ,'url'=>'http://www.guida-wordpress.it/sz-google-plugin-per-integrare-servizi-google/'),
	array('language' => ucfirst(__('italian','szgoogleadmin')),'author'=>'Massimo Della Rovere','authorlink'=>'https://plus.google.com/+MassimoDellaRovere'    ,'url'=>'https://otherplus.com/tech/sz-google/'),
	array('language' => ucfirst(__('italian','szgoogleadmin')),'author'=>'Roberto Rota'        ,'authorlink'=>'https://plus.google.com/+RobertoRota'           ,'url'=>'http://robrota.com/sz-google-plugin-wordpress/'),
	array('language' => ucfirst(__('italian','szgoogleadmin')),'author'=>'wpAndMore'           ,'authorlink'=>'https://plus.google.com/113990373278589561509/' ,'url'=>'https://www.youtube.com/watch?v=cB2CKY1fkvY'),
	array('language' => ucfirst(__('italian','szgoogleadmin')),'author'=>'WP Italyplus'        ,'authorlink'=>'https://plus.google.com/+wpitalyplus'           ,'url'=>'https://www.youtube.com/watch?v=-3IVTqJxFtc'),
	array('language' => ucfirst(__('spanish','szgoogleadmin')),'author'=>'Fabriciano González' ,'authorlink'=>'https://plus.google.com/+FabricianoGonzález1948','url'=>'http://goo.gl/FZBvld'),
	array('language' => ucfirst(__('spanish','szgoogleadmin')),'author'=>'Miguel Cubas'        ,'authorlink'=>'http://www.mundowordpress.net/author/admin/'    ,'url'=>'http://www.mundowordpress.net/como-integrar-los-productos-de-google-en-wordpress/'),
	array('language' => ucfirst(__('korean' ,'szgoogleadmin')),'author'=>'@Veteran'            ,'authorlink'=>'http://wpu.kr/tip/author/veteran/'              ,'url'=>'http://wpu.kr/tip/plugin-sz-google-for-wordpress/'),
	array('language' => ucfirst(__('russian','szgoogleadmin')),'author'=>'Tatyana Leskova'     ,'authorlink'=>'https://plus.google.com/116691044222072795783/' ,'url'=>'http://drago-fly.ru/plagin-sz-google/'),
);

// Generate array with all the internet resources 
// which are contained in the array created earlier

echo '<div class="help">';
echo '<table>';

echo '<tr>';
echo '<th>'.ucfirst(__('language'   ,'szgoogleadmin')).'</th>';
echo '<th>'.ucfirst(__('author'     ,'szgoogleadmin')).'</th>';
echo '<th>'.ucfirst(__('URL address','szgoogleadmin')).'</th>';
echo '</tr>';

foreach ($reviewsLINK as $key => $value) 
{
	echo '<tr>';
	echo '<td>'.$value['language'].'</td>';
	echo '<td><a target="_blank" href="'.$value['authorlink'].'">'.$value['author'].'</a></td>';
	echo '<td><a target="_blank" href="'.$value['url'].'">'.$value['url'].'</a></td>';
	echo '</tr>';
}

echo '</table>';
echo '</div>';