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
$IMAGE1 = SZ_PLUGIN_GOOGLE_PATH_ADMIN_IMAGES.'others/sz-google-plus-authorship.jpg';

/**
 * Definizione variabile HTML per la preparazione della stringa
 * che contiene la documentazione di questa funzionalità
 */
$HTML = <<<EOD

<p>To configure a web page with the attribution of the author or publisher just use the badge page/profile specifying the activation 
with options author="true" and/or publisher="true". If you do not want to use google+ badge on your website, the plugin 
provides an alternative method. In fact, just turn on the options that you find in the admin panel calls HEAD Author and HEAD Publisher.</p>

<h2>HEAD code</h2>

<p>The code added by the plugin will be similar to the example shown below, the id of the profile and the page will be picked up by 
the general configuration of the module google+ present in the admin panel. The only thing you have to keep in mind is that while 
the publisher there is no problem to define it globally to the author are okay if your blog is single author, if by chance the 
website in question should not write different authors activate the function HEAD Author.</p>

<pre>
&lt;head&gt;
  &lt;link rel="author" href="https://plus.google.com/106189723444098348646"/&gt;
  &lt;link rel="publisher" href="https://plus.google.com/116899029375914044550"/&gt;
&lt;/head&gt;
</pre>

<h2>Verified code</h2>

<p>To complete the process of verification for both the publishers and the author does not just activate the plugin, but you must 
specify the name of your domain in the page and in the corresponding profile on google plus. For the author, there is a special section 
in the profile called "Information" where you can enter all the websites to which you write, and the publisher is verified when you 
insert your domain on the field site of the page. For any problems that concern Authorship read 
<a target="_blank" href="https://plus.google.com/authorship">Connect your Google+ profile</a>.</p>

<h2>Structured Data Testing Tool</h2>

<p>If you want to do tests to verify that the code produced by the plugin is correct you have to go on the official page of google 
part of the Webmaster Tools and call <a href="http://www.google.com/webmasters/tools/richsnippets">Structured Data Testing Tool</a>.</p>

<img class="screen" src="$IMAGE1" alt=""/>

<h2>Warnings</h2>

<p>The plugin <b>SZ-Google</b> has been developed with a technique of loading individual modules to optimize overall performance, 
so before you use a shortcode, a widget, or a PHP function you should check that the module general and the specific option appears 
enabled via the field dedicated option that you find in the admin panel.</p>

EOD;

/**
 * Richiamo della funzione per la creazione della pagina di 
 * documentazione standard in base al contenuto della variabile HTML
 */
$this->moduleCommonFormHelp(__('google+ author & publisher','szgoogleadmin'),NULL,NULL,false,$HTML,basename(__FILE__));