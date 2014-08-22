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

<p>To use this feature, you must install the application on your smartphone made ​​available by google in a free environment both 
in IOS Android and Blackberry. So first download the application and install it on your smartphone, as the first operation carried 
out the operation "set up account" and select the mode that is referred to as "read bar code" at this point you configure your 
profile on wordpress framed QR Code generated, if all went well you'll see on your phone a new account with the time code 
in the foreground.</p>

<h2>Resources and documentation</h2>

<ul>
<li><a target="_blank" href="https://itunes.apple.com/it/app/google-authenticator/id388497605?mt=8">Google Authenticator for Apple</a></li>
<li><a target="_blank" href="https://support.google.com/accounts/answer/1066447">Google Authenticator for Blackberry</a></li>
<li><a target="_blank" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2">Google Authenticator for Android</a></li>
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
$this->moduleCommonFormHelp(__('authenticator device','szgoogleadmin'),NULL,NULL,false,$HTML,basename(__FILE__));