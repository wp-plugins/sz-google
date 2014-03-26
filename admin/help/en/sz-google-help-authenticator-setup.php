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
$IMAGE1 = SZ_PLUGIN_GOOGLE_PATH_ADMIN_IMAGES.'others/sz-google-authenticator-setup.jpg';

/**
 * Definizione variabile HTML per la preparazione della stringa
 * che contiene la documentazione di questa funzionalità
 */
$HTML = <<<EOD


<p>The <b>SZ-Google</b> plugin provides the authorization process in two phases designed by google authenticator, it is possible to 
strengthen the security of our login screen asking for a code-time in addition to the normal credentials. This is made ​​possible by 
the Google Authenticator that you can install on our smartphones whether it's an iphone, android or blackberry. As we will see below 
the configuration and synchronization of the key will be performed quickly and easily using a code QR Code to display on your device.</p>

<h2>Configuration</h2>

<p>First you must activate the form of Google Authenticator from the admin panel that covers the plugin, once activated check that 
the configuration screen of the module is activated "<b>active login</b>". At this point in the user profile page will add the 
information to enable key authentication in time. So connect with your account and go to the page of your profile, activate the Google 
Authenticator, generated with the appropriate button a new "secret code" and check the code QR Code, once displayed, add a new 
account on your mobile application if this operation completes successfully updated your profile. The fact that we update your profile 
only after the configuration of the smartphone is dictated only by the fact that if  you update your profile, and before something 
goes wrong on the timing of your phone after you have login problems that must be solved by the administrator.</p>

<h2>Screenshot</h2>

<p>I am attaching a screen that shows some of the fields present sull'anagrafica user profile that are used to activate the 
Google Authenticator associated with the profile. If you do not want to give this opportunity to any user, use the profile with 
administrator rights and enabled on the profile concerned called "Hide google authenticator."</p>

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
$prev = array('title'=>__('analytics PHP functions','szgoogleadmin'),'slug'=>'sz-google-help-ga-functions.php');
$next = array('title'=>__('authenticator PHP','szgoogleadmin')      ,'slug'=>'sz-google-help-authenticator-functions.php');

$HTML .= $this->moduleAddHelpNavs($prev,$next);

/**
 * Richiamo della funzione per la creazione della pagina di 
 * documentazione standard in base al contenuto della variabile HTML
 */
$this->moduleCommonForm(__('authenticator setup','szgoogleadmin'),NULL,NULL,false,$HTML);
