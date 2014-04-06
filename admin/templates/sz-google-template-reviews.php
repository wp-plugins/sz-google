<?php
/**
 * Controllo se il file viene richiamato direttamente senza
 * essere incluso dalla procedura standard del plugin.
 *
 * @package SZGoogle
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die(); 

// Generazione array con tutte le risorse internet in cui
// viene menzionato o recensito il plugin SZ-Google for Wordpress

$reviewsLINK =  array(
	array('language' => ucfirst(__('dutch'   ,'szgoogleadmin')),'author'=>'Mike Nicolaassen'  ,'authorlink'=>'https://plus.google.com/+MikeNicolaassen'      ,'url'=>'http://www.mikenicolaassen.nl/google-for-wordpress/'),
	array('language' => ucfirst(__('english' ,'szgoogleadmin')),'author'=>'Dhiraj Das'        ,'authorlink'=>'https://plus.google.com/+DhirajDas'            ,'url'=>'http://www.indexwp.com/integrate-googles-products-wordpress/'),
	array('language' => ucfirst(__('english' ,'szgoogleadmin')),'author'=>'Tomáš Cirkl'       ,'authorlink'=>'https://plus.google.com/+TomášCirkl'           ,'url'=>'http://www.cmspanda.com/best-free-google-plugins-for-wordpress-2013/'),
	array('language' => ucfirst(__('german'  ,'szgoogleadmin')),'author'=>'Karl-Heinz Klug'   ,'authorlink'=>'https://plus.google.com/104371062498059635629/','url'=>'http://goopluscircles.de/sz-google-integration-fuer-wordpress_813.html'),
	array('language' => ucfirst(__('italian' ,'szgoogleadmin')),'author'=>'Andrea Barghigiani','authorlink'=>'https://plus.google.com/+AndreaBarghigiani'    ,'url'=>'http://wpandmore.info/sz-google-collegare-wordpress-servizi-google/'),
	array('language' => ucfirst(__('italian' ,'szgoogleadmin')),'author'=>'Andrea Lupi'       ,'authorlink'=>'https://plus.google.com/+AndreaLupi'           ,'url'=>'http://www.guida-wordpress.it/sz-google-plugin-per-integrare-servizi-google/'),
	array('language' => ucfirst(__('italian' ,'szgoogleadmin')),'author'=>'Roberto Rota'      ,'authorlink'=>'https://plus.google.com/+RobertoRota'          ,'url'=>'http://robrota.com/sz-google-plugin-wordpress/'),
	array('language' => ucfirst(__('italian' ,'szgoogleadmin')),'author'=>'WP Italyplus'      ,'authorlink'=>'https://plus.google.com/+wpitalyplus'          ,'url'=>'https://wpitalyplus.com/sz-google/'),
	array('language' => ucfirst(__('italian' ,'szgoogleadmin')),'author'=>'wpAndMore'         ,'authorlink'=>'https://plus.google.com/113990373278589561509/','url'=>'https://www.youtube.com/watch?v=cB2CKY1fkvY'),
	array('language' => ucfirst(__('korean'  ,'szgoogleadmin')),'author'=>'@Veteran'          ,'authorlink'=>'http://wpu.kr/tip/author/veteran/'             ,'url'=>'http://wpu.kr/tip/plugin-sz-google-for-wordpress/'),
	array('language' => ucfirst(__('japanese','szgoogleadmin')),'author'=>'オスミツキ'          ,'authorlink'=>'http://osumituki.com/author/オスミツキ/'         ,'url'=>'http://osumituki.com/web-front/687.html'),
);

// Creazione tabella per elenco delle risorse internet che
// sono contenute nell'array creato precedentemente

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