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
$IMAGE1 = SZ_PLUGIN_GOOGLE_PATH_ADMIN_IMAGES.'others/sz-google-youtube-link.jpg';

/**
 * Definizione variabile HTML per la preparazione della stringa
 * che contiene la documentazione di questa funzionalità
 */
$HTML = <<<EOD

<p>Con questa opzione potete inserire in una pagina web dei link ad un <b>canale youtube</b> in diverse maniere. Ad esempio potete inserire un 
link di testo semplice o un'immagine, un bottone più elaborato o un'intero badge. Tutti i componenti prevedono un parametro o un'azione
per effettuare la sottoscrizione al canale automaticamente o con la presentazione di un pop-up.</p>

<p>Per inserire questi componenti dovete usare gli <b>shortcode</b> disponibili, se invece desiderate utilizzare i componenti in una sidebar 
allora dovete utilizzare i widget specifici che trovate nel menu aspetto -> widgets. Per i più esigenti esiste anche un'altra possibilità, 
infatti basta utilizzare delle funzioni PHP messe a disposizione direttamente dal plugin. 

<h2>Shortcode</h2>

<ul>
<li>[sz-ytlink] - Link di testo semplice.</li>
<li>[sz-ytbutton] - Bottone con sottoscrizione.</li>
<li>[sz-ytbadge] - Badge del canale.</li>
</ul>

<h2>Funzioni PHP</h2>

<ul>
<li>szgoogle_get_youtube_code_link()</li>
<li>szgoogle_get_youtube_code_button()</li>
<li>szgoogle_get_youtube_code_badge()</li>
</ul>

<h2>Personalizzazione</h2>

<p>A prescindere dalla forma che utilizzerete, il componente potrà essere personalizzato in diverse maniere, basterà usare i parametri
messi a disposizione elencati nella tabella a seguire. Per quanto riguarda il widget i parametri vengono richiesti
direttamente dall'interfaccia grafica, mentre se utilizzate lo shortcode o la funzione PHP dovete specificarli manualmente nel 
formato opzione="valore". Se volete avere delle informazioni aggiuntive potete visitare la pagina ufficiale
<a target="_blank" href="https://developers.google.com/youtube/youtube_subscribe_button">YouTube Subscribe Button</a>.</p>

<h2>Parametri e opzioni</h2>

<table>

	<tr><th>LINK</th>         <th>Descrizione</th>          <th>Valori ammessi</th> <th>Default</th></tr>
	<tr><td>channel</td>      <td>nome del canale o ID</td> <td>stringa</td>        <td>configurazione</td></tr>
	<tr><td>subscription</td> <td>sottoscrizione</td>       <td>y=yes,n=no</td>     <td>y=yes</td></tr>
	<tr><td>text</td>         <td>testo per il link</td>    <td>stringa</td>        <td>configurazione</td></tr>

	<tr class="space"><td colspan="4">&nbsp;</td></tr>

	<tr><th>BOTTONE</th>      <th>Descrizione</th>          <th>Valori ammessi</th> <th>Default</th></tr>
	<tr><td>channel</td>      <td>nome del canale o ID</td> <td>stringa</td>        <td>configurazione</td></tr>
	<tr><td>layout</td>       <td>tipo layout</td>          <td>default,full</td>   <td>default</td></tr>
	<tr><td>theme</td>        <td>tema del bottone</td>     <td>default,full</td>   <td>default</td></tr>

	<tr class="space"><td colspan="4">&nbsp;</td></tr>

	<tr><th>BADGE</th>        <th>Descrizione</th>          <th>Valori ammessi</th> <th>Default</th></tr>
	<tr><td>channel</td>      <td>nome del canale o ID</td> <td>stringa</td>        <td>configurazione</td></tr>
	<tr><td>width</td>        <td>dimensione pixel</td>     <td>valore</td>         <td>300</td></tr>
	<tr><td>height</td>       <td>dimensione pixel</td>     <td>valore</td>         <td>150</td></tr>
	<tr><td>widthunit</td>    <td>unità dimensione</td>     <td>px,em,%</td>        <td>px</td></tr>
	<tr><td>heightunit</td>   <td>unità dimensione</td>     <td>px,em,%</td>        <td>px</td></tr>
</table>

<h2>Esempio shortcode</h2>

<p>Gli shortcode sono delle macro che vengono inserite nei post per richiede alcune elaborazioni aggiuntive che sono state messe a 
disposizione dai plugin, dai temi o direttamente dal core. Anche il plugin <b>SZ-Google</b> mette a disposizione parecchi shortcode che
possono esseri utilizzati nella forma classica e con le opzioni di personalizzazione permesse. Per inserire uno shortcode nel nostro 
post dobbiamo utilizzare il codice in questa forma:</p>

<pre>
[sz-ytlink   text="iscriviti al mio canale youtube"/]
[sz-ytbutton layout="full" theme="default"/]
[sz-ytbadge  channel="TuttosuYTChannel" width="100" widthunit="%"/]
</pre>

<h2>Esempio codice PHP</h2>

<p>Se volete utilizzare le funzioni PHP messe a disposizione dal plugin dovete accertarvi che il modulo corrispondente sia attivo, una 
volta verificato inserite nel punto desiderato del vostro tema un codice simile al seguente esempio, quindi preparate un array con le
opzioni desiderate e richiamate la funzione richiesta. É consigliabile utilizzare prima della funzione il controllo se questa esista,
in questa maniera non si avranno errori PHP in caso di plugin disattivato o disinstallato.</p> 

<pre>
\$options = array(
  'channel'   => 'TuttosuYTChannel',
  'width'     => 'yes',
  'widthunit' => '%',
);

if (function_exists('szgoogle_get_youtube_code_badge')) {
  echo szgoogle_get_youtube_code_badge(\$options);
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
$prev = array('title'=>__('youtube playlist'       ,'szgoogleadmin'),'slug'=>'sz-google-help-youtube-playlist.php');
$next = NULL;

$HTML .= $this->moduleAddHelpNavs($prev,$next);

/**
 * Richiamo della funzione per la creazione della pagina di 
 * documentazione standard in base al contenuto della variabile HTML
 */
$this->moduleCommonForm(__('youtube link','szgoogleadmin'),NULL,NULL,false,$HTML);