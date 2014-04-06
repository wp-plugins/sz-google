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
$IMAGE1 = SZ_PLUGIN_GOOGLE_PATH_ADMIN_IMAGES.'others/sz-google-calendar.jpg';

/**
 * Definizione variabile HTML per la preparazione della stringa
 * che contiene la documentazione di questa funzionalità
 */
$HTML = <<<EOD

<h2>Descrizione</h2>

<p>Tramite questa funzione è possibile inserire in embed sul proprio sito il calendario di google. Potete specificare anche diversi 
calendari, basta specificare nel parametro <b>"calendar"</b> una stringa con il nomi dei calendari separati da una virgola. Se non
viene specificato nessun calendario sarà utilizzato quello memorizzato nella configurazione generale.</p>

<p>Per inserire questo componente dovete usare lo shortcode <b>[sz-calendar]</b>, se invece desiderate utilizzarlo in una sidebar 
allora dovete utilizzare il widget sviluppato per questa funzione che trovate nel menu aspetto -> widgets. Per i più 
esigenti esiste anche un'altra possibilità, infatti basta utilizzare una funzione PHP messa a disposizione dal plugin 
<b>szgoogle_calendar_get_widget(\$options)</b>.</p>

<h2>Personalizzazione</h2>

<p>A prescindere dalla forma che utilizzerete, il componente potrà essere personalizzato in diverse maniere, basterà usare i parametri
messi a disposizione elencati nella tabella a seguire. Per quanto riguarda il widget i parametri vengono richiesti
direttamente dall'interfaccia grafica, mentre se utilizzate lo shortcode o la funzione PHP dovete specificarli manualmente nel 
formato opzione="valore". Se volete avere delle informazioni aggiuntive potete visitare la pagina ufficiale
<a target="_blank" href="https://www.google.com/calendar/embedhelper">Google Embeddable Calendar Helper</a>.</p>

<h2>Parametri e opzioni</h2>

<table>
	<tr><th>Parametro</th>     <th>Descrizione</th>            <th>Valori ammessi</th>    <th>Default</th></tr>
	<tr><td>calendar</td>      <td>calendario</td>             <td>stringa</td>           <td>configurazione</td></tr>
	<tr><td>title</td>         <td>titolo</td>                 <td>stringa</td>           <td>configurazione</td></tr>
	<tr><td>mode</td>          <td>modalità</td>               <td>AGENDA,WEEK,MONTH</td> <td>configurazione</td></tr>
	<tr><td>weekstart</td>     <td>partenza su settimana</td>  <td>1,2,7</td>             <td>configurazione</td></tr>
	<tr><td>language</td>      <td>lingua</td>                 <td>stringa</td>           <td>configurazione</td></tr>
	<tr><td>timezone</td>      <td>zona oraria</td>            <td>stringa</td>           <td>configurazione</td></tr>
	<tr><td>width</td>         <td>larghezza</td>              <td>valore,auto</td>       <td>configurazione</td></tr>
	<tr><td>height</td>        <td>altezza</td>                <td>valore</td>            <td>configurazione</td></tr>
	<tr><td>showtitle</td>     <td>visualizza titolo</td>      <td>yes,no</td>            <td>configurazione</td></tr>
	<tr><td>shownavs</td>      <td>visualizza navigatore</td>  <td>yes,no</td>            <td>configurazione</td></tr>
	<tr><td>showdate</td>      <td>visualizza data</td>        <td>yes,no</td>            <td>configurazione</td></tr>
	<tr><td>showprint</td>     <td>visualizza stampa</td>      <td>yes,no</td>            <td>configurazione</td></tr>
	<tr><td>showcalendars</td> <td>visualizza calendario</td>  <td>yes,no</td>            <td>configurazione</td></tr>
	<tr><td>showtimezone</td>  <td>visualizza zona oraria</td> <td>yes,no</td>            <td>configurazione</td></tr>
</table>

<h2>Esempio shortcode</h2>

<p>Gli shortcode sono delle macro che vengono inserite nei post per richiede alcune elaborazioni aggiuntive che sono state messe a 
disposizione dai plugin, dai temi o direttamente dal core. Anche il plugin <b>SZ-Google</b> mette a disposizione parecchi shortcode che
possono esseri utilizzati nella forma classica e con le opzioni di personalizzazione permesse. Per inserire uno shortcode nel nostro 
post dobbiamo utilizzare il codice in questa forma:</p>

<pre>[sz-calendar showprint="no"/]</pre>

<h2>Esempio codice PHP</h2>

<p>Se volete utilizzare le funzioni PHP messe a disposizione dal plugin dovete accertarvi che il modulo corrispondente sia attivo, una 
volta verificato inserite nel punto desiderato del vostro tema un codice simile al seguente esempio, quindi preparate un array con le
opzioni desiderate e richiamate la funzione richiesta. É consigliabile utilizzare prima della funzione il controllo se questa esista,
in questa maniera non si avranno errori PHP in caso di plugin disattivato o disinstallato.</p> 

<pre>
\$options = array(
  'calendar'  => 'gt0ejukbb55l7xxcl4qi1j62ng@group.calendar.google.com',
  'title'     => 'My Calendar',
  'mode'      => 'AGENDA',
  'showtitle' => 'no',
  'showdate'  => 'no'
);

if (function_exists('szgoogle_calendar_get_widget')) {
  echo szgoogle_calendar_get_widget(\$options);
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
$this->moduleCommonFormHelp(__('widget calendar','szgoogleadmin'),NULL,NULL,false,$HTML,basename(__FILE__));