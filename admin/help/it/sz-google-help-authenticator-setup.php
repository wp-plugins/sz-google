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

<p>Il plugin <b>SZ-Google</b> mette a disposizione il processo di autorizzazione a due fasi progettato da google authenticator, infatti
è possibile rafforzare la sicurezza del nostro pannello di login chiedendo un codice a tempo oltre alle credenziali normali. Questa
operazione è resa possibile grazie all'applicazione di Google Authenticator che è possibile installare sul nostro smartphone sia che 
questo sia un iphone, un android o un blackberry. Come vedremo in seguito la configurazione e la sincronizzazione della chiave verrà 
eseguita in maniera veloce e semplice utilizzando un codice QR Code da visualizzare sul proprio device.</p>

<h2>Configurazione</h2>

<p>Per prima cosa dovete attivare il modulo di Google Authenticator dal pannello di amministrazione che riguarda il plugin, una volta
attivato controllate che nella schermata di configurazione del modulo sia attiva la funzione di <b>"attivazione login"</b>. A questo punto
nella pagina del profilo utente verranno aggiunte delle informazioni per attivare l'autenticazione con chiave a tempo. Quindi collegatevi
con il vostro account e andate sulla pagina del vostro profilo, attivate la funzione di Google Authenticator, generate con
il pulsante apposito un nuovo "<b>codice segreto</b>" e visualizzate il codice <b>QR Code</b>, una volta visualizzato aggiungete un 
nuovo account sulla vostra applicazione mobile, se questa operazione termina correttamente aggiornate il profilo. Il fatto di 
aggiornare il profilo solo dopo la configurazione dello smartphone è dettato solo dal fatto che se aggiornate prima il profilo e
qualcosa va male sulla sincronizzazione del telefono dopo avrete problemi di login che devono essere risolti dall'amministratore.

<h2>Schermata</h2>

<p>Vi allego una schermata che riporta alcuni campi presenti sull'anagrafica profilo utente che servono per l'attivazione
di Google Authenticator nel profilo associato. Se non volete dare questa possibilità a qualche utente, usate il profilo con diritti
di amministratore e attivata l'opzione sul profilo interessato chiamata "nascondi google authenticator".</p>

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
$this->moduleCommonFormHelp(__('authenticator setup','szgoogleadmin'),NULL,NULL,false,$HTML,basename(__FILE__));