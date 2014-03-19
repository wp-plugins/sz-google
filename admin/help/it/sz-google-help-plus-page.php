<?php 
/**
 * Controllo se il file viene richiamato direttamente senza
 * essere incluso dalla procedura standard del plugin.
 *
 * @package SZGoogle
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die(); 

$IMAGE1 = SZ_PLUGIN_GOOGLE_PATH_ADMIN_IMAGES.'others/sz-google-plus-badge-page.png';

/**
 * Definizione variabile HTML per la preparazione della stringa
 * che contiene la documentazione di questa funzionalità
 */
$HTML = <<<EOD

<p>Se hai una pagina su Google+ e vuoi inserirla sul tuo sito web o integrarla con il tuo badge publisher allora questo è 
lo strumento adatto. Il badge della pagina può essere inserito in differenti metodi in base all'ambiente specifico, 
se ad esempio lo desideri inserire dentro un'articolo o nel contenuto di un qualsiasi post devi utilizzare lo shortcode
messo a disposizione <b>[sz-gplus-page]</b>, se invece desideri utilizzarlo in una sidebar allora devi utilizzare il
widget sviluppato per questa funzione che trovi nel menu aspetto -> widgets. Per i più esigenti esiste anche un'altra
possibilità che permette l'inserimento del badge in qualsiasi parte del vostro tema, infatti basta utilizzare una
funzione PHP messa a disposizione dal plugin <b>szgoogle_get_gplus_badge_page(\$options)</b>.</p>

<h2>Personalizzazione</h2>

<p>A prescindere dalla forma che utilizzerete, il componente potrà essere personalizzato in diverse maniere, basterà usare i parametri
messi a disposizione elencati nella tabella a seguire. Per quanto riguarda il widget i parametri vengono richiesti
direttamente dall'interfaccia grafica, mentre se utilizzate lo shortcode o la funzione PHP dovete specificarli manualmente nel 
formato opzione="valore". Se volete avere delle informazioni aggiuntive potete visitare la pagina ufficiale
<a target="_blank" href="https://developers.google.com/+/web/badge/?hl=it">Google+ Badge</a>.</p>

<h2>Publisher</h2>

<p>Questo badge può essere usato anche per attivare il <b>publisher</b> e quindi associare un'articolo ad un publisher 
in maniera certificata. Basta utilizzare il parametro id="pagina" e publisher="true" nel badge e inserirlo nelle pagine del sito stesso. 
Ricordarsi che per certificare questa funzione bisogna inserire nella propria pagina Google+ il nome del sito con il proprio dominio.
Una volta eseguiti tutti i passagi necessari potete provare il funzionamento della procedura andando nella pagina 
<a target="_blank" href="http://www.google.com/webmasters/tools/richsnippets">Structured Data Testing Tool</a>.</p>

<h2>Parametri e opzioni</h2>

<table>
	<tr><th>Parametro</th> <th>Descrizione</th>           <th>Valori ammessi</th>         <th>Default</th></tr>
	<tr><td>id</td>        <td>pagina</td>                <td>stringa</td>                <td>configurazione</td></tr>
	<tr><td>type</td>      <td>modalità</td>              <td>standard,popup</td>         <td>standard</td></tr>
	<tr><td>width</td>     <td>larghezza</td>             <td>valore,auto</td>            <td>configurazione</td></tr>
	<tr><td>align</td>     <td>allineamento</td>          <td>left,center,right,none</td> <td>none</td></tr>
	<tr><td>layout</td>    <td>layout</td>                <td>portrait,landscape</td>     <td>portrait</td></tr>
	<tr><td>theme</td>     <td>tema</td>                  <td>light,dark</td>             <td>light</td></tr>
	<tr><td>cover</td>     <td>copertina</td>             <td>true,false</td>             <td>true</td></tr>
	<tr><td>tagline</td>   <td>descrizione</td>           <td>true,false</td>             <td>true</td></tr>
	<tr><td>publisher</td> <td>rel=publisher in HTML</td> <td>true,false</td>             <td>false</td></tr>
	<tr><td>text</td>      <td>pop-up testo</td>          <td>stringa</td>                <td>null</td></tr>
	<tr><td>image</td>     <td>pop-up URL immagine</td>   <td>stringa</td>                <td>null</td></tr>
</table>

<h2>Standard o popup</h2>

<p>Come potete vedere dalla tabella delle opzioni è presente un parametro chiamato <b>type</b> con cui potete scegliere di
visualizzare il badge in maniera standard e quindi disegnare subito il badge nella pagina HTML o richiedere la visualizzazione solo
in modalità popup passando con il cursore sopra un testo o un'immagine. In questo caso dovete specificare i parametri dedicati alla
funzione popup che sono <b>text</b> e <b>image</b>. Funzione molto utile nel caso di citazione di altre pagine google+.</p>

<h2>Esempio shortcode</h2>

<p>Gli shortcode sono delle macro che vengono inserite nei post per richiede alcune elaborazioni aggiuntive che sono state messe a 
disposizione dai plugin, dai temi o direttamente dal core. Anche il plugin <b>SZ-Google</b> mette a disposizione parecchi shortcode che
possono esseri utilizzati nella forma classica e con le opzioni di personalizzazione permesse. Per inserire uno shortcode nel nostro 
post dobbiamo utilizzare il codice in questa forma:</p>

<pre>[sz-gplus-page id="117259631219963935481" type="standard" width="auto"/]</pre>

<h2>Esempio codice PHP</h2>

<p>Se volete utilizzare le funzioni PHP messe a disposizione dal plugin dovete accertarvi che il modulo corrispondente sia attivo, una 
volta verificato inserite nel punto desiderato del vostro tema un codice simile al seguente esempio, quindi preparate un array con le
opzioni desiderate e richiamate la funzione richiesta. É consigliabile utilizzare prima della funzione il controllo se questa esista,
in questa maniera non si avranno errori PHP in caso di plugin disattivato o disinstallato.</p> 

<pre>
\$options = array(
  'id'     => '117259631219963935481',
  'type'   => 'standard',
  'width'  => 'auto',
  'theme'  => 'dark',
  'layout' => 'portrait'
);

if (function_exists('szgoogle_get_gplus_badge_page')) {
  echo szgoogle_get_gplus_badge_page(\$options);
}
</pre>

<h2>Schermata</h2>

<p>In questa immagine potete vedere il componente inserito in un post di wordpress, la dimensione e alcune opzioni legate all'aspetto
possono essere modificate con i parametri di configurazione. La zona più adatta alla pubblicazione di queste informazioni 
sono le sidebar, ma alcune volte può essere utile inserirli in un'articolo per sponsorizzare una determinata risorsa.</p>

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
$prev = array('title'=>__('google+ badge profile'  ,'szgoogleadmin'),'slug'=>'sz-google-help-plus-profile.php');
$next = array('title'=>__('google+ badge community','szgoogleadmin'),'slug'=>'sz-google-help-plus-community.php');

$HTML .= $this->moduleAddHelpNavs($prev,$next);

/**
 * Richiamo della funzione per la creazione della pagina di 
 * documentazione standard in base al contenuto della variabile HTML
 */
$this->moduleCommonForm(__('google+ badge page','szgoogleadmin'),NULL,NULL,false,$HTML);