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

<h2>Documentation</h2>

<p>With this feature you can place on its website a widget that displays the recommendations related to the pages of your website 
based on social iterations. This feature will be displayed only on the mobile version of the web site and ignored on different 
devices. To enable this option, you must select the specific field that you find the admin panel but you also need to perform 
operations on google+ page connected to your site. <a target="_blank" href="https://developers.google.com/+/web/recommendations/?hl=it">Content recommendations for mobile websites</a>.</p>

<h2>Configuration</h2>

<p>In the settings section of the Google+ page you can control the behavior of the widget that relates to the advice and the display 
mode. So do not try to change these settings in the options but use the plugin configuration page directly on google plus.</p>

<p><b>The following options are available from the settings page:</b></p>

<ul>
<li>Turn on or off recommendations.</li>
<li>Choose pages or paths which should not show recommendations.</li>
<li>Choose pages or paths to prevent from displaying in the recommendations bar.</li>
</ul>

<p><b>Choose when to show the recommendations bar:</b></p>

<ul>
<li>When the user scrolls up.</li>
<li>When the user scrolls past an element with a specified ID.</li>
<li>When the user scrolls past an element that matches a DOM query selector.</li>
</ul>

<h2>Warnings</h2>

<p>The plugin <b>SZ-Google</b> has been developed with a technique of loading individual modules to optimize overall performance, 
so before you use a shortcode, a widget, or a PHP function you should check that the module general and the specific option appears 
enabled via the field dedicated option that you find in the admin panel.</p>

EOD;

/**
 * Richiamo della funzione per la creazione della pagina di 
 * documentazione standard in base al contenuto della variabile HTML
 */
$this->moduleCommonFormHelp(__('google+ recommendations','szgoogleadmin'),NULL,NULL,false,$HTML,basename(__FILE__));