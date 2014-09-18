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

<p>Tramite questa funzione presente nel plugin <b>SZ-Google</b> è possibile inserire in un post di wordpress o su una sidebar il 
widget dei gruppi presenti su google. Per ottenere ulteriori informazioni sui gruppi leggi la pagina ufficiale su <a target="_blank" href="https://groups.google.com">https://groups.google.com</a>.</p>

<p>Per inserire questo componente dovete usare lo shortcode <b>[sz-ggroups]</b>, se invece desiderate utilizzarlo
in una sidebar allora dovete utilizzare il widget sviluppato per questa funzione che trovate nel menu aspetto -> widgets. Per i più 
esigenti esiste anche un'altra possibilità, infatti basta utilizzare una funzione PHP chiamata 
<b>szgoogle_groups_get_code(\$options)</b>.</p>

<h2>Personalizzazione</h2>

<p>A prescindere dalla forma che utilizzerete, il componente potrà essere personalizzato in diverse maniere, basterà usare i parametri
messi a disposizione elencati nella tabella a seguire. Per quanto riguarda il widget i parametri vengono richiesti
direttamente dall'interfaccia grafica, mentre se utilizzate lo shortcode o la funzione PHP dovete specificarli manualmente nel 
formato opzione="valore". Se volete avere delle informazioni aggiuntive potete visitare la pagina ufficiale
<a target="_blank" href="https://support.google.com/groups/answer/1191206?hl=it">Insert a forum into a webpage</a>.</p>

<h2>Parametri e opzioni</h2>

<table>
	<tr><th>Parametro</th>      <th>Descrizione</th>          <th>Valori ammessi</th> <th>Default</th></tr>
	<tr><td>name</td>           <td>nome del gruppo</td>      <td>stringa</td>        <td>configurazione</td></tr>
	<tr><td>width</td>          <td>larghezza</td>            <td>valore</td>         <td>configurazione</td></tr>
	<tr><td>height</td>         <td>altezza</td>              <td>valore</td>         <td>configurazione</td></tr>
	<tr><td>showsearch</td>     <td>visualizzare ricerca</td> <td>true,false</td>     <td>configurazione</td></tr>
	<tr><td>showtabs</td>       <td>visualizzare tabs</td>    <td>true,false</td>     <td>configurazione</td></tr>
	<tr><td>hideforumtitle</td> <td>nascondi titolo</td>      <td>true,false</td>     <td>configurazione</td></tr>
	<tr><td>hidesubject</td>    <td>nascondi soggetto</td>    <td>true,false</td>     <td>configurazione</td></tr>
	<tr><td>hl</td>             <td>linguaggio</td>           <td>codice lingua</td>  <td>configurazione</td></tr>
</table>

<h2>Esempio shortcode</h2>

<p>Gli shortcode sono delle macro che vengono inserite nei post per richiede alcune elaborazioni aggiuntive che sono state messe a 
disposizione dai plugin, dai temi o direttamente dal core. Anche il plugin <b>SZ-Google</b> mette a disposizione parecchi shortcode che
possono esseri utilizzati nella forma classica e con le opzioni di personalizzazione permesse. Per inserire uno shortcode nel nostro 
post dobbiamo utilizzare il codice in questa forma:</p>

<pre>[sz-ggroups height="1200"/]</pre>

<h2>Esempio codice PHP</h2>

<p>Se volete utilizzare le funzioni PHP messe a disposizione dal plugin dovete accertarvi che il modulo corrispondente sia attivo, una 
volta verificato inserite nel punto desiderato del vostro tema un codice simile al seguente esempio, quindi preparate un array con le
opzioni desiderate e richiamate la funzione richiesta. É consigliabile utilizzare prima della funzione il controllo se questa esista,
in questa maniera non si avranno errori PHP in caso di plugin disattivato o disinstallato.</p> 

<pre>
\$options = array(
  'name'    => 'comp.sys.ibm.as400.misc',
  'height'  => '1200',
  'showtabs'=> 'true',
);

if (function_exists('szgoogle_groups_get_code')) {
  echo szgoogle_groups_get_code(\$options);
}
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
$this->moduleCommonFormHelp(__('google groups','szgoogleadmin'),NULL,NULL,false,$HTML,basename(__FILE__));