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
$IMAGE1 = SZ_PLUGIN_GOOGLE_PATH_ADMIN_IMAGES.'others/sz-google-plus-authorship.png';

/**
 * Definizione variabile HTML per la preparazione della stringa
 * che contiene la documentazione di questa funzionalità
 */
$HTML = <<<EOD

<p>Per configurare una pagina web con l'attribuzione di autore o publisher basta utilizzare il badge del profilo e/o quello della
pagina specificando l'attivazione delle relative opzioni con author="true" e/o publisher="true". Se per esigenze particolari non volete
utilizzare i badge di google+ sul vostro sito, il plugin <b>SZ-Google</b> mette a disposizione un metodo alternativo per raggiungere
lo stesso obiettivo. Infatti basta attivare le opzioni che trovate nel pannello di amministrazione chiamate HEAD Author e HEAD Publisher.</p>

<h2>Codice in HEAD</h2>

<p>Il codice aggiunto dal plugin sarà simile all'esempio qui di seguito riportato, gli id del profilo e della pagina verrano presi dalla
configurazione generale del modulo google+ presente nel pannello di amministrazione. L'unica cosa che dovete tenere conto è che mentre
per il <b>publisher</b> non ci sono problemi a definirlo a livello globale per l'<b>autore</b> va bene sono se il blog è mono autore, se per caso
sul sito web in questione dovessero scrivere autori diversi non attivate la funzione HEAD Author.

<pre>
&lt;head&gt;
  &lt;link rel="author" href="https://plus.google.com/106189723444098348646"/&gt;
  &lt;link rel="publisher" href="https://plus.google.com/116899029375914044550"/&gt;
&lt;/head&gt;
</pre>

<h2>Codice verificato</h2>

<p>Per completare l'operazione di verifica sia per il publisher che per l'autore non basta attivare le funzioni del plugin, ma bisogna
specificare il nome del proprio dominio nella pagina e nel profilo corrispondente su google plus. Per l'autore esiste una sezione apposita 
nel profilo chiamata "Informazioni" dove potete inserire tutti i siti web per cui scrivete, mentre il publisher viene verificato quando
viene inserito il proprio domino sul campo sito web della pagina stessa. Se dovessi riscontrare dei problemi che riguardano l'assegnazione
Authorship leggi con attenzione la pagina ufficiale <a target="_blank" href="https://plus.google.com/authorship">Collega il tuo profilo Google+</a>.</p>
</p>

<h2>Structured Data Testing Tool</h2>

<p>Se volete fare dei test per verificare che il codice prodotto dal plugin sia corretto dovete andare sulla pagina ufficiale di google
facente parte degli Webmaster Tools e chiamata <a href="http://www.google.com/webmasters/tools/richsnippets">Structured Data Testing Tool</a>.</p>

<img class="screen" src="$IMAGE1" alt=""/>

<h2>Avvertenze</h2>

<p>Il plugin <b>SZ-Google</b> è stato sviluppato con una tecnica di caricamento moduli singoli per ottimizzare le performance generali, quindi prima di 
utilizzare uno shortcode, un widget o una funzione PHP bisogna controllare che il modulo generale e l'opzione specifica risulti 
attivata tramite il campo opzione dedicato che trovate nel pannello di amministrazione.</p>

EOD;

/**
 * Definizione array per la creazione del navigatore di fondo
 * con i link seguenti e precedenti della documentazione
 */
$prev = array('title'=>__('google+ badge followers','szgoogleadmin'),'slug'=>'sz-google-help-plus-followers.php');
$next = array('title'=>__('google+ redirect'       ,'szgoogleadmin'),'slug'=>'sz-google-help-plus-redirect.php');

$HTML .= $this->moduleAddHelpNavs($prev,$next);

/**
 * Richiamo della funzione per la creazione della pagina di 
 * documentazione standard in base al contenuto della variabile HTML
 */
$this->moduleCommonForm(__('google+ author & publisher','szgoogleadmin'),NULL,NULL,false,$HTML);