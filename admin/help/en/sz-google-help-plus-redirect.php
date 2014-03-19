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
$IMAGE1 = SZ_PLUGIN_GOOGLE_PATH_ADMIN_IMAGES.'others/sz-google-plus-redirect.png';

/**
 * Definizione variabile HTML per la preparazione della stringa
 * che contiene la documentazione di questa funzionalità
 */
$HTML = <<<EOD

<p>The format of the URL used by Google to identify its pages is definitely not a friendly url, it uses the numeric id of the very long 
URL string that make it impossible to remember or store. For this reason, G+ has made available for profiles and pages a custom URL to 
associate with your profile or page. Unfortunately, however, the system adopted is not always effective, in fact, especially in the pages 
are requested of additional characters that many web sites do not appreciate why not consistent with its original name. For example, 
a company called <b>skydrive</b> not agrees to print an address on an advertising material as <b>https://plus.google.com/+skydrive9876</b>.</p>

<h2>Domain redirect</h2>

<p>The plugin <b>SZ-Google</b> provides a feature to redirect your domain name, for example if the plugin is installed on the site 
that we took as an example <b>skydrive.com</b> you can create a custom URL as <b>https://skydrive.com/+</b> that will take you 
directly to google+ page, certainly more elegant that can be used without problems on various advertising materials or gadgets.</p>

<pre>
Google+ URL ==> https://plus.google.com/123456789012345
Google+ URL ==> https://plus.google.com/+skydrive9876
Plugin+ URL ==> https://skydrive.com/+
</pre>

<p>In the configuration section Google+ redirect present in the admin panel there is also the possibility of identifying a redirect 
to the string URL <b>/plus</b> and one of your choice. For example if you have a community attached to your page you could use the 
string URL <b>/community+</b> to redirect a direct bearing on google+ community page.</p>

<pre>
Plugin+ URL ==> https://skydrive.com/+
Plugin+ URL ==> https://skydrive.com/plus
Plugin+ URL ==> https://skydrive.com/community/+
</pre>

<h2>Screenshot</h2>

<p>In this picture you can see the end result of this feature. You can use your domain with a + sign.</p>

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
$prev = array('title'=>__('google+ author & publisher','szgoogleadmin'),'slug'=>'sz-google-help-plus-author-publisher.php');
$next = array('title'=>__('google+ recommendations'   ,'szgoogleadmin'),'slug'=>'sz-google-help-plus-recommendations.php');

$HTML .= $this->moduleAddHelpNavs($prev,$next);

/**
 * Richiamo della funzione per la creazione della pagina di 
 * documentazione standard in base al contenuto della variabile HTML
 */
$this->moduleCommonForm(__('google+ redirect','szgoogleadmin'),NULL,NULL,false,$HTML);