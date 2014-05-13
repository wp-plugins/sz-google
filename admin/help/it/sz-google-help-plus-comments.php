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
$IMAGE1 = plugin_dir_url(SZ_PLUGIN_GOOGLE_MAIN).'admin/files/images/others/sz-google-plus-comments.jpg';

/**
 * Definizione variabile HTML per la preparazione della stringa
 * che contiene la documentazione di questa funzionalità
 */
$HTML = <<<EOD

<h2>Descrizione</h2>

<p>Google+ mette a disposizione oltre ai badge e ai bottoni anche un widget per gestire un sistema di commenti completo che
viene collegato con il valore URL di una pagina web. Una volta che il widget viene visualizzato sarà possibile eseguire tutte
le funzioni interattive di un sistema di commenti tradizionale, ovviamente può essere utilizzato solo se l'utente ha effettuato
il login sul social network di google+. Normalmente l'insertimento di questo widget si collega automaticamente alla stringa URL 
della pagina visualizzata, però è possibile cambiare questo comportamento tramite l'opzione url="URL".</p>

<p>Per inserire un widget di commenti dovete usare lo shortcode <b>[sz-gplus-comments]</b>, se invece desiderate utilizzarlo
in una sidebar dovete utilizzare il widget che trovate nel menu aspetto -> widgets. Per i più esigenti esiste anche un'altra 
possibilità, infatti basta utilizzare una funzione PHP messa a disposizione dal plugin <b>szgoogle_gplus_get_comments(\$options)</b>.</p>

<h2>Configurazione commenti</h2>

<p>A differenza di altri componenti, il sistema di commenti di google+ può essere inserito anche automaticamente dal plugin, utilizzando
la posizione standard di wordpress e sostituendo il sistema di commenti standard. Nel menu di configurazione presente sul pannello di 
amministrazione chiamato <b>Google+</b> potete trovare una sezione chiamata <b>"Commenti"</b> dove troverete diverse opzioni che possono 
essere impostate secondo le vostre esigenze. Ad esempio troverete la possibilità di attivare o disattivare questo automatismo, decidere se
sostituire il sistema standard di commenti o aggiungere quello di G+ ad esso, decidere la posizione dei commenti dopo il contenuto del
post o dopo il sistema standard e infine la possibilità di inserire una data di riferimento dopo la quale il sistema di commenti deve
essere attivato e ignorando i post più precedenti. Quest'ultima opzione può essere utile se si vuole tenere un vecchio sistema di commenti
per i post passati e usare quello di google+ per i nuovi partendo da una data precisa.</p>

<h2>Parametri e opzioni</h2>

<table>
	<tr><th>Parametro</th> <th>Descrizione</th>            <th>Valori ammessi</th>          <th>Default</th></tr>
	<tr><td>url</td>       <td>indirizzo URL completo</td> <td>stringa</td>                 <td>post corrente</td></tr>
	<tr><td>width</td>     <td>larghezza fissa</td>        <td>valore,auto</td>             <td>auto</td></tr>
	<tr><td>align</td>     <td>allineamento</td>           <td>left,center,right,none</td>  <td>none</td></tr>
</table>

<h2>Dimensione widget</h2>

<p>Il plugin <b>SZ-Google</b> può inserire il widget dei commenti con una dimensione fissa o utilizzare la tecnica del responsive
design adattandosi automaticamente alla dimensione del contenitore generale. Se volete una dimensione fissa basta che utilizzate il
valore width="larghezza", se invece specificate width="auto" il plugin utilizzerà il metodo responsive.</p>

<h2>Esempio shortcode</h2>

<p>Gli shortcode sono delle macro che vengono inserite nei post per richiede alcune elaborazioni aggiuntive che sono state messe a 
disposizione dai plugin, dai temi o direttamente dal core. Anche il plugin <b>SZ-Google</b> mette a disposizione parecchi shortcode che
possono esseri utilizzati nella forma classica e con le opzioni di personalizzazione permesse. Per inserire uno shortcode nel nostro 
post dobbiamo utilizzare il codice in questa forma:</p>

<pre>[sz-gplus-comments url="http://domain.com/post.html"]</pre>

<h2>Esempio codice PHP</h2>

<p>Se volete utilizzare le funzioni PHP messe a disposizione dal plugin dovete accertarvi che il modulo corrispondente sia attivo, una 
volta verificato inserite nel punto desiderato del vostro tema un codice simile al seguente esempio, quindi preparate un array con le
opzioni desiderate e richiamate la funzione richiesta. É consigliabile utilizzare prima della funzione il controllo se questa esista,
in questa maniera non si avranno errori PHP in caso di plugin disattivato o disinstallato.</p> 

<pre>
\$options = array(
  'url'   => 'http://domain.com/post.html',
  'width' => 'auto',
  'align' => 'center',
);

if (function_exists('szgoogle_gplus_get_comments')) {
  echo szgoogle_gplus_get_comments(\$options);
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
$this->moduleCommonFormHelp(__('google+ widget comments','szgoogleadmin'),NULL,NULL,false,$HTML,basename(__FILE__));