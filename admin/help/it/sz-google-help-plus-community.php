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
$IMAGE1 = plugin_dir_url(SZ_PLUGIN_GOOGLE_MAIN).'admin/files/images/others/sz-google-plus-badge-community.jpg';

/**
 * Definizione variabile HTML per la preparazione della stringa
 * che contiene la documentazione di questa funzionalità
 */
$HTML = <<<EOD

<h2>Descrizione</h2>

<p>Se hai una community su Google+ e vuoi inserirla sul tuo sito web allora questo è lo strumento adatto. Il badge della community
può essere inserito in differenti metodi in base all'ambiente specifico, se ad esempio lo desideri inserire dentro un'articolo o 
nel contenuto di un qualsiasi post devi utilizzare lo shortcode messo a disposizione <b>[sz-gplus-community]</b>, se invece desideri
utilizzarlo in una sidebar allora devi utilizzare il widget sviluppato per questa funzione che trovi nel menu aspetto -> widgets. 
Per i più esigenti esiste anche un'altra possibilità che permette l'inserimento del badge in qualsiasi parte del tema, infatti basta
utilizzare una funzione PHP messa a disposizione dal plugin stesso e chiamata <b>szgoogle_gplus_get_badge_community(\$options)</b>.</p>

<h2>Personalizzazione</h2>

<p>A prescindere dalla forma che utilizzerete, il componente potrà essere personalizzato in diverse maniere, basterà usare i parametri
messi a disposizione elencati nella tabella a seguire. Per quanto riguarda il widget i parametri vengono richiesti
direttamente dall'interfaccia grafica, mentre se utilizzate lo shortcode o la funzione PHP dovete specificarli manualmente nel 
formato opzione="valore". Se volete avere delle informazioni aggiuntive potete visitare la pagina ufficiale
<a target="_blank" href="https://developers.google.com/+/web/badge/?hl=it">Google+ Badge</a>.</p>

<h2>Parametri e opzioni</h2>

<table
	<tr><th>Parametro</th> <th>Descrizione</th>   <th>Valori ammessi</th>         <th>Default</th></tr>
	<tr><td>id</td>        <td>community</td>     <td>stringa</td>                <td>configurazione</td></tr>
	<tr><td>width</td>     <td>larghezza</td>     <td>integer,auto</td>           <td>configurazione</td></tr>
	<tr><td>align</td>     <td>allineamento</td>  <td>left,center,right,none</td> <td>none</td></tr>
	<tr><td>layout</td>    <td>layout</td>        <td>portrait,landscape</td>     <td>portrait</td></tr>
	<tr><td>theme</td>     <td>tema</td>          <td>light,dark</td>             <td>light</td></tr>
	<tr><td>photo</td>     <td>fotografia</td>    <td>true,false</td>             <td>true</td></tr>
	<tr><td>owner</td>     <td>proprietari</td>   <td>true,false</td>             <td>false</td></tr>
</table>

<h2>Esempio shortcode</h2>

<p>Gli shortcode sono delle macro che vengono inserite nei post per richiede alcune elaborazioni aggiuntive che sono state messe a 
disposizione dai plugin, dai temi o direttamente dal core. Anche il plugin <b>SZ-Google</b> mette a disposizione parecchi shortcode che
possono esseri utilizzati nella forma classica e con le opzioni di personalizzazione permesse. Per inserire uno shortcode nel nostro 
post dobbiamo utilizzare il codice in questa forma:</p>

<pre>[sz-gplus-community id="109254048492234113886" width="auto"/]</pre>

<h2>Esempio codice PHP</h2>

<p>Se volete utilizzare le funzioni PHP messe a disposizione dal plugin dovete accertarvi che il modulo corrispondente sia attivo, una 
volta verificato inserite nel punto desiderato del vostro tema un codice simile al seguente esempio, quindi preparate un array con le
opzioni desiderate e richiamate la funzione richiesta. É consigliabile utilizzare prima della funzione il controllo se questa esista,
in questa maniera non si avranno errori PHP in caso di plugin disattivato o disinstallato.</p> 

<pre>
\$options = array(
  'id'     => '109254048492234113886',
  'width'  => 'auto',
  'theme'  => 'dark',
  'layout' => 'portrait'
);

if (function_exists('szgoogle_gplus_get_badge_community')) {
  echo szgoogle_gplus_get_badge_community(\$options);
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
 * Richiamo della funzione per la creazione della pagina di 
 * documentazione standard in base al contenuto della variabile HTML
 */
$this->moduleCommonFormHelp(__('google+ badge community','szgoogleadmin'),NULL,NULL,false,$HTML,basename(__FILE__));