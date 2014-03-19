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
$IMAGE1 = SZ_PLUGIN_GOOGLE_PATH_ADMIN_IMAGES.'others/sz-google-analytics.png';

/**
 * Definizione variabile HTML per la preparazione della stringa
 * che contiene la documentazione di questa funzionalità
 */
$HTML = <<<EOD

<p>Google Analytics è un servizio gratuito messo a disposizione da Google per controllare le statistiche di accesso che riguardano
un sito web, questo strumento è usato specialmente da web marketing e webmaster che usufruiscono del servizio aggiungendo un piccolo 
codice HTML alle pagine web, il quale gli permette il monitoraggio e la raccolta delle informazioni legate ai visitatori.</p>

<p>Tramite questo modulo presente nel plugin <b>SZ-Google</b> potete eseguire la stessa operazione senza conoscere nessun aspetto di 
programmazione che riguarda HTML o PHP. Infatti basterà inserire le informazioni richieste e il codice verrà inserito manualmente 
sulle vostre pagine web. Ovviamente dovete già possedere un account google valido su analytics.</p>

<h2>Attivazione modulo</h2>

<p>Una volta che avete verificato di avere un’account valido in google analytics potete attivare il modulo nella sezione generale del
plugin ed inserire il codice UA da associare al monitoraggio. Controllate bene anche i parametri di abilitazione per scegliere quando
il plugin deve inserire il monitoraggio, ad esempio solo nel frontend o anche nel pannello di amministrazione ? Possiamo anche escludere 
gli accessi fatti dagli amministratori o dagli utenti loggati per non aumentare le statistiche con i nostri accessi, i quali potrebbero 
falsare le medie che dobbiamo analizzare e ci potrebbero far sbagliare le nostre previsioni.<p>

<h2>Codice di monitoraggio</h2>

<p>Il codice per default viene inserito nella sezione &lt;head&gt; della pagina HTML, esattamente dove google raccomanda di 
inserirlo, in ogni caso è possibile modificare questo comportamento e specificare di inserirlo in fondo alla pagina o manualmente 
utilizzando una funzione PHP che potete inserire in qualsiasi punto della vostra pagina HTML, magari aggiungendo anche dei controlli 
personalizzati per includere o escludere il monitoraggio. La funzione da usare per l’inserimento manuale è chiamata 
<b>szgoogle_get_ga_code()</b> e non necessita di nessun parametro particolare, basta richiamarla con il comando “echo” 
in qualsiasi parte del vostro tema.</p>

<pre>
if (function_exists('szgoogle_get_ga_code')) {
  echo szgoogle_get_ga_code();
}
</pre>

<h2>Universal Analytics</h2>

<p>Google ha rilasciato un nuovo codice di monitoraggio chiamato Universal Analytics che introduce una serie di caratteristiche che
cambiano il modo in cui i dati sono raccolti e organizzati nel tuo account di Google Analytics, in modo da poter ottenere una migliore
comprensione dei contenuti online. Per tutti i siti web che sono stati configurati nel vecchio metodo si necessità di una conversione
che viene fatta direttamente dal pannello di amministrazione di GA. Solo dopo questa conversione potete attivare l'opzione di Universal
Analytics sul plugin SZ-Google che in ogni caso gestisce automaticamente sia il vecchio codice che il nuovo.</p>

<h2>Schermata</h2>

<p>Via allego una schermata che riporta alcuni grafici presenti su google analytics, uno strumento indispensabile per tutti i
proprietari di siti web e ancora di più per i webmaster che li gestiscono.</p>

<img class="screen" src="$IMAGE1" alt=""/>

<h2>Avvertenze</h2>

<p>Il plugin <b>SZ-Google</b> è stato sviluppato con una tecnica di caricamento moduli singoli per ottimizzare le performance generali, 
quindi prima di utilizzare uno shortcode, un widget o una funzione PHP bisogna controllare che il modulo generale e l'opzione specifica 
risulti attivata tramite il campo opzione dedicato che trovate nel pannello di amministrazione.</p>

EOD;

/**
 * Definizione array per la creazione del navigatore di fondo
 * con i link seguenti e precedenti della documentazione
 */
$prev = array('title'=>__('google+ recommendations','szgoogleadmin'),'slug'=>'sz-google-help-plus-recommendations.php');
$next = array('title'=>__('analytics PHP functions','szgoogleadmin'),'slug'=>'sz-google-help-ga-functions.php');

$HTML .= $this->moduleAddHelpNavs($prev,$next);

/**
 * Richiamo della funzione per la creazione della pagina di 
 * documentazione standard in base al contenuto della variabile HTML
 */
$this->moduleCommonForm(__('analytics setup','szgoogleadmin'),NULL,NULL,false,$HTML);