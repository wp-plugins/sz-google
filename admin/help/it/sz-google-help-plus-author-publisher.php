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

<h2>Descrizione</h2>

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
specificare il nome del proprio dominio nella pagina e nel profilo corrispondente su google plus. Per l'autore esiste una sezione apposita nel 
profilo chiamata "Informazioni" dove potete inserire tutti i siti web per cui scrivete, mentre il publisher viene verificato quando viene inserito 
il proprio domino sul campo sito web della pagina stessa. Se dovessi riscontrare dei problemi che riguardano l'assegnazione Authorship 
leggi con attenzione la pagina ufficiale <a target="_blank" href="https://plus.google.com/authorship">Collega il tuo profilo Google+</a>.</p>

<h2>Funzioni PHP</h2>

<table>
	<tr><td>szgoogle_gplus_get_contact_page()</td><td>Reperimento del campo profilo per google+ pagina.</td></tr>
	<tr><td>szgoogle_gplus_get_contact_community()</td><td>Reperimento del campo profilo per google+ community</td></tr>
	<tr><td>szgoogle_gplus_get_contact_betspost()</td><td>Reperimento del campo profilo per google+ best post.</td></tr>
</table>

<h2>Esempio codice PHP</h2>

<p>Se volete utilizzare le funzioni PHP messe a disposizione dal plugin dovete accertarvi che il modulo corrispondente sia attivo, una 
volta verificato inserite nel punto desiderato del vostro tema un codice simile al seguente esempio, quindi preparate un array con le
opzioni desiderate e richiamate la funzione richiesta. É consigliabile utilizzare prima della funzione il controllo se questa esista,
in questa maniera non si avranno errori PHP in caso di plugin disattivato o disinstallato.</p> 

<pre>
echo '&lt;div id="author"&gt;';

echo '&lt;div class="image"&gt;';
echo '&lt;img src="http://domain.com/image.jpg" alt="author"/&gt;';
echo '&lt;/div&gt;';'

if (function_exists('szgoogle_gplus_get_contact_page')) {
  echo '&lt;div class="link"&gt;';
  echo '&lt;a href="'.szgoogle_gplus_get_contact_page().'"&gt;My G+ Page&lt;/a&gt;';
  echo '&lt;/div&gt;';'
} 

echo '&lt;/div&gt;';
</pre>

<h2>Avvertenze</h2>

<p>Il plugin <b>SZ-Google</b> è stato sviluppato con una tecnica di caricamento moduli singoli per ottimizzare le performance generali, quindi prima di 
utilizzare uno shortcode, un widget o una funzione PHP bisogna controllare che il modulo generale e l'opzione specifica risulti 
attivata tramite il campo opzione dedicato che trovate nel pannello di amministrazione.</p>

EOD;

/**
 * Richiamo della funzione per la creazione della pagina di 
 * documentazione standard in base al contenuto della variabile HTML
 */
$this->moduleCommonFormHelp(__('google+ author & publisher','szgoogleadmin'),NULL,NULL,false,$HTML,basename(__FILE__));