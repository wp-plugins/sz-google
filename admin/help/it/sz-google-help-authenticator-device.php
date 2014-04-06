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
$IMAGE1 = SZ_PLUGIN_GOOGLE_PATH_ADMIN_IMAGES.'others/sz-google-authenticator-device.jpg';

/**
 * Definizione variabile HTML per la preparazione della stringa
 * che contiene la documentazione di questa funzionalità
 */
$HTML = <<<EOD

<h2>Descrizione</h2>

<p>Per utilizzare questa funzionalità bisogna installare sul proprio smartphone l'applicazione messa a disposizione da google in
maniera gratuita sia in ambiente IOS che Android e Blackberry. Quindi per prima cosa scaricate l'applicazione e installatela sul
vostro smartphone, come prima operazione eseguite l'operazione "configura account" e selezionate la modalità che viene indicata 
come "leggi codice a barre", a questo punto configurate il vostro profilo su wordpress e inquadrate il QR Code generato, se 
tutto è andato bene vedrete nel vostro smartphone un nuovo account con il codice a tempo in primo piano.</p>

<h2>Risorse e documentazione</h2>

<ul>
<li><a target="_blank" href="https://itunes.apple.com/it/app/google-authenticator/id388497605?mt=8">Google Authenticator su Apple Store</a></li>
<li><a target="_blank" href="https://support.google.com/accounts/answer/1066447">Google Authenticator su Blackberry</a></li>
<li><a target="_blank" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2">Google Authenticator su Google Play</a></li>
</ul>

<h2>Schermata</h2>

<p>Vi allego una schermata di uno smartphone android dove potete vedere che ogni account utilizzato in google authenticator
ha il suo codice a tempo che deve essere usato durante un login. Potete usare codici diversi per ogni sito web che gestite senza
nessun problema, basterà solamente configurare con il QR Code dei profili su differenti account.</p>

<img class="screen" src="$IMAGE1" alt=""/>

<h2>Avvertenze</h2>

<p>Il plugin <b>SZ-Google</b> è stato sviluppato con una tecnica di caricamento moduli singoli per ottimizzare le performance generali, 
quindi prima di utilizzare uno shortcode, un widget o una funzione PHP bisogna controllare che il modulo generale e l'opzione specifica 
risulti attivata tramite il campo opzione dedicato che trovate nel pannello di amministrazione.</p>

EOD;

/**
 * Richiamo della funzione per la creazione della pagina di 
 * documentazione standard in base al contenuto della variabile HTML
 */
$this->moduleCommonFormHelp(__('authenticator device','szgoogleadmin'),NULL,NULL,false,$HTML,basename(__FILE__));